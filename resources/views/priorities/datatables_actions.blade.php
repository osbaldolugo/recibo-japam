<div class='btn-group'>
    <a href="javascript:;" name="editPriority" data-get="{{ route('priorities.edit', $id) }}" data-route="{{ route("priorities.update",$id) }}" class="btn btn-primary btn-xs">
        <i class="glyphicon glyphicon-edit"></i> Editar
    </a>
    <a href="javascript:;" data-route="{{ route('priorities.destroy', $id) }}" class="btn btn-xs btn-danger delete-priority">
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
