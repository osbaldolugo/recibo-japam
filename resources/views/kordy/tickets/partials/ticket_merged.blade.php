<div class="panel">
    <div class="panel-toolbar bg-inverse">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">
            <i class="fa fa-map-pin"></i>&nbsp;Tiquets absorbidos
            <span class="label" style="background-color: {{ $ticket->priority->color }}">{{ count($tickets_merged) }} tiquets</span>
        </h4>
    </div>
    <div class="panel-body">
        <ul class="chats">
            @foreach($tickets_merged as $value)
                <li class="left">
                    {{--<span class="date-time">{{ $value->incident->name }}</span>--}}
                    <span title="{{ $value->incident->name }}" class="date-time">{{ strlen($value->incident->name) > 45 ? substr($value->incident->name, 0, 40) . '...' : $value->incident->name }}</span>
                    <a href="{{ route('tickets.show', $value->id) }}" target="_blank" class="name">Tiquet N° {{ $value->folio }}</a>
                    <a href="javascript:;" class="image"><img alt="{{ $value->user->name }}" src="{{ empty($value->user->url_image) ? url('img/man.png') : URL::to('../storage/app/public/user/' . $value->user->url_image) }}" title="{{ $value->user->name }}" /></a>
                    <div class="message">
                        {{ strlen($value->content) > 100 ? substr($value->content, 0, 100) . '...' : $value->content }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>