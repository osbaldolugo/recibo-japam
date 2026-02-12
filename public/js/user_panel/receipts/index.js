$(function () {
    $("#frmNewReceipt,#frmEditAlias").parsley();

   // $("#contract").inputmask("9{5}-9{5}-9{1,20}");
    $("#contract");
    //$("#barcode").inputmask("99999999999");

    /*Autocomplete contract input
    $("#barcode").on("change", function (e) {
        var value = $("#contract");
        value.val($(this).val().substring(0, 10));
        return false;
    }); */


    //Submit store receipt
    $("#frmNewReceipt").on("submit", function (e) {
        var valid = $("#frmNewReceipt").parsley().isValid();

        if (valid) {
            e.preventDefault();
            $.ajaxSimple({
                type: 'POST',
                crud: 'Mis Recibos',
                url: $("#page").data("url") + '/receipts/store',
                loadingSelector: "#modalNewReceipt",
                form: '#frmNewReceipt',
                successCallback: function () {
                    $("#modalNewReceipt").modal("hide");
                    $(".buttons-reload").click();
                    $("#modalNewReceipt").modal("hide");
                }, errorCallback: function () {

                }

            });
        }

        return false;
    });

    //Open modal edit alias
    $(document).on('click', '#changeAlias', function () {
        $("#receiptId").val($(this).data("receipt"));
        $("#frmEditAlias input[name='alias']").val($(this).parents("tr").children("td:nth-child(2)").text());
        $("#modalEditAlias").modal("show");
    });

    //Submit edit alias
    $("#frmEditAlias").on("submit", function (e) {
        var valid = $("#frmEditAlias").parsley().isValid(), id = $("#receiptId").val();

        if (valid) {
            e.preventDefault();
            $.ajaxSimple({
                type: 'POST',
                crud: 'Mis Recibos',
                url: $("#page").data("url") + '/receipts/' + id + '/editAlias',
                loadingSelector: "#modalEditAlias",
                form: '#frmEditAlias',
                successCallback: function () {
                    document.getElementById('frmEditAlias').reset();
                    $("#modalEditAlias").modal("hide");
                    $(".buttons-reload").click();

                }, errorCallback: function () {

                }

            });
        }

        return false;
    });

    //Open modal pay history
    $(document).on("click", "#viewHistory", function () {
        $.ajaxSimple({
            type: 'POST',
            crud: 'Mis Recibos',
            url: $("#page").data("url") + '/receipts/' + id + '/viewPays',
            loadingSelector: "#modalPays",
            form: '',
            successCallback: function () {



            }, errorCallback: function () {

            }

        });
    });

});