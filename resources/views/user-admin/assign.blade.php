@extends('layouts.app-argon')

@section('js')
    <script>
        $(document).ready(function () {
            getTableGroup();
            getTableList();
            getTableGroupUserAO();
            getGroupId();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });
        });

        function getTableGroupUserAO() {
            $("#table-aolist").dataTable({
                destroy: true,
                ajax : {
                    url: '{{ url("get-dataAOList/get") }}',
                    data: function (d) {
                        var search_data = {aoID:''};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'user_id', name: 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'user_id', name: 'user_id'},
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [1],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [2],
                    orderable : true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [3],
                    render : function (data, type, row) {
                        var id = row.user_id;
                        var username = row.user_name;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOKUserAO(\''+id+'\',\''+username+'\')">OK</button>'
                    }
                }]
            });
        }

        function clickOKUserAO(id,username) {
            $("#aoid_id").val(id);
            $("#aoid_us").val(username);

            if($("#aoid_us").val() !== ""){$("#cekAoid").text('');$("#aoid_us").removeClass("is-invalid");}
        }

        function refreshTableList(){
            $('#table-grouplist').DataTable().ajax.reload();
        }

        function clickOK(id) {
            $("#groupID").val(id);
            getGroup();
        }

        function getGroupId(){
            var tableListMember = $("#table-listmember").DataTable({
                destroy: true,
                ajax : {
                    url: '{{ url("getGroupUser/get") }}',
                    data: function (d) {
                        var search_data = {groupID:$("#group_hidden").val()};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'sequence_no', name: 'sequence_no'},
                    {data : 'user_id', name: 'user_id'},
                    {data : 'user_name', name: 'user_name'},
                    {data : 'dealer_id', name: 'dealer_id'},
                    /*{data : 'client_id', name: 'client_id'},*/
                ],
                columnDefs: [
                    {
                        targets : [0],
                        orderable : true,
                        searchable : true,
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
                    },/*{
                    searchable : true,
                    targets : [4],
                    render : function (data, type, row) {
                        var id = row.group_id;
                        /!*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*!/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+id+')">OK</button>'
                    }
                }*/]
            });

            $('#table-listmember tbody').on('click', 'tr', function () {
                var data = tableListMember.row( this ).data();
                var aoid = data.dealer_id;
                var aoname = data.user_name;
                tableListMember.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                $("#cekAoid").text("");
                $("#aoid_us").removeClass("is-invalid");
                $("#aoid_us").val(aoname);
                $("#aoid_id").val(aoid);
            } );
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
                        var id = row.group_id;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+id+'\')">OK</button>'
                    }
                }]
            });
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
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
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    searchable : false,
                },{
                    targets : [1],
                    orderable : true,
                    searchable : true,
                }]
            });

            $('#table-reggroup tbody').on('click', 'tr', function () {
                var data = tableGroup.row( this ).data();
                var groupid = data.group_id;
                tableGroup.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                $("#group_hidden").val(groupid);
                $('#table-listmember').DataTable().ajax.reload();

                $("#cekUser").text("");
                $("#grpname").removeClass("is-invalid");
                $("#grpname").val(data.name);
            } );
        }

        $("#btn-current2").on("click", function(){
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

        $("#add-btn").on("click", function () {
            var user = $("#grpname").val();
            var aoid = $("#aoid_us").val();

            var userid = $("#aoid_id").val();
            var groupid = $("#group_hidden").val();

            var required = "Field is required.";
            var clicktable = "Click Table Group Before.";
            var clickaoid = "Please Choose AOID Before.";

            if (user === '' || aoid === ''){
                if (user === ''){ $("#cekUser").text(required+' '+clicktable);$("#grpname").addClass("is-invalid");$("#grpname").focus();}
                if(aoid === ''){$("#cekAoid").text(required+' '+clickaoid);$("#aoid_us").addClass("is-invalid");$("#aoid_us").focus();}
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{ url('addNewUserGroup') }}",
                    data: {
                        'id': userid,
                        'group_id': groupid,
                    },
                    success: function (res) {
                        if ($.trim(res)) {
                            if (res.status === "00") {
                                $('#table-listmember').DataTable().ajax.reload();
                                swal({
                                    title: "Success",
                                    text: "Berhasil menambahkan user ke grup baru",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-success',
                                    confirmButtonText: 'OK',
                                });
                            }else if(res.status === "01"){
                                swal({
                                    title: "Failed",
                                    text: "User telah bergabung dengan grup ini",
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-success',
                                    confirmButtonText: 'OK',
                                });
                            }
                        }
                    }
                });
            }
        });

        $("#del-btn").on("click", function () {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var user = $("#grpname").val();
                        var aoid = $("#aoid_us").val();

                        var userid = $("#aoid_id").val();
                        var groupid = $("#group_hidden").val();

                        var required = "Field is required.";
                        var clicktable = "Click Table Group Before.";
                        var clickaoid = "Please Choose Username AO Before.";

                        if (user === '' || aoid === ''){
                            if (user === '') {
                                $("#cekUser").text(required + ' ' + clicktable);
                                $("#grpname").addClass("is-invalid");
                                $("#grpname").focus();
                            }
                            if (aoid === '') {
                                $("#cekAoid").text(required + ' ' + clickaoid);
                                $("#aoid_us").addClass("is-invalid");
                                $("#aoid_us").focus();
                            }
                        } else {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('delUserGroup') }}",
                                data: {
                                    'id': userid,
                                    'group_id': groupid,
                                },
                                success: function (res) {
                                    console.log(res.napa);
                                    if ($.trim(res)) {
                                        if (res.status === "00") {
                                            $('#table-listmember').DataTable().ajax.reload();
                                            swal({
                                                title: "Success",
                                                text: "Berhasil menghapus user",
                                                type: "success",
                                                showCancelButton: false,
                                                confirmButtonClass: 'btn-success',
                                                confirmButtonText: 'OK',
                                            });
                                        } else if (res.status === "03") {
                                            swal({
                                                title: "Failed",
                                                text: "User tidak bergabung dengan grup",
                                                type: "warning",
                                                showCancelButton: false,
                                                confirmButtonClass: 'btn-success',
                                                confirmButtonText: 'OK',
                                            });
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
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
                        <li class="breadcrumb-item active" aria-current="page">Registrasi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Group ID</label>
                <input class="form-control mb-2" placeholder="Input ID Group" id="groupID" onchange="getGroup()">
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal" onclick="refreshTableList();"><i class="fa fa-search"></i></button>
                <input class="form-control mb-2" placeholder="Nama Detail Group" readonly id="groupGet">
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current2">Search</button>
            </form>
        </div>

        <div class="card card-body" style="min-height: 365px">
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
                                        <th>Group ID</th>
                                        <th>Group Name</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <label class="form-control-label">List Member Account Officer</label>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-listmember">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>Seq</th>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Dealer ID</th>
                                        {{--<th>#</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{--<td></td>--}}
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{--<td></td>--}}
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{--<td></td>--}}
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{--<td></td>--}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <form>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-0 px-0">Group Name</label>
                                    <input class="form-control" type="hidden" placeholder="ID Group" required id="group_hidden"/>
                                    <input class="form-control col-sm-5 readonly" type="text" placeholder="Please Click Table Group" id="grpname" required/>
                                    <label id="cekUser" class="error invalid-feedback small d-block col-sm-5" for="grpname"></label>
                                </div>

                                <div class="form-group form-inline lbl-user-aoid">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-0 px-0">User Name</label>
                                    <div class="input-group col-sm-5 px-0">
                                        <input class="form-control form-control-input col-sm-12 mb-0 mx-0 readonly" placeholder="Username Dealer" id="aoid_us" value="" required/>
                                        <div class="input-group-append">
                                            <span class="input-group-text btn btn-default" data-toggle="modal" data-target="#exampleModal1">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <label id="cekAoid" class="error invalid-feedback small d-block col-sm-5" for="aoid_us"></label>
                                    <input type="hidden" id="aoid_id"/>
                                </div>

                                <div class="form-group form-inline justify-content-end mb-0">
                                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="add-btn">Add</button>
                                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="del-btn">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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

    <!-- Modal Employees List -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Account Officer List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-aolist">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>AOID</th>
                                <th>AO Name</th>
                                <th>Username</th>
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
