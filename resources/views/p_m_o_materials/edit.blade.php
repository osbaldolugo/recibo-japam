@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Editar Material {{isset($pMOMaterial->material)?$pMOMaterial->material:null}}</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOMaterial, ['route' => ['pMOMaterials.update', $pMOMaterial->id], 'method' => 'patch']) !!}

            @include('p_m_o_materials.fields')

            {!! Form::close() !!}
        </div>
@endsection
