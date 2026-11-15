# Paper Cast Theme System

Paper Cast separates the CMS core from its presentation themes.

## Included themes
- **Paper Cast Original**: clean editorial layout.
- **Newspress**: newspaper-inspired layout with red navigation and a sidebar.

## How it works
1. Each theme lives in its own folder under `themes/`.
2. Every theme has a `theme.json` manifest and view files.
3. The active theme slug is stored in the `settings` table.
4. `ThemeManager` validates theme slugs and loads the selected theme.
5. Posts and categories remain in the shared database when switching themes.

Themes should only render data passed by the core. Do not put database writes or CMS business logic in theme files.

## Development note
The appearance screen is protected until admin authentication is implemented. It intentionally returns HTTP 403 without a valid admin session. Do not remove this protection on a public server.
