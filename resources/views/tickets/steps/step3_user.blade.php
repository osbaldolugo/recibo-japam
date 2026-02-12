<fieldset>
    <legend class="pull-left width-full">Información de quién llama</legend>
    <!-- begin row -->
    <div class="form-horizontal">
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">
                Nombre del titular:
                <span class="help-block">Nombre del titular del recibo.</span>
            </label>
            <div class="col-md-6">
                <label class="form-control" id="lblHeadline">{{ isset($appTicket["headline"]) ? $appTicket["headline"] : "Se requiere especificar un contrato en el recibo" }}</label>
                {{ Form::hidden('app_ticket[headline]', isset($appTicket["headline"]) ? $appTicket["headline"] : null, ['id' => 'txtHeadline']) }}
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">
                Nombre:
                <span class="help-block">Nombre(s) de la persona que llama.</span>
            </label>
            <div class="col-md-6">
                @if(isset($appTicket))
                    <label class="form-control">{{ (isset($appTicket["appUser"])) ? $appTicket["appUser"]["people"]["name"] : (isset($appTicket["peopleUnlogged"]) ? $appTicket["peopleUnlogged"]["name"] : "Anónimo") }}</label>
                @else
                    {{ Form::text('people_unlogged[name]', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nombre completo', 'data-parsley-group' => 'wizard-step-4','required', 'data-parsley-error-message' => 'Se requiere nombre']) }}
                @endif
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="last_name_1" class="col-md-4 control-label">
                Apellidos:
                <span class="help-block">Apellidos de la persona que llama</span>
            </label>
            <div class="col-md-3">
                @if(isset($appTicket))
                    <label class="form-control">{{ isset($appTicket["appUser"]) ? $appTicket["appUser"]["people"]["last_name_1"] : (isset($appTicket["peopleUnlogged"]) ? $appTicket["peopleUnlogged"]["last_name_1"] : 'Anónimo') }}</label>
                @else
                    {{ Form::text('people_unlogged[last_name_1]', null, ['id' => 'last_name_1', 'class' => 'form-control', 'placeholder' => 'Apellido paterno', 'title' => 'Apellido paterno','data-parsley-group' => 'wizard-step-4','required', 'data-parsley-error-message' => 'Se requiere apellido paterno']) }}
                @endif
            </div>
            <div class="col-md-3">
                @if(isset($appTicket))
                    <label class="form-control">{{ isset($appTicket["appUser"]) ? $appTicket["appUser"]["people"]["last_name_2"] : (isset($appTicket["peopleUnlogged"]) ? $appTicket["peopleUnlogged"]["last_name_2"] : "Anónimo") }}</label>
                @else
                    {{ Form::text('people_unlogged[last_name_2]', null, ['id' => 'last_name_2', 'class' => 'form-control', 'placeholder' => 'Apellido materno', 'title' => 'Apellido materno','data-parsley-group' => 'wizard-step-4']) }}
                @endif
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="email" class="col-md-4 control-label">
                Información extra:
                <span class="help-block">Datos para ponerse en contacto con la persona que llama.</span>
            </label>
            <div class="col-md-3">
                @if(isset($appTicket))
                    <label class="form-control">{{ isset($appTicket["appUser"]) ? $appTicket["appUser"]["email"] : (isset($appTicket["peopleUnlogged"]) ? $appTicket["peopleUnlogged"]["email"] : "N/A") }}</label>
                @else
                    {{ Form::email('people_unlogged[email]', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Dirección de correo electrónico', 'data-parsley-type' => 'email', 'data-parsley-group' => 'wizard-step-4', 'data-parsley-error-message' => 'No corresponde ha un correo electrónico válido.']) }}
                @endif
            </div>
            <div class="col-md-3">
                @if(isset($appTicket))
                    <label class="form-control">{{ isset($appTicket["appUser"]) ? $appTicket["appUser"]["phone_number"] : (isset($appTicket["peopleUnlogged"]) ? $appTicket["peopleUnlogged"]["phone_number"] : "N/A") }}</label>
                @else
                    {{ Form::text('people_unlogged[phone_number]', null, ['id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Teléfono Celular', 'data-parsley-pattern' => '^[(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{4}', 'data-parsley-group' => 'wizard-step-4', 'data-parsley-error-message' => 'Es necesario respetar el formato del celular']) }}
                @endif
            </div>
        </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->
</fieldset>