<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">

    <link rel="apple-touch-icon" sizes="57x57" href="{{url('favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{url('favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('favicon/favicon-16x16.png')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="%PUBLIC_URL%/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>DX TRADE ADMIN - {{ $title }}</title>
    <!-- Favicon -->
    {{--<link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">--}}
    {{--<link rel="icon" type="image/png" href="{{ url('adminlte/dist/img/p.png') }}">--}}
    <!-- Fonts -->
    <link href="{{ asset('fonts.googleapis.css') }}" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ url('argon/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ url('argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ url('argon/css/argon.css?v=1.0.0') }}" rel="stylesheet">

    <link href="{{ asset('dataTables.min.css') }}" type="text/css" rel="stylesheet">

    <link href="{{ asset('App.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ url('select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ url('bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ url('bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ url('bootstrap-sweetalert/bootstrap-sweetalert.css') }}" rel="stylesheet" />
    <style>
        .modal-ajax {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('{{ asset('/pIkfp.gif') }}')
            50% 50%
            no-repeat;
        }
    </style>
    @section('css')
    @show
</head>

<body>
<!-- Sidenav -->
@if(!isset($fullscreendashboard))
@include('layouts.includes.sidebar-argon')
@endif

<!-- Main content -->
<div class="main-content">
    <!-- Top navbar / sidenav -->
    @include('layouts.includes.navbar-argon')

    <!-- Page content -->
    <div class="container-fluid mt--9">
        @yield('styles')

        @yield('content')

        @yield('scripts')

        <!-- Footer -->
        @include('layouts.includes.footerbar-argon')
    </div>

    <!-- Modal Not Available -->
    <div class="modal fade" id="modalNotAvailable" tabindex="-1" role="dialog" aria-labelledby="modalNotAvailableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-danger text-lighter">
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-notification-70 ni-3x"></i>
                        <h1 class="mt-4">Upss..!</h1>
                        <p>Sorry, this page is not available right now.</p>
                        <p>Please visit later.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Gagal -->
    <div class="modal fade" id="modalGagal" tabindex="-1" role="dialog" aria-labelledby="modalGagalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-gray text-lighter">
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <h1 class="mt-4">Please Input Group Before.</h1>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Argon Scripts -->

<!-- Core -->
<script src="{{ url('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- Optional JS -->
<script src="{{ url('argon/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ url('argon/vendor/chart.js/dist/Chart.extension.js') }}"></script>
<!-- Argon JS -->
<script src="{{ url('argon/js/argon.js?v=1.0.0') }}"></script>

<script src="{{ url('select2/select2.min.js') }}"></script>
<script src="{{ url('bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('bootstrap-sweetalert/bootstrap-sweetalert.js') }}"></script>
<script type="text/javascript" charset="utf8"  src="{{ asset('jquery.dataTables.min.js') }}"></script>

{{--<script src="{{ asset('forms_pickers.js') }}"></script>--}}
<script src="{{ asset('layout_mockJax.js') }}"></script>

<script src="{{ url('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('jquery-validation-1.19.1/dist/jquery.validate.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $('.js-example-basic-single').select2({
        placeholder: '-- pilih beberapa kategori --'
    });
</script>

<script>
    window.onscroll = function () {myHeaderFixed()};

    var header = document.getElementById("navbar-main");

    var sticky = header.offsetTop;

    function myHeaderFixed() {
        if (window.pageYOffset > sticky){
            header.classList.add("sticky-navbar");
        } else {
            header.classList.remove("sticky-navbar");
        }
    }
</script>

@section('js')

@show
</body>

</html>
