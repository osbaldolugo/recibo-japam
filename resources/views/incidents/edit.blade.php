@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Incidents</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($incidents, ['route' => ['incidents.update', $incidents->id], 'method' => 'patch']) !!}

            @include('incidents.fields')

            {!! Form::close() !!}
        </div>
@endsection
