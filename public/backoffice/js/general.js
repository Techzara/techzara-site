/**
 * Javascript général
 */
$(function() {
    // Plugins select2
    $(".select2").select2();

    // Datetimepicker
    $(".datetimepicker").datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY HH:mm'
    });
    $(".datetimepicker-min-now").datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY HH:mm',
        minDate: moment()
    });

    // Confirmation suppression
    $('body').delegate('.delete-btn-custom, .remove-elt', 'click', function(){
        if( !confirm('Etes vous sûr de vouloir supprimer ?') )
            return false;
    });
    $('body').delegate('form .delete-btn', 'click', function(){
        var length_checked = $('[name="delete[]"]:checked').length;
        if (length_checked == 0) {
            alert('Veuillez sélectionner un élément à supprimer');
            return false;
        } else {
            if( !confirm('Etes vous sûr de vouloir supprimer ?') )
                return false;
        }
    });

    // Supprimer la classe Error séléctionnée
    $("input").focus(function() {
        $(this).parents('.form-group').removeClass('has-error');
    });
    $("select").focus(function() {
        $(this).parents('.form-group').removeClass('has-error');
    });
    $("textarea").focus(function() {
        $(this).parents('.form-group').removeClass('has-error');
    });
});

/*
 * Mettre une erreur sur le champ spécifique
 */
function setErrorClass($this){
    $this.parents('.form-group').addClass('has-error');
}