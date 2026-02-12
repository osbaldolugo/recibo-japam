$(document).ready(function () {

    FormMultipleUpload.init();
    FormSliderSwitcher.init();

    //Prevenimos que con un enter se envie el formulario que es usado para hacer el merge del tiquet
    $(window).keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });

    //Evento del botón para enviar un comentario al tiquet
    $("#btnSave").on('click', function (e) {
        sendComment($(this).data('route'));
    });

    //Editor para enviar comentarios
    $("textarea.summernote-editor").summernote({
        lang: 'es-ES',
        height: 100,
        codemirror: {theme: 'monokai', mode: 'text/html', htmlMode: true, lineWrapping: true},
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'strikethrough', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['view', ['help']]
        ],
        // disableDragAndDrop: true,
        placeholder: 'Ingresa tu mensaje...',
        callbacks: {
            onKeydown: function (e) {
                if (e.altKey)
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        sendComment($("#btnSave").data('route'));
                    }
            }
        }
        // disableDragAndDrop: true
    });

    /* Este evento acomoda al usario que ejecuta el evento como el nuevo responsable del tiquet
     * En caso de que el usuario tenga mas de una categoria o area nos muestra un modal para seleccionar la categoria
     * del tiquet (Esta ultima función ya no sera neceasria con la actualización del sistema)
     */
    $(".btnAsignTicket").on('click', function () {
        var show_modal = $(this).data('show-modal');
        //Dependiendo de que botón es el evento mostramos el modal o actualizamos al responsable
        if (show_modal === 1) {
            $("#reasignCategory").modal('show');
        } else {
            var route = $(this).data('route');
            if (show_modal === 2) {
                route = route + '/' + $("input[name='category']:checked").val();
                $("#reasignCategory").modal('hide');
            }
            //Mandamos llamar la función para reasignar el tiquet
            paramsReasign(route);
        }
    });

    /* En caso de que el usuario quiera cambiar al usuario asignado (responsable) del Ticket, se debe seleccionar el
     * departamento (category) y el usuario al que sera reasignado el Ticket.
     *
     * Cargamos la lista de usuarios de la categoria seleccionada al momento de mostrarlo en un modal
     */
    $("#reasignUser").on('show.bs.modal', function () {
        htmlUsers($("input[name='category']:checked").val());
    });

    //Enviamos la informacion del nuevo responsable del ticket para ser actualizado
    $(".btnReasignTicket").on('click', function () {
        var route = $(this).data('route') + '/' + $("input[name='agent']:checked").val() + '/' + $("input[name='category']:checked").val();
        $("#reasignUser").modal('hide');
        paramsReasign(route);
    });

    //Actualizamos la lista  de los usuarios por categoria
    $("input[name='category']").on('change', function () {
        htmlUsers($(this).val());
    });

    //Evento para resaltar los tiquets seleccionados durante el merge (Para los tiquets más próximos)
    $(".merge_ticket").on('click', function () {
        var id = $(this).val();
        if ($(this).is(':checked')) {
            $("#li_" + id).addClass('bg-silver');
        } else {
            $("#li_" + id).removeClass('bg-silver');
        }
    });

    //Deselecciona
    $(".simple_merge").on('click', function () {
        $(".merge_ticket_search").prop("checked", false);
        $(".search_li").removeClass('bg-silver');
    });

    $(".advanced_merge").on('click', function () {
        $(".li").removeClass('bg-silver');
        $(".merge_ticket").prop("checked", false);
    });

    //Botón para buscar los tiquets por su folio
    $("#btnSearch").on('click', function () {
        searchTickets($(this));
    });

    //Evento para buscar los tiquets por su folio
    $("#txtSearch").keydown(function (e) {
        if (event.keyCode === 13) {
            searchTickets($("#btnSearch"));
        }
    });

    //Evento que sirve para realizar el merge de los tiquets seleccionados
    $("#btnMergeTiquet").on('click', function () {
        if (true === $("#frmMergeTicket").parsley().validate('merge')) {
            var route = $(this).data('route');
            var params = {
                type: 'POST',
                url: route,
                form: $("#frmMergeTicket"),
                loadingSelector: $("#page-container"),
                crud: 'Merge',
                successCallback: function (data) {
                    swal({
                        title: data.title,
                        text: data.msg,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK"
                    }, function () {
                        if (data.refresh)
                            location.reload();
                    });
                },
                errorCallback: function (error) {
                    swal({
                        title: 'Error',
                        text: 'No fue posible realizar un merge al tiquet',
                        type: "error",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                }
            };
            $.ajaxSimple(params);
            $("#mergeTicket").modal('hide');
        }
    });

    //Evento para revertir el merge de un tiquet
    $("#merge-revert").on('click', function () {
        var father = $(this).data('father');
        var son = $(this).data('son');
        var route = $(this).data('route');
        swal({
            title: "¿Desea deshacer la unión de este tiquet?",
            text: "Separar tiquet N° " + son + " del tiquet N° " + father, //Esté tiquet (Folio: " + son + ") dejara de estar dependiente del tiquet N° " + father
            type: "info",
            showCancelButton: 1,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "OK",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
            var params = {
                type: 'GET',
                url: route,
                loadingSelector: $("#page-container"),
                crud: 'Revertir Merge',
                successCallback: function (data) {
                    swal({
                        title: data.title,
                        text: data.msg,
                        type: "success",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK"
                    }, function () {
                        if (data.refresh)
                            location.reload();
                    });
                },
                errorCallback: function (error) {
                    swal({
                        title: 'Error',
                        text: 'No fue posible revertir el merge del tiquet',
                        type: "error",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                }
            };
            $.ajaxSimple(params);
        });
    });

    $("#btnRemember").on('click', function () {
        var route = $(this).data('route');
        var params = {
            type: 'GET',
            url: route,
            form: null,
            loadingSelector: $("#page-container"),
            crud: 'Enviar recordatorio',
            successCallback: function (data) {
                swal({
                    title: data.title,
                    text: data.msg,
                    type: 'success',
                    showCancelButton: 0,
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'OK'
                });
            }, errorCallback: function (error) {
                swal({
                    title: "Error",
                    text: "Lo sentimos pero no fue posible enviar su recordatorio",
                    type: "error",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Continuar"
                });
            }
        };
        $.ajaxSimple(params);
    });

    //Mandamos llamar la función para obtener la geolocalización del problema
    getMap();

    //
    $("#image-comment").on('show.bs.modal', function () {
        $("#cancel-image").click();
    });
    
    $("#cbxNotification").on('change', function () {
        var route = $("#page").data('url') + '/tickets/subscribe/' + $("[name='ticket_id']").val();
        if ($(this).is(':checked')) {
            route += '/1';
        } else {
            route += '/0';
        }
        var params = {
            type: 'GET',
            url: route,
            form: null,
            loadingSelector: $("#page-container"),
            crud: 'Notificacion',
            successCallback: function (data) {
                swal({
                    title: data.title,
                    text: data.msg,
                    type: 'success',
                    showCancelButton: 0,
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'OK'
                });
            }, errorCallback: function (error) {
                swal({
                    title: "Error",
                    text: "Lo sentimos pero no fue posible actualizar su suscripción",
                    type: "error",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Continuar"
                });
            }
        };
        $.ajaxSimple(params);
    });

});

//Mostrar la imagen completa mandada por el usuario
$(document).on('click', '.show-detail-image', function () {
    $("#image-detail").modal('show');
    $("#image-detail-img").attr('src', $(this).attr('src'));
});

//Evento para resaltar los tiquets seleccionados durante el merge (Para la busqueda de tiquets)
$(document).on('click', '.merge_ticket_search', function () {
    var id = $(this).val();
    if ($(this).is(':checked')) {
        $("#search_li_" + id).addClass('bg-silver');
    } else {
        $("#search_li_" + id).removeClass('bg-silver');
    }
});

//Función para relizar la busqueda de folios para realizar un merge
function searchTickets(btnSearch) {
    if (true === $("#frmMergeTicket").parsley().validate('search')) {
        var route = btnSearch.data('route');
        var params = {
            type: 'GET',
            url: route + '/' + $("#txtSearch").val(),
            form: null,
            loadingSelector: $("#mergeTicket"),
            crud: 'Busqueda de tiquets',
            successCallback: function (data) {
                $("#listSearch").empty();
                if (data.values.length !== 0)
                    $.each(data.values, function (index, value) {
                        $("#listSearch").prepend('<li class="media media-sm p-5 bg-silver search_li" id="search_li_' + value.id + '">\
                                <label for="' + value.folio + '_check_search" class="cursor-pointer">\
                                    <a class="media-left" href="javascript:;">\
                                        <img src="' + ((value.user.url_image === null) ? data.man : data.image + '/' + value.user.url_image) + '" alt="" class="media-object rounded-corner" title="' + value.user.name + '" />\
                                        <small class="m-l-10" title="Generado el ' + value.created_at.date.substring(0, 18) + '">' + value.created_at.date.substring(0, 10) + '</small>\
                                    </a>\
                                    <div class="media-body">\
                                        <h4 class="media-heading">\
                                            <span class="label label-primary">N° ' + value.folio + '</span>\
                                            ' + value.incident.name + '\
                                            <div class="pull-right">\
                                                <a href="' + $("#page").data('url') + '/tickets/' + value.id + '" target="_blank" class="btn btn-info btn-icon btn-sm" title="Ver tiquet"><i class="fa fa-eye"></i></a>\
                                            </div>\
                                        </h4>\
                                        <p>' + value.content + '</p>\
                                        <p>\
                                            <span class="btn btn-sm m-r-5 bg-warning" title="Departamento">' + value.category.name + '</span>\
                                            <span class="btn btn-sm btn-success" title="Distancia aproximada">' + $.numberFormat(value.distance * 1000) + ' m</span>\
                                        </p>\
                                    </div>\
                                </label>\
                                <div class="hidden">\
                                    <input type="checkbox" name="ticket_son[]" value="' + value.id + '" id="' + value.folio + '_check_search" checked class="merge_ticket_search" required data-parsley-checkmin="1" data-parsley-errors-container="#errorMessage" data-parsley-error-message="Es necesario seleccionar al menos un tiquet" data-parsley-group="merge" />\
                                </div>\
                            </li>').fadeIn();
                    });
                else
                    swal({
                        title: 'No hay coincidencias',
                        text: 'No fue posible encontrar coincidencias con los folios que se desean buscar',
                        type: "warning",
                        showCancelButton: 0,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Continuar"
                    });
                $("#txtSearch").val("");
            },
            errorCallback: function (error) {
                swal({
                    title: 'Error',
                    text: 'No fue posible localizar los tiquets',
                    type: "error",
                    showCancelButton: 0,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Continuar"
                });
            }
        };
        $.ajaxSimple(params);
    }
}


//Función para actualizar al responsable del ticket
function paramsReasign(route) {
    var params = {
        type: 'GET',
        url: route,
        loadingSelector: $("#page-container"),
        form: null,
        crud: 'Reasignar al responsable del tiquet',
        successCallback: function (data) {
            swal({
                title: data.title,
                text: data.msg,
                type: "success",
                showCancelButton: 0,
                confirmButtonClass: "btn-success",
                confirmButtonText: "OK"
            }, function () {
                location.reload();
            });
        },
        errorCallback: function (error) {
            swal({
                title: 'Error',
                text: 'No fue posible reasignar el tiquet',
                type: "error",
                showCancelButton: 0,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar"
            });
        }
    };
    $.ajaxSimple(params);
}

//Obtener la lista de usuarios pertenecientes al departamento
function htmlUsers(category_id) {
    var html = $("#categoryAgentList_" + category_id).data('html');
    $("#agentList").empty().html(html);
}

//Función para mandar un comentario al ticket
function sendComment(route) {
    var params = {
        type: 'POST',
        url: route,
        loadingSelector: $("#comments"),
        form: $("#frmComment"),
        crud: 'Agregar comentario',
        successCallback: function (data) {
            $("#lastActivity").text(data.lastActivity);
            $("textarea.summernote-editor").summernote('reset', {
                placeholder: 'Ingresa tu mensaje...'
            });
        },
        errorCallback: function (error) {
            swal({
                title: 'Error',
                text: 'No fue posible enviar tu comentario',
                type: "error",
                showCancelButton: 0,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar"
            });
        }
    };
    $.ajaxSimple(params);
}

//Obtenemos la ubicación geográfica del problema
function getMap() {
    var lat = parseFloat($("#latitude").val());
    var lng = parseFloat($("#longitude").val());
    var map = new google.maps.Map(document.getElementById('map'), {
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
    var infoWindow = new google.maps.InfoWindow();
    var pos = { lat: lat, lng: lng};
    var place = '<div><i class="fa fa-map-marker">&nbsp;</i>Ubicación.<br><strong>' + $("#txtAddress").val() + '</strong></div>';
    var mark = new google.maps.Marker({
        position: pos,
        map: map,
        icon: $('#page').data('url') + '/img/ico/destino_36.png', //los iconos deben de estar almacenados en img/ico
        animation: google.maps.Animation.DROP,
        title: 'UBICACIÓN DEL PROBLEMA'
    });
    google.maps.event.addListener(mark, 'click', (function (mark, nameContent) {
        return function () {
            infoWindow.open(map, mark);
            infoWindow.setContent(nameContent);
        }
    })(mark, place));
    map.setCenter(pos);
}