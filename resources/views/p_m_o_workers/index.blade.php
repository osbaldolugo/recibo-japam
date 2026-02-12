@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    {{ Html::style('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h2 class="panel-title">
                <i class="ion-android-walk"></i>
                Catálogo de Trabajadores
                <a class="btn btn-sm btn-primary pull-right" style="margin-top: -6px" id="createWorker" data-route="{{ route('pMOWorkers.store') }}">
                    <i class="fa fa-plus-square"></i>&nbsp;Agregar Nuevo Trabajador
                </a>
            </h2>
        </div>
        <div class="panel-body">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <div class="row">
                <div class="form-group col-md-4 pull-right">
                    {!! Form::label('id_speciality', 'Especialidad:') !!}
                    {!! Form::select('speciality', $specialities, null, ['class' => 'select2 form-control', 'id' => 'id_speciality', 'placeholder' => 'Selecciona la especialidad']) !!}
                </div>
            </div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </div>
    @include('p_m_o_workers.modals.modal')
@endsection

@section("footer")
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}

    {{ Html::script("js/utils.js")}}
    {!! Html::script("js/p_m_o_workers/index.js") !!}
@endsection
