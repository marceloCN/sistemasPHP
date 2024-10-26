<?php

use lib\Route;
use App\Models\Validacion;
use App\Models\Direccion;

$validar = new Validacion();
$validaciones = $validar->listarSolicitudes();

$Direcciones = new Direccion();
$Direcciones = $Direcciones->select(['id', 'descripcion'], [], []);

?>
<section class="content">
    <div class="container-fluid">


        <div class="modal fade" id="modal-xl" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title titulo-codigo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
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

        <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title titulo-codigo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Código</th>
                                    <td id="modal-codigo"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Fecha y Hora</th>
                                    <td id="modal-fecha"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Solicitud</th>
                                    <td id="modal-solicitud"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Remitente</th>
                                    <td id="modal-remitente"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Usuario Registrado</th>
                                    <td id="modal-usuario"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dirección Registrado</th>
                                    <td id="modal-direccion"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Usuario Revisión</th>
                                    <td id="modal-usuario-revision"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Estado Respuesta</th>
                                    <td id="modal-estado"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">Listado de solicitudes</h5>
                <div class="card-tools">

                    <div class="input-group input-group-sm" style="width: 150px;">
                        Filtrado por Estado:
                        <select id="estadoFiltro">
                            <option value="todos">Todos</option>
                            <option value="respondido">Respondido</option>
                            <option value="no_respondido">No Respondido</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 1000px;">
                <table class="table table-head-fixed text-nowrap" id="filtro_solicitud">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Fecha y Hora</th>
                            <th scope="col">Solicitud</th>
                            <th scope="col" class="estado-respuesta">Estado_respuesta</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($validaciones != null) {
                            foreach ($validaciones as $validacion) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $validacion['codigo'] ?></th>
                                    <td><?= $validacion['fecha_validacion'] ?></td>
                                    <td><?= $validacion['observacion'] ?></td>
                                    <td><?= $validacion['estado_respuesta'] ?></td>
                                    <td>
                                        <?php if (($validacion['estado_respuesta']) == "No Respondido") { ?>
                                            <button type="button" class="btn btn-danger responder-codigo" data-codigo="<?= $validacion['codigo'] ?>">Responder</button>
                                            <button type="button" class="btn btn-warning ver-codigo"
                                                data-codigo="<?= $validacion['codigo'] ?>"
                                                data-fecha="<?= $validacion['fecha_validacion'] ?>"
                                                data-solicitud="<?= $validacion['observacion'] ?>"
                                                data-remitente="<?= $validacion['remitente'] ?>"
                                                data-usuario="<?= $validacion['usuario_registrado'] ?>"
                                                data-direccion="<?= $validacion['direccion_registro'] ?>"
                                                data-usuario-revision="<?= $validacion['usuario_revision'] ?>"
                                                data-estado="<?= $validacion['estado_respuesta'] ?>">Ver</button>
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
</section>

<script>
    $(document).ready(function() {
        const $estadoFiltro = $('#estadoFiltro');
        const $filas = $('#filtro_solicitud tbody tr');
        const $estadoColHeader = $('.estado-respuesta'); // Encabezado de la columna

        $estadoFiltro.on('change', function() {
            const selectedValue = $(this).val();

            $filas.each(function() {
                const $fila = $(this);
                const estadoRespuesta = $fila.find('td:nth-child(4)').text(); // Obtener estado_respuesta

                if (selectedValue === 'todos') {
                    $fila.show(); // Mostrar todas las filas
                } else if (selectedValue === 'respondido' && estadoRespuesta === 'Respondido') {
                    $fila.show(); // Mostrar solo las filas respondidas
                } else if (selectedValue === 'no_respondido' && estadoRespuesta === 'No Respondido') {
                    $fila.show(); // Mostrar solo las filas no respondidas
                } else {
                    $fila.hide(); // Ocultar las filas que no coinciden
                }
            });

            // Ocultar la columna de estado_respuesta y su encabezado si se filtra
            if (selectedValue === 'respondido' || selectedValue === 'no_respondido') {
                $filas.each(function() {
                    $(this).find('td:nth-child(4)').hide(); // Ocultar la celda
                });
                $estadoColHeader.hide(); // Ocultar el encabezado
            } else {
                $filas.each(function() {
                    $(this).find('td:nth-child(4)').show(); // Mostrar la celda
                });
                $estadoColHeader.show(); // Mostrar el encabezado
            }
        });

        $(".responder-codigo").on("click", function() {
            var direcciones = <?php echo json_encode($Direcciones); ?>;
            var codigo = $(this).data("codigo");

            var formHtml = `
            <form id="responderSolicitud" method="POST">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Direccion destino</label>
                            <select class="form-control" id="direccion_destino" name="direccion_destino">
                                <option value="">Selecciona una dirección</option>`;
            $.each(direcciones, function(index, direccion) {
                formHtml += `<option value="${direccion.id}">${direccion.descripcion}</option>`;
            });

            formHtml += `                   
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Personal destino</label>
                            <select class="form-control" id="personal_destino" name="personal_destino">
                                <option value="">Selecciona un personal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nota</label>
                            <input type="text" name="nota" class="form-control" placeholder="descripcion de la solicitud respondida ..." required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Estado de tramite</label>
                            <select class="form-control" name="estado_tramite" required>
                                    <option value="2" select>REVISADO</option>
                                    <option value="3">OBSERVADO</option>
                                    <option value="4">RECHAZADO</option>
                                    <option value="5">FINALIZADO</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12 modal-footer justify-content-between">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-warning" type="submit">Responder</button>
                    </div>
                </div>
            </form>
    
            `;

            $('#modal-xl .titulo-codigo').text('Responder al tramite: ' + codigo);
            $('#modal-xl .modal-body').html(formHtml);
            $('#modal-xl').modal('show');

            // Manejar el cambio en direccion_destino
            $('#modal-xl').on('change', '#direccion_destino', function() {
                var direccionId = $(this).val(); // Obtén el valor seleccionado

                if (direccionId) {
                    // Crea la URL utilizando el id de dirección
                    //console.log("<?= Route::route('personal_por_direccion') ?>".replace('{id}', direccionId));
                    //console.log("/Area-de-trabajo/Solicitudes-recepcionadas/personal_por_direccion/" + direccionId);

                    $.ajax({
                        type: 'GET',
                        url: "<?= Route::route('personal_por_direccion') ?>".replace('{id}', direccionId), // Usa la URL construida
                        data: {
                            id: direccionId
                        },
                        dataType: 'json',
                        success: function(data) {

                            var personalSelect = $('#personal_destino');
                            personalSelect.empty(); // Limpia las opciones actuales
                            personalSelect.append('<option value="">Selecciona un personal</option>'); // Opción por defecto

                            // Rellena el select con los datos recibidos
                            $.each(data.data, function(index, personal) {
                                personalSelect.append(`<option value="${personal.id}">${personal.nombres}</option>`);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los datos:', error);
                            console.log(xhr.responseText); // Muestra el texto de la respuesta del servidor para depuración
                        }
                    });
                } else {
                    // Si no hay dirección seleccionada, limpia el select de personal
                    $('#personal_destino').empty().append('<option value="">Selecciona un personal</option>');
                }
            });

            $('#modal-xl').off('submit', '#responderSolicitud').on('submit', '#responderSolicitud', function(event) {
                event.preventDefault();

                var formData = $(this).serializeArray();

                var dataObject = {};
                $.each(formData, function(index, item) {
                    dataObject[item.name] = item.value;
                });
                dataObject["codigo"] = codigo;
                console.log(dataObject);

                $.ajax({
                    type: 'POST',
                    url: "<?= Route::route('responder_solicitud', 'POST') ?>", // Cambia esto por la ruta correcta
                    data: dataObject,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= Route::route('solicitud_recepcionada_listar') ?>";
                        } else {
                            showNotification('error', response.sms);
                        }
                        console.log(response.sms);

                    },
                    error: function(xhr, status, error) {
                        console.error('Error al procesar la solicitud:', error);
                        alert('Se produjo un error al procesar su solicitud.');
                    }
                });

            });
        });

        $(".ver-codigo").on("click", function() {

            var codigo = $(this).data("codigo");
            var fecha = $(this).data("fecha");
            var solicitud = $(this).data("solicitud");
            var remitente = $(this).data("remitente");
            var usuario = $(this).data("usuario");
            var direccion = $(this).data("direccion");
            var usuario_revision = $(this).data("usuario-revision");
            var estado = $(this).data("estado");


            $('#modal-lg .titulo-codigo').text('Detalle de tramite: ' + codigo);

            const $fila = $(this).closest('tr');
            $('#modal-codigo').text(codigo);
            $('#modal-fecha').text(fecha);
            $('#modal-solicitud').text(solicitud);
            $('#modal-remitente').text(remitente);
            $('#modal-usuario').text(usuario);
            $('#modal-direccion').text(direccion);
            $('#modal-usuario-revision').text(usuario_revision);
            $('#modal-estado').text(estado);

            $('#modal-lg').modal('show');
        });



    });
</script>