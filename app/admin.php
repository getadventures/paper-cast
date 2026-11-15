<?php
declare(strict_types=1);

function admin_url(string $path = ''): string { return site_url('admin/' . ltrim($path, '/')); }
function admin_csrf_field(): string {
    return '<input type="hidden" name="_token" value="' . e($_SESSION['csrf_token'] ?? '') . '">';
}
function admin_verify_csrf(): void {
    $token = (string)($_POST['_token'] ?? '');
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(419); exit('Invalid security token. Please reload the page.');
    }
}
function admin_require(PDO $pdo): array {
    if (empty($_SESSION['admin_id'])) { header('Location: ' . admin_url('login.php')); exit; }
    $stmt = $pdo->prepare('SELECT id, name, email FROM admins WHERE id = ? LIMIT 1');
    $stmt->execute([(int)$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
    if (!$admin) { unset($_SESSION['admin_id']); header('Location: ' . admin_url('login.php')); exit; }
    return $admin;
}
function admin_header(string $title, array $admin): void { ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($title) ?> · Paper Cast</title><link rel="stylesheet" href="<?= e(site_url('admin/assets/admin.css')) ?>"></head><body class="admin-body"><aside class="sidebar"><a class="admin-brand" href="<?= e(admin_url()) ?>">paper<span>cast</span><i>.</i><small>ADMIN STUDIO</small></a><nav><a href="<?= e(admin_url()) ?>">Overview</a><a href="<?= e(admin_url('posts/')) ?>">Articles</a><a href="<?= e(admin_url('comments/')) ?>">Comments</a><a href="<?= e(admin_url('media/')) ?>">Media library</a><a href="<?= e(admin_url('appearance/')) ?>">Appearance</a><a href="<?= e(admin_url('about.php')) ?>">About page</a><a href="<?= e(site_url()) ?>" target="_blank" rel="noopener">View website ↗</a></nav><div class="sidebar-bottom"><span><?= e($admin['name']) ?></span><form method="post" action="<?= e(admin_url('logout.php')) ?>"><?= admin_csrf_field() ?><button class="logout-button" type="submit">Sign out</button></form></div></aside><main class="admin-main"><header class="admin-top"><div><span class="eyebrow">PAPER CAST CMS</span><h1><?= e($title) ?></h1></div><a class="button secondary" href="<?= e(site_url()) ?>" target="_blank" rel="noopener">View site ↗</a></header>
<?php }
function admin_footer(): void { ?></main></body></html><?php }
function admin_flash(string $message, string $type = 'success'): void { $_SESSION['admin_flash'] = ['message'=>$message,'type'=>$type]; }
function admin_show_flash(): void {
    if (!empty($_SESSION['admin_flash'])) { $f=$_SESSION['admin_flash']; unset($_SESSION['admin_flash']); echo '<div class="notice '.e($f['type']).'">'.e($f['message']).'</div>'; }
}
