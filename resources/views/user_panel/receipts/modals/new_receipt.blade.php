{{Form::open(["id"=>"frmNewReceipt","class"=>"form-horizontal","data-parsley-validate"=>false])}}

<div class="modal  fade in" id="modalNewReceipt" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Nuevo Recibo</h4>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">

                        <div class="col-lg-6 text-left p-t-25 ">
                            <img src="{{url('assets/img/receipt/icon.png')}}" alt="" class="img img-responsive img-thumbnail" style="max-height:160px;">
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Alias</label>
                                    <input type="text"  class="form-control" data-parsley-required="false" name="alias">
                                </div>
                            </div>
                            <div style="display: none" class="row">
                                <div class="form-group">
                                    <label for="">Código de Barras</label>
                                    <div class="input-group">
                                        <input type="text" id="barcode" class="form-control" pattern="/^[0-9]{11}$/" data-parsley-required="false" name="barcode">
                                        <span class="input-group-addon help" data-toggle="tooltip"
                                              data-placement="top" data-html="true"
                                              title="<div class='help-receipt'><img src='{{url('img/receipt/barcode.png')}}'></div>">
                                                    <i class="fa fa-question"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Nº Contrato</label>&nbsp;<small>(Ingrese guiones juntos: xxxx-xxxx-xxxx)</small>
                                    <div class="input-group">
                                        <input type="text"  id="contract" class="form-control" data-parsley-required="true" name="contract">
                                       {{-- <input type="text"  id="contract" class="form-control"  pattern="/^[0-9]{5}-[0-9]{5}-[0-9]+$/" data-parsley-required="true" name="contract"> --}}
                                        <span class="input-group-addon help" data-toggle="tooltip"
                                              data-placement="top" data-html="true"
                                              title="<div class='help-receipt'><img src='{{url('img/receipt/contract.png')}}'></div>">
                                                    <i class="fa fa-question"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" href="javascript:;" class="btn btn-sm btn-primary" id="btnSubmitReceipt"> <i class="fa fa-save"></i> Guardar</button>
                <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cancelar</a>
            </div>
        </div>
    </div>
</div>

{{Form::close()}}