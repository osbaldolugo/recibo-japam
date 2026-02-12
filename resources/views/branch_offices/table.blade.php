@section('css')
    @include('layouts.datatables_css')
    {!! Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') !!}
    {!! Html::style('assets/plugins/kartik-v-bootstrap-fileinput/css/fileinput.css') !!}
    {!! Html::style('assets/plugins/select2/dist/css/select2.min.css') !!}
    {!! Html::style('assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css' )!!}
    {!! Html::style('assets/plugins/parsley/src/parsley.css') !!}
    {!! Html::style('assets/plugins/bootstrap-wizard/css/bwizard.min.css') !!}
@endsection

    {!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') !!}
    {!! Html::script('assets/plugins/blockui/blockui.min.js') !!}
    {!! Html::script('assets/plugins/moment/moment.min.js') !!}
    {!! Html::script('assets/plugins/moment/es.js' )!!}
    {!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxO1q4TalrKuP12BSnNjcyXDXgpZEb8w&libraries=places', array('defer' => 'defer')) !!}
    {!! Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/fileinput.js') !!}
    {!! Html::script('assets/plugins/kartik-v-bootstrap-fileinput/js/locales/es.js') !!}
    {!! Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') !!}
    {!! Html::script('assets/plugins/select2/dist/js/select2.min.js') !!}
    {!! Html::script('assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
    {!! Html::script('assets/plugins/select2/dist/js/i18n/es.js') !!}
    {!! Html::script('assets/plugins/parsley/dist/parsley.js') !!}
    {!! Html::script('assets/plugins/bootstrap-wizard/js/bwizard.js') !!}
    {!! Html::script("js/branch_office/index.js") !!}
    {!! Html::script("js/branch_office/app.js") !!}
    {!! Html::script("js/utils.js") !!}
    {!! $dataTable->scripts() !!}
@endsection