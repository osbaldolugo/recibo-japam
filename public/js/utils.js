//Loader AJAX
$.setLoading = function ($selector, $text) {
    $($selector).block({
        message: $text,
        centerY: true,
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });
};
//Ajax para archivos adjuntos
$.ajaxFormData = function ($params) {
    var formData = ($params.form !== null) ? new FormData($('#' + $params.form)[0]) : null;
    //var formData = new FormData($('#' + $params.form)[0]);

    $.ajax({
        type: $params.type,
        url: $params.url,
        contentType: false,
        processData: false,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($params.loadingSelector, "Espere un momento...");
        },
        data: formData,
        success: function (data) {
            $($params.loadingSelector).unblock();

            if (data.message)
                toastr.success(data.message, $params.crud);

            $params.successCallback(data);
        },
        error: function (error) {
            var data = JSON.parse(error.responseText);

            if (data.errors) {
                $.each(data.errors, function () {
                    toastr.error(this, $params.crud, {
                        closeButton: true,
                        timeOut: 6000,
                        progressBar: true,
                        allowHtml: true
                    });
                });
            } else {
                toastr.error(data.message, $params.crud, {
                    closeButton: true,
                    timeOut: 4000,
                    progressBar: true,
                    allowHtml: true
                });
            }

            $($params.loadingSelector).unblock();
            $params.errorCallback(error);
        }
    });
};

//Ajax con informacion plana obtenida desde formulario
$.ajaxSimple = function ($params) {
    $.ajax({
        type: $params.type,
        url: $params.url,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($params.loadingSelector, "Espere un momento");
        },
        data: $.param($($params.form).serializeArray()),
        success: function (data) {
            $($params.loadingSelector).unblock();

            if (data.message)
                toastr.success(data.message, $params.crud);//crud => Titulo del mensaje

            $params.successCallback(data);
        },
        error: function (error) {
            $('#toast-container').html('');
            var data = JSON.parse(error.responseText);
            if (data.errors) {
                $.each(data.errors, function () {
                    toastr.error(this, $params.crud, {
                        closeButton: true,
                        timeOut: 6000,
                        progressBar: true,
                        allowHtml: true
                    });
                });
            } else {
                toastr.error(data.message, $params.crud, {
                    closeButton: true,
                    timeOut: 4000,
                    progressBar: true,
                    allowHtml: true
                });
            }
            $($params.loadingSelector).unblock();
            //Callback
            $params.errorCallback(error);


        }
    });


};


//Ajax custom data
$.ajaxCustomData = function ($params) {

    var $formData = new FormData();
    $.each($params.data, function (key, val) {
        $formData.append(key, val);
    });

    $.ajax({
        type: $params.type,
        url: $params.url,
        contentType: false,
        processData: false,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($params.loadingSelector, "Espere un momento");
        },
        data: $formData,
        success: function (data) {
            $($params.loadingSelector).unblock();

            if (data.message)
                toastr.success(data.message, $params.crud);

            $params.successCallback(data);
        },
        error: function (error) {

            var msg = '';
            $($params.loadingSelector).unblock();

            $.each(JSON.parse(error.responseText), function (key, val) {
                msg += val + '<br/>';
            });

            toastr.error(msg, $params.crud, {closeButton: true, timeOut: 4000, progressBar: true, allowHtml: true});


            //Callback
            $params.errorCallback(error);


        }
    });


};

function deleteAjax($params) {
    bootbox.dialog({
        size: 'small',
        message: '<p class="text-center"><i class="fa fa-warning fa-4x text-danger"></i></p><div class="text-center">' + $params.question + '</div>',
        buttons: {
            success: {
                label: '<i class="fa fa-check"></i> Aceptar',
                className: "btn btn-sm btn-success text-white",
                callback: function () {
                    $.ajax({
                        type: 'DELETE',
                        url: $params.url,
                        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
                        dataType: 'json',
                        beforeSend: function () {
                            $.setLoading($params.loadingSelector, "Espere un momento...");
                        },
                        success: function (data) {
                            $($params.loadingSelector).unblock();

                            if (data.message)
                                toastr.success(data.message, $params.crud);

                            $params.successCallback(data);
                        }, error: function (error) {
                            var data = JSON.parse(error.responseText);

                            toastr.error(data.message, $params.crud, {
                                closeButton: true,
                                timeOut: 4000,
                                progressBar: true,
                                allowHtml: true
                            });

                            $($params.loadingSelector).unblock();

                            $params.errorCallback(error);
                        }
                    });
                }
            },
            main: {
                label: '<i class="fa fa-times"></i> Cancelar',
                className: "btn btn-sm btn-default",
            }
        }
    });
}

//Number Formatting
$.numberFormat = function (value) {
    var number = parseFloat(value).toFixed(2);
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

//Search on table custom script
$.searchOnTable = function ($inputId, $tbId, $colIndex) {

    $("#" + $inputId).on("keyup", function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById($inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById($tbId);
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[$colIndex];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });

};

$.fn.resetForm = function () {
    var val, type, tag;
    $(':input', this).each(function () {
        type = this.type;
        tag = this.tagName.toLowerCase();
        switch (type) {
            case "checkbox":
                this.checked = false;
                break;
            case "radio":
                this.checked = false;
                break;
            case "hidden":
                val = (this.name === '_token' || this.name === '_method') ? this.value : '';
                this.value = val;
                break;
            case "file":
                this.value = "";
                $('.close.fileinput-remove').click();
                break;
            default:
                this.value = "";
        }
        switch (tag) {
            case "textarea":
                this.value = "";
                break;
            case "select":
                $(this).val("").trigger("change");
                // this.selectedIndex = -1;
                break;
            default:
                ;
        }
    });
};

/*
 decimal_sep: character used as deciaml separtor, it defaults to '.' when omitted
 thousands_sep: char used as thousands separator, it defaults to ',' when omitted
 */
Number.prototype.toMoney = function (decimals, decimal_sep, thousands_sep) {
    var n = this,
        c = isNaN(decimals) ? 2 : Math.abs(decimals), //if decimal is zero we must take it, it means user does not want to show any decimal
        d = decimal_sep || '.', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

        /*
         according to [https://stackoverflow.com/questions/411352/how-best-to-determine-if-an-argument-is-not-sent-to-the-javascript-function]
         the fastest way to check for not defined parameter is to use typeof value === 'undefined'
         rather than doing value === undefined.
         */
        t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

        sign = (n < 0) ? '-' : '',

        //extracting the absolute value of the integer part of the number and converting to string
        i = parseInt(n = Math.abs(n).toFixed(c)) + '',

        j = ((j = i.length) > 3) ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
};