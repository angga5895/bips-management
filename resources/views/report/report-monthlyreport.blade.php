<table border="1">
    <thead>
    <tr style="text-align: center">
        <td colspan="5" style="text-align: center; border: 1px solid black">Report Monthly Login</td>
    </tr>
    <tr style="text-align: center">
        <td colspan="5" style="text-align: center; border: 1px solid black">Filter by : {{ $tgl_awal }} - {{ $tgl_akhir }}</td>
    </tr>
    <tr>
        <th style="text-align: center; border: 1px solid black">No.</th>
        <th style="text-align: center; border: 1px solid black">Year Month</th>
        <th style="text-align: center; border: 1px solid black">Web</th>
        <th style="text-align: center; border: 1px solid black">Mobile</th>
        <th style="text-align: center; border: 1px solid black">Web Mobile</th>
    </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($monthlyreport as $month)
        <tr>
            <td style="border: 1px solid black" width="10">{{ $no++ }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->year_month }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->web }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->mobile }}</td>
            <td style="border: 1px solid black" width="25">{{ $month->web_mobile }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
