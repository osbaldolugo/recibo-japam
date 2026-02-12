@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit P M O Speciality</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOSpeciality, ['route' => ['pMOSpecialities.update', $pMOSpeciality->id], 'method' => 'patch']) !!}

            @include('p_m_o_specialities.fields')

            {!! Form::close() !!}
        </div>
@endsection
