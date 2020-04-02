@extends('layouts.app-argon')

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            } else {
                return true;
            }
        }

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
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });
        });

        function refreshTablemember(){
            $('#table-listmember').DataTable().ajax.reload();
        }

        function clickOK(id) {
            $("#userID").val(id);
            getUsername();
        }

        function clickOKClient(user_id,user_name,email_address,msidn,hash_password,hash_pin) {
            $("#client_id").val(user_id);
            $("#user_id").val(user_id);
            $("#user_name").val(user_name);
            $("#email_address").val(email_address);
            $("#msidn").val(msidn);
            $("#password").val(hash_password);
            $("#password-confirm").val(hash_password);
            $("#pin").val(hash_pin);
            $("#pin-confirm").val(hash_pin);

            checkCache();
        }

        function clientlist(){
            $('#exampleModal2').modal('show', function () {
                $('#table-listclient').DataTable().ajax.reload();
            });
            tableClient();
        }

        function tableClient() {
            var usertype = $("#user_type").val();

            if(usertype === 'S'){
                var id = 'user_id';
                var name = 'sales_name';
                $("#exampleModalLabel2").text('Trader List');
                $("#idClident").text('Sales Code');
                $("#nameClient").text('Sales Name');
            } else if(usertype === 'D'){
                var id = 'user_id';
                var name = 'dealer_name';
                $("#exampleModalLabel2").text('Dealer List');
                $("#idClident").text('Dealer Code');
                $("#nameClient").text('Dealer Name');
            } else if(usertype === 'C'){
                var id = 'user_id';
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
                        var usertype = $("#user_type").val();
                        var arrRow = [];
                        if (usertype === 'C'){
                            var user_id = row.user_id.toLowerCase(); //user_id
                            var user_name = row.custname; //user_name
                            var email_address = row.email; //email_address
                            var msidn = row.phonecell; //msidn
                            var hash_password = (row.user_password === null) ? '' : row.user_password; //hash_password
                            var hash_pin = (row.user_pin === null) ? '' : row.user_pin; //hash_pin
                        } else if (usertype === 'D'){
                            var user_id = row.user_id.toLowerCase(); //user_id
                            var user_name = row.dealer_name; //user_name
                            var email_address = (row.email === null) ? '' : row.email; //email_address
                            var msidn = (row.mobilephone === null) ? '' : row.mobilephone; //msidn
                            var hash_password = ''; //hash_password
                            var hash_pin = ''; //hash_pin
                        } else if (usertype === 'S'){
                            var user_id = row.user_id.toLowerCase(); //user_id
                            var user_name = row.sales_name; //user_name
                            var email_address = (row.email === null) ? '' : row.email; //email_address
                            var msidn = (row.mobilephone === null) ? '' : row.mobilephone; //msidn
                            var hash_password = ''; //hash_password
                            var hash_pin = ''; //hash_pin
                        }

                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOKClient(\''
                            +data.toLowerCase()+'\',\''
                            +user_name+'\',\''
                            +email_address+'\',\''
                            +msidn+'\',\''
                            +hash_password+'\',\''
                            +hash_pin+'\')">OK</button>'
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
                    {data : 'user_id', name : 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'user_id', name: 'user_id'},
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
                        var uid = row.user_id;
                        var us = row.user_name;
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+uid+'\')">OK</button>'
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
                    {data : 'user_id', name : 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'email_address', name: 'email_address'},
                    {data : 'msidn', name: 'msidn'},
                    {data : 'usertype', name: 'usertype'},
                    {data : 'userstatus', name: 'userstatus'},
                    {data : 'last_login', name: 'last_login'},
                    {data : 'user_id', name: 'user_id'},
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
                },{
                    searchable : true,
                    targets : [6],
                    render : function (data, type, row) {
                        return getDateBips(data)
                    }
                },{
                    searchable : true,
                    targets : [7],
                    render : function (data, type, row) {
                        return '<a class="btn btn-sm btn-warning" href="/user/'+data+'/edit" data-toggle="tooltip" data-placement="top" title="Edit Status">' +
                            '<i class="fa fa-pen"></i>' +
                            '</a>' +
                            '<a class="btn btn-sm btn-facebook" href="/user" data-toggle="tooltip" data-placement="top" title="Reset Password">' +
                            '<i class="fa fa-lock-open"></i>' +
                            '</a>' +
                            '<a class="btn btn-sm btn-dark" href="/user" data-toggle="tooltip" data-placement="top" title="Reset PIN">' +
                            '<i class="fa fa-qrcode"></i>' +
                            '</a>'
                    }
                }]
            });
        }

        function addUser() {
            $("[id=user_type]").val('');
            $("[data-id=user_type] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Type');
            $("[id=user_status]").val('');
            $("[data-id=user_status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Status');

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");

            clearCache();
        };

        $("#canceluser").on("click", function () {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $("#add-user").removeClass("d-block");
                        $("#add-user").addClass("d-none");
                        $("#main-user").removeClass("d-none");
                        $("#main-user").addClass("d-block");
                    }
                }
            )
        });

        function checkUserType() {
            var usertype = $("#user_type").val();
            if(usertype !== null){
                if(usertype === 'T'){
                    $("#useridT").removeClass("d-none");
                    $("#useridCDS").addClass("d-none");
                    clearCache();
                } else {
                    $("#useridCDS").removeClass("d-none");
                    $("#useridT").addClass("d-none");
                    clearCache();
                }
            }
        }

        function checking(these) {
            var pass = $("#password").val();
            var cpass = $("#password-confirm").val();
            var pin = $("#pin").val();
            var cpin = $("#pin-confirm").val();

            if(cpass !== '') {
                if (pass != cpass) {
                    var cekpass = document.getElementById('cekPassword-confirm');
                    cekpass.innerHTML = 'Password confirm is wrong.';
                    $("#password-confirm").addClass("is-invalid");
                    $("#password-confirm").val('');
                    $("#password-confirm").focus();
                } else if (pass == cpass) {
                    var cekpass = document.getElementById('cekPassword-confirm');
                    cekpass.innerHTML = '';
                }
            }

            if(cpin !== '') {
                if (pin != cpin) {
                    var cekpin = document.getElementById('cekPin-confirm');
                    cekpin.innerHTML = 'Pin confirm is wrong.';
                    $("#pin-confirm").addClass("is-invalid");
                    $("#pin-confirm").val('');
                    $("#pin-confirm").focus();
                } else if (pin == cpin) {
                    var cekpin = document.getElementById('cekPin-confirm');
                    cekpin.innerHTML = '';
                }
            }

            if ($(these).val() !== ''){
                var str = $(these).attr("id");
                str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });

                $("#cek"+str).text('');

                if (str === 'User_type'){
                    $(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
                }

                if (str === 'User_status'){
                    $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                }
            }
        }

        function checkCache(){
            var user_id = $("#client_id");
            var user_idT = $("#client_id_t");
            var user_name = $("#user_name");
            var email_address = $("#email_address");
            var msidn = $("#msidn");
            var hash_password = $("#password");
            var hash_pin = $("#pin");
            var hash_password_confirm = $("#password-confirm");
            var hash_pin_confirm = $("#pin-confirm");
            var user_type = $("#user_type");
            var user_status = $("#user_status");

            //lbl
            var cekUser_id = $("#cekClient_id");
            var cekUser_idT = $("#cekClient_id_t");
            var cekUser_name = $("#cekUser_name");
            var cekEmail_address = $("#cekEmail_address");
            var cekMsidn = $("#cekMsidn");
            var cekHash_password = $("#cekPassword");
            var cekHash_password_confirm = $("#cekPassword-confirm");
            var cekHash_pin = $("#cekPin");
            var cekHash_pin_confirm = $("#cekPin-confirm");
            var cekUser_type = $("#cekUser_type");
            var cekUser_status = $("#cekUser_status");
            
            if(!user_status[0].checkValidity()){cekUser_status.text(user_status[0].validationMessage);$(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");user_status.focus();}
            else {cekUser_status.text('');$(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");}

            if(!user_type[0].checkValidity()){cekUser_type.text(user_type[0].validationMessage);$(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");user_type.focus();}
            else {cekUser_type.text('');$(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");}

            if(!user_name[0].checkValidity()){cekUser_name.text(user_name[0].validationMessage);user_name.addClass("is-invalid");user_name.focus();}
            else {cekUser_name.text('');user_name.removeClass("is-invalid");}

            if(!email_address[0].checkValidity()){cekEmail_address.text(email_address[0].validationMessage);email_address.addClass("is-invalid");email_address.focus();}
            else {cekEmail_address.text('');email_address.removeClass("is-invalid");}

            if(!msidn[0].checkValidity()){cekMsidn.text(msidn[0].validationMessage);msidn.addClass("is-invalid");msidn.focus();}
            else {cekMsidn.text('');msidn.removeClass("is-invalid");}

            if(!hash_password[0].checkValidity()){cekHash_password.text(hash_password[0].validationMessage);hash_password.addClass("is-invalid");hash_password.focus();}
            else {cekHash_password.text('');hash_password.removeClass("is-invalid");}

            if(!hash_password_confirm[0].checkValidity()){cekHash_password_confirm.text(hash_password_confirm[0].validationMessage);hash_password_confirm.addClass("is-invalid");hash_password_confirm.focus();}
            else {cekHash_password_confirm.text('');hash_password_confirm.removeClass("is-invalid");}

            if(!hash_pin[0].checkValidity()){cekHash_pin.text(hash_pin[0].validationMessage);hash_pin.addClass("is-invalid");hash_pin.focus();}
            else {cekHash_pin.text('');hash_pin.removeClass("is-invalid");}

            if(!hash_pin_confirm[0].checkValidity()){cekHash_pin_confirm.text(hash_pin_confirm[0].validationMessage);hash_pin_confirm.addClass("is-invalid");hash_pin_confirm.focus();}
            else {cekHash_pin_confirm.text('');hash_pin_confirm.removeClass("is-invalid");}

            if(user_type.val() === 'T'){
                if(!user_idT[0].checkValidity()){cekUser_idT.text(user_idT[0].validationMessage);user_idT.addClass("is-invalid");user_idT.focus();}
                else {cekUser_idT.text('');user_id.removeClass("is-invalid");}
            } else{
                if(!user_id[0].checkValidity()){cekUser_id.text(user_id[0].validationMessage);user_id.addClass("is-invalid");user_id.focus();}
                else {cekUser_id.text('');user_id.removeClass("is-invalid");}
            }
        }

        function clearCache(){
            $("#cekUser_type").text('');
            $(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");

            $("#cekUser_status").text('');
            $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");

            $("#cekClient_id").text('');
            $("#client_id").removeClass("is-invalid");
            $("#client_id").val('');

            $("#cekClient_id_t").text('');
            $("#client_id_t").removeClass("is-invalid");
            $("#client_id_t").val('');

            $("#cekUser_name").text('');
            $("#user_name").removeClass("is-invalid");
            $("#user_name").val('');

            $("#cekEmail_address").text('');
            $("#email_address").removeClass("is-invalid");
            $("#email_address").val('');

            $("#cekMsidn").text('');
            $("#msidn").removeClass("is-invalid");
            $("#msidn").val('');

            $("#cekPassword").text('');
            $("#password").removeClass("is-invalid");
            $("#password").val('');

            $("#cekPassword-confirm").text('');
            $("#password-confirm").removeClass("is-invalid");
            $("#password-confirm").val('');

            $("#cekPin").text('');
            $("#pin").removeClass("is-invalid");
            $("#pin").val('');

            $("#cekPin-confirm").text('');
            $("#pin-confirm").removeClass("is-invalid");
            $("#pin-confirm").val('');
        }

        function resetApp(){
            $("[id=user_type]").val('');
            $("[data-id=user_type] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Type');
            $("[id=user_status]").val('');
            $("[data-id=user_status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose User Status');

            clearCache();
        }

        $("#saveuser").on("click", function () {
            var user_type = $("#user_type").val();
            var user_status = $("#user_status").val();
            var user_name = $("#user_name").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var pin = $("#pin").val();
            var cpin = $("#pin-confirm").val();

            var email_address = $("#email_address").val();
            var msidn = $("#msidn").val();

            if (user_type === 'T'){
                var user_id = $("#client_id_t").val();
            } else {
                var user_id = $("#client_id").val();
            }

            var emailaddress = $("#email_address");
            var hashpin = $("#pin");
            var hashpinconfirm = $("#pin-confirm");

            if (user_name !== '' && user_type !== null && user_status !== null && password !== '' && cpassword !== ''
                && pin !== '' && cpin !== '' && user_id !== '' && msidn !== '' && email_address !== ''
                && emailaddress[0].checkValidity() && hashpin[0].checkValidity() && hashpinconfirm[0].checkValidity()
            ){
                $.get("/mockjax");

                $.ajax({
                    type : "GET",
                    url  : "{{ url('username-registrasi') }}",
                    data : {
                        'user_id' : user_id,
                        'user_name' : user_name,
                        'email_address' : email_address,
                        'msidn' : msidn,
                        'hash_password' : password,
                        'hash_pin' : pin,
                        'user_type' : user_type,
                        'user_status' : user_status,
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
                            } else {
                                $('#table-reggroup').DataTable().ajax.reload();
                                $("#add-user").removeClass("d-block");
                                $("#add-user").addClass("d-none");
                                $("#main-user").removeClass("d-none");
                                $("#main-user").addClass("d-block");
                                $("#messageuser").text(res.message);
                                $("#alert-error-registrasi").removeClass("d-none");
                                $("#alert-error-registrasi").addClass("d-block");
                            }
                        }
                    }
                });
            } else {
                checkCache();
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
                            $("#usernameGet").val(res[0].user_name);
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
                    $("#cekUser_type").text(required);$(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");$("#user_type").focus();
                });
            } else {
                // if (usertype === 'C' || usertype === 'D' || usertype === 'S'){
                if (usertype === 'C'){
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-reggroup">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>MSIDN</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
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

                                <div class="form-group form-inline lbl-user-type">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">User Type</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_type" onchange="checkUserType()" required>
                                        <option value="" disabled selected>Choose User Type</option>
                                        @foreach($usertype as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUser_type" class="error invalid-feedback small d-block col-sm-4" for="user_type"></label>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-inline">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User ID</label>
                                            <div class="col-sm-9 px-0 row" id="useridCDS">
                                                <div class="input-group col-sm-12 px-0">
                                                    <input class="form-control readonly" type="text" placeholder="User ID" id="client_id" required/>
                                                    <input class="form-control" type="hidden" id="user_id" required/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text btn btn-default" id="btn-clientid">
                                                            <i class="fa fa-search"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <label id="cekClient_id" class="error invalid-feedback small col-sm-12 px-0" for="client_id" style="justify-content: flex-start;"></label>
                                            </div>
                                            <div class="col-sm-9 px-0 d-none row" id="useridT">
                                                <input class="form-control col-sm-12" type="text" placeholder="User ID" id="client_id_t" onchange="checking(this)" required/>
                                                <label id="cekClient_id_t" class="error invalid-feedback small col-sm-12 px-0" for="client_id_t"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Name</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="text" placeholder="User Name" id="user_name" onchange="checking(this)" required/>
                                                <label id="cekUser_name" class="error invalid-feedback small d-block col-sm-12 px-0" for="user_name"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Email</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="email" placeholder="Email" id="email_address" onchange="checking(this)" required/>
                                                <label id="cekEmail_address" class="error invalid-feedback small d-block col-sm-12 px-0" for="email_address"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">MSIDN</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="text" placeholder="MSIDN" id="msidn" onchange="checking(this)" required/>
                                                <label id="cekMsidn" class="error invalid-feedback small d-block col-sm-12 px-0" for="msidn"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-inline">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Password</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input" id="password" onchange="checking(this)" required/>
                                                <label id="cekPassword" class="error invalid-feedback small d-block col-sm-12 px-0" for="password"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Confirm Password</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input" id="password-confirm" onchange="checking(this)" required/>
                                                <label id="cekPassword-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="password-confirm"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">PIN</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input" id="pin" onchange="checking(this)" onkeypress="return hanyaAngka(event)" maxlength="6" pattern="\d+" required/>
                                                <label id="cekPin" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Confirm PIN</label>
                                            <div class="col-sm-9 px-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input" id="pin-confirm" onchange="checking(this)" onkeypress="return hanyaAngka(event)" maxlength="6" pattern="\d+" required/>
                                                <label id="cekPin-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin-confirm"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-inline lbl-user-status">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Status</label>
                                    <select class="form-control bootstrap-select w-select-100 w-50" data-live-search="true" data-style="btn-white" id="user_status" onchange="checking(this)" required>
                                        <option value="" disabled selected>Choose User Status</option>
                                        @foreach($userstatus as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="cekUser_status" class="error invalid-feedback small d-block col-sm-4" for="user_status"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveuser">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="button" onclick="resetApp()">Reset</button>
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
