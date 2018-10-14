$(function () {
    $('body').delegate('.kl-send-email-connexion', 'click', function(){
        var _id_service_client = $(this).attr('id-service-client');

        // Chargement
        var _loading = "<br><b>Envoie en cours...</b>";
        $("#id-service-client-send-email-" + _id_service_client).html(_loading);

        $.ajax({
            url: _url_send_email_connexion_ajax,
            dataType: "json",
            data: {
                id_service_client: _id_service_client
            },
            type: "POST",
            success: function (response) {
                $("#id-service-client-send-email-" + _id_service_client).html('');
                bootbox.alert("Le lien de connexion espace membre a été bien envoyé.");
            },
            error: function(xhr, status, error) {
                bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            }
        });
    });
})