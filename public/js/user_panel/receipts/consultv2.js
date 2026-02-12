$(function () {
    $("#barcode").inputmask("99999999999");

    $("#frmConsult").parsley();


    //Autocomplete contract input
    $("#barcode").on("change", function (e) {
        var value = $("#contract");
        value.val($(this).val().substring(0, 10));
        return false;
    });

    $(document).ready(function () {
        $("#pay-method").hide();
    });

    //Pay receipt, open modal
    $(document).on("click", "#consultOtherReceipt", function (e) {

        $("#pay-method").hide("slow", function showNext() {
            $('#receiptUrl').attr('src', '');
            $('#btnGeneratePdf').data('receipt','');

            $('#barcode').val('');
            $('#contract').val('');

            $("#consultOtherReceipt").attr("disabled");
            $("#consult-receipt").show("slow");

            $("#ownerDetail").html("<b>Pago de Recibo</b>");
            $("#receiptAmount,#receiptBoard,#receiptTotal").html("");
        });

    });

    $("#contract, #contract2, #contract3").on("keydown",function (e) {
        var code = e.keyCode || e.which;
        if(code == 173) { //Enter keycode
            //Do something
            var id = $(this).attr("id");
            //console.log(id);
            if(id == "contract"){
                $("#contract2").focus();
                event.preventDefault();
            }else if(id == "contract2"){
                $("#contract3").focus();
                event.preventDefault();
            }else{
                $("#frmConsult").focus();
                event.preventDefault();
            }
        }
    });

    $("#frmConsult").on("submit", function (e) {

        var valid = $("#frmConsult").parsley().isValid();
        //console.log(valid)
        //postData('/click',{})
        //let _token = document.getElementsByName('_token')[0].value;
        //if(_token) registraClick(_token);
        if (valid) {
            e.preventDefault();
            var contrato_consultado = $("#contract").val() + "-" + $("#contract2").val() + "-" + $("#contract3").val();
            var route = $('#receiptSearch').data("route");
            var params = {
                type: "POST",
                url: route,
                form: $("form[name='frmConsult']"),
                loadingSelector: $(this).closest("div"),
                crud: "Notificación",
                successCallback: function (data) {
                    muestra_oculta('receipt-contrac');
                     //console.log(data.receiptContract==contrato_consultado);
                     // console.log(data.receiptContract);
                     //console.log(contrato_consultado);
                     
                    console.log({data});
                    let contrato_correcto= data.clave==contrato_consultado;
                    console.log(data.clave);
                    //console.log(contrato_consultado) ;
                    
                    
                    if(contrato_correcto===false){
                        let dis = document.getElementsByClassName("panel-body");
                        dis[0].innerHTML = `<div class="texto-no-encontrado">Lo sentimos, los datos introducidos <b>"${contrato_consultado}"</b> no coinciden, favor de verificar e <a href="https://www.japammovil.com/tcs/public/receipts/searchGuest">intentar nuevamente</a></div>`;
                        setTimeout(()=>{
                            let borrar_div = document.getElementById("consult-receipt");
                        borrar_div.innerHTML ="";
                        },100);
                        return;
                       // console.log("Los datos introducidos no coinciden , favor de verificar e intentar nuevamente");
                    }
                    
                    //console.log('---');
                    //console.log(data);
                    $("#btnGeneratePdf").data('receipt', data.receiptId);
                    $("#receiptUrl").attr("src", '');

                    $("[name='receipt_number']").val(data.receiptId);
                    $("[name='amount']").val($.numberFormat(data.receiptAmount));
                    $("[name='subtotal']").val($.numberFormat(data.receiptAmount));
                    $("[name='description']").val("Pago de Servicios. Contrato #" + data.receiptContract + ". Periodo de Consumo: " + data.receiptConsumptionPeriod);
                    $("[name='direccion']").val(data.direccion);


                    $("[name='consumptionPeriod']").val(data.receiptConsumptionPeriod);
                    $("[name='contract']").val(data.receiptContract);
                    $("[name='barcode']").val(data.receiptBarcode);
                    $("[name='isExpiration']").val(data.receiptIsExp);


                    $("[name='name']").val(data.firstname);
                    $("[name='lastname']").val(data.lastname);

                    $("[name='street']").val(data.receiptStreet);
                    $("[name='receiptStreet']").text(data.receiptStreet);
                    $("[name='outsideNum']").val(data.receiptOutsideNum);
                    $("[name='receiptOutsideNum']").text(data.receiptOutsideNum);
                    $("[name='settlement']").val(data.receiptSettlement);
                    $("[name='receiptSettlement']").text(data.receiptSettlement);

                    var fecha_vencimiento =data.vencimiento;
                    let url_cumplido = data.urlQrCumplido;
                    let url_normal = data.urlQrNormal;
                    var cb_oxxo = data.cb_oxxo;
                    console.log(cb_oxxo);
                    var a_tiempo ;
                    if(fecha_vencimiento === "INMEDIATO"){
                        a_tiempo = false;
                    }
                    else {
                        let fecha_hoy = new Date();
                        fecha_vencimiento = convertir(fecha_vencimiento);
                        fecha_vencimiento.setHours(23,59,0,0);
                        fecha_hoy.setHours(23,59,0,0);
                        console.log(fecha_vencimiento);
                        console.log(fecha_hoy);
                        
                        if(fecha_hoy > fecha_vencimiento){
                            a_tiempo = false;
                        }else {
                            a_tiempo = true;
                        }
                        //console.log('Status ='+a_tiempo)
                    }
                    ///  Validacion con meses de adeudo mayor a uno debe de ser no a tiempo

                    if (parseInt(data.mesesDeAdeudo)> 1){
                        a_tiempo = false;
                    }
                    console.log("------");
                    console.log(parseInt(data.mesesDeAdeudo));
                    
               
                    
               
                    var today = new Date();
                    var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth()+1, 0);
                    console.log(lastDayOfMonth);
                    console.log(today);

                    if (today > lastDayOfMonth){
                        let ultimo_dia = true;
                        console.log(ultimo_dia);
                        console.log("Debe mostrar mensaje que no sirven ligas");
                        $('#btnRedirectBanco').hide();
                    
                        $('#moduloPagar').html('<p>Ah expirado tu fecha de límite de pago por cierre de mes, te invitamos a realizar el pago en nuestras oficinas.</p>');
                    
                    } else {
                        let ultimo_dia = false;
                        console.log(ultimo_dia);
                        console.log("si sirven ligas");
                    }



                  

                    //console.log(fecha_vencimiento)
                    var total_correcto = data.totalNormal;
                    //console.log(total_correcto)
                    if(a_tiempo) total_correcto = data.totalCumplido
                    //console.log(total_correcto)




                    if(data.tarifa==="Domestico" || data.tarifa==="Japam" ){ $("#ownerDetail").html(
                        `
                        <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="panel-heading text-center">
                                <b>Datos del titular</b>
                            </div>
                        </div>
                        
                        <div style="padding: 0%" class="panel-body">
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Contrato:</div>
                            <div class="col-md-3"><b>${data.clave}</b></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Número del recibo:</div>
                            <div class="col-md-3">${data.receiptId}</div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Nombre del titular:</div>
                            <div class="col-md-3"><b>${data.receiptName}</b></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Dirección:</div>
                            <div style="margin-bottom: 3%;" class="col-md-3">${data.direccion}</div>
                        </div>
                        <hr style="height: 10%; width: 100%; background: black">
                        <div style="padding-top: 0%" class="panel-heading text-center">
                                <b>Datos del Recibo</b>
                        </div>
                        <div>
                            <div style="text-align: left" class="col-md-2">Tarifa:</div>
                            <div class="col-md-4"><b>${data.tarifa}</b></div>
                            <div style="width: 100%" class="col-md-6"></div>
                        </div>
                        <div style="margin-bottom: 4%">
                            <div style="text-align: left" class="col-md-2">Giro:</div>
                            <div class="col-md-4">${data.giro}</div>
                            <div style="width: 100%;" class="col-md-6"></div>
                        </div>
                         <div style="margin-bottom: 4%">
                            <div style="text-align: left" class="col-md-2">Estatus del recibo:</div>
                            <div class="col-md-4" style='font-weight:500;font-size:1.2em;color: ${data.status==='No Pagado'?'darkorange':'green'};'>${data.status} <img src=${data.status==='No Pagado'?'https://japammovil.com/img/no_pagado.svg':'https://japammovil.com/img/pagado.svg'} /></div>
                            <div style="width: 100%; margin-bottom: 3%;" class="col-md-6"></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Fecha de vencimiento:</div>
                            <div class="col-md-2"><b>${data.vencimiento}</b></div>
                        </div>
                        <div style="margin-bottom: 4%">
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Consumo:</div>
                            <div class="col-md-2">${data.consumo} M<sup>3</sup></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Periodo facturado:</div>
                            <div class="col-md-2">${data.periodo}</div>
                        </div>
                         <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Meses de adeudo:</div>
                            <div style="padding-bottom: 3%; ${data.mesesDeAdeudo>1?'color:darkorange;':''} " class="col-md-2"><b>${data.mesesDeAdeudo}</b></div>
                        </div>
                        
                        </div>
                        </div>
                     
                        <hr style="height: 10%; width: 100%; background: black">
                        
                        
                    `);
                    
                    if(a_tiempo)$("#ownerDetail").html($("#ownerDetail").html()+`<div style="padding-top: 0%" class="panel-heading text-center">
                                <b>Compare ahorro</b>
                        </div>
                        <div class="card text-center">
                         <table>
                            <tr>
                                <td class="col-md-8">
                                   
                                 <h5><b>Aprovecha el PROGRAMA de apoyo  usuario cumplido. Si pagas antes de la fecha de vencimiento el monto es de: </b></h5>
                                </td>
                                
                                <td>
                                 <h3 id="total_cumplido" style="color: green; ">${data.totalCumplido}</h3>
                                </td>
                            </tr>
                            
                         </table>
                            <div class="col-md-8">
                                <h5><b>Despues de la fecha de vencimiento el monto es de: </b></h5>
                            </div>
                            <div class="col-md-4">
                                <h3 id="total_normal" style="color: green;">${data.totalNormal}</h3>
                            </div>
                        </div>`);
                    }
                    ///   ELSE CASO QUE SEA COMERCIAL.... u otro
                    else {

                        $("#ownerDetail").html(
                            `
                        <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="panel-heading text-center">
                                <b>Datos del titular</b>
                            </div>
                        </div>
                        
                        <div style="padding: 0%" class="panel-body">
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Contrato:</div>
                            <div class="col-md-3">${data.clave}</div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Número del recibo:</div>
                            <div class="col-md-3">${data.receiptId}</div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Nombre del titular:</div>
                            <div class="col-md-3">${data.receiptName}</div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-3">Dirección:</div>
                            <div style="margin-bottom: 3%;" class="col-md-3">${data.direccion}</div>
                        </div>
                        <hr style="height: 10%; width: 100%; background: black">
                        <div style="padding-top: 0%" class="panel-heading text-center">
                                <b>Datos del Recibo</b>
                        </div>
                        <div>
                            <div style="text-align: left" class="col-md-2">Tarifa:</div>
                            <div class="col-md-4">${data.tarifa}</div>
                            <div style="width: 100%" class="col-md-6"></div>
                        </div>
                        <div style="margin-bottom: 4%">
                            <div style="text-align: left" class="col-md-2">Giro:</div>
                            <div class="col-md-4">${data.giro}</div>
                            <div style="width: 100%;" class="col-md-6"></div>
                        </div>
                         <div style="margin-bottom: 4%">
                            <div style="text-align: left" class="col-md-2">Estatus del recibo:</div>
                            <div class="col-md-4" style='font-weight:500;font-size:1.2em;color: #043ca5;'>${data.status}</div>
                            <div style="width: 100%; margin-bottom: 3%;" class="col-md-6"></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Fecha de vencimiento:</div>
                            <div class="col-md-2">${data.vencimiento}</div>
                        </div>
                        <div style="margin-bottom: 4%">
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Consumo:</div>
                            <div class="col-md-2">${data.consumo} M<sup>3</sup></div>
                        </div>
                        <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Periodo facturado:</div>
                            <div class="col-md-2">${data.periodo}</div>
                        </div>
                         <div>
                            <div class="col-md-6"></div>
                            <div style="text-align: right" class="col-md-4">Meses de adeudo:</div>
                            <div style="padding-bottom: 3% " class="col-md-2">${data.mesesDeAdeudo}</div>
                        </div>
                        
                        </div>
                        </div>
                     
                        <hr style="height: 10%; width: 100%; background: black">
                        
                        <div style="padding-top: 0%" class="panel-heading text-center">
                                <b>Compare ahorro</b>
                        </div>
                         <div class="card text-center">
                         
                            <div class="col-md-8">
                                <h4><b>Total a pagar : </b></h4>
                            </div>
                            <div class="col-md-4">
                                <h3 id="" style="color: green;">${data.totalNormal}</h3>
                            </div>
                        </div>
                  
                    `);

                    }



                    let total_grande = document.getElementById("total_grande");
                    total_grande.innerHTML= "$ "+ formato_precio(total_correcto)
                    //console.log(total_correcto)

                    setTimeout(()=>{
                        if (total_correcto == parseInt("0.00") || data.status ==='Pagado'){
                            let moduloPagar = document.getElementById("moduloPagar");
                            moduloPagar.innerHTML= "El recibo ya fue pagado o no cuenta con adeudos."
                            //console.log(total_correcto)
                        }
                        

                        
                        if (a_tiempo === true){
                            
                            var el = document.getElementById("total_normal");

                            if(el)el.style.color = 'gray';
                        } else {
                            var lo = document.getElementById("total_cumplido");
                            if(lo)lo.style.color ='gray';
                        }

                    },300)



                    ///   VALIDACION DE CASOS QUE TIENEN TARIFA QUE NO ES DOMESTICO NI JAPAM
                    if(data.tarifa!="Domestico" && data.tarifa !="Japam" ) total_correcto =data.totalNormal;

                    $("#receiptAmount").html("$" + $.numberFormat(data.receiptAmount));
                    /*$("#receiptBoard").html("$" + $.numberFormat(data.payment.headers.board));*/
                    $("#receiptTotal").html("<h3 class='text-left' style='font-weight: 300;color: white; margin: 0%'>TOTAL A PAGAR</h3>" + "<b style='text-align:right;color: white;font-size:2.2em;font-weight:500;'>"+"$"+  $.numberFormat(total_correcto)+"</b>");
                    //      aqui lo que sigue de cb_oxxo
                    $("#btnRedirectBanco").attr("target", '_blank');
                    if (a_tiempo &&  cb_oxxo && cb_oxxo !="") {
                        $("#messagePaid").html('');
                        $("#consult-receipt").hide("slow", function showNext() {
                            $("#consultOtherReceipt").removeAttr("disabled");
                            $("#pay-method").show("slow");
                        });
                  
                  
                        $("#btnRedirectBanco").attr("href", url_cumplido);
                        datoGuardado = guardarDato(data);

                    } else {
                        $("#messagePaid").html('');
                        $("#consult-receipt").hide("slow", function showNext() {
                            $("#consultOtherReceipt").removeAttr("disabled");
                            $("#pay-method").show("slow");
                        });
                        
                    
                        $("#btnRedirectBanco").attr("href",url_normal);
                        
                        
                        datoGuardado = guardarDato(data);
                       
                        
                        /*
                        if (data.urlPay != ""){
                            // $("#btnRedirectBanco").attr("href", data.payment.urlPay);
                        }else{
                            $("#btnRedirectBanco").addClass("hidden");
                        }
*/

                        if(total_correcto >0) {$("#messagePaid").html("<div class='alert alert-success fade in'>" +
                            "                            <i class='fa fa-check fa-2x pull-left'></i>" +
                            "                            <p style='font-weight:500;font-size:1.2em;color: #043ca5;'> Pagado</p>" +
                            "                        </div>")
                        }
                            else{
                                $("#messagePaid").html("<div class='alert alert-success fade in'> No presenta adeudos                        </div>")
                            }

                    }
                     if(  $("#btnRedirectBanco").attr("href")==="" || cb_oxxo==null || cb_oxxo =="" ||  parseInt(data.mesesDeAdeudo) >3 ){
                        var btn2 = document.getElementById("btnRedirectBanco");
                        console.log("****-*-*")
                        if(btn2!=null) {

                        btn2.style=visivility="hidden";
                        var moduloPagar = document.getElementById("moduloPagar");
                        moduloPagar.innerHTML= "<button type=\"button\" class=\"btn btn-success btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-usd\"></i> Pagar recibo</button>"
                        }
                        //btn2.href="https://avisojapam.japammovil.gob.mx/";
                        //btn2.innerText = "Pagar recibo";


                        //$("#btnRedirectBanco").attr("href") = "https://avisojapam.japammovil.gob.mx/"
                        // var moduloPagar = document.getElementById("moduloPagar");
                        //    moduloPagar.innerHTML= "<a href='https://avisojapam.japammovil.gob.mx/'>Más información</a>"
                    }
                    
                   



                },
                errorCallback: function (error) {
                    //console.log(error);
                }
            };
            $.ajaxSimple(params);


        }

        return false;
    });


});


