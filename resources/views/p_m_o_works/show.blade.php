@extends('layouts.app')

@section('content')
    @include('p_m_o_works.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorks.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
