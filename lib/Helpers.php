<?php

namespace lib;

use Dompdf\Dompdf;
use Dompdf\Options;

class Helpers
{
    function eliminarDirectorio($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->eliminarDirectorio($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
    public function view($route, $data = [])
    {
        extract($data);
        $filePath = "../App/views/" . str_replace('.', '/', $route) . ".php";
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

    public function notFound($route, $notfount = 1)
    {
        $errorFilePath = null;
        if ($notfount == 1) {
            $errorFilePath = "../App/views/error/error404.php";
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
        } else {
            $errorFilePath = "../App/views/error/error404_1.php";
            $errorFilePath = "../App/views/error/error404_1.php";
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

    public function pdf($route, $nomFile = 'document.pdf',  $data = [], $orientacion = 'portrait')
    {
        extract($data);
        $filePath = "../App/views/pdf/" . str_replace('.', '/', $route) . ".php";
        if (file_exists($filePath)) {
            // Incluir el archivo de vista y capturar la salida
            ob_start();
            include $filePath;
            $html = ob_get_clean();
            require_once '../resources/dompdf/autoload.inc.php';
            $options = new Options();
            $options->set('isPhpEnabled', TRUE);
            $options->set('isRemoteEnabled', TRUE); //false
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isCssFloatEnabled', false);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', $orientacion); //carta y horizontal
            $dompdf->render();
            $dompdf->stream($nomFile, array("Attachment" => 'false')); //false para que se descarge 
            return;
        } else {
            $this->notFound($route);
        }
    }

    public function pdf2($route, $data = [], $orientacion = 'portrait')
    {
        extract($data);
        $filePath = "../App/views/pdf/" . str_replace('.', '/', $route) . ".php";
        if (file_exists($filePath)) {
            // Incluir el archivo de vista y capturar la salida
            ob_start();
            include $filePath;
            $html = ob_get_clean();

            require_once '../resources/dompdf/autoload.inc.php';
            $options = new Options();
            $options->set('isPhpEnabled', TRUE);
            $options->set('isRemoteEnabled', TRUE);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isCssFloatEnabled', false);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', $orientacion); //carta y horizontal
            $dompdf->render();

            // Guardar el PDF en el servidor
            $pdfOutput = $dompdf->output();
            $base64Pdf = base64_encode($pdfOutput);
            return $base64Pdf; // Cambia esta línea para retornar el Base64 PDF en lugar de echo
        } else {
            $this->notFound($route);
        }
    }
}
