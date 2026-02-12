<!-- Pmo Work Table Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pmo_work_table_id', 'Pmo Work Table Id:') !!}
    {!! Form::number('pmo_work_table_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Lat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lat', 'Lat:') !!}
    {!! Form::number('lat', null, ['class' => 'form-control']) !!}
</div>

<!-- Lng Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lng', 'Lng:') !!}
    {!! Form::number('lng', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pMOWorkOrderSectorDots.index') !!}" class="btn btn-default">Cancel</a>
</div>
