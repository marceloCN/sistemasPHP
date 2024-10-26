<?php

use lib\Route;
use App\Models\Configuracion;
use App\Models\Localizacion;
use App\Models\TipoContrato;

$tipoContrato = new TipoContrato();
$tipoContrato = $tipoContrato->all();

$localizaciones = new Localizacion();
$localizaciones = $localizaciones->all();

$configuracion = new Configuracion();
$configuraciones = $configuracion->all();
$configuracion = $configuracion->select(['*'], ['estado' => 'AC'], []);


?>

<section class="content">
    <div class="container-fluid">

        <div class="col-12 col-sm-12">
            <div class="card card-primary card-tabs">

                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                        <li class="pt-2 px-3">
                            <h3 class="card-title">Paleta de opciones... </h3>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Ubicaciones y Contratos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Configuracion de calculo</a>
                        </li>
                    </ul>
                </div>

                <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title titulo-responsable"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>One fine body…</p>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title text-center">Ubicaciones en las marcaciones</h5>
                                                            <div class="card-tools">
                                                                <div class="input-group input-group-sm" style="width: 150px;">
                                                                    <input type="text" id="tableSearch_ubicacion" class="form-control float-right" placeholder="Buscar">
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
                                                            <table class="table table-head-fixed text-nowrap" id="marcacionesTable_ubicacion">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Codigo</th>
                                                                        <th scope="col">Ubicacion</th>
                                                                        <th scope="col">IP Acceso</th>
                                                                        <th scope="col">Detalle</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if ($localizaciones != null) {
                                                                        foreach ($localizaciones as $localizacion) {
                                                                    ?>
                                                                            <tr>
                                                                                <th scope="row"><?= $localizacion['id'] ?></th>
                                                                                <td><?= $localizacion['ubicacion'] ?></td>
                                                                                <td><?= $localizacion['direccion_ip'] ?></td>
                                                                                <td>
                                                                                    <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                                        <button type="button" class="btn btn-warning editar-ubicacion" data-id="<?= $localizacion['id'] ?>">Editar</button>
                                                                                        <button type="button" class="btn btn-danger eliminar-ubicacion">Eliminar</button>
                                                                                    <?php } else {
                                                                                        echo "ninguno";
                                                                                    } ?>
                                                                                </td>
                                                                            </tr>
                                                                    <?php

                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title text-center">Listado de tipos de Contrato</h5>

                                                            <div class="card-tools">
                                                                <div class="input-group input-group-sm" style="width: 150px;">
                                                                    <input type="text" id="tableSearch_tipoContrato" class="form-control float-right" placeholder="Buscar">
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
                                                            <table class="table table-head-fixed text-nowrap" id="marcacionesTable_tipoContrato">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">id</th>
                                                                        <th scope="col">Abreviatura</th>
                                                                        <th scope="col">nombre</th>
                                                                        <th scope="col">Detalle</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if ($tipoContrato != null) {
                                                                        foreach ($tipoContrato as $tipo) {
                                                                    ?>
                                                                            <tr>
                                                                                <th scope="row"><?= $tipo['id'] ?></th>
                                                                                <td><?= $tipo['abrev'] ?></td>
                                                                                <td><?= $tipo['nombre'] ?></td>
                                                                                <td>
                                                                                    <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                                        <button type="button" class="btn btn-warning editar-tipo" data-id="<?= $tipo['id'] ?>">Editar</button>
                                                                                        <button type="button" class="btn btn-danger eliminar-tipo">Eliminar</button>
                                                                                    <?php } else {
                                                                                        echo "ninguno";
                                                                                    } ?>
                                                                                </td>
                                                                            </tr>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                </div>
                                <!-- /.col -->
                            </div>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <h4>Registrar nuevo dato de ubicacion</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="guardar_localizacion">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Ubicacion biometrico</label>
                                                                            <input id="nuevo_ubicacion" type="text" class="form-control" placeholder="digite la ubicacion ..." required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Digite la direccion IP</label>
                                                                            <input id="nuevo_direccion_ip" type="text" class="form-control" placeholder="direccion_ip..." required="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Registrar nueva Ubicacion</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <h4>Registrar nuevo tipo de Contrato</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="guardar_contrato">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Abreviatura</label>
                                                                            <input id="nuevo_abrev" type="text" class="form-control" placeholder="abrev ..." required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Nombre de Contrato</label>
                                                                            <input id="nuevo_nombre" type="text" class="form-control" placeholder="nombre..." required="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Registrar nuevo contrato</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <h4>Registrar nueva configuracion</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="guardar_configuracion">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Tolerancia (minutos)</label>
                                                                            <input id="nueva_tolerancia" type="number" class="form-control" value="0" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>diferencia de minutos</label>
                                                                            <input id="nueva_diferencia" type="number" class="form-control" value="0" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>hora de Ingreso1</label>
                                                                            <input id="nuevo_ingreso1" type="time" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>hora de Salida1</label>
                                                                            <input id="nuevo_salida1" type="time" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>hora de Ingreso2</label>
                                                                            <input id="nuevo_ingreso2" type="time" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>hora de Salida2</label>
                                                                            <input id="nuevo_salida2" type="time" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Permitir Editar datos: </label>
                                                                            <input type="checkbox" id="editar_checkbox" data-bootstrap-switch>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Permitir Mostrar listados y marcaciones: </label>
                                                                            <input type="checkbox" id="mostrar_checkbox" data-bootstrap-switch>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Registrar nuevo contrato</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title text-center">Listado de tipos de configuracion</h5>

                                                            <div class="card-tools">
                                                                <div class="input-group input-group-sm" style="width: 150px;">
                                                                    <input type="text" id="tableSearch_tipoContrato" class="form-control float-right" placeholder="Buscar">
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
                                                            <table class="table table-head-fixed text-nowrap" id="marcacionesTable_tipoContrato">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">tolerancia(min)</th>
                                                                        <th scope="col">dif_min</th>
                                                                        <th scope="col">Ingreso1</th>
                                                                        <th scope="col">Salida1</th>
                                                                        <th scope="col">Ingreso2</th>
                                                                        <th scope="col">Salida2</th>
                                                                        <th scope="col">Mostrar</th>
                                                                        <th scope="col">Editar</th>
                                                                        <th scope="col">Estado</th>
                                                                        <th scope="col">Detalles</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if ($configuraciones != null) {
                                                                        foreach ($configuraciones as $conf) {
                                                                    ?>
                                                                            <tr>
                                                                                <td><?= $conf['tolerancia'] ?></td>
                                                                                <td><?= $conf['diferencia_min'] ?></td>
                                                                                <td><?= $conf['horaIngreso1'] ?></td>
                                                                                <td><?= $conf['horaSalida1'] ?></td>
                                                                                <td><?= $conf['horaIngreso2'] ?></td>
                                                                                <td><?= $conf['horaSalida2'] ?></td>
                                                                                <td><?= $conf['mostrar'] ?></td>
                                                                                <td><?= $conf['editar'] ?></td>
                                                                                <td><?= $conf['estado'] ?></td>
                                                                                <td>
                                                                                    <?php if ($conf['estado'] == 'NA') { ?>
                                                                                        <button type="button" class="btn btn-success activar-conf" data-id="<?= $conf['id'] ?>">Activar</button>

                                                                                    <?php
                                                                                    }
                                                                                    if (intval($configuracion['editar']) == 1 || $conf['estado'] == 'AC') { ?>
                                                                                        <button type="button" class="btn btn-warning editar-conf" data-id="<?= $conf['id'] ?>">Editar</button>

                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                </div>
                                <!-- /.col -->
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</section>

<script>
    $(document).ready(function() {

        $("input[data-bootstrap-switch]").bootstrapSwitch();

        $("#tableSearch_ubicacion").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_ubicacion tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_tipoContrato").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_tipoContrato tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        $(".editar-ubicacion").on("click", function() {
            var localizacion_id = $(this).data("id");
            var localizaciones = <?php echo json_encode($localizaciones) ?>;
            var datosLocalizacion = localizaciones.filter(function(ubicacion) {
                return ubicacion.id == localizacion_id;
            });
            var url = "<?= Route::route('editar_localizacion', 'POST') ?>";
            $('#modal-lg .titulo-responsable').text('Editar datos de ubicacion');
            $('#modal-lg .modal-body').html(`
                <form action="` + url + `" method="POST">
                    <input type="hidden" name="localizacion_id" value="` + localizacion_id + `">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ubicacion biometrico</label>
                                <input id="ubicacion" type="text" name="ubicacion" class="form-control" placeholder="digite la ubicacion ..." required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Digite la direccion IP</label>
                                <input id="direccion_ip" type="text" name="direccion_ip" class="form-control" placeholder="direccion_ip..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 modal-footer justify-content-between">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-warning" type="submit">Cambiar datos</button>
                        </div>
                    </div>
                </form>
            `);
            $('#ubicacion').val(datosLocalizacion[0].ubicacion);
            $('#direccion_ip').val(datosLocalizacion[0].direccion_ip);
            $('#modal-lg').modal('show');
        });

        $(".editar-tipo").on("click", function() {
            var tipo_id = $(this).data("id");
            var tipo_contratos = <?php echo json_encode($tipoContrato) ?>;
            var tipoContrato = tipo_contratos.filter(function(tipo) {
                return tipo.id == tipo_id;
            });
            var url = "<?= Route::route('editar_tipo_contrato', 'POST') ?>";
            $('#modal-lg .titulo-responsable').text('Editar datos de contrato');
            $('#modal-lg .modal-body').html(`
                <form action="` + url + `" method="POST">
                    <input type="hidden" name="tipo_id" value="` + tipo_id + `">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Abreviatura</label>
                                <input id="abrev" type="text" name="abrev" class="form-control" placeholder="abrev ..." required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nombre de Contrato</label>
                                <input id="nombre" type="text" name="nombre" class="form-control" placeholder="nombre..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 modal-footer justify-content-between">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-warning" type="submit">Cambiar datos</button>
                        </div>
                    </div>
                </form>
            `);
            $('#abrev').val(tipoContrato[0].abrev);
            $('#nombre').val(tipoContrato[0].nombre);
            $('#modal-lg').modal('show');
        });

        $(".eliminar-ubicacion").on("click", function() {
            showNotification('success', 'No ha sido posible eliminar...');
        });

        $(".eliminar-tipo").on("click", function() {
            showNotification('success', 'No ha sido posible eliminar...');
        });

        $('.activar-conf').on("click", function() {
            var id = $(this).data("id");
            var configuraciones = <?php echo json_encode($configuraciones) ?>;
            var id_activo = configuraciones.filter(function(conf) {
                return conf.estado === 'AC';
            });
            formData = {
                id_activado: id_activo[0].id,
                id_activar: id
            }
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('activar_configuracion', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var url = "<?= Route::route('configuracion', 'GET') ?>";
                        window.location.href = url;
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });

        });

        $('.editar-conf').on("click", function() {
            var id = $(this).data("id");
            var configuraciones = <?php echo json_encode($configuraciones) ?>;
            var datosConfiguracion = configuraciones.filter(function(conf) {
                return conf.id == id;
            });
            console.log(datosConfiguracion);
            var url = "<?= Route::route('editar_configuracion', 'POST') ?>";
            $('#modal-lg .titulo-responsable').text('Editar datos de configuracion');
            $('#modal-lg .modal-body').html(`
                <form id="form-editar" action="` + url + `" method="POST">
                    <input type="hidden" name="configuracion_id" value="` + id + `">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tolerancia (minutos)</label>
                                <input id="tolerancia" name="tolerancia" type="number" class="form-control" value="0" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>diferencia de minutos</label>
                                <input id="diferencia" name="diferencia_min" type="number" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>hora de Ingreso1</label>
                                <input id="ingreso1" name="horaIngreso1" type="time" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>hora de Salida1</label>
                                <input id="salida1" name="horaSalida1" type="time" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>hora de Ingreso2</label>
                                <input id="ingreso2" name="horaIngreso2" type="time" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>hora de Salida2</label>
                                <input id="salida2" name="horaSalida2" type="time" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Permitir Editar datos: </label>
                                <input type="checkbox" id="editar1_checkbox" name="editar" data-bootstrap-switch>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Permitir Mostrar datos: </label>
                                <input type="checkbox" id="mostrar1_checkbox" name="mostrar" data-bootstrap-switch>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 modal-footer justify-content-between">
                            <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-warning" type="submit">Cambiar datos</button>
                        </div>
                    </div>
                </form>
            `);
            $('#tolerancia').val(datosConfiguracion[0].tolerancia);
            $('#diferencia').val(datosConfiguracion[0].diferencia_min);
            $('#ingreso1').val(datosConfiguracion[0].horaIngreso1);
            $('#salida1').val(datosConfiguracion[0].horaSalida1);
            $('#ingreso2').val(datosConfiguracion[0].horaIngreso2);
            $('#salida2').val(datosConfiguracion[0].horaSalida2);
            // Establece el estado de los checkboxes
            $('#editar1_checkbox').bootstrapSwitch('state', datosConfiguracion[0].editar == 1);
            $('#mostrar1_checkbox').bootstrapSwitch('state', datosConfiguracion[0].mostrar == 1);

            $('#modal-lg').modal('show');
            $('#form-editar').on('submit', function(event) {
                // Actualiza el estado del checkbox en el momento del envío
                var editar = $('#editar1_checkbox').bootstrapSwitch('state') ? 1 : 0;
                var mostrar = $('#mostrar1_checkbox').bootstrapSwitch('state') ? 1 : 0;

                // Agregar los valores al formulario
                $(this).append('<input type="hidden" name="editar" value="' + editar + '">');
                $(this).append('<input type="hidden" name="mostrar" value="' + mostrar + '">');
            });
        });

        $("#guardar_localizacion").on("submit", function(e) {
            e.preventDefault();
            var formData = {
                ubicacion: $("#nuevo_ubicacion").val(),
                direccion_ip: $("#nuevo_direccion_ip").val()
            }
            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('registrar_localizacion', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var url = "<?= Route::route('configuracion', 'GET') ?>";
                        window.location.href = url;
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });
        });

        $("#guardar_contrato").on("submit", function(e) {
            e.preventDefault();
            var formData = {
                abrev: $("#nuevo_abrev").val(),
                nombre: $("#nuevo_nombre").val()
            }
            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('registrar_contratos', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var url = "<?= Route::route('configuracion', 'GET') ?>";
                        window.location.href = url;
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });

        });


        $("#guardar_configuracion").on("submit", function(e) {
            e.preventDefault();

            var formData = {
                tolerancia: $("#nueva_tolerancia").val(),
                diferencia: $("#nueva_diferencia").val(),
                ingreso1: $("#nuevo_ingreso1").val(),
                salida1: $("#nuevo_salida1").val(),
                ingreso2: $("#nuevo_ingreso2").val(),
                salida2: $("#nuevo_salida2").val(),
                editar: $("#editar_checkbox").bootstrapSwitch('state') ? 1 : 0,
                mostrar: $("#mostrar_checkbox").bootstrapSwitch('state') ? 1 : 0
            }
            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('registrar_configuracion', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var url = "<?= Route::route('configuracion', 'GET') ?>";
                        window.location.href = url;
                    } else {
                        showNotification('error', response.sms); // Manejo de errores de respuesta
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });


        });

        function showNotification(icon, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 5000
            });
        }
    });
</script>