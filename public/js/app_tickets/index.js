$(document).ready(function () {
    $('select').select2({
        width: '100%',
        language: 'es'
    });
    //Mandamos recargar la tabla cuando cambiemos la selección del Select
    $(".select2").on("change", function () {
        $('.buttons-reload').click();
    });

    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.type = $("#txtType").val();
    });

    $(document).on('click', '.show-detail-image', function () {
        $("#image-detail").modal('show');
        $("#image-detail-img").attr('src', $(this).attr('src'));
    });
});