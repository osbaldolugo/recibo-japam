@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Editar Trabajador {{isset($pMOWorker->name)?$pMOWorker->name:null}}</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOWorker, ['route' => ['pMOWorkers.update', $pMOWorker->id], 'method' => 'patch']) !!}

            @include('p_m_o_workers.fields')

            {!! Form::close() !!}
        </div>
@endsection
