<div class="panel panel-inverse">
    <div class="panel-toolbar">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">
            <i class="fa fa-map-pin"></i>&nbsp;Ubicación del problema
        </h4>
    </div>
    <div class="panel-body">
        <div id="map" class="col-md-12" style="height: 350px !important"></div>
        {{ Form::hidden('longitude', $ticket->longitude, ['id' => 'longitude']) }}
        {{ Form::hidden('latitude', $ticket->latitude, ['id' => 'latitude']) }}
        {{ Form::hidden('address', !empty($ticket->inside_number) ? $ticket->street . ' ' . $ticket->outside_number . ' Int. ' . $ticket->inside_number . ', Col. ' . $ticket->suburb->suburb . ', C.P. ' . $ticket->cp : $ticket->street . ' ' . $ticket->outside_number . ', Col. ' . $ticket->suburb->suburb . ', C.P. ' . $ticket->cp, ['id' => 'txtAddress']) }}
    </div>
</div>

@section('footer')
    {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
@endsection