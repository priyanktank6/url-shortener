# Laravel URL Shortener

## Tech Stack
- Laravel 10
- PHP 8.1+
- MySQL
- Laravel Breeze (Blade)

## Setup Instructions

### 1. Clone Repository
git clone <your-repo-url>
cd url-shortener

### 2. Install Dependencies
composer install
npm install
npm run build

### 3. Environment Setup
cp .env.example .env
php artisan key:generate
Configure my sql in .env

### 4. Run Migrations & Seeders
php artisan migrate --seed

### 5. Run Application
php artisan serve

### 6. Run Tests
cp .env.example .env.testing
php artisan test