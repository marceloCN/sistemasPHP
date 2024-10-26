<?php

use lib\Route;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Iniciar Sesión</title>

    {head}

    {link}

</head>

<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= Route::route('backend.inicio') ?>" class="h1"><b>webSite</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Ingresa tu credenciales de administracion</p>

                <form id="login-form" action="#" method="post">
                    <div class="input-group mb-3">
                        <input type="text" id="login" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recordarme
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

                <p class="mb-1">
                    <a href="forgot-password.html">Olvidaste tu contraseña?</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    {src}

</body>

</html>

<script>
    $(document).ready(function() {
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                login: $('#login').val(),
                password: $('#password').val(),
                remember: $('#remember').is(':checked')
            }
            $.ajax({
                type: 'POST',
                url: "<?= Route::route('backend.verificar') ?>",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.sms);
                        window.location.href = "<?= Route::route('backend.dashboard') ?>";
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: response.sms,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    showNotification('error', 'Se produjo un error al procesar su solicitud.');
                }
            });
        });
    });
</script>