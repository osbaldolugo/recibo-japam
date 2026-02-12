@section('css')
    {{ Html::style('assets/plugins/bootstrap-wizard/css/bwizard.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css') }}
    {{ Html::style('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css') }}
    {{ Html::style('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}

    {{ Html::style('assets/plugins/icheck/skins/all.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
@endsection

<form action="{{ route('sector.update',isset($sector["id"]) ? $sector["id"] : null) }}" method="{{isset($sector["id"]) ? "PATCH" : "POST"}}" name="form-wizard" data-parsley-validate="true">

    <div id="wizard">
        <ol>
            <li>
                Información General
                <small>Información General del Sector y su sección en el mapa (opcional)</small>
            </li>
            <li>
                Colonias
                <small>Agregar colonias al Sector</small>
            </li>
        </ol>
        <!-- begin wizard step-1 -->
        <div class="wizard-step-1">
            @include('sector.steps.step1_general')
        </div>
        <!-- end wizard step-1 -->
        <!-- begin wizard step-2 -->
        <div class="wizard-step-2">
            @include('sector.steps.step2_suburbs')
        </div>
        <!-- end wizard step-2 -->

    </div>
</form>

@include('suburbs.modals.modal')


@section('footer')
    {{ Html::script('assets/plugins/bootstrap-wizard/js/bwizard.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}
    {{ Html::script('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js') }}
    {!!Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBe_A-Oj-0z8aSXQUOfVLdmroSHiMVuVME&libraries=places', array('defer' => 'defer'))!!}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}

    {!!Html::script('js/utils.js')!!}
    {{ Html::script('js/section/create.js') }}
@append