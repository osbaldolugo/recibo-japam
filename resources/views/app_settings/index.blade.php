@extends('layouts.app')

@section('css')
        @include('layouts.datatables_css')
        {!! Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') !!}
@endsection

@section('content')
        <h1 class="pull-left"></h1>

        <div class="clearfix"></div>
                @include('flash::message')
        <div class="clearfix"></div>

        {!! Form::open(['id' => 'formSettings', 'data-action'=>'']) !!}
        {!! Form::hidden('_method', null) !!}
        {!! Form::hidden('status', null) !!}
        <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-12 col-sm-12">
                        <div class="widget-chart with-sidebar bg-white loader-pay-control">
                                <div class="widget-chart-content">
                                        <div class="card-top">
                                                <img src="{{url('img/app_settings/pay_control.jpg')}}" style="width: 100%; border-radius: 5px;">
                                                <img src="{{url('img/app_settings/pay_control.png')}}" style="width: 100%; border-radius: 5px; position:absolute; z-index:10; left: 0; bottom: 0">

                                                <div class="overlay">
                                                        <h3 class="m-t-5 text-white">
                                                                <img class="m-t-1" src="{{url('img/icon_japam.png')}}">&nbsp;Control de Pagos
                                                        </h3>
                                                        <p class="p-l-10 p-r-10">
                                                                Dar clic en el botón <i class="ion-power"></i> para activar o desactivar los pagos. Esto desactivará los pagos en las plataformas:
                                                        <ul>
                                                                <li>Móvil</li>
                                                                <li>Web</li>
                                                        </ul>
                                                        </p>
                                                </div>
                                        </div>
                                </div>
                                <div class="widget-chart-sidebar bg-white">
                                        <div class="responsive-container">
                                                <div class="space-ratio"></div>
                                                <div class="col-lg-12 text-center img-container">
                                                        <div class="centerer"></div>
                                                        <img id="btn-power" class="img-color rounded-corner" style="">
                                                        <div class="col-lg-12 text-center f-s-15" id="container-status" style="display:block;">
                                                                {{-- status --}}
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        {!! Form::close() !!}
@endsection

@section('scripts')
        {!! Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') !!}
        {!! Html::script('assets/plugins/blockUI/blockui.min.js') !!}
        {!! Html::script('js/app_settings/index.js') !!}
        {!! Html::script("js/utils.js") !!}
@endsection
