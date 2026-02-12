@extends('layouts.app-guest')
@section('page', 'Registrar una cuenta')
@section('css')
    {{ Html::style('assets/plugins/bootstrap-toastr/toastr.min.css') }}
    {{ Html::style('assets/plugins/parsley/src/parsley.css') }}
    {{ Html::style('assets/plugins/bootstrap-sweetalert/sweetalert.css') }}
    {{ Html::style('css/styles.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse" id="loading">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        {{--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>--}}
                        {{--<a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>--}}
                    </div>
                    <h4 class="panel-title">LLENA EL FORMULARIO PARA AFILIARTE</h4>
                </div>
                <div class="panel-body">
                    <form action="" method="post" id="form">
                        <fieldset class="col-md-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label>Los campos marcados con <strong>*</strong> son requeridos.</label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="contract" class="c-white"><strong>N&uacute;mero de contrato*</strong></label>
                                    <input type="text" id="contract" name="contract" required class="form-control" placeholder="12345-12345-123456" title="Formato: 12345-12345-123456"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="barcode" class="c-white"><strong>C&oacute;digo de barras*</strong></label>
                                    <input type="text" id="barcode" name="barcode" required class="form-control" placeholder="12345678901" title="Formato: 12345678901" />
                                </div>

                                <div class="col-md-6 form-group">
                                    <button type="button" class="btn btn-info btn-sm validarRecibo pull-right" title="Corroborar que el recibo si existe"><i class="fa fa-check-square-o"></i>&nbsp;Validar Recibo</button>
                                </div>
                                <div class="col-md-6">
                                    <label for="holder">
                                        <input type="checkbox" id="holder" name="holder" onchange="habilitar(this.checked);">
                                        <strong>&nbsp;Soy titular</strong> (En caso de ser titular o due&ntilde;o del contrato marque esta opci&oacute;n)
                                    </label>
                                </div>
                            </div>
                            <legend>
                                Datos del Titular
                            </legend>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="name"><strong>Nombre Titular de contrato*</strong></label>
                                    <input type="text" id="name" name="name" required class="form-control" placeholder="Nombre(s) que aparece en el recibo" title="Nombre(s) que aparece en el recibo" readonly />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="col-md-6">
                            <legend>
                                Datos de usuario
                            </legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback">
                                        <label>Los campos marcados con <strong>**</strong> son requeridos únicamente si no eres el titular del recibo.</label>
                                    </div>
                                </div>
                                <div id="noTitular">
                                    <div class="col-md-4 form-group">
                                        <label for="name_u"><strong>Nombre de contacto**</strong></label>
                                        <input type="text" id="name_u" name="name_u" class="form-control" placeholder="Nombre(s)" title="Únicamente si no eres el titular del recibo" />
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="last_name_1_u"><strong>Apellido Paterno**</strong></label>
                                        <input type="text" id="last_name_1_u" name="last_name_1_u" class="form-control" placeholder="Apellido Paterno" title="Únicamente si no eres el titular del recibo"/>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="last_name_2_u"><strong>Apellido Materno**</strong></label>
                                        <input type="text" id="last_name_2_u" name="last_name_2_u" class="form-control" placeholder="Apellido Materno" title="Únicamente si no eres el titular del recibo"/>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="phone_number"><strong>Tel&eacute;fono celular</strong></label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="(427) 129-0073" title="(427) 129-0073" data-inputmask='"mask": "(999) 999-9999"' data-mask/>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="email"><strong>Asigna un e-mail para recibir notificaciones*</strong></label>
                                    <input type="email" id="email" name="email" required class="form-control" placeholder="Asigna un e-mail para recibir notificaciones"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="old_email"><strong>Confirma tu e-mail*</strong></label>
                                    <input type="email" id="old_email" name="old_email" required class="form-control" placeholder="Confirma tu e-mail"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="title" class="c-white"><strong>Crea una contraseña para acceder a JAPAM*</strong></label>
                                    <input type="password" id="password" name="password" required class="form-control" placeholder="Crea una contraseña para acceder a JAPAM" />
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label>Al enviar la información usted esta aceptando nuestras
                                        <strong><a data-toggle="modal" href="#politicas">Políticas de privacidad</a></strong> y nuestros
                                        <strong><a data-toggle="modal" href="#terminosYCondiciones">Términos y condiciones</a></strong>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary pull-right save" data-route="{{ route('receipt.register.save') }}"><i class="fa fa-send"></i>&nbsp;Registrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('auth-app-user.terms')
@endsection

@section('footer')
    {{ Html::script('assets/plugins/bootstrap-toastr/toastr.min.js') }}
    {{ Html::script('assets/plugins/blockUI/blockui.min.js') }}
    {{ Html::script('assets/plugins/parsley/dist/parsley.js') }}
    {{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
    {{ Html::script('assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}
    {{ Html::script('js/utils.js') }}
    {{ Html::script('js/user_panel/register/send.js') }}
@append

