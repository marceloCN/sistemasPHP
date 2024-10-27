$(document).ready(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    // Manejar mensajes de error
    if (mensajeError) {
        Toast.fire({
            icon: 'error',
            title: mensajeError
        });
    }

    // Manejar mensajes de éxito
    if (mensajeSuccess) {
        Toast.fire({
            icon: 'success',
            title: mensajeSuccess
        });
    }

    var inactividadTimer;

    function reiniciarTemporizador() {
        clearTimeout(inactividadTimer);
        inactividadTimer = setTimeout(function() {
            window.location.href = logoutUrl; // Usa la URL de logout desde PHP
        }, 20 * 60 * 1000); // 20 minutos en milisegundos
    }

    $(document).on('click keydown', function() {
        reiniciarTemporizador();
    });

    reiniciarTemporizador();
});
