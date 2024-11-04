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
use PharData;

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

    static function listarArchivosYCarpetas($url, $usuario, $contraseña, $rutaRemota)
    {
        // Inicializa cURL
        $ch = curl_init();
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/' . $usuario . '/' . ltrim($rutaRemota, '/');

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PROPFIND");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Depth: 1',
            'Content-Type: text/xml; charset=utf-8',
        ]);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);

        // Verifica si hay errores
        if ($response === false) {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Error en cURL: " . curl_error($ch)]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        // Intentar cargar el XML manualmente
        $files = [];
        preg_match_all('/<d:response>(.*?)<\/d:response>/s', $response, $matches);

        foreach ($matches[1] as $index => $match) {
            // Omitir el primer índice (que generalmente es la raíz)
            if ($index === 0) {
                continue;
            }

            preg_match('/<d:href>(.*?)<\/d:href>/', $match, $href);
            preg_match('/<d:collection\/>/', $match, $isFolder);

            // Extraer solo el nombre del archivo o carpeta
            $name = basename(isset($href[1]) ? $href[1] : '');

            $files[] = [
                'name' => $name,
                'href' => isset($href[1]) ? $href[1] : '',
                'resourcetype' => !empty($isFolder) ? 'folder' : 'file',
            ];
        }

        return $files;
    }

    static function descargarCarpeta($url, $usuario, $contraseña, $rutaCarpeta)
    {
        // Obtener la lista de archivos y carpetas
        $files = self::listarArchivosYCarpetas($url, $usuario, $contraseña, $rutaCarpeta);

        // Crear un archivo TAR temporal
        $nombreTar = basename($rutaCarpeta) . '.tar';
        $rutaTempTar = tempnam(sys_get_temp_dir(), $nombreTar);

        // Crear el archivo TAR
        try {
            $tar = new PharData($rutaTempTar);
        } catch (Exception $e) {
            echo "Error al crear el archivo TAR: " . $e->getMessage();
            return;
        }

        // Iterar sobre los archivos y añadirlos al TAR
        foreach ($files as $file) {
            if ($file['resourcetype'] === 'file') {
                $fileUrl = rtrim($url, '/') . $file['href'];

                // Inicializa cURL para descargar el archivo
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $fileUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                // Ejecuta la solicitud cURL para descargar el archivo
                $fileContent = curl_exec($ch);
                if ($fileContent === false) {
                    echo "Error al descargar el archivo: " . curl_error($ch);
                    curl_close($ch);
                    continue; // Continúa con el siguiente archivo
                }
                curl_close($ch);

                // Añadir el archivo al TAR
                try {
                    $tar->addFromString($file['name'], $fileContent);
                } catch (Exception $e) {
                    echo "Error al agregar el archivo al TAR: " . $e->getMessage();
                }
            }
        }

        // Configura las cabeceras para la descarga del TAR
        header('Content-Description: File Transfer');
        header('Content-Type: application/x-tar');
        header('Content-Disposition: attachment; filename="' . $nombreTar . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaTempTar));

        // Envía el archivo TAR al navegador
        readfile($rutaTempTar);

        // Elimina el archivo TAR temporal
        unlink($rutaTempTar);
        exit;
    }






    static function descargarArchivo($url, $usuario, $contraseña, $rutaRemota)
    {
        // Inicializa cURL
        $ch = curl_init();
        $downloadUrl = rtrim($url, '/') . '/remote.php/dav/files/' . $usuario . '/' . ltrim($rutaRemota, '/');

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $downloadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);

        // Verifica si hay errores
        if ($response === false) {
            echo "Error en cURL: " . curl_error($ch);
            curl_close($ch);
            return;
        }

        // Verifica el código de estado HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            echo "Error al descargar el archivo. Código HTTP: $httpCode";
            return;
        }

        // Extrae el nombre del archivo de la ruta remota
        $nombreArchivo = basename($rutaRemota);

        // Configura las cabeceras para la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($response));

        // Envía el contenido del archivo al navegador
        echo $response;
        exit;
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

        // Verificar y crear directorios necesarios
        $partesRuta = explode('/', trim($rutaRemota, '/'));
        $rutaActual = '';

        foreach ($partesRuta as $parte) {
            $rutaActual .= '/' . $parte;
            if (!self::verificarExistenciaDirectorioNextcloud($url, $usuario, $contraseña, $rutaActual)) {
                self::crearDirectorioNextcloud($url, $usuario, $contraseña, $rutaActual);
            }
        }

        // Obtener el nombre del archivo
        $nombreArchivo = basename($archivoLocal);

        // Construir la URL completa para la carga
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/' . $usuario . '/' . rtrim($rutaRemota, '/') . '/' . $nombreArchivo;


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
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Habilitar modo de depuración

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        // Comprobar si hubo un error
        if ($response === false) {
            echo "Error en cURL: " . curl_error($ch) . "\n";
        }

        // Cerrar el archivo y la sesión cURL
        fclose($fh);
        curl_close($ch);
    }

    public static function verificarExistenciaDirectorioNextcloud($url, $usuario, $contraseña, $rutaRemota)
    {
        // Inicializar cURL
        $ch = curl_init();
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/' . $usuario . '/' . ltrim($rutaRemota, '/');

        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $existencia = strpos($response, '<d:response') !== false; // Verificar la respuesta

        curl_close($ch);
        return $existencia;
    }

    public static function crearDirectorioNextcloud($url, $usuario, $contraseña, $rutaRemota)
    {
        // Inicializar cURL para crear el directorio
        $ch = curl_init();
        $uploadUrl = rtrim($url, '/') . '/remote.php/dav/files/'  . $usuario . '/' . ltrim($rutaRemota, '/');

        curl_setopt($ch, CURLOPT_URL, $uploadUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$contraseña");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "MKCOL");

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);
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
