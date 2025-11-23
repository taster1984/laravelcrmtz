# Laravel Feedback Widget

This is a Laravel 12-based feedback widget system with file uploads, customer management, ticketing, and an admin panel.

---

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Running the Project](#running-the-project)
- [Database & Test Data](#database--test-data)
- [Embedding the Widget](#embedding-the-widget)
- [API Endpoints](#api-endpoints)
- [Admin Panel](#admin-panel)
- [Notes](#notes)

---

## Requirements

- PHP 8.4+
- Composer
- Docker & Docker Compose
- MySQL 8+ (via Docker)

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/taster1984/laravelcrmtz.git
cd laravelcrmtz
````

2. Copy `.env.example` to `.env` and configure database:

```bash
cp app/.env.example app/.env
```

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

3. Install PHP dependencies:

```bash
composer install
```

---

## Running the Project

Use Docker Compose:

```bash
docker-compose up --build -d
```

Migrate the database and seed test data:

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

---

## Database & Test Data

Seeders include:

* **Customers:** 5 test customers
* **Tickets:** 10 tickets with random subjects and messages
* **Files:** 10 sample files attached to tickets

Run seeds manually:

```bash
php artisan db:seed
```

---

## Embedding the Widget

Embed the feedback widget via iframe:

```html
<iframe src="http://your-host-name/feedback-widget" width="300" height="900" frameborder="0"></iframe>
```

Widget features:

* Name, Email, Phone (E.164 format)
* Subject & Message
* Multiple file uploads (max 10 files per submission)
* Inline validation errors

---

## API Endpoints

**Base URL:** `/api`

### Create Ticket

```http
POST /api/tickets
Content-Type: multipart/form-data

Form Data:
- name (string, required)
- email (string, required)
- phone (string, required, E.164 format)
- subject (string, required)
- body (string, required)
- files[] (optional, multiple)
```

**Response Example:**

```json
{
  "data": {
    "id": 1,
    "customer_id": 1,
    "subject": "Test ticket",
    "body": "This is a test message",
    "status": "new",
    "created_at": "2025-11-23T18:00:00Z"
  }
}
```

### Tickets Statistics

```http
GET /api/tickets/statistics
```

Response:

```json
{
  "daily": {"new": 5, "in_progress": 2, "processed": 1},
  "weekly": {"new": 20, "in_progress": 10, "processed": 5},
  "monthly": {"new": 50, "in_progress": 30, "processed": 15}
}
```

---

## Admin Panel

**URL Login:** `/login`

Test manager: manager@example.com

Password:password

**URL:** `/admin/tickets`

* Accessible only to users with role `manager`
* Features:

    * List tickets
    * Filter by date, status, email, phone
    * View ticket details with attached files
    * Change ticket status (`new`, `in_progress`, `processed`)

**Logout Form Example:**

```blade
<form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-sm btn-outline-secondary" type="submit">Logout</button>
</form>
```

---

## Notes

* File uploads use [Spatie MediaLibrary](https://spatie.be/docs/laravel-medialibrary/v10/introduction)
* Customers are identified by **email + phone**
* One customer can create **one ticket per day**
* Widget shows validation errors inline
* Admin panel uses Blade with Bootstrap 5

---

**Enjoy your Laravel Feedback Widget!**
