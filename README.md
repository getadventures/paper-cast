# Paper Cast

A lightweight PHP + MySQL blog starter with an editorial-style public site and a searchable Help Center.

## Requirements
- PHP 8.1+
- MySQL 5.7+ or MariaDB 10.4+
- Apache (XAMPP supported)
- PHP extensions: PDO MySQL and mbstring

## Installation
1. Put this folder in your web root, e.g. `htdocs/paper-cast`.
2. Create a MySQL database named `paper_cast`.
3. Import `database/schema.sql` using phpMyAdmin or the MySQL CLI. The same file also creates the missing `posts` table when updating an existing database; it does not drop existing tables.
4. Copy `config/database.example.php` to `config/database.php` and set your credentials.
5. Open `http://localhost/paper-cast/`.
6. Open the searchable documentation at `http://localhost/paper-cast/help/`.

## Included
- Editorial-style responsive blog homepage
- Published article detail pages
- Category and post database schema with sample content
- Reusable PHP helpers and PDO connection bootstrap
- Searchable Help Center with installation, configuration, publishing, troubleshooting, and developer topics

## Current development scope
The current starter provides the public reading experience and documentation. An authenticated admin dashboard, post editor, media manager, and role management are not implemented yet and are planned for later development.

## Project structure
- `index.php` — public homepage
- `article.php` — article detail
- `config/` — database bootstrap and local settings example
- `includes/` — shared PHP helpers and layout
- `database/schema.sql` — database schema and sample article
- `assets/` — CSS and JavaScript
- `help/` — searchable documentation

## Security
Never commit real credentials. Keep `config/database.php` private, use HTTPS in production, and configure the web server to deny direct access to configuration and SQL files.

No license has been selected yet.
