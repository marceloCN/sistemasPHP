<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {head}

    {link}

    {src}
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        {nav}

        {aside}


        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{title}</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= \lib\Route::route('dashboard', 'GET') ?>">Home</a></li>
                                <li class="breadcrumb-item active">{session}</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>

            <div class="content">
                {content}
            </div>
        </div>
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>designed by Ing. Marcelo Cruz Nogales</strong>
        </footer>


    </div>



    <?php if (isset($_SESSION[constant('APP')]['mensaje'])) { ?>
        <script>
            var mensajeError = '<?= $_SESSION[constant('APP')]['mensaje']; ?>';
            $(document).ready(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                });
                Toast.fire({
                    icon: 'error',
                    title: mensajeError
                });
            });
        </script>
    <?php }
    unset($_SESSION[constant('APP')]['mensaje']);
    ?>

    <?php if (isset($_SESSION[constant('APP')]['success'])) { ?>
        <script>
            var mensaje = '<?= $_SESSION[constant('APP')]['success']; ?>';
            $(document).ready(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                });
                Toast.fire({
                    icon: 'success',
                    title: mensaje
                });
            });
        </script>
    <?php }
    unset($_SESSION[constant('APP')]['success']);
    ?>
    <script>
        var inactividadTimer;

        function reiniciarTemporizador() {
            clearTimeout(inactividadTimer);
            inactividadTimer = setTimeout(function() {
                window.location.href = "<?= \lib\Route::route('logout', 'GET') ?>";
            }, 20 * 60 * 1000); // 20 minutos en milisegundos
        }

        $(document).on('click keydown', function() {
            reiniciarTemporizador();
        });

        $(document).ready(function() {
            reiniciarTemporizador();
        });
    </script>

</body>

</html>