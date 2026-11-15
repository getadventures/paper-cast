<?php
declare(strict_types=1);
require dirname(__DIR__,2).'/config/bootstrap.php';require dirname(__DIR__,2).'/app/admin.php';admin_require($pdo);if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}admin_verify_csrf();$s=$pdo->prepare('DELETE FROM posts WHERE id=?');$s->execute([(int)($_POST['id']??0)]);admin_flash('Article deleted.');header('Location: '.admin_url('posts/'));exit;
