<!-- Code Field -->
<div class="form-group">
    {!! Form::label('txtCode', 'Código:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'txtCode']) !!}
    </div>
</div>

<!-- Unit Field -->
<div class="form-group">
    {!! Form::label('txtUnit', 'Unidad:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('unit', null, ['class' => 'form-control', 'id' => 'txtUnit']) !!}
    </div>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('txtPrice', 'Precio:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('price', 0, ['class' => 'form-control touchSpin', 'id' => 'txtPrice']) !!}
    </div>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('txtDescription', 'Descripción:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-8">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'id' => 'txtDescription']) !!}
    </div>
</div>
