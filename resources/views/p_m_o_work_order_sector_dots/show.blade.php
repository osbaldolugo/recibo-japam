@extends('layouts.app')

@section('content')
    @include('p_m_o_work_order_sector_dots.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOWorkOrderSectorDots.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
