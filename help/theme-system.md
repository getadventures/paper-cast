# Paper Cast Theme System

Paper Cast separates the CMS core from presentation themes. The original editorial design remains the default theme.

## Included themes
- **Paper Cast Original** — reuses the existing shared header, footer, and stylesheet in `includes/` and `assets/css/style.css`.
- **Newspress** — an alternative newspaper-inspired layout with red navigation and a sidebar.

## How it works
1. Each theme lives in its own folder under `themes/`.
2. Each theme has a `theme.json` manifest and view files, including `home.php` and `article.php`.
3. The active theme slug is stored in the `settings` table as `active_theme`.
4. `ThemeManager` validates theme slugs and loads the selected theme view.
5. Posts and categories remain in the shared database when switching themes.

Themes should only render data passed by the core. Keep database queries, authentication, and CMS write operations outside theme files.

## Add a theme
Create a folder under `themes/`, add a valid `theme.json`, and provide the supported view files. Use a lowercase slug containing only letters, numbers, and hyphens.

## Admin status
The Theme Manager screen is protected until admin authentication is implemented. It intentionally returns HTTP 403 without an authenticated admin session. Do not remove this protection to make theme switching public.
