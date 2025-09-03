# tryout

This repository contains initial skeletons for the Weduc tweedehands project.

## Structure
- `kassa/` – Slim PHP backend with `/health` and `/api/events` endpoints.
- `wp-plugin/` – WordPress plugin stub for future integrations.

## Usage

To run the Slim app, run database migrations before starting the server:

```
cd kassa
php bin/migrate.php
```

Then start the server:

```
php -S localhost:8080 -t public
```

Visit `http://localhost:8080/health`, `/api/events`, `/api/sellers` or `/api/books` to verify.

