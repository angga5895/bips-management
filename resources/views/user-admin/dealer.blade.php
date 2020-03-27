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
                    url: '{{ url("getDataDealer") }}',

                },
                columns : [
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
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
                    orderable : true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [6],
                    render : function (data, type, row) {
                        var id = row.group_id;
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/
                        return '' +
                            '<button class="btn btn-sm btn-primary fa fa-trash" type="button" data-dismiss= "modal" onclick="clickOK('+id+')"></button>' +
                            '<button class="btn btn-sm btn-primary fa fa-pencil" type="button" data-dismiss= "modal" onclick="clickOK(\'+id+\')">OK</button>'
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
                    url: '{{ url("getDataDealer") }}',
                },
                columns : [
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
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
                    orderable : true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [6],
                    render : function (data, type, row) {
                        var id = row.group_id;
                        return '' +
                            '<button class="btn btn-sm btn-warning fa fa-pen" type="button" data-dismiss= "modal" onclick="clickOK(\'+id+\')"></button>' +
                            '<button class="btn btn-sm btn-danger fa fa-trash" type="button" data-dismiss= "modal" onclick="clickOK('+id+')"></button>'

                    }
                }]
            });
        }

        $("#savegroup").on("click", function () {
            var groupname = $("#groupname").val();
            var groupid = $("#groupid").val();
            var groupaddress = $("#groupaddress").val();
            var groupmobile = $("#groupmobilphone").val();
            var groupphone = $("#groupphone").val();
            var groupemail = $("#groupemail").val();

            var required = "Field is required.";
            if (groupname !== ''){
                $.get("/mockjax");

                $.ajax({
                    type : "GET",
                    url  : "{{ url('dealer-registrasi') }}",
                    data : {
                        'dealer_id' : groupid,
                        'dealer_name' : groupname,
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
                            }
                        }
                    }
                });
            } else{
                if(groupemail === ''){$("#cekGroupEmail").text(required);$("#groupemail").addClass("is-invalid");$("#groupemail").focus();}
                if(groupmobile === ''){$("#cekGroupMobilePhone").text(required);$("#groupmobilphone").addClass("is-invalid");$("#groupmobilphone").focus();}
                if(groupphone === ''){$("#cekGroupPhone").text(required);$("#groupphone").addClass("is-invalid");$("#groupphone").focus();}
                if(groupaddress === ''){$("#cekGroupAddress").text(required);$("#groupaddress").addClass("is-invalid");$("#groupaddress").focus();}
                if(groupname === ''){$("#cekGroupname").text(required);$("#groupname").addClass("is-invalid");$("#groupname").focus();}
                if(groupid === ''){$("#cekGroupId").text(required);$("#groupid").addClass("is-invalid");$("#groupid").focus();}
            }
        });

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
            clearCache();
        }

        function clearCache(){
            var groupname = $("#groupname").val();
            $("#cekGroupname").text('');$("#groupname").removeClass("is-invalid");
        }

        $("#cancelgroup").on("click", function () {
            $("#add-group").removeClass("d-block");
            $("#add-group").addClass("d-none");
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");
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
                        <li class="breadcrumb-item active" aria-current="page">Dealer</li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow" id="main-group">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Dealer ID</label>
                <input class="form-control mb-2" placeholder="Input ID Dealer Group" id="groupID" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Dealer Group" readonly id="groupGet">
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
                                        <th>Dealer Id</th>
                                        <th>Dealer Name</th>
                                        <th>Adress</th>
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
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer ID</label>
                                    <input class="form-control col-sm-6" id="groupid" type="text" maxlength="20" placeholder="Please Input" required/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>

                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input" required id="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Address</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input" required id="groupaddress"/>
                                    <label id="cekGroupAddress" class="error invalid-feedback small d-block col-sm-4" for="groupaddress"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input" maxlength="15" required id="groupphone"/>
                                    <label id="cekGroupPhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Mobile Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Please Input" maxlength="15" required id="groupmobilphone"/>
                                    <label id="cekGroupMobilePhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Email</label>
                                    <input class="form-control col-sm-6" type="email" placeholder="Please Input" required id="groupemail"/>
                                    <label id="cekGroupEmail" class="error invalid-feedback small d-block col-sm-4" for="groupemail"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="savegroup">Save</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="cancelgroup">Cancel</button>
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
