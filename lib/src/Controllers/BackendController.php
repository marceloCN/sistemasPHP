<?php

namespace lib\src\Controllers;

use lib\Route;

class BackendController extends Controller
{

    public function index()
    {
        if (!($_ENV['LOGIN'] && $_ENV['PASSWORD'])) {
            $this->setEnvVar('LOGIN', 'admin');
            $this->setEnvVar('PASSWORD', 'password');
        }

        return $this->view(
            'index',
            [
                'head' => $this->head('Pagina de administracion del sistema web', 'Login de inicio de la pagina principal'),
                'link' => $this->getLinkSrc(),
                'src' => $this->getLinkSrc('src')
            ]
        );
    }

    public function verificar()
    {
        if (!(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["remember"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }
        $login = $_POST["login"];
        $password = $_POST["password"];
        $recordar = $_POST["remember"];
        $response = array("success" => false, 'sms' => 'Credenciales incorrectas.');
        if ($login === $_ENV['LOGIN'] && $password === $_ENV['PASSWORD']) {
            $_SESSION['loged'] = true;
            $_SESSION['remember'] = ($recordar === 'true');
            $response = array("success" => true, 'sms' => 'Credenciales correctas.');
        }
        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    public function dashboard()
    {
        return $this->view(
            'template.dashboard',
            [
                'head' => $this->head('Entorno administrador de Trabajo', 'Contenido de la pagina principal'), //aqui es donde varia
                'link' => $this->getLinkSrc('link', ['https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css']),
                'src' => $this->getLinkSrc('src', [
                    constant('URL') . "/backend/dist/js/adminlte.min.js"
                ]),
                'nav' => $this->getNav('template.nav'),
                'aside' => $this->getNav('template.aside'),
                'title' => 'Area de Trabajo',
                'session' => 'Area de Trabajo',
                'content' => $this->getNav('backend.content_index'), //aqui es donde varia siempre
            ]
        );
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect(Route::route('backend.inicio'));
    }

    public function listar_url()
    {
        var_dump($_SESSION);
        var_dump("DATA ha sido establecida como: " . $_ENV['HOLA']);
        return;
    }
}
