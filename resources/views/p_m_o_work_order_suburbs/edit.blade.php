@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit P M O Work Order Suburbs</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pMOWorkOrderSuburbs, ['route' => ['pMOWorkOrderSuburbs.update', $pMOWorkOrderSuburbs->id], 'method' => 'patch']) !!}

            @include('p_m_o_work_order_suburbs.fields')

            {!! Form::close() !!}
        </div>
@endsection
