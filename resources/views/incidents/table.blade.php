@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection