@extends('layouts.app')
@section('page', trans('lang.show-ticket-title') . trans('lang.colon') . $ticket->incident->name)
@section('css')
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    {{ Html::style('assets/plugins/switchery/switchery.min.css') }}

    {{ Html::style('assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css') }}
    {{ Html::style('assets/plugins/jquery-file-upload/css/jquery.fileupload.css') }}
    {{ Html::style('assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css') }}

    {{ Html::style('css/styles.css') }}
@endsection
@section('content')
        @if($ticket->mergeSon != null)
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="alert alert-danger m-b-0">
                        <h4 class="block">Este tiquet ya no se encuentra disponible para su edición.
                            <a href="{{ route('tickets.show', $ticket->mergeSon->mergeFather->id) }}" class="btn btn-danger btn-xs pull-right">
                                <i class="fa fa-ticket"></i> N° {{ $ticket->mergeSon->mergeFather->folio }}
                            </a>
                        </h4>
                        <p>
                            Si desea realizar cualquier acción a este tiquet, debera hacerlo desde el tiquet que fue asignado como principal que corresponde al tiquet
                            <strong>N° {{ $ticket->mergeSon->mergeFather->folio }}</strong>. Todas las acciones que en su defecto pudieron afectar a este tiquet deberán hacerlas en el tiquet principal.
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                @include('kordy.tickets.partials.ticket_body')
                @include('kordy.tickets.partials.comments')
            </div>
            <div class="col-md-4">
                @include('kordy.tickets.partials.ticket_body_details')
                @if(!empty($tickets_merged))
                    @include('kordy.tickets.partials.ticket_merged')
                @endif
                @include('kordy.tickets.partials.mapping_info')
            </div>
        </div>
@endsection

@section('footer')
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.min.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/lang/summernote-es-ES.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}

    {{ Html::script('assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/vendor/load-image.min.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js') }}
    {{ Html::script('assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js') }}
    {{ Html::script('assets/js/form-multiple-upload.demo.min.js') }}

    {{ Html::script('assets/plugins/switchery/switchery.min.js') }}
    {{ Html::script('assets/js/form-slider-switcher.demo.min.js') }}
    {{ Html::script('js/utils.js') }}
    {{ Html::script('js/Kordy/ticket/app.js') }}
    {{ Html::script('js/Kordy/ticket/show.js') }}
@append
