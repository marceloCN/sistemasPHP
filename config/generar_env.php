<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $url = $_POST['url'];
    $app = $_POST['app'];
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];
    $charset = $_POST['charset'];

    // Crear contenido del archivo .env
    $envContent = sprintf(
        "# Configuración de la aplicación\nURL=%s\nAPP=%s\n\n# Configuración de la base de datos\nHOST=%s\nUSER=%s\nPWD=%s\nCHARSET=%s\n",
        $url,
        $app,
        $host,
        $user,
        $pwd,
        $charset
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Configuración basica de .env</h1>
        <form method="POST" action="">
            <label for="url">URL:</label>
            <input type="text" id="url" name="url" required placeholder="Ej: http://inventario.test">

            <label for="app">APP:</label>
            <input type="text" id="app" name="app" required placeholder="Ej: Inventario">

            <label for="host">HOST:</label>
            <input type="text" id="host" name="host" required placeholder="Ej: mysql:host=localhost;dbname=marcacion;port=3306">

            <label for="user">USER:</label>
            <input type="text" id="user" name="user" required placeholder="Ej: root">

            <label for="pwd">PWD:</label>
            <input type="password" id="pwd" name="pwd" placeholder="Contraseña">

            <label for="charset">CHARSET:</label>
            <input type="text" id="charset" name="charset" required value="utf8mb4" placeholder="Ej: utf8mb4">

            <button type="submit">Guardar configuración</button>
        </form>
        <div class="footer">
            <p>&copy; 2024 Ing. Marcelo Cruz Nogales</p>
        </div>
    </div>
</body>

</html>