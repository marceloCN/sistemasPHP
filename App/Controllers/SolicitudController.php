<?php

namespace App\Controllers;

use lib\Route; //para poder llamar las rutas con los nombres
use App\Models\Usuarios;
use App\Models\Validacion;

class SolicitudController extends Controller
{
    public function recepcionada()
    {
        return Route::view(
            'templates.dashboard',
            [
                'head' => $this->head('Solicitud recepcionada', 'Contenido solicitud de codigos recepcionados para sistemas'), //aqui es donde varia
                'link' => $this->getLinkSrc('link'),
                'src' => $this->getLinkSrc('src'),
                'nav' => $this->getNav('templates.nav'),
                'aside' => $this->getNav('templates.aside'),
                'title' => 'Solicitudes Recepcionadas',
                'session' => 'Solicitud recepcionada',
                'content' => $this->getNav('backend.solicitud_recepcionada'), //aqui es donde varia siempre
                'footer' => $this->getNav('templates.footer')
            ]
        );
    }

    public function no_recepcionada()
    {
        return Route::view(
            'templates.dashboard',
            [
                'head' => $this->head('Solicitud no recepcionada', 'Contenido de solicitud de codigos que no fueron recepcionados a sistemas, pero si tienen algo que ver con el mismo'), //aqui es donde varia
                'link' => $this->getLinkSrc('link'),
                'src' => $this->getLinkSrc('src'),
                'nav' => $this->getNav('templates.nav'),
                'aside' => $this->getNav('templates.aside'),
                'title' => 'Solicitudes No Recepcionadas',
                'session' => 'Solicitud no recepcionada',
                'content' => $this->getNav('backend.solicitud_no_recepcionada'), //aqui es donde varia siempre
                'footer' => $this->getNav('templates.footer')
            ]
        );
    }

    public function personal_por_direccion($id)
    {
        // Aquí iría tu lógica para obtener los usuarios
        $usuarios = new Usuarios();
        $usuarios = $usuarios->select(['id', 'nombres'], ['id_direccion' => $id, "estado" => 'AC'], []);

        // Prepara la respuesta
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $usuarios]);
        exit();
    }

    public function responder_solicitud()
    {
        if (!(isset($_POST["nota"]) && isset($_POST["estado_tramite"]) && isset($_POST["codigo"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }

        $codigo = $_POST["codigo"];
        $fecha = date("Y-m-d H:i:s");
        $id_direccion_derivacion = $id_personal_revision = null; // Inicializa como null

        // Asigna los valores solo si no están vacíos
        if (isset($_POST["direccion_destino"]) && $_POST["direccion_destino"] !== "") {
            $id_direccion_derivacion = (int)$_POST["direccion_destino"];
        }

        if (isset($_POST["personal_destino"]) && $_POST["personal_destino"] !== "") {
            $id_personal_revision = (int)$_POST["personal_destino"];
        }

        $observacion = $_POST["nota"];
        $clasificacion = $_POST["estado_tramite"];
        $estado = 'AC';
        $id_usuario_registro_validacion = $_SESSION[constant('APP')]['id_usuario'];
        $id_direccion_registro_validacion = $_SESSION[constant('APP')]['id_direccion'];

        $validacion = new Validacion();
        $validacion = $validacion->insert([
            'codigo' => $codigo,
            'fecha_validacion' => $fecha,
            'id_direccion_derivacion' => $id_direccion_derivacion,
            'id_personal_revision' => $id_personal_revision,
            'observacion' => $observacion,
            'id_clasificacion' => (int)$clasificacion,
            'estado' => $estado,
            'id_usuario_registro_validacion' => (int)$id_usuario_registro_validacion,
            'id_direccion_registro_validacion' => (int)$id_direccion_registro_validacion
        ]);


        $_SESSION[constant('APP')]['success'] = "Solicitud respondida";
        $response = array("success" => true);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
