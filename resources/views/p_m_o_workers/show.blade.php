@extends('layouts.app')

@section('content')
    @include('p_m_o_workers.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkers.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
