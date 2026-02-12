<!-- The Modal -->
{{--<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="cargando"><label>Cargando...</label></div>
                <iframe id="receiptUrl" src="" ></iframe>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div> --}}

<div class="modal fade in" id="modalReceiptPdf" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               {{-- <h4 class="modal-title">Recibo PDF</h4> --}}
                <div id="link"></div>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    {{--<iframe id="receiptUrl" src="" ></iframe> --}}
                    <canvas id="receiptUrl" style="border:1px  solid black"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"> Aceptar</button>
            </div>
        </div>
    </div>
</div>


