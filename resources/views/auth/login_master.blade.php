<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Iniciar Sesión - Aviomar</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link rel="shortcut icon" href="{{ asset("assets/$theme/images/tittle_logo.png") }}" />
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/bootstrap.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/font-awesome.css") }}" />

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace-fonts.css") }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace.css") }}" />

    <!--[if lte IE 9]>
   <link rel="stylesheet" href="../assets/css/ace-part2.css")}}" />
  <![endif]-->
    <link rel="stylesheet" href="{{ asset("assets/$theme/css/ace-rtl.css") }}" />

    <style>
        img {
            padding-top: 25%;
            vertical-align: middle;
        }

        .login-layout .widget-box {
            background-color: #005965;
        }

    </style>
    <!--[if lte IE 9]>
  <link rel="stylesheet" href="../assets/css/ace-ie.css" />
  <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
  <script src="../assets/js/html5shiv.js"></script>
  <script src="../assets/js/respond.js"></script>
  <![endif]-->
</head>

<body class="login-layout blur-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <img src="{{ asset("assets/$theme/images/aviomar.png") }}">
                        </div>
                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-coffee green"></i>
                                            Iniciar Sesion
                                        </h4>

                                        <div class="space-6"></div>
                                        @if ($errors->any())
                                            <x-alert tipo="danger" :mensaje="$errors" />
                                        @endif
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Correo" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="Contraseña" />
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>

                                                <div class="space"></div>

                                                <div class="clearfix">
                                                    {{-- <label class="inline">
                                                        <input type="checkbox" class="ace" />
                                                        <span class="lbl">Recordarme</span>
                                                    </label> --}}

                                                    <button type="submit"
                                                        class="width-35 pull-right btn btn-sm btn-primary">
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="bigger-110">Ingresar</span>
                                                    </button>
                                                </div>

                                                <div class="space-4"></div>
                                            </fieldset>
                                        </form>
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar clearfix">
                                    {{--     <div>
                                            <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                Olvido la Contraseña?
                                            </a>
                                        </div>--}}

                                        <div>
                                            <a href="{{ route('register') }}" data-target="#signup-box"
                                                class="user-signup-link">
                                                Nuevo Usuario
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->

                            <div id="forgot-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header red lighter bigger">
                                            <i class="ace-icon fa fa-key"></i>
                                            Olvide mi Contraseña
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                            Ingrese el Correo para recibir las instrucciones
                                        </p>

                                        <form>
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="email" class="form-control"
                                                            placeholder="Correo" />
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <div class="clearfix">
                                                    <button type="button"
                                                        class="width-35 pull-right btn btn-sm btn-danger">
                                                        <i class="ace-icon fa fa-lightbulb-o"></i>
                                                        <span class="bigger-110">Enviar!</span>
                                                    </button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            Volver al Inicio de Sesión
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.forgot-box -->

                            <div id="signup-box" class="signup-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header green lighter bigger">
                                            <i class="ace-icon fa fa-users blue"></i>
                                            Registrar Nuevo Usuario
                                        </h4>

                                        <form action="{{ route('register') }}" method="post">
                                            @csrf
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" class="form-control" name="nombre"
                                                            placeholder="Nombres" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" class="form-control" name="apellidos"
                                                            placeholder="Apellidos" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" class="form-control" name="usuario"
                                                            placeholder="Usuario" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <select class="form-control select2bs4" style="width: 100%;"
                                                            id="rol_id" name="rol_id" required>
                                                            <option value="">--Seleccione--</option>
                                                            <option Value="1">Administrador</option>
                                                            <option Value="2">Ejecutivo Senior</option>
                                                            <option Value="3">Ejecutivo Junior</option>
                                                        </select>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="email" class="form-control" name="email"
                                                            placeholder="Correo" />
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="Contraseña" />
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" class="form-control"
                                                            name="password_confirmation"
                                                            placeholder="Repetir Contraseña" />
                                                        <i class="ace-icon fa fa-retweet"></i>
                                                    </span>
                                                </label>

                                                <div class="space-24"></div>

                                                <div class="clearfix">
                                                    <button type="reset" class="width-30 pull-left btn btn-sm">
                                                        <i class="ace-icon fa fa-refresh"></i>
                                                        <span class="bigger-110">Limpiar</span>
                                                    </button>

                                                    <button type="submit"
                                                        class="width-65 pull-right btn btn-sm btn-success">
                                                        <span class="bigger-110">Registrar</span>

                                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                    </button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            <i class="ace-icon fa fa-arrow-left"></i>
                                            Volver al Inicio de Sesión
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.signup-box -->
                        </div><!-- /.position-relative -->
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{ asset("assets/$theme/js/jquery.js") }}"></script>

    <!-- <![endif]-->

    <!--[if IE]>
<script src="../assets/js/jquery1x.js"></script>
<![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write(
            "<script src='{{ asset('assets/$theme/js/jquery.mobile.custom.js') }}''>" + "<" + "/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function($) {
            $(document).on('click', '.toolbar a[data-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible'); //hide others
                $(target).addClass('visible'); //show target
            });
        });

        //you don't need this, just used for changing background
        jQuery(function($) {
            $('#btn-login-dark').on('click', function(e) {
                $('body').attr('class', 'login-layout');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-light').on('click', function(e) {
                $('body').attr('class', 'login-layout light-login');
                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-blur').on('click', function(e) {
                $('body').attr('class', 'login-layout blur-login');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'light-blue');

                e.preventDefault();
            });

        });
    </script>
</body>

</html>
