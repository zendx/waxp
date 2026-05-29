# Security Policy

## Reporting Security Vulnerabilities

If you discover a security vulnerability in WAXP, **please do not** create a public GitHub issue. Instead, email your findings to:

**security@example.com**

Please include:
- Description of the vulnerability
- Steps to reproduce (if applicable)
- Potential impact assessment
- Your contact information

We will acknowledge receipt within 24 hours and provide updates on our investigation.

## Supported Versions

| Version | Supported          |
|---------|------------------- |
| 1.x     | ✅ Yes             |

## Security Best Practices

When deploying WAXP in production:

1. **Environment Variables**
   - Never commit `.env` files
   - Use strong, unique `APP_KEY`
   - Rotate database credentials regularly
   - Use environment-specific configurations

2. **Database**
   - Use strong passwords for database users
   - Restrict database access by IP
   - Enable SSL for database connections
   - Regular backups with encryption

3. **Authentication**
   - Enforce strong password policies
   - Enable email verification
   - Use HTTPS only
   - Implement rate limiting on auth endpoints

4. **Multi-Tenancy**
   - Verify tenant isolation at the middleware level
   - Never trust user input for tenant resolution
   - Regularly audit cross-tenant access attempts
   - Use database-level foreign key constraints

5. **Dependencies**
   - Keep Laravel and all packages updated
   - Run `composer audit` regularly
   - Subscribe to security mailing lists
   - Review dependency updates before upgrading

## Dependencies Security

Critical packages to monitor:
- `laravel/framework` - Core framework
- `laravel/breeze` - Authentication scaffolding
- All vendor packages in `composer.json`

Run regular audits:
```bash
composer audit
npm audit
```

## Deployment Checklist

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY` generated
- [ ] HTTPS/SSL enabled
- [ ] Database passwords changed
- [ ] `.env` file excluded from VCS
- [ ] Vendor directory not exposed
- [ ] Error logging configured
- [ ] Backups automated
- [ ] Monitoring enabled

## Known Vulnerabilities

None currently reported. Check back for updates.
