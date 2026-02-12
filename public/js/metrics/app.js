function abc(){
    $("#precentacion").hide();
    
    route = '/consultaDeFechas';
    $(".buscarBanco").attr("action",route);

    routeQueja = '/quejas';
    $(".buscarQueja").attr("action",routeQueja);

    routeReporte = '/reportes';
    $(".buscarReporte").attr("action",routeReporte);

    routeDenuncia = '/denuncias';
    $(".buscarDenuncia").attr("action",routeDenuncia);

    routeDescarga = '/descargas';
    $(".buscarDescargas").attr("action",route);

    console.log("btnRedirectBanco");
}

function antesDeBusqueda(){
    var route = $('.buscarBanco');
    route.attr("action", "/japam/metrics/consultaDeFechas");
    $("#buscarBanco").data('action', '/japam/metrics/consultaDeFechas');

    url = document.getElementById('buscarBanco');
    console.log(url);

    var from = document.getElementById('from4').value;
    var to = document.getElementById('to4').value;
    console.log(from);
    console.log(to);

    busqueda = buscarpagos();
    //buscarpagos();

    return false;
}

function buscarpagos() {
    $("input[name='_method']").val($("#buscarBanco").data("action") == '/japam/metrics/consultaDeFechas' ? 'POST' : 'PATCH');
    var url = '/tcs/public/japam/metrics/consultaDeFechas';
    $.ajaxFormData({
        crud: 'Pagos',
        type: 'POST',
        url: url,
        form: "buscarBanco",
        loadingSelector: "#fechas",
        successCallback: function (data) {

            data = data.replace(" ","");
            data = JSON.parse("["+data+"]");

            console.log(typeof data == "string");
            console.log(typeof data == "array");

            var abc = $('#valorpagos');
            abc.val(data);
            $(".buttons-reload").click();
            pagos = mostrarPagos(data);

        },
        errorCallback: function (data) {

        }
    });
}

