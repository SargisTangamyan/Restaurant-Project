#pragma once

#include "search/Autocomplete.h"
#include <string>
#include <mutex>

class HttpServer {
public:
    HttpServer(AutocompleteEngine& engine, int port);
    void run();  // blocks forever

private:
    void handle_client(int fd);
    std::string route(const std::string& path, const std::string& qs);

    AutocompleteEngine& engine_;
    std::mutex          engine_mtx_;
    int                 port_;
};
