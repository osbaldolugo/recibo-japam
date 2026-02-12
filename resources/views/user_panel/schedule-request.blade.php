@extends(Auth::guard('appuser')->user() ? 'layouts.app-user' : 'layouts.app-guest')

@section('content')
    <div class="row">
        {!! Form::open(['route' => 'complaints.store',"data-parsley-validate"=>"","id" => "frmDate","name"=>"frmDate"]) !!}
        <div class="panel panel-inverse" data-sortable-id="ui-general-2">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Solicitar una cita</h4>
            </div>
            <div class="panel-body">
                <div class="note note-info">
                    <h4>Nota</h4>
                    <p>
                        La siguiente información será enviada al departamento correspondiente, para que se ponga
                        en contacto contigo lo antes posible.
                    </p>
                </div>

                @if(empty(Auth::guard('appuser')->user()))
                    <div class="col-lg-12 form-group">

                        <div class="form-group col-lg-3 ">
                            {!! Form::label("name","Nombre/s:",["class"=>""]) !!}
                            <div class="input-group input-group-md">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text("name","",["placeholder"=> "Nombre/s", "class" => "form-control","id"=>"name"]) !!}
                            </div>
                        </div>
                        <div class="form-group col-lg-3 ">
                            {!! Form::label("lastnames","Apellido Materno:",["class"=>""]) !!}
                            {!! Form::text("last_name_1","",["placeholder"=> "Apellido Materno", "class" => "form-control","id"=>"lastname1"]) !!}
                        </div>
                        <div class="form-group col-lg-3 ">
                            {!! Form::label("lastnames","Apellido Paterno:",["class"=>""]) !!}
                            {!! Form::text("last_name_2","",["placeholder"=> "Apellido Paterno", "class" => "form-control","id"=>"lastname2"]) !!}
                        </div>

                        <div class="form-group col-lg-3 ">
                            {!! Form::label("phone_number","Teléfono:",["class"=>""]) !!}
                            <div class="input-group input-group-md">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                {!! Form::text("phone_number","",["placeholder"=> "Teléfono", "class" => "form-control","id"=>"phone_number"]) !!}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 form-group">

                        <div class="form-group col-lg-6">
                            <div class="media media-sm">
                                <span class="media-left">
                                    <i class="fa fa-5x fa-user-circle media-object"> </i>
                                </span>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ Auth::guard('appuser')->user()->people->name ." ". Auth::guard('appuser')->user()->people->last_name_1 ." ". Auth::guard('appuser')->user()->people->last_name_2 }}</h4><br/>
                                    <span><b> Correo electrónico: </b></span> {{ Auth::guard('appuser')->user()->email }}<br/>
                                    <span><b> Teléfono: </b></span> {{ Auth::guard('appuser')->user()->phone_number }}<br/>
                                </div>
                            </div>
                        </div>
                        {!! Form::hidden("app_user_id",Auth::guard('appuser')->user()->id) !!}
                        {!! Form::hidden("email",Auth::guard('appuser')->user()->email) !!}
                        {!! Form::hidden("phone_number",Auth::guard('appuser')->user()->phone_number) !!}
                    </div>
                @endif

                <div class="col-lg-12">
                    {!! Form::label("description","Propósito de la cita:",["class"=>""]) !!}
                    {!! Form::textarea("description","",["placeholder"=> "¿Cual es el propósito de su cita?","class" => "form-control","id"=>"description"]) !!}
                </div>

                <div class="col-lg-12 form-group">
                    {!! Form::textarea("type","cita",["placeholder"=> "","class" => "hidden","data-parsley-trigger"=>"keyup", "data-parsley-minlength"=>"20", "data-parsley-minlength-message"=>"Se requiere un mínimo de 10 caractere"]) !!}
                </div>

                <div class="col-lg-12 form-group">
                    <button type="createDate" class="btn btn-lg btn-primary pull-right" type="button" data-route="{!! route("complaints.store") !!}"><i class="fa fa-calendar-plus-o"></i> Solicitar Cita</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {!!Html::script('assets/plugins/switchery/switchery.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/features/schedule_request.js')}}
@endsection