function registraClick(token){
    
    //console.log(token);
    postData('./../clicks',{click_consulta_web:1,_token:token})
    .then((res)=>{
        //console.log(res);
    })
}



function formato_precio(precio) {
    if(precio==undefined)return "0.00";
    precio= parseFloat(precio);
    if(precio=="" || isNaN(precio))return "0.00";
    var precio_txt = precio.toLocaleString("en-US", {
        style: "decimal",
        maximumFractionDigits: 2,
        minimumFractionDigits: 2
    });
    if (precio == 0) return "0.00";
    return  precio_txt;
}

function convertir(fechatxt){
    var array = fechatxt.split("/");
    var fecha_correcta = new Date(array[1]+"/"+array[0]+"/"+array[2]);
    return fecha_correcta;
}

function guardarDato(data){
    console.log("entra a funcion");
    console.log(data);
    var route = $('.saveMetrics');
   route.attr("action", "/tcs/public/saveClick");
    $("#saveMetrics").data('action', '/tcs/public/saveClick');


    $(document).on('click', '#btnRedirectBanco', function () {

        $("#name").val(data.receiptName);
        $("#contractSave").val(data.receiptContract);
        $("#site").val('web');
        $("#boton_type").val('ligaPago');
        $('.saveMetrics').click();

        console.log("btnRedirectBanco");
    });

    $(document).on('click', '#btnGeneratePdf', function () {

        $("#name").val(data.receiptName);
        $("#contractSave").val(data.receiptContract);
        $("#site").val('web');
        $("#boton_type").val('generarPdf');
        $('.saveMetrics').click();

        console.log("btnGeneratePdf");
    });


    $("#saveMetrics").on("submit", function (e) {
        var valid = $("#saveMetrics").parsley().isValid();

        if (valid) {
        //    console.log("vas a llamar a la funcion de php")
          //  saveMetric();
        }

        return false;
    });
}

function saveMetric() {
    //$("input[name='_method']").val($(".saveMetrics").data("action") == '/saveClick' ? 'POST' : 'PATCH');
    $("input[name='_method']").val($("#saveMetrics").data("action") == '/tcs/public/saveClick' ? 'POST' : 'PATCH');

    var url = '/tcs/public/saveClick';

    $.ajaxFormData({
        crud: 'Metrics',
        type: 'POST',
        url: url,
        form: "saveMetrics",
        loadingSelector: "#metrica",
        successCallback: function (data) {
            $(".buttons-reload").click();
        },
        errorCallback: function (data) {
        }
    });
}


/// Post async usado en muchas partes
async function postData(url = '', data = {}) {
  // Default options are marked with *
  const response = await fetch(url, {
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    mode: 'cors', // no-cors, *cors, same-origin
    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    credentials: 'same-origin', // include, *same-origin, omit
    headers: {
      //'Content-Type': 'application/json'
       'Content-Type': 'application/x-www-form-urlencoded',
    },
    redirect: 'follow', // manual, *follow, error
    referrerPolicy: 'no-referrer', // no-referrer, *client
    body: JSON.stringify(data) // body data type must match "Content-Type" header
  });
  return await response; // parses JSON response into native JavaScript objects
}
