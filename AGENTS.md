# AGENTS.md — Ida y Vuelta Booking API

## Dev Commands

```bash
composer setup    # install + .env + key:generate + migrate + npm install + npm run build
composer dev      # serves on :8000, runs queue:listen, runs vite dev — all concurrently
composer test    # clears config cache then runs phpunit
```

**Single test:** `vendor/bin/phpunit --filter TestName`

## Queue / Jobs

- Queue driver is `database`. Jobs will stall silently if no worker is running.
- Always run: `php artisan queue:listen --tries=1 --timeout=0`
- `composer dev` starts the worker automatically.

## Test Environment

- DB: SQLite in-memory (`:memory:`) — no real database needed.
- Queue: `sync` (synchronous, no worker needed for tests).
- Cache: `array`.
- APP_ENV is set to `testing` in `phpunit.xml`.

## API Structure

- API v1 prefix: `/api/v1/` — controllers live in `App\Http\Controllers\Api\V1\`.
- Backward-compat redirects: `/api/hotels` → `/api/v1/hotels`, same for `tours`, `transfers`, `banners`.
- Auth: Sanctum token auth on protected routes; public routes have no middleware.
- Payments (OpenPay): `/api/payments/config` (public), `/api/payments/webhook` (async confirmations), `/api/payments/process` (auth required).

## Non-Obvious Side Effects

- **Observers** registered in `AppServiceProvider`: `HotelObserver`, `TourObserver`, `TransferObserver`, `BannerObserver`. Model saves trigger observer logic automatically.
- **Filament auto-upgrade**: `post-autoload-dump` runs `php artisan filament:upgrade`. Don't disable this.
- **Docker entrypoint** (`docker/entrypoint.sh`) seeds `SiteConfigSeeder` specifically — not the full database seed. Full seed requires `php artisan db:seed`.

## Environment Variables

Required for OpenPay:
```
OPENPAY_MODE=sandbox           # or "production"
OPENPAY_MERCHANT_ID=
OPENPAY_PRIVATE_KEY=
OPENPAY_PUBLIC_KEY=
OPENPAY_LOCATION=MX
```

DB defaults to SQLite (`DB_CONNECTION=sqlite`). Switch to MySQL via `.env`.

## Key Files

- Routes: `routes/api.php`
- Observers: `app/Observers/`
- API Controllers: `app/Http/Controllers/Api/V1/`
- OpenPay config: `config/openpay.php`
- Test config: `phpunit.xml`
