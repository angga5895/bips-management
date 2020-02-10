@extends('layouts.app-argon')

@section('js')
    <script>
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
        function getGroupId(id){
            $("#table-listmember").DataTable({
                destroy: true,
                ajax : {
                    url: '{{ url("getGroupUser/get") }}',
                    data: function (d) {
                        var search_data = {groupID:id};
                        d.search_param = search_data;
                    }
                },  
                columns : [
                    {data : 'sequence_no', name: 'sequence_no'},
                    {data : 'client_id', name: 'client_id'},
                    {data : 'dlrname', name: 'dlrname'},
                    {data : 'username', name: 'username'},
                    {data : 'client_id', name: 'client_id'},
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
                },{
                    searchable : true,
                    targets : [4],
                    render : function (data, type, row) {
                        var id = row.group_id;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+id+')">OK</button>'
                    }
                }]
            });
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
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+id+')">OK</button>'
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
                getGroupId(groupid);
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
                                        <th>AO ID</th>
                                        <th>AO Name</th>
                                        <th>Username</th>
                                        <th>#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <form>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Group Name</label>
                                    <input class="form-control" type="text" placeholder="Please Input"/>
                                </div>

                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Account Officer</label>
                                    <select class="form-control mb-2 bootstrap-select w-select-100" data-live-search="true" data-style="btn-white" placeholder="Input ID Group">
                                        <option value="" disabled selected>AOID</option>
                                        <option value="1">Test</option>
                                    </select>
                                    <input class="form-control form-control-input mb-2" placeholder="Nama Detail Group" readonly>
                                    <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal1"><i class="fa fa-search"></i></button>
                                </div>

                                <div class="form-group form-inline justify-content-end mb-0">
                                    <button class="form-control-btn btn btn-primary mb-2" type="button">Search</button>
                                    <button class="form-control-btn btn btn-danger mb-2" type="button">Delete</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Employees List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-grouplist">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Employee No</th>
                                <th>Employee Name</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>3</td>
                                <td>Amiruddin</td>
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
