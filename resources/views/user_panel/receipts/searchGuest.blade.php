@extends('layouts.app-user')

@section('content')


    @if(!env("MANTENIMIENTO"))
        @include('auth-app-user.terms')
        @include('user_panel.receipts.modals.receiptPdf')
        @include('user_panel.receipts.modals.ayuda')
        
<style>
.texto-no-encontrado{
    font-size: 2em;
text-align: center;
margin: 0 auto;
width: 60%;
padding: 58px;



}
.card-header2{
background-color: #71cae6;
padding: .5em;
font-size: 1.6em;
font-weight: bold;
color: #fffdfd;
}

.boton_mostrar2{
    background-color: #71cae6;
}
</style>
        <div class="row">
            {!! Form::open(['route' => 'receipts.consult', 'method' => 'POST', 'name' => 'frmConsult', 'id' => 'frmConsult']) !!}
            <style>
            .responsive{
                max-width:50%;
                height:auto;
                margin-bottom: 10px;
            }
            
            input[type=number]::-webkit-inner-spin-button,
                input[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                
            -moz-appearance:textfield;
            input[type=number] {
                -moz-appearance:textfield; 
                
            }

            </style>
            <div class="col-md-2"></div>
            <div  id="consult-receipt" class="col-lg-9">
                <div class="card text-center">
                    <div class="card-header2">
                        Recibo
                    </div>
                    <div class="card-block text-center">
                        <!--<img src="{!! url('assets/img/receipt/icon.png') !!}" alt="" class="img img-responsive img-paid-receipt" >-->
                        <h4 class="card-title">Ingrese la información de su recibo</h4>

                        <div class="row">
                                    <li class="list-group-item">
                                        Escriba su número de contrato
                                        <div style="width: 100%" class="input-group">
                                            <div class="form-horizontal">
                                                <div class="col-md-12">
                                                     <div  class="col-md-12 col-xs-7">
                                                        <img src="../img/recibo_consultas.jpeg" class="responsive"/>
                                                    </div>
                                                   
                                                    <div class="col-md-12">
                                                                    <table style="margin: 0 auto;margin-bottom:15px">
                                                                        <tr>
                                                                            <td> <input title="Unicamente valores numéricos están permitidos" type="number" style="font-size: 2em;border-radius: 3px;margin: 0 7px; border: none;background-color: #e4e4e4;height: 35px;width:4em;padding-left: .5em;"  class="inputs_contrato" name="contract" id="contract" data-parsley-required="true"/></td>
                                                                            <td style="font-size: 2em;">
                                                                                -
                                                                            </td>
                                                                            <td>
                                                                                <input title="Unicamente valores numéricos están permitidos" type="number" class=" inputs_contrato" name="contract2" id="contract2" data-parsley-required="true" style="font-size: 2em;border-radius: 5px; margin: 0 7px; border: none;background-color: #e4e4e4;height: 35px;width:4em;padding-left: .5em;"/>
                                                                            </td>
                                                                            <td style="font-size: 2em;">
                                                                                -
                                                                            </td>
                                                                            <td >
                                                                                <input title="Unicamente valores numéricos están permitidos" type="number" class="inputs_contrato" name="contract3" id="contract3" data-parsley-required="true" style="font-size: 2em;border-radius: 5px;margin: 0 7px; border: none;background-color: #e4e4e4;height: 35px;width:4em;padding-left: .5em;"/>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                <td style="height:10px;"></td>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        <!--<span hidden class="input-group-addon help" data-toggle="tooltip"
                                                  data-placement="top" data-html="true"
                                                  title="<div class='help-receipt'><img src='{{url('https://japammovil.com/img/contrato_mini.png')}}'></div>">
                                                   <i class="fa fa-question"></i></span>-->
                                        </div>
                                    </li>
                        </div>
                        <a onclick="generarPlayer()" href="#" style="margin-top: 4px" class="pull-right" data-toggle="modal" data-target="#create">
                            <img width="74px;" src="{!! url('assets/img/receipt/help1.jpg') !!}">
                        </a>
                        <script>
                            function muestra_oculta(id){
                                if (document.getElementById){ //se obtiene el id
                                    var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
                                    el.style.display = (el.style.display === 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
                                }
                            }
                            window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
                                muestra_oculta('receipt-contrac');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
                            }
                        </script>
                        <button type="submit" id="receiptSearch" onclick="guardarContrato()" style="cursor: pointer"  class="boton_mostrar2 btn btn-lg " data-route="{!! route("receipts.consult") !!}"> Consultar recibo</button>
                    </div>
                    
                </div>
               
                
                <!-- Global site tag (gtag.js) - Google Analytics -->
            </div>
            {!! Form::close() !!}

            <div id="receipt-contrac" disabled class="col-lg-7">
                @include('user_panel.receipts.receipt-contract')
            </div>
            {{-- <div id="pay-method" class="col-lg-7">
                @include('user_panel.receipts.pay-method')
            </div>
            --}}
            
        </div>

    @else
        <img src="{!! url('assets/img/receipt/japam.png') !!}" alt="" class="img img-responsive" width="100%" height="100%" >
    @endif
    

@endsection()

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
    {{Html::script('js/user_panel/cards/validate.js')}}
    {{Html::script('js/user_panel/receipts/pay.js')}}
    {{Html::script('js/user_panel/receipts/blob-stream.js')}}
    {{Html::script('js/user_panel/receipts/pdfkit.standalone.js')}}
    {{Html::script('js/user_panel/receipts/consultv2.js')}}
    
@endsection
