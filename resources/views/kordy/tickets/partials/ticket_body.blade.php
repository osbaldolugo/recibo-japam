<div class="panel panel-inverse">
    <div class="panel-toolbar">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
        </div>
        <h4 class="panel-title">
            {{$ticket->incident->name}}
            <span class="label" style="background-color: {{ $ticket->priority->color }}">{{ $ticket->priority->name }}</span>
        </h4>
    </div>
    <div class="panel-body">
        <div data-scrollbar="true" class="height-350">
            <div class="media media-sm">
                <a class="media-left" href="javascript:;">
                    <img src="{{ empty($ticket->user->url_image) ? url('img/man.png') : URL::to('../storage/app/public/user/' . $ticket->user->url_image) }}" alt="{{$ticket->user->name}}" class="media-object" />
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Descripción del problema</h4>
                    <p>{!!  $ticket->html !!}</p>
                    <div class="col-md-8">
                        <p class="f-s-14">
                            <i class="fa fa-map-marker"></i>&nbsp;
                            {{ !empty($ticket->inside_number) ? $ticket->street . ' ' . $ticket->outside_number . ' Int. ' . $ticket->inside_number . ', Col. ' . $ticket->suburb->suburb . ', C.P. ' . $ticket->cp : $ticket->street . ' ' . $ticket->outside_number . ', Col. ' . $ticket->suburb->suburb . ', C.P. ' . $ticket->cp }}
                        </p>
                        <p class="media-left f-s-15"><strong>Realizo:</strong> <span class="text-muted">{{$ticket->user->name}}</span></p>
                    </div>
                    <div class="col-md-4">
                        <div class="p-5 widget-stats bg-primary text-white" style="border-radius: 5px;">
                            <div class="stats-icon stats-icon-lg stats-icon-square bg-white">
                                <i class="fa fa-users text-primary"></i>
                            </div>
                            <div class="stats-title text-white">DENUNCIANTES</div>
                            <div class="stats-number">{{ count($ticket->appTicket) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-group m-t-10" id="accordion">
            @foreach($ticket->appTicket as $appTicket)
                <div class="panel overflow-hidden">
                    <div class="panel-toolbar bg-black">
                        <h3 class="panel-title">
                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $appTicket->id }}">
                                <i class="fa fa-plus-circle pull-right"></i>
                                Informante
                                <span class="text-uppercase">
                                    {{ $appTicket->appUser == null ? $appTicket->peopleUnlogged == null ? 'ANÓNIMO' : $appTicket->peopleUnlogged->name . ' ' . $appTicket->peopleUnlogged->last_name_1 . ' ' . $appTicket->peopleUnlogged->last_name_2 : $appTicket->appUser->people->name . ' ' . $appTicket->appUser->people->last_name_1 . ' ' . $appTicket->appUser->people->last_name_2 }}
                                </span>
                            </a>
                        </h3>
                    </div>
                    @if($appTicket->appUser == null)
                        @if($appTicket->peopleUnlogged != null)
                            <div id="collapse_{{ $appTicket->id }}" class="panel-collapse collapse{{$loop->first ? ' in' : ''}}">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <label class="control-label text-uppercase">Información de contacto</label>
                                        <p>
                                            <strong>E-mail</strong> <span class="pull-right">{{ $appTicket->peopleUnlogged->email == null ? 'N/A' : $appTicket->peopleUnlogged->email }}</span>
                                        </p>
                                        <p>
                                            <strong>Teléfono</strong> <span class="pull-right">{{ $appTicket->peopleUnlogged->phone_number == null ? 'N/A' : $appTicket->peopleUnlogged->phone_number}}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label text-uppercase">Datos del recibo</label>
                                        <p>
                                            <strong>Contrato</strong> <label class="pull-right label bg-primary f-s-14">{{ $appTicket->contract }}</label>
                                        </p>
                                        <p>
                                            <strong>Núm de medidor</strong> <span class="pull-right label bg-primary f-s-14">{{ $appTicket->meter }}</span>
                                        </p>
                                        <p>
                                            <strong>Titular</strong> <span class="pull-right label bg-primary f-s-14">{{ empty($appTicket->headline) ? 'N/A' : $appTicket->headline }}</span>
                                        </p>
                                        {{--<p>
                                            <strong>Etiqueta</strong> <span class="pull-right label bg-info f-s-12">{{ $appTicket->peopleUnlogged->receipt->alias }}</span>
                                        </p>--}}
                                    </div>
                                    <div class="col-md-8">
                                        <h5>Problema descrito por el usuario</h5>
                                        <p> {{ $appTicket->description }} </p>
                                    </div>
                                    @if(!empty($appTicket->url_image))
                                        <div class="col-md-4 text-right">
                                            <img src="{{ \URL::to('/../storage/app/japam/app_ticket/' . $appTicket->url_image) }}" alt="{{ $appTicket->url_image }}" class="show-detail-image cursor-pointer" style="max-width: 100%; max-height: 120px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div id="collapse_{{ $appTicket->id }}" class="panel-collapse collapse{{$loop->first ? ' in' : ''}}">
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <label class="control-label text-uppercase">Información de contacto</label>
                                    <p>
                                        <strong>E-mail</strong> <span class="pull-right">{{ $appTicket->appUser->email == null ? 'N/A' : $appTicket->appUser->email }}</span>
                                    </p>
                                    <p>
                                        <strong>Teléfono</strong> <span class="pull-right">{{ $appTicket->appUser->phone_number == null ? 'N/A' : $appTicket->appUser->phone_number}}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label text-uppercase">Datos del recibo</label>
                                    <p>
                                        <strong>Contrato</strong> <span class="pull-right label bg-primary f-s-14">{{ $appTicket->contract }}</span>
                                    </p>
                                    <p>
                                        <strong>Núm de medidor</strong> <span class="pull-right label bg-primary f-s-14">{{ $appTicket->meter }}</span>
                                    </p>
                                    <p>
                                        <strong>Titular</strong> <span class="pull-right label bg-primary f-s-14">{{ empty($appTicket->headline) ? 'N/A' : $appTicket->headline }}</span>
                                    </p>
                                    {{--<p>
                                        <strong>Etiqueta</strong> <span class="pull-right label bg-info f-s-12">{{ $value->alias }}</span>
                                    </p>--}}
                                </div>
                                <div class="col-md-8">
                                    <h5>Problema descrito por el usuario</h5>
                                    <p> {{ $appTicket->description }} </p>
                                </div>
                                @if(!empty($appTicket->url_image))
                                    <div class="col-md-4 text-right">
                                        <img src="{{ \URL::to('/../storage/app/japam/app_ticket/' . $appTicket->url_image) }}" alt="{{ $appTicket->url_image }}" class="show-detail-image cursor-pointer" style="max-width: 100%; max-height: 120px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@include('tickets.modals.details-image')
