<div class="modal fade bs-modal-lg" id="workTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(['route' => ('pMOWorks.create'), 'id'=>'formWorktype']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title">
                    <i class="ion-settings"></i>
                    Agregar Nuevo Tipo de Trabajo
                </h4>
            </div>
            <div class="modal-body" id="modal_body_inventario">
                <div class="row">
                    <input name="_method" type="hidden">
                    <div class="form-horizontal">
                        <div class="col-md-12">
                            @include("p_m_o_work_types.fields")
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i>&nbsp;Cerrar</button>
                <button type="button" id="saveWorkType" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Guardar Tipo de Trabajo</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
