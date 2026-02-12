/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $("#materialModal").on("hidden.bs.modal", function () {
        var form = $("#formMaterial");
        form.resetForm();
    });

    $(".touchSpin").TouchSpin({
        verticalbuttons: true,
        forcestepdivisibility: 'none',
        min: 0,
        max: 100000,
        mousewheel: false,
        decimals: 2
    });

    $("#saveMaterial").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formMaterial"),
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
                $('#materialModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createMaterial").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveMaterial").data("route", route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Material');
        $("#modal-title").html('<i class="ion-cube"></i> Agregar Nuevo Material');
        $('#materialModal').modal('show');
    });

});

$(document).on("click", "a[name='editMaterial']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveMaterial").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Material');
    var params = {
        type: "GET",
        url: get,
        form: $("#formMaterial"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("textarea[name='description']").val(data.pMOMaterial.description);
            $("input[name='code']").val(data.pMOMaterial.code);
            $("input[name='unit']").val(data.pMOMaterial.unit);
            $("input[name='price']").val(data.pMOMaterial.price);
            $('#materialModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("entro");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-material', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar el Material?',
        text: 'El Material se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de los Materiales',
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
