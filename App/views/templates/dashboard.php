<?php

use lib\Route;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {head}

    {link}

    {src}
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        {nav}

        {aside}


        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{title}</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= Route::route('dashboard') ?>">Home</a></li>
                                <li class="breadcrumb-item active">{session}</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>

            <div class="content">
                {content}
            </div>

        </div>
        <!-- Main Footer -->
        {footer}


        <script>
            var mensajeError = <?= json_encode($_SESSION[constant('APP')]['mensaje'] ?? null); ?>;
            var mensajeSuccess = <?= json_encode($_SESSION[constant('APP')]['success'] ?? null); ?>;
            var logoutUrl = "<?= Route::route('logout') ?>"; // URL para logout

            // Limpiar mensajes de sesión
            <?php
            unset($_SESSION[constant('APP')]['mensaje']);
            unset($_SESSION[constant('APP')]['success']);
            ?>
        </script>
        <script src="<?= constant('URL') ?>/frontend/js/app.js"></script>

    </div>



</body>

</html>