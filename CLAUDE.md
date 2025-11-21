# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Proyecto Interactivas** is a full-stack Laravel 12 Library Management System with Blade templating, Tailwind CSS, and Alpine.js. It supports two user roles (Admin and Student) with features including book catalog browsing, loan request management, stock tracking, PDF report generation, and role-based access control.

## Core Technology Stack

- **Backend**: PHP 8.2+ with Laravel 12
- **Frontend**: Blade templates with Tailwind CSS 3 + Alpine.js 3
- **Build Tool**: Vite 7 (with Hot Module Replacement)
- **Database**: SQLite (local), configurable to MySQL/PostgreSQL
- **Authentication**: Laravel Breeze + Laravel Sanctum (API tokens)
- **Testing**: PHPUnit 11
- **PDF Generation**: barryvdh/laravel-dompdf

## Common Development Commands

### Initial Setup
```bash
composer run setup
```
Installs all dependencies, creates `.env`, generates APP_KEY, runs migrations, and builds frontend assets.

### Start Development Server
```bash
composer run dev
```
Runs 4 concurrent processes (PHP server, queue listener, log streaming, Vite dev server) with hot-reload.

### Run Tests
```bash
composer run test
```
Runs PHPUnit suite with config cleared.

### Individual Commands
- `php artisan migrate` - Apply database migrations
- `php artisan seed:class SomeSeeder` - Run specific seeder
- `npm run build` - Production build for CSS/JS assets
- `npm run dev` - Development watch mode for frontend only
- `php artisan tinker` - Interactive PHP shell

## Code Architecture

### Key Directories

| Directory | Purpose |
|-----------|---------|
| **app/Http/Controllers/** | Request handlers separated by feature (Books, Loans, Reports, Auth) and admin vs student concerns |
| **app/Models/** | Eloquent models: User (with role attribute), Book, Loan, Author, Category |
| **resources/views/** | Blade templates organized by feature; layouts in views/layouts/ |
| **routes/web.php** | Web routes (server-rendered pages with Blade) |
| **routes/api.php** | JSON API endpoints (for external integrations, Sanctum-protected) |
| **database/migrations/** | Schema version control |
| **database/seeders/** | Test data generators |
| **config/** | Application configuration; notably database.php, auth.php, sanctum.php |

### Data Model Relationships

- **User** (with `role` attribute: 'admin' or 'student')
  - Has many Loans
  - Optional: authentication scopes (Sanctum)
- **Book**
  - Belongs to Author
  - Belongs to Category
  - Has many Loans (pivot with stock/approval status)
- **Loan**
  - Belongs to User and Book
  - Tracks status, approval date, due date, return date
- **Author** → Has many Books
- **Category** → Has many Books

### Role-Based Access Control

- **Admin**: Manage catalog (books, authors, categories), approve loan requests, view reports, access dashboard
- **Student**: Browse catalog, request loans, view personal loan history

Authorization checks use middleware and gate policies (defined in app/Providers/AuthServiceProvider.php or controller logic).

## Frontend Structure

- **Blade Components**: Reusable Tailwind-styled components in `resources/views/components/`
- **Alpine.js Integration**: Lightweight interactivity in Blade templates (x-data, x-show, etc.)
- **Tailwind Configuration**: `tailwind.config.js` scans views/ and components/ for class names
- **CSS Entry**: `resources/css/app.css` imports Tailwind directives
- **JS Entry**: `resources/js/app.js` (typically empty; Alpine handles most interactions)
- **Vite Hot Reload**: Auto-refreshes browser on CSS/JS/Blade changes during `composer run dev`

## Database Migrations & Seeders

**Migrations** (database/migrations/):
- Create tables: users, authors, categories, books, loans, personal_access_tokens
- Add columns: role to users table

**Seeders** (database/seeders/):
- UserSeeder: Creates admin and test students
- AuthorSeeder, CategorySeeder, BookSeeder: Populate test data
- Run with: `php artisan db:seed` or `php artisan seed:class BookSeeder`

## Key Features Implementation Details

### Book Catalog
- Browse/search books by title, author, category
- Display stock availability
- Controlled via BookController

### Loan Management
- Students request loans → admins approve/reject in AdminController
- Loan status: pending, approved, rejected, returned
- Stock decrements on approval, increments on return
- Due date calculation (configurable in Loan model or controller)

### PDF Reports
- Uses barryvdh/laravel-dompdf
- Reports: library card, overdue books list
- Generated in ReportController

### Queue & Jobs
- Background task: SendLoanReminders command
- Configured in config/queue.php
- Run with: `php artisan queue:listen` (included in `composer run dev`)

## Authentication & API

- **Session-Based**: Traditional Blade routes use Laravel Breeze auth
- **Token-Based**: API endpoints use Laravel Sanctum (personal access tokens in Authorization header)
- **Email Verification**: Built-in; configure mail driver in .env

## Configuration Files to Know

- **.env**: Database, mail, app settings (copy from .env.example)
- **config/app.php**: APP_NAME, APP_KEY, timezone
- **config/database.php**: Database driver (default: sqlite)
- **config/auth.php**: Guards and password reset behavior
- **config/sanctum.php**: API token lifetime and stateful domains
- **config/mail.php**: Email driver (default: log for local dev)
- **tailwind.config.js**: Scans paths for dynamic class safety
- **vite.config.js**: Build entry points and plugin configuration

## Testing

- Test files in `tests/Feature/` and `tests/Unit/`
- Use factories (Database/Factories/UserFactory.php) for test data
- Run: `composer run test`

## Common Development Patterns

### Creating a New Feature
1. Create migration: `php artisan make:migration create_something_table`
2. Create model: `php artisan make:model Something`
3. Create controller: `php artisan make:controller SomethingController`
4. Define routes in routes/web.php or routes/api.php
5. Create Blade templates in resources/views/
6. Run migrations: `php artisan migrate`

### Adding a Role Check
Check `auth()->user()->role === 'admin'` in controllers or use middleware/gates.

### Debugging
- View logs: `php artisan pail` (included in `composer run dev`)
- Interactive shell: `php artisan tinker`
- Query logging: Enable in config/database.php or middleware

## Important Notes

- **SQLite by default**: For production, switch to MySQL/PostgreSQL in .env
- **Email**: Configured to log to console for local dev; update config/mail.php for SMTP
- **API vs Web**: API routes return JSON (api.php), web routes render Blade (web.php)
- **Concurrency**: `composer run dev` uses concurrently to manage 4 processes; CTRL+C stops all
- **Migrations**: Always use migrations; never hand-edit schema
- **Hot Reload**: Vite auto-compiles; Blade changes require page refresh (not hot)
