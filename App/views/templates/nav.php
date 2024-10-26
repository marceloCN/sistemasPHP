<?php

use lib\Route;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Route::route("dashboard") ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Route::route('listar_soporte') ?>" class="nav-link">Soporte</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Route::route('listar_sistema') ?>" class="nav-link">Sistemas</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link"> Fecha: <?= date("d-m-Y") ?> </span>
        </li>
        <li class="nav-item">
            <span class="nav-link" id="reloj"> </span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
    <script>
        function actualizarReloj() {
            var ahora = new Date();
            var hora = ahora.getHours();
            var minutos = ahora.getMinutes();
            var segundos = ahora.getSeconds();
            document.getElementById('reloj').innerHTML = '  Hora: ' + hora + ':' + minutos + ':' + segundos;

            setTimeout(actualizarReloj, 1000); // Actualizar cada segundo
        }

        actualizarReloj(); // Iniciar la actualización del reloj
    </script>
</nav>