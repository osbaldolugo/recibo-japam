@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-comment">&nbsp;</i>Pagos Realizados
                        <div class="pull-right" style="margin-top: -7px;">
                            <div class="form-group" style="width: 250px!important;">
                                <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                                    {{ Form::text('dateRange', null, ['id' => 'dateRange', 'class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </h4>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-2  col-sm-3 text-center">
                            <span class="user-image">
                                <img src="{{url('img/android.png')}}" alt="Pagos Android" style="width: 42px; height: 42px;">
                            </span>
                            <h5 class="m-b-5" style="color: #716c6c"><b id="textTotalAndroid"></b></h5>
                        </div>

                        <div class="col-lg-2 col-sm-3 text-center">
                            <span class="user-image">
                                <img src="{{url('img/ios.png')}}" alt="Pagos Ios" style="width: 42px; height: 42px;">
                            </span>
                            <h5 class="m-b-5" style="color: #716c6c"><b id="textTotalIos"></b></h5>
                        </div>

                        <div class="col-lg-2 col-sm-3 text-center">
                            <span class="user-image">
                                <img src="{{url('img/web.png')}}" alt="Pagos Web" style="width: 42px; height: 42px;">
                            </span>
                            <h5 class="m-b-5" style="color: #716c6c"><b id="textTotalWeb"></b></h5>
                        </div>

                        <div class="col-lg-2 col-sm-3 text-center">
                            <span class="user-image">
                                <img src="{{url('img/receipt.png')}}" alt="Pagos Totales" style="height: 42px;">
                            </span>
                            <h5 class="m-b-5" style="color: #716c6c"><b id="textTotal"></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group pull-right">
                            {{ Form::label('txtFormaPago', 'Método de Pago') }}
                            {{ Form::select('forma_pago', ['TARJETA' => 'TARJETA', 'FARMACIA_BENAVIDES' => 'FARMACIAS BENAVIDES', 'CHEDRAUI' => 'CHEDRAUI', 'COPPEL' => 'COPPEL', 'ELEKTRA' => 'ELEKTRA', 'EXTRA' => 'EXTRA', 'OXXO' => 'OXXO', 'SEVEN_ELEVEN' => 'SEVEN ELEVEN', 'TELECOMM' => 'TELECOMM', '' => 'TODAS'], '', ['id' => 'txtFormaPago', 'class' => 'form-control select2']) }}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    {!! $dataTable->table(['width' => '100%']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/daterangepicker/daterangepicker.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/css/style.min.css') }}
@endsection


@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    {{ Html::script('assets/plugins/moment/moment.min.js') }}
    {{ Html::script('assets/plugins/moment/es.js') }}
    {{ Html::script('assets/plugins/daterangepicker/daterangepicker.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}

    {{ Html::script('js/pay_control/index.js') }}
@endsection
