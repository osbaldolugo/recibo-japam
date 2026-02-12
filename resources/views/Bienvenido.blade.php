@extends('layouts.login1')

@section('content')
    <style type="text/css">

       #inferior {
           color: black;
           background: white;
           position:fixed; /*El div será ubicado con relación a la pantalla*/
           left:0px; /*A la derecha deje un espacio de 0px*/
           right:0px; /*A la izquierda deje un espacio de 0px*/
           bottom:0px; /*Abajo deje un espacio de 0px*/
           height:50px; /*alto del div*/
           z-index:0;
       }

    </style>

    <div style="" class="login-content">


          <div class="login-buttons">
                <a href="{!! route('receipts.searchGuest') !!}" class="btn btn-success btn-block btn-lg">
                    <i class="fa fa-dollar" aria-hidden="true"></i> Consultar Recibo
                </a>
                    <br><br>
                <a href="{!! route('complain.create') !!}" style="background: #4e7d92; color: white" class="btn btn-block btn-lg">
                    <i class="fa fa-comment"></i> Servicios en linea
                </a>
        </div>
    </div>

@endsection()

@section('css')
    {{Html::style('css/user_panel/receipts/pay.css')}}
    {{Html::style('assets/plugins/parsley/src/parsley.css')}}
    {{Html::style('assets/plugins/bootstrap-toastr/toastr.min.css')}}
    {{Html::style('assets/plugins/switchery/switchery.min.css')}}
@endsection()

@section('scripts')
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {!!Html::script('assets/plugins/switchery/switchery.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/cards/validate.js')}}
    {{Html::script('js/user_panel/receipts/pay.js')}}
    {{Html::script('js/user_panel/receipts/consult.js')}}
@endsection
