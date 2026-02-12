/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $("#equipmentModal").on("hidden.bs.modal", function () {
        var form = $("#formEquipment");
        form.resetForm();
    });

    $("#saveEquipment").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formEquipment"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                table.draw();
                swal({
                    title: data.title,
                    text: data.content, //"El Equipo se creó correctamente",
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                $('#equipmentModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createEquipment").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveEquipment").data("route", route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Equipo');
        $("#modal-title").html('<i class="ion-person-stalker"></i> Agregar Nuevo Equipo');
        $('#equipmentModal').modal('show');
    });

});

$(document).on("click", "a[name='editEquipment']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveEquipment").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Equipo');
    var params = {
        type: "GET",
        url: get,
        form: $("#formEquipment"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("textarea[name='description']").val(data.pMOEquipment.description);
            $("input[name='code']").val(data.pMOEquipment.code);
            $('#equipmentModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-equipment', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el Equipo?',
        text: 'El Equipo se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de los Equipos',
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
