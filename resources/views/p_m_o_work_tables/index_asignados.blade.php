@extends('layouts.app')

@section('content')
        <h1 class="pull-left">Ordenes de trabajo</h1>
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        @include('p_m_o_work_tables.table_asignados')
        
@endsection
