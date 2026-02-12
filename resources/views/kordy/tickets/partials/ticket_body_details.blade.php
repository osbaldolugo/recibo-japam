<div class="panel panel-inverse">
    <div class="panel-toolbar">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
        </div>
        <h4 class="panel-title">
            Detalles del ticket
            <span class="label" style="background-color: {{ $ticket->priority->color }}">{{ $ticket->status }}</span>
        </h4>
    </div>
    <div class="panel-body">
        <table class="table">
            <tbody>
            <tr>
                <td><strong>#</strong></td>
                <td>{{$ticket->folio}}</td>
            </tr>
            <tr>
                <td><strong>Asignado</strong></td>
                <td>
                    <div class="media media-sm">
                        <a class="media-left" href="javascript:;">
                            <img src="{{ empty($ticket->agent->url_image) ? url('img/man.png') : URL::to('../storage/app/public/user/' . $ticket->agent->url_image) }}" alt="{{$ticket->agent->name}}" class="media-object" />
                        </a>
                        <div class="media-body text-center">
                            <h5 class="media-heading">{{$ticket->agent->name}}</h5>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><strong>Capturado</strong></td>
                <td>{{$ticket->created_at->format('d/F/Y h:i:s a')}}</td>
            </tr>
            <tr>
                <td><strong>Ultima actividad</strong></td>
                <td id="lastActivity">{{$ticket->updated_at->format('d/F/Y h:i:s a')}}</td>
            </tr>
            <tr>
                <td><strong>Departamento</strong></td>
                <td>{{$ticket->category->name}}</td>
            </tr>
            <tr>
                <td><label for="cbxNotification" class="bold" title="Determina si quiero recibir notificaciones de este Ticket">Notificaciones</label></td>
                <td><input type="checkbox" data-render="switchery" data-theme="blue" id="cbxNotification" value="1" name="generated" {{ $ticket->userSubsI->isEmpty() ? '' : 'checked' }} /></td>
            </tr>
            </tbody>
        </table>
        <div class="btn-group btn-group-justified">
        @if($ticket->mergeSon == null)
            @if($ticket->agent->id == Auth::user()->id)
                <a href="#reasignUser" class="btn btn-primary btn-sm" title="Asignar el tiquet a otro usuario" data-toggle="modal">
                    <i class="fa fa-random"></i>
                    Reasignar
                </a>
            @else
                @if(!empty($myCategories[0]))
                    <a href="javascript:;" class="btn btn-primary btn-sm btnAsignTicket" data-route="{{route('tickets.reasign', [$ticket->id, Auth::user()->id, $myCategories[0]->id])}}" title="Asignarme el tiquet" data-show-modal="{{ count($myCategories) > 1 ? 1 : 0 }}">
                        <i class="fa fa-thumb-tack"></i>
                        Asignarmelo
                    </a>
                @endif
                <a href="javascript:;" class="btn btn-success btn-sm" id="btnRemember" title="Enviar recordatorio al usuario asignado" data-route="{{ route('tickets.sendReminder', $ticket->id) }}">
                    <i class="fa fa-bullhorn"></i>
                    Recordar
                </a>
            @endif
            <a href="#mergeTicket" class="btn btn-inverse btn-sm" title="Unir con otro tiquet" data-toggle="modal">
                <i class="fa fa-code-fork"></i>
                Merge
            </a>
        @else
            <a href="javascript:;" class="btn btn-warning btn-sm" id="merge-revert" title="Revertir merge" data-route="{{route('tickets.merge.revert', [$ticket->mergeSon->mergeFather->id, $ticket->id])}}" data-father="{{ $ticket->mergeSon->mergeFather->folio }}" data-son="{{ $ticket->folio }}">
                <i class="fa fa-chain-broken"></i>
                Revertir Merge
            </a>
        @endif
        </div>
    </div>
