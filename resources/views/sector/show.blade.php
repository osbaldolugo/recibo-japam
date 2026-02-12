@extends('layouts.app')

@section('content')
    @include('sector.show_fields')

    <div class="form-group">
           <a href="{!! route('sector.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
