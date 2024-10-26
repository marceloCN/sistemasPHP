<?php

namespace App\Controllers\Middlewares;

use lib\Route;

class AuthMiddleware
{
    public function auth()
    {
        if (!$_SESSION[constant('APP')]['loged']) {
            session_destroy();
            return Route::redirect('inicio');
        }
        return true; // Continuar con la solicitud si está autenticado
    }

    public function estasLogueado()
    {
        if (isset($_SESSION[constant('APP')])) {
            $_SESSION[constant('APP')]['success'] = "Usted ya esta logueado al sistema";
            return Route::redirect('dashboard');
        }
        return true;
    }
}
