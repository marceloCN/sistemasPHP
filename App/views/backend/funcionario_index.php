<?php

use lib\Route;

use App\Models\Funcionario;
use App\Models\Configuracion;
use App\Models\TipoContrato;

$tipoContrato = new TipoContrato();
$tipoContrato = $tipoContrato->all();

$configuracion = new Configuracion();
$configuracion = $configuracion->select(['*'], ['estado' => 'AC'], []);

$funcionarios = new Funcionario();
$funcionarios = $funcionarios->all();
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
                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Planta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Contrato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Consultor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">Salud</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-settings1-tab" data-toggle="pill" href="#custom-tabs-two-settings1" role="tab" aria-selected="false">Registrar</a>
                        </li>
                    </ul>
                </div>

                <div class="modal fade registrar-funcionario" id="modal-lg" style="display: none;" aria-hidden="true">
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
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de funcionarios(as) planta</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Planta" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Planta">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">CI_Respaldo</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($funcionarios != null) {
                                                foreach ($funcionarios as $funcionario) {
                                                    if (intval($funcionario['id_tipo']) == 1) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $funcionario['ci'] ?></th>
                                                            <td><?= $funcionario['nombre'] ?></td>
                                                            <td><?= $funcionario['cargo'] ?></td>
                                                            <td><?= $funcionario['ci_respaldo'] ?></td>
                                                            <td>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-funcionario" data-ci="<?= $funcionario['ci'] ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-funcionario">Eliminar</button>
                                                                <?php } else {
                                                                    echo "ninguno";
                                                                } ?>
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
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de funcionarios(as) de Contrato</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Contrato" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Contrato">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">CI_Respaldo</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($funcionarios != null) {
                                                foreach ($funcionarios as $funcionario) {
                                                    if (intval($funcionario['id_tipo']) == 2) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $funcionario['ci'] ?></th>
                                                            <td><?= $funcionario['nombre'] ?></td>
                                                            <td><?= $funcionario['cargo'] ?></td>
                                                            <td><?= $funcionario['ci_respaldo'] ?></td>
                                                            <td>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-funcionario" data-ci="<?= $funcionario['ci'] ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-funcionario">Eliminar</button>
                                                                <?php } else {
                                                                    echo "ninguno";
                                                                } ?>
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
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de funcionarios(as) de Consultor(a)</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Consultor" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Consultor">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">CI_Respaldo</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($funcionarios != null) {
                                                foreach ($funcionarios as $funcionario) {
                                                    if (intval($funcionario['id_tipo']) == 3) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $funcionario['ci'] ?></th>
                                                            <td><?= $funcionario['nombre'] ?></td>
                                                            <td><?= $funcionario['cargo'] ?></td>
                                                            <td><?= $funcionario['ci_respaldo'] ?></td>
                                                            <td>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-funcionario" data-ci="<?= $funcionario['ci'] ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-funcionario">Eliminar</button>
                                                                <?php } else {
                                                                    echo "ninguno";
                                                                } ?>
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
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Listado de funcionarios(as) de Salud</h5>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" id="tableSearch_Salud" class="form-control float-right" placeholder="Buscar">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 600px;">
                                    <table class="table table-head-fixed text-nowrap" id="marcacionesTable_Salud">
                                        <thead>
                                            <tr>
                                                <th scope="col">CI</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cargo</th>
                                                <th scope="col">CI_Respaldo</th>
                                                <th scope="col">Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($funcionarios != null) {
                                                foreach ($funcionarios as $funcionario) {
                                                    if (intval($funcionario['id_tipo']) == 4) {
                                            ?>
                                                        <tr>
                                                            <th scope="row"><?= $funcionario['ci'] ?></th>
                                                            <td><?= $funcionario['nombre'] ?></td>
                                                            <td><?= $funcionario['cargo'] ?></td>
                                                            <td><?= $funcionario['ci_respaldo'] ?></td>
                                                            <td>
                                                                <?php if (intval($configuracion['editar']) == 1) { ?>
                                                                    <button type="button" class="btn btn-warning editar-funcionario" data-ci="<?= $funcionario['ci'] ?>">Editar</button>
                                                                    <button type="button" class="btn btn-danger eliminar-funcionario">Eliminar</button>
                                                                <?php } else {
                                                                    echo "ninguno";
                                                                } ?>
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
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-settings1" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <h4>Registrar funcionarios</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            Solo ingresas por funcionario su CI, nombre, cargo y tipo de contrato. <br>
                                                            <b>NOTA: </b> Si el funcionario existe en la tabla, solo modificaria el nombre, cargo y tipo de contrato para su insercion.<br><br>
                                                            <form id="registrar-por-funcionario">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Nombre Completo</label>
                                                                            <input id="nombre_registro" type="text" class="form-control" placeholder="Nombre y apellido de funcionario ...">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Cedula de Identidad</label>
                                                                            <input id="ci_registro" type="text" class="form-control" placeholder="CI del funcionario ...">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- textarea -->
                                                                        <div class="form-group">
                                                                            <label>Cargo del Funcionario</label>
                                                                            <input id="cargo_registro" type="text" class="form-control" placeholder="cargo del funcionario ...">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Tipo de contrato</label>
                                                                            <select class="form-control" id="tipo_contrato_registro">
                                                                                <?php foreach ($tipoContrato as $tipo): ?>
                                                                                    <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <button type="submit" class="btn btn-info btn-block">Registrar nuevo funcionario</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <h4>Mostrar Listado de los funcionarios</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="mostrar-funcionarios">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- text input -->
                                                                        <div class="form-group">
                                                                            <label>Tipo de contrato</label>
                                                                            <select class="form-control" id="tipo_contrato">
                                                                                <?php foreach ($tipoContrato as $tipo): ?>
                                                                                    <option value="<?= htmlspecialchars($tipo['id']) ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="button" class="btn btn-info btn-block">Mostrar funcionarios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
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
        $("#tableSearch_Planta").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Planta tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Contrato").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Contrato tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Consultor").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Consultor tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $("#tableSearch_Salud").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#marcacionesTable_Salud tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
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

        $(".editar-funcionario").on("click", function() {
            var ci = $(this).data("ci");
            var funcionarios = <?php echo json_encode($funcionarios) ?>;
            var datosFuncionario = funcionarios.filter(function(funcionario) {
                return funcionario.ci == ci;
            });
            var url = "<?= Route::route('modificar_datos_usuarios', 'POST') ?>";
            console.log(url);

            $('#modal-lg .titulo-responsable').text('Editar datos funcionario(a)');
            $('#modal-lg .modal-body').html(`
            <form action="` + url + `" method="POST">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <input id="nombre" type="text" name="nombre" class="form-control" placeholder="Nombre y apellido de funcionario ..." required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cedula de Identidad</label>
                            <input id="ci" type="text" name="ci" class="form-control" placeholder="CI del funcionario ..." required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Cargo del Funcionario</label>
                            <input id="cargo" type="text" name="cargo" class="form-control" placeholder="cargo del funcionario ..." required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tipo de contrato</label>
                            <select class="form-control" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="1">Planta</option>
                                    <option value="2">Contrato</option>
                                    <option value="3">Consultor</option>
                                    <option value="4">Salud</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>CI Respaldo</label>
                            <input id="ci_respaldo" type="text" name="ci_respaldo" class="form-control" placeholder="CI del funcionario ...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 modal-footer justify-content-between">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-warning" type="submit">Cambiar configuración</button>
                    </div>
                </div>
            </form>`);
            $('#nombre').val(datosFuncionario[0].nombre);
            $('#ci').val(datosFuncionario[0].ci);
            $('#cargo').val(datosFuncionario[0].cargo);
            $('#tipo_contrato').val(datosFuncionario[0].id_tipo);
            $('#ci_respaldo').val(datosFuncionario[0].ci_respaldo);
            $('#modal-lg').modal('show');
        });

        $(".eliminar-funcionario").on("click", function() {
            //modificar que se almacene la info en una BD externa para archivar su info pa futuro
            showNotification('success', 'No es posible eliminar datos del funcionario');
        });

        $('#registrar-por-funcionario').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                ci: $('#ci_registro').val(),
                nombre: $('#nombre_registro').val(),
                cargo: $('#cargo_registro').val(),
                tipo_contrato: $('#tipo_contrato_registro').val(),
            };

            $.ajax({
                type: 'POST',
                url: "<?= \lib\Route::route('registrar_un_funcionario', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?= \lib\Route::route('funcionarios', 'GET') ?>";
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





    });
</script>