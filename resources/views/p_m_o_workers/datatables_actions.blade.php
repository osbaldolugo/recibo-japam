<div class='btn-group'>
    <a href="javascript:;" name="editWorker" data-get="{{ route('pMOWorkers.edit', $id) }}" data-route="{{route("pMOWorkers.update",$id)}}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOWorkers.destroy', $id) }}" class='btn btn-danger btn-xs delete-worker'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
