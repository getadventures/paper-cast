<?php
declare(strict_types=1);
require __DIR__ . '/config/bootstrap.php';
$stmt=$pdo->prepare("SELECT p.*,c.name AS category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=:slug AND p.status='published' LIMIT 1");
$stmt->execute(['slug'=>trim((string)($_GET['slug']??''))]);$post=$stmt->fetch();
if(!$post){http_response_code(404);$comments=[];$likeCount=0;$liked=false;}
else{
 $c=$pdo->prepare("SELECT name,body,created_at FROM comments WHERE post_id=? AND status='approved' ORDER BY created_at DESC LIMIT 100");$c->execute([$post['id']]);$comments=$c->fetchAll();
 $l=$pdo->prepare('SELECT COUNT(*) FROM post_likes WHERE post_id=?');$l->execute([$post['id']]);$likeCount=(int)$l->fetchColumn();
 if(empty($_SESSION['like_token']))$_SESSION['like_token']=bin2hex(random_bytes(24));
 $v=$pdo->prepare('SELECT id FROM post_likes WHERE post_id=? AND visitor_hash=?');$v->execute([$post['id'],hash('sha256',$_SESSION['like_token'])]);$liked=(bool)$v->fetchColumn();
}
render_theme($themeManager,$activeTheme,'article',['post'=>$post?:null,'comments'=>$comments,'likeCount'=>$likeCount,'liked'=>$liked,'pageTitle'=>$post['title']??'Article not found']);
