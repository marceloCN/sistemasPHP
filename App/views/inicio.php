<?php

use lib\Route;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <title>Area de Sistemas</title>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body class="login-page" style="min-height: 496.8px;">
    <div class="login-box">
        <div class="login-logo">
            <a href="">Area de Sistemas</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Logueate con tus credenciales del SIM2024</p>

                <form id="verificar_credenciales" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="login de SIM">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="recordarme" id="remember">
                                <label for="remember">
                                    Recordar credenciales
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#verificar_credenciales').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serializeArray();

                var dataObject = {};
                $.each(formData, function(index, item) {
                    dataObject[item.name] = item.value;
                });
                $.ajax({
                    type: 'POST',
                    url: "<?= Route::route('verificar_credenciales', 'POST') ?>",
                    data: dataObject,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "<?= Route::route('dashboard') ?>";
                        } else {
                            showNotification('error', response.sms);
                        }
                    },
                    error: function(xhr, status, error) {
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
</body>

</html>


</script>


</body>

</html>