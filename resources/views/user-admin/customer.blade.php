@extends('layouts.app-argon')

@section('js')
    <script>
        function convertStatus(status){
            switch (status) {
               case 'A': return 'Active';break;
                case 'T': return 'Trade Disabled'; break;
                case 'B': return 'Suspend Buy'; break;
                case 'S': return 'Suspend Sell'; break;
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

        function clickOK(id,name) {
            $("#customerID").val(id);
            getGroup();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('');
                },
                ajax : {
                    url: '{{ url("getDataCustomer") }}',
                    data: function (d) {
                        var search_data = {
                            customerID:"",
                        };
                        d.search_param = search_data;
                    },
                },
                columns : [
                    {data : 'custcode', name: 'custcode'},
                    {data : 'custname', name: 'custname'},
                    {data : 'custcode', name: 'custcode'},
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
                    render : function (data, type, row) {
                        var name = row.custname;
                        return '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+row.custcode+'\',\''+name+'\')">Pick</button>'
                    }}]
            });
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                aaSorting: [[0, 'desc']],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('');
                },
                ajax : {
                    url: '{{ url("getDataCustomer") }}',
                    data: function (d) {
                        var search_data = {
                            customerID: $("#customerID").val(),
                        };
                        d.search_param = search_data;
                    },
                },
                columns : [
                    {data : 'custcode', name: 'custcode'},
                    {data : 'custname', name: 'custname'},
                    {data : 'custstatus', name: 'custstatus'},
                    {data : 'email', name: 'email'},
                    {data : 'phone', name: 'phone'},
                    {data : 'custcode', name: 'custcode'},
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
                    render : function (data, type, row) {
                        return convertStatus(data);
                    }
                },{
                    targets : [3],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [4],
                    orderable : true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [5],
                    render : function (data, type, row) {
                        return '<button class="btn btn-sm btn-info fa fa-search" type="button" data-dismiss= "modal" onclick="detailCustomer(\''+data+'\',\''+row.custname+'\')"></button>'
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
        function detailCustomer(id,name){
            $("#breadDetail").removeClass('d-none');
            $("#detail-group").removeClass("d-none");
            $("#detail-group").addClass("d-block");
            $("#main-group").removeClass("d-block");
            $("#main-group").addClass("d-none");
            getDetailCustomer(id);
            console.log(name);
            $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Detail");
            $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(name);

            // $('#table_detail_customer').DataTable().ajax.reload();
            clearCache();
        }
        function getDetailCustomer(id){
            var tbldetail = $("#table_detail_customer").DataTable({
                /*processing: true,
                serverSide: true,*/
                aaSorting: [[0, 'desc']],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('' +
                        '<a href="{{url('customer')}}"><button class="form-control-btn-0 btn btn-primary mb-2" type="button"> ' +
                        'Back</button></a>');
                },
                ajax : {
                    url: '{{ url("getDataCustomerDetail/") }}',
                    data: function (d) {
                        var search_data = {id: id};
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'base_account_no', name: 'base_account_no'},
                    {data : 'account_name', name: 'account_name'},
                    {data : 'cif_no', name: 'cif_no'},
                    {data : 'balance', name: 'balance'},
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
                },
                ]
            });
        }
        function backback(){
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");
            $("#detail-group").removeClass("d-block");
            $("#detail-group").addClass("d-none");
            clearCache();
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
            clearCache();
        }

        $("#resetgroup").on('click', function(){
            var data = $("#hiddendealerid").val()
            $.ajax({
                type : "GET",
                url  : "{{ url('dealer-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    $("#groupid").val(data);
                    $("#groupname").val(res.dealer_name);
                    $("#groupaddress").val(res.address);
                    $("#groupphone").val(res.phone);
                    $("#groupmobilphone").val(res.mobile_phone);
                    $("#groupemail").val(res.email);
                }
            });
        });

        $("#canceleditgroup").on("click", function () {
            if(confirm("Are u sure dischard changes?")){
                $("#add-group").removeClass("d-block");
                $("#add-group").addClass("d-none");
                $("#main-group").removeClass("d-none");
                $("#main-group").addClass("d-block");
            }
        });
        function backtomain(){
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");
            $("#detail-group").removeClass("d-block");
            $("#detail-group").addClass("d-none");


            clearCache();
        }
        function clearCache(){
            var groupname = $("#groupname").val();
            $("#cekGroupname").text('');$("#groupname").removeClass("is-invalid");
        }

        $("#btn-current1").on("click", function(){
            getGroup();
        });

        function getGroup() {
            var id = $("#customerID").val();

            if(id === ''){
                $("#customerGet").val('');
                $('#table-reggroup').DataTable().ajax.reload();
            } else {
                $.ajax({
                    type : "GET",
                    url  : "{{ url('customerGetName') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#customerGet").val(res[0].custname);
                        } else {
                            $("#customerGet").val('');
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

                        <li class="breadcrumb-item active" aria-current="page">Customer</li>

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
                <label class="form-control-label pr-5 mb-2">Customer Code</label>
                <input class="form-control mb-2" placeholder="Input ID Dealer Group" id="customerID" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Customer" readonly id="customerGet">
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
                    <span class="alert-inner--text"><strong id="update_dealer_notification"></strong>, has updated.</span>
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
                                        <th>Custcomer Code</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Phone</th>
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
            <input type="hidden" id="hiddendealerid">

            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer ID</label>
                                    <input class="form-control col-sm-6" id="groupid" type="text" maxlength="20" placeholder="Please Input" readonly/>
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
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="savegroup">Save</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="cancelgroup">Cancel</button>
                </div>
                <div class="form-inline justify-content-end d-none" id="editgroupbutton">
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetgroup">Reset</button>
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="updategroup">Update</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceleditgroup">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow d-none" id="detail-group">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Customer Code</label>
                <input class="form-control mb-2" placeholder="Input ID Dealer Group" id="groupID" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Customer" readonly id="groupGet">
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal" onclick="refreshTableList()"><i class="fa fa-search"></i></button>
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current1">Search</button>
            </form>
        </div>

        <div class="card card-body" style="min-height: 365px">
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            {{--<div class="form-inline">

                            </div>--}}
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table_detail_customer">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th>Account No</th>
                                        <th>Account Name</th>
                                        <th>Cif No</th>
                                        <th>Balance</th>
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
    <!-- Modal Group List -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer List</h5>
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
