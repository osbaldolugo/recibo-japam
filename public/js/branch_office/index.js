$(document).ready(function () {
    var reader = new FileReader();
    var inputImage = document.getElementById('input_image');
    initMap();
    markerWhenDoingClick();

    /*
     * Create Branch Office - Open Modal
     */
    $(document).on("click", "#btnAddBranchOffice", function () {
        $('input[name=_method]').val('POST');
        $('.nameBtnComplete').text('CREAR SUCURSAL');
        $('#txtTitleModal').text('Agregar Sucursal');
        $("#modal_branch_office").modal("show");
        $('#imagePreviewContainer').remove();
        $('#input_image').attr('required', 'true');
    });

    /*
     * Update Branch Office - Open Modal
     */
    $(document).on("click", "#btnUpdateBranchOffice", function () {
        $('input[name=_method]').val('PATCH');
        $('.nameBtnComplete').text('ACTUALIZAR SUCURSAL');

        var params = {
            type: 'GET',
            url: 'branchOffices/getDetailsBranchOffice/' + $(this).data('id'),
            loadingSelector: $(".loading-content-index-branch-office"),
            form: 'formBranchOffice',
            crud: '<i class="fa fa-server"></i> Server Response',
            successCallback: function (data) {
                $('input[name=_method]').data('id', data.branchOffice.id);
                //Step-1
                $('#description').val(data.branchOffice.description);
                $('#street').val(data.branchOffice.street);
                $('#settlement').val(data.branchOffice.settlement);
                $('#inside_number').val((data.branchOffice.inside_number != null) ? data.branchOffice.inside_number : '');
                $('#outside_number').val((data.branchOffice.outside_number != null) ? data.branchOffice.outside_number : '');
                $('#cp').val(data.branchOffice.cp);
                $('#number_phone').val((data.branchOffice.number_phone != null) ? data.branchOffice.number_phone : '');
                $('#extension').val((data.branchOffice.extension != null) ? data.branchOffice.extension : '');
                $('#input_image').removeAttr('required');
                $('#hiddenDivImagePreview').html(
                    '<div id="imagePreviewContainer" class="col-sm-12 text-center">\
                        <hr class="m-t-10 m-b-0">\
                        <i class="fa fa-image">&nbsp;</i><small><b>Imagen Actual</b></small>\
                        <div class="profile-image m-t-5" style="height:140px !important;margin-bottom: 0 !important;line-height: 0 !important;">\
                            <img src="' + data.branchOffice.image + '" style="max-height: 100%; margin-left: auto; margin-right: auto; vertical-align: middle !important;">\
                            <i class="fa fa-user hide"></i>\
                        </div>\
                    </div>');
                $('#image').val(data.branchOffice.image);
                $('#imageFormat').val(data.branchOffice.imageFormat);

                //Step-2
                $.each(data.schedule, function (title, value) {
                    var txtArea = (value.area == 'box') ? 'Cajas' : 'Atención a Clientes',
                        txtWorkDay = (value.work_day == 'week') ? 'Lunes a Viernes' : 'Sábado';

                    $("#content-table-body").append(
                        "<tr>\
                            <td>\
                                <input class='form-control input-sm' type='text' readonly value='" + txtArea + "'>\
                                <input name='schedule[area][]' class='form-control input-sm' type='hidden' value='" + value.area + "'>\
                            </td>\
                            <td>\
                                <input class='form-control input-sm' type='text' readonly value='" + txtWorkDay + "'>\
                                <input name='schedule[work_day][]' class='form-control input-sm' type='hidden' value='" + value.work_day + "'>\
                            </td>\
                            <td>\
                                <input name='schedule[begin_time][]' class='form-control input-sm text-center' type='text' readonly value='" + value.begin_time + "'>\
                            </td>\
                            <td>\
                                <input name='schedule[end_time][]' class='form-control input-sm text-center' type='text' readonly value='" + value.end_time + "'>\
                            </td>\
                            <td>\
                                <a id='btnRemoveOfTable' data-id_schedule='" + value.id + "' class='btn btn-danger btn-xs text-center'><i class='fa fa-trash fa-2x'></i></a>\
                                <input type='hidden' name='schedule[schedule_id][]' value='" + value.id + "'>\
                            </td>\
                        </tr>"
                    );
                });

                //Step-3
                $('#latitude').val(data.branchOffice.latitude);
                $('#longitude').val(data.branchOffice.longitude);

                $('#txtTitleModal').html('Actualizar Sucursal: <b>' + data.branchOffice.description + '</b>');
                $("#modal_branch_office").modal("show");
            },
            errorCallback: function (error) {
                console.log('¡Error!', error);
            }
        };
        $.ajaxFormData(params);
    });

    /*
     * Delete Branch Office - Open Bootbox
     */
    $(document).on('click', '.btnDeleteBranchOffice', function () {
        var params = {
            question: '¿Eliminar la sucursal: <b>"'+$(this).data('description')+'"</b>?',
            url: 'branchOffices/'+$(this).data('id'),
            loadingSelector: $('.loading-content-index-branch-office'),
            crud: '<i class="fa fa-server"></i> Server Response',
            successCallback: function (data) {
                console.log('¡Success!', data);
                $('.buttons-reload').click();
                //location.reload();
            },
            errorCallback: function (error) {
                console.log('¡Error!', error);
            }
        };
        deleteAjax(params);
    });

    /*
     * Start Validator
     */
    "use strict";
    $("#wizard").bwizard({
        backBtnText: "<i class='ion-arrow-left-c'></i> Anterior",
        nextBtnText: "Siguiente <i class='ion-arrow-right-c'></i>",
        validating: function (e, t) {
            if (t.index === 0)
            {
                //For normal input
                if (false === $('form[name="formWizard"]').parsley().validate("wizard-step-1"))
                {
                    return false
                }
                //For image input
                if (false === $('form[name="formWizard"]').parsley().validate("wizard-validator-file"))
                {
                    return false;
                }

            } else if (t.index === 1 && t.nextIndex > t.index)
            {
                if (false === $('form[name="formWizard"]').parsley().validate("wizard-step-2"))
                {
                    return false
                }
                if ($("#content-table-body tr").length === 0 )
                {
                    $("#table-error").html('Es necesario añadir al menos un horario para poder continuar. *').css({color: '#E5603B'});

                    return false;
                }
            } else if (t.index === 2 && t.nextIndex > t.index)
            {
                if (false === $('form[name="formWizard"]').parsley().validate("wizard-step-3"))
                {
                    return false
                }
            }
        },
        clickableSteps: false,
    });

    /*
     * Start Validator for the Dinamic Table
     */
    $('#addScheduleToTable').on('click', function () {
        var area = $('#area').val(),
            workDay = $('#work_day').val(),
            txtArea = (area == 'box') ? 'Cajas' : 'Atención a Clientes',
            txtWorkDay = (workDay == 'week') ? 'Lunes a Viernes' : 'Sábado',
            beginTime = $('#beginTimePicker').val(),
            endTime = $('#endTimePicker').val();

        if ($('form[name="formWizard"]').parsley().validate("schedule-wizard") === true)
        {
            $("#content-table-body").append(
                "<tr>\
                    <td>\
                        <input class='form-control input-sm' type='text' readonly value='" + txtArea + "'>\
                        <input name='schedule[area][]' class='form-control input-sm' type='hidden' value='" + area + "'>\
                    </td>\
                    <td>\
                        <input class='form-control input-sm' type='text' readonly value='" + txtWorkDay + "'>\
                        <input name='schedule[work_day][]' class='form-control input-sm' type='hidden' value='" + workDay + "'>\
                    </td>\
                    <td>\
                        <input name='schedule[begin_time][]' class='form-control input-sm text-center' type='text' readonly value='" + beginTime + "'>\
                    </td>\
                    <td>\
                        <input name='schedule[end_time][]' class='form-control input-sm text-center' type='text' readonly value='" + endTime + "'>\
                    </td>\
                    <td>\
                        <a id='btnRemoveOfTable' class='btn btn-danger btn-xs text-center'><i class='fa fa-trash fa-2x'></i></a>\
                        <input type='hidden' name='schedule[schedule_id][]' value=''>\
                    </td>\
                </tr>");
        }
        $('#schedule-wizard').resetForm();
    });

    /*
     * Button for Delete record in the Dinamic Table
     */
    $(document).on('click', '#btnRemoveOfTable', function () {
        if ($(this).data('id_schedule') != undefined)
        {
            deleteScheduleFromDB($(this).data('id_schedule'));
        }
        $(this).parent().parent().remove();//change for 'closests()'
    });

    /*
     * Button for send parameters to server
     */
    $('#btnBranchOfficeComplete').on('click', function () {
        var method = $('input[name=_method]'),
            uri =  $("#page").data("url"),
            url = (method.val() == 'POST') ? uri + '/branchOffices' : uri + '/branchOffices/'+ method.data('id');

        var params = {
            type: 'POST',
            url: url,
            loadingSelector: $(".loading-modal-branch-office"),
            form: 'formBranchOffice',
            crud: '<i class="fa fa-server"></i> Server Response',
            successCallback: function (data) {
                //$('form[name="formWizard"]').parsley().reset();
                //$('#formBranchOffice').resetForm();
                //$('.reset-table tr').remove();
                $("#modal_branch_office").modal("hide");
                location.reload();
            },
            errorCallback: function (error) {
                console.log('¡Error!', error);
                $("#modal_branch_office").modal("hide");
            }
        };
        $.ajaxFormData(params);
    });

    /*
     * Button for close the modal, the input´s reset and the clear the dinamic table
     */
    $('#close_modal_branch_office').on('click', function () {
        $('#formBranchOffice').resetForm();
        $('.reset-table tr').remove();
        $('form[name="formWizard"]').parsley().reset();
        $('#imagePreviewContainer').remove();
    });
});

function deleteScheduleFromDB (id)
{
    $.ajax({
        type: 'GET',
        url: 'branchOffices/deleteSchedule/'+id,
        contentType: false,
        processData: false,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($('.loading-modal-branch-office'), "Eliminando...");
        },
        data: false,
        success: function (data) {
            $('.loading-modal-branch-office').unblock();
            toastr.success(data.message, '<i class="fa fa-server"></i> Server Response');
        },
        error: function (error) {
            var data = JSON.parse(error.responseText);
            toastr.error(data.message, '<i class="fa fa-server"></i> Server Response', {closeButton: true, timeOut: 4000, progressBar: true, allowHtml: true});
            $('.loading-modal-branch-office').unblock();
        }
    });
}