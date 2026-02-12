<!-- App User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('app_user_id', 'App User Id:') !!}
    {!! Form::number('app_user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner', 'Owner:') !!}
    {!! Form::text('owner', null, ['class' => 'form-control']) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Number:') !!}
    {!! Form::text('number', null, ['class' => 'form-control']) !!}
</div>

<!-- Exp Month Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exp_month', 'Exp Month:') !!}
    {!! Form::text('exp_month', null, ['class' => 'form-control']) !!}
</div>

<!-- Exp Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('exp_year', 'Exp Year:') !!}
    {!! Form::text('exp_year', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('appUserCards.index') !!}" class="btn btn-default">Cancel</a>
</div>
