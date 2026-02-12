@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 ui-sortable">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <!-- begin breadcrumb -->
                <ol class="breadcrumb pull-right">
                    <li><a href="javascript:;">Home</a></li>
                    <li><a class="active">Dashboard</a></li>
                </ol>
                <!-- end breadcrumb -->
                <!-- begin page-header -->
                <h1 class="page-header">Dashboard <small> Estadisticas de JAPAM MOVIL</small></h1>
                <!-- end page-header -->
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-white text-inverse">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-blue"><i class="ion-ios-people"></i></div>
                            <div class="stats-title">Usuarios registrados en APP</div>
                            <div class="stats-number">{{ $userNum["userNum"] }}</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 70.1%;"></div>
                            </div>
                            <!--<div class="stats-desc">Porcentaje</div>-->
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-white text-inverse">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-blue"><i class="ion-ios-paper-outline"></i></div>
                            <div class="stats-title">APP Tickets</div>
                            <div class="stats-number">{{ $appTickets["tickets"] }}</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 70.1%;"></div>
                            </div>
                            <!--<div class="stats-desc">Porcentaje</div>-->
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-white text-inverse">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-blue"><i class="ion-ios-checkmark-outline"></i></div>
                            <div class="stats-title">APP TICKETs Atendidos</div>
                            <div class="stats-number">{{$attendedTickets["attendedTickets"]}}</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 80.5%;"></div>
                            </div>
                            <div class="stats-desc">Porcentaje</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget-stats bg-white text-inverse">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-blue"><i class="ion-ios-briefcase-outline"></i></div>
                            <div class="stats-title">Ordenes de Trabajo</div>
                            <div class="stats-number">{{ $orderWorks["orderWorks"] }}</div>
                            <div class="stats-progress progress">
                                <div class="progress-bar" style="width: 56.3%;"></div>
                            </div>
                            <div class="stats-desc">Porcentaje</div>
                        </div>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->

                <!-- begin row -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="widget-chart with-sidebar bg-black">
                            <div class="widget-chart-content">
                                <h4 class="chart-title">
                                    Analisis de Usuarios Registrados
                                    <small>Usuarios que se han unido al reto japam</small>
                                </h4>
                                <div id="visitors-line-chart" class="morris-inverse" style="height: 260px;"></div>
                            </div>
                            <div class="widget-chart-sidebar bg-black-darker">
                                <div class="chart-number">
                                    <small>Usuarios Registrados</small>
                                    {{ $userNum["userNum"] }}
                                    <small>Usuarios que han reportado</small>
                                    {{$userActiveNum["userActiveNum"]}}
                                </div>
                                <div id="visitors-donut-chart" style="height: 160px"></div>
                                <ul class="chart-legend">
                                    <li><i class="fa fa-circle-o fa-fw text-info m-r-5"></i> {{ $userActiveNum["percent"] }}% <span>Usuarios Registros</span></li>
                                    <li><i class="fa fa-circle-o fa-fw text-primary m-r-5"></i> {{ $userNum["percent"] }}% <span>Usuarios que han reportado</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-inverse" data-sortable-id="index-1">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    Origen de Tickets Abiertos
                                </h4>
                            </div>
                            <!--<div id="visitors-map" class="bg-black" style="height: 181px;"></div>-->
                            <div class="list-group">
                                @IF(isset($suburbTickets))
                                    @foreach($suburbTickets as $suburbTicket)
                                        <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                            <span class="badge badge-inverse">1</span>

                                        </a>
                                    @endforeach

                                @ENDIF
                                <!--</a><a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                    <span class="badge badge-inverse">1</span>
                                    5.
                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
    {{ Html::script('assets/plugins/morris/raphael.min.js') }}
    {{ Html::script('assets/plugins/morris/morris.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/home.js')}}
@endsection