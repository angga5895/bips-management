@extends('layouts.app-argon')

@section('js')
    <script>
        var conname = 0;

        var name = '';

        var role_app = 0;
        var bapp = 0;

        var rulesobj = {
            "name" : {
                required : true
            }
        }

        var messagesobj = {
            "name" : "Field is required.",
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
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $form.find("#saveUser").on('click', function () {
                if ($form.valid()) {
                    var user = $("#name").val();
                    $.ajax({
                        type : "GET",
                        url  : "{{ url('nameadmin-check') }}",
                        data : {
                            'name' : user,
                        },
                        success : function (res) {
                            if (res.status === "01"){
                                $("#name").val('');
                                $("#name").valid();
                                $(".lbl-group").removeClass('focused');
                                conname = 1;
                            } else {
                                conname = 0;
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
                    if ($("#hiddenadminid").val() === ''){
                        $("#saveUser").click();
                        console.log('save');
                    } else {
                        updateUser($form);
                        console.log('edit');
                    }
                    return false;
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
                            var user = $("#name").val();
                            var userN = $("#hiddenadminname").val();

                            if (user !== userN){
                                $.ajax({
                                    type : "GET",
                                    url  : "{{ url('nameadmin-check') }}",
                                    data : {
                                        'name' : user,
                                    },
                                    success : function (res) {
                                        if (res.status === "01"){
                                            $("#name").val('');
                                            $("#name").valid();
                                            $(".lbl-group").removeClass('focused');
                                            conname = 1;
                                        } else {
                                            conname = 0;
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
                if(conname > 0){
                    $('#name-error').text('Name is already used.');
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
                    url: '{{ url("get-dataRole/get") }}',
                    data: function (d) {
                        var search_data = {userID:""};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'name', name: 'name'},
                    {data : 'id', name: 'id'},
                ],
                columnDefs: [{
                    targets : [0],
                    searchable : true,
                    orderable : true
                },{
                    targets : [1],
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
                    url: '{{ url("get-dataRole/get") }}',
                    data: function (d) {
                        var search_data = {
                            userID:$("#userID").val()
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'id', name: 'id'},
                    {data : 'name', name: 'name'},
                    {data : 'created_at', name: 'created_at'},
                    {data : 'updated_at', name: 'updated_at'},
                ],
                columnDefs: [{
                    targets : [1],
                    searchable : true
                },{
                    targets : [2],
                    searchable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : getDateTimeBips(data);
                    }
                },{
                    targets : [3],
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
                        return '<button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" onclick="editUser(\''+data+'\')">' +
                            '<i class="fa fa-pen"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Role Privilege" onclick="roleUser(\''+data+'\',\''+row.name+'\')">' +
                            '<i class="ni ni-settings"></i>' +
                            '</button>'
                    }
                }]
            });
        }

        function addUser() {
            $("#hiddenadminid").val('');
            $("#name").val('');

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#role-user").removeClass("d-block");
            $("#role-user").addClass("d-none");
            $("#breadAdditional").addClass("d-block"); $("#breadAdditional").removeClass("d-none");$("#breadAdditional").text("Add");

            $("#savegroupbutton").addClass('d-block');
            $("#savegroupbutton").removeClass('d-none');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');

            clearCache();
        };

        function editUser(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('roleadmin-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");

                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].name);
                    $("#hiddenadminid").val(data);
                    $("#hiddenadminname").val(res[0].name);
                    $("#name").val(res[0].name);

                    name = res[0].name;
                }
            });

            $("#hiddenadminid").val(data);

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#role-user").removeClass("d-block");
            $("#role-user").addClass("d-none");

            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');
            clearCache();
        }

        function cancelRole(){
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").addClass("d-block");
            $("#main-user").removeClass("d-none");
            $("#role-user").addClass("d-none");
            $("#role-user").removeClass("d-block");

            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');

            $("#breadAdditional").addClass("d-none").removeClass("d-block").text("");

            $("#breadAdditionalText").addClass("d-none").removeClass("d-block").text("");


            $(".chclappmod").prop('checked', false);
            $(".chclapp").prop('checked', false);

            bapp = 0;
            role_app = 0;
            $('#table-reggroup').DataTable().ajax.reload();
        }

        $("#cancelRole").on("click", function () {
            //if cancel confirm
            var clapplength = $(".chclapp").length;
            var coba =0;
            for (var x=0; x<clapplength; x++){
                if($(".chclapp")[x].checked === true) {
                    coba+=x;
                } else {
                    coba = coba-1;
                }
            }

            var clappmodlength = $(".chclappmod").length;
            var coba1 =0;
            for (var y=0; y<clappmodlength; y++){
                if($(".chclappmod")[y].checked === true) {
                    coba1+=y;
                } else {
                    coba1 = coba1-1;
                }
            }

            console.log(bapp+' '+(coba+coba1));

            if(bapp !== (coba+coba1)) {
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
                            cancelRole();
                        }
                    }
                )
            } else {
                cancelRole();
            }
        });

        $("#updateRole").on("click", function () {
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
                    var myApp = [];
                    var myAppmod = [];
                    $('.chclapp').each(function() {
                        if ($("#"+this.id).is(':checked')){
                            var chclapp = this.id.split("chclapp");
                            myApp.push(chclapp[1]);
                            // console.log(chclapp[1]);
                        }
                    });

                    $('.chclappmod').each(function() {
                        if ($("#"+this.id).is(':checked')){
                            var chclappmod = this.id.split("mod");
                            myAppmod.push(chclappmod[1]);
                            // console.log(chclappmod[1]);
                        }
                    });

                    if (isConfirm) {
                        $.ajax({
                            type : "GET",
                            url  : "{{ url('roleadmin-privilege/submit') }}",
                            data : {
                                'role_app' : role_app,
                                'clapp' : (myApp.length > 0)? myApp : 0,
                                'clappmod' : (myAppmod.length > 0) ? myAppmod : 0,
                                'name' : name
                            },
                            success : function (res) {
                                // console.log(res.name);
                                if(res.status === '00'){
                                    swal({
                                        title: res.user,
                                        text: "Has Updated",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn-success',
                                        confirmButtonText: 'OK'
                                    }, function () {
                                        window.location.href = "{{ route('adminprivilege.uradmin') }}";
                                    });
                                } else {
                                    swal({
                                        title: res.user,
                                        text: res.message,
                                        type: "error",
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn-danger',
                                        confirmButtonText: 'OK'
                                    }, function () {
                                        window.location.href = "{{ route('adminprivilege.uradmin') }}";
                                    });
                                }
                            }
                        });
                    }
            });
        });

        function ajaxRoleUser(data,names) {
            $(".chclappmod").prop('checked', false);
            $(".chclapp").prop('checked', false);
            bapp = 0;
            role_app = 0;
            name = '';

            $.ajax({
                type : "GET",
                url  : "{{ url('rolenameadmin-checkclapp/') }}",
                data : {
                    'role_app' : data,
                },
                success : function (res) {
                    if (res.length > 0){
                        for (var i=0; i<res.length; i++){
                            $("#chclapp"+res[i].cla_id)[0].checked = true;
                            if (res[i].cla_module === true){
                                $("#chclapp"+res[i].cla_id+"mod"+res[i].id)[0].checked = true;
                            }
                        }
                    } else {
                        $(".chclappmod").prop('checked', false);
                        $(".chclapp").prop('checked', false);
                    }

                    //if cancel confirm
                    var clapplength = $(".chclapp").length;
                    var coba =0;
                    for (var x=0; x<clapplength; x++){
                        if($(".chclapp")[x].checked === true) {
                            coba+=x;
                        } else {
                            coba = coba-1;
                        }
                    }

                    var clappmodlength = $(".chclappmod").length;
                    var coba1 =0;
                    for (var y=0; y<clappmodlength; y++){
                        if($(".chclappmod")[y].checked === true) {
                            coba1+=y;
                        } else {
                            coba1 = coba1-1;
                        }
                    }
                    bapp=coba+coba1;
                    role_app = data;
                    name = names;

                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Privilege Menu");

                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(names);
                    $("#hiddenadminid").val(data);
                    $("#hiddenadminname").val(names);
                    $("#name").val(names);
                }
            });
        }

        function roleUser(data,name){
            ajaxRoleUser(data,name);
            $("#hiddenadminid").val(data);

            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#role-user").removeClass("d-none");
            $("#role-user").addClass("d-block");

            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');

            $("#role-admin-name").text(name);
        }

        /*function deleteUser(data){
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
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type : "GET",
                            url  : "{ url('useradmin-delete/submit') }}",
                            data : {
                                'id' : data,
                            },
                            success : function (res) {
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
        }*/

        $("#resetuser").on('click', function(){
            cacheError();
            var data = $("#hiddenadminid").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('roleadmin-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res[0].name);
                    $("#hiddenadminid").val(data);
                    $("#hiddenadminname").val(res[0].name);
                    $("#name").val(res[0].name);
                }
            });
        });

        function cacheError() {
            $('.lbl-group').removeClass('focused');

            $("#name-error").text('');
            $("#name").removeClass("is-invalid");

            $("#cekName").text('');
        }

        $("#canceluser").on("click", function () {
            var name = $("#name").val();

            var res = name;
            res = res.trim();
            if(res.length > 0) {
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
                            $("#role-user").removeClass("d-block");
                            $("#role-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#breadAdditional").addClass("d-none");
                            $("#breadAdditional").removeClass("d-block");
                            $("#breadAdditional").text("");

                        }
                    }
                )
            } else {
                $("#add-user").removeClass("d-block");
                $("#add-user").addClass("d-none");
                $("#role-user").removeClass("d-none");
                $("#role-user").addClass("d-block");
                $("#main-user").removeClass("d-none");
                $("#main-user").addClass("d-block");
                $("#breadAdditional").addClass("d-none");
                $("#breadAdditional").removeClass("d-block");
                $("#breadAdditional").text("");
            }
        });

        function checking(these) {
            if ($(these).val() !== ''){
                var str = $(these).attr("id");
                str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });

                $("#cek"+str).text('');
            }
        }

        function clearCache(){
            conname = 0;
            cacheError();
            $("#hiddenadminid").val('');

            $("#name").val('');

            $("#hiddenadminid").removeClass("is-invalid");

            $("#alert-error-registrasi").removeClass("d-block");
            $("#alert-error-registrasi").addClass("d-none");

            $("#alert-success-registrasi").removeClass("d-block");
            $("#alert-success-registrasi").addClass("d-none");

            $("#alert-success-update").removeClass("d-block");
            $("#alert-success-update").addClass("d-none");
        }

        function resetApp(){
            clearCache();
        }

        function saveUser() {
            var name = $("#name").val();

            $.get("/mockjax");

            $.ajax({
                type : "GET",
                url  : "{{ url('rolenameadmin-registrasi') }}",
                data : {
                    'name' : name
                },
                success : function (res) {
                    if ($.trim(res)){
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
                        if (res.status === "00"){
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#role-user").removeClass("d-block");
                            $("#role-user").addClass("d-none");
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
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
                            $("#role-user").removeClass("d-block");
                            $("#role-user").addClass("d-none");
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

        function updateuser() {
            var id = $("#hiddenadminid").val();
            var name = $("#name").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('roleadmin-update/submit') }}",
                data: {
                    'id': id,
                    'name': name
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#role-user").removeClass("d-block");
                            $("#role-user").addClass("d-none");
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#update_user_notification").text(res.user);
                            $("#alert-success-update").removeClass("d-none");
                            $("#alert-success-update").addClass("d-block");

                            clearVariable();
                        } else {
                            $("#err_msg").text(res.message);
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
                    url  : "{{ url('rolenameadmin-get') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#usernameGet").val(res[0].name);
                        } else {
                            $("#usernameGet").val('');
                        }
                        $('#table-reggroup').DataTable().ajax.reload();
                    }
                });
            }
        }

        function clearVariable() {
            name = '';
        }

        function cancelEdit(){
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
            $("#role-user").removeClass("d-block");
            $("#role-user").addClass("d-none");
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");

            clearVariable();
        }

        $("#canceledituser").on("click", function () {
            var nameN = $("#name").val();

            if (name === nameN) {
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
        
        function checkclapp(thees) {
            if ($(".chclapp"+thees).is(':checked')){
                $(".chclappmod"+thees).prop('checked', true);
            } else {
                $(".chclappmod"+thees).prop('checked', false);
            }
        }

        function checkclappmod(clapp, clappmod) {
            var clapplength = $(".chclappmod"+clapp).length;

            var ii = 1;
            for (var i=0; i<clapplength; i++){
                if($(".chclappmod"+clapp)[i].checked === true) {
                    ii *= 0;
                } else {
                    ii *= 1;
                }
            }

            if (ii === 1){
                $(".chclapp"+clapp).prop('checked', false);
            } else {
                $(".chclapp"+clapp).prop('checked', true);
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
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i> User Admin Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Role Admin</li>
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
                <input class="form-control mb-2" placeholder="Input Role ID" id="userID" onchange="getUsername()">
                <input class="form-control mb-2 ml-input-2" placeholder="Name Of Role" id="usernameGet" readonly>
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1" onclick="refreshTablemember()"><i class="fa fa-search"></i></button>
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
                                        <th>Role Name</th>
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
            <input type="hidden" id="hiddenadminid"/>
            <input type="hidden" id="hiddenadminname"/>
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
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Name</label>
                                            <input class="form-control col-sm-12" type="text" placeholder="Name"
                                                   id="name" name="name" onchange="checking(this)"

                                            />
                                            <label id="cekName" class="error invalid-feedback small d-block col-sm-12 px-0" for="name"></label>
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

    <div class="card shadow d-none" id="role-user">
        <div class="card card-header">
            <span>Role Admin : <strong id="role-admin-name"></strong></span>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div style="border: 1px solid #f2f2f2;">
                @foreach($clapps as $p)
                    @if($p->cla_module)
                        <?php $clappmodule = Illuminate\Support\Facades\DB::select
                        ('
                            SELECT cl_app_mod.*, cl_module.* FROM cl_app_mod
                            JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                            WHERE cl_app_mod.clam_cla_id = '.$p->cla_id.' AND cl_app_mod.clam_show = TRUE
                            ORDER BY cl_module.clm_order;
                        ')
                        ?>
                            <div class="accordion-1">

                                <div class="px-0">
                                    <div class="row">
                                        <div class="col-md-12 ml-auto">
                                            <div class="accordion my-0" id="accordionExample">
                                                <div class="card">
                                                    <div id="cla{{ $p->cla_id }}" class="px-collapse">
                                                        <input type="checkbox" class="chclapp chclapp{{ $p->cla_id }}" id="chclapp{{ $p->cla_id }}" onclick="checkclapp({{ $p->cla_id }})">
                                                        <button class="btn btn-link text-collapse text-left px-0 w-collapse" type="button" data-toggle="collapse" data-target="#collapse{{ $p->cla_id }}" aria-expanded="true" aria-controls="collapse{{ $p->cla_id }}">
                                                            {{ $p->cla_name }}
                                                            <i class="ni ni-bold-down float-right"></i>
                                                        </button>
                                                    </div>

                                                    <div id="collapse{{ $p->cla_id }}" class="collapse show" aria-labelledby="cla{{ $p->cla_id }}" data-parent="#accordionExample">
                                                        <div class="px-5">
                                                            @foreach($clappmodule as $r)
                                                                <div class="py-2">
                                                                    <input type="checkbox" class="chclappmod chclappmod{{ $p->cla_id }}" id="chclapp{{ $p->cla_id }}mod{{ $r->id }}" onclick="checkclappmod({{ $p->cla_id.','.$r->id }});">
                                                                    {{ $r->clm_name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else
                        <div>
                            <div class="px-0">
                                <div class="row">
                                    <div class="col-md-12 ml-auto">
                                        <div class="accordion my-0">
                                            <div class="card">
                                                <div id="cla{{ $p->cla_id }}" class="px-collapse">
                                                    <input type="checkbox" class="chclapp chclapp{{ $p->cla_id }}" id="chclapp{{ $p->cla_id }}" onclick="checkclapp({{ $p->cla_id }})">
                                                    <button class="btn btn-link text-collapse text-left px-0 w-collapse" type="button" data-toggle="collapse" data-target="#collapse{{ $p->cla_id }}" aria-expanded="true" aria-controls="collapse{{ $p->cla_id }}">
                                                        {{ $p->cla_name }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="card card-footer text-right">
            <div class="form-inline justify-content-end">
                <button class="form-control-btn btn btn-success mb-2" type="button" id="updateRole">Update</button>
                <button class="form-control-btn btn btn-info mb-2" onclick="ajaxRoleUser($('#hiddenadminid').val(),$('#hiddenadminname').val());">Reset</button>
                <button class="form-control-btn btn btn-danger mb-2" type="button" id="cancelRole">Cancel</button>
            </div>
        </div>
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