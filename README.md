
## Tech Stack

### Backend
- **Framework**: Laravel 12.21
- **Language**: PHP 8.2+
- **Database**: MySQL/PostgreSQL (via Docker)
- **Authentication**: Laravel Sanctum
- **Payment Processing**: Laravel Cashier
- **Testing**: PHPUnit with Mockery
- **API Testing**: Postman collection included

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
   docker-compose up -d
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