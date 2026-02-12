@extends('layouts.app')

@section('content')
<div class="row">

        <div class="col-md-12 ui-sortable">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-map">&nbsp;</i>Mapeo de Reportes en APP</h4>
                        </div>

                        <div class="panel-body">
                                <div class="clearfix"></div>
                                @include('flash::message')
                                <div class="clearfix"></div>

                                <div class="col-md-12">
                                        <div class="row">
                                                <!-- Street Field -->
                                                <div class="form-group col-sm-3">
                                                        {!! Form::label('sector', 'Sector:') !!}
                                                        {!! Form::select('sector', $sector, ['class' => 'form-control']) !!}
                                                </div>
                                                <!-- Inside Number Field -->
                                                <div class="form-group col-sm-3">
                                                        {!! Form::label('colonia', 'Colonia:') !!}
                                                        {!! Form::select('colonia', [], ['class' => 'form-control']) !!}
                                                </div>
                                                <!-- Street Field -->
                                                <div class="form-group col-sm-3">
                                                        {!! Form::label('status_ticket', 'Status:') !!}
                                                        {!! Form::select('status_ticket', ["Programada","En espera de obras públicas","Finalizada"], ['class' => 'form-control']) !!}
                                                </div>
                                                <!-- Inside Number Field -->
                                                <div class="form-group col-sm-3">
                                                        {!! Form::label('prioridad', 'Prioridad:') !!}
                                                        {!! Form::select('prioridad', ["Prioridad 1","Prioridad 2", "Prioridad 3", "Prioridad 4"], ['class' => 'form-control']) !!}
                                                </div>
                                        </div>
                                        <div class="row">
                                                <!-- Inside Number Field -->
                                                <div class="form-group col-sm-12">

                                                </div>
                                        </div>

                                </div>
                                <div id="map" class="col-md-12" style="height: 550px !important" class="height-md width-full"></div>
                        </div>
                </div>
        </div>
</div>
@endsection

@section('scripts')
        {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
        {!!Html::script('js/mapping/index_app.js')!!}
@endsection

