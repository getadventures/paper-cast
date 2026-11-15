<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'samesite' => 'Lax',
    ]);
    session_start();
}
$configFile = __DIR__ . '/database.php';
if (!is_file($configFile)) { http_response_code(500); exit('Database configuration missing. Copy config/database.example.php to config/database.php.'); }
$db = require $configFile;
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s',$db['host'],$db['port']??'3306',$db['database'],$db['charset']??'utf8mb4');
try {
 $pdo=new PDO($dsn,$db['username'],$db['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
} catch(PDOException $exception) { error_log($exception->getMessage());http_response_code(500);exit('Database connection failed. Check your database settings.'); }
require_once __DIR__.'/../includes/functions.php';
require_once __DIR__.'/../app/ThemeManager.php';
require_once __DIR__.'/../app/helpers.php';
$themeManager=new ThemeManager($pdo,dirname(__DIR__).'/themes');
$activeTheme=$themeManager->active();
if(empty($_SESSION['csrf_token']))$_SESSION['csrf_token']=bin2hex(random_bytes(32));
