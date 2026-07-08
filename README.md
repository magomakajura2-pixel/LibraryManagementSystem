# KMS Community Library — Library Management System

> **Created by KAJURA MAGOMA KAJURA**  
> © 2026 KAJURA MAGOMA KAJURA. All Rights Reserved.

A full-featured Library Management System built with **Laravel 12**, **PostgreSQL**, and **Bootstrap 5**. Designed and developed by **KAJURA MAGOMA KAJURA** as a complete solution for managing books, members, borrowings, returns, fines, and staff.

---

## Tech Stack

| Layer       | Technology                        |
|-------------|-----------------------------------|
| Framework   | Laravel 12 (PHP 8.2)              |
| Database    | PostgreSQL                        |
| Frontend    | Bootstrap 5, Blade Templates      |
| Auth        | Laravel Auth (bcrypt, sessions)   |
| ORM         | Eloquent                          |

---

## Quick Start

```bash
# 1. Clone the repository
git clone <repo-url>
cd LibraryManagementSystem

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
# Edit .env — set DB_DATABASE, DB_USERNAME, DB_PASSWORD (PostgreSQL)

# 4. Generate app key
php artisan key:generate

# 5. Run migrations & seeders
php artisan migrate --seed

# 6. Start the server
php artisan serve
# Open http://127.0.0.1:8000
```

---

## System Features

- **Secure Authentication** — bcrypt hashing, session regeneration, CSRF protection
- **Role-Based Access Control (RBAC)** — Admin / Librarian / Assistant roles
- **Books Management** — Full CRUD with search by title, author, ISBN
- **Members Management** — Registration, profiles, borrowing history
- **Librarians Management** — Admin-only staff management
- **Borrowing & Returns** — Issue books, receive returns, track loan status
- **Automatic Fine Calculation** — Configurable daily rate for overdue loans
- **Reports** — Overdue books, most borrowed, book availability
- **Dashboard Analytics** — Live stats: books, members, active loans, overdue, fines
- **Audit Logging** — Every action recorded with actor and timestamp
- **Pagination** — All listing pages paginated

---

## Project Structure

```
app/
  Http/Controllers/      Laravel controllers (Auth, Dashboard, Books, Members, ...)
  Models/                Eloquent models (User, Book, Member, Borrowing, Librarian, Fine, ...)
  Config/                Custom PDO config (legacy support)
  Services/              Business logic services
config/
  auth.php               Laravel auth guard (Eloquent provider)
  database.php           PostgreSQL connection
database/
  migrations/            Schema migrations
  seeders/               Database seeders
resources/views/         Blade templates (Bootstrap 5 UI)
routes/web.php           Application routes
```

---

## Author

| | |
|---|---|
| **Name** | KAJURA MAGOMA KAJURA |
| **Year** | 2026 |
| **Project** | KMS Community Library Management System |

---

## Default Login Credentials

| Role      | Username   | Password   |
|-----------|------------|------------|
| Admin     | `admin`    | `password` |
| Librarian | `jbrown`   | `password` |
| Assistant | `asmith`   | `password` |

> ⚠️ Change passwords immediately after first login in production.

---

## Folder Structure

```
LibraryManagementSystem/
├── app/
│   ├── Config/
│   │   └── Database.php              # PDO singleton (PostgreSQL)
│   ├── Helpers/
│   │   └── Session.php               # Session helper
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── BookController.php
│   │   │   ├── BorrowingController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LibrarianController.php
│   │   │   ├── MemberController.php
│   │   │   ├── ReportController.php
│   │   │   └── ReturnController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/
│   │   ├── AuditLog.php
│   │   ├── Book.php
│   │   ├── BookReturn.php
│   │   ├── Borrowing.php
│   │   ├── Category.php
│   │   ├── Fine.php
│   │   ├── Librarian.php
│   │   ├── Member.php
│   │   ├── Role.php
│   │   ├── SystemSetting.php
│   │   └── User.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
│       ├── AuthService.php
│       ├── BookService.php
│       └── ReportService.php
├── bootstrap/
│   └── app.php                       # Laravel application bootstrap
├── config/
│   ├── app.php
│   ├── auth.php                      # Laravel guard + Eloquent provider
│   ├── database.php                  # PostgreSQL connection config
│   └── session.php
├── database/
│   ├── migrations/                   # Schema migrations (tables, views, triggers)
│   └── seeders/                      # Database seeders
├── public/
│   └── index.php                     # Application entry point
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── books/
│       ├── borrowings/
│       ├── dashboard/
│       ├── layouts/
│       ├── librarians/
│       ├── members/
│       ├── reports/
│       └── returns/
├── routes/
│   └── web.php                       # All application routes
├── storage/                          # Logs, sessions, cache
├── .env                              # Environment variables (NOT committed)
├── .gitignore
├── CONTRIBUTING.md
├── LICENSE                           # GPL v3
├── README.md
├── SECURITY.md
└── composer.json
```

---

## License

Copyright (C) 2026 **KAJURA MAGOMA KAJURA** — Licensed under **GPL v3**.  
Any use, modification, or distribution **must** credit the original author and release source code under GPL v3.  
See [LICENSE](./LICENSE) for full details.
