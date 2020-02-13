@extends('layouts.app-argon')

@section('js')
    <script>
        function getDateBips(tanggal){
            var datetime = tanggal.split(" ");
            var tgl = datetime[0].split("-");

            var year = tgl[0];

            if (tgl[1] == '01' ||tgl[1] == '1'){
                var month = 'January';
            } else if (tgl[1] == '02' ||tgl[1] == '2'){
                var month = 'February';
            } else if (tgl[1] == '03' ||tgl[1] == '3'){
                var month = 'March';
            } else if (tgl[1] == '04' ||tgl[1] == '4'){
                var month = 'April';
            } else if (tgl[1] == '05' ||tgl[1] == '5'){
                var month = 'Mei';
            } else if (tgl[1] == '06' ||tgl[1] == '6'){
                var month = 'June';
            } else if (tgl[1] == '07' ||tgl[1] == '7'){
                var month = 'July';
            } else if (tgl[1] == '08' ||tgl[1] == '8'){
                var month = 'August';
            } else if (tgl[1] == '09' ||tgl[1] == '9'){
                var month = 'September';
            } else if (tgl[1] == '10'){
                var month = 'October';
            } else if (tgl[1] == '11'){
                var month = 'November';
            } else if (tgl[1] == '12'){
                var month = 'December';
            }

            var date = tgl[2];

            return date+" "+month+" "+year;
        }

        $(document).ready(function () {
            tablegetReg();
            tablelist();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
        });

        function refreshTablemember(){
            $('#table-listmember').DataTable().ajax.reload();
        }

        function clickOK(id) {
            $("#userID").val(id);
            getUsername();
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
                        var ustype = $("#user_type").val();
                        var groupid = row.groupid;
                        if (ustype === '2' || ustype === 2){
                            groupid = ''
                        }

                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOKClient(\''+data+'\',\''+groupid+'\')">OK</button>'
                    }
                }]
            });
        }

        function tablelist() {
            $("#table-listmember").DataTable({
                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("get-dataRegistrasi/get") }}',
                    data: function (d) {
                        var search_data = {userID:""};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'id', name : 'id'},
                    {data : 'username', name: 'username'},
                    {data : 'id', name: 'id'},
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
                        var id = row.id;
                        var us = row.username;
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+id+')">OK</button>'
                    }
                }]
            });
        }

        function tablegetReg() {
            var tableData = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                aaSorting: [[0, 'desc']],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-primary mb-2" type="button" id="adduser" onclick="addUser()">Add</button>');
                },
                ajax : {
                    url: '{{ url("get-dataRegistrasi/get") }}',
                    data: function (d) {
                        var search_data = {userID:$("#userID").val()};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'id', name : 'id'},
                    {data : 'username', name: 'username'},
                    {data : 'groupname', name: 'groupname'},
                    {data : 'type', name: 'type'},
                    {data : 'status', name: 'status'},
                    {data : 'expire_date', name: 'expire_date'},
                    {data : 'id', name: 'id'},
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
                    targets : [4],
                    searchable : true,
                },{
                    searchable : true,
                    targets : [5],
                    render : function (data, type, row) {
                        return getDateBips(data)
                    }
                },{
                    searchable : true,
                    targets : [6],
                    render : function (data, type, row) {
                        return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>'
                    }
                }]
            });
        }

        function addUser() {
            var id = $("#adduserID").val();
            $.ajax({
                type : "GET",
                url  : "{{ url('get-iduser') }}",
                success : function (res) {
                    if ($.trim(res)){
                        $("#adduserID").val(res.userID);
                    }
                }
            });

            $("#username").val('');
            $("#client_id").val('');
            $("#groupID").val('');

            $("[id=user_type]").val('');
            $("[data-id=user_type] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Type');
            $("[id=user_status]").val('');
            $("[data-id=user_status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Status');

            $("#password").val('');
            $("#password-confirm").val('');
            $("#datepicker-base").val('');

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            clearCache();
        };

        $("#canceluser").on("click", function () {
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");
        });

        function cekUsername() {
            var us = $("#username").val();

            if(us !== ''){$("#cekUsername").text('');$("#username").removeClass("is-invalid");}

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

        function checkUserType() {
            var usertype = $("#user_type").val();
            if(usertype !== null){$("#cekUsertype").text('');$(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
                $("#cekClientID").text('');$("#client_id").removeClass("is-invalid");
                $("#client_id").val('');
                $("#groupID").val('');
            }
        }

        function checking() {
            var pass = $("#password").val();
            var cpass = $("#password-confirm").val();

            if(cpass !== '') {
                if (pass != cpass) {
                    var cekpass = document.getElementById('cekCPassword');
                    cekpass.innerHTML = 'Password confirm is wrong.';
                    $("#password-confirm").addClass("is-invalid");
                    $("#password-confirm").val('');
                    $("#password-confirm").focus();
                } else if (pass == cpass) {
                    var cekpass = document.getElementById('cekCPassword');
                    cekpass.innerHTML = '';
                }
            }

            var clientid = $("#client_id").val();
            var userstatus = $("#user_status").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var expire = $("#datepicker-base").val();

            if(userstatus !== null){$("#cekUserstatus").text('');$(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");}
            if(password !== ''){$("#cekPassword").text('');$("#password").removeClass("is-invalid");}
            if(cpassword !== ''){$("#cekCPassword").text('');$("#password-confirm").removeClass("is-invalid");}
            // if(clientid !== ''){$("#cekClientID").text('');$("#client_id").removeClass("is-invalid");}
            if(expire !== ''){$("#cekExpire").text('');$("#errExpire").removeClass("d-border-error");}
        }

        function clearCache(){
            var usertype = $("#user_type").val();
            var userstatus = $("#user_status").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var expire = $("#datepicker-base").val();

            $("#cekUsertype").text('');$(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
            $("#cekUserstatus").text('');$(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
            $("#cekUsername").text('');$("#username").removeClass("is-invalid");
            $("#cekPassword").text('');$("#password").removeClass("is-invalid");
            $("#cekCPassword").text('');$("#password-confirm").removeClass("is-invalid");
            $("#cekExpire").text('');$("#errExpire").removeClass("d-border-error");
            $("#cekClientID").text('');$("#client_id").removeClass("is-invalid");
        }

        $("#saveuser").on("click", function () {
            var username = $("#username").val();
            var usertype = $("#user_type").val();
            var userstatus = $("#user_status").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var expire = $("#datepicker-base").val();
            var clientid = $("#client_id").val();
            var groupid = $("#groupID").val();

            var required = "Field is required.";

            if (username !== '' && usertype !== null && userstatus !== null && password !== ''
                && cpassword !== '' && expire !== '' /*&& clientid !== ''*/){
                if((usertype === '1' || usertype === '2' || usertype === '3') && clientid === ''){
                    $("#cekClientID").text(required);$("#client_id").addClass("is-invalid");$("#client_id").focus();
                } else {
                    $.get("/mockjax");

                    $.ajax({
                        type : "GET",
                        url  : "{{ url('username-registrasi') }}",
                        data : {
                            'username' : username,
                            'password' : password,
                            'user_type' : usertype,
                            'client_id' : clientid,
                            'user_status' : userstatus,
                            'expire_date' : expire,
                            'group' : groupid,
                            'sales_id' : $("#sales_id").val(),
                        },
                        success : function (res) {
                            if ($.trim(res)){
                                if (res.status === "00"){
                                    $('#table-reggroup').DataTable().ajax.reload();
                                    $("#add-user").removeClass("d-block");
                                    $("#add-user").addClass("d-none");
                                    $("#main-user").removeClass("d-none");
                                    $("#main-user").addClass("d-block");
                                    $("#regisuser").text(res.user);
                                    $("#alert-success-registrasi").removeClass("d-none");
                                    $("#alert-success-registrasi").addClass("d-block");
                                }
                            }
                        }
                    });
                }
            } else {
                if(username === ''){$("#cekUsername").text(required);$("#username").addClass("is-invalid");$("#username").focus();}
                if(usertype === null){$("#cekUsertype").text(required);$(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_type").focus();}
                if(userstatus === null){$("#cekUserstatus").text(required);$(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_status").focus();}
                if(password === ''){$("#cekPassword").text(required);$("#password").addClass("is-invalid");$("#password").focus();}
                if(cpassword === ''){$("#cekCPassword").text(required);$("#password-confirm").addClass("is-invalid");$("#password-confirm").focus();}
                if(expire === ''){$("#cekExpire").text(required);$("#errExpire").addClass("d-border-error");$("#datepicker-base").focus();}

                if(usertype === '1' || usertype === '2' || usertype === '3'){
                    if(clientid === ''){$("#cekClientID").text(required);$("#client_id").addClass("is-invalid");$("#client_id").focus();}
                }
            }
        });

        $("#btn-current").on("click", function(){
            getUsername();
        });

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
                            $("#usernameGet").val(res[0].username);
                        } else {
                            $("#usernameGet").val('');
                        }
                        $('#table-reggroup').DataTable().ajax.reload();
                    }
                });
            }
        }

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
    <div class="modal-ajax"></div>
    <div class="header text-white">
        <div class="row col-xs-0">
            <div class="col-sm-12 col-xs-12">
                <nav aria-label="breadcrumb" class="d-inline-block ml-0 w-100">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-2">
                        {{--<li class="breadcrumb-item"><a href="#"><i class="ni ni-single-02"></i> Dashboards</a></li>--}}
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i> User Admin</li>
                        <li class="breadcrumb-item active" aria-current="page">User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow" id="main-user">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">User ID</label>
                <input class="form-control mb-2" placeholder="Input ID User" id="userID" onchange="getUsername()">
                <input class="form-control mb-2 ml-input-2" placeholder="Name Of User" id="usernameGet" readonly>
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1" onclick="refreshTablemember()"><i class="fa fa-search"></i></button>
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current">Search</button>
            </form>
        </div>

        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-success-registrasi">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="regisuser"></strong>, has registered.</span>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-reggroup">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Group Name</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Expire Date</th>
                                        <th>Action</th>
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

    <div class="card shadow d-none" id="add-user">
        <form>
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User ID</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="User ID" readonly id="adduserID"/>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input username" id="username" onchange="cekUsername()"/>
                                    <label id="cekUsername" class="error invalid-feedback small d-block col-sm-4" for="username"></label>
                                </div>
                                <div class="form-group form-inline lbl-user-status">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Status</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_status" onchange="checking()">
                                        <option value="" disabled selected>Choose User Status</option>
                                        @foreach($userstatus as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUserstatus" class="error invalid-feedback small d-block col-sm-4" for="user_status"></label>
                                </div>
                                <div class="form-group form-inline lbl-user-type">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User Type</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_type" onchange="checkUserType()">
                                        <option value="" disabled selected>Choose User Type</option>
                                        @foreach($usertype as $p)
                                            <option value={{ $p->id }}>{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUsertype" class="error invalid-feedback small d-block col-sm-4" for="user_type"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Client Code</label>
                                    <div class="input-group col-sm-6 px-0">
                                        <input class="form-control" type="text" placeholder="Client ID" readonly id="client_id" onchange="checkUserType()"/>
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
                                    <input class="form-control col-sm-6" type="text" placeholder="Group ID" id="groupID" onchange="checking()" readonly/>
                                    <label id="cekGroupID" class="error invalid-feedback small d-block col-sm-4" for="groupID"></label>
                                    {{--<select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" disabled id="user_group" onchange="checking()">
                                        <option value="" disabled selected>Please Choose</option>
                                    </select>--}}
                                </div>
                                {{--<div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales ID</label>--}}
                                    <input class="form-control col-sm-6" type="hidden" placeholder="Sales ID" readonly id="sales_id"/>
                                    {{--<label id="cekSalesID" class="error invalid-feedback small d-block col-sm-4" for="sales_id"></label>--}}
                                {{--</div>--}}
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Password</label>
                                    <input class="form-control col-sm-6" type="password" placeholder="Please Input" id="password" onchange="checking()"/>
                                    <label id="cekPassword" class="error invalid-feedback small d-block col-sm-4" for="password"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Confirm Password</label>
                                    <input class="form-control col-sm-6" type="password" placeholder="Please Input" id="password-confirm" onchange="checking()"/>
                                    <label id="cekCPassword" class="error invalid-feedback small d-block col-sm-4" for="password-confirm"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Expire Date</label>
                                    <div class="input-group input-group-alternative col-sm-6 d-border-input" id="errExpire">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" id="datepicker-base" readonly style="background: white" data-date-start-date="0d" onchange="checking()">
                                    </div>
                                    <label id="cekExpire" class="error invalid-feedback small d-block col-sm-4" for="datepicker-base"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveuser">Save</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Employees List -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employees List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-listmember">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Employee No</th>
                                <th>Employee Name</th>
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
