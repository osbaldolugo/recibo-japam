@extends('layouts.login')
@section('title', 'Restaurar contraseña')
<!-- Main Content -->
@section('content')
    <!-- begin login-header -->
    <div class="login-header">
        <div class="brand">
            <span class="logo"><i class="fa fa-tint text-info"></i></span> JAPAM
            <small>Restablecer su contraseña</small>
        </div>
        <div class="icon">
            <i class="ion-ios-locked"></i>
        </div>
    </div>
    <!-- end login-header -->
    <!-- begin login-content -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="login-content">
        <form action="{{ url('/password/email') }}" method="POST" class="form-horizontal" role="form">
            {!! csrf_field() !!}
            <div class="form-group m-b-15{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="login-buttons">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Enviar enlace para restaurar contraseña</button>
            </div>
            <hr />
            <p class="text-center">
               <strong>Copyright © {!! date('Y') !!} <a target="_blank" href="https://japam.gob.mx/">JAPAM</a>.</strong> Todos los derechos reservados.
            </p>
        </form>
    </div>
    <!-- end login-content -->
@endsection
