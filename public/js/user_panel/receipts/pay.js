

$(function () {


    //-----------INIT COMPONENTS-----------------------
    var elem = document.querySelector('#rememberCard');
    var switchery = new Switchery(elem);
    $("#frmCard,#frmStore").parsley();
    var payStatus = $("#DATA").data("receipt-status");

    //----------END INIT COMPONENTS--------------------


    //-----------------INIT CONFIGS---------------------
    if (payStatus == 'free')
        isLocationSet().catch(function () {
        });

    SrPago.setLiveMode(false);
    SrPago.setPublishableKey('pk_dev_5ab2b4328cb998JLdt');

    /*
    Llaves produccion

    SrPago.setLiveMode(true);
    SrPago.setPublishableKey('pk_live_5ab40149459fcw!2Z?');

    */

    //----------------END INIT CONFIGS------------------


    //-----------------PROMISE FUNCTIONS-----------------
    //Check if location was get
    function isLocationSet() {

        var location = {
            'lat': $('input[name="lat"]'),
            'lng': $('input[name="lng"]')
        };

        return new Promise(function (resolve, reject) {
            if (location.lat.val() && location.lng.val()){
                resolve(true);
            }else{
                if (navigator.geolocation) {
                    $.setLoading('body', "Obteniendo ubicación, espere un momento...");
                    navigator.geolocation.getCurrentPosition(function (position) {

                        location.lat.val(position.coords.latitude);
                        location.lng.val(position.coords.longitude);

                        $('body').unblock();

                        resolve(true);

                    }, function (PositionError) {
                        var message = '';
                        $('body').unblock();
                        switch (PositionError.code) {
                            case 1:
                                message = 'Por motivos de seguridad la aplicación necesita obtener tu ubicación para procesar el pago';
                                break;
                            case 2:
                                message = 'Ocurrió un error al obtener la ubicación, por favor intenta nuevamente';
                                break;
                            case 3:
                                message = 'Tiempo de espera agotado para obtener la ubicación, por favor intenta nuevamente';
                                break;

                        }
                        toastr.error(message, 'Pago de Recibo', {timeout: 10000});
                        reject({errorMessage: message});

                    }, {
                        enableHighAccuracy: false,
                        maximumAge: Infinity,
                        timeout: 90000
                    });

                } else {
                    const message = 'Por motivos de seguridad la aplicación necesita obtener tu ubicación para procesar el pago, por favor cambia de navegador.';
                    $('body').unblock();
                    toastr.error(message, 'Pago de Recibo', {timeout: 10000});
                    reject({errorMessage: message});
                }
            }
        });


    }


    //Tokenize credit/debit card
    function tokenizeCard() {

        return new Promise(function (resolve, reject) {

            //Create card token
            var card = {
                number: $('input[name="number"]').val(),
                holder_name: $('input[name="owner"]').val(),
                cvv: $('input[name="cvv"]').val(),
                exp_month: $('input[name="exp_month"]').val(),
                exp_year: $('input[name="exp_year"]').val()
            };

            $.setLoading('.tab-content', "Procesando tarjeta, por favor espere...");
            SrPago.token.create(card, function (result) {
                //Vaya Joya by Jesus
                $('input[name="number"]').val('');
                $('input[name="owner"]').val('');
                $('input[name="cvv"]').val('');
                $('input[name="exp_month"]').val('');
                $('input[name="exp_year"]').val('');


                $("input[name='token']").val(result.token);
                resolve(true);

            }, function (error) {
                var cardError = JSON.parse(error.responseText);

                $('.tab-content').unblock();

                reject({errorMessage: "Error al procesar la tarjeta," + cardError.error.message});
            });


        });

    }


    //Ajax request to process the payment
    function payRequest(form, type) {

        return new Promise(function (resolve, reject) {

            $.ajaxSimple({
                type: 'POST',
                crud: 'Pago de Servicio',
                url: $("#page").data("url") + '/receipts/processPay/' + type,
                loadingSelector: ".tab-content",
                form: '#' + form,
                successCallback: function (data) {

                    $('#page-loader').removeClass('hide');
                    setTimeout(function () {
                        location.href = data.redirect;
                    }, 4000);

                    resolve(true);

                }, errorCallback: function (data) {

                    reject({errorMessage: data.errorMessage});

                    if (data.errorMessage)
                        toastr.error(data.errorMessage, "Pago de Recibo");
                }

            });
        });


    }

    function crear_el_pdf(blob) {
        const doc = new PDFDocument();
        const stream = doc.pipe(blobStream());

        doc
            .text(
                "$ " + "Hola", 10, 10

            )
            .fill("black", "even-odd")
            .fontSize(7)
            .restore();
        blob = "data:image/jpeg;base64," + blob
        //doc.image(blob, 100, 100, {width: 100}); // this will decode your base64 to a new buffer
        doc.image('data:image/png;base64,pdfData',10,10,{width:500})

        //------------------------------- //  Termina el pdf   **--------
        doc.end();

        stream.on("finish", () => {
            const blob = stream.toBlob("application/pdf");

            url = stream.toBlobURL("application/pdf");
            let iframe = document.getElementById("receiptUrl")
            iframe.src =url
            //console.log(url);
            //iframe.src =url;
            let cargando = document.getElementById("cargando")
            cargando.innerHTML = ""

        });

    }


    function quitar_enters(base64  ){
        return new Promise(async(resolve,reject)=>{
            let res = await JSON.parse(JSON.stringify( base64));
            res = await res.replace('\r\n','');
            resolve(res);
        })
    }

    function generatePdf(receiptId){
        return new Promise(function (resolve, reject) {
            if($('#receiptUrl').attr('src')){
                resolve(true);
            }else{
                $.ajaxSimple({
                    type: 'GET',
                    crud: 'Generar PDF del Recibo',
                    url: $("#page").data("url") + '/receipts/generateReceiptPDF/' + receiptId,
                    //loadingSelector: ".tab-content",
                    successCallback: async function  (data) {
                        //console.log(data);
                        var pdfData = atob(
                            data.result[0]
                        );
                        const base64 = data.result[0] ;
                        //console.log(base64);

                       // var bin = atob(pdfData.replace('\r\n',''));

                        const pdfescapeado =  await quitar_enters(base64);

                        //console.log(pdfescapeado.substr(0,50));

                        // Insert a link that allows the user to download the PDF file
                        var link_existente = document.getElementById("link_descarga");
                        var link ;
                        if(link_existente===null || link_existente === undefined ) link= document.createElement('a');
                        else link = link_existente;
                        
                        link.innerHTML = 'Descargar PDF';
                        link.download = 'ReciboDigital.pdf';
                        link.href = 'data:application/octet-stream;base64,' + pdfescapeado;
                        link.id ="link_descarga";
                        link.className += "btn btn-danger";
                        
                        let domlink = document.getElementById("link");
                        domlink.appendChild(link);
                        
                       
                         let boton = document.getElementById("btnGeneratePdf");
                        if(boton != null){
                            boton.innerHTML = "\n                <i class=\"fa fa-file-pdf-o\"></i> Ver PDF\n            ";
                            boton.disabled = false;
                        }
                        
                  

                        let btn_descarga_pdf = document.getElementById('btn_descarga_pdf');
                       // setTimeout(()=>{
                            //btn_descarga_pdf.href="data:application/octet-stream;base64,"+pdfescapeado},500)


                        //
                        // The workerSrc property shall be specified.
                        //
                        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.487/pdf.worker.min.js';

                        // Opening PDF by passing its binary data as a string. It is still preferable
                        // to use Uint8Array, but string or array-like structure will work too.
                        pdfjsLib.getDocument({data: pdfData}).then(function getPdfHelloWorld(pdf) {
                            // Fetch the first page.
                            pdf.getPage(1).then(function getPageHelloWorld(page) {
                                var scale = 1.5;
                                var viewport = page.getViewport(scale);

                                // Prepare canvas using PDF page dimensions.
                                var canvas = document.getElementById('receiptUrl');
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                // Render PDF page into canvas context.
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                            });
                            //  jQuery('#signup').val('Register');
                            resolve(true);
                        });
                    }
                });
            }
        });
      /*  return new Promise(function (resolve, reject) {
            if($('#receiptUrl').attr('src')){
                resolve(true);
            }else{
                $.ajaxSimple({
                    type: 'GET',
                    crud: 'Generar PDF del Recibo',
                    url: $("#page").data("url") + '/receipts/generateReceiptPDF/' + receiptId,
                    //loadingSelector: ".tab-content",
                    successCallback: function (data) {
                        console.log(data);
                        var pdfData = atob(
                            data.result[0]
                        );
                        console.log(pdfData);
                        crear_el_pdf(pdfData)
                        }
                });
            }
        }); */
    }

    //-------------END PROMISE FUNCTIONS ---------------


    //---------------------EVENTS-----------------------
    //Set store selected class and value on input form
    $('.store').on("click", function () {
        $('.store').removeClass("store-selected");
        $(this).addClass('store-selected');
        $("input[name='store']").val($(this).data("store"));
        return false;
    });

    $('#btnGeneratePdf').on('click', function (e) {
        e.preventDefault();
        generatePdf($(this).data('receipt')).then(function () {
            $('#modalReceiptPdf').modal('show');
        }).catch(function () {
        });
    });

    //Submit store pay
    $("#frmStore").on("submit", function (e) {
        var valid = $("#frmStore").parsley().isValid();

        if (valid) {
            e.preventDefault();

            isLocationSet().then(function () {
                payRequest('frmStore', 'store').then(function () {
                    $('.store').removeClass("store-selected");
                    $("#frmStore input[name='email']").val('');
                    $("#frmCard input[name='phoneNumber']").val('');

                }).catch(function () {

                });
            }).catch(function () {

            });


        }

        return false;
    });

    //Submit card pay
    $("#frmCard").on("submit", function (e) {
        var valid = $("#frmCard").parsley().isValid();

        if (valid) {
            e.preventDefault();

            isLocationSet().then(function () {

                tokenizeCard().then(function () {

                    payRequest('frmCard', 'card').then(function () {
                        $("#cards div").removeClass("hidden");
                        $("#frmCard input[name='email']").val('');
                        $("#frmCard input[name='phoneNumber']").val('');

                    }).catch(function () {

                    });

                }).catch(function (error) {
                    toastr.error(error.errorMessage, "Pagos de recibo", {timeout: 10000});

                });
            }).catch(function () {

            });

        }

        return false;
    });

    function converBase64toBlob(content, contentType) {
        contentType = contentType || '';
        var sliceSize = 512;
        var byteCharacters = window.atob(content); //method which converts base64 to binary
        var byteArrays = [
        ];
        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);
            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
        var blob = new Blob(byteArrays, {
            type: contentType
        }); //statement which creates the blob
        return blob;
    }


    //---------------------END EVENTS-------------------
})
;