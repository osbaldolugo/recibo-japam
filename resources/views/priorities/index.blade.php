@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    {{ Html::style('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css') }}
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h2 class="panel-title">
                <i class="fa fa-level-up"></i>
                <i class="fa fa-level-down fa-flip-horizontal"></i>
                Catálogo de Prioridades
                <a class="btn btn-sm btn-primary pull-right" style="margin-top: -6px" id="createPriority" data-route="{{ route("priorities.store") }}">
                    <i class="fa fa-plus-square"></i>&nbsp;Agregar Nueva Prioridad
                </a>
            </h2>
        </div>

        <div class="clearfix"></div>
        <div class="panel-body">
            @include('flash::message')
            <div class="clearfix"></div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>
    </div>
    @include('priorities.modals.modal')
@endsection

@section("footer")
    {{--Beging scripts DataTables--}}
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    {{--End scripts DataTables--}}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}
    {{ Html::script('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js') }}

    {{ Html::script("js/utils.js") }}
    {{ Html::script("js/priorities/index.js") }}
@endsection
