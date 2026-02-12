@extends('layouts.app')

@section('content')
    @include('suburbs.show_fields')

    <div class="form-group">
           <a href="{!! route('suburbs.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
