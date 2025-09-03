# tryout

This repository contains initial skeletons for the Weduc tweedehands project.

## Structure
- `kassa/` – Slim PHP backend with `/health` and `/api/events` endpoints.
- `wp-plugin/` – WordPress plugin stub for future integrations.

## Usage

To run the Slim app:

```
cd kassa
php -S localhost:8080 -t public
```

Visit `http://localhost:8080/health` or `/api/events` to verify.

