<div class='btn-group'>
    <a href="javascript:;" name="editWorkType" data-get="{{ route('pMOWorkTypes.edit', $id) }}" data-route="{{ route("pMOWorkTypes.update",$id) }}" class="btn btn-primary btn-xs">
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOWorkTypes.destroy', $id) }}" class="btn btn-danger btn-xs delete-work-type">
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
