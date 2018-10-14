$(function () {
    $('body').delegate('.kl-send-email-paiement', 'click', function(){
        var _id_service_client = $(this).attr('id-service-client');

        bootbox.confirm({
            message: "Voulez-vous envoyer par email la confirmation du paiement ?",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Oui'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> Non'
                }
            },
            callback: function (result) {
                if (result) {
                    // Chargement
                    var _loading = "<b>Chargement...</b>";
                    $("#id-service-client-paiement-" + _id_service_client).html(_loading);

                    $.ajax({
                        url: _url_send_email_confirmation_paiement_ajax,
                        dataType: "json",
                        data: {
                            id_service_client: _id_service_client
                        },
                        type: "POST",
                        success: function (response) {
                            $("#id-service-client-paiement-" + _id_service_client).html('Payé et facturé');
                            bootbox.alert("Envoie email confirmation de paiement envoyé");
                        },
                        error: function(xhr, status, error) {
                            bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
                        }
                    });
                }
            }
        });
    });
})