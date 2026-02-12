@extends('layouts.app')

@section('content')
    @include('app_tickets.show_fields')

    <div class="form-group">
           <a href="{!! route('appTickets.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
