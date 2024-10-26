<?php

use lib\Route;

$datos = Route::enrutador(); // Obtiene todas las rutas


$ControllerBackend = [];
$ControllerFrontend = [];

// Recorremos las rutas obtenidas
foreach ($datos as $method => $routes) {
    foreach ($routes as $key => $value) {
        // Verificamos si hay callback definido
        if (isset($value['callback']) && is_array($value['callback']) && isset($value['callback'][1])) {
            $callbackMethod = $value['callback'][1]; // Obtenemos el segundo elemento del callback
            $controllerName = $value['callback'][0]; // Obtenemos el nombre del controlador

            // Extraemos el nombre de la clase del controlador (ej. UsuariosController)
            $controllerSimpleName = (new \ReflectionClass($controllerName))->getShortName();

            // Verificamos si el callback corresponde a un controlador backend
            if (
                strpos($controllerName, 'lib\src\Controllers\\') === 0 ||
                strpos($key, 'panelConfiguration/website/administrador') === 0
            ) {
                // Si el controlador no existe, inicializamos un array
                if (!isset($ControllerBackend[$controllerName])) {
                    $ControllerBackend[$controllerName] = [
                        'nombre' => $controllerSimpleName,
                        'ubicacion' => $controllerName, // Agregamos la ubicación
                        'metodos' => [],
                    ];
                }
                // Agregamos el método al controlador correspondiente
                $ControllerBackend[$controllerName]['metodos'][] = $callbackMethod;
            } else {
                // Si el controlador no existe, inicializamos un array
                if (!isset($ControllerFrontend[$controllerName])) {
                    $ControllerFrontend[$controllerName] = [
                        'nombre' => $controllerSimpleName,
                        'ubicacion' => $controllerName, // Agregamos la ubicación
                        'metodos' => [],
                    ];
                }
                // Agregamos el método al controlador correspondiente
                $ControllerFrontend[$controllerName]['metodos'][] = $callbackMethod;
            }
        }
    }
}

