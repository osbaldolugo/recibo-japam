@extends('layouts.app')

@section('content')
        <h1 class="pull-left">P M O Work Table Finishes</h1>
        <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('pMOWorkTableFinishes.create') !!}">Add New</a>

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        @include('p_m_o_work_table_finishes.table')
        
@endsection
