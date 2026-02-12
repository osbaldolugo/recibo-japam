@extends('layouts.app')

@section('content')
    @include('people_unloggeds.show_fields')

    <div class="form-group">
           <a href="{!! route('peopleUnloggeds.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
