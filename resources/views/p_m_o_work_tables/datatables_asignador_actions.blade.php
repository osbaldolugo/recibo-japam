{!! Form::open(['route' => ['pMOWorkTables.destroy', $ticket_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <button type="button" name="downloadFile" data-route="{{ route('pMOWorkTables.downloadFile', ["ticket_id"=>$ticket_id,"id"=> $id]) }}" class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-download"></i> Descargar archivo
    </button>

    <a type="button" href="{{ route('pMOWorkTables.edit', $id) }}" disabled class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-edit"></i> Editar (en Construcción)
    </a>
    {{--<a href="{{ route('pMOWorkTables.edit', $id) }}" class='btn btn-default btn-xs'>--}}
        {{--<i class="glyphicon glyphicon-edit"></i>--}}
    {{--</a>--}}
    {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [--}}
        {{--'type' => 'submit',--}}
        {{--'class' => 'btn btn-danger btn-xs',--}}
        {{--'onclick' => "return confirm('Are you sure?')"--}}
    {{--]) !!}--}}
</div>
{!! Form::close() !!}
