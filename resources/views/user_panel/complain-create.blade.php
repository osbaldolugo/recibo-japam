
@extends(Auth::guard('appuser')->user() ? 'layouts.app-user' : 'layouts.app-guest')
@section('css')
    <style>
        .switchBtn {
            position: relative;
            display: inline-block;
            width: 110px;
            height: 34px;
        }
        .switchBtn input {display:none;}
        .slide {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            padding: 8px;
            color: #fff;
        }
        .slide:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 78px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        input:checked + .slide {
            background-color: #5da5e8;
            padding-left: 40px;
        }
        input:focus + .slide {
            box-shadow: 0 0 1px #01aeed;
        }
        input:checked + .slide:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            left: -20px;
        }
        .slide.round {
            border-radius: 34px;
        }
        .slide.round:before {
            border-radius: 50%;
        }
        .grande{
            margin-top:20px;
            {{--height:100px;
                width:300px; --}}
border:1px solid #9d9d9d;
            margin-bottom: 18px;
        }

        .chico{
            {{-- width: 50px; --}}
font-size:18px;
            margin-top:12px;
            margin-left:7px;
            background:white;
            color: #9d9d9d;
            width: 41%;
        }
        .panel-title{
            background:#71cae6;
            color:white;
            padding:.5em;
            font-size:1.1em;
        }
       .panel-heading2{
            background:#71cae6;
        }
       .btn-primary2{
            background:#71cae6;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        {!! Form::open(['route' => 'complaints.store',"data-parsley-validate"=>"","id" => "frmComplaint","name"=>"frmComplaint"]) !!}
        <div class="panel panel-inverse" data-sortable-id="ui-general-2">
            <div class="panel-heading2">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Crear Queja</h4>
            </div>
            <div class="panel-body">
                <div class="note note-info">
                    <div>
                        <h4>Nota</h4>
                        <p>
                            La siguiente información será brindada al departamento correspondiente.
                        </p>
                    </div>
                </div>
                <script>
                    var checado =true;
                    function habilitar() {
                        checado = !checado;
                        console.log(checado);
                        var checkbox = document.getElementById("name");
                        var checkbox1 = document.getElementById("lastname2");
                        var checkbox2 = document.getElementById("lastname1");
                        var phone_number = document.getElementById("phone_number");
                        var email = document.getElementById("email");
                        var recibo = document.getElementById("recibo");
                        var contrato = document.getElementById("contrato");

                        checkbox.disabled = !checado;
                        checkbox1.disabled = !checado;
                        checkbox2.disabled = !checado;
                        phone_number.disabled = !checado;
                        email.disabled = !checado;
                        /* recibo.disabled = !checado;
                         contrato.disabled = !checado;
                        */
                        limpiar();
                    }
                    function limpiar() {
                        var anonimo = document.getElementById("anonimo");
                        var name = document.getElementById("name");
                        var checkbox1 = document.getElementById("lastname2");
                        var checkbox2 = document.getElementById("lastname1");
                        var phone_number = document.getElementById("phone_number");
                        var email = document.getElementById("email");

                        setTimeout(()=>{
                            if (anonimo.checked === true){
                                name.value= '';
                            }else {
                                name.value= 'Anónimo';
                                checkbox1.value= '';
                                checkbox2.value= '';
                                phone_number.value= '';
                                email.value= '';
                            }
                        },200)
                    }
                </script>

                @if(empty(Auth::guard('appuser')->user()))
                    <label style="visibility: hidden" class="switchBtn">
                        <input id="anonimo" name="campo1" type="checkbox" onclick="habilitar()">
                        <div class="slide round">Anónimo</div>
                    </label>
                    <h1 class="chico">Datos personales (confidenciales)</h1>

                    <div class="col-md-12 col-lg-12 form-group">
                        <div class="form-group col-lg-3 col-md-3">
                            {!! Form::label("name","Nombre/s:",["class"=>""]) !!}
                            <div class="input-group input-group-md">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text("name",'',["placeholder"=> "Nombre/s", "class" => "form-control","id"=>"name"/*, "disabled" => "checado"*/]) !!}
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            {!! Form::label("lastnames","Apellido Paterno:",["class"=>""]) !!}
                            {!! Form::text("last_name_2","",["placeholder"=> "Apellido Paterno", "class" => "form-control","id"=>"lastname2"/*, "disabled" => "checado"*/]) !!}
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            {!! Form::label("lastnames","Apellido Materno:",["class"=>""]) !!}
                            {!! Form::text("last_name_1","",["placeholder"=> "Apellido Materno", "class" => "form-control","id"=>"lastname1"/*, "disabled" => "checado"*/]) !!}
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            {!! Form::label("phone_number","Ingresa tu número de teléfono:",["class"=>""]) !!}
                            {!! Form::text("phone_number","",["placeholder"=> "Número de teéfono", "class" => "form-control","id"=>"phone_number"/*, "disabled" => "checado"*/]) !!}
                        </div>
                        <div class="form-group col-lg-2 col-md-2">
                            {!! Form::label("email","Ingresa tu correo electrónico:",["class"=>""]) !!}
                            {!! Form::text("email","",["placeholder"=> "Email", "class" => "form-control","id"=>"email"/*, "disabled" => "checado"*/]) !!}
                        </div>
                    </div>
                @else
                    <div class="form-group col-lg-12">
                        <h1 class="chico">Datos personales (confidenciales)</h1>

                        <div class="col-lg-12 form-inline radio-group">
                            <div data-value="user" class="form-group col-lg-6 radio bg-green-lighter height-100">
                                <div class="media media-sm m-10">
                                    <span class="media-left">
                                        <i class="image fa fa-5x fa-user media-object"> </i>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ Auth::guard('appuser')->user()->people->name ." ". Auth::guard('appuser')->user()->people->last_name_1 ." ". Auth::guard('appuser')->user()->people->last_name_2 }}</h4><br/>
                                        <span><b> Correo electrónico: </b></span> {{ Auth::guard('appuser')->user()->email }}<br/>
                                        <span><b> Teléfono: </b></span> {{ Auth::guard('appuser')->user()->phone_number }}<br/>
                                    </div>
                                </div>

                                {!! Form::hidden("app_user_id",Auth::guard('appuser')->user()->id) !!}
                                {!! Form::hidden("email",Auth::guard('appuser')->user()->email) !!}
                                {!! Form::hidden("phone_number",Auth::guard('appuser')->user()->phone_number) !!}
                            </div>



                            <div style="display: none;" data-value="anonymous" class="form-group col-lg-6 radio height-100">
                                <div class="media media-sm m-10">
                                    <span class="media-left">
                                        <i class="fa fa-5x fa-user-secret media-object"> </i>
                                    </span>
                                    <div class="media-body">
                                        <h4 class="media-heading">Anónimo</h4><br/>
                                        De esta manera se enviará tu queja sin datos personales.
                                    </div>
                                </div>
                            </div>
                            {{ Form::hidden("credentials","user",["id"=> "radio-value"]) }}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <h1 class="chico">Datos de tu recibo JAPAM</h1>
                    <div class="col-md-6">
                        <div class="col-md-12 card-block">
                            <div class="form-group col-lg-6 col-md-6">
                                {!! Form::label("recibo","Ingresa el número de recibo:",["class"=>""]) !!}
                                {!! Form::text("recibo","",["placeholder"=> "Número de recibo", "class" => "form-control", "required"/*,"id"=>"recibo"*/]) !!}
                            </div>
                            <div class="form-group col-lg-6 col-md-6">
                                {!! Form::label("contrato","Ingresa el número de contrato:",["class"=>""]) !!}
                                {!! Form::text("contrato","",["placeholder"=> "Número de contrato", "class" => "form-control", "required"/*,"id"=>"contrato"*/]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-lg-12 form-group">
                            {!! Form::label("lastnames","Cuentanos, ¿Cual es tu queja?",["class"=>""]) !!}
                            {!! Form::textarea("description","",["placeholder"=> "Escribe tu queja","class" => "form-control","required"=>"","data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"10", "data-parsley-minlength-message"=>"Se requiere un mínimo de 10 caracterea"]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 form-group">
                    {!! Form::hidden("type","queja",[]) !!}
                </div>

                <label class="switchBtn">
                    <input id="origen" name="origen" type="text" value="web">
                </label>

                <div class="col-lg-12 form-group">
                    <button id="createComplain" type="button" class="btn btn-lg btn-primary2 pull-right" data-route="{!! route("complaints.store") !!}"><i class="fa fa-plus-circle"></i> Crear Queja</button>
                </div>

            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="modal fade in" id="modalPeople">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>


                <div class="modal-body" id="modal-body">
                    <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div>
                </div>

                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-sm btn-success" data-show-modal="2" id="btnSaveTransfer"><i class="fa fa-send"></i>&nbsp;Guardar</a>

                    {{Form::button('<i class="fa fa-times-circle"></i> Cancelar',["data-dismiss"=>"modal","class"=>"btn btn-sm btn-danger"])}}
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
 @includeIf('app_tickets.wordpressForm.barraInferior')

@endsection

@section('scripts')
    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {!!Html::script('assets/plugins/switchery/switchery.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/features/complain_create.js')}}
@endsection