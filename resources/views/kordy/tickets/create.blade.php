@extends("layouts.app")
@section('page', trans('lang.create-ticket-title'))
@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css') }}
    {{ Html::style('https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-wizard/css/bwizard.min.css') }}
    {{ Html::style('assets/plugins/switchery/switchery.min.css') }}
@endsection

@section('content')
{{--@include('kordy.shared.header')--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><i class="fa fa-ticket"></i>&nbsp;{!! trans('lang.create-new-ticket') !!}</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'tickets.store', 'method' => 'POST', 'name' => 'form-wizard', 'data-parsley-validate' => 'true', 'id' => 'createTicket']) !!}
                        <div id="wizard">
                            <div class="navbar">
                                <div class="navbar-inner">
                                    <div class="container nav-justified">
                                        <ul class="nav-justified m-b-0 bg-inverse">
                                            <li data-id="0">
                                                <a href="#tab1" data-toggle="tab">
                                                    <span class="badge badge-info">1</span>
                                                    <h3 class="m-t-2">
                                                        Problema
                                                    </h3>
                                                    <small>Descripción del problema (asignaciones)</small>
                                                </a>
                                            </li>
                                            <li data-id="1">
                                                <a href="#tab2" data-toggle="tab">
                                                    <span class="badge badge-info">2</span>
                                                    <h3 class="m-t-2">
                                                        Dirección
                                                    </h3>
                                                    <small>Ubicación donde se encuentra el problema o la falla</small>
                                                </a>
                                            </li>
                                            <li data-id="2">
                                                <a href="#tab3" data-toggle="tab">
                                                    <span class="badge badge-info">3</span>
                                                    <h3 class="m-t-2">
                                                        Recibo
                                                    </h3>
                                                    <small>Información del recibo</small>
                                                </a>
                                            </li>
                                            <li data-id="3">
                                                <a href="#tab4" data-toggle="tab">
                                                    <span class="badge badge-info">4</span>
                                                    <h3 class="m-t-2">
                                                        Identificación
                                                    </h3>
                                                    <small>Información para la identificación del usario</small>
                                                </a>
                                            </li>
                                            <li data-id="4">
                                                <a href="#tab5" data-toggle="tab">
                                                    <span class="badge badge-info">5</span>
                                                    <h3 class="m-t-2">
                                                        Completado
                                                    </h3>
                                                    <small>Verificar que la información sea la correcta y guardar el ticket</small>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane wizard-step-1" id="tab1">
                                    @include('tickets.steps.step1_trouble')
                                </div>
                                <div class="tab-pane wizard-step-2" id="tab2">
                                    @include('tickets.steps.step2_address')
                                </div>
                                <div class="tab-pane wizard-step-3" id="tab3">
                                    @include('tickets.steps.step4_assignments')
                                </div>
                                <div class="tab-pane wizard-step-4" id="tab4">
                                    @include('tickets.steps.step3_user')
                                </div>
                                <div class="tab-pane wizard-step-5" id="tab5">
                                    @include('tickets.steps.step5_complete')
                                </div>
                                <ul class="pager wizard">
                                    <li class="previous"><a href="#">Anterior</a></li>
                                    <li class="next"><a href="#">Siguiente</a></li>
                                </ul>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/bootstrap-wizard/js/jquery.bootstrap.wizard.min.js') }}
    {{ Html::script('assets/plugins/summernote/summernote.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/lang/summernote-es-ES.js') }}
    {{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('assets/plugins/moment/moment.min.js') }}
    {{ Html::script('assets/plugins/moment/es.js') }}
    {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
    {{ Html::script('assets/plugins/switchery/switchery.min.js') }}
    {{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}
    {{ Html::script('js/utils.js') }}
    {{ Html::script('js/Kordy/ticket/create.js') }}
@append