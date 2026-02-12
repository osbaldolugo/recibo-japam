<div class="modal fade bs-modal-lg" id="workModal" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(['route' => ('pMOWorks.create'), 'id'=>'formWork']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title">
                    <i class="ion-hammer"></i>
                    Agregar Nuevo Trabajo
                </h4>
            </div>
            <div class="modal-body" id="modal_body_inventario">
                <div class="row">
                    <input name="_method" type="hidden">
                    @include("p_m_o_works.fields")
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i>&nbsp;Cerrar</button>
                <button type="button" id="saveWork" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Guardar Trabajo</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    {!! Form::close() !!}
<!-- /.modal-dialog -->
</div>
