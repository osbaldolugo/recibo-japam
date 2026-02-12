@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Create New App Ticket</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'appTickets.store']) !!}

            @include('app_tickets.fields')

        {!! Form::close() !!}
    </div>
@endsection
