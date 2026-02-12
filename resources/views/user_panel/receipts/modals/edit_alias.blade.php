{{Form::open(["id"=>"frmEditAlias","class"=>"form-horizontal","data-parsley-validate"=>true])}}

<div class="modal  fade in" id="modalEditAlias" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Editar Alias</h4>
            </div>
            <div class="modal-body">

                <input type="hidden" id="receiptId">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="form-group">
                            <label for="">Alias</label>
                            <input type="text"  class="form-control" data-parsley-required="true" name="alias">
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" href="javascript:;" class="btn btn-sm btn-primary" id="btnSubmitAlias"> <i class="fa fa-save"></i> Actualizar</button>
                <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cancelar</a>
            </div>
        </div>
    </div>
</div>

{{Form::close()}}