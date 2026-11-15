<?php
declare(strict_types=1);
require __DIR__ . '/config/bootstrap.php';

$posts = publishedPosts($pdo);
render_theme($themeManager, $activeTheme, 'home', [
    'posts' => $posts,
    'pageTitle' => 'Paper Cast — Stories worth reading',
]);
