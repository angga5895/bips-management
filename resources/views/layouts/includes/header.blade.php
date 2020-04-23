<header class="main-header" id="header-adminlte">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>DX TRADE</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">DX TRADE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{--<img src="{{ url('adminlte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">--}}
                        <img src="{{ url('adminlte/dist/img/man.png') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ \Illuminate\Support\Facades\Auth::user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ url('adminlte/dist/img/man.png') }}" class="img-circle" alt="User Image">

                            <p>
                                {{ \Illuminate\Support\Facades\Auth::user()->username }} - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('home') }}" class="btn btn-default btn-flat"></a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    {{ __('Sign Out') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>