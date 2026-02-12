@extends('layouts.login')
@section('title', 'Restaurar contraseña')
<!-- Main Content -->
@section('content')
    <!-- begin login-content -->
    <div class="row">
        <div class="col-lg-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="login-content">
        <form action="{{ url('/app-user/password/email') }}" method="POST" class="form-horizontal" role="form">
            {!! csrf_field() !!}
            <div class="form-group m-b-15{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div style="margin-top: 5%; text-align: center" class="col-md-12">
                <button style="border-radius: 6%" type="submit" class="btn btn-primary">Enviar enlace para restaurar contraseña</button>
            </div>

            <div style="margin-top: 10%; margin-bottom: 38%;" class="col-md-12">
                <div class="col-md-6">
                        <a style="" href="{!! route('appUser.login.view') !!}" class="btn btn-secondary"><i class="fa fa-chevron-left"></i> &nbsp;Iniciar sesión</a>
                </div>
            <!--<div class="col-md-6">
                    <a style="border-radius: 6%;" href="{{ route('receipts.searchGuest') }}" class="btn btn-success">Realiza tu pago&nbsp;<i class="fa fa-chevron-right"></i></a>
                </div>-->
            </div>

            <hr />

        </form>
         <div style="margin-bottom: 0%;">
            <p class="text-center">
                <strong>Copyright © {!! date('Y') !!} <a target="_blank" href="https://japammovil.gob.mx/">JAPAM</a>.</strong> Todos los derechos reservados.
            </p>
        </div>
    </div>
    <!-- end login-content -->
@endsection
