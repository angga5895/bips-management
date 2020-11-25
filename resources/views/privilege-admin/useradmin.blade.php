@extends('layouts.app-argon')

@section('js')
    <script>
        var conpass = 0;
        var conusername = 0;

        var conpin = 0;

        var roleapp = '';
        var username = '';
        var password = '';
        var confirmpassword = '';

        var pin = '';
        var confirmpin = '';

        var rulesobj = {
            "username" : {
                required : true
            },
            "password" : {
                required : true
            },
            "password-confirm" : {
                required : true
            },
            "role-app" : {
                required : true,
            },
            "pin" : {
                required : true
            },
            "pin-confirm" : {
                required : true
            }
        }

        var messagesobj = {
            "username" : "Field is required.",
            "password" : "Field is required.",
            "password-confirm" : "Field is required.",
            "role-app" : "Please pick an role admin.",
            "pin" : "Field is required.",
            "pin-confirm" : "Field is required.",
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
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    $(element).addClass('is-invalid');
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');

                    if (element.id === 'role-app'){
                        $(".lbl-role-app > .dropdown.bootstrap-select").addClass("is-invalid");
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    if (element.id === 'role-app'){
                        $(".lbl-role-app > .dropdown.bootstrap-select").removeClass("is-invalid");
                    }
                }
            });

            $form.find("#saveUser").on('click', function () {
                if ($form.valid()) {
                    var user = $("#username").val();
                    $.ajax({
                        type : "GET",
                        url  : "{{ url('usernameadmin-check') }}",
                        data : {
                            'username' : user,
                        },
                        success : function (res) {
                            if (res.status === "01"){
                                $("#username").val('');
                                $("#username").valid();
                                $(".lbl-group").removeClass('focused');
                                conusername = 1;
                            } else {
                                conusername = 0;
                                saveUser();
                            }
                        }
                    });
                } else {
                    $('.lbl-group').removeClass('focused');
                }
                return false;
            });

            $form.find("#updateUser").on('click', function () {
                updateUser($form);
                return false;
            });

            $form.keypress(function(e) {
                if(e.which == 13) {
                    checking('');
                    if ($("#hiddenuseradminid").val() === ''){
                        $("#saveUser").click();
                        console.log('save');
                    } else {
                        updateUser($form);
                        console.log('edit');
                    }
                }
            });

            var $formpin = $('#myFormPin');
            $formpin.validate({
                rules: rulesobj,
                messages: messagesobj,
                debug: false,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    $(element).addClass('is-invalid');
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $formpin.find("#saveUserPin").on('click', function () {
                pinUser($formpin);
                return false;
            });

            $formpin.keypress(function(e) {
                if(e.which == 13) {
                    checkingpin('');
                    pinUser($formpin);
                    console.log('pin');
                }
            });
        });

        function updateUser(form){
            if (form.valid()) {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnCancel: true,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var user = $("#username").val();
                            var userN = $("#hiddenuseradminname").val();

                            if (user !== userN){
                                $.ajax({
                                    type : "GET",
                                    url  : "{{ url('usernameadmin-check') }}",
                                    data : {
                                        'username' : user,
                                    },
                                    success : function (res) {
                                        if (res.status === "01"){
                                            $("#username").val('');
                                            $("#username").valid();
                                            $(".lbl-group").removeClass('focused');
                                            conusername = 1;
                                        } else {
                                            conusername = 0;
                                            updateuser();
                                        }
                                    }
                                });
                            }  else {
                                updateuser();
                            }
                        }
                    }
                )
            }  else {
                $('.lbl-group').removeClass('focused');
            }
        }

        function pinUser(form){
            if (form.valid()) {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnCancel: true,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            pinuser();
                        }
                    }
                )
            }  else {
                $('.lbl-group').removeClass('focused');
            }
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

            setInterval(function () {
                if(conpin > 0){
                    $('#pin-confirm-error').text('PIN confirm is wrong.');
                }
                if(conpass > 0){
                    $('#password-confirm-error').text('Password confirm is wrong.');
                }
                if(conusername > 0){
                    $('#username-error').text('Username already exist.');
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
            var fulldate = tanggal;
            if (tanggal.includes('T')){
                var utctgl = tanggal.split("T");
                var utctime = utctgl[1].split(".");

                fulldate = utctgl[0]+' '+utctime[0];
            } else {
                fulldate = tanggal;
            }

            var datetime = fulldate.split(" ");
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
            var fulldate = tanggal;
            if (tanggal.includes('T')){
                var utctgl = tanggal.split("T");
                var utctime = utctgl[1].split(".");

                fulldate = utctgl[0]+' '+utctime[0];
            } else {
                fulldate = tanggal;
            }

            var datetime = fulldate.split(" ");
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

        function tablelist() {
            $("#table-listmember").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

                ajax : {
                    url: '{{ url("get-dataAdmin/get") }}',
                    data: function (d) {
                        var search_data = {userID:"",
                            roleApp:""};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'username', name: 'username'},
                    {data : 'role_name', name : 'role_name'},
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
                    className: 'text-center',
                    render : function (data, type, row) {
                        var uid = row.id;
                        var us = row.username;
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
                    url: '{{ url("get-dataAdmin/get") }}',
                    data: function (d) {
                        var search_data = {
                            userID:$("#userID").val(),
                            roleApp:$("#roleApp").val()
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'id', name: 'id'},
                    {data : 'username', name: 'username'},
                    {data : 'role_name', name : 'role_name'},
                    {data : 'created_at', name: 'created_at'},
                    {data : 'updated_at', name: 'updated_at'},
                ],
                columnDefs: [{
                    targets : [1],
                    searchable : true
                },{
                    targets : [2],
                    searchable : true,
                },{
                    targets : [3],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : getDateTimeBips(data);
                    }
                },{
                    targets : [4],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : getDateTimeBips(data);
                    }
                },{
                    searchable : true,
                    targets : [0],
                    orderable : false,
                    className: 'text-center',
                    render : function (data, type, row) {
                        return '<button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="PIN" onclick="pinUsers(\''+data+'\')">' +
                            '<i class="fa fa-qrcode"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" onclick="editUser(\''+data+'\')">' +
                            '<i class="fa fa-pen"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(\''+data+'\')">' +
                            '<i class="fa fa-trash"></i>' +
                            '</button>'
                    }
                }]
            });
        }

        function addUser() {
            $("[id=role-app]").val('');
            $("[data-id=role-app] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose Role Admin');

            $("#hiddenuseradminid").val('');
            $("#username").val('');

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#pin-user").removeClass("d-block");
            $("#pin-user").addClass("d-none");
            $("#breadAdditional").addClass("d-block"); $("#breadAdditional").removeClass("d-none");$("#breadAdditional").text("Add");

            $("#savegroupbutton").addClass('d-block');
            $("#savegroupbutton").removeClass('d-none');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');
            $("#savegroupbuttonpin").removeClass('d-block');
            $("#savegroupbuttonpin").addClass('d-none');

            clearCache();
        };

        function pinUsers(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('useradmin-pin/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("PIN");

                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].username);
                    $("#hiddenuseradminidpin").val(data);
                    $("#hiddenuseradminnamepin").val(res[0].username);

                    $("#pin").val(res[0].pin);
                    $("#pin-confirm").val(res[0].pin);

                    pin = res[0].pin;
                    confirmpin = res[0].pin;
                }
            });

            // $("#groupname").val('');
            $("#hiddenuseradminidpin").val(data);

            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#pin-user").removeClass("d-none");
            $("#pin-user").addClass("d-block");
            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-block');
            $("#savegroupbuttonpin").removeClass('d-none');
            $("#savegroupbuttonpin").addClass('d-block');
            clearCachePin();
        }

        function editUser(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('useradmin-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");

                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].username);
                    $("#hiddenuseradminid").val(data);
                    $("#hiddenuseradminname").val(res[0].username);
                    $("#username").val(res[0].username);
                    $("[id=role-app]").val(res[0].role_app);
                    $("[data-id=role-app] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text(res[0].name);

                    $("#password").val(res[1].password);
                    $("#password-confirm").val(res[1].password);

                    username = res[0].username;
                    roleapp = res[0].role_app;
                    password = res[1].password;
                    confirmpassword = res[1].password;
                }
            });

            // $("#groupname").val('');
            $("#hiddenuseradminid").val(data);

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#pin-user").removeClass("d-block");
            $("#pin-user").addClass("d-none");
            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');
            $("#savegroupbuttonpin").addClass('d-none');
            $("#savegroupbuttonpin").removeClass('d-block');
            clearCache();
        }

        function deleteUser(data){
            var idlogin = "{{ $idlogin }}";
            if (parseInt(idlogin) === parseInt(data)){
                swal({
                    title: "Can't be deleted",
                    text: "User admin is currently in use.",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'OK'
                });
            } else {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-default",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnCancel: true,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('useradmin-delete/submit') }}",
                                data: {
                                    'id': data,
                                },
                                success: function (res) {
                                    // console.log(res.name);
                                    swal({
                                        title: res.user,
                                        text: "Has Deleted",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn-success',
                                        confirmButtonText: 'OK'
                                    }, function () {
                                        $('#table-reggroup').DataTable().ajax.reload();
                                    });
                                }
                            });
                        }
                    }
                )
            }
        }

        $("#resetuser").on('click', function(){
            cacheError();
            var data = $("#hiddenuseradminid").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('useradmin-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].username);
                    $("#hiddenuseradminid").val(data);
                    $("#hiddenuseradminname").val(res[0].username);
                    $("#username").val(res[0].username);
                    $("[id=role-app]").val(res[0].role_app);
                    $("[data-id=role-app] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text(res[0].name);
                    $("#password").val(res[1].password);
                    $("#password-confirm").val(res[1].password);
                }
            });
        });

        $("#resetuserpin").on('click', function(){
            cacheErrorPin();
            var data = $("#hiddenuseradminidpin").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('useradmin-pin/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Pin");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].username);
                    $("#hiddenuseradminidpin").val(data);
                    $("#hiddenuseradminnamepin").val(res[0].username);
                    $("#pin").val(res[0].pin);
                    $("#pin-confirm").val(res[0].pin);
                }
            });
        });

        function cacheErrorPin() {
            $('.lbl-group').removeClass('focused');

            $("#pin-error").text('');
            $("#pin-confirm-error").text('');

            $("#pin").removeClass("is-invalid");
            $("#pin-confirm").removeClass("is-invalid");

            $("#cekPIN").text('');
        }

        function cacheError() {
            $('.lbl-group').removeClass('focused');

            $("#username-error").text('');
            $("#password-error").text('');
            $("#password-confirm-error").text('');
            $("#role-app-error").text('');

            $(".lbl-role-app > .dropdown.bootstrap-select").removeClass("is-invalid");
            $("#username").removeClass("is-invalid");
            $("#password").removeClass("is-invalid");
            $("#password-confirm").removeClass("is-invalid");

            $("#cekUsername").text('');
            $("#cekPassword").text('');
            $("#cekCPassword").text('');
            $("#cekRole-app").text('');
        }

        $("#canceluser").on("click", function () {
            var username = $("#username").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var roleapp = $("#role-app").val();

            var res = username+password+cpassword;
            res = res.trim();
            if(res.length > 0 || roleapp !== null) {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-default",
                        cancelButtonText: "No",
                        confirmButtonText: "Yes",
                        closeOnCancel: true,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#detail-user").removeClass("d-block");
                            $("#detail-user").addClass("d-none");
                            $("#breadAdditional").addClass("d-none");
                            $("#breadAdditional").removeClass("d-block");
                            $("#breadAdditional").text("");

                        }
                    }
                )
            } else {
                $("#add-user").removeClass("d-block");
                $("#add-user").addClass("d-none");
                $("#pin-user").removeClass("d-block");
                $("#pin-user").addClass("d-none");
                $("#main-user").removeClass("d-none");
                $("#main-user").addClass("d-block");
                $("#detail-user").removeClass("d-block");
                $("#detail-user").addClass("d-none");
                $("#breadAdditional").addClass("d-none");
                $("#breadAdditional").removeClass("d-block");
                $("#breadAdditional").text("");
            }
        });

        function checking(these) {
            var pass = $("#password").val();
            var cpass = $("#password-confirm").val();

            if (pass === ''){
                conpass=0;
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

            if  (these !== ''){
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
        }

        function checkingpin(these) {
            var pin = $("#pin").val();
            var cpin = $("#pin-confirm").val();

            if (pin === ''){
                conpin=0;
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
        }

        function clearCache(){
            conpass = 0;
            conusername = 0;
            cacheError();
            $("#hiddenuseradminid").val('');

            $("#username").val('');
            $("#password").val('');
            $("#password-confirm").val('');

            $("#hiddenuseradminid").removeClass("is-invalid");

            $("#alert-error-registrasi").removeClass("d-block");
            $("#alert-error-registrasi").addClass("d-none");

            $("#alert-success-registrasi").removeClass("d-block");
            $("#alert-success-registrasi").addClass("d-none");

            $("#alert-success-update").removeClass("d-block");
            $("#alert-success-update").addClass("d-none");
        }

        function clearCachePin(){
            conpin = 0;
            cacheErrorPin();
            $("#hiddenuseradminidpin").val('');

            $("#pin").val('');
            $("#pin-confirm").val('');

            $("#hiddenuseradminidpin").removeClass("is-invalid");

            $("#alert-error-registrasi").removeClass("d-block");
            $("#alert-error-registrasi").addClass("d-none");

            $("#alert-success-registrasi").removeClass("d-block");
            $("#alert-success-registrasi").addClass("d-none");

            $("#alert-success-update").removeClass("d-block");
            $("#alert-success-update").addClass("d-none");

            $("#alert-success-pin").removeClass("d-block");
            $("#alert-success-pin").addClass("d-none");
        }

        function resetApp(){
            $("[id=role-app]").val('');
            $("[data-id=role-app] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose Role Admin');

            clearCache();
        }

        function saveUser() {
            var username = $("#username").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var roleapp = $("#role-app").val();

            $.get("/mockjax");

            $.ajax({
                type : "GET",
                url  : "{{ url('usernameadmin-registrasi') }}",
                data : {
                    'username' : username,
                    'password' : password,
                    'role_app' : roleapp,
                },
                success : function (res) {
                    if ($.trim(res)){
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
                        if (res.status === "00"){
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#regisuser").text(res.user);
                            $("#alert-success-registrasi").removeClass("d-none");
                            $("#alert-success-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-block");
                            $("#alert-error-registrasi").addClass("d-none");

                            clearVariable();
                        } else {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
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

        function updateuser() {
            var id = $("#hiddenuseradminid").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var cpassword = $("#password-confirm").val();
            var roleapp = $("#role-app").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('useradmin-update/submit') }}",
                data: {
                    'id': id,
                    'username': username,
                    'password': password,
                    'role_app': roleapp,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#update_user_notification").text(res.user);
                            $("#alert-success-update").removeClass("d-none");
                            $("#alert-success-update").addClass("d-block");

                            clearVariable();
                        } else {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#messageuser").text(res.message);
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-none");
                        }
                    }
                }
            });
        }

        function pinuser() {
            var id = $("#hiddenuseradminidpin").val();
            var username = $("#hiddenuseradminnamepin").val();
            var pin = $("#pin").val();
            var cpin = $("#pin-confirm").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('useradmin-pin/submit') }}",
                data: {
                    'id': id,
                    'username': username,
                    'pin': pin,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#pin_user_notification").text(res.user);
                            $("#alert-success-pin").removeClass("d-none");
                            $("#alert-success-pin").addClass("d-block");

                            clearVariable();
                        } else {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#pin-user").removeClass("d-block");
                            $("#pin-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#messageuser").text(res.message);
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-none");
                        }
                    }
                }
            });
        }

        $("#btn-current").on("click", function(){
            $("#userID").val('');
            $("#usernameGet").val('');
            $("[id=roleApp]").val('');
            $("[data-id=roleApp] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('All Role Admin');
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
                    url  : "{{ url('usernameadmin-get') }}",
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

        function clearVariable() {
            roleapp = '';
            username = '';
            password = '';
            confirmpassword = '';
            pin = '';
            confirmpin = '';
        }

        function cancelEdit(){
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#pin-user").removeClass("d-block");
            $("#pin-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");

            clearVariable();
        }

        $("#canceledituser").on("click", function () {
            var usernameN = $("#username").val();
            var passwordN = $("#password").val();
            var confirmpasswordN = $("#password-confirm").val();
            var roleappN = $("#role-app").val();

            /*console.log(usernameN,' ',username);
            console.log(passwordN,' ',password);
            console.log(confirmpasswordN,' ',confirmpassword);
            console.log(parseInt(roleappN),' ',roleapp);*/

            if (username === usernameN && password === passwordN && confirmpassword === confirmpasswordN &&
                roleapp === parseInt(roleappN)) {
                cancelEdit();
            } else {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-default",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnCancel: true,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            cancelEdit();
                        }
                    }
                )
            }
        });

        $("#canceluserpin").on("click", function () {
            var pinN = $("#pin").val();
            var confirmpinN = $("#pin-confirm").val();

            console.log('PIN ::'+pinN+' PINS ::'+pin);
            console.log('CPIN ::'+confirmpinN+' CPINS::'+confirmpin);

            if ((pin === pinN && confirmpin === confirmpinN) || (pinN === null && confirmpinN === null)|| (pin === null && confirmpin === null)) {
                cancelEdit();
            } else {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-default",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnCancel: true,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            cancelEdit();
                        }
                    }
                )
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

    <div class="card shadow" id="main-user">
        <div class="card card-header">
            <label class="form-control-label pr-5 mb-2">Filtered by :</label>
            <form class="form-inline">
                <input class="form-control mb-2" placeholder="Input User Code" id="userID" onchange="getUsername()">
                <input class="form-control mb-2 ml-input-2" placeholder="Name Of User" id="usernameGet" readonly>
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1" onclick="refreshTablemember()"><i class="fa fa-search"></i></button>
                <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-default" id="roleApp"  onchange="getUsername()">
                    <option value="" selected>All Role Admin</option>
                    @foreach($roleApp as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                &nbsp;&nbsp;
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
            <div class="d-none" id="alert-success-update">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="update_user_notification"></strong>, has updated.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-success-pin">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="pin_user_notification"></strong>, pin has updated.</span>
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
                                        <th>Username</th>
                                        <th>Role Admin</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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
            <input type="hidden" id="hiddenuseradminid"/>
            <input type="hidden" id="hiddenuseradminname"/>
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">

                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="form-group lbl-role-app">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Role Admin</label>
                                            <select class="form-control bootstrap-select w-select-100" data-live-search="true"
                                                    data-style="btn-white" id="role-app" name="role-app" onchange="checking(this)">
                                                <option value="" disabled selected>Choose Role Admin</option>
                                                @foreach($roleApp as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                            <label id="cekRole-app" class="error invalid-feedback small d-block col-sm-12 px-0" for="role-app"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Username</label>
                                            <input class="form-control col-sm-12" type="text" placeholder="Username"
                                                   id="username" name="username" onchange="checking(this)"

                                            />
                                            <label id="cekUsername" class="error invalid-feedback small d-block col-sm-12 px-0" for="username"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Password</label>
                                            <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                   id="password" name="password" onchange="checking(this)"

                                            />
                                            <label id="cekPassword" class="error invalid-feedback small d-block col-sm-12 px-0" for="password"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Confirm Password</label>
                                            <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                   id="password-confirm" name="password-confirm" onchange="checking(this)"

                                            />
                                            <label id="cekPassword-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="password-confirm"></label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveUser">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="button" onclick="resetApp()">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
                <div class="form-inline justify-content-end d-none" id="editgroupbutton">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="updateUser">Update</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetuser">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceledituser">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow d-none" id="pin-user">
        <form id="myFormPin">
            <input type="hidden" id="hiddenuseradminidpin"/>
            <input type="hidden" id="hiddenuseradminnamepin"/>
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">

                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">PIN</label>
                                            <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                   id="pin" name="pin" onchange="checkingpin(this)"

                                            />
                                            <label id="cekPIN" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Confirm PIN</label>
                                            <input class="form-control col-sm-12" type="password" placeholder="Please Input"
                                                   id="pin-confirm" name="pin-confirm" onchange="checkingpin(this)"

                                            />
                                            <label id="cekPin-confirm" class="error invalid-feedback small d-block col-sm-12 px-0" for="pin-confirm"></label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbuttonpin">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveUserPin">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="button" id="resetuserpin">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluserpin">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal User Admin List -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Admin List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-listmember">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th data-priority="1">Username</th>
                                <th data-priority="3">Role Name</th>
                                <th data-priority="2">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
