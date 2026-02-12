@extends('layouts.app-user')

@section('content')

        @include('user_panel.receipts.modals.new_receipt')
        @include('user_panel.receipts.modals.edit_alias')
 
   <div class="row">
        <div class="col-md-12 ui-sortable">
                <div class="panel panel-inverse">
                        <div class="panel-heading">
                                <div class="panel-heading-btn">
                                        <button class="btn  btn-success btn-xs pull-right" data-toggle="modal" data-target="#modalNewReceipt">
                                                <i class="glyphicon glyphicon-plus"> </i>Agregar recibo
                                        </button>
                                </div>
                                <h1 class="panel-title"><i class="fa fa-file-text-o">&nbsp;</i> Mis Recibos</h1>
                        </div>
                        <div class="panel-body">
                                <div class="clearfix"></div>
                                @include('flash::message')
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                        @include('user_panel.receipts.table')
                                </div>
                        </div>
                </div>
        </div>
    </div>
@endsection
