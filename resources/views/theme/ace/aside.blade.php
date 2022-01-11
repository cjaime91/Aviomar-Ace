<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script>
    <ul class="nav nav-list">
        <li class="{{ ! Route::is('Dashboard') ?: 'active' }}">
            <a href="{{route('Dashboard')}}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ ! Route::is('Reciprocidad') ?: 'active' }}">
            <a href="{{route('Reciprocidad')}}">
                <i class="menu-icon fa fa-balance-scale"></i>
                <span class="menu-text"> Reciprocidad</span>
            </a>
            <b class="arrow"></b>
        </li>
        
        {{--<li class="">
            <a href="{{route('prueba')}}" role="button" class="blue" data-toggle="modal">
        <i class="menu-icon fa fa-tachometer"></i>
        <span class="menu-text"> Prueba </span>
        </a>
        <b class="arrow"></b>
        </li>--}}

        <li class="{{ ! Route::is('cotizaciones_mn') ?: 'active open' }}
            {{ ! Route::is('cotizaciones_expo') ?: 'active open' }}
            {{ ! Route::is('cotizaciones_impo') ?: 'active open' }} 
            {{ ! Route::is('crear_cotizacion') ?: 'active open' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-tasks"></i>
                <span class="menu-text">
                    Cotizaciones
                </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="{{ ! Route::is('cotizaciones_mn') ?: 'active' }}">
                    <a href="{{route('cotizaciones_mn')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Mercado Natural
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ ! Route::is('cotizaciones_expo') ?: 'active' }}">
                    <a href="{{route('cotizaciones_expo')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Agentes Exportación
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ ! Route::is('cotizaciones_impo') ?: 'active' }}">
                    <a href="{{route('cotizaciones_impo')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Agentes Importación
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ ! Route::is('crear_cotizacion') ?: 'active' }}">
                    <a href="{{route('crear_cotizacion')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Crear Cotización
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li class="{{ ! Route::is('agentes') ?: 'active open' }} {{ ! Route::is('crear_agente') ?: 'active' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-users"></i>
                <span class="menu-text"> Agentes </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="{{ ! Route::is('agentes') ?: 'active' }}">
                    <a href="{{route('agentes')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Listado
                    </a>

                    <b class="arrow"></b>
                </li>

                @if (auth()->user()->rol_id==2||auth()->user()->rol_id==1)

                <li class="{{ ! Route::is('crear_agente') ?: 'active' }}">
                    <a href="{{route('crear_agente')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Crear
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif

            </ul>
        </li>
        <li class="{{ ! Route::is('reporte_menaje') ?: 'active' }}">
            <a href="{{route('reporte_menaje')}}"> 
                <i class="menu-icon fa fa-area-chart"></i>
                <span class="menu-text"> Reportes </span>
            </a>
            <b class="arrow"></b>
        </li>
    </ul><!-- /.nav-list -->

    <!-- /section:basics/sidebar.layout.minimize -->
</div>