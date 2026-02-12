<fieldset>
    <!-- begin row-->

    <div class="col-lg-12">
        <legend class="pull-left width-full">
            <samll class="help-block">Sector afectado</samll>
        </legend>

        <!-- Folio Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('ticket', 'Ticket:') !!}
            {!! Form::text('ticket', isset($ticket["id"])?$ticket["id"]:null, ['class' => 'form-control', "readonly"=>""]) !!}
        </div>

        <!-- Folio Field -->
        <div class="form-group col-sm-4">
            {!! Form::label('sector', 'Sector:') !!}
            {!! Form::select('sector',$sectors, isset($ticket["sector_id"])?$ticket["sector_id"]:null, ['class' => 'form-control select2']) !!}
        </div>
    </div>
    <div class="form-group col-sm-12">
        {!! Form::label('dotsSection', 'Mapa de la sección:') !!}
        <div id="map" class="col-md-12" style="height: 500px !important" class="height-md width-full"></div>

        <table id="tableDots">
            <tbody>
            </tbody>
        </table>

        <table id="tableDotsAux">
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- end row -->
</fieldset>