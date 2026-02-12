@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Priority</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($priority, ['route' => ['priorities.update', $priority->id], 'method' => 'patch']) !!}

            @include('priorities.fields')

            {!! Form::close() !!}
        </div>
@endsection
