<?php

use lib\Route;
use App\Models\Calculo;

$Calculos = new Calculo();
$Calculos = $Calculos->listarCalculosActuales();
?>
<div class="row">

    <div class="col-12 col-sm-12">
        <div class="card card-secondary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Lista Planta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Lista Contrato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Lista Consultor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Mostrar Todo</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                        <div class="card table-container">
                            <div class="card-header">
                                <h3 class="card-title text-center">Lista de todos los Funcionarios Registado como Planta</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" class="form-control float-right search" placeholder="Buscar">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 500px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>CI</th>
                                            <th>Nombre</th>
                                            <th>Mes</th>
                                            <th>Retrazos</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($Calculos != null) {
                                            foreach ($Calculos as $calculo) {
                                                if (intval($calculo['id_tipo']) == 1) {
                                        ?>
                                                    <tr>
                                                        <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                        <td><?= $calculo['nombre'] ?></td>
                                                        <td><?= $calculo['nombre_mes'] ?></td>
                                                        <td><?= $calculo['totalretrazo'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                            <a href="#" onclick="obtenerDatosEvento(<?= $calculo['id'] ?>)">
                                                                <button type="button" class="btn btn-warning">Editar</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <div class="card table-container">
                            <div class="card-header">
                                <h3 class="card-title">Lista de todos los Funcionarios Registado como Contrato</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" class="form-control float-right search" placeholder="Buscar">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 500px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>CI</th>
                                            <th>Nombre</th>
                                            <th>Mes</th>
                                            <th>Retrazos</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($Calculos != null) {
                                            foreach ($Calculos as $calculo) {
                                                if (intval($calculo['id_tipo']) == 2) {
                                        ?>
                                                    <tr>
                                                        <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                        <td><?= $calculo['nombre'] ?></td>
                                                        <td><?= $calculo['nombre_mes'] ?></td>
                                                        <td><?= $calculo['totalretrazo'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                            <a href="#" onclick="obtenerDatosEvento(<?= $calculo['id'] ?>)">
                                                                <button type="button" class="btn btn-warning">Editar</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        <div class="card table-container">
                            <div class="card-header">
                                <h3 class="card-title">Lista de todos los Funcionarios Registado como Consultor</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" class="form-control float-right search" placeholder="Buscar">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 500px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>CI</th>
                                            <th>Nombre</th>
                                            <th>Mes</th>
                                            <th>Retrazos</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($Calculos != null) {
                                            foreach ($Calculos as $calculo) {
                                                if (intval($calculo['id_tipo']) == 3) {
                                        ?>
                                                    <tr>
                                                        <th scope="row"><?= $calculo['ci_client'] ?></th>
                                                        <td><?= $calculo['nombre'] ?></td>
                                                        <td><?= $calculo['nombre_mes'] ?></td>
                                                        <td><?= $calculo['totalretrazo'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary descargar-pdf" data-id="<?= $calculo['id'] ?>">DescargarPDF</button>
                                                            <a href="#" onclick="obtenerDatosEvento(<?= $calculo['id'] ?>)">
                                                                <button type="button" class="btn btn-warning">Editar</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('.search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            var $tableContainer = $(this).closest('.table-container');
            $tableContainer.find('tbody tr').each(function() {
                var rowData = $(this).text().toLowerCase();
                if (rowData.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
        $('.descargar-pdf').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/Area-de-trabajo/eventos/1234567',
                //url: '/Area-de-trabajo/eventos/' + id,
                type: 'GET', // O 'POST' dependiendo de cómo manejes la generación del PDF en tu servidor
                success: function(response) {
                    window.location.href = '/Area-de-trabajo/eventos/1234567';
                    //window.location.href = '/Area-de-trabajo/eventos/' + id;
                },
                error: function(xhr, status, error) {
                    console.error('Error al descargar el PDF:', error);
                }
            });
        });
    });
</script>