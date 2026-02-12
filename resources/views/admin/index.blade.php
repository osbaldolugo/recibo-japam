@extends('layouts.app')

@section('page', 'Lista de usuarios')

@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/switchery/switchery.min.css') }}
@endsection

@section('content')
    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h2 class="panel-title">
                <i class="fa fa-users"></i>
                Lista de Usuarios
                <a class="btn btn-sm btn-primary pull-right" id="createUser" href="#modal-user" data-route="{{ route('admin.users.store') }}" data-toggle="modal" style="margin-top: -6px">
                    <i class="fa fa-plus-square"></i>&nbsp;Crear usuario
                </a>
            </h2>
        </div>

        <div class="panel-body" id="tabble-loading">
            <div id="message"></div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="cbxDeleted">Usuarios eliminados &nbsp;</label>
                    <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxDeleted" value="1" name="deleted"/>
                </div>
            </div>
            {!! $dataTable->table(['width' => '100%']) !!}
        </div>

    </div>
    @include('admin.create')
@endsection

@section('scripts')
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('assets/plugins/icheck/icheck.min.js') }}
    {{ Html::script('assets/plugins/switchery/switchery.min.js') }}
    {{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}
    {{ Html::script('js/admin/userList.js') }}
    {{ Html::script('js/utils.js') }}
@endsection
