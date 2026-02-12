$(document).ready(function() {
    FormSliderSwitcher.init();

    $("[data-render=switchery]").on('change', function () {
        $('.buttons-reload').click();
    });

    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.assigned = $("#cbxAssigned").is(':checked') ? 1 : 0;
        data.completed = $("#cbxCompleted").is(':checked') ? 1 : 0;
        data.generated = $("#cbxGenerated").is(':checked') ? 1 : 0;
    });
});