function mostrarPagos(data){
    //var valores = document.getElementById('valorpagos').value;
    var ctx = document.getElementById('myChart4').getContext('2d');
    if (window.grafica){
        window.grafica.clear();
        window.grafica.destroy();
    }
    window.grafica = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['App', 'Web'],
            datasets: [{
                label: '# de Reg.',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

//ZONA DE QUEJAS PARA MOSTRAR EN GRAFICA
function busquedaQueja(){
    var routeQueja = $('.buscarQueja');
    routeQueja.attr("action", "/japam/metrics/quejas");
    $("#buscarQueja").data('action', '/japam/metrics/quejas');

    url = document.getElementById('buscarQueja');
    console.log(url);

    var from = document.getElementById('from1').value;
    var to = document.getElementById('to1').value;
    console.log(from);
    console.log(to);

    busqueda = buscarquejas();
    //buscarpagos();

    return false;
}

function buscarquejas() {
    $("input[name='_method']").val($("#buscarQueja").data("action") == '/japam/metrics/quejas' ? 'POST' : 'PATCH');
    var action = "/tcs/public/japam/metrics/quejas";
    var url1 = $(this).action;
    $.ajaxFormData({
        crud: 'Quejas',
        type: 'POST',
        url:  action,
        form: "buscarQueja",
        loadingSelector: "#fechas1",
        successCallback: function (data) {
            console.log(data);

            data = data.replace(" ","");
            data = JSON.parse("["+data+"]");

            console.log(typeof data == "string");
            console.log(typeof data == "array");
            $(".buttons-reload").click();
            pagos = mostrarQueja(data);

        },
        errorCallback: function (data) {

        }
    });
}

function mostrarQueja(data){
    //var valores = document.getElementById('valorpagos').value;
    var ctx = document.getElementById('myChart1').getContext('2d');
    if (window.grafica){
        window.grafica.clear();
        window.grafica.destroy();
    }
    window.grafica = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['App', 'Web'],
            datasets: [{
                label: '# de Reg.',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

//  ZONA DE REPORTES PARA GRAFICAR
function busquedaReportes(){
    var routereporte = $('.buscarReporte');
    routereporte.attr("action", "/japam/metrics/reportes");
    $("#buscarReporte").data('action', '/japam/metrics/reportes');

    url = document.getElementById('buscarReporte');
    console.log(url);

    var from = document.getElementById('from2').value;
    var to = document.getElementById('to2').value;
    console.log(from);
    console.log(to);

    busquedaReporteFechas = buscarreportesJson();
    //buscarpagos();

    return false;
}

function buscarreportesJson() {
    $("input[name='_method']").val($("#buscarReporte").data("action") == '/japam/metrics/reportes' ? 'POST' : 'PATCH');
    var url2 = '/tcs/public/japam/metrics/reportes';
    $.ajaxFormData({
        crud: 'Reportes',
        type: 'POST',
        url: url2,
        form: "buscarReporte",
        loadingSelector: "#fechas2",
        successCallback: function (data) {
            console.log(data);
            data = data.replace(" ","");
            data = JSON.parse("["+data+"]");

            console.log(typeof data == "string");
            console.log(typeof data == "array");

            $(".buttons-reload").click();
            reportes = mostrarReporte(data);

        },
        errorCallback: function (data) {

        }
    });
}

function mostrarReporte(data){
    //var valores = document.getElementById('valorpagos').value;
    var ctx = document.getElementById('myChart2').getContext('2d');
    if (window.grafica){
        window.grafica.clear();
        window.grafica.destroy();
    }
    window.grafica = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['App', 'Web'],
            datasets: [{
                label: '',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

// ZONA DE DENUNCIAS PARA GRAFICAR
function busquedaDenuncias(){
    var routedenuncia = $('.buscarDenuncia');
    routedenuncia.attr("action", "/japam/metrics/denuncias");
    $("#buscarDenuncia").data('action', '/japam/metrics/denuncias');

    url = document.getElementById('buscarDenuncia');
    console.log(url);

    var from = document.getElementById('from3').value;
    var to = document.getElementById('to3').value;
    console.log(from);
    console.log(to);

    busquedaReporteFechas = buscardenunciasJson();
    //buscarpagos();

    return false;
}

function buscardenunciasJson() {
    $("input[name='_method']").val($("#buscarDenuncia").data("action") == '/japam/metrics/denuncias' ? 'POST' : 'PATCH');
    var url3 = '/tcs/public/japam/metrics/denuncias';
    $.ajaxFormData({
        crud: 'Denuncias',
        type: 'POST',
        url: url3,
        form: "buscarDenuncia",
        loadingSelector: "#fechas3",
        successCallback: function (data) {
            console.log(data);
            data = data.replace(" ","");
            data = JSON.parse("["+data+"]");

            console.log(typeof data == "string");
            console.log(typeof data == "array");

            $(".buttons-reload").click();
            reportes = mostrarDenuncia(data);

        },
        errorCallback: function (data) {

        }
    });
}

function mostrarDenuncia(data){
    var ctx = document.getElementById('myChart3').getContext('2d');
    if (window.grafica){
        window.grafica.clear();
        window.grafica.destroy();
    }
    window.grafica = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['App', 'Web'],
            datasets: [{
                label: '',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

//ZONA DE DESCARGAS DE PDF
function busquedaDescargas(){
    var routedescarga = $('.buscardescargas');
    routedescarga.attr("action", "/japam/metrics/descargas");
    $("#buscarDescargas").data('action', '/japam/metrics/descargas');

    url = document.getElementById('buscarDescargas');
    console.log(url);

    var from = document.getElementById('from5').value;
    var to = document.getElementById('to5').value;
    console.log(from);
    console.log(to);

    busquedaReporteFechas = buscardescargasJson();
    //buscarpagos();

    return false;
}

function buscardescargasJson() {
    $("input[name='_method']").val($("#buscarDescargas").data("action") == '/japam/metrics/descargas' ? 'POST' : 'PATCH');
    var url5 = '/tcs/public/japam/metrics/descargas';
    $.ajaxFormData({
        crud: 'Descargas',
        type: 'POST',
        url: url5,
        form: "buscarDescargas",
        loadingSelector: "#fechas5",
        successCallback: function (data) {
            console.log(data);
            data = data.replace(" ","");
            data = JSON.parse("["+data+"]");

            console.log(typeof data == "string");
            console.log(typeof data == "array");

            $(".buttons-reload").click();
            reportes = mostrarDescarga(data);

        },
        errorCallback: function (data) {

        }
    });
}

function mostrarDescarga(data){
    var ctx = document.getElementById('myChart5').getContext('2d');
    if (window.grafica){
        window.grafica.clear();
        window.grafica.destroy();
    }
    window.grafica = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['App', 'Web'],
            datasets: [{
                label: '',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
