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

        function clickOK(id) {
            $("#groupID").val(id);
            getGroup();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("get-dataGroup/get") }}',
                    data: function (d) {
                        var search_data = {groupID:''};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'group_id', name: 'group_id'},
                    {data : 'name', name: 'name'},
                    {data : 'group_id', name: 'group_id'},
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
                    searchable : true,
                    targets : [2],
                    render : function (data, type, row) {
                      return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+row.group_id+')">OK</button>'
                    }
                }]
            });
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
                    url: '{{ url("get-dataGroup/get") }}',
                    data: function (d) {
                        var search_data = {groupID:$("#groupID").val()};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'group_id', name: 'group_id'},
                    {data : 'name', name: 'name'},
                    {data : 'created_at', name: 'created_at'},
                    {data : 'updated_at', name: 'updated_at'},
                    {data : 'group_id', name: 'group_id'},
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
                    searchable : true,
                    render : function (data, type, row) {
                        return getDateBips(data);
                    }
                },{
                    targets : [3],
                    searchable : true,
                    render : function (data, type, row) {
                        return getDateBips(data);
                    }
                },{
                    searchable : true,
                    targets : [4],
                    render : function (data, type, row) {
                        return  '<button class="btn btn-sm btn-warning fa fa-pen" onclick="editGroup(\''+data+'\')" type="button" data-dismiss= "modal")"></button>'
                    }
                }]
            });
        }

        $("#savegroup").on("click", function () {
            var groupid = $("#groupid").val();
            var groupname = $("#groupname").val();
            var grouphead = $("#grouphead").val();
            var groupheadname = $("#groupheadname").val();

            if (validateField()){
                $.get("/mockjax");

                $.ajax({
                    type : "GET",
                    url  : "{{ url('group-registrasi') }}",
                    data : {
                        'group_id' : groupid,
                        'group_name' : groupname,
                        'head_id' : grouphead,
                        'head_name' : groupheadname,
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
                                $("#update_group_notification").text();
                                $("#alert-success-registrasi").removeClass("d-none");
                                $("#alert-success-registrasi").addClass("d-block");

                                $("#alert-success-update").removeClass("d-block");
                                $("#alert-success-update").addClass("d-none");
                            }
                        }
                    }
                });
            }
        });
        function validateField(data){
            var groupid = $("#groupid").val();
            var groupname = $("#groupname").val();
            var grouphead = $("#grouphead").val();
            var groupheadname = $("#groupheadname").val();
            var required = "Field is required.";

            res = true;
            if(groupheadname === ''){
                $("#cekGroupHeadName").text(required);
                $("#groupheadname").addClass("is-invalid");
                $("#groupheadname").focus();
                res = false;
            }
            if(grouphead === ''){
                $("#cekGrouphead").text(required);
                $("#grouphead").addClass("is-invalid");
                $("#grouphead").focus();
                res = false;
            }
            if(groupname === ''){
                $("#cekGroupname").text(required);
                $("#groupname").addClass("is-invalid");
                $("#groupname").focus();
                res = false;
            }
            if(data !== "update") {
                if (groupid === '') {
                    $("#cekGroupId").text(required);
                    $("#groupid").addClass("is-invalid");
                    $("#groupid").focus();
                    res = false;
                }
                $.ajax({
                    type: "GET",
                    url: "{{ url('get-idgroup') }}",
                    data: {
                        'id': groupid,
                    },
                    success: function (res) {
                        if (res.status === "01") {
                            $("#cekGroupId").text('Group Id not available, try another ID');
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
                case 'grouphead':
                    var grouphead = $("#grouphead").val();
                    if(grouphead !== ''){
                        $("#grouphead").removeClass("is-invalid");
                        $("#cekGrouphead").text('');
                    };
                    break;
                case 'groupheadname':
                    var groupheadname = $("#groupheadname").val();
                    if(groupheadname !== ''){
                        $("#groupheadname").removeClass("is-invalid");
                        $("#cekGroupHeadName").text('');
                    };
                    break;
            }
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

            $("#groupid").attr('readonly',false);
            $("#add-group").removeClass("d-none");
            $("#add-group").addClass("d-block");
            $("#main-group").removeClass("d-block");
            $("#main-group").addClass("d-none");
            $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Tambah");
            $("#savegroupbutton").removeClass('d-none');
            $("#savegroupbutton").addClass('d-block');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');
            clearCache();

        }
        function editGroup(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('group-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#groupid").val(data);
                    $("#groupid").attr('readonly',true);
                    $("#groupname").val(res.name);
                    $("#grouphead").val(res.head_id);
                    $("#groupheadname").val(res.head_name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res.name);
                }
            });

            // $("#groupname").val('');
            $("#hiddengroupid").val(data);

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
        $("#updategroup").on("click", function () {
            var groupid = $("#hiddengroupid").val();
            var groupname = $("#groupname").val();
            var groupheadid = $("#grouphead").val();
            var groupheadname = $("#groupheadname").val();

            var required = "Field is required.";
            if (validateField('update')){
                $.get("/mockjax");
                $.ajax({
                    type : "GET",
                    url  : "{{ url('group-update/submit') }}",
                    data : {
                        'group_id' : groupid,
                        'name' : groupname,
                        'head_id': groupheadid,
                        'head_name': groupheadname,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            if (res.status === "00"){
                                $('#table-reggroup').DataTable().ajax.reload();
                                $("#add-group").removeClass("d-block");
                                $("#add-group").addClass("d-none");
                                $("#main-group").removeClass("d-none");
                                $("#main-group").addClass("d-block");
                                $("#update_group_notification").text(res.group);
                                $("#alert-success-update").removeClass("d-none");
                                $("#alert-success-update").addClass("d-block");
                                $("#alert-success-registrasi").removeClass("d-block");
                                $("#alert-success-registrasi").addClass("d-none");
                                clearCache();
                            }
                        }
                    }
                });
            }

        });
        $("#resetgroup").on('click', function(){
            var data = $("#hiddengroupid").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('group-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#groupid").val(data);
                    $("#groupname").val(res.name);
                    $("#grouphead").val(res.head_id);
                    $("#groupheadname").val(res.head_name);
                }
            });
        });
        $("#canceleditgroup").on("click", function () {
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
                        $("#add-group").removeClass("d-block");
                        $("#add-group").addClass("d-none");
                        $("#main-group").removeClass("d-none");
                        $("#main-group").addClass("d-block");
                        $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
                        $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text("");
                    }
                }
            )
        });

        function clearCache(){
            $("#groupid").val('');
            $("#groupname").val('');
            $("#grouphead").val('');
            $("#groupheadname").val('');

            $("#cekGroupname").text('');
            $("#cekGroupId").text('');
            $("#cekGrouphead").text('');
            $("#cekGroupHeadName").text('');

            $("#groupid").removeClass("is-invalid");
            $("#groupname").removeClass("is-invalid");
            $("#grouphead").removeClass("is-invalid");
            $("#groupheadname").removeClass("is-invalid");
        }

        $("#cancelgroup").on("click", function () {
            var res =  $("#hiddengroupid").val()+$("#groupid").val()+$("#groupname").val()+$("#grouphead").val()+$("#groupheadname").val();
            res = res.trim();
            if(res.length > 0){
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
                            $("#add-group").removeClass("d-block");
                            $("#add-group").addClass("d-none");
                            $("#main-group").removeClass("d-none");
                            $("#main-group").addClass("d-block");
                            $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
                            clearCache();
                        }
                    }
                )

            }else{
                $("#add-group").removeClass("d-block");
                $("#add-group").addClass("d-none");
                $("#main-group").removeClass("d-none");
                $("#main-group").addClass("d-block");
                $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
                clearCache();
            }
        });

        $("#btn-current1").on("click", function(){
            getGroup();
        });

        function getGroup() {
            var id = $("#groupID").val();

            if(id === ''){
                $("#groupGet").val('');
                $('#table-reggroup').DataTable().ajax.reload();
            } else {
                $.ajax({
                    type : "GET",
                    url  : "{{ url('group-get') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#groupGet").val(res[0].name);
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
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i> User Admin</li>
                        <li class="breadcrumb-item active" aria-current="page">Group</li>
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
                <label class="form-control-label pr-5 mb-2">Group ID</label>
                <input class="form-control mb-2" placeholder="Input ID Group" id="groupID" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Group" readonly id="groupGet">
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
                    <span class="alert-inner--text"><strong id="update_group_notification"></strong>, has updated.</span>
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
                                        <th>Group ID</th>
                                        <th>Group Name</th>
                                        <th>Create Date</th>
                                        <th>Last Update</th>
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
            <input type="hidden" id="hiddengroupid">
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group ID</label>
                                    <input class="form-control col-sm-6" placeholder="Group ID" onchange="changeCheck('groupid')" type="text" id="groupid" maxlength="20"/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Group name" onchange="changeCheck('groupname')" max="255" required id="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Head ID</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Head ID" onchange="changeCheck('grouphead')" maxlength="20" required id="grouphead"/>
                                    <label id="cekGrouphead" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Head Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Head Name" onchange="changeCheck('groupheadname')" maxlength="50" required id="groupheadname"/>
                                    <label id="cekGroupHeadName" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="savegroup">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetgroup">Reset</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Group List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-grouplist">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Id</th>
                                <th>Group Name</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>10002</td>
                                <td>Trader</td>
                                <td><button class="btn btn-sm btn-success" type="button">OK</button></td>
                            </tr>
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
