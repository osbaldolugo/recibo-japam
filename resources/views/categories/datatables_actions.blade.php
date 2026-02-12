<div class='btn-group'>
    <a href="javascript:;" name="editCategory" data-get="{{ route('categories.edit', $id) }}" data-route="{{ route("categories.update",$id) }}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i> Editar
    </a>
    <a href="javascript:;" data-route="{{ route('categories.destroy', $id) }}" class='btn btn-danger btn-xs delete-category'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>

