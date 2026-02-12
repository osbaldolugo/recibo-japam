/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $('select').select2({
        width: '100%',
        language: 'es'
    });

    $("#createSuburb").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveSuburb").data("route", route).html('<i class="fa fa-plus-square">&nbsp;</i>Guardar Colonia');
        $("#modal-title").html("<i class=\"fa fa-map-pin\"></i> Agregar Nueva Colonia");
        $('#suburbModal').modal('show');
    });

    $("#suburbModal").on("hidden.bs.modal", function () {
        var form = $("#formSuburb");
        form.resetForm();
    });

    $("#saveSuburb").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formSuburb"),
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
                    confirmButtonText: "Continuar"
                });
                $('#suburbModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

});


$(document).on("click", "a[name='editSuburb']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveSuburb").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html("<i class=\"fa fa-edit\"></i>&nbsp;Actualizar información de la Colonia");
    var params = {
        type: "GET",
        url: get,
        form: null,
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='suburb']").val(data.suburb.suburb);
            $("select[name='sector_id']").val(data.suburb.sector_id).trigger('change');
            $('#suburbModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-suburb', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar la Colonia?',
        text: 'La Colonia se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de las Colonias',
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
