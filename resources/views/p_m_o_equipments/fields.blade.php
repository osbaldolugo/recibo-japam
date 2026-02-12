<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('txtCode', 'Código:') !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'txtCode']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('txtDescription', 'Descripción:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'id' => 'txtDescription']) !!}
</div>