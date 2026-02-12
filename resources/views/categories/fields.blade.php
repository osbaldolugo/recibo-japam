<!-- Name Field -->
<div class="form-group">
    {!! Form::label('txtName', 'Nombre:', ['class' => 'col-md-4 control-label']) !!}
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

<!-- Executor Field -->
<div class="form-group">
    <label class="col-md-4 control-label" for="cbxExecutor">Ejecutor</label>
    <div class="col-md-6">
        <input type="checkbox" id="cbxExecutor" name="executor" value="1"/>
    </div>
</div>
