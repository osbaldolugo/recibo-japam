@extends('layouts.app')

@section('css')
	@include('layouts.datatables_css')
    {{ Html::style('assets/plugins/daterangepicker/daterangepicker.css') }}
	{{ Html::style('assets/plugins/switchery/switchery.min.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
@endsection

@section('page')
    {{ trans('lang.index-title') }}
@stop

@section('content')
    @include('kordy.shared.header')
    @include('kordy.tickets.index')
@stop

@section('footer')
	@include('layouts.datatables_js')
	{!! $dataTable->scripts() !!}
@append

@section('scripts')
	{{ Html::script('assets/plugins/switchery/switchery.min.js') }}
	{{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}
    {{ Html::script('assets/plugins/moment/moment.min.js') }}
    {{ Html::script('assets/plugins/moment/es.js') }}
    {{ Html::script('assets/plugins/daterangepicker/daterangepicker.js') }}

	{{ Html::script('js/Kordy/ticket/index.js') }}
@endsection
