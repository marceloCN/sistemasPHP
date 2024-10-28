<?php

namespace lib;

//para el pdf
use Dompdf\Dompdf;
use Dompdf\Options;

//para enviar info por correo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//para crear archivos excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//para subir archivo webDav
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;


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

    //$data = no encriptado, te devuelve encriptado
    public function  generateHash($data, $algorithm = 'sha256')
    {
        // Generar el hash utilizando el algoritmo especificado
        return hash($algorithm, $data);
    }

    //$data = no encriptado, $hash = variable encriptada, te devuelve true or false si esta correcto
    public function verifyHash($data, $hash, $algorithm = 'sha256')
    {
        $newHash = hash($algorithm, $data);
        return hash_equals($newHash, $hash); // Compara de forma segura
    }

    public function encrypt($data, $key)
    {
        // Generar un vector de inicialización (IV) aleatorio
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        // Cifrar el dato
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

        // Retornar el IV y el dato cifrado codificados en base64
        return base64_encode($iv . $encryptedData);
    }

    public function decrypt($data, $key)
    {
        // Decodificar el dato de base64
        $data = base64_decode($data);

        // Obtener el tamaño del IV
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');

        // Extraer el IV y el dato cifrado
        $iv = substr($data, 0, $ivSize);
        $encryptedData = substr($data, $ivSize);

        // Desencriptar el dato
        return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    }

    /**
     * Ejemplo de como utilizar
     * $key = "n3gr4c1o"; // Debe ser de 32 bytes para AES-256
     * $plaintext = "9713622";

     * Cifrar
     * $encrypted = Helpers::encrypt($plaintext, $key);
     * echo "Texto cifrado: " . $encrypted . "<br>";

     * Desencriptar
     * $decrypted = Helpers::decrypt($encrypted, $key);
     *echo "Texto desencriptado: " . $decrypted . "\n";
     */


    static function generateExcel($data, $filename = 'mi_archivo.xlsx')
    {
        if (pathinfo($filename, PATHINFO_EXTENSION) !== 'xlsx') {
            $filename .= '.xlsx'; // Agregar la extensión si no está presente
        }
        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar encabezados (suponiendo que el primer elemento del array es un array de encabezados)
        if (!empty($data) && is_array($data) && is_array($data[0])) {
            // Obtener los encabezados de la primera fila
            $headers = array_keys($data[0]);
            $sheet->fromArray($headers, NULL, 'A1');

            // Resaltar los encabezados en negrita
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ];
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($headerStyle);

            // Agregar los datos
            $sheet->fromArray($data, NULL, 'A2'); // A2 para comenzar después de los encabezados
        }

        // Configurar las cabeceras para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Crear el escritor y guardar en la salida
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit; // Terminar el script
    }

    public static function subirArchivoNextcloud($url, $usuario, $contraseña, $archivoLocal, $rutaRemota)
    {
        // Comprobar si el archivo local existe
        if (!file_exists($archivoLocal)) {
            echo "El archivo local no existe: $archivoLocal\n";
            return;
        }

        // Inicializar cURL
        $ch = curl_init();


        // Construir la URL completa para la carga
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/' . $usuario . '/' . ltrim($rutaRemota, '/');
        var_dump($uploadUrl);

        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_UPLOAD, true);

        // Abrir el archivo local para lectura
        $fh = fopen($archivoLocal, 'r');
        if ($fh === false) {
            echo "No se pudo abrir el archivo: $archivoLocal\n";
            return;
        }

        // Configurar cURL para subir el archivo
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($archivoLocal));

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        // Comprobar si hubo un error
        if ($response === false) {
            echo 'Error al enviar el archivo: ' . curl_error($ch) . "\n";
        } else {
            echo "Archivo enviado con éxito a $rutaRemota.\n";
        }

        // Cerrar el archivo y la sesión cURL
        fclose($fh);
        curl_close($ch);
    }

    public static function subirCarpetaNextcloud($url, $usuario, $contraseña, $carpetaLocal, $rutaRemota)
    {
        // Verificar si la carpeta local existe
        if (!is_dir($carpetaLocal)) {
            echo "La carpeta local no existe: $carpetaLocal\n";
            return;
        }

        // Crear la carpeta remota en el servidor
        self::crearDirectorioNextcloud($url, $usuario, $contraseña, $rutaRemota);

        // Iterar sobre los archivos en la carpeta local
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($carpetaLocal));
        foreach ($iterator as $archivo) {
            // Ignorar directorios
            if ($archivo->isDir()) {
                continue;
            }

            // Construir la ruta remota
            $rutaRemotaCompleta = $rutaRemota . '/' . str_replace($carpetaLocal . '/', '', $archivo->getPathname());
            var_dump($rutaRemotaCompleta . "<br>" . dirname($rutaRemotaCompleta));
            // Crear el directorio en la ruta remota si no existe
            //self::crearDirectorioNextcloud($url, $usuario, $contraseña, dirname($rutaRemotaCompleta));
            // Subir el archivo al servidor WebDAV
            //self::subirArchivoNextcloud($url, $usuario, $contraseña, $archivo->getPathname(), $rutaRemotaCompleta);
        }
        die();
    }

    private static function crearDirectorioNextcloud($url, $usuario, $contraseña, $rutaRemota)
    {
        // Inicializar cURL para crear el directorio
        $ch = curl_init();
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/'  . $usuario . '/' . ltrim($rutaRemota, '/');

        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "MKCOL");

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        if ($response === false && curl_errno($ch) != 405) { // 405: método no permitido
            echo 'Error al crear el directorio: ' . curl_error($ch) . "\n";
        } else {
            echo "Directorio creado o ya existe: $rutaRemota\n";
        }

        curl_close($ch);
    }


    public function enviarCorreo($destinatario, $asunto, $cuerpoHtml, $cuerpoTexto = '', $archivosAdjuntos = [])
    {
        $mail = new PHPMailer(true); // Instancia de PHPMailer
        try {
            // Configuración del servidor SMTP utilizando las constantes
            $mail->isSMTP();
            $mail->Host = MAIL_HOST; // Usar la constante MAIL_HOST
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME; // Usar la constante MAIL_USERNAME
            $mail->Password = MAIL_PASSWORD; // Usar la constante MAIL_PASSWORD
            $mail->SMTPSecure = MAIL_ENCRYPTION; // Usar la constante MAIL_ENCRYPTION
            $mail->Port = MAIL_PORT; // Usar la constante MAIL_PORT

            // Destinatarios
            $mail->setFrom(MAIL_USERNAME, 'Marcelo Cruz'); // De
            $mail->addAddress($destinatario); // Para
            $mail->addReplyTo(MAIL_USERNAME, 'Marcelo Cruz'); // Responder a tu correo

            // Agregar archivos adjuntos
            foreach ($archivosAdjuntos as $archivo) {
                if (file_exists($archivo)) {
                    $mail->addAttachment($archivo); // Adjuntar el archivo
                }
            }

            // Contenido
            $mail->isHTML(true); // Establecer formato de correo como HTML
            $mail->Subject = $asunto;
            $mail->Body    = $cuerpoHtml;
            $mail->AltBody = $cuerpoTexto;

            // Enviar el correo
            $mail->send();
            return 'El correo ha sido enviado';
        } catch (Exception $e) {
            return "El correo no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
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
            //require_once '../resources/dompdf/autoload.inc.php';
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

            //require_once '../resources/dompdf/autoload.inc.php';
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
