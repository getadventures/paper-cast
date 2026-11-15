<?php
declare(strict_types=1);
require dirname(__DIR__).'/config/bootstrap.php';require dirname(__DIR__).'/app/admin.php';$admin=admin_require($pdo);
if($_SERVER['REQUEST_METHOD']==='POST'){admin_verify_csrf();foreach(['about_title','about_content'] as $key){$s=$pdo->prepare('INSERT INTO settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');$s->execute([$key,trim((string)($_POST[$key]??''))]);}admin_flash('About page updated.');header('Location: '.admin_url('about.php'));exit;}
$settings=$pdo->query("SELECT setting_key,setting_value FROM settings WHERE setting_key IN ('about_title','about_content')")->fetchAll(PDO::FETCH_KEY_PAIR);
admin_header('About page',$admin);admin_show_flash(); ?><form class="content-card editor-form" method="post"><?= admin_csrf_field() ?><label>Page title<input name="about_title" value="<?= e($settings['about_title']??'About Paper Cast') ?>" required></label><label>About content<textarea name="about_content" rows="16" required><?= e($settings['about_content']??'Tell readers what Paper Cast is about.') ?></textarea></label><button class="button">Save page</button></form><?php admin_footer(); ?>
