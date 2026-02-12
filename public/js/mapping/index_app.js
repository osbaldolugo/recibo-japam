var map, lat, lng, meLat, meLng, service, geocoder, ctaLayer,
    markers = [], directionsDisplayMe, directionsServiceMe, directionsDisplayDestiny,
    directionsServiceDestiny, listStopsDestiny, listStopsMe, listRoutesAround, infoWindow = null,
    markersSearch = [], iconUrl = $('#page').data('url')+"/img/ico/",
    markersSection = [], sectionPath, sectionPathAux, colorHexa;

$(document).ready(function () {
    // Create map and initialize Search Box API
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(20.3951106, -99.98563439999998),
        zoom: 14,
        styles:[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}],
        mapTypeControl: false
    });

    getRoutes("");

    //$('#colorpicker').colorpicker();

    geocoder = new google.maps.Geocoder;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            meLat = position.coords.latitude, meLng = position.coords.longitude;

            if ( pos != null){
                var markLocation = [];

                geocoder.geocode({'location': pos}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var nameContent = '<div><i class="fa fa-map-marker text-info">&nbsp;</i>UBICACIÓN ACTUAL.<br><strong>' + results[0].formatted_address + '</strong></div>';
                            markLocation = new google.maps.Marker({
                                position: pos,
                                map: map,
                                icon: iconUrl+'pointLocation.png', //los iconos deben de estar almacenados en img/ico
                                animation: google.maps.Animation.DROP,
                                title: nameContent
                            });
                            google.maps.event.addListener(markLocation, 'click', (function(markLocation, nameContent) {
                                return function() {
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
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }


    ctaLayer = new google.maps.KmlLayer();
    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);
    directionsDisplayDestiny = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceDestiny = new google.maps.DirectionsService();
    directionsDisplayMe = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsServiceMe = new google.maps.DirectionsService();
    initAutocomplete();
    

    //Add attr disable to button btnViewRouteAround and btnViewNearbyStops
    $('#btnViewRouteAround').prop('disabled', true);
    $('#btnViewNearbyStops').prop('disabled', true);
    $('#iconInfo').show();
    $('#detailTravel').hide();

    //On click button view route urban
    $('#btnViewUrbanRoute').on('click', function () {
        var groupType = $(this).data('grouptype');
            getRoutes(groupType);
    });

    //On click button view route suburban
    $('#btnViewSuburbanRoute').on('click', function () {
        var groupType = $(this).data('grouptype');
            getRoutes(groupType);
    });


    //On click add kml in map
    $(document).on('click', '#btnAddKml', function () {
        var kml = $(this).data('kml'),
            idRoute = $(this).data('id'),
            group = $(this).data('group'),
            route = $(this).data('route'),
            place = $(this).data('place'),
            classTravel = (group == "urbana")? "bg-orange" : "bg-green",
            contentAlert = '<li class="media media-sm" style="list-style: none;">\
                                <div class="col-sm-8">\
                                    <a href="javascript:;" class="pull-left">\
                                        <img src="'+iconUrl+'ruta_buscar.png" style="width: 35px; height: 35px;" alt="" class="media-object no-rounded-corner">\
                                    </a>\
                                    <div class="media-body txt-color-5">\
                                        <h5 class="media-heading" style="font-size: 13px;text-align: left;"><b>&nbsp;Ruta&nbsp;'+route+'</b></h5>\
                                        <h6 class="media-heading" style="font-size: 10px;text-align: left;">&nbsp;'+place+'</h6>\
                                    </div>\
                                </div>\
                                <div class="col-sm-4">\
                                    <h5 class="media-heading" style="font-size: 13px;text-align: right;"><label class="label bg-black">RECORRIDO DE IDA</label></h5>\
                                    <h5 class="media-heading" style="font-size: 13px;text-align: right;"><label class="label '+classTravel+'">RECORRIDO DE REGRESO</label></h5>\
                                </div>\
                            </li>';
        $('#iconInfo').show();
        $('#detailTravel').hide();
        directionsDisplayMe.set('directions', null);
        directionsDisplayDestiny.set('directions', null);
        ctaLayer.setMap(null);
        clearMarkers("stops");
        initMap(kml, idRoute, group);
        nearbyStops(idRoute);
        $('#modalViewRoutes').modal('hide');
        $('#txtRouteSelected').html(contentAlert);
        //showMessageDialog('<b>RUTA '+route+'</b> cargada exitosamente.', 'info', 'Info!');
    });

    //On click button view route around
    $('#btnViewRouteAround').on('click', function () {
        var content = "",
            number = "",
            alias = "",
            lugar = "",
            origen = "",
            destino = "",
            img = "",
            classSuggestion = "",
            suggestion = "";

        $.each(listRoutesAround, function(index, value) {
            number = (value['numero'] != null) ? value['numero'] : "";
            alias = (value['alias'] != null) ? value['alias'] : "";
            origen = (value['origen'] != null) ? value['origen'] : "";
            destino = (value['destino'] != null) ? value['destino'] : "";
            img = (value['agrupacion'] == 'urbana') ? 'urbanos.png' : 'suburbanos.png';
            img = $('#page').data('url') +'/img/ico/'+ img;
            lugar = destino+'&nbsp;/&nbsp;'+origen;
            classSuggestion = (value['agrupacion'] == "urbana") ? "bg-color-2" : "bg-color-4";
            suggestion = (value['around'] == 1) ? '<label class="label '+classSuggestion+' pull-right" style="font-size: 11px;text-align: center;text-transform: uppercase"><i class="fa fa-star">&nbsp;</i>Ruta '+value['agrupacion']+' sugerida</label>' : "";
            content += '<tr style="cursor: pointer;" id="btnAddKml" data-id="'+value['id_ruta']+'" data-kml="'+value['kml']+'" data-group="'+value['agrupacion']+'" data-place="'+lugar+'" data-route="'+number+alias+'">\
                                    <td>\
                                        <div class="row col-sm-12">\
                                            <li class="media media-sm" style="list-style: none;">\
                                                <a href="javascript:;" class="pull-left">\
                                                    <img src="'+img+'" style="width: 50px; height: 50px;" alt="" class="media-object no-rounded-corner">\
                                                </a>\
                                                <div class="media-body">\
                                                    <h5 class="media-heading" style="font-size: 20px;text-align: justify;">\
                                                        Ruta&nbsp;'+number+alias+suggestion+'\
                                                    </h5>\
                                                    <p style="font-size: 15px;text-align: left;">'+destino+'&nbsp;/&nbsp;'+origen+'</p>\
                                                </div>\
                                            </li>\
                                        </div>\
                                    </td>\
                                </tr>';
        });

        $('#fieldsTableRoutes').html(content);
        $('#txtTitleModal').text("cercana a su destino");
        $('#modalViewRoutes').modal('show');
    });

    //On click button nearby stops
    $(document).on('click', '#btnViewNearbyStops', function () {
        clearMarkers("stops");
        if (listStopsDestiny != null){
            var iconNearbyDestiny = (listStopsDestiny["type_recorrido"] == "ida") ? "regreso_36.png": "ida_36.png",
                startDestiny = {lat: listStopsDestiny["lat"],lng: listStopsDestiny["lng"]},
                endDestiny = {lat: listStopsDestiny["destinoLat"],lng: listStopsDestiny["destinoLng"]};
            addMarkers(markers, {lat: listStopsDestiny["lat"],lng: listStopsDestiny["lng"]}, iconNearbyDestiny, listStopsDestiny["description"], 200);
            calculateRouteDestiny(startDestiny, endDestiny, iconNearbyDestiny);
        }
        if (listStopsMe != null){
            var iconNearbyMe = (listStopsMe["type_recorrido"] == "ida") ? "regreso_36.png": "ida_36.png",
                startMe = {lat: listStopsMe["meLat"],lng: listStopsMe["meLng"]},
                endMe = {lat: listStopsMe["lat"],lng: listStopsMe["lng"]};
            addMarkers(markers, {lat: listStopsMe["lat"],lng: listStopsMe["lng"]}, iconNearbyMe, listStopsMe["description"], 200);
            calculateRouteMe(startMe, endMe, iconNearbyMe);
        }
        $('#iconInfo').hide();
        $('#detailTravel').show();
    });
});


function calculateRouteMe(coordStart, coordEnd, icon) {
    var request = {
        origin: coordStart,
        destination: coordEnd,
        travelMode: 'WALKING'
    };
    directionsServiceMe.route(request, function(result, status) {
        if (status == 'OK') {
            directionsDisplayMe.setMap(map);
            //directionsDisplay.setPanel($("#txtStops").get(0));
            directionsDisplayMe.setDirections(result);
            //console.log(result);
            //console.log(result.routes[0].legs[0]);

            var title = '<div class="note note-warning p-b-1 p-t-1">\
                            <h5>\
                                <li class="media media-sm" style="list-style: none;">\
                                    <a href="javascript:;" class="pull-left">\
                                        <img src="'+iconUrl+'pointLocation.png" style="width: 30px; height: 30px;" alt="" class="media-object no-rounded-corner">\
                                    </a>\
                                    <div class="media-body">\
                                        <h6 class="media-heading">'+result.routes[0].legs[0].end_address+'</h6>\
                                    </div>\
                                </li>\
                                <li class="media media-sm" style="list-style: none;">\
                                    <a href="javascript:;" class="pull-left">\
                                        <img src="'+iconUrl+icon+'" style="width: 30px; height: 30px;" alt="" class="media-object no-rounded-corner">\
                                    </a>\
                                    <div class="media-body">\
                                        <h6 class="media-heading">'+result.routes[0].legs[0].start_address+'</h6>\
                                    </div>\
                                </li>\
                            </h5>\
                        </div>',
                instructions = "",
                content = "";
            $.each(result.routes[0].legs[0].steps, function(index, value) {
                instructions = value["instructions"];
                content += '<tr id="">\
                                <td>\
                                    <div class="row col-sm-12">\
                                        <li class="media media-sm" style="list-style: none;">\
                                            <div class="media-body">\
                                                <p><i class="fa fa-caret-right">&nbsp;</i>'+instructions+'</p>\
                                            </div>\
                                        </li>\
                                    </div>\
                                </td>\
                            </tr>';
            });
            $('#txtTitleMe').html(title);
            $('#txtStopsMe').html(content);
        }
    });
}

function calculateRouteDestiny(coordStart, coordEnd, icon) {
    var request = {
        origin: coordStart,
        destination: coordEnd,
        travelMode: 'WALKING'
    };
    directionsServiceDestiny.route(request, function(result, status) {
        if (status == 'OK') {
            directionsDisplayDestiny.setMap(map);
            //directionsDisplay.setPanel($("#txtStops").get(0));
            directionsDisplayDestiny.setDirections(result);
            //console.log(result);
            //console.log(result.routes[0].legs[0]);

            var title = '<div class="note note-warning p-b-1 p-t-1">\
                            <h5>\
                                <li class="media media-sm" style="list-style: none;">\
                                    <a href="javascript:;" class="pull-left">\
                                        <img src="'+iconUrl+icon+'" style="width: 30px; height: 30px;" alt="" class="media-object no-rounded-corner">\
                                    </a>\
                                    <div class="media-body">\
                                        <h6 class="media-heading">'+result.routes[0].legs[0].start_address+'</h6>\
                                    </div>\
                                </li>\
                                <li class="media media-sm" style="list-style: none;">\
                                    <a href="javascript:;" class="pull-left">\
                                        <img src="'+iconUrl+'destino_36.png" style="width: 30px; height: 30px;" alt="" class="media-object no-rounded-corner">\
                                    </a>\
                                    <div class="media-body">\
                                        <h6 class="media-heading">'+result.routes[0].legs[0].end_address+'</h6>\
                                    </div>\
                                </li>\
                            </h5>\
                        </div>',
                instructions = "",
                content = "";
            $.each(result.routes[0].legs[0].steps, function(index, value) {
                instructions = value["instructions"];
                content += '<tr id="">\
                                <td>\
                                    <div class="row col-sm-12">\
                                        <li class="media media-sm" style="list-style: none;">\
                                            <div class="media-body">\
                                                <p><i class="fa fa-caret-right">&nbsp;</i>'+instructions+'</p>\
                                            </div>\
                                        </li>\
                                    </div>\
                                </td>\
                            </tr>';
            });
            $('#txtTitleDestiny').html(title);
            $('#txtStopsDestiny').html(content);
        }
    });
}

function nearbyStops(route){
    var data = JSON.stringify({
        route: route,
        meLat: meLat,
        meLng: meLng,
        lat: lat,
        lng: lng
    });
    $.ajax({
        type: 'POST',
        url: $('#page').data('url')+'/nearbyStops',
        headers: {'_method': 'POST'},
        dataType: 'json',
        data: data,
        contentType: 'application/json',
        processData: false,
        cache: false,
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (data) {
            $("#loading").hide();
            if (data.success === 1) {
                //showMessageDialog(data.msg, 'success', 'Success!');
                if ( data.listStopsDestiny.id_ruta && data.listStopsMe.id_ruta){
                    listStopsDestiny = data.listStopsDestiny;
                    listStopsMe = data.listStopsMe;
                    $('#btnViewNearbyStops').prop('disabled', false);
                }

            } else{
                $.showerrors(data.responseJSON, data.msg);
            }
        }, error: function (data) {
            $("#loading").hide();
            $.showerrors(data.responseJSON, data.msg);
        }
    });
}

function initAutocomplete() {
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(20.3951106, -99.98563439999998));
    var searchBox = new google.maps.places.SearchBox(input, {
        bounds: defaultBounds
    });
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    //New method
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("No hay lugares disponibles.");
                return;
            }
            var infoTxt = '<div><i class="fa fa-map-marker txt-color-3">&nbsp;</i>DESTINO.<br><strong>' + place.formatted_address + '</strong></div>';
            ctaLayer.setMap(null);
            clearMarkers("stops");
            clearMarkers("location");
            $('#iconInfo').show();
            $('#detailTravel').hide();
            directionsDisplayMe.set('directions', null);
            directionsDisplayDestiny.set('directions', null);
            $('#btnViewNearbyStops').prop('disabled', true);
            addMarkers(markersSearch, place.geometry.location, "destino_36.png", infoTxt, 200);
            /*
            var icon = {
                url: iconUrl+"destino_36.png",
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(40, 40)
            };
            var mark = new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location,
                animation: google.maps.Animation.DROP,
                placeId: place.place_id
            });
            markersSearch.push(mark);
            google.maps.event.addListener(mark, 'click', function(evt) {
                service.getDetails({
                    placeId: this.placeId
                }, (function(marker) {
                    return function(place, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address + '</div>');
                            infoWindow.open(map, marker);
                        }
                    }
                }(mark)));
            });
            */

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            //console.log(place.geometry.location.lat()+" "+place.geometry.location.lng()+" "+place.name);
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
        });
        map.fitBounds(bounds);
        findPlaces(lat, lng, meLat, meLng);
    });
    /*
    //var infowindowsearch = new google.maps.InfoWindow();
    //var service = new google.maps.places.PlacesService(map);
    var markersSearch = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        // Clear out the old markers.
        markersSearch.forEach(function(pointSearch) {
            pointSearch.setMap(null);
        });
        markersSearch = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("No hay lugares disponibles.");
                return;
            }
            var icon = {
                url: iconUrl+"destino_46.png",
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(40, 40)
            };
            var mark = new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location,
                animation: google.maps.Animation.DROP,
                placeId: place.place_id
            });
            markersSearch.push(mark);
            google.maps.event.addListener(mark, 'click', function(evt) {
                service.getDetails({
                    placeId: this.placeId
                }, (function(marker) {
                    return function(place, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            infoWindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.formatted_address + '</div>');
                            infoWindow.open(map, marker);
                        }
                    }
                }(mark)));
            });

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            //console.log(place.geometry.location.lat()+" "+place.geometry.location.lng()+" "+place.name);
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
        });
        map.fitBounds(bounds);
        findPlaces(lat, lng);
    });*/
}

