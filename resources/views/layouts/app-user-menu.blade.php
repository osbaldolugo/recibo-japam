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

<br>
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
    <!-- begin sidebar minify button -->
    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Ocultar</span></a></li>
    <!-- end sidebar minify button -->

