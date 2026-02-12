@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">{!! ($type == "queja") ? "Quejas" : "Citas"!!}</h4>
                </div>
                <div class="panel-body">
                    <div class="clearfix"></div>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    @include('complaints.table')
                </div>
            </div>
        </div>
    </div>
@endsection
