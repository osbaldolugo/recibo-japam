@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Crear Trabajador (Ordenes de Trabajo)</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOWorkers.store']) !!}

            @include('p_m_o_workers.fields')

        {!! Form::close() !!}
    </div>
@endsection
