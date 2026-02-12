
@extends('layouts.login')
@section('title', 'Restaurar Contraseña')
<!-- Main Content -->
@section('content')
    <!-- begin login-header -->
    <div class="login-header">
        <div class="brand">
             JAPAM
            <small>Restablecer Contraseña</small>
        </div>
        <div class="icon">
            <i class="ion-ios-locked"></i>
        </div>
    </div>
    <!-- end login-header -->
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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/app-user/password/reset') }}">
                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                   

                    <div class="col-md-12">
                        <label class="control-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <label class=" control-label">Contraseña</label>
                        <input type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <label class="control-label">Confirmar Contraseña</label>
                        
                        <input type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-refresh"></i>Reestablecer
                        </button>
                    </div>
                </div>
            </form>
    </div>

    <!-- end login-content -->
@endsection





