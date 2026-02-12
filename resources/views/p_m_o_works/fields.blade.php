<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Descripcion:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
</div>


<!-- Code Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', 'Código:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

