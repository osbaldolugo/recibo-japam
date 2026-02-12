<fieldset>
    <legend class="pull-left width-full">Identificación del problema</legend>
    <!-- begin row -->
    <div class="form-horizontal">
        {{ Form::hidden('ticketit[user_id]', Auth::user()->id) }}
        {{ Form::hidden('ticketit[user_required]', null) }}
        {{ Form::hidden('ticketit[receipt_required]', null) }}
        <!-- begin col-4 -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="html">
                *&nbsp;Descripción del problema:
                <span class="help-block">{!! trans('lang.create-ticket-describe-issue') !!}</span>
            </label>
            <div class="col-md-8">
            {!! Form::textarea('ticketit[html]', isset($appTicket["description"]) ? $appTicket["description"] : null, ['id' => 'html', 'class' => 'form-control summernote-editor', 'data-parsley-errors-container' => '#html_error', 'data-parsley-group' => 'wizard-step-1', 'required', 'data-parsley-error-message' => 'Es necesario realizar una pequeña descripción del problema']) !!}
            <!-- <input type="text" name="middle" placeholder="A" class="form-control" data-parsley-group="wizard-step-1" required /> -->
                <div id="html_error"></div>
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="incident_id" class="col-md-4 control-label">
                *&nbsp;Problema detectado:
                <span class="help-block">Motivo de la llamada</span>
            </label>
            <div class="col-md-8">
                {{ Form::select('ticketit[incidents_id]', $incidents, null, ['id' => 'incident_id', 'class' => 'form-control', 'required', 'data-parsley-errors-container' => '#incident_id_error', 'data-parsley-error-message' => 'Es necesario seleccionar el motivo de la llamada', 'placeholder' => 'Seleccione el motivo de llamada...', 'data-parsley-group' => 'wizard-step-1' ]) }}
                <div id="incident_id_error"></div>
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="priority_id" class="col-md-4 control-label">
                *&nbsp;Prioridad
                <span class="help-block">Urgencia para resolver el problema.</span>
            </label>
            <div class="col-md-8">
                {{ Form::select('ticketit[priority_id]', $priorities, null, ['id' => 'priority_id', 'class' => 'form-control', 'required', 'placeholder' => 'Selecciona la prioridad...', 'data-parsley-errors-container' => '#priority_id_error', 'data-parsley-group' => 'wizard-step-1', 'data-parsley-error-message' => 'Es necesario establecer la prioridad del Tiquet']) }}
                <div id="priority_id_error"></div>
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="category_id" class="col-md-4 control-label">
                *&nbsp;Departamento
                <span class="help-block">Departamento al que sera asignado.</span>
            </label>
            <div class="col-md-8">
                {{ Form::select('ticketit[category_id]', $categories, null, ['id' => 'category_id', 'class' => 'form-control', 'required', 'placeholder' => 'Selecciona el área responsable...', 'data-parsley-errors-container' => '#category_id_error', 'data-parsley-group' => 'wizard-step-1', 'data-parsley-error-message' => 'Es necesario asignar el tiquet a un departamento']) }}
                <div id="category_id_error"></div>
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
            <div class="form-group">
                <label for="cbxOrder" class="col-md-4 control-label">
                    Orden de Trabajo Directa
                    <span class="help-block">En caso de ser una Orden de Trabajo Directa</span>
                </label>
                <div class="col-md-8">
                    <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxOrder" value="1" name="isDirectOrder"/>
                </div>
            </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->
</fieldset>
