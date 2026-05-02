
## Tech Stack

### Backend
- **Framework**: Laravel 12.21
- **Language**: PHP 8.2+
- **Database**: MySQL/PostgreSQL (via Docker)
- **Authentication**: Laravel Sanctum
- **Payment Processing**: Laravel Cashier
- **Testing**: PHPUnit with Mockery
- **API Testing**: Postman collection included

### Search Engine
- **Language**: C++17
- **Data Structure**: Trie (prefix tree) with frequency tracking and LRU recency cache
- **Database Client**: MySQL Connector/C++ (`libmysqlcppconn-dev`)
- **Build System**: CMake ≥ 3.16
- **Integration**: Standalone CLI binary invoked by Laravel via `shell_exec` / `proc_open`

### Frontend
- **Framework**: Vue.js 3.5.18
- **State Management**: Pinia 3.0.3 with persistence
- **Routing**: Vue Router 4.5.1
- **Form Validation**: VeeValidate 4.15.1 + Yup 1.7.1
- **Styling**: TailwindCSS 4.1.13
- **Icons**: Font Awesome 7.0.1
- **HTTP Client**: Axios 1.12.2
- **Build Tool**: Vite 7.0.6

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18
- npm
- Docker & Docker Compose (for containerized development)
- CMake >= 3.16 (for the search engine)
- GCC / Clang with C++17 support — `sudo apt install g++`
- MySQL Connector/C++ — `sudo apt install libmysqlcppconn-dev`

## Getting Started

### Backend Setup

1. Navigate to the backend directory:
   ```bash
   cd backend
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Start Docker services (database, cache, etc.):
   ```bash
   docker compose up -d
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Seed the database (optional):
   ```bash
   php artisan db:seed
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

### Queue Setup

1. Navigate to the backend directory:
   ```bash
   cd backend
   ```

2. Run the following command to start the queue worker:
   ```bash
   php artisan queue:work
   ```

### Stripe Setup

1. Navigate to the backend directory:
   ```bash
   cd backend
   ```

2. Run the following command to start the Stripe webhook listener:
   ```bash
   stripe listen --forward-to http://localhost:8000/api/stripe/webhook
   ```

### Frontend Setup

1. Navigate to the frontend directory:
   ```bash
   cd frontend
   ```

2. Install JavaScript dependencies:
   ```bash
   npm install
   ```

3. Start the development server:
   ```bash
   npm run dev
   ```

The application will be available at `http://localhost:5173`

### Search Engine Setup

1. Navigate to the search engine directory:
   ```bash
   cd search-engine/cpp_engine
   ```

2. Configure credentials in `search-engine/.env` (shares the same database as the backend):
   ```env
   MYSQL_HOST=127.0.0.1
   MYSQL_ROOT=root
   MYSQL_ROOT_PASSWORD=your_password
   MYSQL_DATABASE=restaurant_project
   MYSQL_PORT=3306
   ```

3. Run the engine in docker:
   ```bash
   docker compose up -d
   ```

   This produces two binaries in `build/`:
   - `engine` — the autocomplete binary called by Laravel
   - `benchmark` — standalone Trie-vs-linear-scan performance tool

4. Verify the build:
   ```bash
   ./build/engine "chicken"
   ```

   Expected output:
   ```json
   {"query":"chicken","fuzzy":false,"elapsed_ms":0.03,"count":5,"results":[...]}
   ```

The engine loads all dish names from MySQL on startup. If the database is unavailable it falls back to the bundled `data/dataset.txt` (1000 food phrases).

## Development

### Backend Development

- **Run tests**:
  ```bash
  cd backend
  php artisan test
  ```

- **Code style check**:
  ```bash
  composer run-script lint
  ```

- **Clear caches**:
  ```bash
  php artisan optimize:clear
  ```

### Search Engine Development

- **Single-shot query**:
  ```bash
  cd search-engine/cpp_engine/build
  ./engine "pasta"
  ./engine --fuzzy "pastta"        # fuzzy mode: edit distance ≤ 1
  ./engine --top 10 "chicken"     # return up to 10 results (default 5)
  ```

- **REPL / pipe mode** (persistent process, avoids per-request DB connection):
  ```bash
  ./engine                         # interactive
  echo "pizza" | ./engine          # pipe a single query
  printf "pizza\nchicken\n:stats\n:quit\n" | ./engine
  ```

  REPL special commands: `?<prefix>` for fuzzy, `+<word>` insert, `-<word>` remove, `:stats` word count, `:quit` exit.

- **Run benchmark** (Trie vs linear scan):
  ```bash
  cd search-engine/cpp_engine/build
  ./benchmark ../data/dataset.txt
  ```

### Frontend Development

- **Run linter**:
  ```bash
  cd frontend
  npm run lint
  ```

- **Build for production**:
  ```bash
  npm run build
  ```

- **Preview production build**:
  ```bash
  npm run preview
  ```

## API Documentation

Import the Postman collection located at `backend/Restaurant Project.postman_collection.json` to explore and test the API endpoints.

## Environment Configuration

### Backend (.env)
Configure the following key variables in `backend/.env`:
- Database connection settings
- Application URL
- Mail settings
- Payment gateway credentials (for Cashier)
- Sanctum settings for authentication

### Frontend
Update API endpoints in the frontend configuration to match your backend URL.

## Testing

### Backend Tests
```bash
cd backend
php artisan test
```