@extends('layouts.app')
@section('content')
<div class="row">
        <div class="col-md-12 ui-sortable">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <div class="panel-heading-btn">
                                        <a class="btn btn-primary btn-xs pull-right" href="{!! route('notifications.create') !!}"><i class="fa fa-paper-plane">&nbsp;</i>Enviar Nueva Notificación</a>
                                </div>
                                <h4 class="panel-title"><i class="fa fa-comment">&nbsp;</i>Notificaciones</h4>
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
        @include('notifications.modal_notification')
@endsection

@section('css')
        @include('layouts.datatables_css')
        {!! Html::style('css/push_notifications.css') !!}
        {!! Html::style('assets/plugins/parsley/src/parsley.css') !!}
        {!! Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') !!}
@endsection
@section('scripts')
        @include('layouts.datatables_js')
        {!! $dataTable->scripts() !!}

        {!!Html::script('assets/plugins/parsley/dist/parsley.js') !!}
        {!!Html::script('assets/plugins/parsley/i18n/es.min.js') !!}

        {!! Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') !!}
        {!! Html::script('assets/plugins/blockUI/blockui.min.js') !!}
        {!! Html::script('js/notification/app.js') !!}
        {!! Html::script('js/notification/index.js') !!}
        {!! Html::script("js/utils.js") !!}
@endsection