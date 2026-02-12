$(document).ready(function () {

    $("[data-mask]").inputmask();
    //data-inputmask='"mask": "99999-99999-999999"' data-mask
    $("#contract").inputmask("99999-99999-9[9][9][9][9][9]");
    $("#meter").inputmask("99999[9][9][9]");

    $("#barcode").inputmask("99999999999", {
        oncomplete: function () {
            if ($("#contract").inputmask("isComplete")) {
                validateReceipt($("#contract").val(), $("#barcode").val());
            }
        }
    });

    $(".validarRecibo").on('click', function () {
        validateReceipt($("#contract").val(), $("#barcode").val());
    });

    $(".save").on('click', function () {
        var form = $(this).parents("form");
        var params = {
            type: 'POST',
            url: $(this).data('route'),
            loadingSelector: $("#loading"),
            form: $("#form"),
            crud: 'Respuesta del servidor',
            successCallback: function (data) {
                if (data.route === undefined) {
                    form.resetForm();
                    habilitar(false);
                    swal({
                        title: data.question,
                        text: data.msg,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Finalizar"
                    });
                    //$.showSuccess(data.msg);
                } else {
                    swal({
                        title: data.question,
                        text: data.msg,
                        type: "warning",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-warning",
                        confirmButtonText: "Login"
                    }, function () {
                        location.href = data.route;
                    });
                }
            },
            errorCallback: function (error) {
                if (data.responseJSON !== undefined) {
                    $.showerrors(data.responseJSON.errors);
                } else {
                    $.showerrors('Error', 'Lo sentimos, pero no es posible completar su registro, hubo un problema al intentar enviar la información al servidor');
                }
            }
        };
        $.ajaxSimple(params);
    });
});

$.showerrors = function (data, msg) {
    $('#toast-container').html('');
    if (msg !== undefined) {
        showMessageDialog(msg, 'error', 'Error');
    } else {
        $.each(data, function (index) {
            showMessageDialog(this, 'error', index);
        });
    }
};

$.showSuccess = function (msg) {
    $('#toast-container').html('');
    showMessageDialog(msg, 'success', 'Success');
};

function showMessageDialog(msg, type, title) {
    Command: toastr[type](msg, title);
}

function habilitar(value) {
    if (value === true) {
        // deshabilitamos
        document.getElementById("noTitular").style.display = "none";
        document.getElementById("name_u").disabled = true;
        document.getElementById("last_name_1_u").disabled = true;
        document.getElementById("last_name_2_u").disabled = true;
    } else {
        // habilitamos
        document.getElementById("noTitular").style.display = "block";
        document.getElementById("name_u").disabled = false;
        document.getElementById("last_name_1_u").disabled = false;
        document.getElementById("last_name_2_u").disabled = false;
    }
}

function validateReceipt(contract, barcode) {
    var params = {
        type: 'GET',
        url: 'https://japammovil.com/tcs/public/receipt/owner/' + contract + '/' + barcode,
        loadingSelector: $("#loading"),
        form: null,
        crud: 'Respuesta del servidor',
        successCallback: function (data) {
            if (data.name !== null) {
                $("#name").val(data.name.trim());
                $.showSuccess("La información del recibo si corresponde a la de nuestros servidores");
            } else {
                $.showerrors('Error', 'Lo sentimos, pero no encontramos ningún recibo con la información proporcionada');
            }
        },
        errorCallback: function (error) {
            if (data.responseJSON !== undefined) {
                $.showerrors(data.responseJSON.errors);
            } else {
                $.showerrors('Error', 'Lo sentimos, pero no encontramos ningún recibo con la información proporcionada');
            }
        }
    };
    $.ajaxSimple(params);
}