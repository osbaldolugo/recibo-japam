@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Crear un nuevo tipo de Trabajo (Ordenes de Trabajo)</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOWorkTypes.store']) !!}

            @include('p_m_o_work_types.fields')

        {!! Form::close() !!}
    </div>
@endsection
