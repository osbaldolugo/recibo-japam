/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable().on('preXhr.dt', function (e, settings, data) {
        data.speciality = $("#id_speciality").val();
    });

    $("#workerModal").on("hidden.bs.modal", function () {
        var form = $("#formWorker");
        form.resetForm();
    });

    $(".select2").on('change', function () {
        $('.buttons-reload').click();
    });

    $(".touchSpin").TouchSpin({
        verticalbuttons: true,
        forcestepdivisibility: 'none',
        min: 0,
        max: 1000000,
        mousewheel: true,
        decimals: 2
    });

    $('select').select2({
        width: '100%',
        language: 'es'
    });

    $("#saveWorker").on("click", function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formWorker"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                table.draw();
                swal({
                    title: data.title,
                    text: data.content, //"El Trabajador se creó correctamente",
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                $('#workerModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error.");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createWorker").on("click", function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveWorker").data("route", route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Trabajador');
        $("#modal-title").html('<i class="ion-android-walk"></i> Agregar Nuevo Trabajador');
        $('#workerModal').modal('show');
    });

});

$(document).on("click", "a[name='editWorker']", function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveWorker").data("route", route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información del Trabajador');
    var params = {
        type: "GET",
        url: get,
        form: $("#formWorker"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("select[name='speciality_id']").val(data.pMOWorker.speciality_id).trigger('change');
            $("input[name='nom_id']").val(data.pMOWorker.nom_id);
            $("input[name='dairy_salary']").val(data.pMOWorker.dairy_salary);
            $("input[name='name']").val(data.pMOWorker.name);
            $('#workerModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-worker', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar al Trabajador?',
        text: 'El Trabajador se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de los Trabajadores',
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
