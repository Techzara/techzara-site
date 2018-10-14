$(function(){
    $('#id-lv-piece-jointe').MultiFile();
});

$("#tz_service_metiermanagerbundle_service_client_lvService").change(function() {
    // Chargement
    var _loading  = '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>';
    $("#id-loading-service-option").html(_loading);

    $.ajax({
        type: "POST",
        url: _url_list_service_option_ajax,
        data: {
            id_service: $(this).val(),
        },
        cache: false,
        success: function(_response) {
            $("#id-loading-service-option").html('');
            $("#id-form-service-option").removeClass('hide');
            $("#tz_service_metiermanagerbundle_service_client_lvServiceOptions").empty();
            $.each(_response, function(k, v) {
                var option = '<option value="' + v.id + '">' + v.srvOptLabel + '</option>';
                $("#tz_service_metiermanagerbundle_service_client_lvServiceOptions").append(option);
            });
        }
    });

    var _data_post  = {
        id_service : $(this).val(),
        nbr_page_integrer : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").val(),
        nbr_page_decline : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").val(),
        service_option : $('#tz_service_metiermanagerbundle_service_client_lvServiceOptions').select2().val()
    };
    ajaxPrix(_data_post);
});

$("#tz_service_metiermanagerbundle_service_client_lvServiceOptions").on("select2:select", function (e) {
    var _select_val = $(e.currentTarget).val();
    var _data_post  = {
        id_service : $("#tz_service_metiermanagerbundle_service_client_lvService").val(),
        nbr_page_integrer : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").val(),
        nbr_page_decline : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").val(),
        service_option : _select_val
    };
    ajaxPrix(_data_post);
});

$("#tz_service_metiermanagerbundle_service_client_lvServiceOptions").on("select2:unselect", function (e) {
    var _select_val = $(e.currentTarget).val();
    var _data_post  = {
        id_service : $("#tz_service_metiermanagerbundle_service_client_lvService").val(),
        nbr_page_integrer : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").val(),
        nbr_page_decline : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").val(),
        service_option : _select_val
    };
    ajaxPrix(_data_post);
});

$("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").change(function() {
    var _data_post  = {
        id_service : $("#tz_service_metiermanagerbundle_service_client_lvService").val(),
        nbr_page_integrer : $(this).val(),
        nbr_page_decline : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").val(),
        service_option : $('#tz_service_metiermanagerbundle_service_client_lvServiceOptions').select2().val()
    };
    ajaxPrix(_data_post);
});

$("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").change(function() {
    var _data_post  = {
        id_service : $("#tz_service_metiermanagerbundle_service_client_lvService").val(),
        nbr_page_integrer : $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").val(),
        nbr_page_decline : $(this).val(),
        service_option : $('#tz_service_metiermanagerbundle_service_client_lvServiceOptions').select2().val()
    };
    ajaxPrix(_data_post);
});

$("#id-form-service-client").submit(function( event ) {
    var _val_page_integrer = $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").val();
    if (isNaN(parseInt(_val_page_integrer)) || parseInt(_val_page_integrer) < 1) {
        $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPage").focus();
        return false;
    }

    var _val_page_decline  = $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").val();
    if (_val_page_decline != "") {
        if (isNaN(parseInt(_val_page_decline)) || ((parseInt(_val_page_integrer) - 1) < parseInt(_val_page_decline))) {
            $("#tz_service_metiermanagerbundle_service_client_srvCltNbrPageDecline").focus();
            return false;
        }
    }

    // var _file = document.getElementById("id-lv-piece-jointe").files[0];
    // if (_file) {
    //     var _file_size = _file.size;
    //     if (_file_size > 1000000 ) {
    //         alert('Maximum upload : 1MO');
    //         return false;
    //     }
    // }
});

function ajaxPrix(_data_post) {
    $.ajax({
        type: "POST",
        url: _url_prix_commande_ajax,
        data: _data_post,
        cache: false,
        success: function(_response) {
            $("#tz_service_metiermanagerbundle_service_client_srvCltPrix").val(_response);
        }
    });
}