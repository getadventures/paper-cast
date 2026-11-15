<?php
declare(strict_types=1);
require dirname(__DIR__,2).'/config/bootstrap.php';require dirname(__DIR__,2).'/app/admin.php';admin_require($pdo);if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}admin_verify_csrf();
$id=(int)($_POST['id']??0);$title=trim((string)($_POST['title']??''));$content=trim((string)($_POST['content']??''));$excerpt=trim((string)($_POST['excerpt']??''));$slug=strtolower(trim((string)($_POST['slug']??'')));$slug=trim(preg_replace('/[^a-z0-9]+/','-',iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$slug?:$title)?:''),'-');$status=($_POST['status']??'draft')==='published'?'published':'draft';$cat=(int)($_POST['category_id']??0)?:null;$cover=trim((string)($_POST['cover_image']??''));
if($title===''||$content===''){admin_flash('Title and content are required.','error');header('Location: '.admin_url('posts/edit.php'.($id?'?id='.$id:'')));exit;}
if(strlen($title)>200||strlen($slug)>220||strlen($cover)>500){http_response_code(422);exit('One or more fields exceed the allowed length.');}
$check=$pdo->prepare('SELECT id FROM posts WHERE slug=? AND id<>?');$check->execute([$slug,$id]);if($check->fetch())$slug.='-'.bin2hex(random_bytes(3));
if($status==='published'){$pub=$pdo->prepare("UPDATE posts SET published_at=COALESCE(published_at,NOW()) WHERE id=?");if($id)$pub->execute([$id]);}
if($id){$s=$pdo->prepare('UPDATE posts SET category_id=?,title=?,slug=?,excerpt=?,content=?,cover_image=?,status=?,published_at=IF(?="published",COALESCE(published_at,NOW()),published_at) WHERE id=?');$s->execute([$cat,$title,$slug,$excerpt,$content,$cover,$status,$status,$id]);}
else{$s=$pdo->prepare('INSERT INTO posts(category_id,title,slug,excerpt,content,cover_image,status,published_at) VALUES(?,?,?,?,?,?,?,IF(?="published",NOW(),NULL))');$s->execute([$cat,$title,$slug,$excerpt,$content,$cover,$status,$status]);}
admin_flash('Article saved successfully.');header('Location: '.admin_url('posts/'));exit;
