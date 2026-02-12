@extends('layouts.app-user')
@section('title', 'Iniciar sesión')
@section('content')
    <!-- begin login-content -->
    <style>
    .content{
        padding: 3px;
        
    }
    .input-wrap{
        padding-right: 5%;
        padding-left: 5%;
        margin: 0 3px;
            margin-bottom: 0px;
        width: 100%;
        max-width: 582px;
        margin: 0 auto;
    }
    .btn-primary2{
        background:#71cae6;
    }
    </style>
    <div class="login-content">

        <form action="{{ url(route('appUser.login')) }}" method="POST" class="form-horizontal" role="form">
            {!! csrf_field() !!}
        <div class="col-md-2"></div>
        <div class="col-lg-7">
            <div class="card">
            <div style="background-color: #71cae6;" class="card-header">
               <p style="color: #ffffff;">Iniciar sesión</p>
            </div>
            <div style="padding-right: 5%; padding-left: 5%" class="input-wrap card-block  m-b-10 {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform:rotate(320deg) translate(2px,0px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M16.484 11.976l6.151-5.344v10.627zm-7.926.905l2.16 1.875c.339.288.781.462 1.264.462h.017h-.001h.014c.484 0 .926-.175 1.269-.465l-.003.002l2.16-1.875l6.566 5.639H1.995zM1.986 5.365h20.03l-9.621 8.356a.612.612 0 0 1-.38.132h-.014h.001h-.014a.61.61 0 0 1-.381-.133l.001.001zm-.621 1.266l6.15 5.344l-6.15 5.28zm21.6-2.441c-.24-.12-.522-.19-.821-.19H1.859a1.87 1.87 0 0 0-.835.197l.011-.005A1.856 1.856 0 0 0 0 5.855V18.027a1.86 1.86 0 0 0 1.858 1.858h20.283a1.86 1.86 0 0 0 1.858-1.858V5.859v-.004c0-.727-.419-1.357-1.029-1.66l-.011-.005z" fill="#043CA5 "/></svg> 
                    Correo<span class="text-danger">*</span></label>
                <input type="text" class=" form-control" placeholder="Correo Electr&oacute;nico" required name="email" value="{{ old('email') }}"/>
                @if ($errors->has('email'))
                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                @endif
            </div>
            <div style="padding-right: 5%; padding-left: 5%" class="input-wrap card-block m-b-10 {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(360deg) translateY(6px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path d="M12.5 8.5v-1a1 1 0 0 0-1-1h-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1m0-4h-4a2 2 0 1 0 0 4h4m0-4a2 2 0 1 1 0 4m-9-6v-3a3 3 0 0 1 6 0v3m2.5 4h1m-3 0h1m-3 0h1" stroke="#043CA5 "/></g></svg> 
                     Contraseña<span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Contrase&ntilde;a" required name="password" />
                @if ($errors->has('password'))
                    <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                @endif
            </div>
            <div style="max-width: 582px;margin: 0 auto;" class="card-block  checkbox m-b-10">
                <label>
                    <input type="checkbox" name="remember" /> Recordarme
                </label>
            </div>

            <div style="padding-right: 5%; padding-left: 5%" class="card-block login-buttons">
                <button style="max-width: 582px;margin: 0 auto;" type="submit" class="btn btn-primary2 btn-block btn-lg">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar sesión
                </button>
               {{-- <a href="{!! route('register') !!}" class="btn btn-secondary btn-block btn-lg">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Crear Cuenta
                </a>

                <a href="{!! route('receipts.searchGuest') !!}" class="btn btn-success btn-block btn-lg">
                    <i class="fa fa-dollar" aria-hidden="true"></i> Pagar Recibo
                </a> --}}
            </div>
            <hr>
            <div style="padding-right: 5%; padding-left: 5%" class="m-t-20 text-inverse">
                ¿Olvido su contraseña? Clic <a href="{{ url('/app-user/password/reset') }}">aquí</a> para restaurar su contraseña.
            </div>
            <hr>
                <div>
                    <p class="text-center">
                        <strong>Copyright © {!! date('Y') !!} <a target="_blank" href="https://japammovil.gob.mx/">JAPAM</a>.</strong> Todos los derechos reservados.

                    </p>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- end login-content -->
@endsection