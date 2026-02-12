<div class="modal fade in" id="modal_app_slider_home" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-modal-slider-home" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Detalles</h4>
            </div>
            <div class="modal-body loading-modal-app-slider-home">
                <div class="row">
                    {!! Form::open(['id' => 'formAppSliderHome', 'name' => 'formAppSlider', 'data-parsley-validate' => 'true']) !!}
                    {!! Form::hidden('_method', null) !!}
                    <div class="col-sm-12 col-lg-12">
                        <div class="form-group col-sm-12 col-lg-12" id="inputImageContainer">
                            <label for="imagen">Seleccionar imagen: <span class="text-danger">*</span></label>
                            <input id="input_image" type="file" class="file"
                                   accept="image/*"
                                   data-preview-file-type="text"
                                   data-show-remove="false"
                                   data-show-upload="false"
                                   data-parsley-required ="true"
                                   data-parsley-required-message = "Debe adjuntar una imagen."
                                   data-parsley-errors-container = "#image_error"
                                   data-parsley-group = "sliderHome">
                            {!! Form::hidden('appSliderHome[image]', null, ['id' => 'image']) !!}
                            {!! Form::hidden('appSliderHome[imageFormat]', null, ['id' => 'imageFormat']) !!}
                            <div id="image_error"></div>
                        </div>

                        <div class="col-sm-12 col-lg-12" id="imagePreviewContainer">
                            <div class="card card-inverse">
                                <img class="card-img image-container" alt="Card image">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-12">
                            <hr class="m-t-10 m-b-10">
                            <label class="p-l-15">Seleccionar el estado de la imagen.</label>
                            <div class="form-group col-sm-12 col-lg-12 text-center">
                                {!! Form::hidden('appSliderHome[status]', 'deshabilitada', ['id' => 'status']) !!}
                                <input type="checkbox" class="js-switch" id="elemCheckbox"/>
                                <span id="txtCheckbox" style="font-size: 16px;"></span>
                                {{Form::button('<i class="fa fa-edit"></i> Actualizar',["id"=>"btnUpdateStatus","class"=>"btn btn-xs bg-color-2 text-white m-t-10"])}}
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-12" id="deleteContainer">
                            <hr class="m-t-10 m-b-10">
                            <label class="p-l-15">¿Eliminar imágen permanentemente?</label>
                            <div class="col-sm-12 col-lg-12 text-center">
                                <a class="btn btn-danger btn-xs" id="deleteImage">
                                    <i class="fa fa-trash-o">&nbsp;</i>Eliminar
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12 col-lg-12">
                        <hr>
                        <div class="text-right">
                            {{Form::button('<i class="fa fa-save"></i> Guardar',["id"=>"btnSaveImage","class"=>"btn btn-sm bg-color-2 text-white"])}}
                            {{Form::button('<i class="fa fa-times-circle"></i> Cerrar',["class"=>"btn btn-sm btn-default close-modal-slider-home","data-dismiss"=>"modal"])}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>