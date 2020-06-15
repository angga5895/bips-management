@extends('layouts.app-argon')

@section('js')
    <script type="text/javascript">

        $(document).ready(function () {
            tablelist();
            tablegetReg();
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });
        });

        function refreshTablemember(){
            $('#table-listmember').DataTable().ajax.reload();
        }

        function tablelist() {
            $("#table-listmember").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

                ajax : {
                    url: '{{ url("get-dataRegistrasi/get") }}',
                    data: function (d) {
                        var search_data = {userID:"",
                            userStatus:"",
                            userType:"C"};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_id', name : 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'user_id', name: 'user_id'},
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    searchable : true
                },{
                    targets : [1],
                    orderable : true,
                    searchable : false,
                },{
                    targets : [2],
                    orderable:false,
                    searchable : false,
                    className: 'text-center',
                    render : function (data, type, row) {
                        var uid = row.user_id;
                        var us = row.user_name;
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+uid+'\')">Pick</button>'
                    }
                }]
            });
        }

        function tablegetReg() {
            var tableData = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

                aaSorting: [[0, 'desc']],
                ajax : {
                    url: '{{ url("get-dataRegistrasi/get") }}',
                    data: function (d) {
                        var search_data = {
                            userID:$("#userID").val(),
                            userStatus:"",
                            userType:"C"
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_name', name: 'user_name'},
                    {data : 'user_id', name : 'user_id'},
                    {data : 'email_address', name: 'email_address'},
                    {data : 'usertype', name: 'usertype'},
                    {data : 'msidn', name: 'msidn'},
                    {data : 'userstatus', name: 'userstatus'},
                    {data : 'last_login', name: 'last_login'},
                    {data : 'last_teriminalid', name: 'last_teriminalid'},
                    {data : 'login_attempt', name: 'login_attempt'},
                    {data : 'pin_attempt', name: 'pin_attempt'},
                    {data : 'pin_locked', name: 'pin_locked'},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : false
                },{
                    targets : [1],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [2],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [3],
                    searchable : true,
                },{
                    searchable : true,
                    targets : [4],
                },{
                    searchable : true,
                    targets : [5],
                },{
                    searchable : true,
                    targets : [6],
                },{
                    searchable : true,
                    targets : [7],
                },{
                    searchable : true,
                    targets : [8],
                },{
                    searchable : true,
                    targets : [9],
                },{
                    searchable : true,
                    targets : [10],
                }]
            });
        }

        function clickOK(id) {
            $("#userID").val(id);
            getUsername();
        }

        function getUsername() {
            var id = $("#userID").val();

            if(id === ''){
                $("#usernameGet").val('');
                $('#table-reggroup').DataTable().ajax.reload();
            } else {
                $.ajax({
                    type : "GET",
                    url  : "{{ url('username-get') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#usernameGet").val(res[0].user_name);
                        } else {
                            $("#usernameGet").val('');
                        }
                        $('#table-reggroup').DataTable().ajax.reload();
                    }
                });
            }
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
                <label class="form-control-label pr-5 mb-2">A/C Name :</label>
                <input class="form-control mb-2" placeholder="Input User Code" id="userID" onchange="getUsername()">
                <input class="form-control mb-2 ml-input-2" placeholder="Name Of User" id="usernameGet" readonly>
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1" onclick="refreshTablemember()"><i class="fa fa-search"></i></button>
                &nbsp;&nbsp;
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current" onclick="getUsername();">Refresh</button>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-success-update">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="update_user_notification"></strong>, has updated.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-error-registrasi">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-inner--text">Error Because =>&nbsp;<strong id="messageuser"></strong></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row lbl-group px-3">
                                        <label class="form-control-label form-inline-label col-sm-label-risk mb-2 px-0">A/C Name</label>
                                        <div class="col-sm-form-risk row pr-0">
                                            <div class="col-sm-4 px-risk">
                                                <input class="form-control" type="text" placeholder="User Code" id="usercode" name="usercode" onchange="checking(this)" disabled/>
                                            </div>
                                            <div class="col-sm-4 px-risk">
                                                <input class="form-control" type="text" placeholder="User Name" id="username" name="username" onchange="checking(this)" disabled/>
                                            </div>
                                            <div class="col-sm-4 px-risk">
                                                <input class="form-control" type="text" placeholder="Status" id="status" name="status" onchange="checking(this)" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Cash Balance</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Cash Balance"
                                                   id="cashbalance" name="cashbalance" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Portfolio Value</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Portfolio Value"
                                                   id="portfoliovalue" name="portfoliovalue" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Payable</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Payable"
                                                   id="payable" name="payable" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Receivable</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Receivable"
                                                   id="receivable" name="receivable" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Collateral Ratio</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Collateral Ratio"
                                                   id="collateralratio" name="collateralratio" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Buy Value</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Buy Value"
                                                   id="buyvalue" name="buyvalue" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Sell Value</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Sell Value"
                                                   id="sellvalue" name="sellvalue" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Buying Limit</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Buying Limit"
                                                   id="buyinglimit" name="buyinglimit" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Credit Limit</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Credit Limit"
                                                   id="creditlimit" name="creditlimit" onchange="checking(this)" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Temp. Limit</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 text-right" type="text" placeholder="Temp. Additional Limit"
                                                   id="tempadditionallimit" name="tempadditionallimit" onchange="checking(this)"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-inline justify-content-end pr-2">
                                <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveUser">Update</button>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="table-reggroup">
                                <thead class="bg-gradient-primary text-lighter">
                                <tr>
                                    <th>User Name</th>
                                    <th>User Code</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>MSIDN</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Last Teriminal ID</th>
                                    <th>Login Attempt</th>
                                    <th>PIN Attempt</th>
                                    <th>PIN Locked</th>
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

    <!-- Modal Users List -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Users List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-listmember">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th data-priority="1">User Code</th>
                                <th data-priority="3">User Name</th>
                                <th data-priority="2">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                {{--<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>--}}
            </div>
        </div>
    </div>

@endsection