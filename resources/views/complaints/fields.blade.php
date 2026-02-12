<!-- App User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('app_user_id', 'App User Id:') !!}
    {!! Form::number('app_user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- People Unlogged Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('people_unlogged_id', 'People Unlogged Id:') !!}
    {!! Form::number('people_unlogged_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
</div>


<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::date('created_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Updated At:') !!}
    {!! Form::date('updated_at', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('complaints.index') !!}" class="btn btn-default">Cancel</a>
</div>
