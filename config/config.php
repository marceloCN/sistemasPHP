<?php

$envFilePath = __DIR__ . '/.env';

if (!file_exists($envFilePath)) {
    include_once 'generar_env.php';
    exit;
}

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


//definir la URL
define('URL', $_ENV['URL']);
define('APP', $_ENV['APP']);

define('HOST', $_ENV['HOST']);
define('USER', $_ENV['USER']);
define('PWD', $_ENV['PWD']);
define('CHARSET', $_ENV['CHARSET']);

define('DB1_HOST', $_ENV['DB1_HOST']);
define('DB1_USER', $_ENV['DB1_USER']);
define('DB1_PWD', $_ENV['DB1_PWD']);
define('DB1_CHARSET', $_ENV['DB1_CHARSET']);

define('MAIL_MAILER', $_ENV['MAIL_MAILER']);
define('MAIL_HOST', $_ENV['MAIL_HOST']);
define('MAIL_PORT', $_ENV['MAIL_PORT']);
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME']);
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD']);
define('MAIL_ENCRYPTION', $_ENV['MAIL_ENCRYPTION']);




//conexion por defecto de la base de datos
/*
define('HOST', 'mysql:host=localhost;dbname=marcacion;port=3306;');
define('USER', 'root');
define('PWD', '456123'); //456123
define('CHARSET', 'utf8mb4');
*/