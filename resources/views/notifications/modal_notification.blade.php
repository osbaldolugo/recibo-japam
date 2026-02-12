<div class="modal fade in" id="modal_notification" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="frmUpdateNotification" data-parsley-validate="" autocomplete="off">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close_modal_notification"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Actualizar Notificación</h4>
                </div>
                <div class="modal-body loading-modal-notification">
                    {!! Form::hidden('_method', null) !!}
                    {!! Form::hidden('id', null) !!}
                    @include('notifications.fields')
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <button id="btnUpdateNotification" class="btn btn-sm bg-color-2 text-white"  type="submit">
                            <i class="fa fa-save"></i>
                            Actualizar
                        </button>
                        {{Form::button('<i class="fa fa-times-circle"></i> Cerrar',["class"=>"btn btn-sm btn-default close-modal-slider-home","data-dismiss"=>"modal"])}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>