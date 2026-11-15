# Paper Cast

Paper Cast is a PHP 8.1+ / MySQL editorial CMS with switchable presentation themes. The original Paper Cast design remains the default.

## Installation
1. Copy the project into your Apache web root (XAMPP: `htdocs/paper-cast`).
2. Create/import the database by running `database/schema.sql` in phpMyAdmin.
3. Copy `config/database.example.php` to `config/database.php` and enter your database credentials.
4. Visit `http://localhost/paper-cast/admin/setup.php` and create the first administrator. The setup page locks after the first account is created.
5. Sign in at `/admin/login.php`; public pages are at the site root.

## CMS features
- Admin login, logout, session regeneration, password hashing, and CSRF checks.
- Dashboard and article CRUD with draft/published states, categories, slugs, and cover images.
- Public article search across title, excerpt, and content.
- About Us content editor.
- Comment submission with moderation (comments require approval).
- Like/unlike per browser session token.
- Image upload library (JPEG, PNG, GIF, WebP, 5 MB limit).
- Theme discovery and activation through Appearance.

## Themes
- `themes/paper-cast/` reuses the existing Paper Cast visual design.
- `themes/newspress/` is the alternate newspaper layout.
- Theme files only render data passed by the core. Keep database and security logic outside themes.

## Security and deployment
- Keep `config/database.php` private and never commit real credentials.
- Use HTTPS in production.
- Restrict write permissions to `uploads/`; PHP execution is disabled there by `.htaccess` on Apache.
- `admin/setup.php` returns 403 once an administrator exists.
- This repository update has not been runtime-tested against your local XAMPP/MySQL instance. Import the updated schema before using the new CMS tables.

## Requirements
PHP 8.1+, PDO MySQL, fileinfo, mbstring, MySQL 5.7+ or MariaDB 10.4+, Apache.
