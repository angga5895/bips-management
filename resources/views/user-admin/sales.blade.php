@extends('layouts.app-argon')

@section('js')
    <script>
        var rulesobj = {
            "groupid" : {
                required : true
            },
            "groupname" : {
                required : true
            },
            "groupaddress" : {
                required : true
            },
            "groupphone" : {
                required : true,
                digits : true
            },
            "groupmobilphone" : {
                required : true,
                digits : true
            },
            "groupemail" : {
                required : true,
                email :true
            },

        };

        var messagesobj = {
            "groupid" : {
                required : "Field is required."
            },
            "groupname" : {
                required : "Field is required."
            },
            "groupaddress" : {
                required : "Field is required."
            },
            "groupphone" : {
                required : "Field is required.",
                digits : "Field must be a number."
            },
            "groupmobilphone" : {
                required : "Field is required.",
                digits : "Field must be a number."
            },
            "groupemail" : {
                required : "Field is required.",
                email : "Field must be a valid email address."
            },

        };

        $(function () {
            var $form = $('#myFormSales');
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
                        url: "{{ url('getSalesId') }}",
                        data: {
                            'id': groupid,
                        },
                        success: function (res) {
                            if (res.status === "01") {
                                $("#cekGroupId").text('Sales Id not available, try another ID');
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
                    if ($("#hiddensalesid").val() === ''){
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

            var date = tgl[2];

            return date+" "+month+" "+year;
        }

        function refreshTableList(){
            $('#table-grouplist').DataTable().ajax.reload();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
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
                    {data : 'sales_name', name: 'sales_name'},
                    {data : 'sls', name: 'sls'},
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
                    className: "text-center",
                    render : function (data, type, row) {
                        return '<i class="text-center">' +
                            '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK(\''+data+'\')">Pick</button></i>'}
                },
                ]
            });
        }

        function clickOK(id) {
            $("#salesID").val(id);
            // alert($("#salesID").val());
            getGroup();
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                responsive: {
                    details: true,
                },
                /*processing: true,
                serverSide: true,*/
                aaSorting: [[0, 'desc']],
                dom: 'l<"toolbar"><f "col-md-6">rtip',
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
                    {data : 'sales_name', name: 'sales_name'},
                    {data : 'sls', name: 'sls'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
                    {data : 'sls', name: 'sls'},
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
                    targets : [3],
                    orderable : true,
                    searchable : true,
                },{
                    targets : [4],
                    orderable :true,
                    searchable : true,
                },{
                    targets : [5],
                    orderable :true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [6],
                    className: 'text-center',
                    render : function (data, type, row) {
                        return  '<i class="text-center"><button class="btn btn-sm btn-warning fa fa-pen" onclick="editSales(\''+data+'\')" type="button" data-dismiss= "modal")"></button>'
                    },
                    className: "text-center",
                },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 2 },
                ],
            });
        }

        function savegroup() {
            var groupname = $("#groupname").val();
            var groupid = $("#groupid").val()
            var groupaddress = $("#groupaddress").val();
            var groupmobile = $("#groupmobilphone").val();
            var groupphone = $("#groupphone").val();
            var groupemail = $("#groupemail").val();

            var required = "Field is required.";
            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('sales-registrasi') }}",
                data: {
                    'sales_id': groupid,
                    'sales_name': groupname,
                    'address': groupaddress,
                    'phone': groupphone,
                    'mobilephone': groupmobile,
                    'email': groupemail,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-group").removeClass("d-block");
                            $("#add-group").addClass("d-none");
                            $("#main-group").removeClass("d-none");
                            $("#main-group").addClass("d-block");
                            $("#regisgroup").text(res.group);
                            $("#alert-success-registrasi").removeClass("d-none");
                            $("#alert-success-registrasi").addClass("d-block");
                        } else {
                            $("#err_msg").text(res.err_msg);
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-none");
                        }
                    }
                }
            });
        }

        function updategroup() {
            var groupid = $("#hiddensalesid").val();
            var groupname = $("#groupname").val();
            var groupaddress = $("#groupaddress").val();
            var groupphone = $("#groupphone").val();
            var groupmobilephone = $("#groupmobilphone").val();
            var groupemail = $("#groupemail").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('sales-update/submit') }}",
                data: {
                    'sales_id': groupid,
                    'sales_name': groupname,
                    'address': groupaddress,
                    'phone': groupphone,
                    'mobile_phone': groupmobilephone,
                    'email': groupemail,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-reggroup').DataTable().ajax.reload();
                            $("#add-group").removeClass("d-block");
                            $("#add-group").addClass("d-none");
                            $("#main-group").removeClass("d-none");
                            $("#main-group").addClass("d-block");
                            $("#update_sales_notification").text(res.group);
                            $("#alert-success-update").removeClass("d-none");
                            $("#alert-success-update").addClass("d-block");
                        } else {
                            $("#err_msg").text(res.err_msg);
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-none");
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

            $("#hiddensalesid").val('');
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
            $("#groupid").attr( "disabled", "disabled" );
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
                        $("#groupmobilphone").val(res.mobilephone);
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
            cacheError();
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
                    $("#groupmobilphone").val(res.mobilephone);
                    $("#groupemail").val(res.email);
                }
            });
        });

        function cacheError() {
            $('.lbl-group').removeClass('focused');

            $("#groupid-error").text('');
            $("#groupname-error").text('');
            $("#groupaddress-error").text('');
            $("#groupphone-error").text('');
            $("#groupmobilphone-error").text('');
            $("#groupemail-error").text('');

            $("#groupid").removeClass("is-invalid");
            $("#groupname").removeClass("is-invalid");
            $("#groupaddress").removeClass("is-invalid");
            $("#groupphone").removeClass("is-invalid");
            $("#groupmobilphone").removeClass("is-invalid");
            $("#groupemail").removeClass("is-invalid");

            $("#cekGroupname").text('');
            $("#cekGroupId").text('');
            $("#cekGroupAddress").text('');
            $("#cekGroupPhone").text('');
            $("#cekGroupMobilePhone").text('');
            $("#cekGroupEmail").text('');
        }

        function clearCache(){
            cacheError();
            $("#hiddendealerid").val('');
            $("#groupid").val('');
            $("#groupname").val('');
            $("#groupaddress").val('');
            $("#groupphone").val('');
            $("#groupmobilphone").val('');
            $("#groupemail").val('');


            $("#hiddendealerid").removeClass("is-invalid");

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

        $("#canceleditgroup").on("click", function () {
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
            $("#add-group").removeClass("d-block");
            $("#add-group").addClass("d-none");
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");
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
                                <table class="table table-striped table-bordered nowrap" width="100%" id="table-reggroup">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th data-priority="0">Sales Name</th>
                                        <th data-priority="2">Sales Id</th>
                                        <th data-priority="10006">Address</th>
                                        <th data-priority="10002">Phone</th>
                                        <th data-priority="10003">Mobile Phone</th>
                                        <th data-priority="10004">Email</th>
                                        <th data-priority="1">Action</th>
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
        <form id="myFormSales">
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
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales ID</label>
                                    <input class="form-control col-sm-6" id="groupid" name="groupid" type="text" maxlength="20" placeholder="Sales ID" onchange="cacheError();"/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>

                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Sales Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Sales Name" id="groupname" name="groupname" onchange="cacheError();"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Address</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Address" id="groupaddress" name="groupaddress" onchange="cacheError();"/>
                                    <label id="cekGroupAddress" class="error invalid-feedback small d-block col-sm-4" for="groupaddress"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Phone" maxlength="15" id="groupphone" name="groupphone" onchange="cacheError();"/>
                                    <label id="cekGroupPhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Mobile Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Mobile Phone" maxlength="15" id="groupmobilphone" name="groupmobilphone" onchange="cacheError();"/>
                                    <label id="cekGroupMobilePhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Email</label>
                                    <input class="form-control col-sm-6" type="email" placeholder="Email" id="groupemail" name="groupemail" onchange="cacheError();"/>
                                    <label id="cekGroupEmail" class="error invalid-feedback small d-block col-sm-4" for="groupemail"></label>
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
                                <th data-priority="1">Sales Name</th>
                                <th data-priority="3">Sales Id</th>
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
