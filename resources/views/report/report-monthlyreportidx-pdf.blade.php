<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    <style>
        table {
            font-family: arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            border-collapse: collapse;
            width: 100%;
            font-size: 12px!important;
        }

        tbody.lebar > tr > td {
            padding-top: 10px!important;
            padding-bottom: 10px!important;
        }

        td {
            border: 1px solid #0f0f0f;
            text-align: left;
            padding: 3px 8px;
        }

        th {
            border: 1px solid #0f0f0f;
            text-align: center;
            padding: 3px 8px;
        }

        table.noborder > tbody > tr > td {
            border: 1px solid #FFFFFF;
            text-align: left;
            padding: 2px 8px;
        }

        table.noborder > thead > tr > th {
            border: 1px solid #FFFFFF;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #FFFFFF;
        }

        .text-right {
            text-align: right!important;
        }

        .text-left {
            text-align: left!important;
        }

        .text-center {
            text-align: center!important;
        }

        .container{
            margin-left: 60px;
            margin-right: 40px;
        }
    </style>
</head>
<body>
<?php
        function tgl_indo_month($tanggal){
            $bulan = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'Nopember',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // variabel pecahkan 0 = tahun
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tanggal

            return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }

        function tgl_indo($tanggal){
            $bulan = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'Nopember',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // variabel pecahkan 0 = tahun
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tanggal

            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }

        function numberWithCommas($x){
            /*return number_format($x, 0, ".", ",");*/
            return number_format($x, 0, ".", ".");
        }

        function dateFormatMonth($x){
            //$date=date_create($x);
            return tgl_indo_month($x);
        }
?>
<div class="container">
    @php $i=1 @endphp
    @foreach($monthlyloginidx as $p)
        <table>
            <tbody>
            <tr>
                <td rowspan="2" class="text-center" width="90px">
                    <img src="{{ image_idx() }}" width="75px" alt="idx">
                </td>
                <td class="text-center" width="280px" style="font-size: 14px!important;">DIVISI PENDUKUNG PERDAGANGAN</td>
                <td width="110px">Nomor Dokumen : FORM-PSH-013-01</td>
                <td class="text-center">Halaman 1 dari 1</td>
            </tr>
            <tr>
                <td class="text-center" style="font-size: 14px!important;">FORMULIR LAPORAN BULANAN PENGGUNA AKSES DXTRADE REAL TIME</td>
                <td colspan="2">Versi: 3 <br/>Tanggal: 4 Agustus 2014</td>
            </tr>
            </tbody>
        </table>

        <br/>

        <table style="font-size: 13px!important;">
            <thead>
            <tr style="background-color: #0f0f0f">
                <th colspan="2" style="text-align: left!important; color: #FFFFFF!important;">Perusahaan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="background-color: #dddddd" width="175px">Nama</td>
                <td>PT. Bahana Sekuritas</td>
            </tr>
            <tr>
                <td style="background-color: #dddddd" width="175px">Alamat</td>
                <td>Gedung Graha CIMB Niaga <br/>Jln. Jend. Sudirman KAV 58 Lantai 19 <br/>Jakarta Selatan, 12910</td>
            </tr>
            </tbody>
            <thead>
            <tr style="background-color: #0f0f0f">
                <th colspan="2" style="text-align: left!important; color: #FFFFFF!important;">Kontak</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="background-color: #dddddd" width="175px">Nama</td>
                <td>Arif Soetiono</td>
            </tr>
            <tr>
                <td style="background-color: #dddddd" width="175px">Jabatan</td>
                <td>ICT Production Officer</td>
            </tr>
            <tr>
                <td style="background-color: #dddddd" width="175px">Telepon</td>
                <td>021 - 2505081 ext. 3194</td>
            </tr>
            <tr>
                <td style="background-color: #dddddd" width="175px">Fax</td>
                <td>021 - 2505087</td>
            </tr>
            <tr>
                <td style="background-color: #dddddd" width="175px">E-mail</td>
                <td>arif@bahana.co.id</td>
            </tr>
            </tbody>
        </table>

        <br/><br/>

        <div class="text-center" style="font-weight: bold">Periode Laporan {{ dateFormatMonth($p->year_month.'-01') }}</div>

        <br/><br/>

        <table style="font-size: 13px!important;">
            <thead>
            <tr style="background-color: #0f0f0f">
                <th style="color: #FFFFFF!important;">Jumlah Pengguna Akses DXTRADE Real Time</th>
                <th style="color: #FFFFFF!important;">Jumlah</th>
            </tr>
            </thead>
            <tbody class="lebar">
                <?php
                    $totalcustlogin = numberWithCommas($p->total_cust_login);
                    $custgeneral = numberWithCommas($p->cust_general);
                    $custacademic = numberWithCommas($p->cust_academic);
                    $custtrial = numberWithCommas($p->cust_trial);
                    $sales = numberWithCommas($p->sales);

                    $monthyears = dateFormatMonth($p->year_month.'-01');
                ?>
                <tr>
                    <td style="background-color: #dddddd" width="300px">Nasabah Umum</td>
                    <td>{{ $custgeneral }}</td>
                </tr>
                <tr>
                    <td style="background-color: #dddddd" width="300px">Nasabah Akademisi</td>
                    <td>{{ $custacademic }}</td>
                </tr>
                <tr>
                    <td style="background-color: #dddddd" width="300px">Nasabah Trial</td>
                    <td>{{ $custtrial }}</td>
                </tr>
                <tr>
                    <td style="background-color: #dddddd" width="300px">Sales / Internal</td>
                    <td>{{ $sales }}</td>
                </tr>
                <tr>
                    <td style="background-color: #dddddd" width="300px">Total Nasabah Login</td>
                    <td>{{ $totalcustlogin }}</td>
                </tr>
            </tbody>
        </table>

        <br/><br/>

        <div class="text-right" style="padding-left: 300px">
            <table class="text-left noborder" style="font-size: 13px!important;">
                <tbody>
                <tr>
                    <td width="50px">Tanggal: </td>
                    <td width="220px">&nbsp;&nbsp; {{ tgl_indo(date('Y-m-d')) }}<br/><hr/></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center" width="200px">
                        {{--<img src="{{ image_ttd() }}" alt="ttd">--}}
                        <div style="height: 54px!important;"></div><br/><hr/>
                    </td>
                </tr>
                <tr><td colspan="2"></td></tr>
                <tr>
                    <td width="50px">Nama: </td>
                    <td width="220px">&nbsp;&nbsp; Ade Heryanto<br/><hr/></td>
                </tr>
                <tr>
                    <td width="50px">Jabatan: </td>
                    <td width="220px">&nbsp;&nbsp; Head Of ICT<br/><hr/></td>
                </tr>
                </tbody>
            </table>
        </div>

        <br/><br/>

        <table style="font-size: 12px!important; text-align: justify!important;">
            <tbody>
                <tr>
                    <td>Mohon melengkapi formulir ini dan mengirim kembali kepada PT Bursa Efek Indonesia, Divisi Pendukung Perdagangan, Unit Pengelolaan dan Penyebaran Informasi Perdagangan, Gedung Bursa Efek Indonesia, Tower I, Jl. Jend. Sudirman Kav. 52-53, Jakarta 12190, Indonesia atau fax ke nomor 6221-5150102</td>
                </tr>
                <tr>
                    <td>Untuk informasi lebih lanjut, silahkan menghubungi nomor telepon 6221-5150515 ext. 2502/2505/2523/2509 atau e-mail ke idxdata@idx.co.id; website www.idx.co.id</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>

</body>
</html>
