<?php $routeName = Route::currentRouteName(); ?>
<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left bg-white navbar-expand-md" id="sidenav-main" style="z-index: 999;color: rgba(0, 0, 0, .5);">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ url('/') }}">
            {{--<img src="./assets/img/brand/blue.png" class="navbar-brand-img" alt="...">--}}
            <!-- mini logo for sidebar mini 50x50 pixels -->
            {{--<span class="logo-lg"><b>Bahana</b></span><br>--}}
                <img class="logo-dx" src="{{asset('/logo_bahana_dx_trade.png')}}"/>

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
                        <h6 class="text-overflow m-0"><b>DX TRADE</b></h6>
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
        <div class="collapse navbar-collapse " id="sidenav-collapse-main">
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
            <h6 class="navbar-heading text-muted">DXADMIN</h6>
            <!-- Divider -->
            {{--<hr class="my-0">--}}
            <!-- Navigation -->
            <ul class="navbar-nav navbar-dark">
                @foreach($clapp as $p)
                    @if($p->cla_module)
                        <?php $clappmodule = Illuminate\Support\Facades\DB::select
                        ('
                            SELECT cl_permission_app_mod.clp_role_app, cl_app_mod.*, cl_app.*, cl_module.* FROM cl_app_mod
                            LEFT JOIN cl_app ON cl_app.cla_id = cl_app_mod.clam_cla_id
                            LEFT JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            JOIN cl_permission_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                            JOIN role_app ON role_app.id = cl_permission_app_mod.clp_role_app
                            WHERE cl_app.cla_id = '.$p->cla_id.' AND cl_app_mod.clam_show = TRUE
                            AND cl_permission_app_mod.clp_role_app = '.$role_app.' ORDER BY cl_module.clm_order;
                        ')
                        ?>

                        <li class="nav-item {{ strpos($routeName, $p->cla_routename) !== false ? 'active' : '' }}">
                            <a class="nav-link {{ strpos($routeName, $p->cla_routename) !== false ? 'active' : '' }}" href="#{{ $p->cla_slug }}" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="{{ $p->cla_slug }}">
                                <i class="{{ $p->cla_icon }}"></i> {{ $p->cla_name }}
                            </a>
                            <div class="collapse {{ strpos($routeName, $p->cla_routename) !== false ? 'show' : '' }}" id="{{ $p->cla_slug }}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach($clappmodule as $r)
                                        <li class="nav-item">
                                            <a href="{{ url('/'.$r->clm_slug)}}" class="nav-link {{ strpos($routeName, $r->clm_routename) !== false ? 'menu-active' : '' }}">
                                                <span class="sidenav-normal"> {{ $r->clm_name }} </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        @if($p->cla_slug === 'empty')
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#modalNotAvailable">
                                    <i class="{{ $p->cla_icon }}"></i> {{ $p->cla_name }}
                                </a>
                            </li>
                        @else
                            <li class="nav-item {{ $routeName == $p->cla_routename ? 'active' : '' }}">
                                <a class="nav-link {{ $routeName == $p->cla_routename ? 'active' : '' }}" href="/{{ $p->cla_routename }}">
                                    <i class="{{ $p->cla_icon }}"></i> {{ $p->cla_name }}
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
