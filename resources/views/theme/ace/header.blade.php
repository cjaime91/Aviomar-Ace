<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-buttons navbar-header pull-left">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.layout.brand -->
                <a href="#" class="navbar-brand nav-bar">
                    <i><img class="nav-user-photo" src="{{asset("assets/$theme/images/aviomar_sm.png")}}"></i>
                    Aviomar
                </a>
            </ul>
        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    @if (Auth::check())
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset("assets/$theme/avatars/user.jpg")}}"
                            alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Bienvenido,</small>
                            {{auth()->user()->nombre}} {{auth()->user()->apellidos}}
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    @endif

                    <ul
                        class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <!--<li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="profile.html">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>-->
                        <div class="center">
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item no-border btn-link blue"
                                    class="ace-icon fa fa-power-off">
                                    <div class="ace-icon fa fa-power-off"></div>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>