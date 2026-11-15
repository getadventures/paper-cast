<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config/bootstrap.php';
$count=(int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$error='';
if($count>0){http_response_code(403);exit('Initial administrator is already configured.');}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $token=(string)($_POST['_token']??'');
    if(empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token)) $error='Invalid security token.';
    else {
        $name=trim((string)($_POST['name']??''));$email=strtolower(trim((string)($_POST['email']??'')));$password=(string)($_POST['password']??'');
        if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<12) $error='Enter a name, valid email, and password with at least 12 characters.';
        else {$stmt=$pdo->prepare('INSERT INTO admins(name,email,password_hash) VALUES(?,?,?)');$stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);session_regenerate_id(true);$_SESSION['admin_id']=(int)$pdo->lastInsertId();header('Location: '.site_url('admin/'));exit;}
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Set up Paper Cast</title><link rel="stylesheet" href="<?= e(site_url('admin/assets/admin.css')) ?>"></head><body class="auth-body"><form class="auth-card" method="post"><a class="admin-brand" href="<?= e(site_url()) ?>">paper<span>cast</span><i>.</i><small>FIRST-TIME SETUP</small></a><h1>Create administrator</h1><p>This page locks automatically after the first administrator is created.</p><?php if($error): ?><div class="notice error"><?= e($error) ?></div><?php endif ?><input type="hidden" name="_token" value="<?= e($_SESSION['csrf_token']) ?>"><label>Your name<input name="name" required maxlength="120"></label><label>Email address<input type="email" name="email" required></label><label>Password <small>(minimum 12 characters)</small><input type="password" name="password" minlength="12" required autocomplete="new-password"></label><button class="button">Create administrator</button></form></body></html>
