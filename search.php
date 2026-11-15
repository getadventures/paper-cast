<?php
declare(strict_types=1);
require __DIR__.'/config/bootstrap.php';
$q=trim((string)($_GET['q']??''));$posts=[];
if($q!==''){$s=$pdo->prepare("SELECT p.*,c.name category_name FROM posts p LEFT JOIN categories c ON c.id=p.category_id WHERE p.status='published' AND (p.title LIKE ? OR p.excerpt LIKE ? OR p.content LIKE ?) ORDER BY p.published_at DESC LIMIT 50");$like='%'.$q.'%';$s->execute([$like,$like,$like]);$posts=$s->fetchAll();}
render_theme($themeManager,$activeTheme,'search',['q'=>$q,'posts'=>$posts,'pageTitle'=>'Search articles · Paper Cast']);
