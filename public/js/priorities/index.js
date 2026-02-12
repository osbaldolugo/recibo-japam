/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    $("#createPriority").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#savePriority").data("route", route).html('<i class="fa fa-plus-square">&nbsp;</i>Guardar Prioridad');
        $("#modal-title").html("<i class=\"fa fa-level-up\"></i><i class=\"fa fa-level-down fa-flip-horizontal\"></i> Agregar Nueva Prioridad");
        $('#priorityModal').modal('show');
    });

    $("#priorityModal").on("hidden.bs.modal", function () {
        var form = $("#formPriority");
        form.resetForm();
    });

    $(".touchSpin").TouchSpin({
        verticalbuttons: true,
        forcestepdivisibility: 'none',
        min: 1,
        max: 365,
        mousewheel: false,
        decimals: 0
    });

    $('#txtColor').colorpicker();

    $("#savePriority").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formPriority"),
            loadingSelector: $(this).closest("div"),
            crud: "Respuesta del servidor",
            successCallback: function (data) {
                $('.buttons-reload').click();
                swal({
                    title: data.title,
                    text: data.content,
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                $('#priorityModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

});


$(document).on("click", "a[name='editPriority']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#savePriority").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html("<i class=\"fa fa-edit\"></i>&nbsp;Actualizar información de la prioridad");
    var params = {
        type: "GET",
        url: get,
        form: null,
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='name']").val(data.priority.name);
            $("input[name='color']").val(data.priority.color);
            $("input[name='response_time']").val(data.priority.response_time);
            $('#priorityModal').modal('show');
        },
        errorCallback: function (error) {
            console.log('Error.');
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-priority', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar la prioridad?',
        text: 'La prioridad se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de las prioridades',
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
