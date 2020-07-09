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

    <script src="{{ url('moment/moment.js') }}"></script>
    <script src="{{ url('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ url('bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

    <script src="{{ url('forms_pickers.js') }}"></script>

    {{--<script src="{{ url('charts_morrisjs.js') }}"></script>--}}

    <script type="text/javascript">
        var chartBar = 0;
        var chartLine = 0;
        var chartArea = 0;

        var barshow1 = 0;
        var barshow2 = 0;
        var lineshow1 = 0;
        var lineshow2 = 0;
        var areashow1 = 0;
        var areashow2 = 0;
        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();

            var lastmonth = new Date($("#tgl_awal").val());
            var thismonth = new Date($("#tgl_akhir").val());

            $("#tgl_awal_current").datepicker("setDate",lastmonth);
            $("#tgl_akhir_current").datepicker("setDate",thismonth);

            chartSummary();
        });

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

        function getMonthBipsShort(tanggal){
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

            return month+" "+year;
        }

        function appendLeadingZeroes(n){
            if(n <= 9){
                return "0" + n;
            }
            return n
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
            } else {
                barshow2++
                if (barshow2%2 === 0){
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color')).substr(0,7));
                } else {
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color'))+'40');
                }
            }
            chartSummary();
        }

        function clickLegendLine(theese) {
            var idlgnd = $(theese).attr('id');
            if (idlgnd === 'linelgnd0'){
                lineshow1 ++
                if (lineshow1%2 === 0){
                    $("#linelgnd0").css('color', rgb2hex($("#linelgnd0").css('color')).substr(0,7));
                } else {
                    $("#linelgnd0").css('color', rgb2hex($("#linelgnd0").css('color'))+'40');
                }
            } else {
                lineshow2++
                if (lineshow2%2 === 0){
                    $("#linelgnd1").css('color', rgb2hex($("#linelgnd1").css('color')).substr(0,7));
                } else {
                    $("#linelgnd1").css('color', rgb2hex($("#linelgnd1").css('color'))+'40');
                }
            }
            chartSummary();
        }

        function clickLegendArea(theese) {
            var idlgnd = $(theese).attr('id');
            if (idlgnd === 'arealgnd0'){
                areashow1 ++
                if (areashow1%2 === 0){
                    $("#arealgnd0").css('color', rgb2hex($("#arealgnd0").css('color')).substr(0,7));
                } else {
                    $("#arealgnd0").css('color', rgb2hex($("#arealgnd0").css('color'))+'40');
                }
            } else {
                areashow2++
                if (areashow2%2 === 0){
                    $("#arealgnd1").css('color', rgb2hex($("#arealgnd1").css('color')).substr(0,7));
                } else {
                    $("#arealgnd1").css('color', rgb2hex($("#arealgnd1").css('color'))+'40');
                }
            }
            chartSummary();
        }

        function chartSummary(){
            let tgllast = new Date($("#tgl_awal_current").val());
            let getlastdate = tgllast.getFullYear() + "/" + appendLeadingZeroes(tgllast.getMonth() + 1) + "/" + appendLeadingZeroes(tgllast.getDate());

            let tglthis = new Date($("#tgl_akhir_current").val());
            let getthisdate = tglthis.getFullYear() + "/" + appendLeadingZeroes(tglthis.getMonth() + 1) + "/" + appendLeadingZeroes(tglthis.getDate());

            console.log(getlastdate+" & "+getthisdate);
            $.ajax({
                type: "GET",
                url: "{{ url('charttradesummary-get') }}",
                data: {
                    'tgl_awal': getlastdate,
                    'tgl_akhir': getthisdate,
                },
                success: function (res) {
                    $("#morrisjs-graph").empty();
                    $("#morrisjs-area").empty();
                    $("#morrisjs-bars").empty();

                    var charttype = $("#chartType").val();

                    if ($.trim(res)) {
                        if (charttype === '1') {
                            $("#morrisjs-bars").removeClass('chart-empty');
                            $("#morrisjs-bars").removeClass('d-none');
                            $("#legendBars").removeClass('d-none');
                            $("#legendLine").addClass('d-none');
                            $("#legendArea").addClass('d-none');
                            $("#morrisjs-graph").addClass('d-none');
                            $("#morrisjs-area").addClass('d-none');
                        }
                        if (charttype === '2') {
                            $("#morrisjs-graph").removeClass('chart-empty');
                            $("#morrisjs-graph").removeClass('d-none');
                            $("#legendLine").removeClass('d-none');
                            $("#legendBars").addClass('d-none');
                            $("#legendArea").addClass('d-none');
                            $("#morrisjs-bars").addClass('d-none');
                            $("#morrisjs-area").addClass('d-none');
                        }
                        if (charttype === '3') {
                            $("#morrisjs-area").removeClass('chart-empty');
                            $("#morrisjs-area").removeClass('d-none');
                            $("#legendArea").removeClass('d-none');
                            $("#legendBars").addClass('d-none');
                            $("#legendLine").addClass('d-none');
                            $("#morrisjs-bars").addClass('d-none');
                            $("#morrisjs-graph").addClass('d-none');
                        }

                        //chart line
                        var ykeysLine = ['total_val','order_val'];
                        var lineColor = ['#5ECBAF','#ABD448'];
                        if (lineshow1%2 === 0 && lineshow2%2 !== 0){
                            ykeysLine = ['total_val'];
                            lineColor = ['#5ECBAF','#ABD44840'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 === 0){
                            ykeysLine = ['order_val'];
                            lineColor = ['#ABD448', '#5ECBAF40'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 !== 0){
                            ykeysLine = ['',''];
                            lineColor = ['#ABD44840', '#5ECBAF40'];
                        }

                        var gridBorder = '#eeeeee';
                        var mLine = new Morris.Line({
                            element: 'morrisjs-graph',
                            data: res.sort(function(a, b){
                                return new Date(a.rec_date) - new Date(b.rec_date)}),
                            xkey: 'rec_date',
                            ykeys: ykeysLine,
                            labels: ['Total Val', 'Order Val'],
                            xLabelFormat: function (x) {
                                Date.prototype.toShortFormat = function () {

                                    let monthNames = ["Jan", "Feb", "Mar", "Apr",
                                        "May", "Jun", "Jul", "Aug",
                                        "Sep", "Oct", "Nov", "Dec"];

                                    let day = this.getDate();

                                    let monthIndex = this.getMonth();
                                    let monthName = monthNames[monthIndex];

                                    let year = this.getFullYear();

                                    return `${day} ${monthName} ${year}`;
                                };
                                return x.toShortFormat();
                            },
                            hoverCallback: function (index, options, content, row) {
                                var total_val = row.total_val;
                                var total_vol = row.total_vol;
                                var order_val = row.order_val;
                                var order_vol = row.order_vol;
                                var total_freq = row.total_freq;

                                if (total_val === null){total_val = '-';}
                                if (total_vol === null){total_vol = '-';}
                                if (order_val === null){order_val = '-';}
                                if (order_vol === null){order_vol = '-';}
                                if (total_freq === null){total_freq = '-';}

                                return "" +
                                    "<div class='text-info'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + total_val + "</div>" +
                                    "<div class='text-success'>Total Vol : " + total_vol + "</div>" +
                                    "<div class='text-light'>Order Val : " + order_val + "</div>" +
                                    "<div class='text-primary'>Order Vol : " + order_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + total_freq + "</div>";
                            },
                            lineWidth: 1,
                            pointSize: 4,
                            gridLineColor: gridBorder,
                            resize: true,
                            hideHover: 'auto',
                            lineColors: lineColor,
                        });

                        mLine.options.labels.forEach(function(label, i){
                            var colorLegendLine = mLine.options.lineColors[i];
                            var legendlabel= $('<span style="display: inline-block; font-size: 12px;"><i id="linelgnd'+i+'" class="fa fa-square" style="color:'+colorLegendLine+'; padding: 0 2px 0 0; cursor: pointer;" onclick="clickLegendLine(this)"></i>'+label+'</span>')
                            var legendItem = $('<div class="mbox"></div>').append(legendlabel)

                            if (chartLine === 0){
                                $('#legendLine').append(legendItem)
                            }
                        });
                        chartLine++;

                        //chart bar
                        var ykeysBars = ['total_val','order_val'];
                        var barsColor = ['#5ECBAF','#ABD448'];
                        if (barshow1%2 === 0 && barshow2%2 !== 0){
                            ykeysBars = ['total_val'];
                            barsColor = ['#5ECBAF','#ABD44840'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0){
                            ykeysBars = ['order_val'];
                            barsColor = ['#ABD448', '#5ECBAF40'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0){
                            ykeysBars = [];
                            barsColor = ['#ABD44840', '#5ECBAF40'];
                        }

                        var mBar = new Morris.Bar({
                            element: 'morrisjs-bars',
                            data: res.sort(function(a, b){
                                return new Date(a.rec_date) - new Date(b.rec_date)}),
                            xkey: 'rec_date',
                            ykeys: ykeysBars,
                            labels: ['Total Val', 'Order Val'],
                            xLabelFormat: function (x) {
                                return getDateBipsShort(x.src.rec_date);
                            },
                            hoverCallback: function (index, options, content, row) {
                                var total_val = row.total_val;
                                var total_vol = row.total_vol;
                                var order_val = row.order_val;
                                var order_vol = row.order_vol;
                                var total_freq = row.total_freq;

                                if (total_val === null){total_val = '-';}
                                if (total_vol === null){total_vol = '-';}
                                if (order_val === null){order_val = '-';}
                                if (order_vol === null){order_vol = '-';}
                                if (total_freq === null){total_freq = '-';}

                                return "" +
                                    "<div class='text-info'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + total_val + "</div>" +
                                    "<div class='text-success'>Total Vol : " + total_vol + "</div>" +
                                    "<div class='text-light'>Order Val : " + order_val + "</div>" +
                                    "<div class='text-primary'>Order Vol : " + order_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + total_freq + "</div>";
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

                        //chart area
                        var ykeysArea = ['total_val','order_val'];
                        var areaColor = ['#5ECBAF','#ABD448','#ff0200'];
                        if (areashow1%2 === 0 && areashow2%2 !== 0){
                            ykeysArea = ['total_val'];
                            areaColor = ['#5ECBAF','#ABD44840'];
                        } else if (areashow1%2 !== 0 && areashow2%2 === 0){
                            ykeysArea = ['order_val'];
                            areaColor = ['#ABD448', '#5ECBAF40'];
                        } else if (areashow1%2 !== 0 && areashow2%2 !== 0){
                            ykeysArea = [''];
                            areaColor = ['#ABD44840', '#5ECBAF40'];
                        }

                        var mArea = new Morris.Area({
                            element: 'morrisjs-area',
                            data: res.sort(function(a, b){
                                return new Date(a.rec_date) - new Date(b.rec_date)}),
                            xkey: 'rec_date',
                            ykeys: ykeysArea,
                            labels: ['Total Val', 'Order Val'],
                            xLabelFormat: function (x) {
                                Date.prototype.toShortFormat = function () {

                                    let monthNames = ["Jan", "Feb", "Mar", "Apr",
                                        "May", "Jun", "Jul", "Aug",
                                        "Sep", "Oct", "Nov", "Dec"];

                                    let day = this.getDate();

                                    let monthIndex = this.getMonth();
                                    let monthName = monthNames[monthIndex];

                                    let year = this.getFullYear();

                                    return `${day} ${monthName} ${year}`;
                                };
                                return x.toShortFormat();
                            },
                            hoverCallback: function (index, options, content, row) {
                                var total_val = row.total_val;
                                var total_vol = row.total_vol;
                                var order_val = row.order_val;
                                var order_vol = row.order_vol;
                                var total_freq = row.total_freq;

                                if (total_val === null){total_val = '-';}
                                if (total_vol === null){total_vol = '-';}
                                if (order_val === null){order_val = '-';}
                                if (order_vol === null){order_vol = '-';}
                                if (total_freq === null){total_freq = '-';}

                                return "" +
                                    "<div class='text-info'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + total_val + "</div>" +
                                    "<div class='text-success'>Total Vol : " + total_vol + "</div>" +
                                    "<div class='text-light'>Order Val : " + order_val + "</div>" +
                                    "<div class='text-primary'>Order Vol : " + order_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + total_freq + "</div>";
                            },
                            hideHover: 'auto',
                            lineColors: areaColor,
                            fillOpacity: 0.1,
                            behaveLikeLine: true,
                            lineWidth: 1,
                            pointSize: 4,
                            gridLineColor: gridBorder,
                            resize: true
                        });

                        mArea.options.labels.forEach(function(label, i){
                            var colorLegendArea = mArea.options.lineColors[i];
                            var legendlabel= $('<span style="display: inline-block; font-size: 12px;"><i id="arealgnd'+i+'" class="fa fa-square" style="color:'+colorLegendArea+'; padding: 0 2px 0 0; cursor: pointer;" onclick="clickLegendArea(this)"></i>'+label+'</span>')
                            var legendItem = $('<div class="mbox"></div>').append(legendlabel)

                            if (chartArea === 0){
                                $('#legendArea').append(legendItem)
                            }
                        });
                        chartArea++;
                    } else {
                        if (charttype === '1') {
                            $("#morrisjs-bars").addClass('chart-empty');
                            $("#morrisjs-bars").append('' +
                                '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                                '<div>' +
                                'No data available in chart' +
                                '</div></div>' + '');
                        }
                        if (charttype === '2') {
                            $("#morrisjs-graph").addClass('d-none');
                            $("#morrisjs-graph").append('' +
                                '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                                '<div>' +
                                'No data available in chart' +
                                '</div></div>' + '');
                        }
                        if (charttype === '3') {
                            $("#morrisjs-area").addClass('chart-empty');
                            $("#morrisjs-area").append('' +
                                '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                                '<div>' +
                                'No data available in chart' +
                                '</div></div>' + '');
                        }
                    }
                }
            });
        }
    </script>
@endsection

@section('content')
    <div class="modal-ajax"></div>
    <div class="header text-white">
        <div class="row col-xs-0">
            <div class="col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb" class="d-inline-block ml-0 w-100">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-2">
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i> @foreach($clapps as $p) {{ $p->cla_name }} @endforeach</li>
                        <li class="breadcrumb-item active" aria-current="page"> @foreach($clmodule as $p) {{ $p->clm_name }} @endforeach</li>
                        <li id="breadAdditional" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <li id="breadAdditionalText" class="breadcrumb-item active d-none" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow" id="main-user">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Type Chart :</label>
                <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="chartType"  onchange="chartSummary();">
                    <option value="1" selected>Chart Bar</option>
                    <option value="2">Chart Line</option>
                    <option value="3">Chart Area</option>
                </select>
                &nbsp;&nbsp;
                <div class="ml-input-2 input-daterange input-group" id="datepicker-range">
                    <input type="text" class="form-control" name="start" id="tgl_awal_current" value="{{ $lastmonth }}" onchange="chartSummary();" readonly>
                    <div class="input-group-prepend">
                        <span class="input-group-text">To</span>
                    </div>
                    <input type="text" class="form-control" name="end" id="tgl_akhir_current" value="{{ $thismonth }}" onchange="chartSummary();" readonly>
                </div>&nbsp;&nbsp;
                <button class="form-control-btn btn btn-primary mb-1" type="button" id="btn-current" onclick="chartSummary();">Refresh</button>
                <input value="{{ $lastmonth }}" type="hidden" id="tgl_awal"/>
                <input value="{{ $thismonth }}" type="hidden" id="tgl_akhir"/>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="demo-vertical-spacing-lg">
                <div id="morrisjs-bars" class="chart-empty chart-height" style="width:auto"></div>
                <div id="legendBars" style="text-align: center"></div>
                <div id="morrisjs-graph" class="d-none chart-height" style="width:auto"></div>
                <div id="legendLine" class="d-none" style="text-align: center"></div>
                <div id="morrisjs-area" class="d-none chart-height" style="width:auto"></div>
                <div id="legendArea" class="d-none" style="text-align: center"></div>
            </div>
        </div>
    </div>
@endsection