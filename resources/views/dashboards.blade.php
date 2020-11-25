@extends('layouts.app-argon')

@section('css')
    <link rel="stylesheet" href="{{ url('chart/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ url('bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
@endsection

@section('js')
    <!-- Dependencies -->
    <script src="{{ url('chart/eve/eve.js') }}"></script>
    <script src="{{ url('chart/raphael/raphael.js') }}"></script>
    <script src="{{ url('chart/morris/morris.js') }}"></script>
    <script src="{{ url('chart/chartjs/chartjs.js') }}"></script>
    <script src="{{ url('chart/chartjs/chartjs-plugin-label.js') }}"></script>

    <script src="{{ url('moment/moment.js') }}"></script>
    <script src="{{ url('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ url('bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

    <script src="{{ url('forms_pickers.js') }}"></script>
    <script type="text/javascript">
        var chartBar = 0;
        var barshow1 = 0;
        var barshow2 = 0;
        var barshow3 = 0;
        var barshow4 = 0;

        function appendLeadingZeroes(n){
            if(n <= 9){
                return "0" + n;
            }
            return n
        }

        function getDateBipsShort(tanggal){
            var datetime = tanggal.split(" ");
            var tgl = datetime[0].split("-");

            var year = tgl[0];

            if (tgl[1] == '01' ||tgl[1] == '1'){
                var month = 'Jan';
            } else if (tgl[1] == '02' ||tgl[1] == '2'){
                var month = 'Feb';
            } else if (tgl[1] == '03' ||tgl[1] == '3'){
                var month = 'Mar';
            } else if (tgl[1] == '04' ||tgl[1] == '4'){
                var month = 'Apr';
            } else if (tgl[1] == '05' ||tgl[1] == '5'){
                var month = 'Mei';
            } else if (tgl[1] == '06' ||tgl[1] == '6'){
                var month = 'Jun';
            } else if (tgl[1] == '07' ||tgl[1] == '7'){
                var month = 'Jul';
            } else if (tgl[1] == '08' ||tgl[1] == '8'){
                var month = 'Aug';
            } else if (tgl[1] == '09' ||tgl[1] == '9'){
                var month = 'Sep';
            } else if (tgl[1] == '10'){
                var month = 'Oct';
            } else if (tgl[1] == '11'){
                var month = 'Nov';
            } else if (tgl[1] == '12'){
                var month = 'Dec';
            }

            var date = tgl[2];

            return date+" "+month+" "+year;
        }

        function rgb2hex(rgb){
            rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
            return (rgb && rgb.length === 4) ? "#" +
                ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
                ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
        }

        function clickLegendBar(theese) {
            var idlgnd = $(theese).attr('id');
            if (idlgnd === 'barlgnd0'){
                barshow1 ++
                if (barshow1%2 === 0){
                    $("#barlgnd0").css('color', rgb2hex($("#barlgnd0").css('color')).substr(0,7));
                } else {
                    $("#barlgnd0").css('color', rgb2hex($("#barlgnd0").css('color'))+'40');
                }
            } else if(idlgnd === 'barlgnd1'){
                barshow2++
                if (barshow2%2 === 0){
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color')).substr(0,7));
                } else {
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color'))+'40');
                }
            } else if(idlgnd === 'barlgnd2'){
                barshow3++
                if (barshow3%2 === 0){
                    $("#barlgnd2").css('color', rgb2hex($("#barlgnd2").css('color')).substr(0,7));
                } else {
                    $("#barlgnd2").css('color', rgb2hex($("#barlgnd2").css('color'))+'40');
                }
            } else {
                barshow4++
                if (barshow4%2 === 0){
                    $("#barlgnd3").css('color', rgb2hex($("#barlgnd3").css('color')).substr(0,7));
                } else {
                    $("#barlgnd3").css('color', rgb2hex($("#barlgnd3").css('color'))+'40');
                }
            }
            getuseractivity();
        }

        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
            getuseractivity();
            tablegetTopTrade();
            changeTypeCust();
            setInterval(function(){
                getuseractivity();
                $('#table-toptrade').DataTable().ajax.reload();
            }, 120000);
        });

        function changeTypeCust() {
            var tabletype = $("#tableType").val();

            if (tabletype === '1'){
                $("#title-label").text('Sales');
                $("#usercode-label").text('Sales ID');
                $("#username-label").text('Sales Name');
                $("#total-label").text('Total Val');
            } else {
                $("#title-label").text('Customer');
                $("#usercode-label").text('Custcode');
                $("#username-label").text('Custame');
                $("#total-label").text('Trade Val');
            }
            $('#table-toptrade').DataTable().ajax.reload();
        }

        function tablegetTopTrade() {
            var tableData = $("#table-toptrade").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
                aaSorting: [[3, 'desc']],
                bPaginate: false,
                bInfo: false,
                ajax : {
                    url: '{{ url("toptrade-get") }}',
                    data: function (d) {
                        var search_data = {
                            tableType:$("#tableType").val()
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_code', name: 'user_code'},
                    {data : 'user_code', name: 'user_code'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'total_val', name: 'total_val'},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : true,
                    orderable:false,
                    render : function (data, type, row, index) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [1],
                    searchable : true,
                    orderable:false,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [2],
                    searchable : true,
                    orderable:false,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [3],
                    searchable : true,
                    orderable:false,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: right; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(Number(data))+'</div>';
                    }
                }]
            });

            tableData.on( 'order.dt search.dt', function () {
                tableData.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function changePie() {
            var type = $("#piechartType").val();

            if (type === '1'){
                $("#pie-trade").removeClass('d-none');
                $("#pie-order").addClass('d-none');
            } else {
                $("#pie-order").removeClass('d-none');
                $("#pie-trade").addClass('d-none');
            }

            getuseractivity();
            setTimeout(function () {
                getuseractivity();
            },100)
        }

        function getuseractivity() {
            $.ajax({
                type    : "GET",
                url     : "{{url('countuseractivity-get')}}",
                success : function (res){
                    $("#morrisjs-bars").empty();
                    if ($.trim(res)) {
                        $('.date-now').text(res.user_activity[0].now_date);

                        if (res.user_activity.length > 0){
                            $("#cnt_web").text(numberWithCommas(Number(res.user_activity[0].cnt_web)));
                            $("#cnt_mobile").text(numberWithCommas(Number(res.user_activity[0].cnt_mobile)));
                            $("#cnt_web_mobile").text(numberWithCommas(Number(res.user_activity[0].cnt_web_mobile)));
                            $("#cnt_pc").text(numberWithCommas(Number(res.user_activity[0].cnt_pc)));
                        }

                        if (res.sum_trade.length > 0){
                            $("#sum_web_trade").text(numberWithCommas(Number(res.sum_trade[0].sum_web_trade)));
                            $("#sum_mobile_trade").text(numberWithCommas(Number(res.sum_trade[0].sum_mobile_trade)));
                            $("#sum_dealer_trade").text(numberWithCommas(Number(res.sum_trade[0].sum_dealer_trade)));
                            $("#sum_trade_all").text(numberWithCommas(Number(res.sum_trade[0].sum_trade_all)));
                        }

                        if (res.sum_order.length > 0){
                            $("#sum_web_order").text(numberWithCommas(Number(res.sum_order[0].sum_web_order)));
                            $("#sum_mobile_order").text(numberWithCommas(Number(res.sum_order[0].sum_mobile_order)));
                            $("#sum_dealer_order").text(numberWithCommas(Number(res.sum_order[0].sum_dealer_order)));
                            $("#sum_order_all").text(numberWithCommas(Number(res.sum_order[0].sum_order_all)));
                        }

                        if (res.orders.length > 0) {
                            $("#cnt_orders").text(numberWithCommas(Number(res.orders[0].cnt_orders)));
                        }

                        if (res.trades.length > 0) {
                            $("#cnt_trades").text(numberWithCommas(Number(res.trades[0].cnt_trades)));
                        }

                        if (res.number_order.length > 0){
                            $("#cnt_web_order").text(numberWithCommas(Number(res.number_order[0].cnt_web_order)));
                            $("#cnt_mobile_order").text(numberWithCommas(Number(res.number_order[0].cnt_mobile_order)));
                            $("#cnt_dealer_order").text(numberWithCommas(Number(res.number_order[0].cnt_dealer_order)));
                        }

                        var piechrt1 = 0;
                        var piechrt2 = 0;
                        var piechrt3 = 0;

                        if (res.sum_trade.length > 0){
                            piechrt1 = Number(res.sum_trade[0].sum_web_trade);
                            piechrt2 = Number(res.sum_trade[0].sum_mobile_trade);
                            piechrt3 = Number(res.sum_trade[0].sum_dealer_trade);
                        }

                        //chartjs
                        var chart6 = new Chart(document.getElementById('statistics-chart-6').getContext("2d"), {
                            type: 'pie',
                            data: {
                                labels: ['WEB', 'MOBILE', 'DEALER'],
                                datasets: [{
                                    data: [piechrt1,piechrt2,piechrt3],
                                    backgroundColor: ['rgba(99,125,138,0.5)', 'rgba(28,151,244,0.5)', 'rgba(2,188,119,0.5)'],
                                    borderColor: ['#647c8a', '#2196f3', '#02bc77'],
                                    hoverBackgroundColor: ['#647c8a', '#2196f3', '#02bc77'],
                                    borderWidth: 1
                                }]
                            },

                            options: {
                                scales: {
                                    xAxes: [{
                                        display: false,
                                    }],
                                    yAxes: [{
                                        display: false
                                    }]
                                },
                                legend: {
                                    position: 'right',
                                    labels: {
                                        boxWidth: 12
                                    }
                                },
                                responsive: false,
                                maintainAspectRatio: false,
                                tooltips: {
                                    callbacks: {
                                        title: function (tooltipItem, data) {
                                            return data['labels'][tooltipItem[0]['index']];
                                        },
                                        label: function (tooltipItem, data) {
                                            return numberWithCommas(data['datasets'][0]['data'][tooltipItem['index']]);
                                        }
                                    },
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: ['white', 'white', 'white'],
                                        precision: 2
                                    }
                                },
                            }
                        });
                        chart6.resize();

                        var opiechrt1 = 0;
                        var opiechrt2 = 0;
                        var opiechrt3 = 0;

                        if (res.sum_order.length > 0){
                            opiechrt1 = Number(res.sum_order[0].sum_web_order);
                            opiechrt2 = Number(res.sum_order[0].sum_mobile_order);
                            opiechrt3 = Number(res.sum_order[0].sum_dealer_order);
                        }

                        var chart5 = new Chart(document.getElementById('statistics-chart-5').getContext("2d"), {
                            type: 'pie',
                            data: {
                                labels: ['WEB', 'MOBILE', 'DEALER'],
                                datasets: [{
                                    data: [opiechrt1,opiechrt2,opiechrt3],
                                    backgroundColor: ['rgba(99,125,138,0.5)', 'rgba(28,151,244,0.5)', 'rgba(2,188,119,0.5)'],
                                    borderColor: ['#647c8a', '#2196f3', '#02bc77'],
                                    hoverBackgroundColor: ['#647c8a', '#2196f3', '#02bc77'],
                                    borderWidth: 1
                                }]
                            },

                            options: {
                                scales: {
                                    xAxes: [{
                                        display: false,
                                    }],
                                    yAxes: [{
                                        display: false
                                    }]
                                },
                                legend: {
                                    position: 'right',
                                    labels: {
                                        boxWidth: 12
                                    }
                                },
                                responsive: false,
                                maintainAspectRatio: false,
                                tooltips: {
                                    callbacks: {
                                        title: function (tooltipItem, data) {
                                            return data['labels'][tooltipItem[0]['index']];
                                        },
                                        label: function (tooltipItem, data) {
                                            return numberWithCommas(data['datasets'][0]['data'][tooltipItem['index']]);
                                        }
                                    },
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: ['white', 'white', 'white'],
                                        precision: 2
                                    }
                                },
                            }
                        });
                        chart5.resize();

                        $("#morrisjs-bars").removeClass('chart-empty');
                        $("#morrisjs-bars").removeClass('d-none');
                        $("#legendBars").removeClass('d-none');

                        var gridBorder = '#eeeeee';

                        //chart bar
                        var ykeysBars = ['cnt_web','cnt_mobile','cnt_pc','cnt_web_mobile'];
                        var barsColor = ['#5ECBAF','#ABD448','#F5365C','#FFD600'];
                        if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_pc'];
                            barsColor = ['#5ECBAF','#ABD448','#F5365C','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_web_mobile'];
                            barsColor = ['#5ECBAF','#ABD448','#FFD600','#F5365C0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_pc','cnt_web_mobile'];
                            barsColor = ['#5ECBAF','#F5365C','#FFD600','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_mobile','cnt_pc','cnt_web_mobile'];
                            barsColor = ['#ABD448','#F5365C','#FFD600','#5ECBAF0'];
                        } else if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_mobile'];
                            barsColor = ['#5ECBAF','#ABD448','#F5365C0','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_pc'];
                            barsColor = ['#5ECBAF','#F5365C','#ABD4480','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_mobile','cnt_pc'];
                            barsColor = ['#ABD448','#F5365C','#5ECBAF0','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_web_mobile'];
                            barsColor = ['#5ECBAF','#FFD600','#ABD4480','#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_pc','cnt_web_mobile'];
                            barsColor = ['#F5365C','#FFD600','#5ECBAF0','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_mobile','cnt_web_mobile'];
                            barsColor = ['#ABD448','#FFD600','#F5365C0','#5ECBAF0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web'];
                            barsColor = ['#5ECBAF','#ABD4480', '#F5365C0','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_mobile'];
                            barsColor = ['#ABD448','#5ECBAF40','#F5365C0','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_pc'];
                            barsColor = ['#F5365C','#5ECBAF40','#ABD4480','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web_mobile'];
                            barsColor = ['#FFD600','#5ECBAF40','#ABD4480','#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 !== 0){
                            ykeysBars = ['','',''];
                            barsColor = ['#ABD44840', '#5ECBAF40', '#F5365C0', '#FFD6000'];
                        }

                        var mBar = new Morris.Bar({
                            element: 'morrisjs-bars',
                            data: res.user_activity,
                            xkey: 'dt',
                            ykeys: ykeysBars,
                            labels: ['Web', 'Mobile', 'Dealer', 'Web Mobile'],
                            xLabelFormat: function (x) {
                                return '';
                            },
                            hoverCallback: function (index, options, content, row) {
                                var mobile = row.cnt_mobile;
                                var web = row.cnt_web;
                                var webmobile = row.cnt_web_mobile;
                                var dealer = row.cnt_pc;

                                if (mobile === null){mobile = '-';}
                                if (web === null){web = '-';}
                                if (webmobile === null){webmobile = '-';}
                                if (dealer === null){dealer = '-';}

                                return "" +
                                    "<div class='text-info'>" + getDateBipsShort(row.dt) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Mobile : " + numberWithCommas(Number(mobile)) + "</div>" +
                                    "<div class='text-danger'>Web : " + numberWithCommas(Number(web)) + "</div>" +
                                    "<div class='text-success'>Dealer : " + numberWithCommas(Number(dealer)) + "</div>"+
                                    "<div class='text-light'>Web Mobile : " + numberWithCommas(Number(webmobile)) + "</div>" ;
                            },
                            barRatio: 0.4,
                            /*xLabelAngle: 35,*/
                            hideHover: 'auto',
                            barColors: barsColor,
                            gridLineColor: gridBorder,
                            resize: true
                        });

                        mBar.options.labels.forEach(function(label, i){
                            var colorLegendBars = mBar.options.barColors[i];
                            var legendlabel= $('<span style="display: inline-block; font-size: 12px;"><i id="barlgnd'+i+'" class="fa fa-square" style="color:'+colorLegendBars+'; padding: 0 2px 0 0; cursor: pointer;" onclick="clickLegendBar(this)"></i>'+label+'</span>')
                            var legendItem = $('<div class="mbox"></div>').append(legendlabel)

                            if (chartBar === 0){
                                $('#legendBars').append(legendItem)
                            }
                        });
                        chartBar++;
                    } else {
                        $("#morrisjs-bars").addClass('chart-empty');
                        $("#morrisjs-bars").append('' +
                            '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                            '<div>' +
                            'No data available in chart' +
                            '</div></div>' + '');
                    }
                }
            });
        }
    </script>
