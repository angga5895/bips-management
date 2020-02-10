@extends('layouts.app-argon')

@section('js')
    <script>
        $(document).ready(function () {
            $('.bootstrap-select').selectpicker();
        });

        $("#canceluser").on("click", function () {
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");
        });

        function cekUsername() {
            var us = $("#username").val();
            var ushidden = $("#husername").val();

            if(us !== ''){$("#cekUsername").text('');$("#username").removeClass("is-invalid");}

            if (us !== ushidden){
                $.ajax({
                    type : "GET",
                    url  : "{{ url('username-unique') }}",
                    data : {'username' : us},
                    success : function (res) {
                        if ($.trim(res)){
                            $("#username").val('');
                            $("#username").addClass("is-invalid");
                            $("#username").focus();
                            $("#cekUsername").text('Username already exist.');
                        }
                    }
                });
            }
        }

        function clickOKClient(id,group) {
            $("#groupID").val(group);
            $("#client_id").val(id);
            $("#cekClientID").text('');$("#client_id").removeClass("is-invalid");
        }

        function clientlist(){
            $('#exampleModal2').modal('show', function () {
                $('#table-listclient').DataTable().ajax.reload();
            });
            tableClient();
        }

        function tableClient() {
            var usertype = $("#user_type").val();

            if(usertype === '1'){
                var id = 'slscode';
                var name = 'slsname';
                $("#exampleModalLabel2").text('Trader List');
                $("#idClident").text('Sales Code');
                $("#nameClient").text('Sales Name');
            } else if(usertype === '2'){
                var id = 'dlrcode';
                var name = 'dlrname';
                $("#exampleModalLabel2").text('Dealer List');
                $("#idClident").text('Dealer Code');
                $("#nameClient").text('Dealer Name');
            } else if(usertype === '3'){
                var id = 'custcode';
                var name = 'custname';
                $("#exampleModalLabel2").text('Customers List');
                $("#idClident").text('Customer Code');
                $("#nameClient").text('Customer Name');
            } else{
                var id = '';
                var name = '';
            }

            $("#table-listclient").DataTable({
                destroy: true,
                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("get-dataClient/get") }}',
                    data: function (d) {
                        var search_data = {userType:usertype};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : id, name : id},
                    {data : name, name: name},
                    {data : id, name: id},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : true
                },{
                    targets : [1],
                    orderable : true,
                    searchable : false,
                },{
                    targets : [2],
                    orderable:false,
                    searchable : false,
                    render : function (data, type, row) {
                        var groupid = row.groupid;
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOKClient(\''+data+'\',\''+groupid+'\')">OK</button>'
                    }
                }]
            });
        }

        function checkUserType() {
            var usertype = $("#user_type").val();
            if(usertype !== null){$("#cekUsertype").text('');$(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
                $("#cekClientID").text('');$("#client_id").removeClass("is-invalid");
                $("#client_id").val('');
                $("#groupID").val('');
            }
        }

        function checking() {
            var usertype = $("#user_type").val();
            var userstatus = $("#user_status").val();
            var expire = $("#datepicker-base").val();
            var clientid = $("#client_id").val();

            if(usertype !== null){$("#cekUsertype").text('');$(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");}
            if(userstatus !== null){$("#cekUserstatus").text('');$(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");}
            if(expire !== ''){$("#cekExpire").text('');$("#errExpire").removeClass("d-border-error");}
        }

        $("#saveuser").on("click", function () {
            var id = $("#userID").val();
            var username = $("#username").val();
            var usertype = $("#user_type").val();
            var userstatus = $("#user_status").val();
            var expire = $("#datepicker-base").val();
            var groupid = $("#groupID").val();
            var hgroupid = $("#hgroupID").val();
            var clientid = $("#client_id").val();
            var hclientid = $("#hclient_id").val();
            var salesid = $("#sales_id").val();

            var required = "Field is required.";

            if (username !== '' && usertype !== null && userstatus !== null && expire !== ''){
                if((usertype === '1' || usertype === '2' || usertype === '3') && clientid === ''){
                    $("#cekClientID").text(required);$("#client_id").addClass("is-invalid");$("#client_id").focus();
                } else {
                    $.get("/mockjax");

                    $.ajax({
                        type: "GET",
                        url: "{{ url('username-update') }}",
                        data: {
                            'id': id,
                            'username': username,
                            'user_type': usertype,
                            'user_status': userstatus,
                            'expire_date': expire,
                            'group': groupid,
                            'client_id': clientid,
                            'hclient_id': hclientid,
                            'sales_id': salesid,
                            'hgroup': hgroupid,
                        },
                        success: function (res) {
                            if ($.trim(res)) {
                                if (res.status === "00") {
                                    swal({
                                        title: res.user,
                                        text: "Has Updated",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn-success',
                                        confirmButtonText: 'OK'
                                    }, function () {
                                        window.location.href = "{{route('user')}}";
                                    });
                                }
                            }
                        }
                    });
                }
            } else {
                if(username === ''){$("#cekUsername").text(required);$("#username").addClass("is-invalid");$("#username").focus();}
                if(usertype === null){$("#cekUsertype").text(required);$(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_type").focus();}
                if(userstatus === null){$("#cekUserstatus").text(required);$(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_status").focus();}
                if(expire === ''){$("#cekExpire").text(required);$("#errExpire").addClass("d-border-error");$("#datepicker-base").focus();}

                if(usertype === '1' || usertype === '2' || usertype === '3'){
                    if(clientid === ''){$("#cekClientID").text(required);$("#client_id").addClass("is-invalid");$("#client_id").focus();}
                }
            }
        });

        $("#btn-clientid").on("click", function () {
            var usertype = $("#user_type").val();

            if (usertype === '' || usertype === null){
                swal({
                    title: "User type is empty!",
                    text: "Please select user type before.",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: 'OK'
                }, function () {
                    var required = "Field is required.";
                    $("#cekUsertype").text(required);$(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_type").focus();
                });
            } else {
                if (usertype === '1' || usertype === '2' || usertype === '3'){
                    clientlist();
                } else {
                    swal({
                        title: "Not Available",
                        text: "",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: 'btn-danger',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    </script>
@endsection

@section('content')
    <?php
        function rollbackFormatDate($tanggal){
            $fulldate = explode(" ",$tanggal);

            $date = $fulldate[0];
            $tgl = explode("-",$date);

            $day = $tgl[2];
            $month = $tgl[1];
            $year = $tgl[0];

            return $day."/".$month."/".$year;
        }
    ?>

    <div class="modal-ajax"></div>
    <div class="header text-white">
        <div class="row col-xs-0">
            <div class="col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb" class="d-inline-block ml-0 w-100">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-2">
                        {{--<li class="breadcrumb-item"><a href="#"><i class="ni ni-single-02"></i> Dashboards</a></li>--}}
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i> User Admin</li>
                        <li class="breadcrumb-item active">User</li>
                        <li class="breadcrumb-item active">Edit</li>
                        @foreach($userbips as $p)
                            <li class="breadcrumb-item active" aria-current="page">{{ $p->username }}</li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <form>
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            @foreach($userbips as $p)
                                <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User ID</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="User ID" readonly id="userID" value="{{ $p->id }}"/>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input username" id="username" onchange="cekUsername()" value="{{ $p->username }}"/>
                                    <input type="hidden" id="husername" value="{{ $p->username }}"/>
                                    <label id="cekUsername" class="error invalid-feedback small d-block col-sm-4" for="username"></label>
                                </div>
                                <div class="form-group form-inline lbl-user-status">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Status</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_status" onchange="checking()">
                                        <option value="" disabled>Choose User Status</option>
                                        @foreach($userstatus as $r)
                                            <option @if((int)$p->user_status === (int)$r->id) selected="selected" @endif value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUserstatus" class="error invalid-feedback small d-block col-sm-4" for="user_status"></label>
                                </div>
                                <div class="form-group form-inline lbl-user-type">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User Type</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_type" onchange="checkUserType()">
                                        <option value="" disabled>Choose User Type</option>
                                        @foreach($usertype as $r)
                                            <option @if((int)$p->user_type === (int)$r->id) selected="selected" @endif value={{ $r->id }}>{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUsertype" class="error invalid-feedback small d-block col-sm-4" for="user_type"></label>
                                </div>

                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Client Code</label>
                                    <div class="input-group col-sm-6 px-0">
                                        <input class="form-control" type="text" placeholder="Client ID" readonly id="client_id" value="{{ $p->client_id }}" onchange="checkUserType()"/>
                                        <input class="form-control" type="hidden" placeholder="Client ID" readonly id="hclient_id" value="{{ $p->client_id }}"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text btn btn-default" id="btn-clientid">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <label id="cekClientID" class="error invalid-feedback small d-block col-sm-4" for="client_id"></label>
                                </div>

                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group ID</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Group ID" id="groupID" onchange="checking()" value="{{ $p->group }}" readonly/>
                                    <input class="form-control col-sm-6" type="hidden" placeholder="Group ID" id="hgroupID" value="{{ $p->group }}" readonly/>
                                    <label id="cekGroupID" class="error invalid-feedback small d-block col-sm-4" for="groupID"></label>
                                </div>

                                {{--<div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales ID</label>--}}
                                    <input class="form-control col-sm-6" type="hidden" placeholder="Sales ID" readonly id="sales_id" value="{{ $p->sales_id }}"/>
                                    {{--<label id="cekSalesID" class="error invalid-feedback small d-block col-sm-4" for="sales_id"></label>
                                </div>--}}
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Expire Date</label>
                                    <div class="input-group input-group-alternative col-sm-6 d-border-input" id="errExpire">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <?php
                                            $datebips = rollbackFormatDate($p->expire_date);
                                        ?>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" id="datepicker-base" readonly style="background: white" data-date-start-date="0d" onchange="checking()" value="{{ $datebips }}">
                                    </div>
                                    <label id="cekExpire" class="error invalid-feedback small d-block col-sm-4" for="datepicker-base"></label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="saveuser">Update</button>
                    <a class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser" href="{{ route('user') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Client List -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-listclient">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th id="idClident"></th>
                                <th id="nameClient"></th>
                                <th>#</th>
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
