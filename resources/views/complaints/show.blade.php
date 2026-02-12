@extends('layouts.app')

@section('content')
    @include('complaints.show_fields')

    <div class="form-group">
           <a href="{!! route('complaints.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
