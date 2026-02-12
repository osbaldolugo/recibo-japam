<div class='btn-group'>
    <a name="editIncident" data-get="{{ route('incidents.edit', $id) }}" data-route="{{ route("incidents.update",$id) }}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i> Editar
    </a>
    <a href="javascript:;" data-route="{{ route('incidents.destroy', $id) }}" class='btn btn-danger btn-xs delete-incident'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
