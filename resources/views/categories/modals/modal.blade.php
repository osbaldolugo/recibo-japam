<div class="modal fade bs-modal-lg" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    {{--This route doesnt is used--}}
    {!! Form::open(['route' => ('categories.create'), 'id'=>'formCategory']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title">
                    <i class="ion-grid"></i>
                    Agregar Nueva Área
                </h4>
            </div>
            <div class="modal-body" id="modal_body_incident">
                <div class="row">
                    <input name="_method" type="hidden">
                    <div class="form-horizontal">
                        <div class="col-md-12">
                            @include("categories.fields")
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i>&nbsp;Cerrar</button>
                <button type="button" id="saveCategory" class="btn btn-primary"><i class="fa fa-plus-square"></i>&nbsp;Guardar Area</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    {!! Form::close() !!}
<!-- /.modal-dialog -->
</div>
