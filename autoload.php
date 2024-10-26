<?php
define('BASE_PATH', __DIR__); // Establece la ruta base como el directorio actual

spl_autoload_register(function ($clase) {
    //echo $clase . '<br>';
    $ruta = BASE_PATH . '/' . str_replace("\\", "/", $clase) . ".php";
    if (file_exists($ruta)) {
        require_once $ruta;
    } else {
        die("No se puede cargar la clase $clase");
    }
});

//require_once '../lib/src/routes/structure.php'; // importando el ruteo de elementos
