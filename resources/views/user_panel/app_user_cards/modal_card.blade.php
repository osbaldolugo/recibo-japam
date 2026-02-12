
{{Form::open(["id"=>"frmNewCard","data-parsley-validate"=>true])}}
                        
<div class="modal  fade in" id="modalNewCard" >
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nueva Tarjeta</h4>
                </div>
                <div class="modal-body">

                            <div class="row form-group">
                                    <div class="col-md-9 col-sm-9">
                                        <label class="control-label" for="owner">Nombre </label>
                                        <input class="form-control" type="text" id="owner" name="owner" 
                                            placeholder="Nombre completo del tarjeta habiente" data-parsley-required="true" >
                                    </div>
                            </div>
                            
                            
                            
                            <div class="row form-group m-t-10">
                                <div class="col-md-4 col-sm-4">
                                    <label class="control-label" for="number">No.Tarjeta </label>
                                    <input class="form-control" type="text" id="number" name="number"  
                                        placeholder="*********8886" data-parsley-required="true" data-parsley-card-payment="" >
                                </div>
                                <div class="col-md-5 col-sm-5 text-left m-t-30" id="cards">
                                    
                                    <div class="col-lg-4">
                                        <img src="{{url('assets/img/receipt/pay-methods/cards/visa.svg')}}" alt="">
                                    </div>
                                
                                    <div class="col-lg-4">
                                        <img src="{{url('assets/img/receipt/pay-methods/cards/master.svg')}}" alt="">
                                    </div>
                                  
                                </div>
                            </div>
                            

                            <div class="row m-t-10">
                                <div class="col-lg-12">
                                     <label class="control-label" for="exp_month">Fecha de expiración </label>  

                                </div>
                            </div>
                            <div class="row form-group  ">     
                                    
                                    <div class="col-md-2 col-sm-2">
                                        <input class="form-control" type="text" id="exp_month" name="exp_month" 
                                            placeholder="MM" data-parsley-required="true" pattern="^(0?[1-9]|1[012])$"  >
                                    </div>
                                    <div class="col-md-1 col-sm-1 text-center" style="font-size:20px; font-weight:bold;">
                                        /
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <input class="form-control" type="text" data-parsley-required="true" 
                                        pattern="^(1?[8-9]{1}|4?[0]{1}|[2-3]{1}[0-9]{1})$" data-required id="exp_year" name="exp_year" placeholder="YYYY" >
                                    </div>
                                       
                            </div>
                                
                </div>
   
                <div class="modal-footer">
                    <button type="submit" href="javascript:;" class="btn btn-sm btn-primary" id="btnSubmitCard"> <i class="fa fa-save"></i> Guardar</button>
                    <a href="javascript:;" class="btn btn-sm btn-danger" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cancelar</a>
                </div>
            </div>
        </div>
    </div>
{{Form::close()}}