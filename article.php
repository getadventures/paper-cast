<?php
declare(strict_types=1);
require __DIR__ . '/config/bootstrap.php';

$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=:slug AND p.status='published' LIMIT 1");
$stmt->execute(['slug' => trim((string) ($_GET['slug'] ?? ''))]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
}
render_theme($themeManager, $activeTheme, 'article', [
    'post' => $post ?: null,
    'pageTitle' => $post['title'] ?? 'Article not found',
]);
