<?php
declare(strict_types=1);
require dirname(__DIR__).'/config/bootstrap.php';
if(!empty($_SESSION['admin_id'])){header('Location: '.site_url('admin/'));exit;}
$error='';
$now=time();$attempts=$_SESSION['login_attempts']??['count'=>0,'until'=>0];
if($attempts['until']>$now && $attempts['count']>=5){$error='Too many attempts. Please wait 15 minutes before trying again.';}
elseif($_SERVER['REQUEST_METHOD']==='POST'){
 $token=(string)($_POST['_token']??'');
 if(empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token))$error='Your session expired. Reload and try again.';
 else {
  $stmt=$pdo->prepare('SELECT id,name,password_hash FROM admins WHERE email=? LIMIT 1');$stmt->execute([strtolower(trim((string)($_POST['email']??'')))]);$user=$stmt->fetch();
  if($user&&password_verify((string)($_POST['password']??''),$user['password_hash'])){
   session_regenerate_id(true);$_SESSION['admin_id']=(int)$user['id'];unset($_SESSION['login_attempts']);$_SESSION['csrf_token']=bin2hex(random_bytes(32));header('Location: '.site_url('admin/'));exit;
  }
  $attempts['count']=(int)$attempts['count']+1;
  if($attempts['count']>=5){$attempts=['count'=>5,'until'=>$now+900];}
  $_SESSION['login_attempts']=$attempts;$error='Email or password is incorrect.';
 }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin sign in · Paper Cast</title><link rel="stylesheet" href="<?= e(site_url('admin/assets/admin.css')) ?>"></head><body class="auth-body"><form class="auth-card" method="post"><a class="admin-brand" href="<?= e(site_url()) ?>">paper<span>cast</span><i>.</i><small>ADMIN STUDIO</small></a><h1>Welcome back</h1><p>Sign in to manage your publication.</p><?php if($error): ?><div class="notice error"><?= e($error) ?></div><?php endif ?><input type="hidden" name="_token" value="<?= e($_SESSION['csrf_token']) ?>"><label>Email address<input type="email" name="email" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button class="button" type="submit">Sign in</button><a class="subtle-link" href="<?= e(site_url()) ?>">← Back to website</a></form></body></html>
