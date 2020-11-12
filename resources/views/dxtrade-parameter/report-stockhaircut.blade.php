<table>
    <tbody>
    @foreach($stockhaircutreport as $daily)
        <tr>
            <td>{{ $daily->stock_code }}</td>
            <td>{{ $daily->haircut }}</td>
            <td>{{ $daily->haircut_comite }}</td>
            <td>{{ $daily->hc1 }}</td>
            <td>{{ $daily->hc2 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
