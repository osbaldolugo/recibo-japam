@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/switchery/switchery.min.css') }}
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    {{ Html::script('assets/plugins/switchery/switchery.min.js') }}
    {{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}
    {{ Html::script('assets/plugins/blockui/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('js/utils.js') }}
    {{ Html::script('js/p_m_o_work_tables/index_asignador.js') }}

    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection