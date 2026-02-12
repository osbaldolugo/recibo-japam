$(document).ready(function () {
    $('#txtTitle').on('keyup', function (e) {
        $('#textTitle').text($(this).val());
    });
    $('#txtDescription').on('keyup', function (e) {
        $('#textDescription').text($(this).val());
    });

    $('#txtUrl').on('change', function (e) {
        var url = $(this).val();
        url.length > 0 ? $('#divMoreInfo').show() : $('#divMoreInfo').hide();

        $('#divMoreInfo > a').attr('href', url);
    });
});