# Contributing to WAXP

Thank you for your interest in contributing to WAXP! This document provides guidelines and instructions for contributing.

## Code of Conduct

Be respectful and constructive in all interactions.

## Getting Started

1. Fork the repository
2. Clone your fork: `git clone https://github.com/YOUR_USERNAME/waxp.git`
3. Create a feature branch: `git checkout -b feature/your-feature-name`
4. Follow the setup instructions in [README.md](README.md)

## Development Workflow

### Making Changes

1. Write clear, descriptive commit messages
2. Follow PSR-12 coding standards for PHP
3. Add tests for new functionality
4. Ensure all tests pass: `php artisan test`

### Code Style

- **PHP**: PSR-12 (enforced by Pint)
- **JavaScript**: ESLint + Prettier configuration
- **Blade Templates**: Use consistent indentation

Run code formatting:
```bash
./vendor/bin/pint          # Fix PHP formatting
npm run format             # Fix JS formatting
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

### Database Migrations

When modifying database schema:

1. Create a new migration: `php artisan make:migration your_migration_name`
2. For central DB: Place in `database/migrations/`
3. For tenant DB: Place in `database/migrations/tenant/`
4. Test against both database types

## Submitting Changes

1. Push your branch to your fork
2. Open a Pull Request with:
   - Clear description of changes
   - Link to related issues (if any)
   - Screenshots for UI changes
   - Test results

### PR Guidelines

- Keep PRs focused on a single feature or fix
- Update documentation as needed
- Add/update tests for changed functionality
- Ensure CI/CD pipeline passes

## Reporting Bugs

Create an issue with:
- Clear description of the problem
- Steps to reproduce
- Expected vs. actual behavior
- Your environment (PHP version, OS, etc.)

## Reporting Security Issues

**Do not** create a public GitHub issue for security vulnerabilities.

Email: security@example.com with:
- Description of the vulnerability
- Steps to reproduce (if possible)
- Potential impact

## Project Structure

- `app/Http/Controllers/` - Request handlers
- `app/Models/` - Database models
- `routes/` - Route definitions
- `database/migrations/` - Central DB migrations
- `database/migrations/tenant/` - Tenant DB migrations
- `resources/views/` - Blade templates
- `tests/` - Test files

## Key Concepts

### Multi-Tenancy
- Central DB: Stores tenants metadata and base users
- Tenant DB: Isolated per-tenant data
- Middleware: `SetTenantFromHost` switches connections based on subdomain

### Authentication
- Session-based via Laravel Breeze
- Email verification required
- Tenant creation via onboarding flow

## Questions?

- Open an issue with your question
- Check existing issues/documentation first
- Join our community discussions

Thanks for contributing! 🎉
