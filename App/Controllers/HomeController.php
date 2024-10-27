<?php

namespace App\Controllers;

use lib\Route; //para poder llamar las rutas con los nombres

use App\Models\Usuarios;
use App\Models\Cargos;

class HomeController extends Controller
{
    //para cada view debes ingresar el head, link, y src
    public function index()
    {
        return $this->view('login');
    }

    public function verificar_credencial()
    {
        if (!(isset($_POST["username"]) && isset($_POST["password"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }
        $email = $_POST["username"];
        $password = $_POST["password"];

        $usuario = new Usuarios(); //es el unico que enlaza con otra base de datos
        $resultado = $usuario->select(['*'], ['usuario' => $email, 'clave' => $password, 'id_direccion' => 22, 'estado' => 'AC'], []);

        $response = array("success" => false, 'sms' => 'Credenciales incorrectas.');


        // Verifica si se encontró un resultado
        if (!empty($resultado)) {
            $_SESSION[constant('APP')]['loged'] = true;
            $_SESSION[constant('APP')]['id_usuario'] = $resultado['id'];
            $_SESSION[constant('APP')]['id_direccion'] = $resultado['id_direccion'];
            $_SESSION[constant('APP')]['nombre'] = $resultado['nombres'];
            $_SESSION[constant('APP')]['email'] = $resultado['email'];
            $_SESSION[constant('APP')]['telefono'] = $resultado['nro_celular'];
            $_SESSION[constant('APP')]['if_director'] = $resultado['if_director'];
            $cargos = new Cargos();
            $resultado = $cargos->select(['descripcion'], ['id' => $resultado['id_cargo']], []);
            $_SESSION[constant('APP')]['cargo'] = $resultado['descripcion'];

            if (isset($_POST["recordarme"]) && $_POST["recordarme"] === 'on') {
                $this->setRememberMeCookies($email, $password);
            }
            $response = array("success" => true);
        }

        $_SESSION[constant('APP')]['success'] = "Te has logueado";
        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    public function dashboard()
    {
        return $this->view(
            'templates.dashboard',
            [
                'head' => $this->head('Entorno de Trabajo', 'Contenido de la pagina principal'), //aqui es donde varia
                'link' => $this->getLinkSrc('link'),
                'src' => $this->getLinkSrc('src'),
                'nav' => $this->getNav('templates.nav'),
                'aside' => $this->getNav('templates.aside'),
                'title' => 'Area de Trabajo',
                'session' => 'Area de Trabajo',
                'content' => $this->getNav('backend.content_index'), //aqui es donde varia siempre
                'footer' => $this->getNav('templates.footer')
            ]
        );
    }

    public function logout()
    {
        session_destroy();
        return Route::redirect('inicio');
    }
}
