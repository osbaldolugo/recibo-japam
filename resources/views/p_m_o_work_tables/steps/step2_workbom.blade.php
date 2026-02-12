<fieldset>
    <div class="row">
        <!-- begin row -->
        <div class="col-lg-6 form-horizontal">
            <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                    </div>
                    <h4 class="panel-title">Mano de Obra</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <thead>
                            <tr>
                                Nom.ID
                            </tr>
                            <tr>
                                Nombre
                            </tr>
                            <tr>
                                Horas
                            </tr>
                            <tr>
                                Horas Extras
                            </tr>
                        </thead>
                        <table class="table table-responsive" >

                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- begin row-->
        <div class="col-lg-6 form-horizontal">


            <div class="panel panel-inverse" data-sortable-id="table-basic-6">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                    </div>
                    <h4 class="panel-title">Materiales</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    No. Material
                                </tr>
                                <tr>
                                    Descripción
                                </tr>
                                <tr>
                                    Cantidad de Material
                                </tr>
                            </thead>
                            <tbody id=tableMaterial>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->



        <div class="form-group col-sm-6">
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('worker_cost', 'Mano de Obra:') !!}
                {{ Form::text('worker_cost', isset($pmo_workcontrol["worker_cost"])?$pmo_workcontrol["worker_cost"]:null, ['class' => 'form-control','id' => 'worker_cost', "data-parsley-group" =>"wizard-step-2"]) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 --><!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('material_cost', 'Material:') !!}
                {{ Form::text('material_cost', isset($pmo_workcontrol["material_cost"])?$pmo_workcontrol["material_cost"]:null, ['class' => 'form-control','id' => 'material_cost', "data-parsley-group" =>"wizard-step-2"]) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('tools_cost', 'Herramientas:') !!}
                {{ Form::text('tools_cost', isset($pmo_workcontrol["tools_cost"])?$pmo_workcontrol["tools_cost"]:null, ['class' => 'form-control','id' => 'tools_cost', "data-parsley-group" =>"wizard-step-2"]) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('other_cost', 'Otros:') !!}
                {{ Form::text('other_cost', isset($pmo_workcontrol["other_cost"])?$pmo_workcontrol["other_cost"]:null, ['class' => 'form-control','id' => 'other_cost', "data-parsley-group" =>"wizard-step-2"]) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->
        </div>
        <div class="form-group col-sm-6">
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('work_time', 'Tiempo de Duración del Trabajo:') !!}
                {{ Form::text('work_time', isset($pmo_workcontrol["work_time"])?$pmo_workcontrol["work_time"]:null, ['class' => 'form-control','id' => 'work_time', "data-parsley-group" =>"wizard-step-2"]) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->
            <!-- Equipment Code Field -->
            <div class="form-inline col-sm-12">
                {!! Form::label('cause_id', 'Causa:') !!}
                {!! Form::select('cause_id', $PMOEquipments,isset($pmo_workcontrol["cause_id"])?$pmo_workcontrol["cause_id"]:null, ['class' => 'form-control', "data-parsley-group" =>"wizard-step-1", 'placeholder' => 'Selecciona el equipo...']) !!}
                <div id="equipment_id_error"></div>
            </div>
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('supervisory_id', 'Supervisar:') !!}
                {{ Form::select('supervisory_id', $PMOWorkTypes, isset($pmo_workcontrol["supervisory_id"])?$pmo_workcontrol["supervisory_id"]:null, ['class' => '','id' => 'supervisory_id', "data-parsley-group" =>"wizard-step-1", 'placeholder' => 'Selecciona la prioridad...']) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="form-inline col-md-12">
                {!! Form::label('captured_id', 'Capturo:') !!}
                {{ Form::select('captured_id', $PMOWorkTypes, isset($pmo_workcontrol["captured_id"])?$pmo_workcontrol["captured_id"]:null, ['class' => '','id' => 'captured_id', "data-parsley-group" =>"wizard-step-1", 'placeholder' => 'Selecciona la prioridad...']) }}
                <div id="work_type_id_error"></div>
            </div>
            <!-- end col-4 -->

        </div>

    </div>
</fieldset>