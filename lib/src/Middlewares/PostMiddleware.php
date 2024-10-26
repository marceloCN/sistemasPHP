<?php

namespace lib\src\Middlewares;

use lib\src\Controllers\Controller;

use lib\Route;

class PostMiddleware extends Controller
{
    public function isPost()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(array("success" => false, "sms" => "Error: Método no permitido."));
            exit();
        }
        return true; // Continuar con la solicitud si está autenticado
    }
}
