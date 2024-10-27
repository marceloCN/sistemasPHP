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
            url: verificarCredencialesUrl, // Usa la variable definida en PHP
            data: dataObject,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = dashboardUrl; // Usa la variable definida en PHP
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
