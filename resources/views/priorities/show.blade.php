@extends('layouts.app')

@section('content')
    @include('priorities.show_fields')

    <div class="form-group">
           <a href="{!! route('priorities.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
