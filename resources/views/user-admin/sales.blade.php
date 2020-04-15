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
            getTableGroup();
            getTableList();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
        });

        function refreshTableList(){
            $('#table-grouplist').DataTable().ajax.reload();
        }


        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("getDataSales") }}',
                    data: function (d) {
                        var search_data = {
                            salesID:'',
                        };
                        d.search_param = search_data;
                    },
                },
                columns : [
                    {data : 'sls', name: 'sls'},
                    {data : 'sales_name', name: 'sales_name'},
                    {data : 'sls', name: 'sls'},
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    searchable : false,
                }, {
                    targets: [1],
                    orderable: true,
                    searchable: true,
                },{
                    searchable : true,
                    targets : [2],
                    render : function (data, type, row) {
                        return '<i class="text-center">' +
                            '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+data+'\')">Pick</button></i>'}
                }]
            });
        }
        function clickOK(id) {
            $("#salesID").val(id);
            // alert($("#salesID").val());
            getGroup();
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                aaSorting: [[0, 'desc']],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-primary mb-2" id="addgroup" type="button" onclick="addGroup()">Add</button>');
                },
                ajax : {
                    url: '{{ url("getDataSales") }}',
                    data: function (d) {
                        var search_data = {
                            salesID: $("#salesID").val(),
                        };
                        d.search_param = search_data;
                    },
                },
                columns : [
                    {data : 'sls', name: 'sls'},
                    {data : 'sales_name', name: 'sales_name'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
                    {data : 'sls', name: 'sls'},
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    searchable : false,
                },{
                    targets : [1],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [2],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [3],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [4],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [5],
                    orderable :true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [6],
                    render : function (data, type, row) {
                        return  '<i class="text-center"><button class="btn btn-sm btn-warning fa fa-pen" onclick="editSales(\''+data+'\')" type="button" data-dismiss= "modal")"></button>'
                    }
                }]
            });
        }

        $("#savegroup").on("click", function () {
            var groupname = $("#groupname").val();
            var groupid = $("#groupid").val()
            var groupaddress = $("#groupaddress").val();
            var groupmobile = $("#groupmobilphone").val();
            var groupphone = $("#groupphone").val();
            var groupemail = $("#groupemail").val();

            var required = "Field is required.";
            if (validateGroup('save')){
                $.get("/mockjax");

                $.ajax({
                    type : "GET",
                    url  : "{{ url('sales-registrasi') }}",
                    data : {
                        'sales_id' : groupid,
                        'sales_name' : groupname,
                        'address' : groupaddress,
                        'phone' : groupphone,
                        'mobilephone' : groupmobile,
                        'email' : groupemail,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            if (res.status === "00"){
                                $('#table-reggroup').DataTable().ajax.reload();
                                $("#add-group").removeClass("d-block");
                                $("#add-group").addClass("d-none");
                                $("#main-group").removeClass("d-none");
                                $("#main-group").addClass("d-block");
                                $("#regisgroup").text(res.group);
                                $("#alert-success-registrasi").removeClass("d-none");
                                $("#alert-success-registrasi").addClass("d-block");
                            }else{
                                $("#err_msg").text(res.err_msg);
                                $("#alert-error-registrasi").addClass("d-block");
                                $("#alert-error-registrasi").removeClass("d-none");
                            }
                        }
                    }
                });
            }
        });
        function validateGroup(typeData){
            var res = true;
            var required = "Field is required.";

            var groupname = $("#groupname").val();
            var groupid = $("#groupid").val();
            var groupaddress = $("#groupaddress").val();
            var groupmobile = $("#groupmobilphone").val();
            var groupphone = $("#groupphone").val();
            var groupemail = $("#groupemail").val();

            if (testEmail(groupemail) === false){
                $("#cekGroupEmail").text('Email not valid');
                $("#groupemail").addClass("is-invalid");
                $("#groupemail").focus();
                res = false;
            }
            if(groupemail === ''){
                $("#cekGroupEmail").text(required);
                $("#groupemail").addClass("is-invalid");
                $("#groupemail").focus();
                res = false;
            }
            var isnum = /^\d+$/.test(groupmobile);
            if(isnum === false){
                $("#cekGroupMobilePhone").text("Number only");
                $("#groupmobilphone").addClass("is-invalid");
                $("#groupmobilphone").focus();
                res = false;
            }
            if(groupmobile === ''){
                $("#cekGroupMobilePhone").text(required);
                $("#groupmobilphone").addClass("is-invalid");
                $("#groupmobilphone").focus();
                res = false;
            }
            isnum2 = /^\d+$/.test(groupphone);
            if(isnum2 === false){
                $("#cekGroupPhone").text("Number only");
                $("#groupphone").addClass("is-invalid");
                $("#groupphone").focus();
                res = false;
            }
            if(groupphone === ''){
                $("#cekGroupPhone").text(required);
                $("#groupphone").addClass("is-invalid");
                $("#groupphone").focus();
                res = false;
            }
            if(groupaddress === ''){
                $("#cekGroupAddress").text(required);
                $("#groupaddress").addClass("is-invalid");
                $("#groupaddress").focus();
                res = false;

            }
            if(groupname === ''){
                $("#cekGroupname").text(required);
                $("#groupname").addClass("is-invalid");
                $("#groupname").focus();
                res = false;

            }
            if(groupid === ''){
                $("#cekGroupId").text(required);
                $("#groupid").addClass("is-invalid");
                $("#groupid").focus();
                res = false;
            }
            if (groupid === '') {
                $("#cekGroupId").text(required);
                $("#groupid").addClass("is-invalid");
                $("#groupid").focus();
                res = false;
            }
            if(typeData == "save"){
                $.ajax({
                    type: "GET",
                    url: "{{ url('getSalesId') }}",
                    data: {
                        'id': groupid,
                    },
                    success: function (res) {
                        if (res.status === "01") {
                            $("#cekGroupId").text('Sales Id not available, try another ID');
                            $("#groupid").addClass("is-invalid");
                            $("#groupid").focus();
                            res = false;
                        } else {
                            res = true;
                        }
                    }
                });
            }
            return res;
        }
        function changeCheck(data){

            switch (data) {
                case 'groupid':
                    var groupid = $("#groupid").val();
                    if(groupid !== ''){
                        $("#groupid").removeClass("is-invalid");
                        $("#cekGroupId").text('');
                    };
                    break;
                case 'groupname':
                    var groupname = $("#groupname").val();
                    if(groupname !== ''){
                        $("#groupname").removeClass("is-invalid");
                        $("#cekGroupname").text('');
                    };
                    break;
                case 'groupaddress':
                    var groupaddress = $("#groupaddress").val();
                    if(groupaddress !== ''){
                        $("#groupaddress").removeClass("is-invalid");
                        $("#cekGroupAddress").text('');
                    };
                    break;
                case 'groupphone':
                    var groupphone = $("#groupphone").val();
                    if(groupphone !== ''){
                        $("#groupphone").removeClass("is-invalid");
                        $("#cekGroupPhone").text('');
                    };
                    break;
                case 'groupmobilephone':
                    var groupmobile = $("#groupmobilphone").val();
                    if(groupmobile !== ''){
                        $("#groupmobilphone").removeClass("is-invalid");
                        $("#cekGroupMobilePhone").text('');
                    };
                    break;
                case 'groupemail':
                    var groupemail = $("#groupemail").val();
                    if(groupemail !== ''){
                        $("#groupemail").removeClass("is-invalid");
                        $("#cekGroupEmail").text('');
                    };
                    break;
            }
        }
        function testEmail(email){
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        function addGroup() {
            var id = $("#addgroupID").val();
            $.ajax({
                type : "GET",
                url  : "{{ url('get-idgroup') }}",
                success : function (res) {
                    if ($.trim(res)){
                        $("#addgroupID").val(res.groupID);
                    }
                }
            });

            $("#groupname").val('');

            $("#add-group").removeClass("d-none");
            $("#add-group").addClass("d-block");
            $("#main-group").removeClass("d-block");
            $("#main-group").addClass("d-none");
            $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Add");


            $("#savegroupbutton").addClass('d-block');
            $("#savegroupbutton").removeClass('d-none');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');

            clearCache();
        }
        function editSales(data){
            $.ajax({
                type : "GET",
                        url  : "{{ url('sales-update/') }}",
                        data : {
                        'id' : data,
                    },
                    success : function (res) {
                        // console.log(res.name);
                        $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                        $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res.sales_name);
                        $("#groupid").val(data);
                        $("#groupname").val(res.sales_name);
                        $("#groupaddress").val(res.address);
                        $("#groupphone").val(res.phone);
                        $("#groupmobilphone").val(res.mobile_phone);
                        $("#groupemail").val(res.email);
                }
            });

            // $("#groupname").val('');
            $("#hiddensalesid").val(data);

            $("#add-group").removeClass("d-none");
            $("#add-group").addClass("d-block");
            $("#main-group").removeClass("d-block");
            $("#main-group").addClass("d-none");
            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');
            clearCache();
        }
        $("#resetgroup").on('click', function(){
            var data = $("#hiddensalesid").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('sales-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res.sales_name);
                    $("#groupid").val(data);
                    $("#groupname").val(res.sales_name);
                    $("#groupaddress").val(res.address);
                    $("#groupphone").val(res.phone);
                    $("#groupmobilphone").val(res.mobile_phone);
                    $("#groupemail").val(res.email);
                }
            });
        });
        $("#updategroup").on("click", function () {
            var groupid = $("#hiddensalesid").val();
            var groupname = $("#groupname").val();
            var groupaddress = $("#groupaddress").val();
            var groupphone = $("#groupphone").val();
            var groupmobilephone = $("#groupmobilphone").val();
            var groupemail = $("#groupemail").val();

            var required = "Field is required.";
            if (validateGroup('update')){
                $.get("/mockjax");
                $.ajax({
                    type : "GET",
                    url  : "{{ url('sales-update/submit') }}",
                    data : {
                        'sales_id' : groupid,
                        'sales_name' : groupname,
                        'address': groupaddress,
                        'phone': groupphone,
                        'mobile_phone': groupmobilephone,
                        'email': groupemail,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            if (res.status === "00"){
                                $('#table-reggroup').DataTable().ajax.reload();
                                $("#add-group").removeClass("d-block");
                                $("#add-group").addClass("d-none");
                                $("#main-group").removeClass("d-none");
                                $("#main-group").addClass("d-block");
                                $("#update_sales_notification").text(res.group);
                                $("#alert-success-update").removeClass("d-none");
                                $("#alert-success-update").addClass("d-block");
                            }else{
                                $("#err_msg").text(res.err_msg);
                                $("#alert-error-registrasi").addClass("d-block");
                                $("#alert-error-registrasi").removeClass("d-none");
                            }
                        }
                    }
                });
            }
        });
        function clearCache(){
            $("#hiddendealerid").val('');
            $("#groupid").val('');
            $("#groupname").val('');
            $("#groupaddress").val('');
            $("#groupphone").val('');
            $("#groupmobilphone").val('');
            $("#groupemail").val('');

            $("#cekGroupname").text('');
            $("#cekGroupId").text('');
            $("#cekGroupAddress").text('');
            $("#cekGroupPhone").text('');
            $("#cekGroupMobilePhone").text('');
            $("#cekGroupEmail").text('');

            $("#hiddendealerid").removeClass("is-invalid");
            $("#groupid").removeClass("is-invalid");
            $("#groupname").removeClass("is-invalid");
            $("#groupaddress").removeClass("is-invalid");
            $("#groupphone").removeClass("is-invalid");
            $("#groupmobilphone").removeClass("is-invalid");
            $("#groupemail").removeClass("is-invalid");

            $("#alert-error-registrasi").removeClass("d-block");
            $("#alert-error-registrasi").addClass("d-none");

            $("#alert-success-registrasi").removeClass("d-block");
            $("#alert-success-registrasi").addClass("d-none");

            $("#alert-success-update").removeClass("d-block");
            $("#alert-success-update").addClass("d-none");
        }

        $("#cancelgroup").on("click", function () {
            var res =  $("#hiddensalesid").val()+$("#groupid").val()+$("#groupname").val()+$("#groupaddress").val()+$("#groupphone").val()+$("#groupmobilphone").val()+$("#groupemail").val();
            res = res.trim();
            if(res.length > 0){
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        reverseButtons: true,
                        closeOnCancel: true,
                        closeOnCancel: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $("#add-group").removeClass("d-block");
                            $("#add-group").addClass("d-none");
                            $("#main-group").removeClass("d-none");
                            $("#main-group").addClass("d-block");
                            $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
                        }
                    }
                )

            }else{
                $("#add-group").removeClass("d-block");
                $("#add-group").addClass("d-none");
                $("#main-group").removeClass("d-none");
                $("#main-group").addClass("d-block");
                $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
            }
        });

        $("#canceleditgroup").on("click", function () {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
                        $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
                        $("#add-group").removeClass("d-block");
                        $("#add-group").addClass("d-none");
                        $("#main-group").removeClass("d-none");
                        $("#main-group").addClass("d-block");

                    }
                }
            )
        });

        $("#btn-current1").on("click", function(){

            getGroup();
        });

        function getGroup() {
            var id = $("#salesID").val();
            console.log(id);
            if(id === ''){
                $("#groupGet").val('');
                $('#table-reggroup').DataTable().ajax.reload();
            } else {
                $.ajax({
                    type : "GET",
                    url  : "{{ url('salesGetName') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#groupGet").val(res[0].sales_name);
                        } else {
                            $("#groupGet").val('');
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
                        {{--<li class="breadcrumb-item"><a href="#"><i class="ni ni-single-02"></i> Dashboards</a></li>--}}
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i>&nbsp;Master Data</li>
                        <li class="breadcrumb-item active" aria-current="page">Sales</li>
                        <li id="breadAdditional" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <li id="breadAdditionalText" class="breadcrumb-item active d-none" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow" id="main-group">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Sales ID</label>
                <input class="form-control mb-2" placeholder="Input ID Sales" id="salesID"  onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Sales Name" readonly id="groupGet">
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal" onclick="refreshTableList()"><i class="fa fa-search"></i></button>
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current1">Search</button>
            </form>
        </div>

        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-success-registrasi">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="regisgroup"></strong>, has registered.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-success-update">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="update_sales_notification"></strong>, has updated.</span>
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
                            {{--<div class="form-inline">

                            </div>--}}
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-reggroup">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th>Sales Id</th>
                                        <th>Sales Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Mobile Phone</th>
                                        <th>Email</th>
                                        <th>#</th>
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

    <div class="card shadow d-none" id="add-group">
        <form>
            <input type="hidden" id="hiddensalesid">
            <div class="card card-body" style="min-height: 365px">

                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="d-none" id="alert-error-registrasi">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <span class="alert-inner--icon"><i class="fa fa-exclamation-triangle"></i></span>
                                    <span class="alert-inner--text"><strong>Err.</strong><span id="err_msg"></span></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales ID</label>
                                    <input class="form-control col-sm-6" id="groupid" type="text" maxlength="20" onchange="changeCheck('groupid')" placeholder="Sales ID" required/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>

                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Sales Name" onchange="changeCheck('groupname')" required id="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Address</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Address" onchange="changeCheck('groupaddress')" required id="groupaddress"/>
                                    <label id="cekGroupAddress" class="error invalid-feedback small d-block col-sm-4" for="groupaddress"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Phone" maxlength="15" onchange="changeCheck('groupphone')" required id="groupphone"/>
                                    <label id="cekGroupPhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Mobile Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Mobile Phone" maxlength="15" onchange="changeCheck('groupmobilephone')" required id="groupmobilphone"/>
                                    <label id="cekGroupMobilePhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Email</label>
                                    <input class="form-control col-sm-6" type="email" placeholder="Email" required onchange="changeCheck('groupemail')" id="groupemail"/>
                                    <label id="cekGroupEmail" class="error invalid-feedback small d-block col-sm-4" for="groupemail"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="savegroup">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="cancelgroup">Cancel</button>
                </div>
                <div class="form-inline justify-content-end d-none" id="editgroupbutton">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="updategroup">Update</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetgroup">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceleditgroup">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Group List -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sales List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-grouplist">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Sales Id</th>
                                <th>Sales Name</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
