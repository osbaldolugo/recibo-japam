@extends('layouts.app')

@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>

                    <h4 class="panel-title">
                        <i class="fa fa-phone"></i>
                        &nbsp;Motivos de llamada
                        <a class="btn btn-sm btn-primary pull-right" style="margin-top: -6px" id="createIncident" data-route="{{ route("incidents.store") }}"><i class="fa fa-plus"></i> Crear Nuevo Motivo</a>
                    </h4>
                </div>

                <div class="panel-body">
                    <div class="clearfix"></div>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    {!! $dataTable->table(['width' => '100%']) !!}
                </div>
            </div>
        </div>
    </div>

    @include('incidents.modals.modal')

@endsection

@section("footer")
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('assets/plugins/icheck/icheck.min.js') }}
    {!! Html::script("js/utils.js") !!}
    {!! Html::script("js/incidents/index.js") !!}
@endsection
