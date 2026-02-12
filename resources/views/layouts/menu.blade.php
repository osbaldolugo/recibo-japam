    @if(\App\Models\Agent::isAdmin())
        <li class="nav-header"><i class="fa fa-anchor"></i> Administrador</li>
        <li class="{{ Request::is('admin/users/*') ? 'active' : '' }}">
            <a href="{!! route('admin.users') !!}">
                <i class="ion-person-stalker bg-gradient-black"></i>
                <span>Usuarios Internos</span>
            </a>
        </li>
    @endif

    <li class="nav-header"><i class="fa fa-bars"></i> Menú</li>

    <li class="has-sub {{ Request::is('mapping') ? 'active' : Request::is('mapping/app') ? 'active' : Request::is('home*') ? 'active' : ''}}">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="ion-arrow-graph-up-right bg-gradient-blue-dark"></i>
            <span>Dashboard</span>
        </a>
        <ul class="sub-menu">
            <li class="{{ Request::is('mapping') ? 'active' : '' }}">
                <a href="{!! route('mapping.index') !!}">
                    <i class="ion-map"></i>
                    <span>Mapa de Tickets</span>
                </a>
            </li>
            {{--<li class="{{ Request::is('mapping/app') ? 'active' : '' }}">
                <a href="{!! route('mapping.index_app') !!}">
                    <i class="ion-arrow-graph-up-right"></i>
                    <span>Mapa de Reportes</span>
                </a>
            </li>--}}
            <li class="{{ Request::is('home*') ? 'active' : '' }}">
                <a href="{!! url('/home') !!}">
                    <i class="ion-arrow-graph-up-right"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </li>

    {{--
    <li class="{{ Request::is('appUsers*') ? 'active' : '' }}">
        <a href="{!! route('appUsers.index') !!}">
            <i class="ion-ios-people bg-gradient-red"></i>
            <span>Usuarios Japam M&oacute;vil</span>
        </a>
    </li>
    --}}

    <li class="{{ Request::is('payControls*') ? 'active' : '' }}">
        <a href="{!! route('payControls.index') !!}">
            <i class="ion-ios-pricetag  bg-gradient-green-dark"></i>
            <span>Pagos Japam Móvil</span>
        </a>
    </li>
    <li class="{{ Request::is('notifications*') ? 'active' : '' }}">
        <a href="{!! route('notifications.index') !!}">
            <i class="ion-ios-chatbubble bg-gradient-red-orange"></i>
            <span>Notificaciones</span>
        </a>
    </li>
    <li class="{{ Request::is('appTickets*') ? 'active' : '' }}">
        <a href="{!! route('appTickets.index') !!}">
            <i class="ion-iphone bg-gradient-blue"></i>
            <span>Reportes y denuncias</span>
        </a>
    </li>
    <li class="{{ Request::is('complaints') ? 'active' : '' }}">
        <a href="{!! route('complaints.index', "queja") !!}">
            <i class="ion-android-mail bg-aqua-darker"></i>
            <span>Quejas</span>
        </a>
    </li>

    <li class="{{ Request::is('complaints/indexDate') ? 'active' : '' }}">
        <a href="{!! route('complaints.indexDate',"cita") !!}">
            <i class="ion-ios-calendar bg-aqua-darker"></i>
            <span>Petición de cita</span>
        </a>
    </li>

    <li class="{{ Request::is('tickets*') ? 'active' : ''  }}">
        <a href="{{ action('TicketsController@index') }}">
            <i class="fa fa-ticket bg-gradient-orange-dark text-white"></i>
            <span> Tiquets </span>
        </a>
    </li>
    
    <li class="{{ Request::is('japam*') ? 'active' : '' }}">
        <a href="{!! route('onclicks.metrics') !!}">
            <i class="ion-stats-bars bg-gradient-silver"></i>
            <span>Metricas Japam</span>
        </a>
    </li>

    <li class="has-sub {{ Request::is('pMOWorkTables*') ? 'active' : '' }}">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="ion-ios-briefcase bg-gradient-black"></i>
            <span>Gestión de Trabajos</span>
        </a>
        <ul class="sub-menu">
            <li class="{{ Request::is('pMOWorkTables') ? 'active' : '' }}">
                <a href="{!! route('pMOWorkTables.index') !!}">
                    <i class="fa fa-ticket p-r-5"></i>
                    <span>Tickets</span>
                </a>
            </li>
            <li class="{{ Request::is('pMOWorkTables/asignados') ? 'active' : '' }}">
                <a href="{!! route('pmoWorkTables.index_asignados') !!}">
                    <i class="fa fa-ticket p-r-5"></i>
                    <span>Ordenes Generadas</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-header f-s-12"><i class="ion-ios-book"></i> Catálogos</li>

    <li class="has-sub {{ Request::is('priorities*') ? 'active' : Request::is('incidents*') ? 'active' : Request::is('sector*') ? 'active' : Request::is('suburbs*') ? 'active' : ''  }}">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="fa fa-ticket bg-gradient-yellow"></i>
            <span>Ticket</span>
        </a>
        <ul class="sub-menu">
            <li class="f-s-12 {{ Request::is('priorities*') ? 'active' : '' }}">
                <a href="{!! route('priorities.index') !!}">
                    <i class="ion-levels p-r-5"></i>
                    <span>Prioridades</span>
                </a>
            </li>

            <li class="{{ Request::is('incidents*') ? 'active' : '' }}">
                <a href="{!! route('incidents.index') !!}">
                    <i class="ion-headphone"></i>
                    <span>Motivos de llamada</span>
                </a>
            </li>

            <li class="{{ Request::is('sector*') ? 'active' : '' }}">
                <a href="{!! route('sector.index') !!}">
                    <i class="ion-map"></i>
                    <span>Sector</span>
                </a>
            </li>
            <li class="{{ Request::is('suburbs*') ? 'active' : '' }}">
                <a href="{!! route('suburbs.index') !!}">
                    <i class="ion-ios-location"></i>
                    <span>Colonia</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="has-sub {{ Request::is('pMOWorks*') ? 'active' : Request::is('categories*') ? 'active' : Request::is('pMOEquipments*') ? 'active' : Request::is('pMOWorkTypes*') ? 'active' : Request::is('pMOMaterials*') ? 'active' : Request::is('pMOSpecialities*') ? 'active' : Request::is('pMOWorkers*') ? 'active' : ''  }}">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="ion-ios-briefcase bg-gradient-black"></i>
            <span>Ordenes de Trabajo</span>
        </a>
        <ul class="sub-menu">

            <li class="f-s-12 {{ Request::is('pMOWorks*') ? 'active' : '' }}">
                <a href="{!! route('pMOWorks.index') !!}">
                    <i class="ion-hammer p-r-5"></i>
                    <span>Trabajos</span>
                </a>
            </li>

            <li class="f-s-12 {{ Request::is('categories*') ? 'active' : '' }}">
                <a href="{!! route('categories.index') !!}">
                    <i class="ion-grid p-r-5"></i>
                    <span>Areas</span>
                </a>
            </li>

            <li class="f-s-12 {{ Request::is('pMOWorkTypes*') ? 'active' : '' }}">
                <a href="{!! route('pMOWorkTypes.index') !!}">
                    <i class="ion-settings p-r-5 "></i>
                    <span>Tipos de Trabajos</span>
                </a>
            </li>

            <li class="f-s-12 {{ Request::is('pMOEquipments*') ? 'active' : '' }}">
                <a href="{!! route('pMOEquipments.index') !!}">
                    <i class="ion-person-stalker p-r-5"></i>
                    <span>Equipos de Trabajos</span>
                </a>
            </li>

            <li class="f-s-12  {{ Request::is('pMOMaterials*') ? 'active' : '' }}">
                <a href="{!! route('pMOMaterials.index') !!}">
                    <i class="ion-cube p-r-5 "></i>
                    <span>Materiales</span>
                </a>
            </li>

            <li class="f-s-12 {{ Request::is('pMOSpecialities*') ? 'active' : '' }}">
                <a href="{!! route('pMOSpecialities.index') !!}">
                    <i class="ion-android-menu p-r-5"></i>
                    <span>Especialidades</span>
                </a>
            </li>

            <li class="f-s-12  {{ Request::is('pMOWorkers*') ? 'active' : '' }}">
                <a href="{!! route('pMOWorkers.index') !!}">
                    <i class="ion-android-walk p-r-5 "></i>
                    <span>Trabajadores</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="has-sub {{ Request::is('branchOffices') ? 'active' : Request::is('appSliderHomes*') ? 'active' : Request::is('appSettings*') ? 'active' : Request::is('peopleUnloggeds*') ? 'active' : ''}}">
        <a href="javascript:;">
            <b class="caret pull-right"></b>
            <i class="ion-wrench bg-gradient-green-light"></i>
            <span>Configuraci&oacute;n</span>
        </a>
        <ul class="sub-menu">
            <li class="{{ Request::is('branchOffices') ? 'active' : ''}}">
                <a href="{!! route('branchOffices.index') !!}">
                    <i class="ion-ios-location p-r-5"></i>
                    <span>Sucursales</span>
                </a>
            </li>

            <li class="{{ Request::is('appSliderHomes*') ? 'active' : '' }}">
                <a href="{!! route('appSliderHomes.index') !!}">
                    <i class="ion-images p-r-5"></i>
                    <span>Slider Home</span>
                </a>
            </li>

            <li class="{{ Request::is('appSettings*') ? 'active' : '' }}">
                <a href="{!! route('appSettings.index') !!}">
                    <i class="ion-power p-r-5"></i>
                    <span>Control de Pagos</span>
                </a>
            </li>

            <li class="{{ Request::is('peopleUnloggeds*') ? 'active' : '' }}">
                <a href="{!! route('peopleUnloggeds.index') !!}">
                    <i class="ion-ios-people "></i>
                    <span>Personas que denuncian</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- begin sidebar minify button -->
    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Ocultar</span></a></li>
    <!-- end sidebar minify button -->
