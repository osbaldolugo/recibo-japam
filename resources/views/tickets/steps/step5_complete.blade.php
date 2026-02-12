<div class="jumbotron m-b-0 text-center">
    <h1>Se ha completado la información del tiquet</h1>
    <p>Ahora solo es necesario proceder a enviar su información</p>
    <div class="alert alert-danger fade in m-t-15 hidden errorRecipt">
        <strong>No se encontro ningún recibo con la información proporcionada</strong>
    </div>
    <p><a href="javascript:;" class="btn btn-success btn-lg" id="btnSave" data-route="{{ route('tickets.store') }}"><i class="fa fa-save"></i>&nbsp;Enviar y guardar Tiquet</a></p>
</div>