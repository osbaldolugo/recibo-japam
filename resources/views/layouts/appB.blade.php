<!DOCTYPE html>
<html lang="en">
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

        .barra_azul{
            padding: 23px;
            font-size: 1.5em;background-image:  linear-gradient(180deg,#013ca6 59%,#0898d5 100%); border-radius: 15px 15px 15px 15px; overflow: hidden;
        }
        .padding-imagenes{
            padding-left: 4vw;
        }
    </style>
</head>
<body id="app-layout">




<!-- begin #page-loader -->
<a id="page" data-url="{{ URL::to('/') }}"></a>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

    <!-- begin #content -->
    <div id="content" class="">



        @yield('content')

    </div>
    <!-- end #content1 -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->


<!-- JavaScripts aqui -->
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
{!!Html::script("assets/plugins/flot/jquery.flot.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.time.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.resize.min.js")!!}
{!!Html::script("assets/plugins/flot/jquery.flot.pie.min.js")!!}
{!!Html::script("assets/plugins/sparkline/jquery.sparkline.js")!!}
{!!Html::script("assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js")!!}
{!!Html::script("assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js")!!}
{!!Html::script("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")!!}
{!!Html::script("assets/plugins/bootbox-master/bootbox.js")!!}
{!!Html::script("assets/js/dashboard.min.js")!!}
{!!Html::script("assets/js/apps.min.js")!!}

{!!Html::script("js/app_vue.js")!!}

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
</html>/