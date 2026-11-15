<?php
declare(strict_types=1);
require dirname(__DIR__,2).'/app/bootstrap.php';
if(empty($_SESSION['admin_id'])){http_response_code(403);exit('Admin authentication is not configured yet.');}
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method not allowed.');}
$token=(string)($_POST['_token']??'');
if(empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token)){http_response_code(419);exit('Invalid security token.');}
if(!$themeManager->activate((string)($_POST['theme']??''))){http_response_code(422);exit('Theme unavailable.');}
header('Location: index.php?updated=1'); exit;
