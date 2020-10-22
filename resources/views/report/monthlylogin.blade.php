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
    <script type="text/javascript">
        var chartBar = 0;
        var chartLine = 0;
        var chartArea = 0;

        var barshow1 = 0;
        var barshow2 = 0;
        var barshow3 = 0;
        var lineshow1 = 0;
        var lineshow2 = 0;
        var lineshow3 = 0;
        var areashow1 = 0;
        var areashow2 = 0;
        var areashow3 = 0;

        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();

            tablegetMonthly();
            var lastmonth = new Date($("#tgl_awal").val());
            var thismonth = new Date($("#tgl_akhir").val());
            $("#tgl_awal_current").datepicker("setDate",lastmonth);
            $("#tgl_akhir_current").datepicker("setDate",thismonth);
            chartSummary();
        });

        function exportExcel() {
            $.ajax({
                type    : "GET",
                url     : "{{url('reportmonthlylogin-get')}}",
                data    : {
                    'tgl_awal': $("#tgl_awal").val(),
                    'tgl_akhir': $("#tgl_akhir").val()
                },
                complete : function (){
                    window.location = this.url;
                    console.log('Export Excel Success..');
                }
            });
        }

        function tablegetMonthly() {
            var tableData = $("#table-monthly").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
                aaSorting: [[0, 'desc']],
                bFilter:false,
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-outline-default mb-2" type="button" onclick="exportExcel()"><i style="color: #00b862" class="fa fa-file-excel"></i> Export Excel</button>');
                },
                ajax : {
                    url: '{{ url("datamonthlylogin-get") }}',
                    data: function (d) {
                        var search_data = {
                            tgl_awal: $("#tgl_awal").val(),
                            tgl_akhir: $("#tgl_akhir").val(),
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'year_month', name: 'year_month'},
                    {data : 'web', name: 'web'},
                    {data : 'mobile', name: 'mobile'},
                    {data : 'web_mobile', name: 'web_mobile'},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : getMonthBipsShort(data);
                    }
                },{
                    targets : [1],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [2],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [3],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                }]
            });
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
            } else if(idlgnd === 'barlgnd1'){
                barshow2++
                if (barshow2%2 === 0){
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color')).substr(0,7));
                } else {
                    $("#barlgnd1").css('color', rgb2hex($("#barlgnd1").css('color'))+'40');
                }
            } else {
                barshow3++
                if (barshow3%2 === 0){
                    $("#barlgnd2").css('color', rgb2hex($("#barlgnd2").css('color')).substr(0,7));
                } else {
                    $("#barlgnd2").css('color', rgb2hex($("#barlgnd2").css('color'))+'40');
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
            } else if (idlgnd === 'linelgnd1'){
                lineshow2++
                if (lineshow2%2 === 0){
                    $("#linelgnd1").css('color', rgb2hex($("#linelgnd1").css('color')).substr(0,7));
                } else {
                    $("#linelgnd1").css('color', rgb2hex($("#linelgnd1").css('color'))+'40');
                }
            } else {
                lineshow3++
                if (lineshow3%2 === 0){
                    $("#linelgnd2").css('color', rgb2hex($("#linelgnd2").css('color')).substr(0,7));
                } else {
                    $("#linelgnd2").css('color', rgb2hex($("#linelgnd2").css('color'))+'40');
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
            } else if(idlgnd === 'arealgnd1'){
                areashow2++
                if (areashow2%2 === 0){
                    $("#arealgnd1").css('color', rgb2hex($("#arealgnd1").css('color')).substr(0,7));
                } else {
                    $("#arealgnd1").css('color', rgb2hex($("#arealgnd1").css('color'))+'40');
                }
            } else {
                areashow3++
                if (areashow3%2 === 0){
                    $("#arealgnd2").css('color', rgb2hex($("#arealgnd2").css('color')).substr(0,7));
                } else {
                    $("#arealgnd2").css('color', rgb2hex($("#arealgnd2").css('color'))+'40');
                }
            }
            chartSummary();
        }

        function chartSummary(){
            var tgllast = new Date($("#tgl_awal_current").val());
            var getlastdate = tgllast.getFullYear() + "/" + appendLeadingZeroes(tgllast.getMonth() + 1);

            var tglthis = new Date($("#tgl_akhir_current").val());
            var getthisdate = tglthis.getFullYear() + "/" + appendLeadingZeroes(tglthis.getMonth() + 1);

            $("#tgl_awal").val(getlastdate);
            $("#tgl_akhir").val(getthisdate);

            console.log(getlastdate+" & "+getthisdate);
            $.ajax({
                type: "GET",
                url: "{{ url('chartmonthlylogin-get') }}",
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
                        var ykeysLine = ['web','mobile','web_mobile'];
                        var lineColor = ['#5ECBAF','#ABD448','#F5365C'];
                        if (lineshow1%2 === 0 && lineshow2%2 === 0 && lineshow3%2 !== 0){
                            ykeysLine = ['web','mobile'];
                            lineColor = ['#5ECBAF','#ABD448','#F5365C0'];
                        } else if (lineshow1%2 === 0 && lineshow2%2 !== 0 && lineshow3%2 === 0){
                            ykeysLine = ['web','web_mobile'];
                            lineColor = ['#5ECBAF','#F5365C','#ABD4480'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 === 0 && lineshow3%2 === 0){
                            ykeysLine = ['mobile','web_mobile'];
                            lineColor = ['#ABD448','#F5365C','#5ECBAF0'];
                        } else if (lineshow1%2 === 0 && lineshow2%2 !== 0 && lineshow3%2 !== 0){
                            ykeysLine = ['web'];
                            lineColor = ['#5ECBAF','#ABD4480', '#F5365C0'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 === 0 && lineshow3%2 !== 0){
                            ykeysLine = ['mobile'];
                            lineColor = ['#ABD448','#5ECBAF40','#F5365C0'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 !== 0 && lineshow3%2 === 0){
                            ykeysLine = ['web_mobile'];
                            lineColor = ['#F5365C','#5ECBAF40','#ABD4480'];
                        } else if (lineshow1%2 !== 0 && lineshow2%2 !== 0 && lineshow3%2 !== 0){
                            ykeysLine = ['','',''];
                            lineColor = ['#ABD44840', '#5ECBAF40', '#F5365C0'];
                        }

                        var gridBorder = '#eeeeee';
                        var mLine = new Morris.Line({
                            element: 'morrisjs-graph',
                            data: res.sort(function(a, b){
                                return new Date(a.year_month) - new Date(b.year_month)}),
                            xkey: 'year_month',
                            ykeys: ykeysLine,
                            labels: ['Web','Mobile','Web Mobile'],
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
                                var mobile = row.mobile;
                                var web = row.web;
                                var webmobile = row.web_mobile;
                                var desktop = row.desktop;

                                if (mobile === null){mobile = '-';}
                                if (web === null){web = '-';}
                                if (webmobile === null){webmobile = '-';}
                                if (desktop === null){desktop = '-';}

                                return "" +
                                    "<div class='text-info'>" + getMonthBipsShort(row.year_month) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Mobile : " + mobile + "</div>" +
                                    "<div class='text-danger'>Web : " + web + "</div>" +
                                    "<div class='text-light'>Web Mobile : " + webmobile + "</div>" +
                                    "<div class='text-success'>Desktop : " + desktop + "</div>";
                            },
                            lineWidth: 1,
                            pointSize: 4,
                            gridLineColor: gridBorder,
                            resize: true,
                            hideHover: 'auto',
                            // lineColors: ['#FFC107', '#E91E63'],
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
                        var ykeysBars = ['web','mobile','web_mobile'];
                        var barsColor = ['#5ECBAF','#ABD448','#F5365C'];
                        if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 !== 0){
                            ykeysBars = ['web','mobile'];
                            barsColor = ['#5ECBAF','#ABD448','#F5365C0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 === 0){
                            ykeysBars = ['web','web_mobile'];
                            barsColor = ['#5ECBAF','#F5365C','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 === 0){
                            ykeysBars = ['mobile','web_mobile'];
                            barsColor = ['#ABD448','#F5365C','#5ECBAF0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 !== 0){
                            ykeysBars = ['web'];
                            barsColor = ['#5ECBAF','#ABD4480', '#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 !== 0){
                            ykeysBars = ['mobile'];
                            barsColor = ['#ABD448','#5ECBAF40','#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 === 0){
                            ykeysBars = ['web_mobile'];
                            barsColor = ['#F5365C','#5ECBAF40','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 !== 0){
                            ykeysBars = ['','',''];
                            barsColor = ['#ABD44840', '#5ECBAF40', '#F5365C0'];
                        }

                        var mBar = new Morris.Bar({
                            element: 'morrisjs-bars',
                            data: res.sort(function(a, b){
                                return new Date(a.year_month) - new Date(b.year_month)}),
                            xkey: 'year_month',
                            ykeys: ykeysBars,
                            labels: ['Web', 'Mobile', 'Web Mobile'],
                            xLabelFormat: function (x) {
                                return getMonthBipsShort(x.src.year_month);
                            },
                            hoverCallback: function (index, options, content, row) {
                                var mobile = row.mobile;
                                var web = row.web;
                                var webmobile = row.web_mobile;
                                var desktop = row.desktop;

                                if (mobile === null){mobile = '-';}
                                if (web === null){web = '-';}
                                if (webmobile === null){webmobile = '-';}
                                if (desktop === null){desktop = '-';}

                                return "" +
                                    "<div class='text-info'>" + getMonthBipsShort(row.year_month) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Mobile : " + mobile + "</div>" +
                                    "<div class='text-danger'>Web : " + web + "</div>" +
                                    "<div class='text-light'>Web Mobile : " + webmobile + "</div>" +
                                    "<div class='text-success'>Desktop : " + desktop + "</div>";
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
                        var ykeysArea = ['web','mobile','web_mobile'];
                        var areaColor = ['#5ECBAF','#ABD448','#F5365C'];
                        if (areashow1%2 === 0 && areashow2%2 === 0 && areashow3%2 !== 0){
                            ykeysArea = ['web','mobile'];
                            areaColor = ['#5ECBAF','#ABD448','#F5365C0'];
                        } else if (areashow1%2 === 0 && areashow2%2 !== 0 && areashow3%2 === 0){
                            ykeysArea = ['web','web_mobile'];
                            areaColor = ['#5ECBAF','#F5365C','#ABD4480'];
                        } else if (areashow1%2 !== 0 && areashow2%2 === 0 && areashow3%2 === 0){
                            ykeysArea = ['mobile','web_mobile'];
                            areaColor = ['#ABD448','#F5365C','#5ECBAF0'];
                        } else if (areashow1%2 === 0 && areashow2%2 !== 0 && areashow3%2 !== 0){
                            ykeysArea = ['web'];
                            areaColor = ['#5ECBAF','#ABD4480', '#F5365C0'];
                        } else if (areashow1%2 !== 0 && areashow2%2 === 0 && areashow3%2 !== 0){
                            ykeysArea = ['mobile'];
                            areaColor = ['#ABD448','#5ECBAF40','#F5365C0'];
                        } else if (areashow1%2 !== 0 && areashow2%2 !== 0 && areashow3%2 === 0){
                            ykeysArea = ['web_mobile'];
                            areaColor = ['#F5365C','#5ECBAF40','#ABD4480'];
                        } else if (areashow1%2 !== 0 && areashow2%2 !== 0 && areashow3%2 !== 0){
                            ykeysArea = ['','',''];
                            areaColor = ['#ABD44840', '#5ECBAF40', '#F5365C0'];
                        }

                        var mArea = new Morris.Area({
                            element: 'morrisjs-area',
                            data: res.sort(function(a, b){
                                return new Date(a.year_month) - new Date(b.year_month)}),
                            xkey: 'year_month',
                            ykeys: ykeysArea,
                            labels: ['Web', 'Mobile', 'Web Mobile'],
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
                                var mobile = row.mobile;
                                var web = row.web;
                                var webmobile = row.web_mobile;
                                var desktop = row.desktop;

                                if (mobile === null){mobile = '-';}
                                if (web === null){web = '-';}
                                if (webmobile === null){webmobile = '-';}
                                if (desktop === null){desktop = '-';}

                                return "" +
                                    "<div class='text-info'>" + getMonthBipsShort(row.year_month) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Mobile : " + mobile + "</div>" +
                                    "<div class='text-danger'>Web : " + web + "</div>" +
                                    "<div class='text-light'>Web Mobile : " + webmobile + "</div>" +
                                    "<div class='text-success'>Desktop : " + desktop + "</div>";
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
                        $("#morrisjs-bars").addClass('chart-empty');
                        $("#morrisjs-bars").append('' +
                            '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                            '<div>' +
                            'No data available in chart' +
                            '</div></div>' + '');

                        $("#morrisjs-graph").addClass('chart-empty');
                        $("#morrisjs-graph").append('' +
                            '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                            '<div>' +
                            'No data available in chart' +
                            '</div></div>' + '');

                        $("#morrisjs-area").addClass('chart-empty');
                        $("#morrisjs-area").append('' +
                            '<div style="font-size: 18px"><i class="ni ni-sound-wave" style="font-size: 36px"></i>' +
                            '<div>' +
                            'No data available in chart' +
                            '</div></div>' + '');
                    }
                    $('#table-monthly').DataTable().ajax.reload();
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
                        <li class="breadcrumb-item active"><i class="@foreach($clapps as $p) {{ $p->cla_icon }} @endforeach" style="color: #8898aa!important;"></i> @foreach($clapps as $p) {{ $p->cla_name }} @endforeach</li>
                        <li class="breadcrumb-item active" aria-current="page"> @foreach($clmodule as $p) {{ $p->clm_name }} @endforeach</li>
                        <li id="breadAdditional" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <li id="breadAdditionalText" class="breadcrumb-item active d-none" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Filter by :</label>
                <div class="ml-input-2 input-daterange input-group" id="monthPicker">
                    <input type="text" class="form-control" name="start" id="tgl_awal_current" readonly value="{{ $startmonth }}" onchange="chartSummary();">
                    <div class="input-group-prepend">
                        <span class="input-group-text">To</span>
                    </div>
                    <input type="text" class="form-control" name="end" id="tgl_akhir_current" readonly value="{{ $thismonth }}" onchange="chartSummary();">
                </div>&nbsp;&nbsp;
                <button class="form-control-btn btn btn-primary mb-1" type="button" id="btn-current" onclick="chartSummary();">Refresh</button>
                <input value="{{ $startmonth }}" type="hidden" id="tgl_awal"/>
                <input value="{{ $thismonth }}" type="hidden" id="tgl_akhir"/>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-monthly">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>Year Month</th>
                                        <th>Web</th>
                                        <th>Mobile</th>
                                        <th>Web Mobile</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <form class="form-inline">
                                <label class="form-control-label pr-5 mb-2">Type Chart :</label>
                                <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="chartType"  onchange="chartSummary();">
                                    <option value="1" selected>Chart Bar</option>
                                    <option value="2">Chart Line</option>
                                    <option value="3">Chart Area</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
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
                </div>
            </section>
        </div>
    </div>
@endsection
