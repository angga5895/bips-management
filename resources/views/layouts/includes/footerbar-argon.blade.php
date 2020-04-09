<?php $routeName = Route::currentRouteName(); ?>
<!-- Footer -->
<footer class="footer">
    <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
                &copy; 2020 <a href="{{ url('/') }}" class="font-weight-bold ml-1"><b>Bahana</b></a>
            </div>
        </div>
        <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                <li class="nav-item {{ $routeName == 'assign' ? 'active' : '' }}">
                    <a href="{{ route('useradmin.user') }}" class="nav-link {{ $routeName == 'useradmin.user' ? 'active' : '' }}">Admin User</a>
                </li>
                {{--<li class="nav-item {{ $routeName == 'user.ganti-pass' ? 'active' : '' }}">
                    <a href="{{ route('user.ganti-pass') }}" class="nav-link {{ $routeName == 'user.ganti-pass' ? 'active' : '' }}">Ganti Password</a>
                </li>--}}
            </ul>
        </div>
    </div>
</footer>