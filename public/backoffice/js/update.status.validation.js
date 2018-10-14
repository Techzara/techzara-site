$(function () {
    $('body').delegate('.kl-service-client', 'click', function(){
        var _id_status         = $(this).attr('id-status');
        var _id_service_client = $(this).attr('id-service-client');

        // Autre que bon de commande
        if (_id_status != 1) {
            ajaxUpdateStatus(_id_status, _id_service_client);
        // Bon de commande
        } else {
            bootbox.confirm({
                message: "Voulez-vous envoyer le mail bon de commande ?",
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
                        ajaxUpdateStatus(_id_status, _id_service_client);
                    }
                }
            });
        }
    });

    /* Fichiers non conformes */
    $('body').delegate('.kl-cancel-service-client', 'click', function(){
        var _id_status         = $(this).attr('id-status');
        var _id_service_client = $(this).attr('id-service-client');

        $("#id-service-client").val(_id_service_client);
        $("#id-status").val(_id_status);

        $('#id-modal-form-comment').modal('show');
    });

    $("#id-modal-form-comment").submit(function( event ) {
        var _id_status         = $("#id-status").val();
        var _id_service_client = $("#id-service-client").val();
        var _comment           = $("#id-comment").val();

        // Chargement
        var _loading = "<i class='fa-li fa fa-spinner fa-spin'></i>";
        $("#id-loading").html(_loading);

        $.ajax({
            url: _url_cancel_status_validation_ajax,
            dataType: "json",
            data: {
                id_status: _id_status,
                id_service_client: _id_service_client,
                comment: _comment
            },
            type: "POST",
            success: function (response) {
                $('#id-modal-form-comment').modal('hide');
                $("#id-loading").html('');
                bootbox.alert("Statut modifié avec envoie mail fichiers non conformes");
                $("#id-service-client-" + _id_service_client).html(response.message);
            },
            error: function(xhr, status, error) {
                bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            }
        });

        event.preventDefault();
    });

    /* Projet finalisé */
    $('body').delegate('.kl-finalise-service-client', 'click', function(){
        var _id_status         = $(this).attr('id-status');
        var _id_service_client = $(this).attr('id-service-client');

        $("#id-service-client-finalise").val(_id_service_client);
        $("#id-status-finalise").val(_id_status);

        $('#id-modal-form-finalise').modal('show');
    });

    /* Projet lien livré */
    $('body').delegate('.kl-lien-livre-service-client', 'click', function(){
        var _id_status         = $(this).attr('id-status');
        var _id_service_client = $(this).attr('id-service-client');

        $("#id-service-client-lien-livre").val(_id_service_client);
        $("#id-status-lien-livre").val(_id_status);

        $('#id-modal-form-lien-livre').modal('show');
    });

    $("#id-modal-form-finalise").submit(function( event ) {
        var _id_status         = $("#id-status-finalise").val();
        var _id_service_client = $("#id-service-client-finalise").val();
        var _lien_code_source  = $("#id-lien-code-source").val();

        // Chargement
        var _loading = "<i class='fa-li fa fa-spinner fa-spin'></i>";
        $("#id-loading-finalise").html(_loading);

        $.ajax({
            url: _url_finalise_status_validation_ajax,
            dataType: "json",
            data: {
                id_status: _id_status,
                id_service_client: _id_service_client,
                lien_code_source: _lien_code_source
            },
            type: "POST",
            success: function (response) {
                $('#id-modal-form-finalise').modal('hide');
                $("#id-loading-finalise").html('');
                bootbox.alert("Statut modifié avec envoie mail projet finalisé");
                $("#id-service-client-" + _id_service_client).html(response.message);
            },
            error: function(xhr, status, error) {
                bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            }
        });

        event.preventDefault();
    });

    $("#id-modal-form-lien-livre").submit(function( event ) {
        var _id_status         = $("#id-status-lien-livre").val();
        var _id_service_client = $("#id-service-client-lien-livre").val();
        var _lien_livre        = $("#id-lien-livre").val();

        // Chargement
        var _loading = "<i class='fa-li fa fa-spinner fa-spin'></i>";
        $("#id-loading-lien-livre").html(_loading);

        $.ajax({
            url: _url_lien_livre_status_validation_ajax,
            dataType: "json",
            data: {
                id_status: _id_status,
                id_service_client: _id_service_client,
                lien_livre: _lien_livre
            },
            type: "POST",
            success: function (response) {
                $('#id-modal-form-lien-livre').modal('hide');
                $("#id-loading-lien-livre").html('');
                bootbox.alert("Statut modifié avec envoie mail lien livré");
                $("#id-service-client-" + _id_service_client).html(response.message);
            },
            error: function(xhr, status, error) {
                bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            }
        });

        event.preventDefault();
    });
})

function ajaxUpdateStatus(_id_status, _id_service_client) {
    // Chargement
    var _loading = "<b>Chargement...</b>";
    $("#id-service-client-" + _id_service_client).html(_loading);

    $.ajax({
        url: _url_update_status_validation_ajax,
        dataType: "json",
        data: {
            id_status: _id_status,
            id_service_client: _id_service_client
        },
        type: "POST",
        success: function (response) {
            $("#id-service-client-" + _id_service_client).html(response.message);
            if (_id_status == 1)
                bootbox.alert("Statut modifié avec envoie mail bon de commande");
        },
        error: function(xhr, status, error) {
            bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            var _error_message = "<b style='color: red'>Erreur</b>";
            $("#id-service-client-" + _id_service_client).html(_error_message);
        }
    });
}