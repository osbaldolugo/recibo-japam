<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h2 class="panel-title">
            <i class="fa fa-ticket"></i>&nbsp;
            {{ trans('lang.index-my-tickets') }}
            <a class="btn btn-sm btn-primary pull-right" href="{{ route('tickets.create') }}" style="margin-top: -6px">
                <i class="fa fa-plus-square"></i>&nbsp;{{ trans('lang.btn-create-new-ticket') }}
            </a>
        </h2>
    </div>
    <div class="panel-body">
        <div id="message"></div>
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="cbxCompleted">Tickets que han sido completados &nbsp;</label>
                <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxCompleted" value="1" name="completed"/>
            </div>
            <div class="col-md-4 form-group">
                <label for="cbxGenerated">Generados por mi &nbsp;</label>
                <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxGenerated" value="1" name="generated"/>
            </div>
            @if($isAdmin || $permits)
                <div class="col-md-4 form-group">
                    <label for="cbxAssigned">Tickets asignados a mi &nbsp;</label>
                    <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxAssigned" value="1" name="assigned"/>
                </div>
                <div class="col-md-4 form-group">
                    {{ Form::label('cmbDepartment', 'Departamento') }}
                    {{ Form::select('cmbDepartment', $department, null, ['id' => 'cmbDepartment', 'class' => 'select2 form-control', 'placeholder' => 'Filtrar por categoría']) }}
                </div>
                <div class="col-md-4 form-group">
                    {{ Form::label('cmbUsers', 'Usuario asignado') }}
                    {{ Form::select('cmbUsers', $users, null, ['id' => 'cmbUsers', 'class' => 'select2 form-control', 'placeholder' => 'Filtrar por usuario']) }}
                </div>
            @endif
            <div class="col-md-4 form-group">
                {{ Form::label('txtFecha', 'Buscar entre dos fechas:') }}
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                    {{ Form::text('fechas', null, ['id' => 'txtFecha', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>
        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

</div>
