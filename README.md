# WAXP - Multi-Tenant SaaS Platform

> A modern Laravel 11 multi-tenant SaaS application with subdomain-based tenant isolation, product catalog management, and session-based authentication.

## Features

- 🏢 **Multi-Tenancy**: Database-per-tenant architecture with central hub
- 👥 **Authentication**: Session-based auth with Laravel Breeze (email verification included)
- 🌐 **Subdomain Routing**: Automatic tenant resolution from subdomains
- 📦 **Product Management**: Categories, products, and SKU management per tenant
- 🔐 **Security**: Tenant isolation, CSRF protection, secure middleware
- ⚡ **Modern Stack**: Laravel 11, Vite, Tailwind CSS

## Requirements

- PHP >= 8.2
- Composer
- Node.js 16+ (for Vite)
- MySQL/MariaDB or SQLite
- npm or yarn

## Installation

### 1. Clone & Setup

```bash
git clone <repository-url> waxp
cd waxp
composer install
npm install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:

```env
# Central Database (stores tenants & base users)
CENTRAL_DB_HOST=127.0.0.1
CENTRAL_DB_DATABASE=waxp_central
CENTRAL_DB_USERNAME=root
CENTRAL_DB_PASSWORD=yourpassword

# Tenant Database (template for per-tenant databases)
TENANT_DB_HOST=127.0.0.1
TENANT_DB_USERNAME=root
TENANT_DB_PASSWORD=yourpassword

# Base domain for subdomain routing
TENANCY_BASE_DOMAIN=waxp.local
APP_URL=http://waxp.local
SESSION_DOMAIN=.waxp.local
```

### 3. Database Setup

```bash
# Create central database and run migrations
php artisan migrate --database=central

# Seed with sample data (optional)
php artisan db:seed --database=central
```

### 4. DNS/Hosts Configuration

For local development, add to `/etc/hosts` (Linux/Mac) or `C:\Windows\System32\drivers\etc\hosts` (Windows):

```
127.0.0.1 waxp.local
127.0.0.1 *.waxp.local
```

### 5. Run Application

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Build frontend assets
npm run dev
```

Access at: `http://waxp.local`

## Project Structure

```
app/
├── Http/
│   ├── Controllers/          # Request handlers
│   ├── Middleware/           # Tenant routing, auth
│   └── Requests/             # Form validation
├── Models/
│   ├── Tenant.php            # Multi-tenant model
│   └── User.php              # User model with tenant_id
config/
├── database.php              # Central & tenant connections
database/
├── migrations/               # Central database schema
└── migrations/tenant/        # Tenant database schema
routes/
├── web.php                   # Web routes
└── auth.php                  # Auth routes
```

## Authentication Flow

1. **Registration/Login**: Via central domain (`waxp.local`)
2. **Onboarding**: Create tenant with subdomain (e.g., `myshop.waxp.local`)
3. **Tenant Access**: All requests to `*.waxp.local` auto-switch to tenant database
4. **Logout**: Session destroyed, redirect to central domain

## Multi-Tenancy Architecture

### Central Database
- Stores tenant metadata (name, domain, database name)
- Base user records
- Session storage

### Per-Tenant Databases
- Products, categories, SKUs
- Tenant-specific users
- Tenant-specific business data

### Middleware
- `SetTenantFromHost`: Parses subdomain, switches database connection
- `EnsureCentralDomain`: Restricts access to central domain only

## Key Files

- [app/Http/Middleware/SetTenantFromHost.php](app/Http/Middleware/SetTenantFromHost.php) - Tenant resolution
- [app/Models/Tenant.php](app/Models/Tenant.php) - Tenant model
- [config/database.php](config/database.php) - Database configuration
- [routes/web.php](routes/web.php) - Application routes

## Testing

```bash
php artisan test
```

## Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## Security

For security issues, please email security@example.com instead of using the issue tracker.

## License

This project is open-source software licensed under the [MIT license](LICENSE).
