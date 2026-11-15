<?php
declare(strict_types=1);
require __DIR__.'/config/bootstrap.php';
$s=$pdo->query("SELECT setting_key,setting_value FROM settings WHERE setting_key IN ('about_title','about_content')")->fetchAll(PDO::FETCH_KEY_PAIR);
$title=$s['about_title']??'About Paper Cast';$content=$s['about_content']??'Paper Cast is an independent publication for thoughtful stories, ideas, and perspectives.';
render_theme($themeManager,$activeTheme,'about',['aboutTitle'=>$title,'aboutContent'=>$content,'pageTitle'=>$title.' · Paper Cast']);
