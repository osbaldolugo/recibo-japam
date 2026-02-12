$(document).ready(function () {
    FormSliderSwitcher.init();

    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.deleted = $("#cbxDeleted").is(':checked') ? 1 : 0;
    }).on('draw.dt', function () {
        $('.is-admin-all').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
        $('.is-agent-all').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
    });

    $('.categories').iCheck({
        radioClass: 'iradio_square-orange',
        checkboxClass: 'icheckbox_square-orange'
    });

    $("[data-render=switchery]").on('change', function () {
        $('.buttons-reload').click();
    });

    // Prepare the preview for profile picture
    $("#wizard-picture").change(function () {
        readURL(this);
    });

    $("#createUser").on('click', function () {
        $("#method").val('POST');
        $("#route").val($(this).data('route'));
        $("#btnSave").html("<i class=\"fa fa-save\"></i>&nbsp;Guardar");
        $("#modal-title-user").html("<i class=\"fa fa-user-plus\"></i>&nbsp;Agregar un nuevo usuario");
        $("#content-password").hide().fadeIn('slow');
        $("#email").prop('disabled', false);
    });

    //Reiniciar el modal cada vez que se oculte
    $("#modal-user").on("hidden.bs.modal", function () {
        var form = $("#frmUser");
        form.resetForm();
        $('.categories').iCheck('uncheck').iCheck('update');
        $('#ticketit_admin').iCheck('uncheck').iCheck('update');
        $('#ticketit_agent').iCheck('uncheck').iCheck('update');
        $("#route").val(null);
        $("#password").prop('required', true);
        $('#wizardPicturePreview').attr('src', $("#image-default").val()).fadeIn('slow');
    });

    $("#btnSave").on('click', function (e) {
        var method = $("#method").val();
        var form = $("#frmUser");
        if (form.parsley().validate()) {
            var params = {
                type: method,
                url: $("#route").val(),
                loadingSelector: $("#modal-user"),
                form: "frmUser",
                crud: 'Respuesta del servidor',
                successCallback: function (data) {
                    swal({
                        title: data.title,
                        text: data.content,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Continuar"
                    });
                    $('.buttons-reload').click();
                    $("#modal-user").modal('hide');
                },
                errorCallback: function (error) {
                    console.log(error);
                }
            };
            $.ajaxFormData(params);
        }
    });
});

$(document).on('click', '.editUser', function () {
    $("#method").val('POST');
    $("#route").val($(this).data('route'));
    $("#btnSave").html("<i class=\"fa fa-send\"></i>&nbsp;Guardar Cambios");
    $("#modal-title-user").html("<i class=\"fa fa-edit\"></i>&nbsp;Actualizar información del usuario");
    //$("#content-password").show().fadeOut('slow');
    $("#password").prop('required', false).val('');
    var params = {
        type: 'GET',
        url: $(this).data('route'),
        loadingSelector: $("#tabble-loading"),
        form: null,
        crud: 'Respuesta del servidor',
        successCallback: function (data) {
            $("#name").val(data.name);
            if (data.url_image !== '') {
                $('#wizardPicturePreview').attr('src', $("#image").val() + data.url_image).fadeIn('slow');
            } else {
                $('#wizardPicturePreview').attr('src', $("#image-default").val()).fadeIn('slow');
            }
            if (data.ticketit_admin) {
                $('#ticketit_admin').iCheck('check');
            }
            if (data.ticketit_agent) {
                $('#ticketit_agent').iCheck('check');
            }
            $.each(data.categories, function (index, value) {
                $("#category" + value.id).iCheck('check');
            });
            $("#email").val(data.email).prop('disabled', true);
            $("#modal-user").modal('show');
        },
        errorCallback: function (error) {
            console.log(error);
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.deleteUser', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el usuario?',
        text: 'El usuario ya no podra acceder al Panel WEB',
        type: "info",
        showCancelButton: 1,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Continuar",
        cancelButtonClass: "btn-warning",
        cancelButtonText: "Cancelar"
    }, function (data) {
        if (data) {
            var params = {
                type: 'DELETE',
                url: route,
                loadingSelector: $("#tabble-loading"),
                form: null,
                crud: 'Respuesta del servidor',
                successCallback: function (data) {
                    swal({
                        title: data.title,
                        text: data.content,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Continuar"
                    });
                    $('.buttons-reload').click();
                },
                errorCallback: function (error) {
                    swal({
                        title: 'Error',
                        text: 'No fue posible actualizar los permisos del usuario',
                        type: "error",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                }
            };
            $.ajaxSimple(params);
        }
    });
});

$(document).on('click', '.retoreUser', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea restaurar el usuario?',
        text: 'El usuario podra volver a acceder al Panel WEB',
        type: "info",
        showCancelButton: 1,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Continuar",
        cancelButtonClass: "btn-warning",
        cancelButtonText: "Cancelar"
    }, function (data) {
        if (data) {
            var params = {
                type: 'GET',
                url: route,
                loadingSelector: $("#tabble-loading"),
                form: null,
                crud: 'Respuesta del servidor',
                successCallback: function (data) {
                    swal({
                        title: data.title,
                        text: data.content,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Continuar"
                    });
                    $('.buttons-reload').click();
                },
                errorCallback: function (error) {
                    swal({
                        title: 'Error',
                        text: 'No fue posible restaurar el usuario',
                        type: "error",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                }
            };
            $.ajaxSimple(params);
        }
    });
});

$(document).on('ifToggled', '.is-admin', function () {
    var checked = $(this).is(':checked') ? 1 : 0;
    updatePermissions($('#page').data('url') + '/admin/users/is_admin/' + $(this).val() + '/' + checked, $(this));
});

$(document).on('ifToggled', '.is-agent', function () {
    var checked = $(this).is(':checked') ? 1 : 0;
    updatePermissions($('#page').data('url') + '/admin/users/is_agent/' + $(this).val() + '/' + checked, $(this));
});

function loadImg(img) {
    img.prop({ src: img.data("src") });
}

//Function to show image before upload to input file
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updatePermissions(url, object) {
    var params = {
        type: 'GET',
        url: url,
        loadingSelector: $("#tabble-loading"),
        form: null,
        crud: 'Respuesta del servidor',
        successCallback: function (data) {
            swal({
                title: data.title,
                text: data.content,
                type: "success",
                showCancelButton: 0,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Continuar"
            });
            $('.buttons-reload').click();
        },
        errorCallback: function (error) {
            swal({
                title: 'Error',
                text: 'No fue posible actualizar los permisos del usuario',
                type: "error",
                showCancelButton: 0,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar"
            });
        }
    };
    swal({
        title: '¿Esta seguro que desea continuar?',
        text: 'Actualizar los permisos del usuario',
        type: "info",
        showCancelButton: 1,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "Continuar",
        cancelButtonClass: "btn-warning",
        cancelButtonText: "Cancelar"
    }, function (data) {
        if (data)
            $.ajaxSimple(params);
        else
            object.iCheck('toggle');
    });
}