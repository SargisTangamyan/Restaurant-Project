# ── Stage 1: Build ────────────────────────────────────────────────────────────
FROM debian:bookworm AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
        cmake \
        make \
        g++ \
        libmysqlcppconn-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /src
COPY . .

RUN cmake -B build -DCMAKE_BUILD_TYPE=Release \
    && cmake --build build --target engine -j"$(nproc)"

# ── Stage 2: Runtime ──────────────────────────────────────────────────────────
FROM debian:bookworm-slim AS runtime

RUN apt-get update && apt-get install -y --no-install-recommends \
        libmysqlcppconn-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY --from=builder /src/build/engine ./engine
COPY --from=builder /src/data         ./data

EXPOSE 9000

# Path where docker-compose will bind-mount the .env file
ENV SEARCH_ENGINE_ENV=/app/.env

ENTRYPOINT ["./engine"]
CMD        ["--serve"]