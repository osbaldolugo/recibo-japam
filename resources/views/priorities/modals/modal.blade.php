<div class="modal fade bs-modal-lg" id="priorityModal" tabindex="-1" role="dialog" aria-hidden="true">
    {{--This route doesnt is used--}}
    {!! Form::open(['route' => ('priorities.create'), 'id'=>'formPriority']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title">
                    <i class="fa fa-level-up"></i>
                    <i class="fa fa-level-down fa-flip-horizontal"></i>
                    Agregar Nueva Prioridad
                </h4>
            </div>
            <div class="modal-body" id="modal_body_incident">
                <div class="row">
                    <input name="_method" type="hidden">
                    <div class="form-horizontal">
                        <div class="col-md-12">
                            @include("priorities.fields")
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i>&nbsp;Cerrar</button>
                <button type="button" id="savePriority" class="btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Guardar Prioridad</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    {!! Form::close() !!}
<!-- /.modal-dialog -->
</div>
