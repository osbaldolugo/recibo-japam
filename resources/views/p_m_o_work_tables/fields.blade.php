
<!-- Method change -->
<input name="_method" value="{!! isset($workOrden['id'])?'PUT':'POST' !!}" type="hidden">

<!-- Id Pmo Work Table Field -->
<div class="form-group col-sm-6 hidden">
    {!! Form::label('id_pmo_work_table', 'Id Pmo Work Table:') !!}
    {!! Form::number('id_pmo_work_table', isset($workOrden["id"])?$workOrden["ticket_id"]:null, ['class' => 'form-control','id'=>'id_pmo_work_table']) !!}
</div>

<!-- Id Ticketit Field -->
<div class="form-group col-sm-6 hidden">
    {!! Form::label('ticket_id', 'Id Ticketit:') !!}
    {!! Form::number('ticket_id', isset($workOrden["ticket_id"])?$workOrden["ticket_id"]:isset($ticket["id"])?$ticket["id"]:null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12">
    <!-- Id Work Field -->
    <div class="form-inline col-sm-8">
        {!! Form::label('work_id', 'Trabajo:') !!}
        {!! Form::select('work_id',$PMOWorks, isset($workOrden["work_id"])?$workOrden["work_id"]:null, ['readonly'=>'','class' => '','id'=>'id_work', 'data-route'=> route("pMOWorks.index"), 'placeholder' => 'Selecciona el Trabajo...',
                                                                                                            "data-parsley-group" =>"wizard-step-1","required"=>"true","data-parsley-group" =>"wizard-step-1",
                                                                                                            "required"=>"true", 'data-parsley-errors-container' => 'div[name="work_id_error"]', 'data-parsley-error-message' => 'Es necesario asignar el Trabajo a realizar']) !!}

    </div>
    <!-- Nuevo Field check-->

    <div class="form-inline col-sm-4">
        {!! Form::label('check_description', 'Nuevo:',["class"=>""]) !!}
        <input name="check_description" type="checkbox" data-render="switchery" data-theme="default" unchecked value="{{ isset($workOrden["check_description"])?$ticket["check_description"]:null }}"/>
    </div>
</div>

<br/>
<div class="form-group col-sm-12">
    <div class="form-horizontal col-sm-12">
        {!! Form::label('desc_work', 'Descripci¨®n de trabajo:') !!}
        {!! Form::textarea('desc_work', isset($workOrden["name"])?$workOrden["name"]:null, ['readonly'=>'','class' => 'form-control', "rows"=>"3","cols"=>"40","data-parsley-group" =>"wizard-step-1","required"=>"true",'data-parsley-error-message' => 'La descripci¨®n no puede ser nula']) !!}
    </div>
</div>

<div class="form-group col-sm-12">
    {{--<!-- Sector Field -->
    <div class="form-inline col-sm-6 hidden">
        {!! Form::label('subsector', 'Subsector:') !!}
        {!! Form::text('subsector', isset($pmo_workcontrol["subsector"])?$pmo_workcontrol["subsector"]:null, ['class' => 'form-block','readonly'=>'']) !!}
    </div>--}}

    <!-- Equipment Code Field -->
    <div class="form-inline col-sm-6">
        {!! Form::label('equipment_id', 'C¨®digo de Equipo:') !!}
        {!! Form::select('equipment_id', $PMOEquipments,isset($workOrden["equipment_id"])?$workOrden["equipment_id"]:null, ['class' => 'form-control', "data-parsley-group" =>"wizard-step-1", "required"=>"true", 'placeholder' => 'Selecciona el equipo...', 'data-parsley-errors-container' => 'div[name="equipment_id_error"]', 'data-parsley-error-message' => 'Es necesario asignar el Equipo']) !!}

    </div>
    <!-- begin col-4 -->
    <div class="form-inline col-md-6">
        {!! Form::label('worktype_id', 'Tipo de Trabajo:') !!}
        {{ Form::select('worktype_id', $PMOWorkTypes, isset($workOrden["worktype_id"])?$workOrden["worktype_id"]:null, ['class' => '','id' => 'worktype_id', "data-parsley-group" =>"wizard-step-1","required"=>"true", 'placeholder' => 'Selecciona la prioridad...', 'data-parsley-errors-container' => 'div[name="work_type_id_error"]', 'data-parsley-error-message' => 'Es necesario asignar el tipo de trabajo']) }}

    </div>
    <!-- end col-4 -->

</div>

<div class="form-group col-sm-12">
    <!-- begin col-6-->
    <div class="form-inline col-md-6">
        {!! Form::label('depto_ejecutor', 'Departamento Ejecutor:') !!}
        {{ Form::select('executor_category_id', $categories, isset($workOrden["executor_category_id"])?$workOrden["executor_category_id"]:null, ['id' => 'executor_category_id','readonly'=>'', 'class' => 'form-control', 'required', 'placeholder' => 'Selecciona la prioridad...', 'data-parsley-errors-container' => 'div[name="category_id_error"]', 'data-parsley-group' => 'wizard-step-1', 'data-parsley-error-message' => 'Es necesario asignar la orden a un departamento']) }}
    </div>
    <!-- end col-5 -->
    <!-- Vo Bo Field -->
    <div class="form-inline col-sm-6 hidden">
        {!! Form::label('vo_bo', 'Visto Bueno:') !!}
        {!! Form::select('vo_bo', [], isset($workOrden["vo_bo"])?$workOrden["vo_bo"]:Auth::user()->id, ['class' => '','readonly'=>'']) !!}
    </div>
</div>

<div class="form-group col-sm-12">
    <!-- Deadline Field -->
    <div class="col-sm-4">
        {!! Form::label('deadline', 'Fecha Limite:') !!}
        {!! Form::text('deadline', isset($workOrden["deadline"])?$workOrden["deadline"]:isset($ticket->created_at)?$ticket->created_at->addDays($ticket->priority->response_time):null, ['class' => 'form-control','readonly'=>'']) !!}
    </div>

    <!-- Status Field -->
    {{--<div class="form-inline col-sm-6">
        {!! Form::label('status', 'Status:') !!}
        {!! Form::select('status', [], isset($pmo_workcontrol["status"])?$pmo_workcontrol["status"]:null, ['class' => '','required', 'placeholder' => 'Selecciona la prioridad...', 'data-parsley-errors-container' => '#status_id_error', 'data-parsley-group' => 'wizard-step-1', 'data-parsley-error-message' => 'Es necesario asignar un Estatus de']) !!}
        <div id="status_id_error"></div>
    </div>--}}
</div>

<!-- Date End Field -->
<div class="form-group col-sm-6 hidden">
    {!! Form::label('date_end', 'Fecha Conclusion:') !!}
    {!! Form::text('date_end', isset($workOrden["date_end"])?$workOrden["date_end"]:null, ['class' => 'form-control','readonly'=>'']) !!}
</div>


<!-- Submit Field
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pMOWorkTables.index') !!}" class="btn btn-default">Cancelar</a>
</div>-->
