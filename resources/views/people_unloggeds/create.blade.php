@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New People Unlogged</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'peopleUnloggeds.store']) !!}

            @include('people_unloggeds.fields')

        {!! Form::close() !!}
    </div>
@endsection
