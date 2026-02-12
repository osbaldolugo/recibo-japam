@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit P M O Work Table</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOWorkTable, ['route' => ['pMOWorkTables.update', $pMOWorkTable->id], 'method' => 'patch']) !!}

            @include('p_m_o_work_tables.fields')

            {!! Form::close() !!}
        </div>
@endsection
