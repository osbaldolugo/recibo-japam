$(document).ready(function () {
    /*
     * Edit Notification - Open Modal
     */
    $(document).on("click", ".btnEditNotification", function () {
        $('input[name=_method]').val('PATCH');
        $('input[name=id]').val($(this).data('id'));

        $('#imgNotification').attr('src', $(this).data('url_image'));
        $('#txtTitle').val($(this).data('title'));
        $('#txtDescription').val($(this).data('description'));
        $('#txtUrl').val($(this).data('url_info'));

        //set values to preview
        $('#textTitle').text($(this).data('title'));
        $('#textDescription').text($(this).data('description'));

        var url = $(this).data('url_info');
        url.length > 0 ? $('#divMoreInfo').show() : $('#divMoreInfo').hide();
        $('#divMoreInfo > a').attr('href', url);

        $("#modal_notification").modal("show");
    });

    /*
    * Update Notification
    * */
    $(document).on('click', '#btnUpdateNotification', function () {
        if ($('#frmUpdateNotification').parsley().validate("sliderHome"))
        {
            $.ajaxFormData({
                type: 'POST',
                url: $('#page').data('url')+'/notifications/'+$('input[name=id]').val(),
                loadingSelector: $(".loading-modal-notification"),
                form: 'frmUpdateNotification',
                crud: '<i class="fa fa-server"></i> Notificación',
                successCallback: function (data) {
                    $("#modal_notification").modal("hide");
                    $('.buttons-reload').click();
                },
                errorCallback: function (error) {
                    //$('.close-modal-slider-home').click();
                }
            });
            return false; // Don't submit form for this demo
        } else {
            return false;
        }
    });


    /*
     * Delete Notification - Open Bootbox
     */
    $(document).on('click', '.btnDeleteNotification', function () {
        var params = {
            question: '¿Eliminar notificación de forma permanente?',
            url: $('#page').data('url') + '/notifications/' + $(this).data('id'),
            loadingSelector: $('.panel-body'),
            crud: '<i class="fa fa-server"></i> Notificación',
            successCallback: function (data) {
                $('.buttons-reload').click();
            },
            errorCallback: function (error) {
                console.log('¡Error!', error);
            }
        };
        deleteAjax(params);
    });
});