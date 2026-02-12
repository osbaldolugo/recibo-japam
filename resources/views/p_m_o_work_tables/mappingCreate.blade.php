@extends('layouts.app')

@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-wizard/css/bwizard.min.css') }}
@endsection

@section('content')
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
        <div class="panel panel-inverse">
            <div class="panel-toolbar bg-inverse">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
                </div>
                <h4 class="panel-title">
                    Mapeo del Ticket
                </h4>
            </div>
            <div class="panel-body">
                 <form action="{{ route('tickets.store') }}" method="POST" name="form-wizard" data-parsley-validate="true">
                    <div id="wizard">
                        <ol>
                            <li>
                                Mapeo
                                <small>Mapeo de mesa de control</small>
                            </li>
                            <li>
                                Colonias Afectadas
                                <small>Seleccionar colonias afectadas</small>
                            </li>
                        </ol>

                        <!-- begin wizard step-1 -->
                        <div class="wizard-step-1">
                            @include('p_m_o_work_tables.steps_mapping.step1_mapping')
                        </div>
                        <!-- end wizard step-1 -->
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                            @include('p_m_o_work_tables.steps_mapping.step2_affectedSuburbs')

                            <div class="row">
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12">
                                    <a class="btn btn-primary pull-right" id="saveMapping" data-route="{{ route("sector.store") }}"><i class="glyphicon glyphicon-save">&nbsp;</i>Guardar</a>
                                    <a href="{!! route('appTickets.index') !!}" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>
                        <!-- end wizard step-2 -->
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}
    {{ Html::script('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js') }}


    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
    {{ Html::script('assets/plugins/bootstrap-wizard/js/bwizard.js') }}

    {!!Html::script('js/utils.js')!!}
    {{ Html::script('js/p_m_o_work_tables/app.js') }}

@endsection

@section("script")


@endsection
