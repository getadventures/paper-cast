<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));

$configFile = ROOT_PATH . '/config/config.php';
if (!is_file($configFile)) {
    http_response_code(500);
    exit('Paper Cast is not configured. Copy config/config.example.php to config/config.php.');
}
$config = require $configFile;

require_once ROOT_PATH . '/app/Database.php';
require_once ROOT_PATH . '/app/ThemeManager.php';
require_once ROOT_PATH . '/app/helpers.php';

$pdo = Database::connect($config['database']);
$themeManager = new ThemeManager($pdo, ROOT_PATH . '/themes');
$activeTheme = $themeManager->active();
