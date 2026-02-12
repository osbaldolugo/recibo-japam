<form id="saveMetrics" class="saveMetrics form" action="" method="post">


<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Datos del Recibo</h4>
    </div>

    <div style="padding: 0%" class="panel-body">


        <div style="padding: 0%; margin: 0%;" class="invoice col-md-12">


            <div style="padding-left: 5%; padding-right: 5%" class="invoice-content">
                <div class="table-responsive">
                    <table style="width: 100%" class="table table-invoice">

                        <tbody>
                             <div id="metrica">
                            {!! csrf_field() !!}
                            {{Form::hidden('_method',null)}}

                            <input type="text" id="name" name="name" style="display: none">
                            <input type="text" id="contractSave" name="contractSave" style="display: none">
                            <input type="text" id="site" name="site" value="web" style="display: none">
                            <input type="text" id="boton_type" name="boton_type" style="display: none">
                            <button type="submit" id="saveMetrics" name="saveMetrics" class="saveMetrics btn btn-lg btn-primary" style="display: none"> Consultar recibo</button>
                        </div>
                        <tr>
                            <td style="padding: 0%" id="ownerDetail">
                                <b>Pago de Recibo</b>

                            </td>
                        </tr>
                        <tr>
                            <td id="receiptBoard"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="border-radius: 5px 5px 5px 5px;" class="invoice-price">
                    <div style="border-radius: 5px 5px 5px 5px;" class="card invoice-price-right" id="receiptTotal">
                        <small>TOTAL A PAGAR</small>
                        <span id="total_grande" style="width: 25%;    background: #222;    color: #fff;    font-size: 28px;    text-align: right;    vertical-align: bottom;    font-weight: 300;"></span>
                    </div>
                </div>
                <!-- <div style="border-radius: 5px 5px 5px 5px; background: #D75A4A; margin-top: 18px; vertical-align: 50%; padding: 3%" class="card invoice-company text-center">
                    <h4 style="color: white;">"NOTA; SI ACABAS DE REALIZAR TU PAGO ESTE SE VERÁ REFLEJADO EN UN LAPSO MÁXIMO DE 48 HORAS"</h4>
                </div> -->
            </div>
        </div>
        <div class="col-md-4 text-center">
            <a style="margin-right: 2%" href="{!! route('receipts.searchGuest') !!}" class="btn btn-info btn-lg text-left"><i class="fa fa-chevron-left"></i> Inicio</a>
        </div>
        <div class="col-md-4 row text-center">
          {{--  <button id="btnGeneratePdf" data-receipt="{{isset($receiptDetail)?$receiptDetail["receiptId"]:''}}" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Consultar recibo
            </button> --}}
          <button onclick="esconder_boton()"  type="button" class="btn btn-primary text-center btn-lg"
                    data-toggle="modal" id="btnGeneratePdf" data-receipt="{{isset($receiptDetail)?$receiptDetail["receiptId"]:''}}">
                <i class="fa fa-file-pdf-o"></i> Ver PDF
            </button>
           
        </div>
        <!-- <div style="margin-bottom: 5%" class="col-md-4">
            <div id="moduloPagar" class="form-bordered text-center">
                <p hidden > Da clic en el botón para agregar los datos de tu cuenta y pagar tu recibo. </p>
                <a id="btnRedirectBanco" type="button" class="btn btn-success btn-lg"><i class="fa fa-usd"></i> Proceder a Pagar</a>
            </div>
        </div> -->
    </div>
</div>
</form>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div style="width: 56%" class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">Aviso de Japam</h4>
            </div>
            <div class="modal-body">
                <img src="{!! url('assets/img/receipt/avisoJapam.jpg') !!}" alt="" class="img img-responsive" width="100%" height="100%" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script> 

 function esconder_boton(){
        setTimeout(()=>{

            let boton = document.getElementById("btnGeneratePdf");
            boton.innerHTML = "Cargando...";
            $("#btnGeneratePdf").prop("disabled", true)
            //boton.disabled = true ;


        },100)
    }


</script>