</div>
@if($ticket->mergeSon == null)
    @if($ticket->agent->id == Auth::user()->id)
        <div class="modal fade" id="reasignUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Cambiar al usuario asignado</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-uppercase">Categorías</label>
                                        <div class="col-md-8">
                                            @foreach($all_categories as $category)
                                                <div class="radio radio-css">
                                                    {{ Form::radio('category', $category->id, $category->id == $ticket->category->id ? true : false, ['id' => 'category' . $category->id]) }}
                                                    <label for="category{{$category->id}}">{{$category->name}}</label>
                                                    <span data-html="@foreach($category->agents as $agent)<div class='radio radio-css radio-success'><input id='agent{{ $agent->id }}' name='agent' type='radio' value='{{ $agent->id }}' {{$loop->first ? 'checked="checked"' : ''}}'><label for='agent{{ $agent->id }}'>{{ $agent->name }}</label></div>@endforeach" id="categoryAgentList_{{$category->id}}"></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 my-arrow-right">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-uppercase">Usuarios</label>
                                        <div class="col-md-8" id="agentList">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
                        <a href="javascript:;" class="btn btn-sm btn-success btnReasignTicket" data-route="{{ URL::to('/tickets/reasign') . '/' . $ticket->id }}" data-show-modal="2"><i class="fa fa-send"></i>&nbsp;Reasignar el tiquet</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="reasignCategory">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Seleccionar la categoría donde será reubicado el ticket</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-3 control-label text-uppercase">Categoría</label>
                                <div class="col-md-9">
                                    @foreach($myCategories as $category)
                                        <div class="radio radio-css">
                                            {{ Form::radio('category', $category->id, $loop->first ? true : false, ['id' => 'cssRadio' . $category->id]) }}
                                            <label for="cssRadio{{$category->id}}">{{$category->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal"><i class="fa fa-window-close"></i>&nbsp;Cerrar</a>
                        <a href="javascript:;" class="btn btn-sm btn-primary btnAsignTicket" data-route="{{ URL::to('/tickets/reasign') . '/' . $ticket->id . '/' . Auth::user()->id }}" data-show-modal="2"><i class="fa fa-send"></i>&nbsp;Asignarme el ticket</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Begin Modal Merge -->
    <div class="modal fade" id="mergeTicket">
        {!! Form::open(['route' => ['tickets.merge', $ticket->id], 'method' => 'POST', 'name' => 'form-wizard', 'data-parsley-validate' => 'true', 'id' => 'frmMergeTicket']) !!}
        <div class="modal-dialog">
            <div class="modal-content" id="mergeTicketContent">
                <div class="modal-header bg-black">
                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-white">Selecciona un método para hacer el merge del tiquet</h4>
                </div>
                <!-- Begin modals-body -->
                <div class="modal-body bg-silver">
                    <!-- Begin row -->
                    <div class="row">
                        <!-- Begin nav-tab -->
                        <div class="col-md-12">
                            <ul class="nav nav-tabs bg-blue-darker myTab">
                                <li class="active advanced_merge">
                                    <a href="#advanced_merge" data-toggle="tab">
                                        <i class="fa fa-search"></i>
                                        <span class="hidden-xs">&nbsp;Busqueda</span>
                                    </a>
                                </li>
                                <li class="simple_merge">
                                    <a href="#simple_merge" data-toggle="tab">
                                        <i class="fa fa-map-marker"></i>
                                        <span class="hidden-xs">&nbsp;Proximidad</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="simple_merge">
                                    @if(count($similar_tickets) > 0)
                                        <ul class="media-list media-list-with-divider">
                                            @foreach($similar_tickets as $sticket)
                                                <li class="media media-sm p-5 li" id="li_{{$sticket->id}}">
                                                    <label for="{{$sticket->folio}}_check" class="cursor-pointer">
                                                        <a class="media-left" href="javascript:;">
                                                            <img src="{{ empty($sticket->user->url_image) ? url('img/man.png') : URL::to('../storage/app/public/user/' . $sticket->user->url_image) }}" alt="" class="media-object rounded-corner" title="{{ $sticket->user->name }}" />
                                                            <small class="m-l-10" title="Generado el {{ $sticket->created_at->format('d/F/Y') }}">{{ $sticket->created_at->format('d/m/Y') }}</small>
                                                        </a>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                <span class="label label-primary">N° {{ $sticket->folio }}</span>
                                                                {{ $sticket->incident->name }}
                                                                <div class="pull-right">
                                                                    <a href="{{ route('tickets.show', $sticket->id) }}" target="_blank" class="btn btn-info btn-icon btn-sm" title="Ver tiquet"><i class="fa fa-eye"></i></a>
                                                                </div>
                                                            </h4>
                                                            <p>{{ $sticket->content }}</p>
                                                            <p>
                                                                <span class="btn btn-sm m-r-5 bg-warning" title="Departamento">{{ $sticket->category->name }}</span>
                                                                <span class="btn btn-sm btn-success" title="Distancia aproximada">{{ number_format($sticket->distance * 1000, 2) }} m</span>
                                                            </p>
                                                        </div>
                                                    </label>
                                                    <div class="hidden">
                                                        {{Form::checkbox('ticket_son[]', $sticket->id, false, ['id' => $sticket->folio.'_check', 'class' => 'merge_ticket', 'required', 'data-parsley-chekmin' => '1', 'data-parsley-errors-container' => '#errorMessage', 'data-parsley-error-message' => 'Es necesario seleccionar al menos un tiquet', 'data-parsley-group' => 'merge'])}}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="note note-warning">
                                            <h4>¡No hay tiquets!</h4>
                                            <p>
                                                No se encontraron tiquets que puedan estar relacionados con este tiquet. Busca en la sección de la otra pestaña.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade active in" id="advanced_merge">
                                    <div class="alert alert-warning fade in m-b-10">
                                        <span class="close" data-dismiss="alert">×</span>
                                        <h4>¡Como seleccionar un tiquet en esta sección!</h4>
                                        <p>
                                            Escribe el numero de folio del tiquet que deseas buscar. Puedes separar los folios por comas.
                                            <br />Ejemplo:1,52,68,71
                                            <br /><strong>Importante: Los resultados de la busqueda quedan seleccionados por default.</strong>
                                        </p>
                                    </div>
                                    <div class="input-group">
                                        {{ Form::text('search', null, ['id' => 'txtSearch', 'class' => 'form-control', 'placeholder' => 'Buscar tickets...', 'required', 'data-parsley-group' => 'search', 'data-parsley-error-message' => 'Es necesario especificar los tiquets que se desean buscar', 'data-parsley-errors-container' => '#search_id_error']) }}
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-route="{{ route('tickets.merge.search', $ticket->id) }}" id="btnSearch">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div id="search_id_error"></div>
                                    <br />
                                    <ul class="media-list media-list-with-divider" id="listSearch">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End nav-tab -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- End modal-body -->
                <div class="modal-footer">
                    <div id="errorMessage" class="pull-left" style="font-weight: bolder;"></div>
                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal"><i class="fa fa-window-close"></i>&nbsp;Cerrar</a>
                    <a href="javascript:;" id="btnMergeTiquet" class="btn btn-sm btn-primary" data-route="{{ route('tickets.merge', $ticket->id) }}"><i class="fa fa-code-fork"></i>&nbsp;Fusionar tiquet</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif
    <!-- End Modal Merge -->
