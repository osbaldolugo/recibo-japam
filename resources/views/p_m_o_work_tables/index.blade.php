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
                                        <h4 class="panel-title">Mesa de Control</h4>
                                </div>
                                <div class="clearfix"></div>
                                <div class="panel-body">
                                        @include('flash::message')

                                        <div class="clearfix"></div>

                                        @if($isAdmin)
                                                <div id="message"></div>
                                                <div class="col-md-4 form-group">
                                                        <label for="cbxAssigned">Tiquets asignados a mi &nbsp;</label>
                                                        <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxAssigned" value="1" name="assigned"/>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                        <label for="cbxCompleted">Tiquets que han sido completados &nbsp;</label>
                                                        <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxCompleted" value="1" name="completed">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                        <label for="cbxGenerated">Generados por mi &nbsp;</label>
                                                        <input type="checkbox" data-render="switchery" data-theme="blue" id="cbxGenerated" value="1" name="generated">
                                                </div>
                                        @endif

        @include('p_m_o_work_tables.table')
</div>
</div>
</div>
</div>
@endsection

