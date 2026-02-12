@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Crear Nuevo Equipo</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOEquipments.store']) !!}

            @include('p_m_o_equipments.fields')

        {!! Form::close() !!}
    </div>
@endsection
