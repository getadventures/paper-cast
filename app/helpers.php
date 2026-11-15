<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function site_url(string $path = ''): string
{
    global $config;
    return rtrim($config['app']['base_url'], '/') . '/' . ltrim($path, '/');
}

function render_theme(ThemeManager $manager, array $theme, string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $themeName = $theme['name'] ?? 'Paper Cast';
    require $manager->view($theme, $view);
}
