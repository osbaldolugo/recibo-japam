@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {!! Html::style('assets/plugins/parsley/src/parsley.css') !!}
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h2 class="panel-title">
                <i class="fa fa-map"></i>&nbsp;Sector
                <a class="btn btn-sm btn-primary pull-right" href="{!! route('sector.create') !!}" style="margin-top: -6px">
                    <i class="fa fa-plus-square"></i>&nbsp;Agregar Nuevo Sector
                </a>
            </h2>
        </div>
        <div class="panel-body">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {!! Html::script('assets/plugins/parsley/dist/parsley.js') !!}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}

    {{ Html::script("js/utils.js") }}
    {{ Html::script('js/sector/index.js') }}
@endsection