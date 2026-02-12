@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title">
                <i class="ion ion-map"></i>&nbsp;Mapeo de Tickets
            </h4>
        </div>

        <div class="panel-body" id="panel-body">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <div class="row">
                {{ Form::open(['route' => ('sector.map.getTickets'), 'id' => 'frmMap']) }}
                    <!-- Street Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('txtSector', 'Sector:') !!}
                        {!! Form::select('sector', isset($sector) ? $sector : null, null, ['id' => 'txtSector','class' => 'form-control select2', 'placeholder' => 'Filtrar por sector...']) !!}
                    </div>
                    <!-- Inside Number Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('txtSuburb', 'Colonia:') !!}
                        {!! Form::select('suburb', [], null, ['id' => 'txtSuburb', 'class' => 'form-control select2', 'placeholder' => 'Selecciona un sector']) !!}
                    </div>
                    <!-- Street Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('txtStatus', 'Estatus:') !!}
                        {!! Form::select('status_ticket', ["Sin Atender" => "Programada", "Orden Generada" => "Orden Generada", "Atendida" => "Finalizada"], "Sin Atender", ['id' => 'txtStatus', 'class' => 'form-control select2', 'placeholder' => 'Filtrar por estatus...']) !!}
                    </div>
                    <!-- Inside Number Field -->
                    {{--<div class="form-group col-sm-3">
                        {!! Form::label('txtPrioridad', 'Prioridad:') !!}
                        {!! Form::select('prioridad', isset($prioridad) ? $prioridad : null, null, ['id' => 'txtPrioridad', 'class' => 'form-control select2', 'placeholder' => 'Filtrar por prioridad...']) !!}
                    </div>--}}
                    <div class="form-group col-md-3">
                        <div class="p-5 widget-stats bg-primary text-white" style="border-radius: 5px;">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-white">
                                <i class="fa fa-ticket text-primary"></i>
                            </div>
                            <div class="stats-title text-white">No TICKETS</div>
                            <div class="stats-number" id="lblNoTickets"> 0</div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            <div id="map" class="height-md width-full"></div>
        </div>
    </div>
@endsection

@section('scripts')
    {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}

    {{ Html::script("js/utils.js") }}
    {!!Html::script('js/mapping/index.js')!!}
@endsection

