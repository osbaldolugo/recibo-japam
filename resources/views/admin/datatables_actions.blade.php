<div class="btn-group">
    @if($deleted_at == null)
        <a href="javascript:;" class='btn btn-primary btn-xs editUser' data-route="{{ route('admin.users.edit', $id) }}">
            <i class="fa fa-edit"></i> Editar
        </a>
        <a href="javascript:;" class="btn btn-danger btn-xs deleteUser" data-route="{{ route('admin.users.delete', $id) }}">
            <i class="fa fa-trash"></i> Eliminar
        </a>
    @else
        <a href="javascript:;" class='btn btn-warning btn-xs retoreUser' data-route="{{ route('admin.users.restore', $id) }}">
            <i class="fa fa-edit"></i> Restaurar
        </a>
    @endif
</div>