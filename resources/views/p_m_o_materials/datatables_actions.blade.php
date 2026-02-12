<div class='btn-group'>
    <a href="javascript:;" name="editMaterial" data-get="{{ route('pMOMaterials.edit', $id) }}" data-route="{{ route('pMOMaterials.update',$id) }}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOMaterials.destroy', $id) }}" class='btn btn-danger btn-xs delete-material'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