function getLocationWithClick(pos, lat, lng) {
    var icon = 'destino_36.png';

    geocoder.geocode({'location': pos}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                var place = '<div><i class="fa fa-map-marker txt-color-3">&nbsp;</i>DESTINO.<br><strong>' + results[0].formatted_address + '</strong></div>';
                findPlaces(lat, lng, meLat, meLng);
                ctaLayer.setMap(null);
                clearMarkers("stops");
                clearMarkers("location");
                $('#iconInfo').show();
                $('#detailTravel').hide();
                directionsDisplayMe.set('directions', null);
                directionsDisplayDestiny.set('directions', null);
                $('#btnViewNearbyStops').prop('disabled', true);
                addMarkers(markersSearch, pos, icon, place, 100);
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function addMarkers(markerType, pos, icon, nameContent, timeout) {


    window.setTimeout(function() {
        var mark = new google.maps.Marker({
            position: pos,
            map: map,
            //sicon: iconUrl+icon, //los iconos deben de estar almacenados en img/ico
            animation: google.maps.Animation.DROP,
            title: nameContent
        });
        google.maps.event.addListener(mark, 'click', (function(mark, nameContent) {
            return function() {
                infoWindow.setContent(nameContent);
                infoWindow.open(map, mark);
            }
        })(mark, nameContent));
        markerType.push(mark);
    }, timeout);
}

function clearMarkers(type) {
    if (type == "stops"){
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }
    if (type == "location"){
        for (var i = 0; i < markersSearch.length; i++) {
            markersSearch[i].setMap(null);
        }
        markersSearch = [];
    }
}

function initMap(kml, id, group) {
    // Add KML in Map
    ctaLayer = new google.maps.KmlLayer({
        url: 'https://turutasanjuan.com/storage/app/public/rutas/'+group+'/'+id+'/'+kml+'',
        map: map
    });
    ctaLayer.setMap(map);
    // Call function for add markers
    viewStops(id);
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ? 'Error: El servicio de Geolocalización falló.' : 'Error: Su navegador no admite Geolocalización.');
}

function getRoutes(group) {


    var sector = $("#sector option:selected").val();
    var suburbs = $("#suburbs option:selected").val();
    var status = $("#status option:selected").val();
    var priority = $("#priority option:selected").val();
    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: $('#page').data('url')+'/sector/getPlacesTicketApp',
        headers: {
            'X-CSRF-TOKEN': token
        },
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (data) {
            $("#loading").hide();
            if (data.success === 1) {
                console.log(data.listTickets);

                $.each(data.listTickets,  function(index,val)
                {
                    var pos = {"lat": parseFloat(val.latitude), "lng": parseFloat(val.longitude)};
                    var id = val.id;

                    addMarkers(markersSearch, pos, "", id, 20);
                });
            } else{
                $.showerrors(data.responseJSON, data.msg);
            }
        }, error: function (data) {
            $("#loading").hide();
            $.showerrors(data.responseJSON, data.msg);
        }
    });
}

