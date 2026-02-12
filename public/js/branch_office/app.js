var map,
    marker = null;

$(document).ready(function ()
{
    $('select').select2({
        width: '100%',
        language: 'es'
    });

    $('#number_phone').inputmask('(999) 999-9999');
    $('#input_image').on('change', readFile);
});

function readFile()
{
    var extension = $('#input_image').val().split('.').pop();
    document.getElementById('imageFormat').value = extension;

    if (this.files && this.files[0]) {
        var FR= new FileReader();
        FR.addEventListener("load", function(e) {
            document.getElementById('image').value = e.target.result;
            $('#imagePreviewContainer').remove();
        });
        FR.readAsDataURL( this.files[0] );
    }
}

function initMap()
{
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(20.3951106, -99.98563439999998),
        zoom: 15,
        styles:[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}],
        mapTypeControl: false
    });
}

function markerWhenDoingClick()
{
    var latInput = document.getElementById('latitude'),
        lngInput = document.getElementById('longitude');

    google.maps.event.addListener(map, 'click', function(event) {
        if (marker != null)
            clearMarker();

        addMarker(event.latLng);

        var latWhenDoingClick = event.latLng.lat(),
            lngWhenDoingClick = event.latLng.lng();

        latInput.value = latWhenDoingClick;
        lngInput.value = lngWhenDoingClick;
        latInput.text = latWhenDoingClick;
        lngInput.text = lngWhenDoingClick;
    });
}

function addMarker(pos)
{
    marker = new google.maps.Marker({
        position: pos,
        map: map,
        icon: $('#page').data('url')+"/img/branch_office/icn_map.png",
        animation: google.maps.Animation.DROP,
    });
}

function clearMarker()
{
    marker.setMap(null);
}

$(function ()
{
    $('#beginTimePicker').datetimepicker({
        useCurrent : false,
        format: 'LT',
    });

    $('#endTimePicker').datetimepicker({
        useCurrent : false,
        format: 'LT',
    });
});