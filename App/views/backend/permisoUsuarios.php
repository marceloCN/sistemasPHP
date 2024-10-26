<?php

use App\Models\Datos_Usuarios;
use App\Models\Permiso;
use lib\Route;

$datos_usuarios = new Datos_Usuarios();
$datos_usuarios = $datos_usuarios->select(['*'], ['estado' => 'AC'], []);
$permiso = new Permiso();
$permisos = $permiso->all();
$listadoPermisos = $permiso->byQuery("SELECT p.nro, p.abrev, p.nombre, du.nombres, up.creacion, up.iduser 
from permiso p, datos_usuarios du, user_permiso up 
where up.iduser = du.id and up.nropermiso = p.nro and up.estado = 'AC' and du.estado = 'AC' order by p.nro asc");

?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Listado de los permisos</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <input type="text" id="search" name="table_search" class="form-control float-right" data-toggle="tab" placeholder="Buscar...">
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Listado de permisos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Registrar Permiso</a></li>
                </ul>

            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Abrev</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Fecha creacion</th>
                                        <th>opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($listadoPermisos != null) {
                                        if (is_array($listadoPermisos) && array_keys($listadoPermisos) !== range(0, count($listadoPermisos) - 1)) {
                                            // Envolver el array en otro array
                                            $datos = array($listadoPermisos);
                                        } else {
                                            $datos = $listadoPermisos;
                                        }

                                        foreach ($datos as $fila) {
                                    ?>
                                            <tr>
                                                <td><?= $fila['nro'] ?></td>
                                                <td><?= $fila['abrev'] ?></td>
                                                <td><?= $fila['nombre'] ?></td>
                                                <td><?= $fila['nombres'] ?></td>
                                                <td><?= $fila['creacion'] ?></td>

                                                <td><button type="button" class="btn btn-block bg-gradient-danger" data-toggle="modal" data-target="#modal-danger-<?= $fila['nro'] ?>-<?= $fila['iduser'] ?>">Dar de baja</button></td>
                                                <div class="modal fade" id="modal-danger-<?= $fila['nro'] ?>-<?= $fila['iduser'] ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Dar de Baja</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= Route::route('dar_baja_permiso', 'POST') ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="nro" value="<?= $fila['nro'] ?>">
                                                                    <input type="hidden" name="iduser" value="<?= $fila['iduser'] ?>">
                                                                    Estas seguro que quieres darle de baja al permiso <?= $fila['nombre'] ?> para el usuario (a) <?= $fila['nombres'] ?>
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
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">

                        <div class="card-body">
                            <form id="registrar-form" action="#" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Usuario Activos</label>
                                            <select class="form-control select2" id="id_usuario" style="width: 100%;">
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
                                                        <option value="<?= $fila['id'] ?>"><?= $fila['nombres'] ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control" id="id_estado" style="width: 100%;">
                                                <option value="AC">Activo</option>
                                                <option value="NA">No Activar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre_funcionario">Pemisos de:</label>
                                            <select class="form-control" id="id_Permiso" style="width: 100%;">
                                                <option value="date">Seleccione una opcion de usuario</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" id="registrar" class="btn btn-block btn-primary btn-lg">Registrar</button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //loadMissingPermissions();
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
    });
</script>

<script>
    var id_usuario = $('#id_usuario').val();
    $(document).ready(function() {
        $('.select2').change(function() {
            id_usuario = $(this).val();
            var formData = {
                idUser: id_usuario
            };
            $.ajax({
                type: 'POST', // Método HTTP de la solicitud
                url: "<?= Route::route('mostrar_permisos_faltantes', 'POST') ?>", // URL a la que se enviarán los datos
                data: formData, // Datos a enviar
                success: function(response) {
                    if (response.success) {
                        var datosArray = Array.isArray(response.datos) ? response.datos : (response.datos ? [response.datos] : []);
                        if (datosArray.length > 0) {
                            // Limpiar opciones existentes
                            $('#id_Permiso').empty();
                            // Iterar sobre los datos y agregar opciones
                            $.each(datosArray, function(index, value) {
                                $('#id_Permiso').append('<option value="' + value.nro + '">' + value.nombre + '</option>');
                            });
                            // Habilitar el botón de Registrar
                            $('#registrar').prop('disabled', false);
                        } else {
                            // Si no hay datos o es un arreglo vacío, mostrar mensaje de alerta
                            $('#id_Permiso').empty();
                            $('#id_Permiso').append('<option value="date"> YA TIENES TODOS LOS PERMISOS </option>');
                            // Deshabilitar el botón de Registrar
                            $('#registrar').prop('disabled', true);
                        }
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
<script>
    var estado = $('#id_estado').find('option:first').val();
    //para detectar cual sera el estado
    $('#id_estado').change(function() {
        estado = $(this).val();
    });

    $('#registrar-form').submit(function(e) {
        e.preventDefault(); // Evita el envío del formulario por defecto
        // Objeto con los datos a enviar
        var id_permiso = $('#id_Permiso').val();

        var formData = {
            idUser: id_usuario,
            idPermiso: id_permiso,
            estado: estado,
        };

        $.ajax({
            type: 'POST', // Método HTTP de la solicitud
            url: "<?= Route::route('registrar_permiso', 'POST') ?>", // URL a la que se enviarán los datos
            data: formData, // Datos a enviar
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    window.location.href = "<?= Route::route('permisos', 'GET') ?>";
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Se produjo un error al procesar su solicitud. Por favor, inténtelo de nuevo más tarde.');
            }
        });

    });
</script>