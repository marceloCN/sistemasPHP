<?php

namespace lib\src\Controllers;

use lib\Helpers;
use lib\Route;

//el Helpers es para ayudar a contener las funciones mas fundamentales para el controller
class Controller
{
    function setEnvVar($key, $value)
    {
        $envFile = __DIR__ . '/../../../config/.env';

        if (!file_exists($envFile)) {
            die("Error: El archivo .env no se encuentra en la ruta: $envFile");
        }

        // Lee el contenido del archivo
        $envContent = file_get_contents($envFile);
        if ($envContent === false) {
            die("Error: No se pudo leer el archivo .env.");
        }

        // Si la clave ya existe, reemplázala
        if (strpos($envContent, $key) !== false) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        } else {
            // Si no existe, añádala al final
            $envContent .= "\n{$key}={$value}";
        }

        // Intentar abrir el archivo
        $handle = fopen($envFile, 'w');
        if ($handle === false) {
            die("Error: No se pudo abrir el archivo .env para escritura. Verifica los permisos y la ruta.");
        }

        // Escribir el contenido
        if (fwrite($handle, $envContent) === false) {
            fclose($handle);
            die("Error: No se pudo escribir en el archivo .env.");
        }

        // Cerrar el archivo
        fclose($handle);
        $_ENV[$key] = $value;
        putenv("{$key}={$value}");
    }

    public function redirect($route)
    {
        $location = 'location:' . constant('URL') . $route;
        header($location);
    }

    public function estasLogueado()
    {
        if (!isset($_SESSION[constant('APP')])) {
            return $this->redirect(Route::route('principal'));
        }
        if (!$_SESSION[constant('APP')]['loged']) {
            return $this->redirect(Route::route('principal'));
        }
    }

    public function head($title = 'document', $content = 'nombre del documento', $icon = "/backend/logo.ico")
    {
        $ico = constant('URL') . $icon;
        $head = "
        <meta name='description' content='$content'>
        <title>$title</title>
        <link rel='icon' type='image/x-icon' href='$ico' />
        ";
        return $head;
    }

    public function getLinkSrc($enlace = 'link', $link_script = [])
    {
        // Base stylesheets
        $baseLinks = [
            constant('URL') . "/backend/plugins/fontawesome-free/css/all.min.css",
            constant('URL') . "/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
            constant('URL') . "/backend/dist/css/adminlte.min.css",
        ];

        // Base scripts
        $baseScripts = [
            constant('URL') . "/backend/plugins/jquery/jquery.min.js",
            constant('URL') . '/backend/plugins/sweetalert2/sweetalert2.min.js',
        ];

        // Merge additional links/scripts if provided
        if (is_array($link_script) && !empty($link_script)) {
            if ($enlace === 'link') {
                $baseLinks = array_merge($baseLinks, $link_script);
            } elseif ($enlace === 'src') {
                $baseScripts = array_merge($baseScripts, $link_script);
            }
        }

        // Generate HTML output
        if ($enlace === 'link') {
            return implode("\n", array_map(fn($url) => "<link rel='stylesheet' href='$url'>", $baseLinks));
        } elseif ($enlace === 'src') {
            return implode("\n", array_map(fn($url) => "<script src='$url'></script>", $baseScripts));
        }

        return ''; // Return an empty string if $enlace is neither 'link' nor 'src'
    }

    public function view($route, $data = [])
    {
        extract($data);
        $filePath = "../lib/src/views/" . str_replace('.', '/', $route) . ".php";
        if (file_exists($filePath)) {
            // Incluir el archivo de vista y capturar la salida
            ob_start();
            include $filePath;
            $content = ob_get_clean();
            foreach ($data as $key => $value) {
                $content = str_replace("{{$key}}", $value, $content);
            }

            echo ($content);
        } else {
            $this->notFound($route);
        }
    }

    public function getNav($route)
    {
        $filePath = "../lib/src/views/" . str_replace('.', '/', $route) . ".php";
        if (file_exists($filePath)) {
            ob_start();
            include $filePath;
            $date = ob_get_clean();
            return $date;
        } else {
            $errorFilePath = "./lib/src/views/error404_1.php";
            $data = ['route' => $route];
            extract($data);
            if (file_exists($errorFilePath)) {
                ob_start();
                include $errorFilePath;
                $errorContent = ob_get_clean();
                return $errorContent;
            } else {
                echo "Error: La vista solicitada '$route' no se encuentra y tampoco se encontró la página de error.";
            }
        }
    }

    public function notFound($route)
    {
        $errorFilePath = "../lib/src/views/Error/error404.php";
        $data = ['route' => $route];
        if (file_exists($errorFilePath)) {
            ob_start();
            include $errorFilePath;
            $errorContent = ob_get_clean();
            foreach ($data as $key => $value) {
                $errorContent = str_replace("{{$key}}", $value, $errorContent);
            }
            echo ($errorContent);
        } else {
            echo "Error: La vista solicitada '$route' no se encuentra y tampoco se encontró la página de error.";
        }
    }
}
