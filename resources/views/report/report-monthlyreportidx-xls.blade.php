<table border="1">
    <thead>
    <tr style="text-align: center">
        <td colspan="7" style="text-align: center; border: 1px solid black">Report Monthly Login IDX</td>
    </tr>
    <tr style="text-align: center">
        <td colspan="7" style="text-align: center; border: 1px solid black">Filter by : {{ $tgl_awal }} - {{ $tgl_akhir }}</td>
    </tr>
    <tr>
        <th style="text-align: center; border: 1px solid black">No.</th>
        <th style="text-align: center; border: 1px solid black">Year Month</th>
        <th style="text-align: center; border: 1px solid black">Total Nasabah Login</th>
        <th style="text-align: center; border: 1px solid black">Nasabah Umum</th>
        <th style="text-align: center; border: 1px solid black">Nasabah Akademisi</th>
        <th style="text-align: center; border: 1px solid black">Nasabah Trial</th>
        <th style="text-align: center; border: 1px solid black">Sales / Internal</th>
    </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($monthlyloginidx as $month)
        <tr>
            <td style="border: 1px solid black" width="10">{{ $no++ }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->year_month }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->total_cust_login }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->cust_general }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->cust_academic }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->cust_trial }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->sales }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
