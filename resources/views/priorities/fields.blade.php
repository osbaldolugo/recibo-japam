<!-- Name Field -->
<div class="form-group">
    {!! Form::label('txtName', 'Prioridad:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'txtName']) !!}
    </div>
</div>

<!-- Color Field -->
<div class="form-group">
    {!! Form::label('txtColor', 'Color:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('color', "#000000", ['class' => 'form-control', 'id' => 'txtColor']) !!}
    </div>
</div>

<!-- Response Time Field -->
<div class="form-group">
    {!! Form::label('txtTime', 'Tiempo de respuesta (Dias):', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('response_time', null, ['class' => 'form-control touchSpin', 'id' => 'txtTime']) !!}
    </div>
</div>
