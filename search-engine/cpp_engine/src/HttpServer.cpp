#include "HttpServer.h"

#include <sys/socket.h>
#include <netinet/in.h>
#include <unistd.h>

#include <thread>
#include <sstream>
#include <iostream>
#include <map>
#include <cstring>
#include <iomanip>
#include <chrono>

// ─────────────────────────────────────────────
//  URL / query-string helpers
// ─────────────────────────────────────────────
static std::string url_decode(const std::string& s) {
    std::string out;
    out.reserve(s.size());
    for (size_t i = 0; i < s.size(); ++i) {
        if (s[i] == '%' && i + 2 < s.size()) {
            int v = std::stoi(s.substr(i + 1, 2), nullptr, 16);
            out += static_cast<char>(v);
            i += 2;
        } else if (s[i] == '+') {
            out += ' ';
        } else {
            out += s[i];
        }
    }
    return out;
}

static std::map<std::string, std::string> parse_qs(const std::string& qs) {
    std::map<std::string, std::string> params;
    std::istringstream ss(qs);
    std::string token;
    while (std::getline(ss, token, '&')) {
        auto eq = token.find('=');
        if (eq != std::string::npos)
            params[url_decode(token.substr(0, eq))] = url_decode(token.substr(eq + 1));
    }
    return params;
}

// ─────────────────────────────────────────────
//  JSON helpers  (reused from main.cpp style)
// ─────────────────────────────────────────────
static std::string json_escape(const std::string& s) {
    std::string out;
    for (unsigned char c : s) {
        switch (c) {
            case '"':  out += "\\\""; break;
            case '\\': out += "\\\\"; break;
            case '\n': out += "\\n";  break;
            case '\r': out += "\\r";  break;
            case '\t': out += "\\t";  break;
            default:   out += static_cast<char>(c);
        }
    }
    return out;
}

static std::string make_json(const std::string& query,
                             bool fuzzy,
                             const std::vector<Completion>& res,
                             double ms) {
    std::ostringstream o;
    o << std::fixed << std::setprecision(3);
    o << "{\"query\":\""   << json_escape(query) << "\""
      << ",\"fuzzy\":"     << (fuzzy ? "true" : "false")
      << ",\"elapsed_ms\":" << ms
      << ",\"count\":"     << res.size()
      << ",\"results\":[";
    for (size_t i = 0; i < res.size(); ++i) {
        if (i) o << ",";
        o << "{\"id\":"     << res[i].id
          << ",\"word\":\"" << json_escape(res[i].word)
          << "\",\"score\":" << res[i].score << "}";
    }
    o << "]}";
    return o.str();
}

// ─────────────────────────────────────────────
//  HTTP response builder
// ─────────────────────────────────────────────
static std::string http_response(int status,
                                 const std::string& status_text,
                                 const std::string& body) {
    std::ostringstream r;
    r << "HTTP/1.1 " << status << " " << status_text << "\r\n"
      << "Content-Type: application/json\r\n"
      << "Content-Length: " << body.size() << "\r\n"
      << "Access-Control-Allow-Origin: *\r\n"
      << "Connection: close\r\n"
      << "\r\n"
      << body;
    return r.str();
}

// ─────────────────────────────────────────────
//  Constructor
// ─────────────────────────────────────────────
HttpServer::HttpServer(AutocompleteEngine& engine, int port)
    : engine_(engine), port_(port) {}

