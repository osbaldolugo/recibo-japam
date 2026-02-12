<fieldset>
    <div class="col-sm-12 col-lg-12">
        <div id="schedule-wizard">
            <div class="form-group col-sm-12 col-lg-3">
                <label for="area">Área: <span class="text-danger">*</span></label>
                <div>
                    {!! Form::select('schedule[area]', ['box'=>'Cajas', 'atention'=>'Atención a Clientes'], null, ['class' => 'form-control', 'placeholder' => 'Seleccionar área',
                    'id' => 'area',
                    'required',
                    'data-parsley-error-message' => 'Seleccione área.',
                    'data-parsley-errors-container' => '#area_error',
                    'data-parsley-group' => 'schedule-wizard',
                     ]) !!}
                    <div id="area_error"></div>
                </div>
            </div>
            <div class="form-group col-sm-12 col-lg-3">
                <label for="work_day">Día Laboral: <span class="text-danger">*</span></label>
                <div>
                    {!! Form::select('schedule[work_day]', ['week'=>'Lunes a Viernes', 'saturday'=>'Sábado'], '', ['class' => 'form-control', 'placeholder' => 'Seleccionar día laboral',
                    'id' => 'work_day',
                    'data-parsley-required' => 'true',
                    'data-parsley-required-message' => 'Seleccione día laboral.',
                    'data-parsley-errors-container' => '#work_day_error',
                    'data-parsley-group' => 'schedule-wizard',
                     ]) !!}
                    <div id="work_day_error"></div>
                </div>
            </div>
            <label class="col-sm-12 col-lg-6">Horario: <span class="text-danger">*</span></label>
            <div class="form-group col-sm-11 col-lg-5">
                <div class="col-lg-12 col-sm-12 p-0 m-0">
                    <div class="input-group date">
                        {!! Form::text('schedule[begin_time]', null, ['id'=>'beginTimePicker', 'required', 'class' => 'form-control', 'placeholder'=>'Hora de apertura',
                        'data-parsley-error-message' => 'Es necesario seleccionar una hora de apertura.',
                        'data-parsley-errors-container' => '#begin_time_error',
                        'data-parsley-group' => 'schedule-wizard',
                        ]) !!}
                        <span class="input-group-addon">a:</span>
                        {!! Form::text('schedule[end_time]', null, ['id'=>'endTimePicker', 'required', 'class' => 'form-control', 'placeholder'=>'Hora de cierre',
                        'data-parsley-error-message' => 'Es necesario seleccionar una hora de cierre.',
                        'data-parsley-errors-container' => '#end_time_error',
                        'data-parsley-group' => 'schedule-wizard',
                        ]) !!}
                    </div>
                    <div class="col-lg-12 col-sm-12 p-0">
                        <div class="col-lg-6 col-sm-6 p-l-0" id="begin_time_error"></div>
                        <div class="col-lg-6 col-sm-6 p-r-0" id="end_time_error"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-1 col-lg-1">
            <a href="javascript:;" id="addScheduleToTable" class="btn btn-default"><i class="fa fa-plus"></i></a>
        </div>

        <div class="col-lg-12 col-sm-12">
            <hr class="m-t-5 m-b-5">
            <div  id="table-error"></div>
            <div class="table-responsive m-t-5" style="overflow: auto; max-height: 180px;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Día Laboral</th>
                        <th>Hora de Apertura</th>
                        <th>Hora de Cierre</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                        <tbody id="content-table-body" class="reset-table"></tbody>
                </table>
            </div>
        </div>
    </div>
</fieldset>