<?php

use lib\Route;
?>
<section class="content">
    <div class="container-fluid">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Pagina no encontrada.</h3>

                <div class="container">
                    <h1>404</h1>
                    <p>Lo sentimos, la página que estás buscando no se pudo encontrar.</p>
                    <p>La ruta solicitada es: <strong><?= $route ?></strong></p>
                    <p><a href="<?= Route::route('dashboard', 'GET') ?>">Volver a la página principal</a></p>
                </div>


            </div>
        </div>
    </div>
</section>