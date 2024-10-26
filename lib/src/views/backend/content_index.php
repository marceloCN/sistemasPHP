<?php

use lib\Route;

$datos = Route::enrutador(); // Obtiene todas las rutas

$GetControllerBackend = [];
$GetControllerFrontend = [];
$PostControllerBackend = [];
$PostControllerFrontend = [];

// Recorremos las rutas obtenidas
foreach ($datos as $method => $routes) {
    foreach ($routes as $key => $value) {
        // Verificamos que el método sea GET o POST
        if (in_array($method, ['GET', 'POST'])) {
            // Verificamos si hay callback definido
            if (isset($value['callback']) && is_array($value['callback'])) {
                $callback = $value['callback'][0] ?? null;

                // Verificamos si el callback corresponde a un controlador backend
                if (
                    strpos($callback, 'lib\src\Controllers\\') === 0 ||
                    strpos($key, 'panelConfiguration/website/administrador') === 0
                ) {
                    if ($method === 'GET') {
                        $GetControllerBackend[$key] = $value;
                    } elseif ($method === 'POST') {
                        $PostControllerBackend[$key] = $value;
                    }
                } else {
                    if ($method === 'GET') {
                        $GetControllerFrontend[$key] = $value;
                    } elseif ($method === 'POST') {
                        $PostControllerFrontend[$key] = $value;
                    }
                }
            } else {
                // Si no hay callback, agrupamos según el método
                if ($method === 'GET') {
                    $GetControllerFrontend[$key] = $value; // Asignamos a frontend por defecto
                } elseif ($method === 'POST') {
                    $PostControllerFrontend[$key] = $value; // Asignamos a frontend por defecto
                }
            }
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= count($GetControllerBackend) ?></h3>

                        <p>Metodo GET backend creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= count($PostControllerBackend) ?></h3>

                        <p>Metodo POST backend creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= count($GetControllerFrontend) ?></h3>

                        <p>Metodo GET frontend creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= count($PostControllerFrontend) ?></h3>

                        <p>Metodo POST frontend creados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
</section>