@extends('layouts.app')

@section('content')
    @include('p_m_o_work_types.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkTypes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
