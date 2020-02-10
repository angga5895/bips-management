<?php $routeName = Route::currentRouteName(); ?>
<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-dark bg-gradient-dark" id="sidenav-main" style="z-index: 999">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ url('/') }}">
            {{--<img src="./assets/img/brand/blue.png" class="navbar-brand-img" alt="...">--}}
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-lg"><b>Bahana</b></span>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            {{--<li class="nav-item dropdown">
                <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                {{--<img alt="Image placeholder" src="./assets/img/theme/team-1-800x800.jpg">--}}
                <img src="{{ url('adminlte/dist/img/man.png') }}" class="user-image" alt="User Image">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><b>Bahana</b></h6>
                    </div>
                    {{--<a href="{{ route('home') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>User Admin - {{ \Illuminate\Support\Facades\Auth::user()->username }}</span>
                    </a>--}}
                    {{--<a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>--}}
                    {{--<a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Activity</span>
                    </a>--}}
                    {{--<a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Support</span>
                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        <i class="ni ni-button-power"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse navbar-dark bg-gradient-dark" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ url('/') }}">
                            {{--<img src="./assets/img/brand/blue.png">--}}
                            <span class="logo-lg"><b>Bahana</b></span>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            {{--<form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>--}}

            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Dashboard</h6>
            <!-- Divider -->
            {{--<hr class="my-0">--}}
            <!-- Navigation -->
            <ul class="navbar-nav navbar-dark">
                <li class="nav-item {{ $routeName == 'home' || $routeName == 'group' || $routeName == 'user' || $routeName == 'user.edit' || $routeName == 'group.edit' || $routeName == '' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'home' || $routeName == 'group' || $routeName == 'user' || $routeName == 'user.edit' || $routeName == 'group.edit' || $routeName == '' ? 'active' : '' }}" href="#navbar-useradmin" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-useradmin">
                        <i class="ni ni-single-02 text-yellow"></i> User Admin
                    </a>
                    <div class="collapse show" id="navbar-useradmin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/home" class="nav-link {{ $routeName == 'home' || $routeName == '' ? 'menu-active' : '' }}">
                                    <span class="sidenav-normal"> Registrasi </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/group" class="nav-link {{ $routeName == 'group' || $routeName == 'group.edit' ? 'menu-active' : '' }}">
                                    <span class="sidenav-normal"> Group Management </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user" class="nav-link {{ $routeName == 'user' || $routeName == 'user.edit' ? 'menu-active' : '' }}">
                                    <span class="sidenav-normal"> User Management </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ $routeName == '' ? '' : '' }}">
                    <a class="nav-link {{ $routeName == '' ? '' : '' }}" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                        <i class="fa fa-laptop text-gray"></i> IT Admin
                    </a>
                </li>
                <li class="nav-item {{ $routeName == '' ? '' : '' }}">
                    <a class="nav-link {{ $routeName == '' ? '' : '' }}" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                        <i class="fa fa-asterisk text-primary"></i> Risk Management
                    </a>
                </li>
                <li class="nav-item {{ $routeName == '' ? '' : '' }}">
                    <a class="nav-link {{ $routeName == '' ? '' : '' }}" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                        <i class="ni ni-diamond text-danger"></i> Finance
                    </a>
                </li>
                <li class="nav-item {{ $routeName == '' ? '' : '' }}">
                    <a class="nav-link {{ $routeName == '' ? '' : '' }}" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                        <i class="ni ni-archive-2 text-light"></i> Custodian
                    </a>
                </li>
                <li class="nav-item {{ $routeName == '' ? '' : '' }}">
                    <a class="nav-link {{ $routeName == '' ? '' : '' }}" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                        <i class="fab fa-telegram text-success"></i> Call Center
                    </a>
                </li>
                {{--<li class="nav-item {{ $routeName == 'user.ganti-pass' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'user.ganti-pass' ? 'active' : '' }}" href="{{ route('user.ganti-pass') }}">
                        <i class="fa fa-user-lock text-warning"></i> Ganti Password
                    </a>
                </li>
                <li class="nav-item {{ $routeName == 'user.blog-saya' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-upgrade-history' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-add-new' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'user.blog-saya' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-upgrade-history' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-add-new' ? 'active' : '' }}" href="{{ route('user.blog-saya') }}">
                        <i class="fa fa-globe-americas text-info"></i> Blog Saya
                    </a>
                </li>
                <li class="nav-item {{ $routeName == 'user.beli-backlink' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'user.beli-backlink' ? 'active' : '' }}" href="{{ route('user.beli-backlink') }}">
                        <i class="fa fa-shopping-cart text-primary"></i> Beli Backlink
                    </a>
                </li>
                <li class="nav-item {{ $routeName == 'user.jual-backlink' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'user.jual-backlink' ? 'active' : '' }}" href="{{ route('user.jual-backlink') }}">
                        <i class="fa fa-hand-holding-usd text-green"></i> Jual Backlink
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-wallet text-light-blue"></i> Dompet Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-money-bill-alt text-green"></i> Setor Deposit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-money-bill text-primary"></i> Tarik Tunai
                    </a>
                </li>
                <li class="nav-item {{ $routeName == 'user.rekening-bank' ? 'active' : '' }}">
                    <a class="nav-link {{ $routeName == 'user.rekening-bank' ? 'active' : '' }}" href="{{ route('user.rekening-bank') }}">
                        <i class="fa fa-credit-card text-gray"></i> Rekening Bank
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-globe text-info"></i> Blog PBN
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-handshake text-dark"></i> Affiliasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form-1').submit();">
                        <i class="ni ni-button-power text-danger"></i> Keluar
                    </a>
                    <form id="logout-form-1" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>--}}
            </ul>
        </div>
    </div>
</nav>
