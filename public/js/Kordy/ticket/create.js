var map, lat, lng, service, geocoder, ctaLayer, markersSearch,
    markers = [], directionsDisplayMe, directionsServiceMe, directionsDisplayDestiny,
    directionsServiceDestiny, infoWindow = null,
    iconUrl = $('#page').data('url') + "/img/ico/";
$(document).ready(function () {
    FormSliderSwitcher.init();

    "use strict";

    //Siguiente indice al que me quiero mover dentro de los pasos del formulario
    var nextIndex = 0;
    $(".container ul li").on('click', function (e) {
        nextIndex = $(this).data('id');
    });

    $("#wizard").bootstrapWizard({
        onTabChange: function (tab, navigation, index) {
            if (index !== -1 && nextIndex > index) {
                if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-" + (index + 1))) {
                    tab.removeClass('done');
                    return false;
                } else {
                    if (index === 2)
                        validateReceipt($("#contract").val());
                    tab.addClass('done');
                    return true;
                }
            }
        },
        onNext: function (tab, navigation, index) {
            nextIndex = index;
        },
        onPrevious: function (tab, navigation, index) {
            nextIndex = index;
        }
    });

    $("textarea.summernote-editor").summernote({
        lang: 'es-ES',
        height: 200,
        codemirror: {theme: 'monokai', mode: 'text/html', htmlMode: true, lineWrapping: true},
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'strikethrough', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            // ['insert', ['picture']],
            ['view', ['help']]
        ],
        // disableDragAndDrop: true,
        placeholder: 'Descripción del problema...',
        focus: true
    });

    $("#cp").inputmask("99999");
    $("#meter").inputmask("99999[9][9][9]");
    //$("#barcode").inputmask("99999999999");
    $("#contract").inputmask("99999-99999-9[9][9][9][9][9][9]");
    $("#phone").inputmask("(999) 999-9999");

    $('select').select2({
        width: '100%',
        language: 'es'
    });

    $('#btnSave').on('click', function () {
        getAppTicketAddress();
        var params = {
            type: 'POST',
            url: $(this).data('route'),
            loadingSelector: $("#wizard"),
            form: $("#createTicket"),
            crud: 'Respuesta del servidor',
            successCallback: function (data) {
                swal({
                    title: data.title,
                    text: data.content,
                    type: "success",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Continuar"
                }, function () {
                    window.location.href = data.load;
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

    //Evento para resaltar los tiquets seleccionados durante el merge (Para los tiquets más próximos)
    $(document).on('click', '.merge_ticket', function () {
        var id = $(this).data('id');
        if ($(this).hasClass('bg-silver')) {
            $(this).removeClass('bg-silver');
            $("#mergeTicket").val(null);
        } else {
            $(".merge_ticket").removeClass('bg-silver');
            $(this).addClass('bg-silver');
            $("#mergeTicket").val(id);
        }
    });

    if ($("input[name='app_ticket[latitude]']").val() !== null && $("input[name='app_ticket[longitude]']").val() !== null) {
        lat = parseFloat($("#latitude").val());
        lng = parseFloat($("#longitude").val());
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(lat, lng),
            zoom: 14,
            styles: [{
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#444444"}]
            }, {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2f2f2"}]}, {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{"visibility": "on"}]
            }, {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{"saturation": -100}, {"lightness": 45}]
            }, {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{"visibility": "simplified"}]
            }, {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]}],
            mapTypeControl: false
        });

        geocoder = new google.maps.Geocoder;

        ctaLayer = new google.maps.KmlLayer();
        infoWindow = new google.maps.InfoWindow();
        service = new google.maps.places.PlacesService(map);
        directionsDisplayDestiny = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsServiceDestiny = new google.maps.DirectionsService();
        directionsDisplayMe = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsServiceMe = new google.maps.DirectionsService();


        map.addListener('click', function (e) {
            var pos = e.latLng;
            getLocationWithClick(pos);
        });
        //Agregamos el punto de geolocalización en el mapa
        getAppTicketAddress();
        var pos = {
            lat: lat,
            lng: lng
        };
        var icon = 'destino_36.png';
        var place = '<div><i class="fa fa-map-marker txt-color-3">&nbsp;</i>Ubicación.<br><strong>' + $("#searchAddress").val() + '</strong></div>';
        addMarkers(pos, icon, place, 100);
    }

    $("#btnSearchAddress").on('click', function () {
        getAppTicketAddress();
        foundLocationAddres();
    });
});

