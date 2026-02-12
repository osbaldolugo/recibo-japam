<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('suburb', 'Colonia:') !!}
    {!! Form::text('suburb', null, ['class' => 'form-control']) !!}
</div>

<!-- name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sector_id', 'Sector:') !!}
    {!! Form::select('sector_id', $sectors, isset($sector) ? $sector->id : null, ['class' => 'select2 form-control', 'placeholder' => 'Selecciona el Sector de la colonia']) !!}
</div>