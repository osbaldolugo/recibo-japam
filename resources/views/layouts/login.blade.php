<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta content="" name="description" />
    <meta content="" name="author" />

    <title>Japam Móvil - @yield('title')</title>
    <link rel="shortcut icon" href="{{url('img/icon_japam.png')}}">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    {!!Html::style("assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css")!!}
    {!!Html::style("assets/plugins/bootstrap/css/bootstrap.min.css")!!}
    {!!Html::style("assets/plugins/font-awesome/css/font-awesome.min.css")!!}
    {!!Html::style("assets/plugins/ionicons/css/ionicons.min.css")!!}
    {!!Html::style("assets/css/animate.min.css")!!}
    {!!Html::style("assets/css/style.min.css")!!}
    {!!Html::style("assets/css/style-responsive.min.css")!!}
    {!!Html::style("assets/css/theme/default.css", ["id"=>"theme"])!!}
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    {!!Html::script("assets/plugins/pace/pace.min.js")!!}
    <!-- ================== END BASE JS ================== -->
    <style>
        .btn.btn-primary {
            color: #fff;
            background: #023aa7!important;
            border-color: #0097d0!important;
        }

        .btn.btn-success {
            color: #fff;
            background: #0498D4!important;
            border-color: #fff!important;
        }

        .btn.btn-secondary {
            color: #fff;
            background: #41B125!important;
            border-color: #fff!important;
        }

        .alert.alert-success {
            background: #0295CF!important;
            color: #fff;
        }

        .note .note-icon>img {
            position: absolute!important;
        }

        .note .note-icon+.note-content {
            margin-left: 85px;
        }

        .note.note-primary {
            border-color: #348fe2;
            background: #c2ddf7;
            color: #1a4772;
        }

        .note.note-danger {
            border-color: #ff5b57;
            background: #ffcdcc;
            color: #802d2b;
        }

        #c-slider {
            /* margin-top: 10%; */
            /* margin-left: 6%; */
            z-index: 100;
            /* width: 90%; */
            max-width: calc(100vw - 500px);
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 0 0px #252525, 0 5px 50px #292929;
            margin: calc(21vh - 100px) 4vw;
            border-radius: 8px;
            border: 1px solid white;
        }
        #slider{
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            width: 300%;
        }
        #slider section{
            width: 100%;
        }
        #slider img{
            display: block;
            width: 100%;
            height: 100%;
        }
        #btn-next, #btn-prev, #btn-pausa{
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.6);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            line-height: 40px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            font-family: monospace;
            border-radius: 50%;
            cursor: pointer;
        }
        #btn-prev:hover, #btn-next:hover {
            background: rgba(255, 255, 255, 1);
        }
        #btn-prev{
            left: 10px;
        }
        #btn-next{
            right: 10px;
        }


    </style>
</head>
<body class="pace-top bg-white">
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div style="width: 99%" class="text-center login login-with-news-feed">
        <!-- begin news-feed -->
        <div class="news-feed">
            <div id="c-slider">
                <div id="slider">
                    <section><img style="height: 68%;margin-top: 10%;" src="{{url('img/email/slider/slider7.jpg')}}" alt=""></section>
                    <section><img src="{{url('img/email/slider/slider4.jpeg')}}" alt=""></section>
                    <section><img src="{{url('img/email/slider/slider5.jpg')}}" alt=""></section>

                </div>
                <div id="btn-prev">&#60;</div>
                <div title="Pausa" onclick="pausa();" id="btn-pausa" style="margin:50px 0 0 10px;"><i class="fa fa-pause"></i></div>
                <div id="btn-next">&#62;</div>
            </div>
            <div class="news-image">
                <img src="{{URL::to('img/login.png')}}" data-id="login-cover-image" alt="Background-image" />
            </div>
           {{--<div class="news-caption" style="font-weight: bold; color:#ffffff;">
                <h4 class="caption-title"> ¡Registrate y afíliate al nuevo recibo digital! </h4>
                <p>
                    Podras realizar el pago en tiempo real, con tarjeta de crédito o débito, o en efectivo en tiendas de conveniencia.
                </p>
            </div>--}}
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div style="margin-top: 8%" class="right-content">
                @if(Session::has('success'))
                    <div class="note note-primary m-b-15">
                        <div class="note-icon">
                            <img class="m-t-1" src="{{url('img/icon_japam.png')}}">
                        </div>
                        <div class="note-content">
                            <h5><b>¡Listo!</b></h5>
                            <h5>{!! session('success') !!}</h5>
                        </div>
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="note note-danger m-b-15">
                        <div class="note-icon">
                            <img class="m-t-1" src="{{url('img/icon_japam.png')}}">
                        </div>
                        <div class="note-content">
                            <h5><b>¡Ocurrio un error!</b></h5>
                            <h5>{!! session('error') !!}</h5>
                        </div>
                    </div>
                @endif

            <!-- begin register-header -->
            <h1 class="register-header" style="text-align: center">
                <img src="{!! url('img/email/imagen_11.png') !!}" alt="" style="max-width: 300px"/>
            </h1>
            @yield('content')
        </div>
        <!-- end right-container -->
    </div>
    <!-- end login -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
{!! Html::script("assets/plugins/jquery/jquery-1.9.1.min.js") !!}
        {!! Html::script("assets/plugins/jquery/jquery-migrate-1.1.0.min.js") !!}
        {!! Html::script("assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js") !!}
        {!! Html::script("assets/plugins/bootstrap/js/bootstrap.min.js") !!}
<!--[if lt IE 9]>
{!! Html::script("assets/crossbrowserjs/html5shiv.js") !!}
{!! Html::script("assets/crossbrowserjs/respond.min.js") !!}
{!! Html::script("assets/crossbrowserjs/excanvas.min.js") !!}
<![endif]-->
{!! Html::script("assets/plugins/slimscroll/jquery.slimscroll.min.js") !!}
{!! Html::script("assets/plugins/jquery-cookie/jquery.cookie.js") !!}
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
{!! Html::script("assets/js/apps.min.js") !!}
{{ Html::script('assets/plugins/masked-input/jquery.inputmask.bundle.js') }}
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
{{Html::script('js/slider.js')}}

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        $("[data-mask]").inputmask();
    });
</script>
</body>
</html>
