$(function () {
    $('body').delegate('.kl-service-client', 'click', function(){
        var _id_status         = $(this).attr('id-status');
        var _id_service_client = $(this).attr('id-service-client');

        ajaxUpdateStatus(_id_status, _id_service_client);
    });
})

function ajaxUpdateStatus(_id_status, _id_service_client) {
    // Chargement
    var _loading = "<b>Chargement...</b>";
    $("#id-service-client-" + _id_service_client).html(_loading);

    $.ajax({
        url: _url_update_status_project_ajax,
        dataType: "json",
        data: {
            id_status: _id_status,
            id_service_client: _id_service_client
        },
        type: "POST",
        success: function (response) {
            $("#id-service-client-" + _id_service_client).html(response.message);
        }
    });
}