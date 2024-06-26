<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-blue navbar-border-bottom" id="navbar-main">
    @if(isset($fullscreendashboard))
        <div class="h4 mb-0 text-white text-uppercase d-inline-block">
            <a class="navbar-brand pt-0" href="{{ url('/') }}">
            {{--<img src="./assets/img/brand/blue.png" class="navbar-brand-img" alt="...">--}}
            <!-- mini logo for sidebar mini 50x50 pixels -->
                {{--<span class="logo-lg"><b>Bahana</b></span><br>--}}
                <img width="55px" style="background: white; padding: 2.5px; border-radius: 10px" src="{{asset('/logo_bahana_dx_trade.png')}}"/>
            </a>
        </div>
        <div class="h4 mb-0 text-white text-uppercase d-inline-block">
            <button class="form-control-btn btn btn btn-secondary mb-1" onclick="getuseractivity();">
                <i class="fa fa-sync-alt"></i> Refresh</button>
        </div>
        <div class="h4 mb-0 text-white text-uppercase d-inline-block">
            <button class="form-control-btn btn btn btn-default disabled mb-1">
                <span class="text-nowrap date-now">Data taken at : <?php echo date('d M Y H:i:s')." WIB"?></span>
            </button>
        </div>
    @endif
    <div class="container-fluid" style="justify-content: flex-end!important;">
        <!-- Brand -->
        <div class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"></div>
        <!-- Form -->
        {{--<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div>
        </form>--}}
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                    {{--<img alt="Image placeholder" src="./assets/img/theme/team-4-800x800.jpg">--}}
                    <img src="{{ url('adminlte/dist/img/man.png') }}" class="user-image" alt="User Image">
                </span>
                        <div class="media-body ml-2 d-none d-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ \Illuminate\Support\Facades\Auth::user()->username }}</span>
                            <input type="hidden" value='{{ \Illuminate\Support\Facades\Auth::user()->role_app }}' id="role_app">
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0"><b>DX TRADE</b></h6>
                    </div>
                    {{--<a href="{{ url('/home') }}" class="dropdown-item">
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
    </div>
</nav>

<!-- Header -->
<div class="header navbar-blue pb-8 pt-5 pt-md-8"></div>