@endsection

@section('content')
    {{--<div class="modal-ajax"></div>--}}
    <div class="header text-white">
        <div class="row col-xs-0">
            <div class="col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb" class="d-inline-block ml-0 w-100">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-2">
                        <li class="breadcrumb-item active"><i class="@foreach($clapps as $p) {{ $p->cla_icon }} @endforeach" style="color: #8898aa!important;"></i> @foreach($clapps as $p) {{ $p->cla_name }} @endforeach</li>
                        {{--<li class="breadcrumb-item active" aria-current="page"> @foreach($clmodule as $p) {{ $p->clm_name }} @endforeach</li>--}}
                        <li id="breadAdditional" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <li id="breadAdditionalText" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <div class="form-inline" style="position: absolute; right:20px; top: 2.5px;">
                            <button class="form-control-btn btn btn btn-outline-secondary mb-1" onclick="getuseractivity();">
                                <i class="fa fa-sync-alt"></i> Refresh</button>
                        </div>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <div class="card card-body" style="min-height: 365px">
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            Trade Statistics
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">TOTAL AMOUNT</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_trade_all">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                        <i class="ni ni-tag"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-luggage-cart"></i> TRADES AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">WEB</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_web_trade">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                        <i class="ni ni-laptop"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-luggage-cart"></i> TRADES AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">MOBILE</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_mobile_trade">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                        <i class="ni ni-mobile-button"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-luggage-cart"></i> TRADES AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">DEALER</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_dealer_trade">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                        <i class="ni ni-tv-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-luggage-cart"></i> TRADES AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            Order Statistics
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">TOTAL AMOUNT</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_order_all">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                        <i class="ni ni-tag"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-shopping-cart"></i> ORDER AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">WEB</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_web_order">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                        <i class="ni ni-laptop"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-shopping-cart"></i> ORDER AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">MOBILE</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_mobile_order">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                        <i class="ni ni-mobile-button"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-shopping-cart"></i> ORDER AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">DEALER</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="sum_dealer_order">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                        <i class="ni ni-tv-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-shopping-cart"></i> ORDER AMOUNT</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            User Activity
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">WEB</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="cnt_web">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                        <i class="ni ni-laptop"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-check"></i> LOGIN SUCCESS</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">MOBILE</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="cnt_mobile">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                        <i class="ni ni-mobile-button"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-check"></i> LOGIN SUCCESS</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">DEALER</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="cnt_pc">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                        <i class="ni ni-tv-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-check"></i> LOGIN SUCCESS</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">WEB MOBILE</h5>
                                                    <span class="h2 font-weight-bold mb-0" id="cnt_web_mobile">0</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                        <i class="ni ni-world-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2"><i class="fa fa-check"></i> LOGIN SUCCESS</span>
                                                <span class="text-nowrap date-now"><?php echo date('d M Y H:i:s')." WIB"?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="row">
                                <div class="col-xl-6 col-md-12">
                                    Stat User Activity
                                    <div class="demo-vertical-spacing-lg">
                                        <div id="morrisjs-bars" class="chart-empty chart-height" style="width:auto"></div>
                                        <div id="legendBars" style="text-align: center"></div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12">
                                    <form class="form-inline">
                                        Stat &nbsp;
                                        <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="piechartType" onchange="changePie();">
                                            <option value="1" selected>Trade</option>
                                            <option value="2">Order</option>
                                        </select>
                                    </form>
                                    <div class="demo-vertical-spacing-lg" id="pie-trade">
                                        <div class="chart-height" style="width:auto">
                                            <canvas class="chart-height" id="statistics-chart-6"></canvas>
                                        </div>
                                    </div>
                                    <div class="demo-vertical-spacing-lg d-none" id="pie-order">
                                        <div class="chart-height" style="width:auto">
                                            <canvas class="chart-height" id="statistics-chart-5"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            Other Statistics
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                    <tr class="bg-gradient-primary text-lighter">
                                        <th rowspan="2">Number Of Order</th>
                                        <th>Web</th>
                                        <th>Mobile</th>
                                        <th>Dealer</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right" id="cnt_web_order"></td>
                                        <td class="text-right" id="cnt_mobile_order"></td>
                                        <td class="text-right" id="cnt_dealer_order"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gradient-primary text-lighter">#Customer Order</th>
                                        <td colspan="3" class="text-right" id="cnt_orders"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gradient-primary text-lighter">#Customer Trades</th>
                                        <td colspan="3" class="text-right" id="cnt_trades"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <form class="form-inline">
                                <select class="form-control bootstrap-select w-select-100 pr-2" data-live-search="true" data-style="btn-default" id="tableType" onchange="changeTypeCust();">
                                    <option value="1" selected>Sales</option>
                                    <option value="2">Customer</option>
                                </select>
                                <label>Top 10 &nbsp;<span id="title-label">Sales</span>&nbsp; Trades</label>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-toptrade">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>No.</th>
                                        <th id="usercode-label"></th>
                                        <th id="username-label"></th>
                                        <th id="total-label">Total Val</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
