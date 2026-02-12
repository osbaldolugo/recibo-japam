@extends('layouts.app')
@section('content')

<div class="panel">
    <div class="row">
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>

                    <h4 class="panel-title">Mediciones Japam</h4>
                    {{--<a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('complaints.create') !!}">Add New</a>--}}
                </div>
                <div class="col-md-3"></div>
                <div class="panel-body col-md-7">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a onclick="abc()" class="nav-link" id="queja-tab" data-toggle="tab" href="#queja" role="tab" aria-controls="queja" aria-selected="true">Quejas</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="abc()" class="nav-link" id="reporte-tab" data-toggle="tab" href="#reporte" role="tab" aria-controls="reporte" aria-selected="false">Reportes</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="abc()" class="nav-link" id="denuncia-tab" data-toggle="tab" href="#denuncia" role="tab" aria-controls="denuncia" aria-selected="false">Denuncias</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="abc()" class="nav-link pagos-tab" id="pagos-tab" data-toggle="tab" href="#pagos" role="tab" aria-controls="pagos" aria-selected="false">Pagos generados</a>
                        </li>
                        <li class="nav-item">
                            <a onclick="abc()" class="nav-link" id="descargas-tab" data-toggle="tab" href="#descargas" role="tab" aria-controls="descargas" aria-selected="false">Descargas de PDF</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent" style="height: 617px">
                        <div style="display: none" class="text-center" id="precentacion" name="precentacion">
                           {{-- <img src="{!! url('assets/img/grafica.jpg') !!}" alt=""> --}}
                        </div>
                        <div class="tab-pane fade" id="queja" role="tabpanel" aria-labelledby="queja-tab">
                            <div id="formQueja" class="formQueja">
                                <form id="buscarQueja" name="buscarQueja" class="buscarQueja" action="" method="post">
                                    <div id="fechas1" class="fechas1 bg-silver col-md-12">
                                        {!! csrf_field() !!}
                                        {{Form::hidden('_method',null)}}
                                        <div class="col-md-3">
                                            <p style="text-align: center; margin-bottom: 0; margin-top: 5%">Buscar de:</p>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" id="from1" name="from1" class="bg-silver form-control input-sm" required>
                                        </div>
                                        <div class="col-md-1">
                                            <p style="text-align: center; margin-bottom: 0; margin-top: 11%">a:</p>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" id="to1" name="to1" class="bg-silver form-control input-sm" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" onclick="busquedaQueja()" id="btnBuscar1" name="btnBuscar1" class="btnBuscar1 btn btn-success">Buscar...</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <canvas id="myChart1" style="height: 40vh; width: 40vw;"></canvas>
                        </div>
                        <div class="tab-pane fade" id="reporte" role="tabpanel" aria-labelledby="reporte-tab">
                            <form id="buscarReporte" name="buscarReporte" class="buscarReporte" action="" method="post">
                                <div id="fechas2" class="fechas2 bg-silver col-md-12">
                                    {!! csrf_field() !!}
                                    {{Form::hidden('_method',null)}}
                                    <div class="col-md-3">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 5%">Buscar de:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="from2" name="from2" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-1">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 11%">a:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="to2" name="to2" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="busquedaReportes()" id="btnBuscar2" name="btnBuscar2" class="btnBuscar2 btn btn-success">Buscar...</button>
                                    </div>
                                </div>
                            </form>
                            <canvas id="myChart2" style="height: 40vh; width: 40vw;"></canvas>
                        </div>
                        <div class="tab-pane fade" id="denuncia" role="tabpanel" aria-labelledby="denuncia-tab">
                            <form id="buscarDenuncia" name="buscarDenuncia" class="buscarDenuncia" action="" method="post">
                                <div id="fechas3" class="fechas3 bg-silver col-md-12">
                                    {!! csrf_field() !!}
                                    {{Form::hidden('_method',null)}}
                                    <div class="col-md-3">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 5%">Buscar de:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="from3" name="from3" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-1">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 11%">a:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="to3" name="to3" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="busquedaDenuncias()" id="btnBuscar3" name="btnBuscar3" class="btnBuscar3 btn btn-success">Buscar...</button>
                                    </div>
                                </div>
                            </form>
                            <canvas id="myChart3" style="height: 40vh; width: 40vw;"></canvas>
                        </div>
                        <div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
                            <div id="formPagos" class="formPagos">
                                <form id="buscarBanco" name="buscarBanco" class="buscarBanco" action="" method="post">
                                    <div id="fechas" class="fechas bg-silver col-md-12">
                                        {!! csrf_field() !!}
                                        {{Form::hidden('_method',null)}}
                                        <div class="col-md-3">
                                            <p style="text-align: center; margin-bottom: 0; margin-top: 5%">Buscar de:</p>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" id="from4" name="from4" class="bg-silver form-control input-sm" required>
                                        </div>
                                        <div class="col-md-1">
                                            <p style="text-align: center; margin-bottom: 0; margin-top: 11%">a:</p>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="date" id="to4" name="to4" class="bg-silver form-control input-sm" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" onclick="antesDeBusqueda()" id="btnBuscar" name="btnBuscar" class="btnBuscar btn btn-success">Buscar...</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <canvas id="myChart4" style="height: 40vh; width: 40vw;"></canvas>
                        </div>
                        <div class="tab-pane fade" id="descargas" role="tabpanel" aria-labelledby="descargas-tab">
                            <form id="buscarDescargas" name="buscarDescargas" class="buscarDescargas" action="" method="post">
                                <div id="fechas5" class="fechas5 bg-silver col-md-12">
                                    {!! csrf_field() !!}
                                    {{Form::hidden('_method',null)}}
                                    <div class="col-md-3">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 5%">Buscar de:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="from5" name="from5" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-1">
                                        <p style="text-align: center; margin-bottom: 0; margin-top: 11%">a:</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" id="to5" name="to5" class="bg-silver form-control input-sm" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="busquedaDescargas()" id="btnBuscar5" name="btnBuscar5" class="btnBuscar5 btn btn-success">Buscar...</button>
                                    </div>
                                </div>
                            </form>
                            <canvas id="myChart5" style="height: 40vh; width: 40vw;"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('css')
    {{Html::style('css/user_panel/receipts/pay.css')}}
    {{Html::style('assets/plugins/parsley/src/parsley.css')}}
    {{Html::style('assets/plugins/bootstrap-toastr/toastr.min.css')}}
    {{Html::style('assets/plugins/switchery/switchery.min.css')}}
@endsection()

@section('scripts')

    <!--
        <script src="../../node_modules/pdfjs-dist/build/pdf.js"></script>
    -->
    <!--
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.487/pdf.js"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.487/pdf.min.js"></script>






    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {!!Html::script('assets/plugins/switchery/switchery.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/receipts/blob-stream.js')}}

    {{--{{Html::script('js/user_panel/receipts/metrics.js')}} --}}
    {{Html::script('js/metrics/app.js')}}


@endsection
