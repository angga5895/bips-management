@extends('layouts.app-argon')

@section('content')
    <?php
    function tglIndonesia($str){
        $tr   = trim($str);
        //$str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
        $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), $tr);
        return $str;
    }
    ?>

    <div class="modal-ajax"></div>
    <div class="header text-white">
        <div class="row col-xs-0">
            <div class="col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb" class="d-inline-block ml-0 w-100">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-2">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Dashboards</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <div class="card-footer">
            <div class="text-muted text-tiny mt-1"><small class="font-weight-normal"><?php date_default_timezone_set('Asia/Jakarta'); echo tglIndonesia(date('D, d F Y')); ?></small></div>
        </div>
        <div class="card-body" style="min-height: 365px">
            <div id="alert-success-registrasi">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-single-02"></i></span>
                    <span class="alert-inner--text"><strong id="regisuser"></strong>: Welcome, {{ \Illuminate\Support\Facades\Auth::user()->username }}.</span>
                        <br/><br/>
                    <div>
                        This is, application web admin PT. Bahana Sekuritas.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
