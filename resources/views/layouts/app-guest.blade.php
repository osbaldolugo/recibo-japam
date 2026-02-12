<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Japam Móvil @yield('page')</title>
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
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- <script src="sweetalert2.all.min.js"></script>
      Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    {!!Html::style("assets/plugins/jquery-jvectormap/jquery-jvectormap.css")!!}
    {!!Html::style("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css")!!}
    {!!Html::style("assets/plugins/gritter/css/jquery.gritter.css")!!}
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    @yield('css')

    {!!Html::style("css/styles.css")!!}

    <!-- ================== BEGIN BASE JS ================== -->
    {!!Html::script("assets/plugins/pace/pace.min.js")!!}
    <!-- ================== END BASE JS ================== -->
</head>
<body>
    <!-- begin #page-loader -->
    <a id="page" data-url="{{ URL::to('/') }}"></a>
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-header-fixed page-sidebar-fixed">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="https://japammovil.com/" class="navbar-brand">
                        {{--<span class="navbar-logo">
                            <i class="ion-ios-cloud"></i>
                        </span>
                        <b>Color</b> Admin--}}
                        <img src="{{ URL::to('img/login/logotipo.png') }}" style="margin-left: -60px; margin-top: -15px;">
                    </a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->


            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->

        <!-- begin #sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile">
                        <div class="info">
                            JAPAM Móvil
                            <small>Portal Web</small>
                        </div>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav">
                    @include('layouts.app-user-menu')
                </ul>
                <!-- end sidebar nav -->
            </div>
        </div>
        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->

        <!-- begin #content -->
        <div id="content" class="content">
                @yield('content')
        </div>
        <!-- end #content -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->

<!-- JavaScripts -->
<!-- ================== BEGIN BASE JS ================== -->
{!!Html::script("assets/plugins/jquery/jquery-1.9.1.min.js")!!}
{!!Html::script("assets/plugins/jquery/jquery-migrate-1.1.0.min.js")!!}
{!!Html::script("assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js")!!}
{!!Html::script("assets/plugins/bootstrap/js/bootstrap.min.js")!!}
<!--[if lt IE 9]>
{!!Html::script("assets/crossbrowserjs/html5shiv.js")!!}
{!!Html::script("assets/crossbrowserjs/respond.min.js")!!}
{!!Html::script("assets/crossbrowserjs/excanvas.min.js")!!}
<![endif]-->
{!!Html::script("assets/plugins/slimscroll/jquery.slimscroll.min.js")!!}
{!!Html::script("assets/plugins/jquery-cookie/jquery.cookie.js")!!}
<!-- ================== END BASE JS ================== -->

@yield('footer')

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
{!!Html::script("assets/plugins/gritter/js/jquery.gritter.js")!!}
{!!Html::script("assets/js/apps.min.js")!!}
{!! Html::script('js/srpago/v1/srpago.min.js')  !!}
{!! Html::script('js/srpago/v1/srpago.encryption.min.js')  !!}


    <!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>

@yield('scripts')

<!-- for passing the jquery scripts of ticketit-->
</body>
</html>