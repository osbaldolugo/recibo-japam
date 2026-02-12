<fieldset>
    <legend class="pull-left width-full">
        Datos del recibo
    </legend>
    <!-- begin row-->
    <div class="form-horizontal">
        <!-- begin col-4-->
        <div class="form-group">
            <label for="contract" class="col-md-4 control-label">
                Número de contrato
            </label>
            <div class="col-md-6">
                {{ Form::text('app_ticket[contract]', isset($appTicket['contract']) ? $appTicket['contract'] : null, ['id' => 'contract', 'class' => 'form-control', 'placeholder' => '12345-12345-123456']) }}
            </div>
        </div>
        <!-- end col-4 -->
        <!-- begin col-4 -->
        {{--<div class="form-group">
            <label for="barcode" class="col-md-4 control-label">
                Código de barras
            </label>
            <div class="col-md-6">
                {{ Form::text('receipt[barcode]', null, ['id' => 'barcode', 'class' => 'form-control', 'placeholder' => '12345678901','data-parsley-group' => 'wizard-step-4','required', 'data-parsley-error-message' => 'Se requiere código de barras']) }}
                <div class="alert alert-danger fade in m-t-15 hidden" id="errorRecipt">
                    <strong>No se encontro ningún recibo con la información proporcionada</strong>
                </div>
            </div>
        </div>--}}
        <!-- end col-4 -->
        <!-- begin col-4 -->
        <div class="form-group">
            <label for="barcode" class="col-md-4 control-label">
                Medidor
            </label>
            <div class="col-md-6">
                {{ Form::text('app_ticket[meter]', isset($appTicket['meter']) ? $appTicket['meter'] : null, ['id' => 'meter', 'class' => 'form-control', 'placeholder' => '12345678']) }}
                <div class="alert alert-danger fade in m-t-15 hidden errorRecipt">
                    <strong>No se encontro ningún recibo con la información proporcionada</strong>
                </div>
            </div>
        </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->
</fieldset>