$(document).ready(function () {
    var begin = moment().subtract(0, 'days');
    var end = moment();
    
    $('.select2').select2({
        width: '100%',
        language: 'es'
    }).on('change', function () {
        $('.buttons-reload').click();
    });;

    $('#dateRange').daterangepicker({
        startDate: moment(),
        endDate: moment(),
        opens: 'left',
        autoUpdateInput: true,
        // autoApply: true,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
            cancelLabel: 'Limpiar',
            customRangeLabel: 'Personalizado',
            applyLabel: 'Continuar',
            format: 'MMMM D, YYYY'
        }
    }).on('cancel.daterangepicker', function(ev, picker) {
        //do something, like clearing an input
        $(this).val('');
        begin = null;
        end = null;
        $('.buttons-reload').click();
    }).on('apply.daterangepicker', function(ev, picker) {
        begin = picker.startDate;
        end = picker.endDate;

        getTotalSales(begin.format('YYYY-MM-DD')+' 00:00:00' , end.format('YYYY-MM-DD')+' 23:59:59');
        $('.buttons-reload').click();
    });

    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.begin = (begin) ? begin.format('YYYY-MM-DD')+' 00:00:00' : null;
        data.end = (end) ? end.format('YYYY-MM-DD')+' 23:59:59' : null;
        data.pay_method = $("#txtFormaPago").val();
        getTotalSales(data.begin, data.end);
    });

    $('.buttons-reload').click();

    getTotalSales(begin.format('YYYY-MM-DD')+' 00:00:00' , end.format('YYYY-MM-DD')+' 23:59:59');
});


function getTotalSales(begin, end) {
    $.ajax({
        type: 'POST',
        url: $('#page').data('url')+'/payControls/getTotals',
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content'), '_method': 'POST'},
        cache: false,
        dataType : 'json',
        beforeSend: function () {
            $("#page-loader").show();
        },
        data: {
            begin : begin,
            end : end
        },
        success: function (data) {
            $("#page-loader").hide();
            $('#textTotalAndroid').text(data.android + (data.android == 1 ? ' pago': ' pagos'));
            $('#textTotalIos').text(data.ios + (data.ios == 1 ? ' pago': ' pagos'));
            $('#textTotalWeb').text(data.web + (data.web == 1 ? ' pago': ' pagos'));
            $('#textTotal').text(data.total + (data.total == 1 ? ' pago': ' pagos'));
        },
        error: function (error) {}
    });
}