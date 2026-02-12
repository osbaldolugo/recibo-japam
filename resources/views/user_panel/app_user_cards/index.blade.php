@extends('layouts.app-user')

@section('content')

        @include('user_panel.app_user_cards.modal_card')
 
   <div class="row">
        <div class="col-md-12 ui-sortable">
                <div class="panel panel-inverse">
                        <div class="panel-heading">
                                <div class="panel-heading-btn">
                                        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modalNewCard">
                                                <i class="fa fa-plus-circle"> </i>Agregar tarjeta
                                        </button>
                                </div>
                                <h1 class="panel-title"><i class="fa fa-credit-card">&nbsp;</i> Mis Tarjetas</h1>
                        </div>
                        <div class="panel-body">
                                <div class="clearfix"></div>
                                @include('flash::message')
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                        @include('user_panel.app_user_cards.table')
                                </div>
                        </div>
                </div>
        </div>
    </div>
@endsection
