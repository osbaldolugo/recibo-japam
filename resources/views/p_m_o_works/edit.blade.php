@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Editar Trabajo ({{ isset($pMOWork->description)?$pMOWork->description:null  }}})</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOWork, ['route' => ['pMOWorks.update', $pMOWork->id], 'method' => 'patch']) !!}

            @include('p_m_o_works.fields')

            {!! Form::close() !!}
        </div>
@endsection
