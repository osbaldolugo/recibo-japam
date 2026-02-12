{!! Form::open(['route' => ['pMOWorkTables.destroy', $ticket_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('tickets.show', $ticket_id) }}" class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-eye-open"></i> Ver detalle
    </a>
    {{--<a href="{{ route('pMOWorkTables.edit', $id) }}" class='btn btn-default btn-xs'>--}}
        {{--<i class="glyphicon glyphicon-edit"></i>--}}
    {{--</a>--}}
    <a href="{{ route('pmoWorkTables.mappingCreate', $ticket_id) }}" class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-map-marker"></i> Mapeo
    </a>
    <a href="{{ route('pmoWorkTables.orderWorkCreate', $ticket_id) }}" class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-file"></i> Orden de Trabajo
    </a>
    <a href="{{ route('pmoWorkTables.orderWorkClose', $ticket_id) }}" class='btn btn-primary btn-sm'>
        <i class="glyphicon glyphicon-usd"></i> Cerrar Orden de Trabajo
    </a>
    {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [--}}
        {{--'type' => 'submit',--}}
        {{--'class' => 'btn btn-danger btn-xs',--}}
        {{--'onclick' => "return confirm('Are you sure?')"--}}
    {{--]) !!}--}}
</div>
{!! Form::close() !!}
