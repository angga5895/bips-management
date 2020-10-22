<?php $routeName = Route::currentRouteName(); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('adminlte/dist/img/man.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ \Illuminate\Support\Facades\Auth::user()->username }}</p>
                <a href="{{ route('home') }}" class="active"><i class="fa fa-user text-success"></i> User Admin</a>
            </div>
        </div>
        <!-- search form -->
        {{--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>--}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">DXADMIN</li>
            {{--<li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>--}}
            <li class="{{ $routeName == 'home' ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="fa fa-unlock-alt"></i>
                    <span>User Admin</span>
                </a>
            </li>
            {{--<li class="{{ $routeName == 'user.blog-saya' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-upgrade-history' ? 'active' : '' ||
                        $routeName == 'user.blog-saya-add-new' ? 'active' : '' }}">
                <a href="{{ route('user.blog-saya') }}">
                    <i class="fa fa-globe"></i>
                    <span>Blog Saya</span>
                </a>
            </li>
            <li class="{{ $routeName == 'user.beli-backlink' ? 'active' : '' }}">
                <a href="{{ route('user.beli-backlink') }}">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Beli Backlink</span>
                </a>
            </li>
            <li class="{{ $routeName == 'user.jual-backlink' ? 'active' : '' }}">
                <a href="{{ route('user.jual-backlink') }}">
                    <i class="fa fa-hand-grab-o"></i>
                    <span>Jual Backlink</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-suitcase"></i>
                    <span>Dompet Saya</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Setor Deposit</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-credit-card-alt"></i>
                    <span>Tarik Tunai</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-credit-card"></i>
                    <span>Rekening Bank</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-globe"></i>
                    <span>Blog PBN</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-link"></i>
                    <span>Affiliasi</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-off"></i>
                    <span>Keluar</span>
                </a>
            </li>--}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
