@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title">
                <i class="fa fa-mobile-phone"></i>&nbsp;Reportes y Denuncias
            </h4>
        </div>
        <div class="panel-body">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-4 form-group pull-right">
                    {!! Form::label('txtType', 'Reporte o Denuncia', ['class' => 'sbold']) !!}
                    {{Form::select('type', ['Reporte' => 'Reporte', 'Denuncia' => 'Denuncia', 'all' => 'Todos los tipos'], 'all', ['class' => 'select2', 'id' => 'txtType'])}}
                </div>
            </div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </div>
    @include('tickets.modals.details-image')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}
    {{ Html::script('js/app_tickets/index.js') }}
    {!! $dataTable->scripts() !!}
@endsection

