var uri = $('#page').data('url');

$(document).ready(function ()
{
    $('.img-color').attr('src', uri+'/img/app_settings/power-grey.png');
    $('#container-status').html('<i class="fa fa-spinner fa-pulse fa-fw f-s-18"></i>');

    getStatus();

    $(document).on("click", "#btn-power", function () {
        $('input[name=_method]').val('PATCH');

        updateStatus();
    });
});

function getStatus()
{
    var params = {
        type: 'GET',
        url: uri+'/appSettings/getPaymentStatus',
        form: null
    };
    $.ajaxStatus(params);
}

function updateStatus()
{
    var params = {
        type: 'POST',
        url: uri+'/appSettings/1',
        form: 'formSettings'
    };
    $.ajaxStatus(params);
}

$.ajaxStatus = function ($params) {
    var formData = $params.form !== null ? new FormData(document.getElementById($params.form)) : null;

    $.ajax({
        type: $params.type,
        url: $params.url,
        cache: false,
        contentType: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($('.loader-pay-control'), "Espere un momento...");
            $('#container-status').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        },
        data: formData,
        success: function (data) {
            var txtStatus = data.status === 'on' ? 'Pagos Activos' : 'Pagos Inactivos',
                icon = data.status === 'on' ? 'check bg-gradient-green-dark p-2' : 'close bg-gradient-red p-l-4 p-r-4 p-t-3 p-b-3' ;

            data.status === 'on'
                ? $('.img-color').attr('src', uri+'/img/app_settings/power-on.png')
                : $('.img-color').attr('src', uri+'/img/app_settings/power-off.png');

            $('input[name=status]').val(data.status);

            $("#container-status").html(
                '<span class="badge bg-gradient-black">\
                    <i class="fa rounded-corner fa-'+icon+'"></i> '
                    + txtStatus +
                '</span>'
            );

            $('.loader-pay-control').unblock();

            toastr.info(data.message, '<i class="fa fa-server"></i> Server Response');
        },
        error: function (error) {
            $('.loader-pay-control').unblock();

            var data = JSON.parse(error.responseText);

            toastr.error(data.message, '<i class="fa fa-server"></i> Server Response', {
                closeButton: true,
                timeOut: 4000,
                progressBar: true,
                allowHtml: true
            });
        }
    });
};