<div class='btn-group'>
    <a href="javascript:;" name="editWork" data-get="{{ route('pMOWorks.edit', $id) }}" data-route="{{ route("pMOWorks.update",$id) }}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i> Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOWorks.destroy', $id) }}" class="btn btn-danger btn-xs delete-work">
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
