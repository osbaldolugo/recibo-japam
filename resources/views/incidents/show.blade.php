@extends('layouts.app')

@section('content')
    @include('incidents.show_fields')

    <div class="form-group">
           <a href="{!! route('incidents.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
