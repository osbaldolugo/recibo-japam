/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {
    $('.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue'
    });
    
    $("#is_ticket").on('ifToggled', function () {
        var checked = $(this).is(':checked') ? 1 : 0;
        if (checked) {
            $("#user_required").prop('disabled', false).iCheck('uncheck');
            $("#receipt_required").prop('disabled', false).iCheck('uncheck');
        } else {
            $("#user_required").prop('disabled', true).iCheck('uncheck');
            $("#receipt_required").prop('disabled', true).iCheck('uncheck');
        }
    });

});

$("#createIncident").on("click", function () {
    $("input[name='_method']").val("POST");
    var route = $(this).data("route");
    $("#saveIncident").data("route", route).html('<i class="fa fa-plus-square">&nbsp;</i>Guardar Motivo de Llamada');
    $("#modal-title").html("<i class=\"fa fa-phone\"></i> Motivo de Llamada ");
    $('#indicidentModal').modal('show');
});

$("#indicidentModal").on("hidden.bs.modal", function () {
    var form = $("#formIncident");
    form.resetForm();
    $('.icheck').iCheck('uncheck').iCheck('update');
});

$(document).on("click", "a[name='editIncident']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#modal-title").html("<i class=\"fa fa-edit\"></i>&nbsp;Actualizar información del motivo de llamada");
    $("#saveIncident").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    var params = {
        type: "GET",
        url: get,
        form: $("#formIncident"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='name']").val(data.incidents.name);
            $("textarea[name='description']").val(data.incidents.description);
            if (data.incidents.ticket)
                $("#is_ticket").iCheck('check');
            if (data.incidents.receipt_required)
                $("#receipt_required").iCheck('check');
            if (data.incidents.user_required)
                $("#user_required").iCheck('check');
            $('#indicidentModal').modal('show');
            swal({
                title: data.title,
                text: data.content,
                type: "success",
                showCancelButton: 0,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Continuar"
            });
        },
        errorCallback: function (error) {
            console.log(error);
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-incident', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el motivo de llamada?',
        text: 'El motivo de llamada se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de los motivos de llamada',
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

$("#saveIncident").on("click", function () {
    var route = $(this).data("route");
    var params = {
        type: "POST",
        url: route,
        form: $("#formIncident"),
        loadingSelector: $(this).closest("div"),
        crud: "Respuesta del Servidor",
        successCallback: function (data) {
            swal({
                title: data.title,
                text: data.content,
                type: "success",
                showCancelButton: 0,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Continuar"
            });
            $('.buttons-reload').click();
            $('#indicidentModal').modal('hide');
        },
        errorCallback: function (error) {
            console.log(error);
        }
    };
    $.ajaxSimple(params);
});
