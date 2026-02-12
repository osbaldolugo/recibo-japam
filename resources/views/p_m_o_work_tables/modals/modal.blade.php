<div class="modal fade bs-modal-lg" id="workModal" tabindex="-1" role="dialog" aria-hidden="true">
{!! Form::open(['route' => ('pMOWorks.create'), 'id'=>'formWork']) !!}
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Trabajo </h4>
        </div>
        <div class="modal-body" id="modal_body_inventario">
            @include("p_m_o_works.fields")
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
            <button type="button" id="saveWork" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus">&nbsp;</i>Guardar Trabajo</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
