/**
 * Created by ApiDeveloper on 23/01/2018.
 */

var map, lat, lng, meLat, meLng, service, geocoder, ctaLayer,
    markers = [], directionsDisplayMe, directionsServiceMe, directionsDisplayDestiny,
    directionsServiceDestiny, listStopsDestiny, listStopsMe, listRoutesAround, infoWindow = null,
    markersSearch = [], iconUrl = $('#page').data('url') + "/img/ico/",
    markersSection = [], sectionPath, sectionPathAux, colorHexa, table;

$(document).ready(function () {
    "use strict";

    $("#wizard").bwizard({
        backBtnText: "<i class='ion-arrow-left-c'></i> Anterior",
        nextBtnText: "Siguiente <i class='ion-arrow-right-c'></i>",
        validating: function (e, t) {
            if (t.index === 0) {
                if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-1")) {
                    return false
                } else {
                    var page = $("#page").data("url");
                    var params;
                    var id_sector = $("#id_sector").val();
                    if (id_sector === "") {
                        params = {
                            type: "POST",
                            url: page + "/sector",
                            form: $("form[name='form-wizard']"),
                            loadingSelector: $(this).closest("div"),
                            crud: "Notificación",
                            successCallback: function (data) {
                                $("#id_sector").val(data.data.id);
                                $("#sector_suburb_id").val(data.data.id);
                                $("#sector_id").html('<option value>Selecciona el Sector de la Colonia</option><option value="' + data.data.id + '">' + data.data.name + '</option>').val(data.data.id).trigger('change');
                                var table = $('#dataTableBuilder').DataTable().on('preXhr.dt', function (e, settings, data) {
                                    data.id_sector = $("#id_sector").val();
                                });
                                table.draw();
                                swal({
                                    title: "Correcto",
                                    text: "Sector guardado correctamente",
                                    type: "success",
                                    showCancelButton: 0,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Continuar"
                                });
                            },
                            errorCallback: function (error) {
                                console.log("Error.");
                            }
                        };
                    } else {
                        params = {
                            type: "PATCH",
                            url: page + "/sector/" + id_sector,
                            form: $("form[name='form-wizard']"),
                            loadingSelector: $(this).closest("div"),
                            crud: "Notificación",
                            successCallback: function (data) {
                                $("#id_sector").val(data.data.id);
                            },
                            errorCallback: function (error) {
                                console.log("Error.");
                            }
                        };
                    }
                    $.ajaxSimple(params);

                }
            }
        }
    });

    // Create map and initialize Search Box API
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(20.3951106, -99.98563439999998),
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

    $('#colorpicker').colorpicker();

    geocoder = new google.maps.Geocoder;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            meLat = position.coords.latitude;
            meLng = position.coords.longitude;

            if (pos != null) {
                var markLocation = [];

                geocoder.geocode({'location': pos}, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var nameContent = '<div><i class="fa fa-map-marker text-info">&nbsp;</i>UBICACIÓN ACTUAL.<br><strong>' + results[0].formatted_address + '</strong></div>';
                            markLocation = new google.maps.Marker({
                                position: pos,
                                map: map,
                                icon: iconUrl + 'pointLocation.png', //los iconos deben de estar almacenados en img/ico
                                animation: google.maps.Animation.DROP,
                                /*title: nameContent*/
                            });
                            google.maps.event.addListener(markLocation, 'click', (function (markLocation, nameContent) {
                                return function () {
                                    infoWindow.open(map, markLocation);
                                    infoWindow.setContent(nameContent);
                                }
                            })(markLocation, nameContent));
                            map.setCenter(pos);
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }
        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }


    sectionPath = new google.maps.Polygon({
        paths: markersSection,
        strokeColor: colorHexa,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: colorHexa,
        fillOpacity: 0.35
    });


    map.addListener('click', function (e) {
        var pos = e.latLng;
        lat = e.latLng.lat();
        lng = e.latLng.lng();
        //getLocationWithClick(pos, lat, lng);
        if (markersSection.length > 0) {
            sectionPath.setMap(null);
        }

        markersSection.push({"lat": lat, "lng": lng});
        $("#tableDots tbody").append("<tr>" +
            "<td><input name='sectorDots[lat][]' value='" + lat + "' /></td>" +
            "<td><input name='sectorDots[lng][]' value='" + lng + "' /></td>" +
            "</tr>");

        sectionPath = new google.maps.Polygon({
            paths: markersSection,
            strokeColor: colorHexa,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: colorHexa,
            fillOpacity: 0.35
        });

        drawPolygon();

    });


    document.onkeydown = KeyPress;

    function KeyPress(e) {
        var evtobj = window.event ? event : e;
        //Do action on CTRL + Z
        if (evtobj.keyCode === 90 && evtobj.ctrlKey) {

            if (markersSection.length > 0) {
                sectionPath.setMap(null);
                markersSection.splice(-1, 1);
            }

            sectionPath = new google.maps.Polygon({
                paths: markersSection,
                strokeColor: colorHexa,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: colorHexa,
                fillOpacity: 0.35
            });

            console.log(markersSection);
            drawPolygon();

            $("#tableDots tbody tr:last-child").remove();
        }
    }

    ctaLayer = new google.maps.KmlLayer();
    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);
    directionsDisplayDestiny = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceDestiny = new google.maps.DirectionsService();
    directionsDisplayMe = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceMe = new google.maps.DirectionsService();
    //initAutocomplete();


    if ($("#tableDots tbody tr").length > 0) {
        $("#tableDots tbody tr").each(function (index_tr, val_tr) {
            var lat = $(this).find("td").eq(0).children("input").val();
            var lng = $(this).find("td").eq(1).children("input").val();

            markersSection.push({"lat": parseFloat(lat), "lng": parseFloat(lng)});
        });

        console.log(markersSection);
        drawPolygon();

    }


});

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ? 'Error: El servicio de Geolocalización falló.' : 'Error: Su navegador no admite Geolocalización.');
}

function drawPolygon() {

    var icon = 'destino_36.png';
    colorHexa = $('#colorpicker').val();
    console.log(colorHexa);
    console.log(markersSection);


    sectionPath.setOptions({
        paths: markersSection,
        strokeColor: colorHexa,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: colorHexa,
        fillOpacity: 0.35
    });

    sectionPath.addListener('click', function (e) {
        //alert(this.indexID);
        if (markersSection.length > 0) {
            sectionPath.setMap(null);
        }

        var pos = e.latLng;
        lat = e.latLng.lat();
        lng = e.latLng.lng();

        markersSection.push({"lat": lat, "lng": lng});
        //getLocationWithClick(pos, lat, lng);
        sectionPath.setOptions({
            paths: markersSection,
            strokeColor: colorHexa,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: colorHexa,
            fillOpacity: 0.35
        });

        sectionPath.setMap(map);

        $("#tableDots tbody").append("<tr>" +
            "<td><input name='sectorDots[lat][]' value='" + lat + "' \></td>" +
            "<td><input name='sectorDots[lng][]' value='" + lng + "' \></td>" +
            "</tr>");
    });

    //sconsole.log(markersSection);
    // Construct the polygon.
    sectionPath.setMap(map);

}


