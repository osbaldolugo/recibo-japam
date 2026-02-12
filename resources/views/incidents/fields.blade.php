<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nombre:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-8">
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Titulo del incidente']) !!}
    </div>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Descripción:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'rows' => '5']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('options', 'Opciones al momento de generar el tiquet:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-md-8">
        <div class="input-group">
            <div class="icheck-list">
                <label class="col-md-12">
                    {!! Form::checkbox('ticket', 1, false, ['class' => 'icheck form-group', 'id' => 'is_ticket']) !!}
                    Procede para generar un tiquet
                </label>
                <label class="col-md-12">
                    {!! Form::checkbox('user_required', 1, false, ['class' => 'icheck form-group', 'id' => 'user_required']) !!}
                    La información del usuario es requerida (al generar el tiquet)
                </label>
                <label class="col-md-12">
                    {!! Form::checkbox('receipt_required', 1, false, ['class' => 'icheck form-group', 'id' => 'receipt_required']) !!}
                    La información del recibo es requerida (al generar el tiquet)
                </label>
            </div>
        </div>
    </div>
</div>
