@extends('layouts.app')

@section('content')
        <h1 class="pull-left">P M O Work Order Sector Dots</h1>
        <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('pMOWorkOrderSectorDots.create') !!}">Add New</a>

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        @include('p_m_o_work_order_sector_dots.table')
        
@endsection
