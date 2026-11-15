# Paper Cast Admin Guide

## First-time setup
1. Import `database/schema.sql` into MySQL/MariaDB.
2. Copy `config/database.example.php` to `config/database.php` and configure the connection.
3. Open `/admin/setup.php` once to create the first administrator. Use a unique email and a password of at least 12 characters.
4. Sign in at `/admin/login.php`. The setup route becomes unavailable after an administrator exists.

## Publishing an article
Open **Articles → New article**, enter a title and body, optionally choose a category and cover image, then save as Draft or Published. Slugs are generated from the title when left blank.

## Search, About, and reader interaction
- The public Search page searches published article titles, excerpts, and content.
- Edit the About Us page from **About page** in the admin sidebar.
- Reader comments enter the Pending queue. Approve or mark spam from **Comments**.
- Likes are toggled per browser session token; they are not tied to user accounts.

## Media library
Upload JPEG, PNG, GIF, or WebP images up to 5 MB. Copy an image URL into the article cover image field. Apache rules in `uploads/.htaccess` block PHP-family file execution.

## Appearance
Open **Appearance** and activate a discovered theme. Switching themes does not change posts, categories, comments, likes, or About page content.
