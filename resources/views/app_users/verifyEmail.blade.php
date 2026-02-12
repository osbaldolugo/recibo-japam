<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$title}}</title>

        <!-- BEGIN BASE CSS STYLE -->
        {!!Html::style("assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css")!!}
        {!!Html::style("assets/plugins/bootstrap/css/bootstrap.min.css")!!}
        {!!Html::style("assets/plugins/font-awesome/css/font-awesome.min.css")!!}
        {!!Html::style("assets/plugins/ionicons/css/ionicons.min.css")!!}
        {!!Html::style("assets/css/animate.min.css")!!}
        {!!Html::style("assets/css/style.min.css")!!}
        {!!Html::style("assets/css/style-responsive.min.css")!!}
        {!!Html::style("assets/css/theme/default.css", ["id"=>"theme"])!!}
        <!-- END BASE CSS STYLE -->

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .success {
                color: #023BA6;
            }

            .error {
                color: #0996CC;
            }

            .container {
                text-align: center;
                vertical-align: middle;
            }

            .title {
                font-size: 40px;
                margin-bottom: 40px;
            }

            .body {
                font-size: 24px;
            }
            .image {
                margin: auto;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    @if($activado == 1)
                        <img src="{{URL::asset('img/email/imagen_1.png')}}" class="image img-responsive">
                        <div class="title">¡Cuenta Activada!</div>
                        <div class="border-default">
                            <p class="body sbold">{{$name}}, gracias por sumarte con nosotros <span style="color: #0aad2e;">#</span><span style="color: #013ca6;">acepta</span><span style="color: #0aad2e;">el</span><span style="color: #013ca6;">reto</span>.</p>
                        </div>
                        <p class="body">Ahora que has activado tu cuenta ya puedes iniciar sesión en <img style="display: inline-block !important; vertical-align: middle !important;" src="{{URL::asset('img/email/lg-logo.png')}}" width="105" height="55"> o en <a href="{{route('appUser.login.view')}}">www.japammovil.com</a></p>
                    @elseif($activado == 0)
                        <img src="{{URL::asset('img/email/mail_error.png')}}" class="image img-responsive">
                        <div class="title error">Hubo un problema al intentar activar su cuenta</div>
                        <div class="border-default error">
                            <p class="body sbold">La activación de la cuenta falló</p>
                            <p class="helper">Intente nuevamente activar su cuenta en unos momentos más.</p>
                        </div>
                    @elseif($activado == 2)
                        <img src="{{URL::asset('img/email/mail_error.png')}}" class="image img-responsive">
                        <div class="title error">Lo sentimos pero el código de activación que intenta usar no corresponde al de su cuenta</div>
                        <div class="border-default error">
                            <p class="body sbold">La activación de la cuenta falló</p>
                            <p class="helper">Para activar su cuenta asociada a JAPAM solo necesita seguir los pasos indicados en el correo de confirmación que fue enviado a su cuenta de correo.</p>
                        </div>
                    @else
                        <img src="{{URL::asset('img/email/mail_error.png')}}" class="image img-responsive">
                        <div class="title error">El código de activación que intenta usar no existe</div>
                        <div class="border-default error">
                            <p class="body sbold">La activación de la cuenta falló</p>
                            <p class="helper">Lo sentimos pero no podemos activar la cuenta sin su código asociado a la misma</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ================== BEGIN BASE JS ================== -->
        {!!Html::script("assets/plugins/jquery/jquery-1.9.1.min.js")!!}
        {!!Html::script("assets/plugins/jquery/jquery-migrate-1.1.0.min.js")!!}
        {!!Html::script("assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js")!!}
        {!!Html::script("assets/plugins/bootstrap/js/bootstrap.min.js")!!}
        {!!Html::script("assets/plugins/slimscroll/jquery.slimscroll.min.js")!!}
        {!!Html::script("assets/plugins/jquery-cookie/jquery.cookie.js")!!}
        <!-- ================== END BASE JS ================== -->

    </body>
</html>