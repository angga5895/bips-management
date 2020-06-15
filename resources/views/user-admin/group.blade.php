@extends('layouts.app-argon')

@section('js')
    <script>
        var groupname = '';
        var grouphead = '';
        var groupheadname = '';
        var rulesobj = {
            "groupid" : {
                required : true
            },
            "groupname" : {
                required : true
            },
            "grouphead" : {
                required : true
            },
            "groupheadname" : {
                required : true,
            },

        };

        var messagesobj = {
            "groupid" : {
                required : "Field is required."
            },
            "groupname" : {
                required : "Field is required."
            },
            "grouphead" : {
                required : "Field is required."
            },
            "groupheadname" : {
                required : "Field is required.",
            },
        };

        $(function () {
            var $form = $('#myFormGroup');
            $form.validate({
                rules: rulesobj,
                messages: messagesobj,
                debug: false,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback offset-label-error-sales');
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

            $form.find("#saveGroup").on('click', function () {
                if ($form.valid()) {
                    var groupid = $("#groupid").val();
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
                            } else {
                                savegroup();
                            }
                        }
                    });
                } else {
                    $('.lbl-group').removeClass('focused');
                }
                return false;
            });

            $form.find("#updateGroup").on('click', function () {
                updateGroup($form);
                return false;
            });

            $form.keypress(function(e) {
                if(e.which == 13) {
                    if ($("#hiddengroupid").val() === ''){
                        $("#saveGroup").click();
                        console.log('save');
                    } else {
                        updateGroup($form);
                        console.log('edit');
                    }
                }
            });
        });

        function updateGroup(form){
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
                            updategroup();
                        }
                    }
                )
            }  else {
                $('.lbl-group').removeClass('focused');
            }
        }

        $(document).ready(function () {
            getTableGroup();
            getTableList();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
        });

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
            var time = datetime[1];
            // return time;
            var date = tgl[2];

            return time+" "+date+" "+month+" "+year;
        }

        function refreshTableList(){
            $('#table-grouplist').DataTable().ajax.reload();
        }

        function clickOK(id) {
            $("#groupID2").val(id);
            getGroup();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                responsive: true,

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
                    {data : 'name', name: 'name'},
                    {data : 'group_id', name: 'group_id'},
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
                    className: 'text-center',
                    render : function (data, type, row) {
                      return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+row.group_id+'\')">Pick</button>'
                    }
                }]
            });
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                responsive: true,

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
                        var search_data = {groupID:$("#groupID2").val()};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'name', name: 'name'},
                    {data : 'group_id', name: 'group_id'},
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
                    className: 'text-center',
                    render : function (data, type, row) {
                        return  '<button class="btn btn-sm btn-warning fa fa-pen" onclick="editGroup(\''+data+'\')" type="button" data-dismiss= "modal")"></button>'
                    }
                }]
            });
        }

        function savegroup() {
            var groupid = $("#groupid").val();
            var groupname = $("#groupname").val();
            var grouphead = $("#grouphead").val();
            var groupheadname = $("#groupheadname").val();

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

                            clearVariable();
                        }else{
                            $("#err_msg").text(res.err_msg);
                            $("#alert-error-registrasi").removeClass("d-none");
                            $("#alert-error-registrasi").addClass("d-block");
                        }
                    }
                }
            });
        }

        function updategroup() {
            var groupid = $("#hiddengroupid").val();
            var groupname = $("#groupname").val();
            var groupheadid = $("#grouphead").val();
            var groupheadname = $("#groupheadname").val();

            var required = "Field is required.";

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

                            clearVariable();
                        }else{
                            $("#err_msg").text(res.err_msg);
                            $("#alert-error-registrasi").removeClass("d-none");
                            $("#alert-error-registrasi").addClass("d-block");
                        }
                    }
                }
            });
        }

        function addGroup() {
            $("#groupid").removeAttr( "disabled", "disabled" );
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
            $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Add");
            $("#savegroupbutton").removeClass('d-none');
            $("#savegroupbutton").addClass('d-block');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');

            clearCache();
        }

        function editGroup(data){
            $("#groupid").attr( "disabled", "disabled" );
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

                    groupname = res.name;
                    grouphead = res.head_id;
                    groupheadname = res.head_name;
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

        $("#resetgroup").on('click', function(){
            cacheError();
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

        function cacheError() {
            $('.lbl-group').removeClass('focused');

            $("#groupid-error").text('');
            $("#groupname-error").text('');
            $("#grouphead-error").text('');
            $("#groupheadname-error").text('');

            $("#groupid").removeClass("is-invalid");
            $("#groupname").removeClass("is-invalid");
            $("#grouphead").removeClass("is-invalid");
            $("#groupheadname").removeClass("is-invalid");

            $("#cekGroupname").text('');
            $("#cekGroupId").text('');
            $("#cekGrouphead").text('');
            $("#cekGroupHeadName").text('');
        }

        function clearCache(){
            cacheError();
            $("#groupid").val('');
            $("#groupname").val('');
            $("#grouphead").val('');
            $("#groupheadname").val('');

            $("#alert-error-registrasi").removeClass('d-block');
            $("#alert-error-registrasi").addClass('d-none');
        }

        function cancelEdit(){
            $("#add-group").removeClass("d-block");
            $("#add-group").addClass("d-none");
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text("");

            clearVariable();
        }

        $("#canceleditgroup").on("click", function () {
            var groupnameN = $("#groupname").val();
            var groupheadN = $("#grouphead").val();
            var groupheadnameN = $("#groupheadname").val();

            if (groupname === groupnameN && grouphead === groupheadN && groupheadname === groupheadnameN) {
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
                    function (isConfirm) {
                        if (isConfirm) {
                            cancelEdit();
                        }
                    }
                )
            }
        });

        $("#cancelgroup").on("click", function () {
            var res =  $("#hiddengroupid").val()+$("#groupid").val()+$("#groupname").val()+$("#grouphead").val()+$("#groupheadname").val();
            res = res.trim();
            if(res.length > 0){
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

        function clearVariable() {
            groupname = '';
            grouphead = '';
            groupheadname = '';
        }

        $("#btn-current1").on("click", function(){
            getGroup();
        });

        function getGroup() {
            var id = $("#groupID2").val();

            if(id === ''){
                $("#groupGet2").val('');
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
                            $("#groupGet2").val(res[0].name);
                        } else {
                            $("#groupGet2").val('');
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

    <div class="card shadow" id="main-group">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Group ID</label>
                <input class="form-control mb-2" placeholder="Input ID Group" id="groupID2" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Group" readonly id="groupGet2">
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
                                        <th data-priority="1">Group Name</th>
                                        <th data-priority="3">Group ID</th>
                                        <th data-priority="10001">Create Date</th>
                                        <th data-priority="10002">Last Update</th>
                                        <th data-priority="2">Action</th>
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
        <form id="myFormGroup">
            <input type="hidden" id="hiddengroupid">
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
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group ID</label>
                                    <input class="form-control col-sm-6" placeholder="Group ID" onchange="cacheError();" type="text" id="groupid" name="groupid" maxlength="20"/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Group name" onchange="cacheError();" maxlength="255" id="groupname" name="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Head ID</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Head ID" onchange="cacheError();" maxlength="20" id="grouphead" name="grouphead"/>
                                    <label id="cekGrouphead" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Head Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Head Name" onchange="cacheError();" maxlength="50" id="groupheadname" name="groupheadname"/>
                                    <label id="cekGroupHeadName" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveGroup">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset" onclick="cacheError();">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="cancelgroup">Cancel</button>
                </div>
                <div class="form-inline justify-content-end d-none" id="editgroupbutton">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="updateGroup">Update</button>
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
                                <th data-priority="1">Group Name</th>
                                <th data-priority="3">Id</th>
                                <th data-priority="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>10002</td>
                                <td>Trader</td>
                                <td><button class="btn btn-sm btn-success" type="button">Pick</button></td>
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
