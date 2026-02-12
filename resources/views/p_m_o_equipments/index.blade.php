@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
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
                <i class="ion-person-stalker"></i>&nbsp;Catálogo de Equipos
                <a class="btn btn-sm btn-primary pull-right" style="margin-top: -6px" id="createEquipment" data-route="{{ route("pMOEquipments.store") }}">
                    <i class="fa fa-plus-square"></i>&nbsp;Agregar Nuevo Equipo
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
    @include('p_m_o_equipments.modals.modal')
@endsection

@section("footer")
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script("js/utils.js") }}
    {{ Html::script("js/p_m_o_equipments/index.js") }}
@endsection
