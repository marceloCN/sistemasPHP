<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $url = $_POST['url'];
    $app = $_POST['app'];

    // Crear contenido del archivo .env
    $envContent = sprintf(
        "# Configuración de la aplicación\nURL=%s\nAPP=%s\n",
        $url,
        $app
    );

    // Manejar la única conexión a bases de datos (en este caso solo una)
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pwd = $_POST['db_pwd'];
    $db_charset = $_POST['db_charset'];

    $envContent .= sprintf(
        "\n# Configuración de la base de datos 1\nHOST=%s\nUSER=%s\nPWD=%s\nCHARSET=%s\n\n# Configuracion de la base de datos 1\nDB1_HOST=\nDB1_USER=\nDB1_PWD=\nDB1_CHARSET=\n",
        $db_host,
        $db_user,
        $db_pwd,
        $db_charset
    );

    // Configuración de correo
    $mail_host = $_POST['mail_host'];
    $mail_username = $_POST['mail_username'];
    $mail_password = $_POST['mail_password'];
    $mail_port = $_POST['mail_port'];
    $mail_encryption = $_POST['mail_encryption'];

    $envContent .= sprintf(
        "\n# Configuración de correo\nMAIL_MAILER=smtp\nMAIL_HOST=%s\nMAIL_PORT=%s\nMAIL_USERNAME=%s\nMAIL_PASSWORD=%s\nMAIL_ENCRYPTION=%s\n",
        $mail_host,
        $mail_port,
        $mail_username,
        $mail_password,
        $mail_encryption
    );

    $envFilePath = __DIR__ . '/../config/.env';

    // Guardar el archivo .env
    if (file_put_contents($envFilePath, $envContent) === false) {
        die("Error: No se pudo crear el archivo .env. Verifica los permisos del directorio.");
    }

    // Cambiar permisos del archivo .env a 775
    if (chmod($envFilePath, 0775) === false) {
        die("Error: No se pudo cambiar los permisos del archivo .env. Verifica los permisos del directorio.");
    }
    // Si la creación fue exitosa, redirige
    header("Location: ../public/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de .env</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 500px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .db-config {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Configuración de .env</h1>
        <form method="POST" action="">
            <div class="db-config">
                <h3>Nombre la App virtual y url</h3>
                <div class="db-entry">
                    <label for="url">URL:</label>
                    <input type="text" id="url" name="url" required placeholder="Ej: http://inventario.test">

                    <label for="app">Nombre de la Aplicación:</label>
                    <input type="text" id="app" name="app" required placeholder="Ej: Inventario">
                </div>
            </div>
            <div class="db-config" id="db-configs">
                <h3>Conexiones a Bases de Datos</h3>
                <div class="db-entry">
                    <label for="db1_host">HOST:</label>
                    <input type="text" id="db_host" name="db_host" required placeholder="Ej: mysql:host=localhost;dbname=marcacion;port=3306">

                    <label for="db1_user">USER:</label>
                    <input type="text" id="db_user" name="db_user" required placeholder="Ej: root">

                    <label for="db1_pwd">PWD:</label>
                    <input type="password" id="db_pwd" name="db_pwd" placeholder="Contraseña">

                    <label for="db1_charset">CHARSET:</label>
                    <input type="text" id="db_charset" name="db_charset" required value="utf8mb4" placeholder="Ej: utf8mb4">
                </div>
            </div>

            <div class="db-config">
                <h3>Configuracion de phpMailer</h3>
                <div class="db-entry">
                    <label for="mail_host">MAIL HOST:</label>
                    <input type="text" id="mail_host" name="mail_host" required value="smtp.gmail.com" placeholder="Ej: smtp.gmail.com">

                    <label for="mail_username">MAIL USERNAME:</label>
                    <input type="text" id="mail_username" name="mail_username" required placeholder="Ej: tu_correo@gmail.com">

                    <label for="mail_password">MAIL PASSWORD:</label>
                    <input type="password" id="mail_password" name="mail_password" placeholder="Contraseña de correo">

                    <label for="mail_port">MAIL PORT:</label>
                    <input type="text" id="mail_port" name="mail_port" required value="587" placeholder="Ej: 587">

                    <label for="mail_encryption">MAIL ENCRYPTION:</label>
                    <input type="text" id="mail_encryption" name="mail_encryption" required value="tls" placeholder="Ej: tls">
                </div>
            </div>
            <div class="db-config">
                <button type="submit">Guardar configuración</button>
            </div>

        </form>
        <div class="footer">
            <p>&copy; 2024 Ing. Marcelo Cruz Nogales</p>
        </div>
    </div>
</body>

</html>