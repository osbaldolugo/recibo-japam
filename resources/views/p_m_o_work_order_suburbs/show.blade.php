@extends('layouts.app')

@section('content')
    @include('p_m_o_work_order_suburbs.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkOrderSuburbs.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
