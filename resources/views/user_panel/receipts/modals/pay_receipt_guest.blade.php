{{Form::open(["id"=>"frmNewReceipt","class"=>"form-horizontal","data-parsley-validate"=>true])}}

<div class="modal  fade in" id="modalPayReceipt" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Pagar Recibo</h4>
            </div>
            <div class="modal-body">
                <row>
                    {{--<div class="col-lg-5">
                        @include('user_panel.receipts')
                    </div>--}}
                    <div class="col-lg-12">
                        @include('user_panel.receipts.pay-method')
                    </div>
                </row>
            </div>
            <div class="modal-footer">
                {{--<button type="submit" href="javascript:;" class="btn btn-sm btn-primary" id="btnSubmitReceipt"> <i class="fa fa-save"></i> Guardar</button>--}}
                <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cancelar</a>
            </div>
        </div>
    </div>
</div>

{{Form::close()}}