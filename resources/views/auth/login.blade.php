@extends('layouts.login')
@section('title', 'Iniciar sesión')
@section('content')
    <!-- begin login-header -->
    <div class="login-header">
        <div class="brand">
            <span class="logo"><i class="fa fa-tint text-info"></i></span> JAPAM
            <small>Ingrese sus credenciales para iniciar sesión</small>
        </div>
        <div class="icon">
            <i class="ion-ios-locked"></i>
        </div>
    </div>
    <!-- end login-header -->
    <!-- begin login-content -->
    <div class="login-content">
        <form action="{{ url('/login') }}" method="POST" class="form-horizontal" role="form">
            {!! csrf_field() !!}
            <!-- Si no tiene erorres es que todo bie-->
             @if ($success)
                    <span class="help-block">
                        <strong>Se ha registrado correctamente</strong>
                    </span>
            @endif
            <dif>{$success}</dif>
            <div class="form-group m-b-15{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group m-b-15{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control input-lg" name="password" placeholder="Password" />
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="checkbox m-b-30">
                <label>
                    <input type="checkbox" name="remember" /> Recordarme
                </label>
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Iniciar sesión</button>
            </div>
            <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                ¿Olvido su contraseña? Clic <a href="{{ url('/password/reset') }}">aquí</a> para restaurar su contraseña.
            </div>
            <hr />
            <p class="text-center">
                &copy; ISOTECH Todos los derechos reservados {{date('Y')}}
            </p>
        </form>
    </div>
    <!-- end login-content -->
@endsection