<div class='btn-group btn-group-sm'>

    @if(!$default)
        <button class="btn btn-primary" id="defaultCard" data-card="{{$id}}">
                <i class="fa fa-tags"></i> Predeterminada
        </button>
    @endif
    <button class="btn btn-danger" id="deleteCard" data-card="{{$id}}">
        <i class="fa fa-times-circle"></i> Eliminar
    </button>
   
</div>
