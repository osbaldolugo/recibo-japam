@section('css')
    @include('layouts.datatables_css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/select2/dist/css/select2.min.css') }}
@endsection

<fieldset>
    <!-- begin panel -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h2 class="panel-title">
                <i class="fa fa-map"></i>&nbsp;COLONIAS
                <a class="btn btn-sm btn-primary pull-right" id="createSuburb" style="margin-top: -6px" data-route="{{ route("suburbs.store") }}">
                    <i class="fa fa-plus-square"></i>&nbsp;Crear Nueva Colonia
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
    <!-- end panel -->
</fieldset>

@section("footer")
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/plugins/select2/dist/js/i18n/es.js') }}
    {!! Html::script("js/utils.js") !!}
    {!! Html::script("js/suburbs/index.js") !!}
@endsection