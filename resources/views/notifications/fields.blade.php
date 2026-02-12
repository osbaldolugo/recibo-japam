<div class="row">
    <div class="col-lg-6">
        <!-- Title Field -->
        <div class="form-group col-lg-8">
            <label>
                Titulo:
            </label>
            {!! Form::text('title', null, ['class' => 'form-control', 'id'=>'txtTitle', 'maxlength'=>40]) !!}
            <span style="display:inline;"></span>
        </div>

        <!-- Description Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('description', 'Descripci&oacute;n:') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control input-sm', 'rows' => '2', 'id'=>'txtDescription', 'maxlength'=>200]) !!}
        </div>

        <!-- More info Field -->
        <div class="form-group col-lg-12">
            <label>
                M&aacute;s Informaci&oacute;n (URL):
                <i class="glyphicon glyphicon-info-sign txt-color-2"
                   style="cursor:pointer; cursor: hand" data-toggle="tooltip"
                   data-original-title="Ingresar direcci&oacute;n web si desea redireccionar a un sitio externo."></i>
            </label>
            {!! Form::text('url_info', null, ['class' => 'form-control', 'id'=>'txtUrl', 'placeholder'=>'https://www.japammovil.com', 'data-parsley-type'=>'url']) !!}
            <span style="display:inline;"></span>
        </div>
        @if(isset($showDateImage))
            <!-- Fechas Field -->
            <div class="form-group">
                <label class="col-sm-12 col-lg-12">Fecha de Vigencia: <span style="display:inline-block;" id="error-vigencia"></span></label>
                <div class="col-lg-12 col-sm-12 p-b-10">
                    <div class="input-group input-daterange">
                        {!! Form::text('begin_date', null, ['id'=>'datetimepickerBegin', 'class' => 'form-control input-sm', 'placeholder'=>'Fecha Inicio', 'required' => true]) !!}
                        <span class="input-group-addon">a:</span>
                        {!! Form::text('end_date', null, ['id'=>'datetimepickerEnd', 'class' => 'form-control input-sm', 'placeholder'=>'Fecha Fin', 'required' => true]) !!}
                    </div>
                </div>
            </div>

            <!-- Image Field -->
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('imagen', 'Adjuntar Imagen:') !!}
                <input id="inputImgNotification" type="file" class="file"
                       accept="image/*"
                       data-show-upload="false"
                       data-show-remove="false"
                       data-preview-file-type="text"
                       data-show-preview="false"
                       data-parsley-required ="true"
                       data-parsley-required-message = "Debe adjuntar una imagen."
                       data-parsley-errors-container = "#image_error" name="image">
               {{-- {!! Form::hidden('image', null, ['id' => 'image']) !!}
                {!! Form::hidden('imageFormat', null, ['id' => 'imageFormat']) !!} --}}
                <div id="image_error"></div>
            </div>
        @endif
    </div>

    <div class="col-lg-6">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="image gallery-group-1">
                <div class="image-inner">
                    <img id="imgNotification" src="{{url('img/notification/example.jpg')}}" class="img-thumbnail">
                </div>
                <div class="image-info">
                    <h5 class="title" id="textTitle" style="font-weight: bold"></h5>
                    <div class="desc" id="textDescription"></div>
                    <div class="text-center" id="divMoreInfo" style="display: none;">
                        <a href=""  class="button button-outline-md button-round-md"  target="_blank">
                            <i class="fa fa-share">&nbsp;</i>Más Información
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>