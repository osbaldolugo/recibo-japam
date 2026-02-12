@section('css')
    @include('layouts.datatables_css')
    {{Html::style('assets/plugins/parsley/src/parsley.css')}}
    {{Html::style('assets/plugins/bootstrap-toastr/toastr.min.css')}}
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js')}}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/receipts/index.js')}}
    
@endsection