<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DX TRADE - {{ $title }}</title>
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
    <link href="{{ url('select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ url('bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ url('bootstrap-datepicker/bootstrap-datepicker.css') }}" rel="stylesheet" />
    @section('css')
    @show
</head>

<body>

<!-- Main content -->
<div class="main-content">

<!-- Page content -->
    <div class="container-fluid">
    @yield('styles')

    @yield('content')

    @yield('scripts')

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
<script type="text/javascript" charset="utf8"  src="{{ asset('jquery.dataTables.min.js') }}"></script>

{{--<script src="{{ asset('forms_pickers.js') }}"></script>--}}

@section('js')

@show
</body>

</html>