<li class="nav-header"><i class="fa fa-bars"></i> Menú</li>
  {{--  <li class="{{ Request::is('appUserCards*') ? 'active' : '' }}">
        <a href="{!! url('/appUserCards') !!}">
            <i class="fa fa-credit-card bg-green-darker"></i>
            <span>Mis Tarjetas</span>
        </a>
    </li> --}}

{{--<li class="">
    <a href="{{ route('japam.Home') }}">
        <i class="fa fa-home bg-gradient-pink"></i>
        <span>Home</span>
    </a>
</li> --}}
<ion-icon name="home-outline"></ion-icon>
<li class="{{ Request::is('receipts/searchGuest') ? 'active' : '' }}">
    <a href="{{ route('receipts.searchGuest') }}">
        <i class="fa fa-usd bg-blue"></i>
        <span>Pagar Recibo</span>
    </a>
</li>
@if(auth('appuser')->check())
    <li class="{{ Request::is('receipts') ? 'active' : '' }}">
        <a href="{!! route('receipts.indexWeb') !!}">
            <i class="fa fa-file-text bg-grey-darker"></i>
            <span>Mis Recibos</span>
        </a>
    </li>

    <li>
        <a href="{{ route('appUser.logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off bg-grey-darker"></i>
            <span>Cerrar Sesión</span>
        </a>
        <form id="logout-form" action="{{ route('appUser.logout')}}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
@endif

@if(!auth('appuser')->check())
    <li class="" >
        <a href="{{ route('appUser.login.view') }}"><i class="fa fa-arrow-circle-o-right fa-3x text-inverse bg-green"></i><span> Iniciar sesión</span></a>
    </li>

    <li class="" >
        <a href="{!! route('register') !!}"><i class="fa fa-3x fa-pencil-square text-inverse bg-aqua"></i><span> Registrarse</span></a>
    </li>

@endif
<br>
<li><span>&nbsp; &nbsp;Crear reporte por:</span></li>
<li class="">
    <a href="{!! route('falta.servicio') !!}">
        <i class="ion-alert text-inverse bg-orange"></i>
        <span>Falta de servicio</span>
    </a>
</li>
<li class="">
    <a href="{!! route('reporte.fuga') !!}">
        <i class="ion-wrench bg-black-darker"></i>
        <span>Fuga de agua</span>
    </a>
</li>
<li class="">
    <a href="{!! route('toma.clandestina') !!}">
        <i class="ion-hammer bg-yellow-lighter"></i>
        <span>Toma clandestina</span>
    </a>
</li>
<li class="{{ Request::is('complain*') ? 'active' : '' }}">
        <a href="{!! route('complain.create') !!}">
            <i class="fa fa-comment bg-grey-darker"></i>
            <span>Crear Queja</span>
        </a>
    </li>
<li>
    <hr>
</li>
{{--
    <li class="{{ Request::is('schedule*') ? 'active' : '' }}">
        <a href="{!! route('schedule.request') !!}">
            <i class="fa fa-calendar bg-aqua-darker"></i>
            <span>Solicitar cita</span>
        </a>
    </li>
--}}
    <!-- begin sidebar minify button -->
    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Ocultar</span></a></li>
    <!-- end sidebar minify button -->

