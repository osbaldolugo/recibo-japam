$(document).ready(function() {
    FormSliderSwitcher.init();

    var start = moment().subtract(29, 'days');
    var end = moment();

    $('#txtFecha').daterangepicker({
        startDate: start,
        endDate: end,
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
        start = null;
        end = null;
        $('.buttons-reload').click();
    }).on('apply.daterangepicker', function(ev, picker) {
        start = picker.startDate;
        end = picker.endDate;
        $('.buttons-reload').click();
    });

    $("[data-render=switchery]").on('change', function () {
        $('.buttons-reload').click();
    });

    $(".select2").on('change', function () {
        $('.buttons-reload').click();
    });

    $('select').select2({
        width: '100%',
        language: 'es'
    });

    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.assigned = $("#cbxAssigned").is(':checked') ? 1 : 0;
        data.completed = $("#cbxCompleted").is(':checked') ? 1 : 0;
        data.generated = $("#cbxGenerated").is(':checked') ? 1 : 0;
        data.categories = $("#cmbDepartment").val();
        data.users = $("#cmbUsers").val();
        data.inicio = (start) ? start.format('YYYY/MM/DD') : null;
        data.fin = (end) ? end.format('YYYY/MM/DD') : null;
    });
});
