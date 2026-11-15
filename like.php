<?php
declare(strict_types=1);
require __DIR__.'/config/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
$token=(string)($_POST['_token']??'');if(empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token)){http_response_code(419);exit('Invalid security token.');}
$postId=(int)($_POST['post_id']??0);$slug=(string)($_POST['slug']??'');$s=$pdo->prepare("SELECT id FROM posts WHERE id=? AND status='published'");$s->execute([$postId]);if(!$s->fetchColumn()){http_response_code(404);exit('Article not found.');}
if(empty($_SESSION['like_token']))$_SESSION['like_token']=bin2hex(random_bytes(24));$hash=hash('sha256',$_SESSION['like_token']);$del=$pdo->prepare('DELETE FROM post_likes WHERE post_id=? AND visitor_hash=?');$del->execute([$postId,$hash]);if(!$del->rowCount()){$ins=$pdo->prepare('INSERT IGNORE INTO post_likes(post_id,visitor_hash) VALUES(?,?)');$ins->execute([$postId,$hash]);}
header('Location: '.site_url('article.php?slug='.rawurlencode($slug)).'#article-actions');exit;
