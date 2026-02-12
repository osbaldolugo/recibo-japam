<div class="modal fade bs-modal-lg" id="indicidentModal" tabindex="-1" role="dialog" aria-hidden="true">
    {{--This route doesnt is used--}}
    {!! Form::open(['route' => ('pMOWorks.create'), 'id'=>'formIncident']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title"><i class="fa fa-phone"></i> Motivo de Llamada </h4>
            </div>
            <div class="modal-body" id="modal_body_incident">
                <input name="_method" type="hidden">
                <div class="form-horizontal">
                    @include("incidents.fields")
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
                <button type="button" id="saveIncident" class="btn btn-primary"><i class="glyphicon glyphicon-plus">&nbsp;</i>Guardar Motivo de Llamada</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    {!! Form::close() !!}
<!-- /.modal-dialog -->
</div>
