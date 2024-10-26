<?php

namespace lib\src\Controllers;

use lib\Route;

class ControladorController extends Controller
{
    public function index()
    {
        return $this->view(
            'template.dashboard',
            [
                'head' => $this->head('Controlador', 'Contenido de la pagina principal de controlador'), //aqui es donde varia
                'link' => $this->getLinkSrc('link', [
                    constant('URL') . "/backend/plugins/fontawesome-free/css/all.min.css",
                    'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css'
                ]),
                'src' => $this->getLinkSrc('src', [
                    constant('URL') . "/backend/plugins/bootstrap/js/bootstrap.bundle.min.js",
                    'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js',
                    constant('URL') . "/backend/dist/js/adminlte.min.js",
                ]),
                'nav' => $this->getNav('template.nav'),
                'aside' => $this->getNav('template.aside'),
                'title' => 'Area de Controlador',
                'session' => 'Area de Controlador',
                'content' => $this->getNav('backend.content_controller'), //aqui es donde varia siempre
            ]
        );
    }

    public function registro()
    {
        if (!(isset($_POST["controlador"]) && isset($_POST["desarrollo"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }
        $controlador = $_POST["controlador"];
        $desarrollo = $_POST["desarrollo"];

        $contenido = '';
        $ruta = '';
        if ($desarrollo == 1) {
            $ruta = "/../../../App/Controllers/$controlador.php";
            $contenido = "<?php\n\nnamespace App\Controllers;\nuse lib\Route;\nclass $controlador extends Controller{}\n";
        } elseif ($desarrollo == 2) {
            $ruta = "/$controlador.php";
            $contenido = "<?php\n\nnamespace lib\\src\Controllers;\nuse lib\Route;\nclass $controlador extends Controller\n{\n\n}\n";
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Valor de desarrollo no válido."));
            exit();
        }
        $envFilePath = __DIR__ . $ruta;
        // Crea el archivo y escribe el contenido
        if (file_put_contents($envFilePath, $contenido) !== false) {
            $_SESSION['success'] = "Archivo creado exitosamente";
            echo json_encode(array("success" => true));
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(array("success" => false, "sms" => "Error: No se pudo crear el archivo."));
        }
        exit();
    }

    public function listarControlador()
    {
        header('Content-Type: application/json');
        $rutas = [
            2 => __DIR__ . '/',        // backend
            1 => __DIR__ . '/../../../App/Controllers/'     // frontend
        ];
        $desarrollo = isset($_GET['desarrollo']) ? (int)$_GET['desarrollo'] : 1;
        if (!array_key_exists($desarrollo, $rutas)) {
            echo json_encode([]);
            exit();
        }
        $directorio = $rutas[$desarrollo];
        $controladores = [];

        // Escanear la carpeta para obtener los archivos PHP
        if (is_dir($directorio)) {
            $archivos = scandir($directorio);
            foreach ($archivos as $archivo) {
                if (pathinfo($archivo, PATHINFO_EXTENSION) === 'php') {
                    $controlador = pathinfo($archivo, PATHINFO_FILENAME);
                    $controladores[] = ['value' => $controlador, 'text' => $controlador];
                }
            }
        }

        echo json_encode($controladores);
    }

    public function metodo()
    {
        if (!(isset($_POST["desarrollo"]) && isset($_POST["controlador"]) && isset($_POST["metodo"]) && isset($_POST["uri"]) && isset($_POST["tipo"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }
        $rutas = [
            2 => __DIR__ . '/',        // Backend
            1 => __DIR__ . '/../../../App/Controllers/'     // frontend
        ];
        $desarrollo = isset($_POST['desarrollo']) ? (int)$_POST['desarrollo'] : 1;
        if (!array_key_exists($desarrollo, $rutas)) {
            echo json_encode([]);
            exit();
        }
        $archivo = $rutas[$desarrollo] . $_POST['controlador'] . ".php";
        // Leer el contenido del archivo
        $contenido = file_get_contents($archivo);

        $metodo = $_POST['metodo'];
        // Verificar si ya existe la función
        if (strpos($contenido, "public function $metodo()")) {
            echo json_encode(array("success" => false, "sms" => "el metodo ya existe el dicha clase"));
            exit();
        }
        // Eliminar la última llave de cierre
        $contenido = rtrim($contenido); // Elimina espacios en blanco al final
        $contenido = preg_replace('/\}\s*$/', '', $contenido); // Elimina la última '}' y cualquier espacio en blanco

        // Añadir la función y la llave de cierre
        $contenido .= "\n    public function $metodo() {}\n}\n";

        // Escribir el contenido modificado de vuelta al archivo
        if (file_put_contents($archivo, $contenido) === false) {
            echo json_encode(array("success" => false, "sms" => "No se pudo escribir en el archivo: $archivo"));
            exit();
        }
        $routes = [
            2 => __DIR__ . '/../routes/structure.php',  //backend
            1 => __DIR__ . '/../../../routes/web.php'   //frontend
        ];
        $archivo = $routes[$desarrollo];
        $contenido = file_get_contents($archivo);
        $uri = $_POST['uri'];
        $tipo = $_POST['tipo'];
        $controlador = $_POST['controlador'];

        $namespace = $desarrollo === 1 ? "App\Controllers\\" : "lib\src\Controllers\\";
        $useStatement = "use $namespace$controlador;";

        if (strpos($contenido, $useStatement) === false) {
            $lineas = explode("\n", rtrim($contenido));

            // Buscar la posición de 'use lib\Route;'
            $posicion = array_search("use lib\Route;", $lineas);
            array_splice($lineas, $posicion + 1, 0, $useStatement);
            $contenido = implode("\n", $lineas);

            // Escribir el contenido modificado de vuelta al archivo
            if (file_put_contents($archivo, $contenido) === false) {
                echo json_encode(array("success" => false, "sms" => "No se pudo escribir en el archivo: $archivo"));
                exit();
            }
        }

        $contenido = file_get_contents($archivo);
        if (strpos($contenido, "Route::controller(" . $controlador . "::class)") === false) {
            $nuevaEstructura = "\n\nRoute::controller(" . $controlador . "::class)->group(function () {";
            $nuevaEstructura .= "\n\tRoute::" . $tipo . "('" . $uri . "','" . $metodo . "');";
            $nuevaEstructura .= "\n});";

            $lineas = explode("\n", $contenido);
            $contenido = implode("\n", $lineas);
            if (file_put_contents($archivo, $contenido . $nuevaEstructura) === false) {
                echo json_encode(array("success" => false, "sms" => "No se pudo escribir en el archivo: $archivo"));
                exit();
            }
        } else {
            $lineas = explode("\n", rtrim($contenido));
            $posicion = array_search("Route::controller(" . $controlador . "::class)->group(function () {", $lineas);
            $j = 0;
            for ($i = $posicion; $i < count($lineas); $i++) {
                $j++;
                if (trim($lineas[$i + 1]) === '});') {
                    $lin = "\tRoute::" . $tipo . "('" . $uri . "','" . $metodo . "');";
                    // Insertar la nueva línea antes de la última llave de cierre
                    array_splice($lineas, $posicion + $j, 0, $lin);
                    break;
                }
            }
            $contenido = implode("\n", $lineas);
            if (file_put_contents($archivo, $contenido) === false) {
                echo json_encode(array("success" => false, "sms" => "No se pudo escribir en el archivo: $archivo"));
                exit();
            }
        }
        $_SESSION['success'] = "El metodo ha sido registrado";
        echo json_encode(array("success" => true));
        exit();
    }

    public function mostrarMetodo()
    {
        if (!(isset($_POST["desarrollo"]) && isset($_POST["controlador"]) && isset($_POST["metodo"]))) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("success" => false, "sms" => "Error: Datos incompletos."));
            exit();
        }
        $rutas = [
            2 => __DIR__ . '/',        // Backend
            1 => __DIR__ . '/../../../App/Controllers/'     // frontend
        ];
        $desarrollo = isset($_POST['desarrollo']) ? (int)$_POST['desarrollo'] : 1;
        if (!array_key_exists($desarrollo, $rutas)) {
            echo json_encode([]);
            exit();
        }
        $archivo = $rutas[$desarrollo] . $_POST['controlador'] . ".php";
        // Verificar si el archivo existe
        if (!file_exists($archivo)) {
            echo json_encode(array("success" => false, "sms" => "Controlador no encontrado."));
            exit();
        }
        // Leer el contenido del archivo
        $contenido = file_get_contents($archivo);

        $metodo = $_POST['metodo'];

        // Buscar el método de manera más flexible
        $pattern = "/public function\s+$metodo\s*\(/";
        if (!preg_match($pattern, $contenido)) {
            echo json_encode(array("success" => false, "sms" => "No existe el método en el controlador."));
            exit();
        }

        $lineas = explode("\n", ($contenido));
        $datos = '';
        $posicion = -1;

        // Buscar la posición del método de manera más precisa
        foreach ($lineas as $index => $linea) {
            if (preg_match($pattern, $linea)) {
                $posicion = $index;
                break;
            }
        }

        // Comprobar si la posición fue encontrada
        if ($posicion === -1) {
            echo json_encode(array("success" => false, "sms" => "No se pudo encontrar la posición del método."));
            exit();
        }

        // Capturar el contenido del método
        for ($i = $posicion; $i < count($lineas); $i++) {
            $datos .= $lineas[$i] . "\n"; // Concatenar correctamente
            if (trim($lineas[$i]) === '}') {
                break;
            }
        }
        // Convertir saltos de línea en <br>
        $datosFormateados = nl2br(htmlspecialchars($datos));

        echo json_encode(array("success" => true, "sms" => $datosFormateados)); // Cambiar a success true
        exit();
    }
}
