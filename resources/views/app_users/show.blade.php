@extends('layouts.app')

@section('content')
    @include('app_users.show_fields')

    <div class="form-group">
           <a href="{!! route('appUsers.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
