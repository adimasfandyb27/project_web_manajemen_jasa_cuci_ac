# AGENTS.md — CV. NISRINA JAYA (AC Service Management)

## Stack

- **Laravel 10** + PHP 8.1+, MySQL, Blade, Tailwind CSS 3, Vite, Alpine.js
- Key packages: `spatie/laravel-permission`, `spatie/laravel-activitylog`, `barryvdh/laravel-dompdf`, `yajra/laravel-datatables-oracle`, `laravel/sanctum`
- JS: `cleave.js` (input formatting), `sweetalert2`, `axios`, `alpinejs`

## Quick Start

```bash
composer install
npm install
cp .env.example .env   # edit DB_* credentials
php artisan key:generate
php artisan migrate --seed
npm run dev            # Vite dev server
```

## Commands

| Action | Command |
|---|---|
| Vite dev | `npm run dev` |
| Vite build | `npm run build` |
| Tests | `php artisan test` or `vendor/bin/phpunit` |
| Lint | `./vendor/bin/pint` (Laravel Pint, PSR-12) |
| Seeder | `php artisan db:seed` — runs `RolePermissionSeeder` then `UserSeeder` |

## Architecture

- **Two portals** defined in `routes/web.php`:
  - **Admin** (`/admin/*`) — middleware `auth, role:Owner|Admin|Teknisi`
  - **Customer** (`/customer/*`) — middleware `auth, role:customer`
- Sidebar: **Master Data** (Teknisi, Layanan, Merek/Tipe/Kapasitas AC), **Transaksi** (Customer, Pemesanan, Invoice, Pembayaran), **Laporan**, **Pengaturan**
- Roles: Owner (all perms), Admin (no user/role mgmt), Customer Service (limited), Teknisi (view only)
- Guest routes (login, register, password reset) in `routes/auth.php`
- API routes minimal (`routes/api.php`, no real endpoints yet)
- DB: MySQL, timezone `Asia/Jakarta` (`config/app.php`)
- Soft deletes on `Customer` model

## Domain (AC Service Management)

- **AcBrand** (merek AC) — generates `BRN####` code via `ac_brands::generateKode()`
- **AcType** (tipe AC) — generates `TYP####` code via `ac_types::generateKode()`
- **Customer** — generates `CUS######` code via `Customer::generateKode()`
- **ServiceOrder** — generates `SO[YYYYMMDD]####` code via `ServiceOrder::generateKode()`
- **Invoice** — status `lunas` = paid; `markAsPaid` / `markAsPaidWithProof` endpoints
- **Payment** — requires admin verify/reject; customers submit via `/customer/payments`
- **Technician, Service, AC Brand/Type/Capacity** — CRUD master data
- **Reports** — PDF exports for service-orders, revenue, customers
- **Activity Log** — tracked via spatie/laravel-activitylog on models

## Test Credentials (after seeding)

- Owner: `owner@test.com` / `password123`

## Important Notes

- PHPUnit config (`phpunit.xml`) leaves `DB_CONNECTION` and `DB_DATABASE` for MySQL **commented out** — tests run against real DB by default. Uncomment sqlite lines to use in-memory.
- `permission.php` config is default spatie/laravel-permission v6 (teams off, cache 24h)
- `tailwind.config.js` has a `safelist` for dynamically-used classes
- `.editorconfig`: 4-space indent, LF line endings
- No CI/CD config or Docker setup in repo
