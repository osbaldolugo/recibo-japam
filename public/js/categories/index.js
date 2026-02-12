/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable().on('draw.dt', function () {
        $('.executor').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
    });

    $('#cbxExecutor').iCheck({
        checkboxClass: 'icheckbox_square-blue'
    });

    $('#txtColor').colorpicker();

    $("#categoryModal").on("hidden.bs.modal", function () {
        var form = $("#formCategory");
        form.resetForm();
        $('#cbxExecutor').iCheck('uncheck').iCheck('update');
    });

    $("#saveCategory").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formCategory"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                swal({
                    title: data.title, //"Correcto",
                    text: data.content, //"El area se guardo correctamente",
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                table.draw();
                $('#categoryModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log('Error.');
            }
        };
        $.ajaxSimple(params);
    });

    $("#createCategory").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveCategory").data("route", route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Area');
        $("#modal-title").html('<i class="ion-grid"></i>&nbsp;Agregar Nueva Área');
        $('#categoryModal').modal('show');
    });

});

$(document).on("click", "a[name='editCategory']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveCategory").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Área');
    var params = {
        type: "GET",
        url: get,
        form: $("#formCategory"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='name']").val(data.category.name);
            $("input[name='color']").val(data.category.color);
            if (data.category.executor)
                $('#cbxExecutor').iCheck('check');
            $('#categoryModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("entro");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-category', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el Área?',
        text: 'El Área se quitara del catálogo',
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
                loadingSelector: $("#app-layout"),
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
                        text: 'No fue posible actualizar el catálogo de las areas',
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

$(document).on('ifToggled', '.executor', function () {
    var checked = $(this).is(':checked') ? 1 : 0;
    updateExecutor($('#page').data('url') + '/categories/' + $(this).val() + '/update/' + checked, $(this));
});

function updateExecutor(url, object) {
    console.log('Si esta funcionando el evento');
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
                text: 'No fue posible actualizar los permisos del area',
                type: "error",
                showCancelButton: 0,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar"
            });
        }
    };
    swal({
        title: '¿Esta seguro que desea continuar?',
        text: 'Actualizar los permisos del area',
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
