@extends('layouts.app')

@section('content')
    @include('p_m_o_work_table_finishes.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkTableFinishes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