// ─────────────────────────────────────────────
//  Route dispatcher
// ─────────────────────────────────────────────
std::string HttpServer::route(const std::string& path, const std::string& qs) {
    // GET /health
    if (path == "/health" || path == "/health/") {
        std::lock_guard<std::mutex> lk(engine_mtx_);
        std::string body = "{\"status\":\"ok\",\"words\":" +
                           std::to_string(engine_.word_count()) + "}";
        return http_response(200, "OK", body);
    }

    // GET /search?prefix=...&fuzzy=1&top=5
    if (path == "/search" || path == "/search/") {
        auto params  = parse_qs(qs);
        auto pit     = params.find("prefix");

        if (pit == params.end() || pit->second.empty()) {
            return http_response(400, "Bad Request",
                                 "{\"error\":\"'prefix' parameter is required\"}");
        }

        std::string prefix = pit->second;
        bool fuzzy  = (params.count("fuzzy") && params.at("fuzzy") != "0"
                                             && params.at("fuzzy") != "false");
        int  top    = 5;
        if (params.count("top")) {
            try { top = std::stoi(params.at("top")); } catch (...) {}
            top = std::max(1, std::min(top, 20));
        }

        std::vector<Completion> results;
        double ms = 0.0;
        {
            std::lock_guard<std::mutex> lk(engine_mtx_);
            // Temporarily override top_n isn't exposed, so query uses engine default.
            // fuzzy/normal path:
            auto t0 = std::chrono::high_resolution_clock::now();
            results = fuzzy ? engine_.fuzzy_query(prefix) : engine_.query(prefix);
            auto t1 = std::chrono::high_resolution_clock::now();
            ms = std::chrono::duration<double, std::milli>(t1 - t0).count();
        }

        // Trim to requested top
        if ((int)results.size() > top) results.resize(top);

        return http_response(200, "OK", make_json(prefix, fuzzy, results, ms));
    }

    return http_response(404, "Not Found", "{\"error\":\"Not found\"}");
}

// ─────────────────────────────────────────────
//  Per-connection handler
// ─────────────────────────────────────────────
void HttpServer::handle_client(int fd) {
    // Read until double-CRLF (we only need the request line for GET)
    char buf[4096] = {};
    int  n         = recv(fd, buf, sizeof(buf) - 1, 0);
    if (n <= 0) { close(fd); return; }

    std::string raw(buf, n);

    // Parse request line: "GET /path?qs HTTP/1.1"
    auto line_end = raw.find("\r\n");
    if (line_end == std::string::npos) {
        close(fd);
        return;
    }
    std::string req_line = raw.substr(0, line_end);

    // Extract method, target
    std::istringstream ls(req_line);
    std::string method, target;
    ls >> method >> target;

    if (method != "GET") {
        auto resp = http_response(405, "Method Not Allowed",
                                  "{\"error\":\"Only GET is supported\"}");
        send(fd, resp.c_str(), resp.size(), 0);
        close(fd);
        return;
    }

    // Split path and query string
    std::string path, qs;
    auto qpos = target.find('?');
    if (qpos != std::string::npos) {
        path = target.substr(0, qpos);
        qs   = target.substr(qpos + 1);
    } else {
        path = target;
    }

    std::string resp = route(path, qs);
    send(fd, resp.c_str(), resp.size(), 0);
    close(fd);
}

// ─────────────────────────────────────────────
//  Main server loop
// ─────────────────────────────────────────────
void HttpServer::run() {
    int server_fd = socket(AF_INET, SOCK_STREAM, 0);
    if (server_fd < 0) {
        std::cerr << "[server] socket() failed\n";
        return;
    }

    int opt = 1;
    setsockopt(server_fd, SOL_SOCKET, SO_REUSEADDR, &opt, sizeof(opt));

    sockaddr_in addr{};
    addr.sin_family      = AF_INET;
    addr.sin_addr.s_addr = INADDR_ANY;
    addr.sin_port        = htons(port_);

    if (bind(server_fd, (sockaddr*)&addr, sizeof(addr)) < 0) {
        std::cerr << "[server] bind() failed on port " << port_ << "\n";
        close(server_fd);
        return;
    }

    listen(server_fd, 64);
    std::cerr << "[server] Listening on port " << port_ << "\n";

    while (true) {
        int client_fd = accept(server_fd, nullptr, nullptr);
        if (client_fd < 0) continue;

        std::thread([this, client_fd]() {
            handle_client(client_fd);
        }).detach();
    }
}
