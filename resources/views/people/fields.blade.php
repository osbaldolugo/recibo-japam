<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name 1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name_1', 'Last Name 1:') !!}
    {!! Form::text('last_name_1', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name 2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name_2', 'Last Name 2:') !!}
    {!! Form::text('last_name_2', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('people.index') !!}" class="btn btn-default">Cancel</a>
</div>
