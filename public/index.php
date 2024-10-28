<?php

use lib\Route;

session_start();

date_default_timezone_set('America/La_Paz');

require_once '../config/config.php'; //recarga la configuracion de la base de datos

require_once '../autoload.php';        // importando el autocargador

require_once '../routes/web.php';      // importando el enrutamiento php

// Llamar al método dispatch del enrutador para manejar la solicitud
Route::dispatch();
