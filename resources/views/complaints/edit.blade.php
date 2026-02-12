@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Complaint</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($complain, ['route' => ['complaints', $complain->id], 'method' => 'patch']) !!}

            @include('complaints.fields')

            {!! Form::close() !!}
        </div>
@endsection
