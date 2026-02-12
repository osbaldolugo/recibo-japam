/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $("#workTypeModal").on("hidden.bs.modal", function () {
        var form = $("#formWorktype");
        form.resetForm();
    });

    $("#saveWorkType").on("click",function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formWorktype"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                table.draw();
                swal({
                    title: data.title,
                    text: data.content,
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Confirmar"
                });
                $('#workTypeModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createWorkType").on("click",function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveWorkType").data("route",route).html('<i class="fa fa-plus-square"></i> Guardar Tipo de Trabajo');
        $("#modal-title").html('<i class="ion-settings"></i> Agregar Nuevo Tipo de Trabajo');
        $('#workTypeModal').modal('show');
    });

});

$(document).on("click","a[name='editWorkType']",function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveWorkType").data("route",route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Tipo de Trabajo');
    var params = {
        type: "GET",
        url: get,
        form: $("#formWorkType"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='type']").val(data.workType.type);
            $("input[name='code']").val(data.workType.code);
            $('#workTypeModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-work-type', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el Tipo de Trabajo?',
        text: 'El Tipo de Trabajo se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo del Tipo de Trabajo',
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