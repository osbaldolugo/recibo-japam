<fieldset>

    <div class="col-lg-12">
        <div class="panel panel-inverse" data-sortable-id="table-basic-6">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                </div>
                <h4 class="panel-title">PDF</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <iframe id="pdfFactura" class="col-lg-12" style="height:1000px;" src="" ></iframe>
                </div>
            </div>
            <div class="panel-footer center">
                <a href="{{ route('pMOWorkTables.index') }}"  class="btn btn-md btn-primary"> Regresar a la lista</a>
                <a href="{{ route('pmoWorkTables.index_asignados') }}"  class="btn btn-md btn-primary"> ver lista de ordenes</a>
            </div>
        </div>
    </div>
    <!-- end row -->
</fieldset>