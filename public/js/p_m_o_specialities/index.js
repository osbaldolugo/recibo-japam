/**
 * Created by ApiDeveloper on 21/02/2018.
 */
$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();

    $("#specialityModal").on("hidden.bs.modal", function () {
        var form = $("#formSpeciality");
        form.resetForm();
    });

    $("#saveSpeciality").on("click",function () {
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("#formSpeciality"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                table.draw();
                swal({
                    title: "Correcto",
                    text: "La especialidad se creó correctamente",
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                });
                $('#specialityModal').modal('hide');
            },
            errorCallback: function (error) {
                console.log("Error");
            }
        };
        $.ajaxSimple(params);
    });

    $("#createSpeciality").on("click",function () {
        $("input[name='_method']").val("POST");
        var route = $(this).data("route");
        $("#saveSpeciality").data("route",route).html('<i class="fa fa-plus-square"></i>&nbsp;Guardar Especialidad');
        $("#modal-title").html('<i class="ion-android-menu"></i> Agregar Nueva Especialidad');
        $('#specialityModal').modal('show');
    });

});


$(document).on("click","a[name='editSpeciality']",function () {
    var get = $(this).data("get");
    var route = $(this).data("route");
    $("#saveSpeciality").data("route",route).html('<i class="fa fa-send"></i>&nbsp;Guardar Cambios');
    $("#modal-title").html('<i class="fa fa-edit"></i>&nbsp;Actualizar la información de la Especialidad')
    var params = {
        type: "GET",
        url: get,
        form: $("#formSpeciality"),
        loadingSelector: $("#app-layout"),
        crud: "Notificación",
        successCallback: function (data) {
            $("input[name='_method']").val("PATCH");
            $("input[name='speciality']").val(data.pMOSpecialty.speciality);
            $('#specialityModal').modal('show');
        },
        errorCallback: function (error) {
            console.log("Error.");
        }
    };
    $.ajaxSimple(params);
});

$(document).on('click', '.delete-speciality', function () {
    var route = $(this).data('route');
    swal({
        title: '¿Esta seguro que desea eliminar la Especialidad?',
        text: 'La Especialidad se quitara del catálogo',
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
                        text: 'No fue posible actualizar el catálogo de las Especialidades',
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