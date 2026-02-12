@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Editar el Tipo de Trabajo {{isset($pMOWorkType->type)?$pMOWorkType->type:null}}</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOWorkType, ['route' => ['pMOWorkTypes.update', $pMOWorkType->id], 'method' => 'patch']) !!}

            @include('p_m_o_work_types.fields')

            {!! Form::close() !!}
        </div>
@endsection
