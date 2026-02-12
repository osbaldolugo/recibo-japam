@extends('layouts.app')

@section('content')
    @include('p_m_o_work_tables.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkTables.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
