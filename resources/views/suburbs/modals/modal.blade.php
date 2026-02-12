<div class="modal fade bs-modal-lg" id="suburbModal" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(['route' => ('suburbs.create'), 'id'=>'formSuburb']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title">
                    <i class="fa fa-map-pin"></i>
                    Agregar Nueva Colonia
                </h4>
            </div>
            <div class="modal-body" id="modal_body_suburb">
                <div class="row">
                    <input name="_method" type="hidden">
                    @include("suburbs.fields")
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i>&nbsp;Cerrar</button>
                <button type="button" id="saveSuburb"  class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Guardar Colonia</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    {!! Form::close() !!}
<!-- /.modal-dialog -->
</div>
