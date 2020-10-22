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
            getuseractivity();
            setInterval(function(){
                getuseractivity();
            }, 120000);
        });

        function getuseractivity() {
            $.ajax({
                type    : "GET",
                url     : "{{url('countuseractivity-get')}}",
                success : function (res){
                    $("#morrisjs-bars").empty();
                    if ($.trim(res)) {
                        $('.date-now').text(res[0].now_date);
                        $("#cnt_web").text(res[0].cnt_web);
                        $("#cnt_mobile").text(res[0].cnt_mobile);
                        $("#cnt_web_mobile").text(res[0].cnt_web_mobile);
                        $("#cnt_pc").text(res[0].cnt_pc);

                        $("#morrisjs-bars").removeClass('chart-empty');
                        $("#morrisjs-bars").removeClass('d-none');
                        $("#legendBars").removeClass('d-none');

                        var gridBorder = '#eeeeee';

                        //chart bar
                        var ykeysBars = ['cnt_web','cnt_mobile','cnt_web_mobile','cnt_pc'];
                        var barsColor = ['#5ECBAF','#ABD448','#F5365C','#FFD600'];
                        if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_web_mobile'];
                            barsColor = ['#5ECBAF','#ABD448','#F5365C','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_pc'];
                            barsColor = ['#5ECBAF','#ABD448','#FFD600','#F5365C0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_pc'];
                            barsColor = ['#5ECBAF','#F5365C','#FFD600','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_mobile','cnt_pc'];
                            barsColor = ['#ABD448','#F5365C','#FFD600','#5ECBAF0'];
                        } else if (barshow1%2 === 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_mobile'];
                            barsColor = ['#5ECBAF','#ABD448','#F5365C0','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web','cnt_web_mobile'];
                            barsColor = ['#5ECBAF','#F5365C','#ABD4480','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_mobile','cnt_web_mobile'];
                            barsColor = ['#ABD448','#F5365C','#5ECBAF0','#FFD6000'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web','cnt_pc'];
                            barsColor = ['#5ECBAF','#FFD600','#ABD4480','#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_web_mobile','cnt_pc'];
                            barsColor = ['#F5365C','#FFD600','#5ECBAF0','#ABD4480'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_mobile','cnt_pc'];
                            barsColor = ['#ABD448','#FFD600','#F5365C0','#5ECBAF0'];
                        } else if (barshow1%2 === 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web'];
                            barsColor = ['#5ECBAF','#ABD4480', '#F5365C0','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 === 0 && barshow3%2 !== 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_mobile'];
                            barsColor = ['#ABD448','#5ECBAF40','#F5365C0','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 === 0 && barshow4%2 !== 0){
                            ykeysBars = ['cnt_web_mobile'];
                            barsColor = ['#F5365C','#5ECBAF40','#ABD4480','#FFD6000'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 !== 0 && barshow4%2 === 0){
                            ykeysBars = ['cnt_pc'];
                            barsColor = ['#FFD600','#5ECBAF40','#ABD4480','#F5365C0'];
                        } else if (barshow1%2 !== 0 && barshow2%2 !== 0 && barshow3%2 !== 0){
                            ykeysBars = ['','',''];
                            barsColor = ['#ABD44840', '#5ECBAF40', '#F5365C0', '#FFD6000'];
                        }

                        var mBar = new Morris.Bar({
                            element: 'morrisjs-bars',
                            data: res,
                            xkey: 'dt',
                            ykeys: ykeysBars,
                            labels: ['Web', 'Mobile', 'Web Mobile', 'Desktop'],
                            xLabelFormat: function (x) {
                                return getDateBipsShort(x.src.dt);
                            },
                            hoverCallback: function (index, options, content, row) {
                                var mobile = row.cnt_mobile;
                                var web = row.cnt_web;
                                var webmobile = row.cnt_web_mobile;
                                var desktop = row.cnt_pc;

                                if (mobile === null){mobile = '-';}
                                if (web === null){web = '-';}
                                if (webmobile === null){webmobile = '-';}
                                if (desktop === null){desktop = '-';}

                                return "" +
                                    "<div class='text-info'>" + getDateBipsShort(row.dt) + "</div>" +
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
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">DESKTOP</h5>
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
                            </div>
                            <div class="demo-vertical-spacing-lg">
                                <div id="morrisjs-bars" class="chart-empty chart-height" style="width:auto"></div>
                                <div id="legendBars" style="text-align: center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
