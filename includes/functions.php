<?php
declare(strict_types=1);
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function excerpt(string $content, int $length = 150): string {
    $plain = trim(preg_replace('/\s+/', ' ', strip_tags($content)) ?? '');
    return mb_strlen($plain) <= $length ? $plain : mb_substr($plain, 0, $length - 1) . '…';
}
function publishedPosts(PDO $pdo, int $limit = 12): array {
    $limit = max(1, min($limit, 50));
    $query = $pdo->query("SELECT p.*, c.name AS category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.status='published' ORDER BY p.published_at DESC, p.id DESC LIMIT {$limit}");
    return $query->fetchAll();
}
