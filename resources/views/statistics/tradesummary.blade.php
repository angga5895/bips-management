@extends('layouts.app-argon')

@section('css')
    <link rel="stylesheet" href="{{ url('chart/morris/morris.css') }}">
@endsection

@section('js')
    <!-- Dependencies -->
    <script src="{{ url('chart/eve/eve.js') }}"></script>
    <script src="{{ url('chart/raphael/raphael.js') }}"></script>
    <script src="{{ url('chart/morris/morris.js') }}"></script>

    {{--<script src="{{ url('charts_morrisjs.js') }}"></script>--}}

    <script type="text/javascript">
        $(document).ready(function () {
            chartSummary();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
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

        function chartSummary(){
            $.ajax({
                type: "GET",
                url: "{{ url('charttradesummary-get') }}",
                success: function (res) {
                    $("#morrisjs-graph").empty();
                    $("#morrisjs-area").empty();
                    $("#morrisjs-bars").empty();


                    var charttype = $("#chartType").val();

                    if ($.trim(res)) {
                        if (charttype === '1') {
                            $("#morrisjs-bars").removeClass('chart-empty');
                            $("#morrisjs-bars").removeClass('d-none');
                            $("#morrisjs-graph").addClass('d-none');
                            $("#morrisjs-area").addClass('d-none');
                        }
                        if (charttype === '2') {
                            $("#morrisjs-graph").removeClass('chart-empty');
                            $("#morrisjs-graph").removeClass('d-none');
                            $("#morrisjs-bars").addClass('d-none');
                            $("#morrisjs-area").addClass('d-none');
                        }
                        if (charttype === '3') {
                            $("#morrisjs-area").removeClass('chart-empty');
                            $("#morrisjs-area").removeClass('d-none');
                            $("#morrisjs-bars").addClass('d-none');
                            $("#morrisjs-graph").addClass('d-none');
                        }

                        var gridBorder = '#eeeeee';
                        new Morris.Line({
                            element: 'morrisjs-graph',
                            data: res,
                            xkey: 'rec_date',
                            ykeys: ['total_val'],
                            labels: ['Total Val'],
                            xLabelFormat: function (x) {
                                Date.prototype.toShortFormat = function () {

                                    let monthNames = ["Jan", "Feb", "Mar", "Apr",
                                        "May", "Jun", "Jul", "Aug",
                                        "Sep", "Oct", "Nov", "Dec"];

                                    let day = this.getDate();

                                    let monthIndex = this.getMonth();
                                    let monthName = monthNames[monthIndex];

                                    let year = this.getFullYear();

                                    return `${monthName}-${year}`;
                                };
                                return x.toShortFormat();
                            },
                            hoverCallback: function (index, options, content, row) {
                                return "" +
                                    "<div class='text-success'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + row.total_val + "</div>" +
                                    "<div class='text-primary'>Total Vol : " + row.total_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + row.total_freq + "</div>";
                            },
                            lineWidth: 1,
                            pointSize: 4,
                            gridLineColor: gridBorder,
                            resize: true,
                            hideHover: 'auto',
                            lineColors: ['#FFC107', '#E91E63'],
                        });

                        new Morris.Bar({
                            element: 'morrisjs-bars',
                            data: res,
                            xkey: 'rec_date',
                            ykeys: ['total_val'],
                            labels: ['Total Val'],
                            xLabelFormat: function (x) {
                                return getMonthBipsShort(x.src.rec_date);
                            },
                            hoverCallback: function (index, options, content, row) {
                                return "" +
                                    "<div class='text-success'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + row.total_val + "</div>" +
                                    "<div class='text-primary'>Total Vol : " + row.total_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + row.total_freq + "</div>";
                            },
                            barRatio: 0.4,
                            /*xLabelAngle: 35,*/
                            hideHover: 'auto',
                            barColors: ['#CDDC39'],
                            gridLineColor: gridBorder,
                            resize: true
                        });

                        new Morris.Area({
                            element: 'morrisjs-area',
                            data: res,
                            xkey: 'rec_date',
                            ykeys: ['total_val'],
                            labels: ['Total Val'],
                            xLabelFormat: function (x) {
                                Date.prototype.toShortFormat = function () {

                                    let monthNames = ["Jan", "Feb", "Mar", "Apr",
                                        "May", "Jun", "Jul", "Aug",
                                        "Sep", "Oct", "Nov", "Dec"];

                                    let day = this.getDate();

                                    let monthIndex = this.getMonth();
                                    let monthName = monthNames[monthIndex];

                                    let year = this.getFullYear();

                                    return `${monthName}-${year}`;
                                };
                                return x.toShortFormat();
                            },
                            hoverCallback: function (index, options, content, row) {
                                return "" +
                                    "<div class='text-success'>" + getDateBipsShort(row.rec_date) + "</div>" +
                                    "<br/>" +
                                    "<div style='color: #FFC107'>Total Val : " + row.total_val + "</div>" +
                                    "<div class='text-primary'>Total Vol : " + row.total_vol + "</div>" +
                                    "<div class='text-danger'>Total Freq : " + row.total_freq + "</div>";
                            },
                            hideHover: 'auto',
                            lineColors: ['#673AB7', '#0288D1', '#9E9E9E'],
                            fillOpacity: 0.1,
                            behaveLikeLine: true,
                            lineWidth: 1,
                            pointSize: 4,
                            gridLineColor: gridBorder,
                            resize: true
                        });
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
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current" onclick="chartSummary();">Refresh</button>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="demo-vertical-spacing-lg">
                <div id="morrisjs-bars" class="chart-empty chart-height"></div>
                <div id="morrisjs-graph" class="d-none chart-height"></div>
                <div id="morrisjs-area" class="d-none chart-height"></div>
            </div>
        </div>
    </div>
@endsection