$(document).ready(function () {
    var checkbox = document.querySelector('.js-switch'),
        switchery = new Switchery(checkbox, { size: 'large', color: '#4CD964' });

    sliderLoad();

    checkbox.onchange = function() {
        (checkbox.checked == true)
            ? $('#status').val('habilitada')
            : $('#status').val('deshabilitada');

        (checkbox.checked == true)
            ? $('#txtCheckbox').html('<span class="label label-success m-l-5"><i class="fa fa-check-circle">&nbsp;</i>Habilitada</span>')
            : $('#txtCheckbox').html('<span class="label label-danger m-l-5"><i class="fa fa-times-circle">&nbsp;</i>Deshabilitada</span>');
    };

    $('#txtCheckbox').html('<span class="label label-danger m-l-5"><i class="fa fa-times-circle">&nbsp;</i>Deshabilitada</span>');

    $('#input_image').on('change', readFile);

    //Add image
    $(document).on('click', '#btnAddImage', function () {
        $('input[name=_method]').val('POST');
        $("#imagePreviewContainer").hide();
        $("#deleteContainer").hide();
        $("#btnSaveImage").show();
        $("#btnUpdateStatus").hide();
        $("#inputImageContainer").show();
        $("#modal_app_slider_home").modal("show");

        return false;
    });

    //View details
    $(document).on('click', '#btnViewImage', function () {
        $('input[name=_method]').val('PATCH');
        getImage($(this).data('id'));

        return false;
    });

    //Save image
    $(document).on('click', '#btnSaveImage', function () {
        var reader = new FileReader(),
            inputImage = document.getElementById('input_image'),
            params = {
            type: 'POST',
            url: 'appSliderHomes',
            loadingSelector: $(".loading-modal-app-slider-home"),
            form: 'formAppSliderHome',
            crud: '<i class="fa fa-server"></i> Server Response',
            successCallback: function (data) {
                $("#modal_app_slider_home").modal("hide");
                location.reload();
            },
            errorCallback: function (error) {
                $('.close-modal-slider-home').click();
            }
        };

        if (true === $('form[name="formAppSlider"]').parsley().validate("sliderHome"))
        {
            reader.readAsDataURL(inputImage.files[0]);
            reader.onload = function (e) {
                var image = new Image();

                image.src = e.target.result;
                image.onload = function () {
                    var height = this.height,
                        width = this.width;

                    if (height >= 600 && width >= 1200 && width > height){
                        $.ajaxFormData(params);
                    } else {
                        toastr.error(
                            'Sólo se permiten imágenes con una resolución mínima de 1200x600 píxeles.',
                            '<i class="fa fa-image">&nbsp;</i>Resolución de imágen no permitido',
                            {timeOut: 6000, allowHtml: true}
                        );

                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    });

    //Update status
    $(document).on('click', '#btnUpdateStatus', function () {
        var method = $('input[name=_method]');
        var formData = new FormData(document.getElementById('formAppSliderHome'));

        $.ajax({
            type: 'POST',
            url: $("#page").data("url") + '/appSliderHomes/' + method.data('id'),
            contentType: false,
            processData: false,
            cache: false,
            headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
            beforeSend: function () {
                $.setLoading($(".loading-modal-app-slider-home"),"Actualizando...");
            },
            data: formData,
            success: function (data) {
                (data.message === null)
                    ? toastr.info('No realizó ningún cambio.', '<i class="fa fa-server"></i> Server Response')
                    : toastr.success(data.message, '<i class="fa fa-server"></i> Server Response');
                $('.buttons-reload').click();
                $(".loading-modal-app-slider-home").unblock();
            },
            error: function (error) {
                var data = JSON.parse(error.responseText);

                toastr.error(data.message, '<i class="fa fa-server"></i> Server Response', {closeButton: true, timeOut: 4000, allowHtml: true});
                $(".loading-modal-app-slider-home").unblock();
            }
        });
    });

    //Close modal
    $(document).on('click', '.close-modal-slider-home', function () {
        if ($('#status').val() == 'habilitada') {
            $('#elemCheckbox').click();
        }
        $('#formAppSliderHome').resetForm();
        $('form[name="formAppSlider"]').parsley().reset();
    });

    //Delete image
    $(document).on('click', '#deleteImage', function () {
        var params = {
            type: 'DELETE',
            url: 'appSliderHomes/'+$(this).data('id'),
            loadingSelector: $('.loading-modal-app-slider-home'),
            form: null,
            crud: '<i class="fa fa-server"></i> Server Response',
            successCallback: function (data) {
                $("#modal_app_slider_home").modal("hide");
                location.reload();
            },
            errorCallback: function (error) {
                $('.close-modal-slider-home').click();
            }
        };
        $.ajaxFormData(params);

        return false;
    });
});

function readFile()
{
    var extension = $('#input_image').val().split('.').pop();
    document.getElementById('imageFormat').value = extension;

    if (this.files && this.files[0]) {
        var FR= new FileReader();
        FR.addEventListener("load", function(e) {
            document.getElementById('image').value = e.target.result;
        });
        FR.readAsDataURL( this.files[0] );
    }
}

function sliderLoad() {
    var params = {
        type: 'GET',
        url: 'appSliderHomes/sliderLoad',
        loadingSelector: ('.loading-content-index-slider-home'),
        form: null,
        crud: '<i class="fa fa-server"></i> Server Response',
        successCallback: function (data) {
            $.each(data.images, function (title, value) {
                $(".owl-carousel").append(
                    "<div>\
                        <img src='"+value.image+"' style='height: 125px !important;'>\
                    </div>"
                );
            });

            $(".owl-carousel").owlCarousel({
                autoplay: true,
                autoplayTimeout: 3000,
                loop:true,
                margin:0,
                nav:false,
                responsive:{
                    0:{
                        items:1,
                        loop:true
                    },
                    600:{
                        items:1,
                        loop:true
                    },
                    1000:{
                        items:1,
                        loop:true
                    }
                },
                mouseDrag: true,
            });
        },
        errorCallback: function (error) {
            $(".owl-carousel").html(
                "<div>\
                    <img src='"+$("#page").data("url")+"/img/app_slider_home/default.png' style='height: 125px !important;'>\
                </div>"
            );

            $(".owl-carousel").owlCarousel({
                autoplay: false,
                autoplayTimeout: 3000,
                loop:false,
                margin:0,
                nav:false,
                responsive:{
                    0:{
                        items:1,
                        loop:true
                    },
                    600:{
                        items:1,
                        loop:true
                    },
                    1000:{
                        items:1,
                        loop:true
                    }
                },
                mouseDrag: true,
            });
        }
    };
    $.ajaxFormData(params);
}

function getImage(id) {
    $.ajax({
        type: 'GET',
        url: 'appSliderHomes/getImage/'+id,
        contentType: false,
        processData: false,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        data: null,
        success: function (data) {
            $('#status').val(data.image.status);
            $('#deleteImage').data('id', data.image.id);
            $('input[name=_method]').data('id', data.image.id);
            $('.image-container').attr('src', data.image.image);
            if ($('#status').val() != 'deshabilitada') { $('#elemCheckbox').click(); }
            $("#btnSaveImage").hide();
            $("#btnUpdateStatus").show();
            $("#inputImageContainer").hide();
            $("#deleteContainer").show();
            $("#imagePreviewContainer").show();
            $("#modal_app_slider_home").modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });
}