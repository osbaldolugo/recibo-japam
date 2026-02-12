<div class='btn-group'>
    <a href="javascript:;" name="editSuburb" data-route="{{ route("suburbs.update",$id) }}" data-get="{{ route("suburbs.edit",$id) }}" class="btn btn-primary btn-xs">
        <i class="glyphicon glyphicon-edit"></i> Editar
    </a>
    <a href="javascript:;" data-route="{{ route('suburbs.destroy', $id) }}" class="btn btn-xs btn-danger delete-suburb">
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
