@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit People Unlogged</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($peopleUnlogged, ['route' => ['peopleUnloggeds.update', $peopleUnlogged->id], 'method' => 'patch']) !!}

            @include('people_unloggeds.fields')

            {!! Form::close() !!}
        </div>
@endsection
