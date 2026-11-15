<?php
declare(strict_types=1);
require dirname(__DIR__,2).'/config/bootstrap.php';require dirname(__DIR__,2).'/app/admin.php';admin_require($pdo);if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}admin_verify_csrf();$status=(string)($_POST['status']??'pending');if(!in_array($status,['pending','approved','spam'],true))$status='pending';$s=$pdo->prepare('UPDATE comments SET status=? WHERE id=?');$s->execute([$status,(int)($_POST['id']??0)]);admin_flash('Comment moderation updated.');header('Location: '.admin_url('comments/'));exit;
