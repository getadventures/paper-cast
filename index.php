<?php
declare(strict_types=1);
require __DIR__ . '/config/bootstrap.php';
$posts = publishedPosts($pdo);
$pageTitle = 'Paper Cast — Stories worth reading';
require __DIR__ . '/includes/header.php';
?>
<section class="hero"><div><span class="eyebrow">THE PAPER CAST JOURNAL</span><h1>Good stories.<br><em>Fresh perspectives.</em></h1><p>A place for thoughtful ideas, useful discoveries, and stories that stay with you.</p></div><div class="hero-mark">PC<span>✳</span></div></section>
<div class="section-heading"><div><span class="eyebrow">THE LATEST</span><h2>Latest stories</h2></div><span class="muted"><?= count($posts) ?> articles</span></div>
<?php if (!$posts): ?><section class="empty-state"><h3>Your publication starts here.</h3><p>No articles have been published yet.</p><a href="help/">Read the Help Center →</a></section><?php else: ?>
<section class="article-grid"><?php foreach ($posts as $post): ?><article class="article-card"><a class="article-image" href="article.php?slug=<?= rawurlencode($post['slug']) ?>"><?php if ($post['cover_image']): ?><img src="<?= e($post['cover_image']) ?>" alt=""><?php else: ?><span class="image-placeholder">PC</span><?php endif; ?></a><div class="meta"><?= e($post['category_name'] ?: 'Journal') ?> · <?= e(date('M j, Y', strtotime($post['published_at'] ?: 'now'))) ?></div><h3><a href="article.php?slug=<?= rawurlencode($post['slug']) ?>"><?= e($post['title']) ?></a></h3><p><?= e($post['excerpt'] ?: excerpt($post['content'])) ?></p><a class="read-more" href="article.php?slug=<?= rawurlencode($post['slug']) ?>">Read story →</a></article><?php endforeach; ?></section><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
