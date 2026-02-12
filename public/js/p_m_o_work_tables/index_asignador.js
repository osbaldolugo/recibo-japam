$(document).ready(function() {

    $(document).on("click","button[name='downloadFile']",function () {
        console.log("entra");

        var this_select = this;
        var route = $(this).data("route");

        var params = {
            type: "POST",
            url: route,
            loadingSelector: $(this).find("div[name='content']"),
            crud: "Notificación",
            successCallback: function (data) {
                console.log(data.url);

                window.open(data.url);

            },
            errorCallback: function (error) {
                console.log("entro");
            }
        };
        $.ajaxSimple(params);


    });

    $(document).on("click","button[name='changeStatus']",function () {
        console.log("entra");

        var this_select = this;
        var route = $(this).data("route");

        var params = {
            type: "POST",
            url: route,
            loadingSelector: $(this).closest("div"),
            crud: "Notificación",
            successCallback: function (data) {
                console.log(data);

            },
            errorCallback: function (error) {
                console.log("entro");
            }
        };
        $.ajaxSimple(params);


    });

});
