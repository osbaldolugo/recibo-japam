@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-12 ui-sortable">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="panel-title"><i class="fa fa-users">&nbsp;</i>Usuarios Japam Móvil</h4>
                        </div>

                        <div class="panel-body">
                                <div class="clearfix"></div>
                                @include('flash::message')
                                <div class="clearfix"></div>

                                @include('app_users.table')
                        </div>
                </div>
        </div>
</div>
@endsection
