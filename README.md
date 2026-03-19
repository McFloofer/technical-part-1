# TechnicalExam — Joshua Ilagan

A Laravel 13+ mini CRM module built for the Ensemble technical assessment.
Implements a Client Management API with full CRUD, validation, repository pattern, and status filtering.

---

## Tech Stack

- **PHP** 8.4+
- **Laravel** 13+
- **Database** SQLite
- **Testing** Postman

---

## Project Setup

### 1. Clone the repository
```bash
git clone https://github.com/McFloofer/technical-part-1.git
cd technical-part-1
```

### 2. Install dependencies
```bash
composer install
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Create the SQLite database file
```bash
touch database/database.sqlite
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Start the development server
```bash
php artisan serve
```

---

## API Endpoints

All endpoints are prefixed with `/api`.

| Method   | Endpoint                      | Description                      |
|----------|-------------------------------|----------------------------------|
| `GET`    | `/api/clients`                | List all clients                 |
| `GET`    | `/api/clients?status=active`  | Filter clients by status (bonus) |
| `POST`   | `/api/clients`                | Create a new client              |
| `GET`    | `/api/clients/{id}`           | Get a single client              |
| `PUT`    | `/api/clients/{id}`           | Update a client                  |
| `DELETE` | `/api/clients/{id}`           | Delete a client                  |
| `POST`   | `/api/clients/store-details`  | Part 1 Q3 — storeClientDetails() |

---

## Example API Calls

### Create a Client
**POST** `/api/clients`
```json
{
    "name": "John Doe",
    "email": "jdoe@example.com",
    "status": "active"
}
```

Response `201`:
```json
{
    "status": "success",
    "client": {
        "id": 1,
        "name": "John Doe",
        "email": "jdoe@example.com",
        "status": "active",
        "created_at": "2026-03-19T09:05:22.000000Z",
        "updated_at": "2026-03-19T09:05:22.000000Z"
    }
}
```

### Duplicate Email Error
**POST** `/api/clients` with an already-used email returns `422`:
```json
{
    "status": "error",
    "message": "Validation failed.",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

---

## Project Structure
```
app/
├── Http/Controllers/ClientController.php   # CRUD + storeClientDetails()
├── Models/Client.php
└── Repositories/ClientRepository.php       # Repository pattern

database/migrations/..._create_clients_table.php
routes/api.php
part1-answers.php                           # Part 1 code snippets (Q1, Q2, Q3)
```

---

## Assumptions

- No authentication was added to API routes to keep local Postman testing straightforward.
- `status` only accepts `active` or `inactive`, enforced at validation and database level.
- `storeClientDetails()` is implemented as a real working route, not just a snippet.

---

## Notes

- Part 1 answers (Questions 1–3) are in `part1-answers.php` at the project root.
- The repository pattern is used for all database operations — the controller never touches Eloquent directly.