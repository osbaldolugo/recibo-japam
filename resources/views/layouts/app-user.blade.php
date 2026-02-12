<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JAPAM</title>
    <link rel="shortcut icon" href="{{url('img/icon_japam.png')}}">

    {!!Html::style("css/styles.css")!!}

<!-- ================== BEGIN BASE CSS STYLE ================== -->
    {!!Html::style("assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css")!!}
    {!!Html::style("assets/plugins/bootstrap/css/bootstrap.min.css")!!}
    {!!Html::style("assets/plugins/font-awesome/css/font-awesome.min.css")!!}
    {!!Html::style("assets/plugins/ionicons/css/ionicons.min.css")!!}
    {!!Html::style("assets/css/animate.min.css")!!}
    {!!Html::style("assets/css/style.min.css")!!}
    {!!Html::style("assets/css/style-responsive.min.css")!!}
    {!!Html::style("assets/css/theme/default.css", ["id"=>"theme"])!!}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
{!!Html::style("assets/plugins/jquery-jvectormap/jquery-jvectormap.css")!!}
{!!Html::style("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css")!!}
{!!Html::style("assets/plugins/gritter/css/jquery.gritter.css")!!}
<!-- ================== END PAGE LEVEL STYLE ================== -->

@yield('css')
<!-- ================== BEGIN BASE JS ================== -->
{!!Html::script("assets/plugins/pace/pace.min.js")!!}
<!-- ================== END BASE JS ================== -->

    <style type="text/css">

        #map { height: 100%; } /* Optional: Makes the sample page fill the window. */
        html, body { height: 100%; margin: 0; padding: 0; }
        .sidebar-nav li.active > a,
        .sidebar-nav li > a:focus {
            text-decoration: none;
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
        }

        .header {
            width: 100%;
            background: #e7e7e7;
            color: #fff;
            height: 50px;

        }
    </style>
</head>
<body id="app-layout">



<!--aqui -->
    <!-- begin #page-loader -->
    <a id="page" data-url="{{ URL::to('/') }}"></a>
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed ">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="https://japam.gob.mx/" class="navbar-brand">
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

                <!-- begin header navigation right -->

                {{--
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="user-image online">
                                <img src="{!! url('img/user.png') !!}" alt="" />
                            </span>
                            <span class="hidden-xs">{{ isset(Auth::guard('appuser')->user()->people->name)?Auth::guard('appuser')->user()->people->name:"" }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('appUser.logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ route('appUser.logout')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('appUser.userProfile') }}">Ver Perfil
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                --}}
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->

        @include('layouts.app-user-sidebar')
        <!-- begin #content1 -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
{{-- {!!Html::script("assets/plugins/jquery/jquery-1.9.1.min.js")!!} --}}
{!!Html::script("assets/plugins/jquery/jquery-migrate-1.1.0.min.js")!!}
{!!Html::script("assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js")!!}
{!!Html::script("assets/plugins/bootstrap/js/bootstrap.min.js")!!}
{!!Html::script("assets/plugins/slimscroll/jquery.slimscroll.min.js")!!}
{!!Html::script("assets/plugins/jquery-cookie/jquery.cookie.js")!!}
<!-- ================== END BASE JS ================== -->

@yield('footer')

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
{!!Html::script("assets/plugins/gritter/js/jquery.gritter.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.time.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.resize.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.pie.min.js")!!}
{!!Html::script("assets/plugins/sparkline/jquery.sparkline.js")!!}
{!!Html::script("assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js")!!}
{!!Html::script("assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js")!!}
{!!Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")!!}
{!!Html::script("assets/js/dashboard.min.js")!!}
{!!Html::script("assets/js/apps.min.js")!!}
{!! Html::script('js/srpago/v1/srpago.min.js')  !!}
{!! Html::script('js/srpago/v1/srpago.encryption.min.js')  !!}



    <!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        Dashboard.init();
    });
</script>
@yield('scripts')

<!-- for passing the jquery scripts of ticketit-->
</body>
</html>