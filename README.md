# Symfony Customer Importer API

Hi everyone! This is Angela and I made a simple Symfony backend app that fetches Australian customer data from a public API and exposes it through RESTful endpoints. The goal is to demonstrate clean architecture, reusability, and proper separation of concerns as stated by the Code Challenge requirements.

---

## Features

- Imports 100+ Australian users from https://randomuser.me
- Stores only the required fields in a MySQL database
- Updates existing customers by email if already present
- Exposes two API endpoints:
  - `GET /customers` – list all customers
  - `GET /customers/{id}` – get details for a single customer
- Clean, reusable importer logic
- Configurable through `.env`
- Includes unit tests with mocked API calls

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- MySQL (use XAMPP or Laragon for local setup)
- Symfony CLI (optional but helpful)

---

### Setup Instructions

1. Clone the repository (I made it public)

```bash
git clone https://github.com/angelatenshi/customer-importer.git
cd customer-importer
```

2. Install dependencies

```bash
composer install
```

3. Copy the environment file and adjust as needed:

```bash
cp .env.example .env
```

4. Create the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Import customers:

```bash
php bin/console app:import-customers
```

6. Run the local server:

```bash
symfony serve
```

---

## API Endpoints

### `GET /customers`

Returns a list of customers with:

- `full_name`
- `email`
- `country`

### `GET /customers/{id}`

Returns full customer details:

- `full_name`
- `email`
- `username`
- `gender`
- `country`
- `city`
- `phone`

---

## Testing

Run all tests with:

```bash
php bin/phpunit
```

Tests cover:
- Importer success and failure cases
- Response structure
- Mocked HTTP client (no real API calls)

---

## Notes

- Only required fields are stored in the database
- Passwords are re-hashed using `md5()` as required
- The importer is fully reusable and decoupled from Symfony-specific layers

---

## Author

Angela Villamar
