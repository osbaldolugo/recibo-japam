<fieldset>
    <div class="row col-lg-12 col-sm-12">
        <small><b>Marque un punto en el mapa para regisrar la ubicación de la sucursal.</b><span class="text-danger">*</span></small>
    </div>
    <hr>
    <div class="col-lg-12 col-sm-12 p-0">
        <div class="col-sm-12 col-lg-2">
            <div class="form-group">
                <small>Latitud<span class="text-danger">*</span></small>
                {!! Form::text('branchOffice[latitude]', null, ['class' => 'form-control input-sm', 'id'=>'latitude', 'readonly',
                'required',
                'data-parsley-errors-messages-disabled' => 'true',
                'data-parsley-group' => 'wizard-step-3',
                ]) !!}
                <div id="latitude_error"></div>
            </div>
            <div class="form-group">
                <small>Longitud<span class="text-danger">*</span></small>
                {!! Form::text('branchOffice[longitude]', null, ['class' => 'form-control input-sm', 'id'=>'longitude', 'readonly',
                'required',
                'data-parsley-errors-messages-disabled' => 'true',
                'data-parsley-group' => 'wizard-step-3',
                ]) !!}
            </div>
        </div>
        <div class="col-sm-12 col-lg-10 p-0">
            <div id="map"></div>
        </div>
    </div>
</fieldset>