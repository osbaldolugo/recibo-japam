@extends('layouts.app')

@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-wizard/css/bwizard.min.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/plugins/switchery/switchery.min.css') }}
@endsection

@section('content')
    <form action="{{ route('tickets.store') }}" method="POST" name="form-wizard" data-parsley-validate="true">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Generar Orden de Trabajo</h1>
        </div>
        @include('core-templates::common.errors')

        {{--{!! Form::model($ticket, ['route' => ['pMOWorkTables.update', $ticket->id], 'method' => 'patch']) !!}--}}

        <div class="col-lg-6">
            @include('kordy.tickets.partials.ticket_body')
        </div>
        <div class="col-lg-6">
            @include('kordy.tickets.partials.ticket_body_details')
        </div>
        {{--{!! Form::close() !!}--}}
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-toolbar bg-inverse">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
                    </div>
                    <h4 class="panel-title">
                        Generar Orden de Trabajo
                    </h4>
                </div>
                <div class="panel-body">
                <div class="row">

                    <div id="wizard">
                        <ol>
                            <li>
                                Orden de Trabajo
                                <small>Información extra para generar la orden de trabajo</small>
                            </li>
                            <li>
                                Generación de Orden de Trabajo
                                <small>PDF</small>
                            </li>

                        </ol>

                        <!-- begin wizard step-1 -->
                        <div class="wizard-step-1">
                            @include('p_m_o_work_tables.steps.step1_workorder')
                        </div>
                        <!-- end wizard step-1 -->
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                            @include('p_m_o_work_tables.steps.step3_pdf')
                        </div>
                        <!-- end wizard step-2 -->

                        <!-- begin wizard step-4
                        <div class="wizard-step-3">
                            <a class="media" id="pdf" href="{{storage_path("app/ejemplo.pdf")}}">PDF File</a>
                            <a class="media {type: 'html'}" href="../">HTML File</a>
                        </div>
                        <!-- end wizard step-4 -->
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>

    </form>




@endsection

@section('footer')


    {{ Html::script('assets/plugins/bootstrap-wizard/js/bwizard.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{--{{ Html::script('assets/js/form-wizards-validation.demo.min.js') }}--}}
    {{ Html::script('assets/plugins/summernote/summernote.min.js') }}
    {{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/lang/summernote-es-ES.min.js') }}--}}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/lang/summernote-es-ES.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/switchery/switchery.min.js') }}
    {{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}

    {{ Html::script("http://github.com/malsup/media/raw/master/jquery.media.js")}}
    {{ Html::script("assets/plugins/jquery-metadata/jquery-metadata.js")}}

    {{ Html::script('js/utils.js') }}
    {{ Html::script('js/p_m_o_work_tables/appOrder.js') }}
@endsection
