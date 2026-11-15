<?php
declare(strict_types=1);
require dirname(__DIR__,2).'/config/bootstrap.php';require dirname(__DIR__,2).'/app/admin.php';admin_require($pdo);if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}admin_verify_csrf();
$f=$_FILES['image']??null;if(!$f||$f['error']!==UPLOAD_ERR_OK||$f['size']>5*1024*1024){admin_flash('Upload failed. Choose an image up to 5 MB.','error');header('Location: '.admin_url('media/'));exit;}
$info=@getimagesize($f['tmp_name']);$mime=$info['mime']??'';$extensions=['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];if(!isset($extensions[$mime])){admin_flash('Only JPEG, PNG, GIF, and WebP images are allowed.','error');header('Location: '.admin_url('media/'));exit;}
$dir=dirname(__DIR__,2).'/uploads';if(!is_dir($dir))mkdir($dir,0755,true);$name=bin2hex(random_bytes(16)).'.'.$extensions[$mime];if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name)){admin_flash('Could not save uploaded image.','error');}else{admin_flash('Image uploaded. URL: '.site_url('uploads/'.$name));}header('Location: '.admin_url('media/'));exit;
