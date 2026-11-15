<?php
declare(strict_types=1);

function site_url(string $path = ''): string
{
    $script = str_replace('\\\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/'));
    $base = strpos($script, '/admin/') !== false
        ? dirname($script, 3)
        : dirname($script);
    $base = rtrim($base, '/.');
    return ($base === '' ? '' : $base) . '/' . ltrim($path, '/');
}

/** Render a view from the active theme. CMS queries remain in core controllers. */
function render_theme(ThemeManager $manager, array $theme, string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $themeName = $theme['name'] ?? 'Paper Cast';
    require $manager->view($theme, $view);
}