$controllerBackendJson = json_encode($ControllerBackend);
$controllerFrontendJson = json_encode($ControllerFrontend);

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
                            <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Listar Controladores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Crear nuevo</a>
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
                                                            <h5 class="card-title text-center">Area de Backend</h5>
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
                                                                        <th scope="col">Nombre</th>
                                                                        <th scope="col">ubicacion</th>
                                                                        <th scope="col">cantidad Metodos</th>
                                                                        <th scope="col">Detalle</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($ControllerBackend as $controller) { ?>
                                                                        <tr>
                                                                            <th scope="row"><?= $controller['nombre'] ?></th>
                                                                            <td><?= $controller['ubicacion'] ?></td>
                                                                            <td><?= count($controller['metodos']) ?></td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-warning editar-ubicacion" data-id="2">Editar</button>
                                                                                <button type="button" class="btn btn-danger eliminar-ubicacion">Eliminar</button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title text-center">Area de desarrollador</h5>

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
                                                                        <th scope="col">NombreController</th>
                                                                        <th scope="col">ubicacion</th>
                                                                        <th scope="col">Cantidad Metodos</th>
                                                                        <th scope="col">Detalle</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($ControllerFrontend as $controller) { ?>
                                                                        <tr>
                                                                            <th scope="row"><?= $controller['nombre'] ?></th>
                                                                            <td><?= $controller['ubicacion'] ?></td>
                                                                            <td><?= count($controller['metodos']) ?></td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-warning editar-ubicacion" data-id="2">Editar</button>
                                                                                <button type="button" class="btn btn-danger eliminar-ubicacion">Eliminar</button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
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
                                                    <h4>Registrar nuevo Controlador</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="registrar_controlador">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Nombre de Controlador</label>
                                                                            <input id="name" type="text" class="form-control" placeholder="ej: UserController ..." required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Area de Desarrollo</label>
                                                                            <select class="form-control" id="area_desarrollo">
                                                                                <option value="1" selected>Frontend => App/Controllers</option>
                                                                                <option value="2">Backend => lib/src/Controllers</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Registrar Controlador</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <h4>Registrar nuevo Metodo al controlador</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="registrar_metodo">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Area de Desarrollo</label>
                                                                            <select class="form-control" id="desarrollo">
                                                                                <option value="1" selected>Frontend => App/Controllers</option>
                                                                                <option value="2">Backend => lib/src/Controllers</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Identifique el Controlador</label>
                                                                            <select class="form-control" id="controlador">
                                                                                <!-- Las opciones se generarán dinámicamente aquí -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Nombre del Metodo</label>
                                                                            <input id="metodo" type="text" class="form-control" placeholder="ej: loguear ..." required="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Indique la URI</label>
                                                                            <input id="uri" type="text" class="form-control" placeholder="ej: /Area-de-trabajo ..." required="">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Indique el Metodo</label>
                                                                            <select class="form-control" id="tipo">
                                                                                <option value="get" selected>GET</option>
                                                                                <option value="post">POST</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Registrar nuevo metodo</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <h4>Mostrar contenido del metodo</h4>
                                                    <div class="card card-info">
                                                        <div class="card-body">
                                                            <form id="mostrar_metodo_controlador">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label>Area de Desarrollo</label>
                                                                            <select class="form-control" id="desarrollo1">
                                                                                <option value="1" selected>Frontend => App/Controllers</option>
                                                                                <option value="2">Backend => lib/src/Controllers</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label>Identifique el Controlador</label>
                                                                            <select class="form-control" id="controlador1">
                                                                                <!-- Las opciones se generarán dinámicamente aquí -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label>Identifique el Metodo</label>
                                                                            <select class="form-control" id="metodo_controller">
                                                                                <!-- Las opciones se generarán dinámicamente aquí -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for=""></label>
                                                                            <button type="submit" class="btn btn-info btn-block">Mostrar metodo</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div id="mostrar_metodo"></div>

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

        var ControllerBackend = <?= $controllerBackendJson ?>;
        var ControllerFrontend = <?= $controllerFrontendJson ?>;
        var controladores; // Declarar variable global para controladores

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

        $("#registrar_controlador").on("submit", function(e) {
            e.preventDefault();
            var formData = {
                controlador: $("#name").val(),
                desarrollo: $("#area_desarrollo").val()
            }
            //console.log(formData);

            $.ajax({
                type: 'POST',
                url: "<?= Route::route('backend.controlador.registrar', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = "<?= lib\Route::route('backend.controlador') ?>";
                    } else {
                        showNotification('error', response.sms);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });

        });

        $('#desarrollo').change(function() {
            const desarrolloSeleccionado = $(this).val();
            const placeholders = {
                1: 'Ej: /Area-de-trabajo...',
                2: 'Ej: /panelConfiguration/website/administrador/dashboard...'
            };
            $('#uri').attr('placeholder', placeholders[desarrolloSeleccionado]);
            // Limpiar el select de controladores
            $('#controlador').empty();
            // Hacer la llamada AJAX para obtener los controladores
            $.ajax({
                url: "<?= Route::route('backend.controlador.listarControlador') ?>",
                type: 'GET',
                data: {
                    desarrollo: desarrolloSeleccionado
                },
                success: function(data) {
                    // Agregar las nuevas opciones al select de controladores
                    data.forEach(function(controlador) {
                        $('#controlador').append(new Option(controlador.text, controlador.value));
                    });
                },
                error: function() {
                    console.error('Error al obtener los controladores.');
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });
        });

        // Disparar el evento change al cargar la página para inicializar el controlador
        $('#desarrollo').change();


        $("#registrar_metodo").on("submit", function(e) {
            e.preventDefault();

            var metodo = $("#metodo").val();
            var regex = /^[\w]+$/; // Solo permite letras, números y guiones bajos

            if (!regex.test(metodo)) {
                alert("El método debe ser una sola palabra (letras, números o guiones bajos).");
                return; // Detiene el envío del formulario
            }

            var desarrolloSeleccionado = parseInt($("#desarrollo").val(), 10); // Convierte a entero

            // Determina qué conjunto de controladores usar
            var controladores = desarrolloSeleccionado === 1 ? ControllerFrontend : ControllerBackend;

            var controladorEncontrado = false;
            var metodoExistente = false;

            // Iterar sobre los controladores
            for (var controlador in controladores) {
                // Verifica si el nombre del controlador coincide
                if (controladores[controlador].nombre === $("#controlador").val()) {
                    controladorEncontrado = true;

                    // Verificar si el método ya está en la lista de métodos
                    metodoExistente = controladores[controlador].metodos.includes(metodo);
                    break; // Salir del bucle ya que encontramos el controlador
                }
            }
            var sw = false;

            // Verificar si el controlador existe y si el método no está en la lista
            if (!controladorEncontrado) {
                sw = true;
            } else if (metodoExistente) {
                alert("El método ya existe para este controlador.");
            } else {
                sw = true;
            }
            if (sw) {
                // Aquí puedes continuar con el procesamiento de formData...
                var formData = {
                    desarrollo: desarrolloSeleccionado,
                    controlador: $("#controlador").val(),
                    metodo: metodo,
                    uri: $("#uri").val(),
                    tipo: $("#tipo").val(),
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: "<?= Route::route('backend.controlador.registrar.metodo', 'POST') ?>",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= lib\Route::route('backend.controlador') ?>";
                        } else {
                            showNotification('error', response.sms);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Detalles del error:", xhr.responseText); // Añade esta línea para ver el error exacto
                        showNotification('error', 'Se produjo un error al procesar su solicitud.');
                    }
                });
            }

        });


        $('#desarrollo1').change(function() {
            const desarrolloSeleccionado = $(this).val();
            // Determina qué conjunto de controladores usar
            controladores = desarrolloSeleccionado == 1 ? ControllerFrontend : ControllerBackend; // Asigna a la variable global

            $('#controlador1').empty();
            $.each(controladores, function(key, controlador) {
                $('#controlador1').append(new Option(controlador.nombre, controlador.nombre));
            });

            // Limpiar el select de métodos al cambiar de desarrollo
            $('#metodo_controller').empty();

            // Disparar el evento change para inicializar métodos del primer controlador
            $('#controlador1').change();
        });

        // Manejador único para controlador1
        $('#controlador1').change(function() {
            var controladorSeleccionado = $(this).val();

            // Limpiar el select de métodos
            $('#metodo_controller').empty();

            var controladorData = Object.values(controladores).find(function(ctrl) {
                return ctrl.nombre === controladorSeleccionado;
            });

            if (controladorData) {
                var metodos = controladorData.metodos;
                $.each(metodos, function(index, nombre_metodo) {
                    $('#metodo_controller').append(new Option(nombre_metodo, nombre_metodo));
                });
            } else {
                console.error("Controlador no encontrado:", controladorSeleccionado);
            }
        });

        // Disparar el evento change al cargar la página para inicializar el controlador
        $('#desarrollo1').change();

        $("#mostrar_metodo_controlador").on("submit", function(e) {
            e.preventDefault();
            var formData = {
                desarrollo: $("#desarrollo1").val(),
                controlador: $("#controlador1").val(),
                metodo: $("#metodo_controller").val()
            }
            console.log(formData);

            $.ajax({
                type: 'POST',
                url: "<?= Route::route('backend.controlador.mostrar_metodo', 'POST') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.sms);
                        $('#mostrar_metodo').empty();

                        // Establecer el estilo del div
                        $('#mostrar_metodo').css({
                            'border': '1px solid #ccc', // Borde del rectángulo
                            'background-color': '#1e1e1e', // Color de fondo similar a una consola
                            'color': '#ffffff', // Color del texto
                            'padding': '15px', // Espacio interno
                            'font-family': 'consolas', // Fuente de estilo consola
                            'max-height': '350px', // Altura máxima del div
                        });

                        // Agregar el nuevo contenido
                        $('#mostrar_metodo').html(response.sms);


                        // Si deseas mantener el contenido visible, puedes desplazar el scroll hacia abajo
                        $('#mostrar_metodo').scrollTop($('#mostrar_metodo')[0].scrollHeight);

                    } else {
                        showNotification('error', response.sms);
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