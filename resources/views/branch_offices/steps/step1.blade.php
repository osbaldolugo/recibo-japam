<fieldset>
    <div class="col-sm-12 col-lg-7">
        <!-- Description Field -->
        <div class="form-group col-sm-12 col-lg-12">
            <label for="description">Nombre: <span class="text-danger">*</span></label>
            <div>
                {!! Form::text('branchOffice[description]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Descripción',
                'id' => 'description',
                'data-parsley-required' => 'true',
                'data-parsley-required-message' => 'Ingrese un nombre o descripción.',
                'data-parsley-errors-container' => '#description_error',
                'data-parsley-group' => 'wizard-step-1',
                 ]) !!}
                <div id="description_error"></div>
            </div>
        </div>

        <!-- Street Field -->
        <div class="form-group col-sm-12 col-lg-6">
            <label for="street">Calle: <span class="text-danger">*</span></label>
            <div>
                {!! Form::text('branchOffice[street]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Calle',
                'id' => 'street',
                'data-parsley-required' => 'true',
                'data-parsley-required-message' => 'Ingrese una calle.',
                'data-parsley-errors-container' => '#street_error',
                'data-parsley-group' => 'wizard-step-1',
                 ]) !!}
                <div id="street_error"></div>
            </div>
        </div>

        <!-- Settlement Field -->
        <div class="form-group col-sm-12 col-lg-6">
            <label for="settlement">Colonia: <span class="text-danger">*</span></label>
            <div>
                {!! Form::text('branchOffice[settlement]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Colonia',
                'id' => 'settlement',
                'data-parsley-required' => 'true',
                'data-parsley-required-message' => 'Ingrese una colonia.',
                'data-parsley-errors-container' => '#settlement_error',
                'data-parsley-group' => 'wizard-step-1',
                ]) !!}
                <div id="settlement_error"></div>
            </div>
        </div>

        <!-- Inside Number Field -->
        <div class="form-group col-sm-6 col-lg-4">
            {!! Form::label('inside_number', 'No. Int:') !!}
            <div>
                {!! Form::text('branchOffice[inside_number]', null, ['class' => 'form-control input-sm', 'placeholder' => 'No. Interior',
                'id' => 'inside_number',
                'data-parsley-maxlength' => '3',
                'data-parsley-maxlength-message' => 'Caracteres excedidos.',
                'data-parsley-errors-container' => '#noInt_error',
                'data-parsley-group' => 'wizard-step-1',
                ]) !!}
                <div id="noInt_error"></div>
            </div>
        </div>

        <!-- Outside Number Field -->
        <div class="form-group col-sm-6 col-lg-4">
            {!! Form::label('outside_number', 'No. Ext:') !!}
            <div>
                {!! Form::text('branchOffice[outside_number]', null, ['class' => 'form-control input-sm', 'placeholder' => 'No. Exterior',
                'id' => 'outside_number',
                'data-parsley-maxlength' => '3',
                'data-parsley-maxlength-message' => 'Caracteres excedidos.',
                'data-parsley-errors-container' => '#noExt_error',
                'data-parsley-group' => 'wizard-step-1',
                ]) !!}
                <div id="noExt_error"></div>
            </div>
        </div>

        <!-- Cp Field -->
        <div class="form-group col-sm-6 col-lg-4">
            <label for="cp">CP: <span class="text-danger">*</span></label>
            <div>
                {!! Form::text('branchOffice[cp]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Código Postal',
                'id' => 'cp',
                'data-parsley-required' => 'true',
                'data-parsley-required-message' => 'Ingrese un código postal.',
                'data-parsley-min' => '76800',
                'data-parsley-max' => '76850',
                'data-parsley-error-message' => 'Este CP no corresponde a San Juan del Rio.',
                'data-parsley-errors-container' => '#cp_error',
                'data-parsley-group' => 'wizard-step-1',
                ]) !!}
                <div id="cp_error"></div>
            </div>
        </div>

        <!-- Number Phone Field -->
        <div class="form-group col-sm-6 col-lg-6">
            {!! Form::label('number_phone', 'Número Telefónico:') !!}
            <div>
                {!! Form::text('branchOffice[number_phone]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Teléfono',
                'id' => 'number_phone',
                'data-parsley-pattern' => '^[(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{4}',
                'data-parsley-pattern-message' => 'Formato incorrecto.',
                'data-parsley-errors-container' => '#number_phone_error',
                'data-parsley-group' => 'wizard-step-1',
                ]) !!}
                <div id="number_phone_error"></div>
            </div>
        </div>

        <!-- Extension Field -->
        <div class="form-group col-sm-6 col-lg-6">
            {!! Form::label('extension', 'Extensiones:') !!}
            {!! Form::text('branchOffice[extension]', null, ['class' => 'form-control input-sm', 'placeholder' => 'Separar por ","', 'id' => 'extension']) !!}
        </div>
    </div>

    <div class="col-sm-12 col-lg-5">
        <!-- Url Image Field -->
        <div class="form-group col-sm-12 col-lg-12">
            <label for="imagen">Seleccionar imagen: <span class="text-danger">*</span></label>
            <input id="input_image" type="file" class="file"
                   data-preview-file-type="text"
                   data-show-remove="false"
                   data-show-upload="false"
                   accept="image/*"
                   data-parsley-required-message = "Debe adjuntar una imagen."
                   data-parsley-errors-container = "#image_error"
                   data-parsley-group = "wizard-step-1">
            {!! Form::hidden('branchOffice[image]', null, ['id' => 'image']) !!}
            {!! Form::hidden('branchOffice[imageFormat]', null, ['id' => 'imageFormat']) !!}
            <div id="image_error"></div>

            <div id="hiddenDivImagePreview"></div>
        </div>
    </div>
</fieldset>
