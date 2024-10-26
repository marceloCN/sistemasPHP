<?php

use App\Models\Datos_Usuarios;
use App\Models\Usuarios;
use lib\Route;

$datos_usuarios = new Datos_Usuarios();
$datos_usuarios = $datos_usuarios->all();

$datosfuncionario = new Usuarios();
$datosfuncionario = $datosfuncionario->select(['id', 'nombres', 'ci', 'nro_celular', 'email'], ['estado' => 'ac'], []);
//$datosfuncionario = $datosfuncionario->byQuery("SELECT id, nombres, ci, nro_celular, email FROM `usuarios` where estado = 'AC'");
?>

<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Listado de los usuarios registrados</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <input type="text" id="search" name="table_search" class="form-control float-right" data-toggle="tab" placeholder="Buscar...">
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Listar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Registrar</a></li>
                </ul>

            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="card-body table-responsive p-0" style="height: 600px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CI</th>
                                        <th>Funcionario (a)</th>
                                        <th>Creacion</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($datos_usuarios != null) {
                                        if (is_array($datos_usuarios) && array_keys($datos_usuarios) !== range(0, count($datos_usuarios) - 1)) {
                                            // Envolver el array en otro array
                                            $datos = array($datos_usuarios);
                                        } else {
                                            $datos = $datos_usuarios;
                                        }

                                        foreach ($datos as $fila) {
                                    ?>
                                            <tr>
                                                <td><?= $fila['id'] ?></td>
                                                <td><?= $fila['ci'] ?></td>
                                                <td><?= $fila['nombres'] ?></td>
                                                <td><?= $fila['creacion'] ?></td>
                                                <td><?= $fila['estado'] ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-block bg-gradient-info" data-toggle="modal" data-target="#modal-info-<?= $fila['id'] ?>">Editar</button>
                                                    <?php if ($fila['estado'] === 'AC') { ?>
                                                        <button type="button" class="btn btn-block bg-gradient-danger" data-toggle="modal" data-target="#modal-danger-<?= $fila['id'] ?>">Dar de baja</button>
                                                    <?php } ?>
                                                </td>

                                                <div class="modal fade" id="modal-info-<?= $fila['id'] ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-info">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Editar datos del funcionario</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= Route::route('modificar_funcionario', 'POST') ?>" method="post">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                                                                        <div class="col-md-6">
                                                                            <!-- /.form-group -->
                                                                            <div class="form-group">
                                                                                <label for="ci">CI</label>
                                                                                <input type="text" class="form-control" name="ci" value="<?= $fila['ci'] ?>" required>
                                                                            </div>
                                                                            <!-- /.form-group -->
                                                                            <div class="form-group">
                                                                                <label for="email">Email</label>
                                                                                <input type="email" class="form-control" name="email" value="<?= $fila['email'] ?>" required>
                                                                            </div>
                                                                            <!-- /.form-group -->
                                                                            <div class="form-group">
                                                                                <label for="telf">Telefono</label>
                                                                                <input type="text" class="form-control" name="telf" value="<?= $fila['telf'] ?>" required>
                                                                            </div>
                                                                            <!-- /.form-group -->
                                                                        </div>
                                                                        <!-- /.col -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="nombres">Nombre completo</label>
                                                                                <input type="text" class="form-control" name="nombres" value="<?= $fila['nombres'] ?>" required>
                                                                            </div>
                                                                            <!-- /.form-group -->
                                                                            <div class="form-group">
                                                                                <label>Estado</label>
                                                                                <select class="form-control" name="estado" style="width: 100%;">
                                                                                    <option value="AC">Activo</option>
                                                                                    <option value="NA">No Activo</option>
                                                                                </select>
                                                                            </div>
                                                                            <!-- /.form-group -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-outline-light">Guardar Cambios</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                                <?php if ($fila['estado'] === 'AC') { ?>
                                                    <div class="modal fade" id="modal-danger-<?= $fila['id'] ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content bg-danger">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Dar de Baja</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form action="<?= Route::route('dar_Baja', 'POST') ?>" method="post">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                                                                        Estas seguro que quieres darle de baja al usuario (a) <?= $fila['nombres'] ?>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-outline-light">Dar de baja</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                <?php } ?>
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
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">

                        <div class="card-body">
                            <form id="registro-form" action="#" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Usuario funcionario</label>
                                            <select class="form-control select2" style="width: 100%;">
                                                <?php
                                                if ($datosfuncionario != null) {
                                                    foreach ($datosfuncionario as $datos) { ?>
                                                        <option value="<?= $datos['id'] ?>"><?= $datos['nombres'] ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label for="ci_funcionario">CI</label>
                                            <input type="text" class="form-control" id="ci_funcionario" placeholder="Introduce el CI..." required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label for="email_funcionario">Email</label>
                                            <input type="text" class="form-control" id="email_funcionario" placeholder="Introduce el email..." required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" id="id_estado" style="width: 100%;">
                                                <option value="AC">Activo</option>
                                                <option value="NA">No Activar</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre_funcionario">Nombre completo</label>
                                            <input type="text" class="form-control" id="nombre_funcionario" placeholder="Introduce nombre completo..." required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label for="telf_funcionario">Telefono</label>
                                            <input type="text" class="form-control" id="telf_funcionario" placeholder="Introduce telefono..." required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label for="creacion">Fecha Creacion</label>
                                            <input type="datetime" class="form-control" id="creacion" placeholder="Introduce telefono..." required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-block btn-primary btn-lg">Registrar</button>
                                        </div>
                                        <!-- /.form-group -->

                                    </div>

                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
    <!-- ./card -->
</div>


<script>
    $(document).ready(function() {
        var id = 0;
        var estado = $('#id_estado').find('option:first').val();
        $('#search').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var rowData = $(this).text().toLowerCase();
                if (rowData.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });

        //para detectar cual sera el estado
        $('#estado').change(function() {
            estado = $(this).val();
        });
        //para detectar cual sera el estado
        $('#id_estado').change(function() {
            estado = $(this).val();
        });

        // Detectar cambio en el select
        $('.select2').change(function() {
            // Obtener el valor seleccionado
            var selectedOption = $(this).val();
            id = selectedOption; //guardando el id
            var datosFuncionario = <?php echo json_encode($datosfuncionario); ?>;
            // Buscar los datos del funcionario seleccionado en el array
            var funcionario = datosFuncionario.find(function(item) {
                return item.id == selectedOption;
            });

            $('#ci_funcionario').val(funcionario.ci);
            $('#email_funcionario').val(funcionario.email);
            $('#nombre_funcionario').val(funcionario.nombres);
            $('#telf_funcionario').val(funcionario.nro_celular);
            $('#creacion').val(obtenerFechaHoraActual());
        });

        function obtenerFechaHoraActual() {
            var fechaHora = new Date();
            var year = fechaHora.getFullYear();
            var month = ('0' + (fechaHora.getMonth() + 1)).slice(-2); // Se suma 1 ya que los meses van de 0 a 11
            var day = ('0' + fechaHora.getDate()).slice(-2);
            var hours = ('0' + fechaHora.getHours()).slice(-2);
            var minutes = ('0' + fechaHora.getMinutes()).slice(-2);
            var seconds = ('0' + fechaHora.getSeconds()).slice(-2);
            return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
        }

        $('#registro-form').submit(function(e) {
            e.preventDefault(); // Evita el envío del formulario por defecto
            // Obtener los valores de correo electrónico y contraseña
            var ci = $('#ci_funcionario').val();
            var nombre = $('#nombre_funcionario').val();
            var email = $('#email_funcionario').val();
            var telf = $('#telf_funcionario').val();
            var creacion = $('#creacion').val();

            // Objeto con los datos a enviar
            var formData = {
                id: id,
                ci: ci,
                nombre: nombre,
                email: email,
                telf: telf,
                creacion: creacion,
                estado: estado
            };
            // Enviar solicitud AJAX
            $.ajax({
                type: 'POST', // Método HTTP de la solicitud
                url: "<?= \lib\Route::route('registrar_funcionario', 'POST') ?>", // URL a la que se enviarán los datos
                data: formData, // Datos a enviar
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?= \lib\Route::route('usuarios', 'GET') ?>";
                    } else {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            icon: 'error',
                            title: response.sms
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                    alert('Se produjo un error al procesar su solicitud. Por favor, inténtelo de nuevo más tarde.');
                }
            });
        });

    });
</script>