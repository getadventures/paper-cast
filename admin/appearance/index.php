<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/config/bootstrap.php';
if (empty($_SESSION['admin_id'])) {
    http_response_code(403);
    exit('Admin authentication is not configured yet.');
}
$themes = $themeManager->all();
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Theme Manager · Paper Cast</title><link rel="stylesheet" href="<?= e(site_url('admin/assets/admin.css')) ?>"></head><body><main class="panel"><h1>Theme Manager</h1><p>Change the public design without changing posts or categories.</p><div class="themes"><?php foreach ($themes as $theme): ?><article><div class="preview"><?= e(strtoupper(substr($theme['name'], 0, 1))) ?></div><h2><?= e($theme['name']) ?></h2><p><?= e($theme['description'] ?? '') ?></p><?php if (($activeTheme['slug'] ?? '') === $theme['slug']): ?><strong>Active theme</strong><?php else: ?><form method="post" action="save.php"><input type="hidden" name="theme" value="<?= e($theme['slug']) ?>"><input type="hidden" name="_token" value="<?= e($_SESSION['csrf_token'] ?? '') ?>"><button>Activate theme</button></form><?php endif ?></article><?php endforeach ?></div></main></body></html>
