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
        }
        return;
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
        }
        return;
    }
}
