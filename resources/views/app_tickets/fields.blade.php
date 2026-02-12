<!-- Incidents Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('incidents_id', 'Incidents Id:') !!}
    {!! Form::number('incidents_id', null, ['class' => 'form-control']) !!}
</div>

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
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Street Field -->
<div class="form-group col-sm-6">
    {!! Form::label('street', 'Street:') !!}
    {!! Form::text('street', null, ['class' => 'form-control']) !!}
</div>

<!-- Outside Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('outside_number', 'Outside Number:') !!}
    {!! Form::text('outside_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Inside Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('inside_number', 'Inside Number:') !!}
    {!! Form::text('inside_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Suburb Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('suburb_id', 'Suburb Id:') !!}
    {!! Form::number('suburb_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Cp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cp', 'Cp:') !!}
    {!! Form::text('cp', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('appTickets.index') !!}" class="btn btn-default">Cancel</a>
</div>
