<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<div class="container">
    <table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Year Month</th>
        <th>Total Nasabah Login</th>
        <th>Nasabah Umum</th>
        <th>Nasabah Akademisi</th>
        <th>Nasabah Trial</th>
        <th>Sales / Internal</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($monthlyloginidx as $p)
        <tr>
            <td>{{ $i++ }}.</td>
            <td>{{$p->year_month}}</td>
            <td class="text-right">{{$p->total_cust_login}}</td>
            <td class="text-right">{{$p->cust_general}}</td>
            <td class="text-right">{{$p->cust_academic}}</td>
            <td class="text-right">{{$p->cust_trial}}</td>
            <td class="text-right">{{$p->sales}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

</body>
</html>
