<?php
if (!$post) {
    $pageTitle = 'Article not found — Paper Cast';
    require dirname(__DIR__, 2) . '/includes/header.php';
    echo '<section class="empty-state"><h1>Story not found</h1><a href="index.php">Back to home</a></section>';
    require dirname(__DIR__, 2) . '/includes/footer.php';
    return;
}
require dirname(__DIR__, 2) . '/includes/header.php';
?>
<article class="article-detail"><a href="index.php">← All stories</a><div class="meta"><?= e($post['category_name'] ?: 'Journal') ?> · <?= e(date('M j, Y', strtotime($post['published_at'] ?: 'now'))) ?></div><h1><?= e($post['title']) ?></h1><?php if ($post['excerpt']): ?><p class="lead"><?= e($post['excerpt']) ?></p><?php endif; ?><?php if ($post['cover_image']): ?><img class="detail-cover" src="<?= e($post['cover_image']) ?>" alt=""><?php endif; ?><div class="article-body"><?= nl2br(e($post['content'])) ?></div></article>
<?php require dirname(__DIR__, 2) . '/includes/footer.php'; ?>
