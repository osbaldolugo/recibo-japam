<div class='btn-group'>
    <a href="javascript:;" name="editEquipment" data-get="{{ route('pMOEquipments.edit', $id) }}" data-route="{{route('pMOEquipments.update',$id)}}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOEquipments.destroy', $id) }}" class='btn btn-danger btn-xs delete-equipment'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
