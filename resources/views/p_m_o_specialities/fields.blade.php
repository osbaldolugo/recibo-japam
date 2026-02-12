<!-- Speciality Field -->
<div class="form-group">
    {!! Form::label('txtSpeciality', 'Especialidad:', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('speciality', null, ['class' => 'form-control', 'id' => 'txtSpeciality', 'placeholder' => 'Escribe la especialidad']) !!}
    </div>
</div>

<!-- Created At Field -->
{{--<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Created At:') !!}
    {!! Form::date('created_at', null, ['class' => 'form-control']) !!}
</div>--}}

<!-- Deleted At Field
<div class="form-group col-sm-6">
    {{--{!! Form::label('deleted_at', 'Deleted At:') !!}
    {!! Form::date('deleted_at', null, ['class' => 'form-control']) !!}--}}
</div>
-->
