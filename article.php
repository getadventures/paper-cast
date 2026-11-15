<?php
declare(strict_types=1);
require __DIR__ . '/config/bootstrap.php';
$stmt=$pdo->prepare("SELECT p.*,c.name AS category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=:slug AND p.status='published' LIMIT 1");
$stmt->execute(['slug'=>trim((string)($_GET['slug']??''))]); $post=$stmt->fetch();
if (!$post) { http_response_code(404); $pageTitle='Article not found'; require __DIR__.'/includes/header.php'; echo '<section class="empty-state"><h1>Story not found</h1><a href="index.php">Back to home</a></section>'; require __DIR__.'/includes/footer.php'; exit; }
$pageTitle=$post['title'].' — Paper Cast'; require __DIR__.'/includes/header.php';
?><article class="article-detail"><a href="index.php">← All stories</a><div class="meta"><?= e($post['category_name']?:'Journal') ?> · <?= e(date('M j, Y',strtotime($post['published_at']?:'now'))) ?></div><h1><?= e($post['title']) ?></h1><?php if($post['excerpt']):?><p class="lead"><?= e($post['excerpt']) ?></p><?php endif;?><?php if($post['cover_image']):?><img class="detail-cover" src="<?= e($post['cover_image']) ?>" alt=""><?php endif;?><div class="article-body"><?= nl2br(e($post['content'])) ?></div></article><?php require __DIR__.'/includes/footer.php'; ?>
