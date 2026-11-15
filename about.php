<?php
declare(strict_types=1);
require __DIR__.'/config/bootstrap.php';
$s=$pdo->query("SELECT setting_key,setting_value FROM settings WHERE setting_key IN ('about_title','about_content')")->fetchAll(PDO::FETCH_KEY_PAIR);
$pageTitle=($s['about_title']??'About Paper Cast').' · Paper Cast';require __DIR__.'/includes/header.php'; ?>
<article class="article-detail"><span class="eyebrow">OUR STORY</span><h1><?= e($s['about_title']??'About Paper Cast') ?></h1><div class="article-body"><?= nl2br(e($s['about_content']??'Paper Cast is an independent publication for thoughtful stories, ideas, and perspectives.')) ?></div></article><?php require __DIR__.'/includes/footer.php'; ?>
