
<div class="modal fade bs-modal-lg" id="suburbModal" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(['route' => ('suburbs.create'), 'id'=>'formSuburb']) !!}
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Inventario </h4>
            </div>
            <div class="modal-body" id="modal_body_inventario">
                <input name="_method" type="hidden">
                <!-- Code Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('suburb', 'Colonia:') !!}
                    {!! Form::text('suburb', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-sm-6 hidden">
                    {!! Form::label('sector_id', 'Sector:') !!}
                    {!! Form::text('sector_id', isset($sector["id"])?$sector["id"]:null, ['class' => 'form-control', "id"=>"sector_suburb_id"]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                <button type="button" id="saveColoniaSector" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-plus">&nbsp;</i>Guardar Colonia</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    {!! Form::close() !!}
</div>