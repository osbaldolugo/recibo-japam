@section('css')
    @include('layouts.datatables_css')
    {!! Html::style('assets/plugins/parsley/src/parsley.css') !!}
    {!! Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') !!}
    {!! Html::style('assets/plugins/owl-carousel/owl.carousel.min.css') !!}
    {!! Html::style('assets/plugins/kartik-v-bootstrap-fileinput/css/fileinput.css') !!}
    {!! Html::style('assets/plugins/switchery/switchery.min.css') !!}
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! Html::script('assets/plugins/parsley/dist/parsley.js') !!}
    {!! Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/fileinput.js') !!}
    {!! Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/locales/es.js') !!}
    {!! Html::script('assets/plugins/blockUI/blockui.min.js') !!}
    {!! Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') !!}
    {!! Html::script('assets/plugins/owl-carousel/owl.carousel.min.js') !!}
    {!! Html::script('assets/plugins/switchery/switchery.min.js') !!}
    {!! Html::script('js/app_slider_home/index.js') !!}
    {!! Html::script("js/utils.js") !!}
    {!! $dataTable->scripts() !!}
@endsection