<div class='btn-group'>
    <a href="javascript:;" name="editSpeciality" data-get="{{ route('pMOSpecialities.edit', $id) }}" data-route="{{route("pMOSpecialities.update",$id)}}" class='btn btn-primary btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>&nbsp;Editar
    </a>
    <a href="javascript:;" data-route="{{ route('pMOSpecialities.destroy', $id) }}" class='btn btn-danger btn-xs delete-speciality'>
        <i class="glyphicon glyphicon-trash"></i>
    </a>
</div>
