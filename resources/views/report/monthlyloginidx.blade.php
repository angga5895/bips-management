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
        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();

            tablegetMonthly();
            var lastmonth = new Date($("#tgl_awal").val()+'/01');
            var thismonth = new Date($("#tgl_akhir").val()+'/01');
            $("#tgl_awal_current").datepicker("setDate",lastmonth);
            $("#tgl_akhir_current").datepicker("setDate",thismonth);
            tableSummary();
        });

        function exportPDF() {
            $.ajax({
                type    : "GET",
                url     : "{{url('/reportmonthlyloginidx/pdf')}}",
                data    : {
                    'tgl_awal': $("#tgl_awal").val(),
                    'tgl_akhir': $("#tgl_akhir").val()
                },
                complete : function (){
                    // window.open(this.url, '_blank');
                    window.location = this.url;
                    console.log('Export PDF Success..');
                }
            });
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function tablegetMonthly() {
            var tableData = $("#table-monthly").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
                aaSorting: [[0, 'desc']],
                bFilter:false,
                ajax : {
                    url: '{{ url("datamonthlyloginidx-get") }}',
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
                    {data : 'total_cust_login', name: 'total_cust_login'},
                    {data : 'cust_general', name: 'cust_general'},
                    {data : 'cust_academic', name: 'cust_academic'},
                    {data : 'cust_trial', name: 'cust_trial'},
                    {data : 'sales', name: 'sales'},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<span style="display: none;">'+data+'</span>'+getMonthBipsShort(data);
                    }
                },{
                    targets : [1],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(data)+'</div>';
                    }
                },{
                    targets : [2],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(data)+'</div>';
                    }
                },{
                    targets : [3],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(data)+'</div>';
                    }
                },{
                    targets : [4],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(data)+'</div>';
                    }
                },{
                    targets : [5],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(data)+'</div>';
                    }
                }]
            });
        }

        function tableSummary() {
            var tgllast = new Date($("#tgl_awal_current").val()+'/01');
            var getlastdate = tgllast.getFullYear() + "/" + appendLeadingZeroes(tgllast.getMonth() + 1);

            var tglthis = new Date($("#tgl_akhir_current").val()+'/01');
            var getthisdate = tglthis.getFullYear() + "/" + appendLeadingZeroes(tglthis.getMonth() + 1);

            $("#tgl_awal").val(getlastdate);
            $("#tgl_akhir").val(getthisdate);

            console.log(getlastdate + " & " + getthisdate);
            $('#table-monthly').DataTable().ajax.reload();
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
                    <input type="text" class="form-control" name="start" id="tgl_awal_current" readonly value="{{ $startmonth }}" onchange="tableSummary();">
                    <div class="input-group-prepend">
                        <span class="input-group-text">To</span>
                    </div>
                    <input type="text" class="form-control" name="end" id="tgl_akhir_current" readonly value="{{ $thismonth }}" onchange="tableSummary();">
                </div>&nbsp;&nbsp;
                <button class="form-control-btn btn btn-primary mb-1" type="button" id="btn-current">Refresh</button>
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
                            <div class="toolbar">
                                {{--<a href="{{route('pdfMonthlyLoginIdx')}}" class="form-control-btn-0 btn btn-outline-default mb-0"><i style="color: #e40909" class="fa fa-file-pdf"></i> Export PDF</a>--}}
                                <button class="form-control-btn-0 btn btn-outline-default mb-0" type="button" onclick="exportPDF()"><i style="color: #e40909" class="fa fa-file-pdf"></i> Export PDF</button>
                                <button class="form-control-btn-0 btn btn-outline-default mb-0" type="button" onclick="exportExcel()"><i style="color: #00b862" class="fa fa-file-excel"></i> Export Excel</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-monthly">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>Year Month</th>
                                        <th>Total Nasabah Login</th>
                                        <th>Nasabah Umum</th>
                                        <th>Nasabah Akademisi</th>
                                        <th>Nasabah Trial</th>
                                        <th>Sales / Internal</th>
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
