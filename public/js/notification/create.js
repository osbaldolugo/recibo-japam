$(document).ready(function () {
    var reader = new FileReader();

    $('#txtTitlePush').on('keyup', function () {
        $('#textTitlePush').text($(this).val());
    });

    $('#txtBodyPush').on('keyup', function (e) {
        $('#textBodyPush').text($(this).val());
    });


    $('#inputImgNotification').on('change', readFile);

    $('#datetimepickerBegin').datetimepicker({
        useCurrent: false,
        locale: 'es',
        format: 'YYYY/MM/DD',
        minDate: moment().toDate()
    });
    $('#datetimepickerEnd').datetimepicker({
        useCurrent: false,
        locale: 'es',
        format: 'YYYY/MM/DD',
        minDate: moment().add(1, 'days').toDate()
    });
    $("#datetimepickerBegin").on("dp.change", function (e) {
        $('#datetimepickerEnd').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerEnd").on("dp.change", function (e) {
        $('#datetimepickerBegin').data("DateTimePicker").maxDate(e.date);
    });

    $('#frmCreateNotification').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    }).on('form:submit', function(event) {
        reader.readAsDataURL(document.getElementById('inputImgNotification').files[0]);
        reader.onload = function (e) {
            var image = new Image();

            image.src = e.target.result;
            image.onload = function () {
                if (this.height == 1000 && this.width == 1135){
                    $.ajaxFormData({
                        type: 'POST',
                        url: $('#page').data('url')+'/notifications',
                        loadingSelector: $(".panel-body"),
                        form: 'frmCreateNotification',
                        crud: '<i class="fa fa-server"></i> Notificación',
                        successCallback: function (data) {
                            //$("#modal_app_slider_home").modal("hide");
                            //
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        },
                        errorCallback: function (error) {
                            //$('.close-modal-slider-home').click();
                        }
                    });
                } else {
                    toastr.error(
                        'Sólo se permiten imágenes con una resolución de 1135x1000 píxeles.',
                        '<i class="fa fa-image">&nbsp;</i>Resolución de imágen no permitido',
                        {timeOut: 7000, allowHtml: true}
                    );

                    return false;
                }
            }
        };
        return false; // Don't submit form for this demo
    });
});

function readFile()
{
    if (this.files && this.files[0]) {
        var FR= new FileReader();
        FR.addEventListener("load", function(e) {
            $('#imgNotification').attr('src',  e.target.result);
        });
        FR.readAsDataURL( this.files[0] );
    }
}
