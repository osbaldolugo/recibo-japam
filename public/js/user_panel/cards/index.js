$(function () {

    $("#frmNewCard").parsley();

    //Save card
    $("#frmNewCard").on("submit", function (e) {
        var valid = $("#frmNewCard").parsley().isValid();

        if (valid) {
            e.preventDefault();
            $.ajaxSimple({
                type: 'POST',
                crud: 'Mis tarjetas',
                url: $("#page").data("url") + '/appUserCards/store',
                loadingSelector: "#modalNewCard",
                form: '#frmNewCard',
                successCallback: function () {
                    document.getElementById('frmNewCard').reset();
                    $("#modalNewCard").modal("hide");
                    $(".buttons-reload").click();
                }, errorCallback: function () {

                }

            });
        }

        return false;
    });

    //Delete card
    $(document).on('click', '#deleteCard', function () {

        var id = $(this).data('card');

        if (confirm('¿ Está seguro(a) de eliminar esta tarjeta ?')) {
            $.ajaxSimple({
                type: 'DELETE',
                crud: 'Mis Tarjetas',
                url: $("#page").data("url") + '/appUserCards/' + id + '/delete',
                loadingSelector: ".panel-body",
                form: '',
                successCallback: function () {
                    $(".buttons-reload").click();

                }, errorCallback: function () {

                }

            });
        }
        return false;

    });

    //To tag card as default
    $(document).on('click', '#defaultCard', function () {

        var id = $(this).data('card');

        if (confirm('¿ Está seguro(a) de marcar esta tarjeta como predeterminada ?')) {
            $.ajaxSimple({
                type: 'GET',
                crud: 'Mis Tarjetas',
                url: $("#page").data("url") + '/appUserCards/' + id + '/default',
                loadingSelector: ".panel-body",
                form: '',
                successCallback: function () {
                    $(".buttons-reload").click();

                }, errorCallback: function () {

                }

            });
        }
        return false;

    });
});