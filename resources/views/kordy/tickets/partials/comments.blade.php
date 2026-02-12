<div class="panel" id="comments">
    <div class="panel-toolbar" style="background: #043ca5; color:#ffffff;">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>--}}
        </div>
        <h4 class="panel-title">
            Actividad del ticket
        </h4>
    </div>
    @if($ticket->mergeSon == null)
        <div class="panel-toolbar">
            {{Form::open(['route' => 'tickets-comment.store', 'method' => 'POST', 'id' => 'frmComment'])}}
            <div class="form-group">
                {{Form::hidden('ticket_id', $ticket->id)}}
                {{Form::textarea('content', null, ['id' => 'txtCommentContent', 'class' => 'form-control bg-silver summernote-editor', 'placeholder' => 'Ingresa tu mensaje...'])}}
                {{--<input name="content" id="comment" type="text" class="form-control bg-silver" placeholder="Ingresa tu mensaje">--}}
            </div>
            <div class="input-group-btn">
                <div class="row">
                    <div class="col-md-10">
                        <a href="javascript:;" id="btnSave" data-route="{{ route('tickets-comment.store') }}" class="btn btn-primary btn-block"><i class="fa fa-send"></i></a>
                    </div>
                    <div class="col-md-2">
                        <a href="#image-comment" data-route="{{ route('tickets-comment.store') }}" class="btn btn-default btn-block" data-toggle="modal">
                            <i class="fa fa-picture-o"></i>
                            <span class="hidden-xs">Imagen</span>
                        </a>
                    </div>
                </div>
            </div>
            {{Form::close()}}
        </div>
        @include('tickets.modals.modal-image')
    @endif
    <div class="panel-body" id="contentComment">
        <div data-scrollbar="true" class="height-500">
            <comments route_get="{{ route('tickets.listComments', $ticket->id) }}" ticket_id="{{ $ticket->id }}"></comments>
        </div>
    </div>
</div>

