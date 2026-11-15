<?php
declare(strict_types=1);
function site_url(string $path = ''): string
{
    $script = str_replace('\\\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? '/'));
    $adminPosition = strpos($script, '/admin/');
    $base = $adminPosition !== false ? substr($script, 0, $adminPosition) : dirname($script);
    $base = rtrim($base, '/.');
    return ($base === '' ? '' : $base) . '/' . ltrim($path, '/');
}
function render_theme(ThemeManager $manager, array $theme, string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $themeName = $theme['name'] ?? 'Paper Cast';
    require $manager->view($theme, $view);
}
