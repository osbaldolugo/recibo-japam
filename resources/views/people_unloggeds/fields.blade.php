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

<!-- Receipt Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receipt_id', 'Receipt Id:') !!}
    {!! Form::number('receipt_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('peopleUnloggeds.index') !!}" class="btn btn-default">Cancel</a>
</div>
