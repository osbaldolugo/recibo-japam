@extends('layouts.app')

@section('page', 'Lista de usuarios')

@section('content')
    <!-- begin error -->
    <div class="error">
        <div class="error-code m-b-10 text-primary">401 <i class="ion-android-warning"></i></div>
        <div class="error-content">
            <div class="error-message">No tiene permiso para acceder a esta sección.</div>
            <div class="error-desc m-b-20">
                No tienes permiso para acceder a la página a la que intentas ingresar.<br />
                Para poder ver el contenido de esta página necesita comunicarse con el administtrador del sistema.
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-primary"><i class="fa fa-home"></i> Volver a la Página Principal</a>
            </div>
        </div>
    </div>
    <!-- end error -->
@endsection