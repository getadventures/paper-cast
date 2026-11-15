# Paper Cast

Paper Cast is a PHP + MySQL editorial blog starter. Its public presentation is now separated into switchable themes while the existing Paper Cast visual design remains the default theme.

## Requirements
- PHP 8.1+
- MySQL 5.7+ or MariaDB 10.4+
- Apache (XAMPP supported)
- PDO MySQL and mbstring extensions

## Installation
1. Place the project in your web root, e.g. `htdocs/paper-cast`.
2. Create the `paper_cast` database and import `database/schema.sql`.
3. Copy `config/database.example.php` to `config/database.php` and set your local credentials.
4. Open `http://localhost/paper-cast/`.

## Theme system
- `themes/paper-cast/` preserves the original Paper Cast editorial layout.
- `themes/newspress/` is an alternative newspaper-inspired layout.
- Theme manifests are stored in each theme's `theme.json`.
- The active theme is stored in the `settings` table under `active_theme`.
- Theme views render data supplied by the core; posts and categories remain independent of the active theme.

The theme loader is in `app/ThemeManager.php`. Theme documentation: [help/theme-system.md](help/theme-system.md).

## Current milestone
Implemented: theme discovery, active-theme lookup, theme view loading, two initial theme layouts, and a protected Theme Manager screen.

Not yet implemented: admin login/session management, working admin theme activation UI, post editor, full article search, About Us content editor, comments, likes, media library, and visual theme customizer. The Theme Manager deliberately denies access until admin authentication is implemented; do not remove its access guard on a public server.

## Existing project files
The original `includes/` and `assets/css/style.css` layout are retained and reused by the Paper Cast Original theme.
