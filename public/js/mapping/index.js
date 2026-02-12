var map, lat, lng, meLat, meLng, service, geocoder, ctaLayer,
    markers = [], directionsDisplayMe, directionsServiceMe, directionsDisplayDestiny,
    directionsServiceDestiny, infoWindow = null,
    markersSearch = [], iconUrl = $('#page').data('url')+"/img/ico/";

$(document).ready(function () {

    $(".select2").on('change', function () {
        getRoutes();
    }).select2({
        width: '100%',
        language: 'es'
    });
    $("#txtSector").on('change', function () {
        var value;
        if ($(this).val())
            value = $(this).val();
        else
            value = 0;
        var params = {
            type: 'GET',
            url: $('#page').data('url') + '/sector/get/suburbs/' + value,
            loadingSelector: $(this).closest('.row'),
            form: null,
            crud: 'Consultando las colonias de la sección',
            successCallback: function (data) {
                if (data.length) {
                    $("#txtSuburb").empty().append('<option selected="selected" value="">Filtrar por colonia...</option>');
                    $.each(data, function (index, val) {
                        $("#txtSuburb").append('<option value="' + val.id + '">' + val.suburb + '</option>');
                    });
                } else
                    $("#txtSuburb").empty().append('<option selected="selected" value="">Selecciona un sector</option>');
            },
            errorCallback: function (data) {
                console.log('Error.');
            }
        };
        $.ajaxSimple(params);
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
    geocoder = new google.maps.Geocoder;
    ctaLayer = new google.maps.KmlLayer();
    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);
    directionsDisplayDestiny = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceDestiny = new google.maps.DirectionsService();
    directionsDisplayMe = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceMe = new google.maps.DirectionsService();

    getRoutes();
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
                                title: 'Ubicación Actual'
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
});

function addMarkers(markerType, pos, icon, nameContent, timeout, title) {
    window.setTimeout(function () {
        var mark = new google.maps.Marker({
            position: pos,
            map: map,
            icon: iconUrl + icon, //los iconos deben de estar almacenados en img/ico
            animation: google.maps.Animation.DROP,
            title: title
        });
        google.maps.event.addListener(mark, 'click', (function (mark, nameContent) {
            return function () {
                infoWindow.setContent(nameContent);
                infoWindow.open(map, mark);
            }
        })(mark, nameContent));
        markerType.push(mark);
    }, timeout);
}

function clearMarkers(type) {
    if (type === "stops") {
        for (var j = 0; j < markers.length; j++) {
            markers[j].setMap(null);
        }
        markers = [];
    }
    if (type === "location") {
        for (var i = 0; i < markersSearch.length; i++) {
            markersSearch[i].setMap(null);
        }
        markersSearch = [];
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ? 'Error: El servicio de Geolocalización falló.' : 'Error: Su navegador no admite Geolocalización.');
}

function getRoutes() {
    var params = {
        type: 'POST',
        url: $('#page').data('url') + '/sector/getPlacesTicket',
        loadingSelector: $("#panel-body"),
        form: $("#frmMap"),
        crud: 'Buscando localizaciones...',
        successCallback: function (data) {
            var icon = 'destino_36.png';
            clearMarkers('location');
            $.each(data, function (index, val) {
                var place;
                if (val.inside_number === null)
                    place = '<div><i class="fa fa-map-marker text-inverse">&nbsp;</i>' + val.incident.name + ' FOLIO #'+ val.folio + '<br><strong>' + val.street + ' ' + val.outside_number + ', Col. ' + val.suburb.suburb + ' ' + val.cp  + '</strong></div>';
                else
                    place = '<div><i class="fa fa-map-marker text-inverse">&nbsp;</i>FOLIO #'+ val.folio + '<br><strong>' + val.street + ' ' + val.outside_number + ' Int. ' + val.inside_number + ', Col. ' + val.suburb.suburb + ' ' + val.cp  + '</strong></div>';
                var pos = {"lat": parseFloat(val.latitude), "lng": parseFloat(val.longitude)};
                addMarkers(markersSearch, pos, icon, place, 20, val.incident.name);
            });
            $("#lblNoTickets").text(' ' + parseFloat(data.length).toMoney(0, '.', ','));
        },
        errorCallback: function (data) {
            console.log('Error.');
        }
    };
    $.ajaxSimple(params);
}