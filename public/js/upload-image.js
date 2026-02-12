$(document).ready(function () {

    $('#fileUpload').fileupload({
        dataType: 'json',
        autoUpload: false,
        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
        maxFileSize: 5e6,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    });

    $("#showImageModal").on('click', function () {
        console.log('HOLA');
        $("#image-comment").modal('show');
    });
});