<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>@yield('titulo', 'Aviomar')</title>


    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset("assets/$theme/images/tittle_logo.png") }}" />
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/bootstrap.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/font-awesome.css") }}" />

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace-fonts.css") }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace.css") }}" class="ace-main-stylesheet"
        id="main-ace-style" />

    <!-- ace settings handler -->
    <script src="{{ asset("assets/$theme/js/ace-extra.js") }}"></script>
    @yield('styles')
    <style>
        .navbar .navbar-brand {
            font-weight: bolder;
        }

        .navbar {
            background: linear-gradient(to bottom, #3f9fab 0%, #115963 100%);
        }

        .ace-nav>li>a {
            background-color: #2db5c800;
        }

        .ace-nav>li.light-blue>a:hover,
        .ace-nav>li.light-blue>a:focus,
        .ace-nav>li.open.light-blue>a {
            color: #ece861;
            background-color: #2db5c800;
        }

        .dropdown-menu.dropdown-close.dropdown-menu-right {
            left: auto;
            right: 1px;
            top: 29px;
        }

        .btn-link {
            color: #337ab7;
            font-weight: bold;
        }

        .dropdown-menu {
            background: blanchedalmond;
            border-radius: 6px !important;
            -webkit-box-shadow: 0 2px 4px rgb(0 0 0 / 20%);
            box-shadow: 0 2px 4px rgb(0 0 0 / 20%);
        }

        .no-skin .nav-list>li>a {
            background: linear-gradient(to bottom, #82af6f 0%, #2e4c21 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
        }

        .no-skin .nav-list>li:hover>a {
            background-color: #ffffff;
            color: #f4d67c;
        }

        .no-skin .nav-list>li.active>a,
        .no-skin .nav-list>li.active>a:hover,
        .no-skin .nav-list>li.active>a:focus {
            background: linear-gradient(to bottom, #307ecc 0%, #163350 100%);
            color: #ffffff;
        }

        .no-skin .nav-list li.active>a:after {
            border-right-color: #ff4700;
        }

        .no-skin .nav-list>li.active:after {
            border-color: #ff4700;
        }

        .no-skin .nav-list>li.open>a {
            background-color: #fafafa;
            color: #ffffff;
        }

        no-skin .nav-list>li:hover>a {
            background-color: #ffffff;
            color: #ffffff;
        }

        .no-skin .nav-list>li>a:focus {
            background-color: #f8f8f8;
            color: #f4d67c;
        }

        .no-skin .nav-list>li .submenu>li>a {
            border-top-color: #060202;
            background-color: rgb(255, 238, 169);
            color: #434348;
            font-weight: bold;
        }

        .no-skin .nav-list>li .submenu>li.active:not(.open)>a:hover {
            background: linear-gradient(to bottom, #ececec 0%, #a3a3a3 100%);
            color: #000000;
        }

        .no-skin .nav-list>li .submenu>li>a:hover {
            color: #000000;
            background: linear-gradient(to bottom, #ffffff 0%, #bbbaba 100%);
        }

        .no-skin .nav-list>li .submenu>li.active>a>.menu-icon {
            color: #ff4700;
        }

        .no-skin .nav-list>li .submenu>li.active:not(.open)>a {
            background: linear-gradient(to bottom, #ececec 0%, #a3a3a3 100%);
            color: #000000;
        }

        .no-skin .nav-list>li .submenu>li.active>a {
            color: #000000;
        }

        .footer.footer-fixed .footer-inner .footer-content {
            position: absolute;
            left: -1px;
            right: 0px;
            bottom: 0px;
            padding: 11px;
            line-height: 5px;
            background: linear-gradient(to bottom, #ffffff 0%, #8f8f8f 100%);
        }

        .se_exp {
            padding: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            margin: 3px 0;
            border: 1px solid #0a0a0a;
            background: white;
            width: 40%;
            margin-top: 12%;
            margin-left: 30%;
        }

    </style>
</head>

<body class="no-skin">
    <!--Inicio Header-->
    @include("theme/$theme/header")
    <!--Fin Header-->

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.loadState('main-container')
            } catch (e) {}
        </script>

        @if (Auth::check())
            <!--Inicio Aside-->
            @include("theme/$theme/aside")
            <!--Fin Aside-->
            <div class="main-content">
                <!-- Main content -->
                <section class="main-content-inner">
                    @yield('contenido')
                </section>
            </div>
            <!-- /.content -->
        @else
            <!-- Main content -->
            <div class="main-content">
                <section class="main-content-inner">
                    <div class="col-lg-12">
                        <div class="widget-box row se_exp">
                            <div class="center widget-user">
                                <h1>La sesion ha Expirado, por favor ingresar nuevamente</h1>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item no-border btn-link blue"
                                        class="ace-icon fa fa-power-off">
                                        <h2 class="">Iniciar Sesión</h2>
                                    </button>
                                </form>
                            </div>
                            <br>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content -->
        @endif
        @include('includes.modal_not')
        @include('includes.modal_estado2')
        @include('includes.modal_estado3')
        @include('includes.modal_estado4')
        @include('includes.modal_estado5')
        @include('includes.modal_estado8')
        @include('includes.modal_estado10')
        @include('includes.modal_estado11')
        @include('includes.modal_estado12')
        @include('includes.modal_estado13')
        @include('includes.modal_estado14')
        @include('includes.modal_estado15')
        @include('includes.modal_estado16')
        @include('includes.modal_estado17')
        @include('includes.modal_estado18')
        @include("
                                            theme/$theme/footer") </div>
                                            <!-- ./wrapper -->

                                            <!-- basic scripts -->

                                            <!--[if !IE]> -->
                                            <script src="{{ asset("assets/$theme/js/jquery.js") }}"></script>

                                            <!-- <![endif]-->

                                            <script type="text/javascript">
                                                if ('ontouchstart' in document.documentElement) document.write(
                                                    "<script src='{{ asset('assets/ace/js/jquery.mobile.custom.js') }}'>" + "<" + "/script>");
                                            </script>
                                            <script src="{{ asset("assets/$theme/js/bootstrap.js") }}"></script>

                                            <!-- page specific plugin scripts -->

                                            <!--[if lte IE 8]>
  <script src="{{ asset("assets/$theme/js/excanvas.js") }}"></script>
  <![endif]-->
                                            <script src="{{ asset("assets/$theme/js/jquery-ui.custom.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/jquery.ui.touch-punch.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/jquery.easypiechart.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/jquery.sparkline.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/flot/jquery.flot.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/flot/jquery.flot.pie.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/flot/jquery.flot.resize.js") }}"></script>

                                            <!-- ace scripts -->
                                            <script src="{{ asset("assets/$theme/js/ace/elements.scroller.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.colorpicker.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.fileinput.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.typeahead.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.wysiwyg.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.spinner.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.treeview.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.wizard.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/elements.aside.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.ajax-content.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.touch-drag.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.sidebar.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.sidebar-scroll-1.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.submenu-hover.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.widget-box.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.settings.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.settings-rtl.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.settings-skin.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.widget-on-reload.js") }}"></script>
                                            <script src="{{ asset("assets/$theme/js/ace/ace.searchbox-autocomplete.js") }}"></script>
                                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                                            @yield('scriptsPlugins')
                                            @yield('scripts')
                                            <script>
                                                $(document).ready(function() {
                                                    $("#modal-alert").modal("show");
                                                });

                                                $('#accordion-style').on('click', function(ev) {
                                                    var target = $('input', ev.target);
                                                    var which = parseInt(target.val());
                                                    if (which == 2) $('#accordion').addClass('accordion-style2');
                                                    else $('#accordion').removeClass('accordion-style2');
                                                });
                                            </script>
</body>

</html>
