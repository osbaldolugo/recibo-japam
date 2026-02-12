<div class="modal fade bs-modal-lg" id="image-comment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['route' => ('tickets-comment.image'), 'id' => 'fileupload', 'class' => 'dropzone']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="modal-title"><i class="fa fa-picture-o"></i> Agregar Imagenes </h4>
            </div>
            <div class="modal-body">
                {{ Form::hidden('image_ticket_id', $ticket->id) }}
                <div class="row fileupload-buttonbar">
                    <div class="col-md-7">
                        <span class="btn btn-success fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Agregar imagenes...</span>
                            <input type="file" name="files[]" multiple>
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <i class="fa fa-upload"></i>
                            <span>Iniciar carga</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel" id="cancel-image">
                            <i class="fa fa-ban"></i>
                            <span>Cancelar carga</span>
                        </button>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div class="col-md-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width: 0;"></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>

                <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                        <tr class="template-upload fade">
                            <td class="col-md-1">
                                <span class="preview"></span>
                            </td>
                            <td>
                                <p class="name">{%=file.name%}</p>
                                <strong class="error text-danger"></strong>
                            </td>
                            <td>
                                <p class="size">Procesando...</p>
                                <div class="progress progress-striped active"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                            </td>
                            <td>
                                {% if (!i && !o.options.autoUpload) { %}
                                    <button class="btn btn-primary btn-sm start" disabled>
                                        <i class="fa fa-upload"></i>
                                        <span>Iniciar</span>
                                    </button>
                                {% } %}
                                {% if (!i) { %}
                                    <button class="btn btn-white btn-sm cancel">
                                        <i class="fa fa-ban"></i>
                                        <span>Cancelar</span>
                                    </button>
                                {% } %}
                            </td>
                        </tr>
                    {% } %}
                </script>
                <script id="template-download" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                        <tr class="template-download fade">
                            <td>
                                <span class="preview">
                                    {% if (file.thumbnailUrl) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" style="max-width: 80px; max-height= 80px;"></a>
                                    {% } %}
                                </span>
                            </td>
                            <td>
                                <p class="name">
                                    {% if (file.url) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                                    {% } else { %}
                                        <span>{%=file.name%}</span>
                                    {% } %}
                                </p>
                                {% if (file.error) { %}
                                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                                {% } %}
                            </td>
                            <td>
                                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                            </td>
                            <td>
                                {% if (file.deleteUrl) { %}
                                    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Eliminar</span>
                                    </button>
                                    <input type="checkbox" name="delete" value="1" class="toggle">
                                {% } else { %}
                                    <button class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cerrar</span>
                                    </button>
                                {% } %}
                            </td>
                        </tr>
                    {% } %}
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>