@extends('layouts.app')

@section('content')
        @include('branch_offices.modal_branch_office')
        <div class="row">
                <div class="col-md-12 ui-sortable">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <div class="panel-heading-btn">
                                                <a class="btn btn-primary btn-xs pull-right bg-color-2 text-white" id="btnAddBranchOffice"><i class="glyphicon glyphicon-plus">&nbsp;</i>Agregar nueva</a>
                                        </div>
                                        <h4 class="panel-title"><i class="fa fa-institution">&nbsp;</i>Sucursales</h4>
                                </div>

                                <div class="panel-body loading-content-index-branch-office">
                                        <div class="clearfix"></div>
                                        @include('flash::message')
                                        <div class="clearfix"></div>

                                        @include('branch_offices.table')
                                </div>
                        </div>
                </div>
        </div>
@endsection
