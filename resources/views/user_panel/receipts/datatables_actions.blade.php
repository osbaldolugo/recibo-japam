<div class='btn-group btn-group-xs btn-group-vertical'>

<a href="#" class='btn btn-inverse' id="changeAlias" data-receipt="{{$id}}">
        <i class="fa fa-user"></i> Cambiar Alias
    </a>

    <a href="{{ route('receipts.pay', $id) }}" class='btn btn-primary'>
        <i class="fa fa-eye"></i> Consultar Status
    </a>
<!--
    <a href="#" class='btn btn-inverse' id="viewHistory" data-receipt="{{$id}}">
        <i class="fa fa-list-alt"></i> Historial de Pagos
    </a>

-->
    
</div>
