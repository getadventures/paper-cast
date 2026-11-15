<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config/bootstrap.php';
require dirname(__DIR__) . '/app/admin.php';
$admin=admin_require($pdo);
$stats=['posts'=>(int)$pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn(),'published'=>(int)$pdo->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),'drafts'=>(int)$pdo->query("SELECT COUNT(*) FROM posts WHERE status='draft'")->fetchColumn(),'comments'=>(int)$pdo->query("SELECT COUNT(*) FROM comments WHERE status='pending'")->fetchColumn()];
$recent=$pdo->query('SELECT id,title,status,updated_at FROM posts ORDER BY updated_at DESC LIMIT 6')->fetchAll();
admin_header('Overview',$admin);admin_show_flash(); ?>
<section class="stats-grid"><article class="stat-card"><span>All articles</span><strong><?= $stats['posts'] ?></strong></article><article class="stat-card"><span>Published</span><strong><?= $stats['published'] ?></strong></article><article class="stat-card"><span>Drafts</span><strong><?= $stats['drafts'] ?></strong></article><article class="stat-card"><span>Pending comments</span><strong><?= $stats['comments'] ?></strong></article></section>
<section class="content-card"><div class="section-head"><div><h2>Recently updated</h2><p>Your latest editorial work.</p></div><a class="button" href="<?= e(admin_url('posts/edit.php')) ?>">＋ New article</a></div><div class="table-wrap"><table><thead><tr><th>Title</th><th>Status</th><th>Updated</th><th></th></tr></thead><tbody><?php foreach($recent as $post): ?><tr><td><?= e($post['title']) ?></td><td><span class="status <?= e($post['status']) ?>"><?= e(ucfirst($post['status'])) ?></span></td><td><?= e(date('M j, Y',strtotime($post['updated_at']))) ?></td><td><a href="<?= e(admin_url('posts/edit.php?id='.(int)$post['id'])) ?>">Edit</a></td></tr><?php endforeach ?><?php if(!$recent): ?><tr><td colspan="4">No articles yet. Create your first one.</td></tr><?php endif ?></tbody></table></div></section>
<?php admin_footer(); ?>
