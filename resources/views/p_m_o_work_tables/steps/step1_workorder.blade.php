<fieldset>
    <!-- end row -->

    <!-- begin row-->
    <div class="col-lg-12">
        <!-- begin row -->
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-12">
                <!--<ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#newOrden" data-toggle="tab">
                            <span class="visible-xs">Crear nueva orden</span>
                            <span class="hidden-xs">Crear nueva orden</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#selectOrden" data-toggle="tab">
                            <span class="visible-xs">Elegir orden creada</span>
                            <span class="hidden-xs">Elegir orden creada</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="newOrden">-->
                        <div class="form-horizontal">
                            <div class="col-lg-12">
                                <legend class="pull-left width-full">Datos de Orden</legend>
                                @include('p_m_o_work_tables.fields')
                            </div>
                        </div>
                    <!--</div>
                    <div class="tab-pane fade" id="selectOrden">
                        <div class="form-horizontal">
                            <div class="col-lg-4">
                                <legend class="pull-left width-full">Selecciona Orden Creada</legend>
                                <table id="tableWorkOrden" class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="hidden">ID</th>
                                        <th>Folio</th>
                                        <th>Area</th>
                                        <th>Trabajo</th>
                                        <th>Acci¨®n</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                  {{--  @if(isset($ticket["pmo_worktable"]))
                                        @foreach($ticket["pmo_worktable"] as $workOrden)
                                            <tr>
                                                <th class="hidden">{{$workOrden["id"]}}</th>
                                                <th>{{$workOrden["folio"]}}</th>
                                                <th>{{$workOrden->pmoCategory["name"]}}</th>
                                                <th>{{$workOrden->pmoWork["description"]}}</th>
                                                <th><button class="btn btn-sm btn-inverse" name="fillWorkOrder" data-workOrderId ="{{$workOrden["id"]}}"  data-route="{{ route('pmoWorkTables.getWorkOrder',$workOrden["id"]) }}" >Usar</button></th>
                                            </tr>
                                        @endforeach
                                    @endif--}}

                                    </tbody>
                                </table>

                            </div>
                            <div class="col-lg-8">
                                <legend class="pull-left width-full">Datos de Orden</legend>
                                {{--@include('p_m_o_work_tables.fields')--}}
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <!-- end col-6 -->
        </div>
    </div>

    <!-- end row -->
</fieldset>