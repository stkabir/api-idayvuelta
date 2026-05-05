# Booking API (Ida y Vuelta) — Claude Code Context

## Project Identity

Backend API for a **booking/payment platform** ("Ida y Vuelta"). Laravel monolith with Filament admin panel, API authentication via Sanctum, and OpenPay integration for Mexican payment processing.

---

## Stack

| Layer | Tech |
|---|---|
| Framework | Laravel v12.0 |
| Language | PHP ^8.2 |
| Admin Panel | Filament v3.2 |
| API Auth | Laravel Sanctum v4.0 |
| Payments | OpenPay SDK (dev-master) |
| Media | Spatie Laravel MediaLibrary v11.21 |
| Permissions | Spatie Laravel Permission v7.2 |
| DB Default | SQLite (configurable to MySQL) |
| Frontend Build | Vite |
| Package managers | Composer + pnpm |

---

## Dev Commands

```bash
# Setup (install deps, generate key, migrate)
composer setup

# Dev server + queue + Vite (concurrently)
composer dev

# Run tests
composer test

# Artisan commands
php artisan serve
php artisan queue:listen --tries=1 --timeout=0
php artisan migrate
php artisan db:seed
```

---

## File Structure

```
app/              # Models, Controllers, Filament resources
bootstrap/        # App bootstrap
cofig/            # Laravel config files
database/         # Migrations, seeders, factories
public/           # Web root / Vite build output
resources/        # Views, CSS, JS
routes/           # web.php, api.php, console.php
storage/          # Logs, cache, uploads
tests/            # PHPUnit tests
docker/           # Docker config
.env / .env.example
```

---

## Key Conventions

- **Filament** admin panel auto-upgrades on `post-autoload-dump`.
- **Sanctum** for SPA/API token authentication.
- **OpenPay** credentials configured via `.env` (`OPENPAY_MERCHANT_ID`, `OPENPAY_PRIVATE_KEY`, `OPENPAY_PUBLIC_KEY`).
- **Spatie MediaLibrary** for file attachments (images, documents).
- **Spatie Permission** for role-based access control.
- **Queue** uses database driver; run `php artisan queue:listen` in dev.
- Dockerized — `Dockerfile` and `docker/` config present.
- Uses `npm` / `pnpm` for frontend asset building via Vite.

---

## Environment

Key `.env` variables:

- `DB_CONNECTION=sqlite` (default)
- `QUEUE_CONNECTION=database`
- `SESSION_DRIVER=database`
- `OPENPAY_MODE=sandbox`
- `OPENPAY_MERCHANT_ID`, `OPENPAY_PRIVATE_KEY`, `OPENPAY_PUBLIC_KEY`
