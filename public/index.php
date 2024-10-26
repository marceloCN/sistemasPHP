<?php

use lib\Route;

session_start();

date_default_timezone_set('America/La_Paz');

$envFilePath = __DIR__ . '/../config/.env';

if (!file_exists($envFilePath)) {
    include_once '../config/generar_env.php';
    exit;
}

require_once '../vendor/autoload.php';

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

require_once '../lib/Database.php';    // importando la base de datos

require_once '../autoload.php';        // importando el autocargador

require_once '../routes/web.php';      // importando el enrutamiento php

// Llamar al método dispatch del enrutador para manejar la solicitud
Route::dispatch();
