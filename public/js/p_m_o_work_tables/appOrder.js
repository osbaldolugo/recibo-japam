
$(document).ready(function () {
    "use strict";
    $("#wizard").bwizard({
        backBtnText: "<i class='ion-arrow-left-c'></i> Anterior",
        nextBtnText: "Siguiente <i class='ion-arrow-right-c'></i>",
        activeIndexChanged: function (e, ui) {
            console.log(e);
            console.log(ui);
        },
        validating: function (e, t) {
            /*$.each({0: 'wizard-step-1', 1: 'wizard-step-2', 2: 'wizard-step-3', 3: 'wizard-step-4'}, function (i, v) { //index, value
                console.log(i);
                console.log(v);
                if (t.index === i) {
                    if (false === $('form[name="form-wizard"]').parsley().validate(v)) {
                        return false
                    }
                }
            });*/
            if (t.index === 0) {
                if (false === $("form[name='form-wizard']").parsley().validate("wizard-step-1")) {
                    return false
                } else {
                    console.log("Paso 1");
                    var page = $("#page").data("url");
                    var params = {
                        type: "POST",
                        url: page + "/pMOWorkTables",
                        form: $('form[name="form-wizard"]'),
                        loadingSelector: $(this).closest("div"),
                        crud: "Notificaci車n",
                        successCallback: function (data) {
                           console.log(data);

                            var id_pmo_work_table = $("#id_pmo_work_table").val(data.pmoWork.id);

                            $("#tableWorkOrden tbody").append("<tr>" +
                                "<td><b>"+ data.pmoWork.folio+"</b></td>" +
                                "<td><b>"+ data.pmoWork.pmo_category.name+"</b></td>" +
                                "<td><b>"+ data.pmoWork.pmo_work.description+"</b></td>" +
                                "<td>" +
                                "   <button class='btn btn-sm btn-inverse' name='fillWorkOrder' " +
                                "   data-workorderid='"+data.pmoWork.id+" "+
                                "   data-route='http://localhost/Proyectos%20Laravel/ALBEK/japam_web/public/pMOWorkTables/"+1+"/getWorkOrder'>Usar</button></td>" +
                                "</tr>");



                            var params = {
                                type: "POST",
                                url: page + "/pMOWorkTables/createPDF",
                                loadingSelector: $(this).closest("div"),
                                form: $('form[name="form-wizard"]'),
                                crud: "Notificaci車n",
                                successCallback: function (data) {

                                    $("#pdfFactura").attr("src",data.url);
                                    console.log(data);

                                },
                                errorCallback: function (error) {
                                    console.log("entro");
                                }
                            };
                            $.ajaxSimple(params);
                        },
                        errorCallback: function (error) {
                            console.log("entro");
                        }
                    };
                    $.ajaxSimple(params);
                }
            } else if (t.index === 1) {
                if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-2")) {
                    return false
                } else {
                    console.log("Paso 2");
                    var page = $("#page").data("url");
                    var id_pmo_work_table = $("#id_pmo_work_table").data("url");
                    var params = {
                        type: "GET",
                        url: page + "/createPDF/"+id_pmo_work_table,
                        loadingSelector: $(this).closest("div"),
                        crud: "Notificaci車n",
                        successCallback: function (data) {
                            $("#id_sector").val(data.data.id);
                            table = $('#dataTableBuilder').DataTable().on('preXhr.dt', function (e, settings, data) {
                                data.id_sector = $("#id_sector").val();
                            }).on('draw.dt', function () {

                            });
                            table.draw();
                        },
                        errorCallback: function (error) {
                            console.log("entro");
                        }
                    };
                    $.ajaxSimple(params);
                }
            } else if (t.index === 2) {
                if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-3")) {
                    return false
                } else {
                }
               
            }
        }
    });

    // Create map and initialize Search Box API
    var options = $.extend(true, {
        lang: 'es',
        codemirror: {theme: 'monokai', mode: 'text/html', htmlMode: true, lineWrapping: true},
        height: 200,
        toolbar: {
            style: "style",
            font: ["bold", "underline", "italic", "clear"],
            color: "color",
            para: ["ul", "ol", "paragraph"],
            table: "table",
            insert: ["link", "picture", "video"],
            view: ["fullscreen", "codeview", "help"]
        }
    });

    $('select').select2({
        width: '100%',
        language: 'es'
    });

    FormSliderSwitcher.init();

    $("#selectOrden").find("input, textarea, select").each(function () {
        console.log(this);
        $(this).prop('disabled', true);
        $(this).prop('required', false);
    });

    $("#newOrden").find("input, textarea, select").each(function () {
        console.log(this);
        var parsley_errors_container = $(this).data("parsley-errors-container");
        $(this).after("<div "+parsley_errors_container+">");
    });



});


$('input[name="check_description"]').on("change",function () {
   console.log("entra");

    if ( $(this).is(":checked"))
    {
        console.log(false);
        $("#desc_work").removeAttr("readonly");
        $("#desc_work").val("");

    }else{
        console.log(true);
        $("#desc_work").attr("readonly",true);
        $("#desc_work").val("");

    }

});

$("select[name='work_id']").on("change",function () {
    console.log("entra");

    var this_select = this;
    var route = $(this).data("route");
    var id_work = $(this).children("option:selected").val();

    var params = {
        type: "GET",
        url: route+"/"+id_work+"/edit",
        loadingSelector: $(this).closest("div"),
        crud: "Notificaci車n",
        successCallback: function (data) {
            console.log(data.work);

            console.log($(this_select).parents().parents().parents().find("textarea[name='desc_work']").val());
            $(this_select).parents().parents().parents().find("textarea[name='desc_work']").val(data.work.code+" : "+data.work.description);

        },
        errorCallback: function (error) {
            console.log("entro");
        }
    };
    $.ajaxSimple(params);


});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    console.log(e);
    e.target // newly activated tab
    var targetID = $(e.target).attr("href");
    console.log($(e.target).attr("href"));
    e.relatedTarget // previous active tab
    var relatedtargetID = $(e.relatedTarget).attr("href");
    console.log($(e.relatedTarget).attr("href"));

    $(targetID).find("input, textarea,select").each(function () {
        console.log(this);
        $(this).prop('disabled', false);
        $(this).prop('required', true);
    });
    $(relatedtargetID).find("input, textarea, select").each(function () {
        console.log(this);
        $(this).prop('disabled', true);
        $(this).prop('required', false);
    });

});


$('button[name="fillWorkOrder"]').on('click', function (e) {
    console.log(e);
    var route = $(this).data("route");

    var params = {
        type: "GET",
        url: route,
        loadingSelector: $(this).closest("div"),
        successCallback: function (data) {


            $("#selectOrden #id_pmo_work_table").val(data.data.id);
            $("#selectOrden select[name='work_id']").val(data.data.work_id).change();
            $("#selectOrden select[name='worktype_id']").val(data.data.worktype_id).change();
            $("#selectOrden select[name='executor_category_id']").val(data.data.executor_category_id).change();
            $("#selectOrden select[name='equipment_id']").val(data.data.equipment_id).change();
            $("#selectOrden input[name='deadline']").val(data.data.deadline);

        },
        errorCallback: function (error) {
            console.log("entro");
        }
    };
    $.ajaxSimple(params);

});
