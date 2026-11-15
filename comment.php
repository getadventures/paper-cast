<?php
declare(strict_types=1);
require __DIR__.'/config/bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
$token=(string)($_POST['_token']??'');if(empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token)){http_response_code(419);exit('Invalid security token.');}
$postId=(int)($_POST['post_id']??0);$name=trim((string)($_POST['name']??''));$email=trim((string)($_POST['email']??''));$body=trim((string)($_POST['body']??''));
if($name===''||strlen($name)>100||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($body)<3||strlen($body)>3000){$_SESSION['comment_notice']='Please check your name, email, and comment.';header('Location: '.site_url('article.php?slug='.rawurlencode((string)($_POST['slug']??''))).'#comments');exit;}
$check=$pdo->prepare("SELECT id FROM posts WHERE id=? AND status='published'");$check->execute([$postId]);if(!$check->fetchColumn()){http_response_code(404);exit('Article not found.');}
$ins=$pdo->prepare("INSERT INTO comments(post_id,name,email,body,status) VALUES(?,?,?,?, 'pending')");$ins->execute([$postId,$name,$email,$body]);$_SESSION['comment_notice']='Thanks! Your comment is awaiting moderation.';header('Location: '.site_url('article.php?slug='.rawurlencode((string)($_POST['slug']??''))).'#comments');exit;
