/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $("#workModal").on("hidden.bs.modal", function () {
        var form = $("#formWork");
        form.resetForm();
    });

    $("#saveWork").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formWork"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                table.draw();
                swal({
                    title: data.title, //"Correcto",
                    text: data.content, //"El Trabajo se creó correctamente",
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                $('#workModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createWork").on("click", function () {
        var route = $(this).data("route");
        $("input[name='_method']").val("POST");
        $("#saveWork").data("route", route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Trabajo');
        $("#modal-title").html('<i class="ion-hammer"></i> Agregar Nuevo Trabajo');
        $('#workModal').modal('show');
    });

});

$(document).on("click", "a[name='editWork']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveWork").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Trabajo');
    var params = {
        type: "GET",
        url: get,
        form: $("#formWork"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("textarea[name='description']").val(data.work.description);
            $("input[name='code']").val(data.work.code);
            $('#workModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-work', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el Trabajo?',
        text: 'El Trabajo se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de los Trabajos',
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