function viewStops(id) {
    $.ajax({
        type: 'GET',
        url: $('#page').data('url')+'/getStops/'+id,
        headers: {'_method': 'GET'},
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (data) {
            $("#loading").hide();
            if (data.success === 1) {
                //showMessageDialog(data.msg, 'success', 'Success!');
                var i,
                    icons = {
                        //scaledSize: new google.maps.Size(36, 36), // Scaled size
                        origen: {
                            icon: 'inicio_36.png'
                        },
                        destino: {
                            icon: 'fin_36.png'
                        },
                        ida: {
                            icon: 'regreso_36.png'
                        },
                        regreso: {
                            icon: 'ida_36.png'
                        }
                    };

                for (i = 0; i < data.data.length; i++) {
                    addMarkers(markers, {lat: data.data[i]["lat"],lng: data.data[i]["lng"]}, icons[data.data[i]["type_recorrido"]].icon, data.data[i]["description"], i * 200);
                }
            } else{
                $.showerrors(data.responseJSON, data.msg);
            }
        }, error: function (data) {
            $("#loading").hide();
            $.showerrors(data.responseJSON, data.msg);
        }
    });
}

function findPlaces(latDestiny, lngDestiny, meLat, meLng) {
    var coordinates = JSON.stringify({
        latDestiny:latDestiny,
        lngDestiny:lngDestiny,
        meLat:meLat,
        meLng:meLng
    });

    $.ajax({
        type: 'POST',
        url: $('#page').data('url')+'/getPlacesTicket',
        headers: {'_method': 'POST'},
        dataType: 'json',
        data: coordinates,
        contentType: 'application/json',
        processData: false,
        cache: false,
        beforeSend: function () {
            $("#loading").show();
        },
        success: function (data) {
            $("#loading").hide();
            if (data.success === 1) {
                console.log(data.listTickets);

                $.each(data.listTickets, function(val)
                {
                    var pos = {"lat": parseFloat(val.latitude), "lng": parseFloat(val.longitude)};
                    var id = val.id;

                    addMarkers(markersSearch, pos, "", id, 20);
                });
            } else{
                $.showerrors(data.responseJSON, data.msg);
            }
        }, error: function (data) {
            $("#loading").hide();
            $.showerrors(data.responseJSON, data.msg);
        }
    });
}