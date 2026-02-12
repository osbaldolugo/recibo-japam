@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New P M O Work Table Finish</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOWorkTableFinishes.store']) !!}

            @include('p_m_o_work_table_finishes.fields')

        {!! Form::close() !!}
    </div>
@endsection
