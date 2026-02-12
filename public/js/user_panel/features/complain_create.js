

$(function () {
    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).parent().find('.radio').removeClass('bg-green-lighter');
        $(this).addClass('selected');
        $(this).addClass('bg-green-lighter');
        var val = $(this).attr('data-value');
        $("#credentials").val(val);

        console.log(val);

        $(val).each("input",function () {
           $(this).removeAttr("disabled");
           $(this).removeAttr("required");
        });

    });

    $("#createComplain").click(function () {

        if (false === $("form[name='frmComplaint']").parsley().validate()) {
            return false;
        }

        console.log("Ejemplo");
        console.log($("form[name='frmComplaint']"));
        var route = $(this).data("route");
       console.log(route);
        var switchDOM = document.getElementById("anonimo");
        var checkbox = document.getElementById("name");
        var checkbox1 = document.getElementById("lastname2");
        var checkbox2 = document.getElementById("lastname1");
        var phone_number = document.getElementById("phone_number");
        var email = document.getElementById("email");
        var recibo = document.getElementById("recibo");
        var contrato = document.getElementById("contrato");
        //console.log(switchDOM.value=="on");

        if (switchDOM){
            if (switchDOM.value=="on") {
                desactivar(false);
            }
        }


        var params = {
            type: "POST",
            url: route,
            form: $("form[name='frmComplaint']"),
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                console.log(data);
                //desactivar(true);
                Swal.fire({
                    title: data.title,
                    text: data.content,
                    //type: "success",
                    showCancelButton: 0,
                    //confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar",
                    icon: 'success',
                }, function () {
                    location.reload();
                });

            },
            errorCallback: function (error) {
                console.log(error);

                //desactivar(true);

                Swal.fire({
                    title: 'Error',
                    text: 'No fue posible generar el ticket',
                    //type: "error",
                    showCancelButton: 0,
                    //confirmButtonClass: "btn-danger",
                    confirmButtonText: "Continuar",
                    icon: 'error',
                });
            }
        };
        $.ajaxSimple(params);
    })


});


function desactivar(valor) {
    var checkbox = document.getElementById("name");
    var checkbox1 = document.getElementById("lastname2");
    var checkbox2 = document.getElementById("lastname1");
    var phone_number = document.getElementById("phone_number");
    var email = document.getElementById("email");

        checkbox.disabled = valor;
        checkbox1.disabled = valor;
        checkbox2.disabled = valor;
        phone_number.disabled = valor;
        email.disabled = valor;


}