function getLocationWithClick(pos) {

    var icon = 'destino_36.png';

    geocoder.geocode({'location': pos}, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                var place = '<div><i class="fa fa-map-marker txt-color-3">&nbsp;</i>Ubicación.<br><strong>' + results[0].formatted_address + '</strong></div>';

                ctaLayer.setMap(null);
                $('#iconInfo').show();
                $('#detailTravel').hide();
                //directionsDisplayMe.set('directions', null);
                //directionsDisplayDestiny.set('directions', null);
                $('#btnViewNearbyStops').prop('disabled', true);
                addMarkers(pos, icon, place, 100);
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function addMarkers(pos, icon, nameContent, timeout) {
    //console.log(markerType);
    if (markersSearch !== undefined)
        markersSearch.setMap(null);
    window.setTimeout(function () {
        var mark = new google.maps.Marker({
            position: pos,
            map: map,
            icon: iconUrl + icon, //los iconos deben de estar almacenados en img/ico
            animation: google.maps.Animation.DROP,
            title: 'UBICACIÓN DEL PROBLEMA'
        });
        google.maps.event.addListener(mark, 'click', (function (mark, nameContent) {
            return function () {
                infoWindow.open(map, mark);
                infoWindow.setContent(nameContent);
            }
        })(mark, nameContent));
        map.setCenter(pos);
        markersSearch = mark;
        if ($("#txtIdAppTicket").val() === '') {
            $("#latitude").val(pos.lat);
            $("#longitude").val(pos.lng);
        }
        $("#latitudeTicket").val(pos.lat);
        $("#longitudeTicket").val(pos.lng);
        similarTiquets();
    }, timeout);
}

function validateReceipt(contract) {
    var flag = false;
    //http://45.5.52.145:1022/datasnap/rest/TWebAcces/GetMRecibo/65049-65996-151639/
    //'http://45.5.52.145:1022/datasnap/rest/TWebAcces/ValEanContrato/' + contract + '/' + barcode + '/'
    if (contract.length > 0) {
        var params = {
            type: 'GET',
            url: $("#page").data('url') + '/tickets/get/holder/' + contract,
            loadingSelector: $("#wizard"),
            form: null,
            crud: 'Respuesta del servidor',
            successCallback: function (data) {
                $(".errorRecipt").addClass('hidden');
                $("#lblHeadline").text(data.name);
                $("#txtHeadline").val(data.name);
                $("#meter").val(data.medidor);
                flag = true;
            },
            errorCallback: function (error) {
                $(".errorRecipt").removeClass('hidden');
                $("#lblHeadline").text('N/A');
                $("#txtHeadline").val();
                console.log('Error.');
            }
        };
        $.ajaxSimple(params);
    } else {
        $(".errorRecipt").removeClass('hidden');
    }
    return flag;
}

$("#step2").find("input").each(function () {
    $(this).on("change", function (e) {
        getAppTicketAddress();
    })
});

$("#suburb").on('change', function (e) {
    if ($("#txtIdAppTicket").val() === '') {
        getAppTicketAddress();
        foundLocationAddres();
    }
});


function foundLocationAddres() {
    if ($("#suburb").val() !== '') {
        geocoder.geocode({
            'address': $("#searchAddress").val()
        }, function (results, status) {
            if (status === 'OK') {
                //console.log(results);
                if (results[0]) {
                    //console.log(results[0]);
                    map.setCenter(results[0].geometry.location);
                    var icon = 'destino_36.png';
                    var place = '<div><i class="fa fa-map-marker txt-color-3">&nbsp;</i>Ubicación.<br><strong>' + results[0].formatted_address + '</strong></div>';

                    addMarkers(results[0].geometry.location, icon, place, 100);
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    }
}

function getAppTicketAddress() {
    var concatAddress = $("#street").val() + " #" + $("#outside_number").val().replace(/^\D+/g, '') + ", ";
    if ($("#suburb").val() !== '')
        concatAddress += $("#suburb option:selected").text() + ", " + $("#cp").val() + ", San Juan del Río,Querétaro";
    else
        concatAddress += $("#helpSuburb").text() + ", " + $("#cp").val() + ", San Juan del Río,Querétaro";
    $("#searchAddress").val(concatAddress);
}

//Muestra u oculta los pasos del formulario de a cuerdo al motivo de la llamada
$("select[name='ticketit[incidents_id]']").on('change', function (e) {
    var page = $("#page").data("url");
    if ($(this).val() !== null) {
        var params = {
            type: 'GET',
            url: page + "/incidents/" + $(this).val() + "/getSteps",
            loadingSelector: $("#wizard"),
            form: null,
            crud: 'Respuesta del servidor',
            successCallback: function (data) {

                $("input[name='ticketit[receipt_required]']").val(data.data.receipt_required);
                $("input[name='ticketit[user_required]']").val(data.data.user_required);
                if (data.data.user_required) {
                    $("#wizard").bootstrapWizard('enable', 3);
                } else {
                    $("#wizard").bootstrapWizard('disable', 3);
                }
                if (data.data.receipt_required) {
                    $("#wizard").bootstrapWizard('enable', 2);
                } else {
                    $("#wizard").bootstrapWizard('disable', 2);
                }
                //$(".done").toArray().length;
            },
            errorCallback: function (error) {

            }
        };
        $.ajaxSimple(params);
    }
});

//Hay que buscar los nuevos tiquets que se encuentren dentro del radio del ticket que se esta creando
function similarTiquets() {
    var page = $("#page").data("url");
    var params = {
        type: 'GET',
        url: page + "/tickets/listSimilar/" + $("#latitudeTicket").val() + '/' + $("#longitudeTicket").val(),
        loadingSelector: $("#wizard"),
        form: null,
        crud: 'Respuesta del servidor',
        successCallback: function (data) {
            var body = $("#bodySimilarTickets");
            body.empty();
            if (data.tickets.length === 0) {
                body.append('<div data-scrollbar="true" data-height="250px">\
                    <div class="card card-inverse card-info text-center">\
                        <div class="card-block">\
                            <blockquote class="card-blockquote">\
                                <p>Lista de concidencias con un tiquet de acuerdo a la ubicación geográfica del problema. Se manejara un radio de 200 m</p>\
                                <footer>No existen actualmente <cite>Coincidencias con un Tiquet</cite></footer>\
                            </blockquote>\
                        </div>\
                    </div>\
                </div>');
            } else {
                var element = '<ul class="media-list media-list-with-divider" id="similarTiquets">';
                $.each(data.tickets, function (index, value) {
                    element += '<li class="media media-sm p-5 li cursor-pointer merge_ticket" data-id="' + value.id + '">\
                        <a class="media-left" href="javascript:;">';
                    if (value.user.url_image.length > 0)
                        element += '<img src="' + data.image + '/' + value.user.url_image + '" alt="' + value.user.name + '" class="media-object rounded-corner" title="' + value.user.name + '" />';
                    else
                        element += '<img src="' + data.image_default + '" alt="' + value.user.name + '" class="media-object rounded-corner" title="' + value.user.name + '" />';

                    element += '<small class="m-l-10" title="Generado el ' + moment(value.created_at.date).format('DD/MMM/YYYY') + '">' + moment(value.created_at.date).format('DD/MM/YYYY') +' </small>\
                        </a>\
                        <div class="media-body">\
                            <h4 class="media-heading">\
                                <span class="label label-primary">N° ' + value.folio + '</span>\
                                ' + value.incident.name + '\
                                <div class="pull-right">\
                                    <a href="' + page + '/tickets/' + value.id + '" target="_blank" class="btn btn-info btn-icon btn-sm" title="Ver tiquet"><i class="fa fa-eye"></i></a>\
                                </div>\
                            </h4>\
                            <p>' + value.content + '</p>\
                            <p>\
                                <span class="btn btn-sm m-r-5 btn-warning" title="Departamento">' + value.category.name + '</span>\
                                <span class="btn btn-sm btn-success" title="Distancia aproximada">' + parseFloat(value.distance * 1000).toMoney(2, '.', ',') + ' m</span>\
                            </p>\
                        </div>\
                    </li>';
                });
                element += '</ul>';
                body.append(element);
            }
        }
    };
    $.ajaxSimple(params);
}
