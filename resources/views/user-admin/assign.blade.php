@extends('layouts.app-argon')

@section('js')
    <script>
        $(document).ready(function () {
            getTableGroup();
            getTableList();
            getTableGroupUserAO();
            getGroupId();
            getTableDealerList();
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });
        });

        function getTableDealerList() {
            $("#table-dealerList").dataTable({
                destroy: true,
                responsive: true,

                ajax : {
                    url: '{{ url("dealerGetSalesID") }}',
                    data: function (d) {
                        var search_data = {
                            dealerID:$("#aoid_id").val(),
                    };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'sequence_no', name: 'sequence_no'},
                    {data : 'sales_id', name: 'sales_id'},
                    {data : 'sales_name', name: 'sales_id'},
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
                },
                ]
            });
        }

        function getTableGroupUserAO() {
            $("#table-pickDealer").dataTable({
                destroy: true,
                ajax : {
                    url: '{{ url("getDataDealer") }}',
                    data: function (d) {
                        var search_data = {dealerId:''};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'dealer_id', name: 'dealer_id'},
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
                    searchable : true,
                    targets : [2],
                    className: 'text-center',
                    render : function (data, type, row) {
                        var id = row.dealer_id;
                        var username = row.dealer_name;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOKUserAO(\''+id+'\',\''+username+'\')">Pick</button>'
                    },
                },]
            });
        }

        function resetApp(){
            $("#grpname").val('');
            $("#group_hidden").val('');
            $("#aoid_us").val('');
            $("#aoid_id").val('');
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
                // destroy: true,
                responsive: true,

                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-sm btn-danger mb-2" type="button" onclick="delAllUser()">Delete All Member</button>');
                },
                ajax : {
                    url: '{{ url("getGroupUser/get") }}',
                    data: function (d) {
                        var search_data = {groupID:$("#group_hidden").val()};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'sequence_no', name: 'sequence_no'},
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'email', name: 'email'},
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
                    },
                    /*{
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

                $('#table-dealerList').DataTable().ajax.reload();

                $('#ModalDealerList').modal('show');
            } );
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
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
                    className: 'text-center',
                    render : function (data, type, row) {
                        var id = row.group_id;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+id+'\')">Pick</button>'
                    }
                }
                ]
            });
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

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
                $("#nameofgroup").text(data.name);
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

        function delAllUser(){
            var groupid = $("#group_hidden").val();

            if (groupid === ''){
                swal({
                    title: "Error",
                    text: "Please, choose the group for delete all members.",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'OK',
                });
            } else {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "No",
                        cancelButtonText: "Yes",
                        closeOnCancel: true,
                },
                function(isConfirm) {
                    if (!isConfirm) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('delAllUserGroup') }}",
                            data: {
                                'group_id': groupid,
                            },
                            success: function (res) {
                                if ($.trim(res)) {
                                    if (res.status === "00") {
                                        $('#table-listmember').DataTable().ajax.reload();
                                        swal({
                                            title: "Success",
                                            text: res.message,
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn-success',
                                            confirmButtonText: 'OK',
                                        });
                                    } else if (res.status === "03") {
                                        swal({
                                            title: "Failed",
                                            text: res.message,
                                            type: "warning",
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn-danger',
                                            confirmButtonText: 'OK',
                                        });
                                    }
                                }
                            }
                        });
                    }
                });
            }
        }

        $("#add-btn").on("click", function () {
            var user = $("#grpname").val();
            var aoid = $("#aoid_us").val();

            var userid = $("#aoid_id").val();
            var groupid = $("#group_hidden").val();

            var iduser = $("#grpname");
            var idaoid = $("#aoid_us");

            var required = "Field is required.";
            var clicktable = "Click Table Group Before.";
            var clickaoid = "Please Choose List Dealer Before.";

            if (!iduser[0].checkValidity() || !idaoid[0].checkValidity()){
                if (!iduser[0].checkValidity()){ $("#cekUser").text(required+' '+clicktable);$("#grpname").addClass("is-invalid");iduser.focus();}
                if (!idaoid[0].checkValidity()){$("#cekAoid").text(required+' '+clickaoid);$("#aoid_us").addClass("is-invalid");idaoid.focus();}
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
                                    text: res.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-success',
                                    confirmButtonText: 'OK',
                                });
                            }else if(res.status === "01"){
                                swal({
                                    title: "Failed",
                                    text: res.message,
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-danger',
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

                    var iduser = $("#grpname");
                    var idaoid = $("#aoid_us");

                    var required = "Field is required.";
                    var clicktable = "Click Table Group Before.";
                    var clickaoid = "Please Choose List Dealer Before.";

                    if (!iduser[0].checkValidity() || !idaoid[0].checkValidity()){
                        if (!iduser[0].checkValidity()) {
                            $("#cekUser").text(required + ' ' + clicktable);
                            $("#grpname").addClass("is-invalid");
                            $("#grpname").focus();
                        }
                        if (!idaoid[0].checkValidity()) {
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
                                if ($.trim(res)) {
                                    if (res.status === "00") {
                                        $('#table-listmember').DataTable().ajax.reload();
                                        swal({
                                            title: "Success",
                                            text: res.message,
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn-success',
                                            confirmButtonText: 'OK',
                                        });
                                    } else if (res.status === "03") {
                                        swal({
                                            title: "Failed",
                                            text: res.message,
                                            type: "warning",
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn-danger',
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
                        <li class="breadcrumb-item active"><i class="ni ni-single-02"></i>&nbsp;Master Data</li>
                        <li class="breadcrumb-item active" aria-current="page">Group Dealer</li>
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
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Group" readonly id="groupGet">
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal" onclick="refreshTableList();"><i class="fa fa-search"></i></button>
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
                                <table class="table table-striped table-bordered table-hover table-hoverclick" id="table-reggroup">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th data-priority="2">Group ID</th>
                                        <th data-priority="1">Group Name</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <label class="form-control-label">
                                List Member Group :&nbsp;
                                <strong id="nameofgroup">-</strong>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-hoverclick" id="table-listmember">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th data-priority="3">Seq</th>
                                        <th data-priority="2">Dealer ID</th>
                                        <th data-priority="1">Dealer Name</th>
                                        <th data-priority="10001">Email</th>
                                        {{--<th>#</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
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
                                    <label class="form-control-label form-inline-label col-sm-2 mb-0 px-0">Dealer Name</label>
                                    <div class="input-group col-sm-5 px-0">
                                        <input class="form-control form-control-input col-sm-12 mb-0 mx-0 readonly" placeholder="Dealer Name" id="aoid_us" value="" required/>
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
                                    <button class="form-control-btn btn btn-info mb-2" type="button" onclick="resetApp()">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Modal Dealer List -->
    <div class="modal fade" id="ModalDealerList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <table class="table table-striped table-bordered table-hover" id="table-dealerList">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th data-priority="3">Saq</th>
                                <th data-priority="2">Sales ID</th>
                                <th data-priority="1">Sales Name</th>
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
                                <th data-priority="3">Group ID</th>
                                <th data-priority="1">Group Name</th>
                                <th data-priority="2">Action</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Dealer List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover display nowrap dataTable" id="table-pickDealer">
                        <thead class="bg-gradient-primary text-lighter">
                        <tr>
                            <th data-priority="3">Dealer ID</th>
                            <th data-priority="1">Dealer Name</th>
                            <th data-priority="2">Action</th>
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
