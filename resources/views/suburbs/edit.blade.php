@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Suburb</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($suburb, ['route' => ['suburbs.update', $suburb->id], 'method' => 'patch']) !!}

            @include('suburbs.fields')

            {!! Form::close() !!}
        </div>
@endsection
