<style>
    #map {
        height: 270px;
        width: 100%;
    }
</style>

{!! Form::open(['id' => 'formBranchOffice', 'name' => 'formWizard', 'data-parsley-validate' => 'true','data-action'=>'']) !!}
{!! Form::hidden('_method', null) !!}
<div id="wizard">
    <ol>
        <li>
            Información General
        </li>
        <li>
            Horarios
        </li>
        <li>
            Ubicación
        </li>
        <li>
            Completado
        </li>
    </ol>

    <div class="wizard-step-1">
        @include('branch_offices.steps.step1')
    </div>

    <div class="wizard-step-2">
        @include('branch_offices.steps.step2')
    </div>

    <div class="wizard-step-3">
        @include('branch_offices.steps.step3')
    </div>

    <div>
        @include('branch_offices.steps.step4')
    </div>
</div>
{!! Form::close() !!}