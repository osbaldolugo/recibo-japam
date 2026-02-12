<!-- Pmo Work Table Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pmo_work_table_id', 'Pmo Work Table Id:') !!}
    {!! Form::number('pmo_work_table_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Work Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('work_time', 'Work Time:') !!}
    {!! Form::text('work_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Cause Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cause_id', 'Cause Id:') !!}
    {!! Form::number('cause_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Supervisory Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('supervisory_id', 'Supervisory Id:') !!}
    {!! Form::number('supervisory_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Captured Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('captured_id', 'Captured Id:') !!}
    {!! Form::number('captured_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tools Cost Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tools_cost', 'Tools Cost:') !!}
    {!! Form::number('tools_cost', null, ['class' => 'form-control']) !!}
</div>

<!-- Other Cost Field -->
<div class="form-group col-sm-6">
    {!! Form::label('other_cost', 'Other Cost:') !!}
    {!! Form::number('other_cost', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pMOWorkTableFinishes.index') !!}" class="btn btn-default">Cancel</a>
</div>
