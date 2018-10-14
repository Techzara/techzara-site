$(function() {
    $('.datetimepicker_date_debut').datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY HH:mm'
    });
    $('.datetimepicker_date_fin').datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY HH:mm',
        useCurrent: false //Important! See issue #1075
    });

    $(".datetimepicker_date_debut").on("dp.change", function (e) {
        $('.datetimepicker_date_fin').data("DateTimePicker").minDate(e.date);
    });
    $(".datetimepicker_date_fin").on("dp.change", function (e) {
        $('.datetimepicker_date_debut').data("DateTimePicker").maxDate(e.date);
    });
});