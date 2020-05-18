@extends('layouts.app-argon')

@section('js')
    <script>
        var conpass = 0;
        var conpin = 0;
        var rulesobj = {
            "user_type" : {
                required : true
            },
            "client_id" : {
                required : true
            },
            "client_id_t" : {
                required : true
            },
            "user_name" : {
                required : true
            },
            "email_address" : {
                required : true,
                email : true
            },
            "msidn" : {
                required : true
            },
            "user_status" : {
                required : true
            },
            "password" : {
                required : true
            },
            "password-confirm" : {
                required : true
            },
            "pin" : {
                required : true,
                digits : true
            },
            "pin-confirm" : {
                required : true,
                digits : true
            }
        }

        var messagesobj = {
            "user_type" : "Please pick an user type.",
            "client_id" : "Field is required.",
            "client_id_t" : "Field is required.",
            "user_name" : "Field is required.",
            "email_address" : {
                required : "Field is required.",
                email : "Field must be a valid email address."
            },
            "msidn" : "Field is required.",
            "user_status" : "Please pick an user status.",
            "password" : "Field is required.",
            "password-confirm" : "Field is required.",
            "pin" : {
                required : "Field is required.",
                digits : "Field must be a number."
            },
            "pin-confirm" : {
                required : "Field is required.",
                digits : "Field must be a number."
            }

        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            var $form = $('#myForm');
            $form.validate({
                rules: rulesobj,
                messages: messagesobj,
                debug: false,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback offset-label-error-user');
                    element.closest('.form-group').append(error);
                    $(element).addClass('is-invalid');
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');

                    if (element.id === 'user_type'){
                        $(".lbl-user-type > .dropdown.bootstrap-select").addClass("is-invalid");
                    }
                    if (element.id === 'user_status'){
                        $(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    if (element.id === 'user_type'){
                        $(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
                    }
                    if (element.id === 'user_status'){
                        $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                    }
                }
            });

            $form.find("#saveUser").on('click', function () {
                if ($form.valid()) {
                    saveUser();
                } else {
                    $('.lbl-group').removeClass('focused');
                }
                return false;
            });

            $form.keypress(function(e) {
                if(e.which == 13) {
                    $("#saveUser").click();
                }
            });
        });

        $(document).ready(function () {
            tablegetReg();
            tablelist();
            tablelistaccount();

            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });

            setInterval(function () {
                if(conpass > 0){
                    $('#password-confirm-error').text('Password confirm is wrong.');
                }
                if(conpin > 0){
                    $('#pin-confirm-error').text('PIN confirm is wrong.');
                }
            },100);
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

        function getDateTimeBips(tanggal){
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

            return date+" "+month+" "+year+" | "+datetime[1]+" WIB";
        }

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

            $("#myForm").valid();
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
                responsive: true,

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
                            +hash_pin+'\')">Pick</button>'
                    }
                }]
            });
        }
        function convertStatus(status){
            switch (status) {
                case 'A': return 'Active';break;
                case 'T': return 'Trade Disabled'; break;
                case 'B': return 'Suspend Buy'; break;
                case 'S': return 'Suspend Sell'; break;
            }
        }
        function tablelistaccount() {
            $("#table-listaccount").DataTable({
                responsive: true,

                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("getUserPerAccount") }}',
                    data: function (d) {
                        var search_data = {userID:$("#detail-userid").text(),
                         };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'sequence_no', name : 'sequence_no'},
                    {data : 'account_no', name : 'account_no'},
                    {data : 'account_name', name: 'account_name'},
                    {data : 'account_status', name: 'account_status'},
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
                    orderable : true,
                    searchable : false,
                },{
                    targets : [3],
                    orderable : true,
                    searchable : false,
                    render : function (data, type, row) {
                        return convertStatus(row.account_status);
                    }
                    }],
            });
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
                            userType:""};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_name', name: 'user_name'},
                    {data : 'user_id', name : 'user_id'},
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
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-primary mb-2" type="button" id="adduser" onclick="addUser()">Add</button>');
                },
                ajax : {
                    url: '{{ url("get-dataRegistrasi/get") }}',
                    data: function (d) {
                        var search_data = {
                            userID:$("#userID").val(),
                            userStatus:$("#userStatus").val(),
                            userType:$("#userType").val()
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_id', name: 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'user_id', name : 'user_id'},
                    {data : 'email_address', name: 'email_address'},
                    /*{data : 'msidn', name: 'msidn'},*/
                    {data : 'usertype', name: 'usertype'},
                    {data : 'userstatus', name: 'userstatus'},
                    /*{data : 'last_login', name: 'last_login'},*/
                ],
                columnDefs: [{
                    targets : [1],
                    searchable : false
                },{
                    targets : [2],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [3],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [4],
                    searchable : true,
                },{
                    searchable : true,
                    targets : [5],
                },{
                    searchable : true,
                    targets : [0],
                    className: 'text-center',
                    render : function (data, type, row) {
                        return '<button class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detail" onclick="detailUser(\''+data+'\')">' +
                            '<i class="fa fa-search"></i>' +
                            '</button>'+
                            '<a class="btn btn-sm btn-warning" href="/user/'+data+'/edit" data-toggle="tooltip" data-placement="top" title="Edit Status">' +
                            '<i class="fa fa-pen"></i>' +
                            '</a>' +
                            '<a class="btn btn-sm btn-facebook" href="/user/'+data+'/reset/password" data-toggle="tooltip" data-placement="top" title="Reset Password">' +
                            '<i class="fa fa-lock-open"></i>' +
                            '</a>' +
                            '<a class="btn btn-sm btn-dark" href="/user/'+data+'/reset/pin" data-toggle="tooltip" data-placement="top" title="Reset PIN">' +
                            '<i class="fa fa-qrcode"></i>' +
                            '</a>'
                    }
                }]
            });
        }

        function detailUser(userid) {
            $.get("/mockjax");

            $.ajax({
                type : "GET",
                url  : "{{ url('get-detailUser') }}",
                data : {
                    'user_id' : userid,
                },
                success : function (res) {
                    //row 1
                    $("#dtl_user_id").text((res.user_id === null) ? '-' : res.user_id);
                    $("#dtl_user_name").text((res.user_name === null) ? '-' : res.user_name);
                    $("#dtl_email_address").text((res.email_address === null) ? '-' : res.email_address);
                    $("#dtl_msidn").text((res.msidn === null) ? '-' : res.msidn);
                    //row 2
                    $("#dtl_status").text((res.status === null) ? '-' : res.status);
                    $("#dtl_last_login").text((res.last_login === null) ? '-' : getDateTimeBips(res.last_login));
                    $("#dtl_last_teriminalid").text((res.last_teriminalid === null) ? '-' : res.last_teriminalid);
                    $("#dtl_user_type").text((res.user_type === null) ? '-' : res.user_type);

                    $("#detail-userid").text(res.user_id);
                    $("#detail-user").removeClass("d-none");
                    $("#detail-user").addClass("d-block");
                    $("#add-user").removeClass("d-block");
                    $("#add-user").addClass("d-none");
                    $("#main-user").removeClass("d-block");
                    $("#main-user").addClass("d-none");
                    $('#table-listaccount').DataTable().ajax.reload();
                    $("#breadAdditional").addClass("d-block"); $("#breadAdditional").removeClass("d-none");$("#breadAdditional").text("Detail");
                    $("#breadAdditionalText").addClass("d-block"); $("#breadAdditionalText").removeClass("d-none");$("#breadAdditionalText").text(res.user_name);

                }
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
            $("#detail-user").removeClass("d-block");
            $("#detail-user").addClass("d-none");
            $("#breadAdditional").addClass("d-block"); $("#breadAdditional").removeClass("d-none");$("#breadAdditional").text("Add");

            clearCache();
        };

        $("#backdetail").on("click", function () {
            $("#detail-user").removeClass("d-block");
            $("#detail-user").addClass("d-none");
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");
            $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
            $("#breadAdditionalText").addClass("d-none"); $("#breadAdditionalText").removeClass("d-block");$("#breadAdditionalText").text("");

        });

        $("#canceluser").on("click", function () {
            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonClass: "btn-danger",
                    cancelButtonText: "No",
                    confirmButtonText: "Yes",
                    closeOnCancel: true,
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $("#add-user").removeClass("d-block");
                        $("#add-user").addClass("d-none");
                        $("#main-user").removeClass("d-none");
                        $("#main-user").addClass("d-block");
                        $("#detail-user").removeClass("d-block");
                        $("#detail-user").addClass("d-none");
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");

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
            // console.log(usertype);
        }

        function checking(these) {
            var pass = $("#password").val();
            var cpass = $("#password-confirm").val();
            var pin = $("#pin").val();
            var cpin = $("#pin-confirm").val();

            if (pass === ''){
                conpass=0;
            }

            if (pin === ''){
                conpin=0;
            }

            if(cpass !== '') {
                if (pass != cpass) {
                    $("#password-confirm").focus();
                    $("#password-confirm").val('');
                    $('#password-confirm').valid();
                    conpass = 1;
                } else if (pass == cpass) {
                    $('#password').valid();
                    $('#password-confirm').valid();
                    conpass = 0;
                }
            }

            if(cpin !== '') {
                if (pin != cpin) {
                    $("#pin-confirm").focus();
                    $("#pin-confirm").val('');
                    $('#pin-confirm').valid();
                    conpin = 1;
                } else if (pin == cpin) {
                    $('#pin').valid();
                    $('#pin-confirm').valid();
                    conpin = 0;
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
                    $("#user_status-error").text('');
                    $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                }
            }
        }

        function clearCache(){
            conpass = 0;
            conpin = 0;
            $('.lbl-group').removeClass('focused');

            $("#user_type-error").text('');
            $(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");

            $("#user_status-error").text('');
            $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");

            $("#client_id-error").text('');
            $("#client_id").removeClass("is-invalid");
            $("#client_id").val('');

            $("#client_id_t-error").text('');
            $("#client_id_t").removeClass("is-invalid");
            $("#client_id_t").val('');

            $("#user_name-error").text('');
            $("#user_name").removeClass("is-invalid");
            $("#user_name").val('');

            $("#email_address-error").text('');
            $("#email_address").removeClass("is-invalid");
            $("#email_address").val('');

            $("#msidn-error").text('');
            $("#msidn").removeClass("is-invalid");
            $("#msidn").val('');

            $("#password-error").text('');
            $("#password").removeClass("is-invalid");
            $("#password").val('');

            $("#password-confirm-error").text('');
            $("#password-confirm").removeClass("is-invalid");
            $("#password-confirm").val('');

            $("#pin-error").text('');
            $("#pin").removeClass("is-invalid");
            $("#pin").val('');

            $("#pin-confirm-error").text('');
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

        function saveUser() {
            var user_type = $("#user_type").val();
            var user_status = $("#user_status").val();
            var user_name = $("#user_name").val();
            var password = $("#password").val();
            var pin = $("#pin").val();
            var cpassword = $("#password-confirm").val();
            var cpin = $("#pin-confirm").val();

            var email_address = $("#email_address").val();
            var msidn = $("#msidn").val();

            if (user_type === 'T'){
                var user_id = $("#client_id_t").val();
            } else {
                var user_id = $("#client_id").val();
            }

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
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
                        if (res.status === "00"){
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#regisuser").text(res.user);
                            $("#alert-success-registrasi").removeClass("d-none");
                            $("#alert-success-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-block");
                            $("#alert-error-registrasi").addClass("d-none");

                        } else {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#messageuser").text(res.message);
                            $("#alert-error-registrasi").removeClass("d-none");
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-success-registrasi").removeClass("d-block");
                            $("#alert-success-registrasi").addClass("d-none");
                        }
                    }
                }
            });
        };

        $("#btn-current").on("click", function(){
            $("#userID").val('');
            $("#usernameGet").val('');
            $("[id=userType]").val('');
            $("[data-id=userType] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('All User Type');
            $("[id=userStatus]").val('');
            $("[data-id=userStatus] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('All User Status');
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
                });
            } else {
                if (usertype === 'C' || usertype === 'D' || usertype === 'S'){
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
            <label class="form-control-label pr-5 mb-2">Filtered by :</label>
            <form class="form-inline">
                <input class="form-control mb-2" placeholder="Input User Code" id="userID" onchange="getUsername()">
                <input class="form-control mb-2 ml-input-2" placeholder="Name Of User" id="usernameGet" readonly>
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1" onclick="refreshTablemember()"><i class="fa fa-search"></i></button>
                <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="userType"  onchange="getUsername()">
                    <option value="" selected>All User Type</option>
                    @foreach($usertype as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                &nbsp;&nbsp;
                <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="userStatus"  onchange="getUsername()">
                    <option value="" selected>All User Status</option>
                    @foreach($userstatus as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current">All Data</button>
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
                                        <th>Action</th>
                                        <th>User Name</th>
                                        <th>User Code</th>
                                        <th>Email</th>
                                        {{--<th>MSIDN</th>--}}
                                        <th>User Type</th>
                                        <th>Status</th>
                                        {{--<th>Last Login</th>--}}
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
        <form id="myForm">
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">

                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Type</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <div class="input-group col-sm-12 px-0 lbl-user-type">
                                                    <select class="form-control bootstrap-select w-select-100" data-live-search="true"
                                                            data-style="btn-white" id="user_type" name="user_type" onchange="checkUserType()"

                                                    >
                                                        <option value="" disabled selected>Choose User Type</option>
                                                        @foreach($usertype as $p)
                                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label id="cekUser_type" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekUser_type"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Code</label>
                                            <div class="col-sm-9 pr-0 row" id="useridCDS">
                                                <div class="input-group col-sm-12 px-0">
                                                    <input class="form-control readonly" type="text" placeholder="User Code" id="client_id" name="client_id"

                                                    />
                                                    <input class="form-control" type="hidden" id="user_id" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text btn btn-default" id="btn-clientid">
                                                            <i class="fa fa-search"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <label id="cekClient_id" class="error invalid-feedback small col-sm-12 px-0" for="client_id" style="justify-content: flex-start;"></label>
                                            </div>
                                            <div class="col-sm-9 pr-0 d-none row" id="useridT">
                                                <input class="form-control col-sm-12" type="text" placeholder="User Code" id="client_id_t" name="client_id_t" onchange="checking(this)" />
                                                <label id="cekClient_id_t" class="error invalid-feedback small col-sm-12 px-0" for="client_id_t"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Name</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="text" placeholder="User Name"
                                                       id="user_name" name="user_name" onchange="checking(this)"

                                                />
                                                <label id="cekUser_name" class="error invalid-feedback small d-block col-sm-12 px-0" for="user_name"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Email</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="email" placeholder="Email" id="email_address" name="email_address" onchange="checking(this)"

                                                />
                                                <label id="cekEmail_address" class="error invalid-feedback small d-block col-sm-12 px-0" for="email_address"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">MSIDN</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="text" placeholder="MSIDN" id="msidn" name="msidn" onchange="checking(this)"

                                                />
                                                <label id="cekMsidn" class="error invalid-feedback small d-block col-sm-12 px-0" for="msidn"></label>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-sm-6">

                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Status</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <div class="input-group col-sm-12 px-0 lbl-user-status">
                                                    <select class="form-control bootstrap-select w-select-100" data-live-search="true"
                                                            data-style="btn-white" id="user_status" name="user_status" onchange="checking(this)"

                                                    >
                                                        <option value="" disabled selected>Choose User Status</option>
                                                        @foreach($userstatus as $p)
                                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label id="cekUser_status" class="error invalid-feedback small d-block col-sm-12 px-0" for="user_status"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Password</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                       id="password" name="password" onchange="checking(this)"

                                                />
                                                <label id="cekPassword" class="error invalid-feedback small d-block col-sm-12 px-0" for="password"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Confirm Password</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                       id="password-confirm" name="password-confirm" onchange="checking(this)"

                                                />
                                                <label id="cekPassword-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="password-confirm"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">PIN</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                       id="pin" name="pin" onchange="checking(this)" onkeypress="return hanyaAngka(event)" maxlength="6" pattern="\d+"

                                                />
                                                <label id="cekPin" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin"></label>
                                            </div>
                                        </div>
                                        <div class="form-group form-inline lbl-group">
                                            <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Confirm PIN</label>
                                            <div class="col-sm-9 pr-0 row">
                                                <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                       id="pin-confirm" name="pin-confirm" onchange="checking(this)" onkeypress="return hanyaAngka(event)"
                                                       maxlength="6" pattern="\d+"

                                                />
                                                <label id="cekPin-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin-confirm"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveUser">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="button" onclick="resetApp()">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow d-none" id="detail-user">
        <div class="card card-header">
            <form class="form-inline">
                <button class="btn btn-sm btn-primary" type="button" id="backdetail"><i class="fa fa-backspace"></i> Back</button>
                <label class="form-control-label pr-5 mb-0">Detail User Code : &nbsp;<span id="detail-userid"></span></label>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">User Code</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_user_id"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">User Name</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_user_name"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">Email</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_email_address"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">MSIDN</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_msidn"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">Status</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_status"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">Last Login</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_last_login"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">Last Teriminal Id</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_last_teriminalid"></div>
                        </div>
                        <div class="form-group form-inline ">
                            <label class="form-control-label form-inline-label col-sm-4 mb-2 px-0 text-primary">User Type</label>
                            <div class="col-sm-8 pr-0 row" id="dtl_user_type"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-hoverclick" id="table-listaccount">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Seq</th>
                                <th>Account ID</th>
                                <th>Account Name</th>
                                <th>Account Status</th>
                                {{--<th>#</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <th data-priority="1">Employee Name</th>
                                <th data-priority="3">User Code</th>
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
                                <th>Action</th>
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
