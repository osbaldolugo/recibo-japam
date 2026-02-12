<!-- Speciality Id Field -->
<div class="form-group">
    {!! Form::label('txtSpeciality', 'Especialidad:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('speciality_id', $specialities, null, ['class' => 'form-control', 'id' => 'txtSpeciality', 'placeholder' => 'Selecciona la especialidad']) !!}
    </div>
</div>

<!-- Nom Id Field -->
<div class="form-group">
    {!! Form::label('txtNomID', 'ID Nómina:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('nom_id', null, ['class' => 'form-control', 'id' => 'txtNomID', 'placeholder' => 'ID Nómina']) !!}
    </div>
    <!-- Dairy Salary Field -->
    <div class="col-sm-2">
        {!! Form::text('dairy_salary', 0, ['class' => 'form-control touchSpin', 'id' => 'txtSalary', 'placeholder' => 'Salario x día']) !!}
    </div>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('txtName', 'Nombre:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'txtName', 'placeholder' => 'Nombre del trabajador']) !!}
    </div>
</div>
