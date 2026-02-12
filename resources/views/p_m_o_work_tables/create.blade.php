@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New P M O Work Table</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'pMOWorkTables.store']) !!}

            @include('p_m_o_work_tables.fields')

        {!! Form::close() !!}
    </div>
@endsection
