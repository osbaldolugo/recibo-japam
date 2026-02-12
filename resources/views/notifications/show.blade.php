@extends('layouts.app')

@section('content')
    @include('notifications.show_fields')

    <div class="form-group">
           <a href="{!! route('notifications.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
