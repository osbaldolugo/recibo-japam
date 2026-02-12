<fieldset>
    <legend class="pull-left width-full">Ubicación del problema</legend>
    <!-- begin row -->
    <div class="row">
        <div class="col-md-6">
            <!-- Address -->
            <div class="form-group">
                <label for="street" class="control-label">
                    *&nbsp;Calle:
                    {{--<span class="help-block">Dirección de la falla</span>--}}
                </label>
                {{ Form::text('ticketit[street]', isset($appTicket["street"]) ? $appTicket["street"] : null, ['id' => 'street', 'class' => 'form-control', 'required', 'data-parsley-group' => 'wizard-step-2', 'placeholder' => 'Cuauhtemoc', 'data-parsley-error-message' => 'Es necesario especificar la calle']) }}
            </div>
            <!-- end Address -->
            <!-- Number of address -->
            <div class="form-group">
                <div class="row">
                    <label for="outside_number" class="control-label col-md-12">
                        *&nbsp;Número:
                        {{--<small>Número de la propiedad</small>--}}
                    </label>
                    <div class="col-md-6">
                        {{ Form::text('ticketit[outside_number]', isset($appTicket["outside_number"]) ? $appTicket["outside_number"] : null, ['id' => 'outside_number', 'class' => 'form-control', 'required', 'data-parsley-group' => 'wizard-step-2', 'data-parsley-error-message' => 'No puede quedar vacio', 'placeholder' => '33', 'title' => 'Número exterior']) }}
                    </div>
                    <div class="col-md-6">
                        {{ Form::text('ticketit[inside_number]', isset($appTicket["inside_number"]) ? $appTicket["inside_number"] : null, ['id' => 'inside_number', 'class' => 'form-control', 'placeholder' => 'Número interior', 'title' => 'Número interior']) }}
                    </div>
                </div>
            </div>
            <!-- end Address -->
            <!-- Suburb -->
            <div class="form-group">
                <label for="suburb" class="control-label">
                    *&nbsp;Colonia:
                    <span class="help-block" id="helpSuburb">{{ isset($appTicket["suburb"]) ? $appTicket["suburb"] : "" }}</span>
                </label>
                {{ Form::select('ticketit[suburb_id]', $suburbs, null, ['id' => 'suburb', 'class' => 'form-control', 'required', 'data-parsley-errors-container' => '#suburb_error', 'data-parsley-group' => 'wizard-step-2', 'data-parsley-error-message' => 'La colonia de la ubicación no puede quedar vacia', 'placeholder' => 'Seleccione la ubicación']) }}
                <div id="suburb_error"></div>
            </div>
            <!-- end Suburb -->
            <!-- Postal Code -->
            <div class="form-group">
                <div class="row">
                    <label for="cp" class="control-label col-md-12">
                        *&nbsp;Código postal:
                        <span class="help-block">Usar un código postal que corresponda a SJR</span>
                    </label>
                    <div class="col-md-8">
                        {{ Form::text('ticketit[cp]', 76800, ['id' => 'cp', 'class' => 'form-control', 'required', 'data-parsley-group' => 'wizard-step-2', 'data-parsley-type' => 'digits', 'data-parsley-max' => '76850', 'data-parsley-min' => '76800', 'data-parsley-error-message' => 'No corresponde a un Código Postal de SJR', 'placeholder' => '76807']) }}
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:;" class="btn btn-primary btn-block" id="btnSearchAddress"><i class="fa fa-map-marker"></i>&nbsp;Coordenadas</a>
                    </div>
                </div>
            </div>
            <!-- end Postal Code -->
            <div class="hidden">
                {{ Form::hidden('app_ticket[latitude]', isset($appTicket["latitude"]) ? $appTicket["latitude"] : 20.383618065369074, ['id' => 'latitude']) }}
                {{ Form::hidden('ticketit[latitude]', isset($appTicket["latitude"]) ? $appTicket["latitude"] : 20.383618065369074, ['id' => 'latitudeTicket']) }}
                {{ Form::hidden('app_ticket[longitude]', isset($appTicket["longitude"]) ? $appTicket["longitude"] : -99.99767491968242, ['id' => 'longitude']) }}
                {{ Form::hidden('ticketit[longitude]', isset($appTicket["longitude"]) ? $appTicket["longitude"] : -99.99767491968242, ['id' => 'longitudeTicket']) }}
                {{ Form::hidden('app_ticket[id]', isset($appTicket) ? $appTicket["id"] : null, ['id' => 'txtIdAppTicket']) }}
                {{ Form::text('app_ticket[address]',null, ['id' => 'searchAddress','class' => 'form-control',"readonly"=>"readonly"]) }}
            </div>
        </div>
        <!-- end col-6 -->
        <!-- begin col-6 -->
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-toolbar bg-inverse">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
                    </div>
                    <h4 class="panel-title">
                        Coincidencias del tiquet
                    </h4>
                </div>
                <div class="panel-body" id="bodySimilarTickets">
                    <div data-scrollbar="true" data-height="250px">
                        <div class="card card-inverse card-info text-center">
                            <div class="card-block">
                                <blockquote class="card-blockquote">
                                    <p>Lista de concidencias con un tiquet de acuerdo a la ubicación geográfica del problema. Se manejara un radio de 200 m</p>
                                    <footer>Es necesario llenar la dirección y obtener las coordenadas para obtener las <cite>Coincidencias con un Tiquet</cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->
        <div class="col-md-12">
            {{Form::hidden('ticketit[id]', null, ['id' => 'mergeTicket'])}}
            <div id="map" class="col-md-12 height-md width-full"></div>
        </div>
    </div>
    <!-- end row -->
</fieldset>