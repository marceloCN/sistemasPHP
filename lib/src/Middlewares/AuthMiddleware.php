<?php

namespace lib\src\Middlewares;

use lib\src\Controllers\Controller;
use lib\Route;

class AuthMiddleware extends Controller
{
    public function auth()
    {
        if (!$_SESSION['loged']) {
            $_SESSION['mensaje'] = "ERROR: VUELVE A INICIAR SESSION";
            return $this->redirect(Route::route('backend.inicio'));
        }
        return true; // Continuar con la solicitud si está autenticado
    }

    public function estasLogueado()
    {

        if (isset($_SESSION['loged'])) {
            $_SESSION['success'] = "Usted ya esta logueado al sistema";
            return $this->redirect(Route::route('backend.dashboard'));
        }
        return true;
    }
}
