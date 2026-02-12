@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Crear Trabajo (Ordenes de trabajo)</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOWorks.store']) !!}

            @include('p_m_o_works.fields')

        {!! Form::close() !!}
    </div>
@endsection
