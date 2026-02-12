@extends('layouts.app')

@section('content')

    <div class="row col-lg-12">
        <form id="frmCreateNotification" data-parsley-validate="" autocomplete="off">
        {{--{!! Form::open(['id' => 'frmCreateNotification', 'data-parsley-validate' => 'true']) !!} --}}
            <div class="panel">
                <div class="panel-heading bg-color-2 text-white">
                    <div class="panel-heading-btn">
                    </div>
                    <h4 class="panel-title"><i class="fa fa-bell"></i> Nueva Notificación</h4>
                </div>
                <div class="panel-body">
                    <!--            <form action="#" id="frmCreateNotification" class="form-horizontal" novalidate="novalidate">-->

                    <input type="hidden" id="txtImg64">
                    <div class="clearfix"></div>
                    @include('notifications.fields_push')
                    <hr/>
                    @include('notifications.fields')
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <button id="btnSendNotification" class="btn btn-xs pull-right bg-white text-primary"  type="submit">
                            {{--<i class="fa fa-shopping-cart txt-color-3 fa-2x">&nbsp;</i>Agregar a la compra--}}
                            <span class="fa-stack fa-2x  text-primary">
                                <i class="fa fa-square-o fa-stack-2x"></i>
                                <i class="fa fa-paper-plane fa-stack-1x"></i>
                            </span>
                            <b>Enviar Notificación</b>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('css')
    {!! Html::style('assets/plugins/parsley/src/parsley.css') !!}
    {!! Html::style('css/push_notifications.css') !!}
    {!! Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') !!}
    {!! Html::style('assets/plugins/kartik-v-bootstrap-fileinput/css/fileinput.css') !!}
    {!!Html::style('assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css')!!}
@endsection
@section('scripts')
    {!!Html::script('assets/plugins/moment/moment.min.js')!!}
    {!!Html::script('assets/plugins/moment/es.js')!!}
    {!! Html::script('assets/plugins/blockUI/blockui.min.js') !!}
    {!!Html::script('assets/plugins/parsley/dist/parsley.js') !!}
    {!!Html::script('assets/plugins/parsley/i18n/es.min.js') !!}
    {!! Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') !!}
    {!!Html::script('assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
    {!!Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/fileinput.js') !!}
    {!!Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/locales/es.js') !!}
    {!! Html::script('js/notification/app.js') !!}
    {!! Html::script('js/notification/create.js') !!}
    {!! Html::script("js/utils.js") !!}
@endsection