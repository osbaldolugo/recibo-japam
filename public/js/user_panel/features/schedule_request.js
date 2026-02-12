$(function () {

    $("#createDate").click(function () {
        if (false === $("form[name='frmDate']").parsley().validate()) {
            return false;
        }

        console.log("Ejemplo");
        var route = $(this).data("route");
        var params = {
            type: "POST",
            url: route,
            form: $("form[name='frmDate']"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                console.log(data);
                swal({
                    title: data.title,
                    text: data.content,
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                }, function () {
                    location.reload();
                });
            },
            errorCallback: function (error) {
                swal({
                    title: 'Error',
                    text: 'No fue posible generar el tiquet',
                    type: "error",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Continuar"
                });
            }
        };
        $.ajaxSimple(params);
    });

});
