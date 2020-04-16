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
            $("#dealerID").val(id);
            getGroup();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                ajax : {
                    url: '{{ url("getDataDealer") }}',
                    data: function (d) {
                        var search_data = {
                            dealerId: $("#dealerID").val(),
                        };
                        d.search_param = search_data;
                    },
                },
                columns : [
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
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
                        return '' +
                            '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+row.dealer_id+')">Pick</button>'
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
                    data: function (d) {
                        var search_data = {
                            dealerId: $("#dealerID").val(),
                        };
                        d.search_param = search_data;
                    },
                },

                columns : [
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
                    {data : 'dealer_id', name: 'dealer_id'},

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
                            '<button class="btn btn-sm btn-warning fa fa-pen" type="button" data-dismiss= "modal" onclick="editDealer(\''+data+'\')"></button>' +
                            '<button class="btn btn-sm btn-info fa fa-user-cog" type="button" data-dismiss= "modal" onclick="assignSales(\''+data+'\')"></button>'
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

            if (validateGroup('save')){
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
                                $("#breadAdditional").removeClass("d-block").addClass("d-none").text("");

                                $("#add-group").addClass("d-none");
                                $("#main-group").removeClass("d-none");
                                $("#main-group").addClass("d-block");
                                $("#regisgroup").text(res.group);
                                $("#alert-success-registrasi").removeClass("d-none");
                                $("#alert-success-registrasi").addClass("d-block");
                                $("#alert-success-update").removeClass("d-block");
                                $("#alert-success-update").addClass("d-none");
                            }else{
                                $("#alert-error-registrasi").addClass('d-block');
                                $("#alert-error-registrasi").removeClass('d-none');
                                $("#err_msg").text(res.err_msg);
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
                    url: "{{ url('getDealerId') }}",
                    data: {
                        'id': groupid,
                    },
                    success: function (res) {
                        if (res.status === "01") {
                            $("#cekGroupId").text('Dealer Id not available, try another ID');
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
            clearCache();
        }
        function assignSales(data){


            $.ajax({
                type : "GET",
                url  : "{{ url('dealer-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                        $("#groupID").val(res.dealer_id);
                        $("#groupGetSales").val(res.dealer_name);
                        $("#breadAdditional").removeClass("d-none").addClass("d-block").text(res.dealer_name);
                        $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text('Assign Sales');
                        $("#sales-group").removeClass("d-none");
                        $("#sales-group").addClass("d-block");
                        $("#main-group").removeClass("d-block");
                        $("#main-group").addClass("d-none");
                        $("#idCurrDealer").val(data);
                        clearCache();
                }
            });


            getAssignSalesTable(data,"01");
        }
        $("#typeuser").on('change', function() {
            alert( this.value );
        });
        function getAssignSalesTable(data,typeRes){
            var id = $("#idCurrDealer").val();
            var select01 = "";
            var select02 = "";
            var select00 = "";
            if(typeRes == "00"){
                var select00 = "selected";
            }else if(typeRes == "02"){
                var select02 = "selected";
            }else{
                var select01 = "selected";
            }
            $("#table-dealer-sales").DataTable({
                /*processing: true,
                serverSide: true,*/
                dom: 'l<"toolbar"><"selectToolbar col-md-3">frtip',
                initComplete: function(){
                    $("div.toolbar").html('' +
                        '<div class="input-group"><a href="{{url('dealer')}}">'+
                    '<button class="form-control-btn-0 btn btn-primary mb-2" type="button"  style="display: inline";>Back</button></a>&nbsp;&nbsp;&nbsp;<div id="idselect"></div></div>');
                    $('<select class="form-control" data-live-search="true" data-style="btn-default"><option value="01" '+select01+'>Assigned Sales</option><option value="02"  '+select02+'>Unassigned Sales</option><option value="00" '+select00+'>All Sales</option></select>').appendTo( $("div.selectToolbar")).on('change', function (){
                        $("#table-dealer-sales").DataTable().clear().destroy();
                        getAssignSalesTable(data,$(this).val());
                    });
                },
                ajax : {
                    url: '{{ url("dealerGetSales/") }}',
                    data : {
                        'id' : data,
                        'type': typeRes,
                    },
                },
                columns : [
                    {data : 'sls', name: 'sls'},
                    {data : 'sls', name: 'sls'},
                    {data : 'sales_name', name: 'sales_name'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
                ],
                columnDefs: [{
                    targets : [0],
                    orderable : true,
                    render : function (data, type, row) {
                        var id = row.group_id;
                        if(!row.dealer_id){
                            return '<button class="btn btn-sm btn-success fa fa-user-plus" type="button" data-dismiss= "modal" onclick="addThis(\''+row.sls+'\')"></button>'
                        }else{
                            if(data == null){
                                return '<button class="btn btn-sm btn-success fa fa-user-plus" type="button" data-dismiss= "modal" onclick="addThis(\''+row.sls+'\')"></button>'
                            }else{
                                return '<button class="btn btn-sm btn-danger fa fa-user-minus" type="button" data-dismiss= "modal" onclick="removeThis(\''+row.sls+'\')"></button>'
                            }
                        }
                        /*return '<a class="btn btn-sm btn-success" href="/user/'+data+'/edit">Edit</a>' +*/

                    }
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
                    searchable : true,
                }]
            });
        }
        function selectChange(code){
            var data = $("#idCurrDealer").val();

        }
        function addThis(salesId){
            dealerId = $("#idCurrDealer").val();
            $.ajax({
                type : "GET",
                url  : "{{ url('dealerAssign/add/') }}",
                data : {
                    'dealer_id' : dealerId,
                    'sales_id': salesId,
                },
                success : function (res) {
                    if(res.status == "00"){
                        $("#alert-addsuccess").removeClass("d-none");
                        $("#alert-addsuccess").addClass("d-block");
                        $("#alert-del").removeClass("d-block");
                        $("#alert-del").addClass("d-none");
                    }else{
                        $("#alert-error-assign").removeClass('d-none');
                        $("#alert-error-assign").addClass('d-block');
                        $("#err_msg_assign").text(res.err_msg);
                    }
                    $('#table-dealer-sales').DataTable().ajax.reload();
                }
            });
        }
        function removeThis(salesId){
            dealerId = $("#idCurrDealer").val();
            $.ajax({
                type : "GET",
                url  : "{{ url('dealerAssign/remove/') }}",
                data : {
                    'dealer_id' : dealerId,
                    'sales_id': salesId,
                },
                success : function (res) {
                    if(res.status == "00") {
                        $("#alert-del").removeClass("d-none");

                        $("#alert-del").addClass("d-block");

                        $("#alert-addsuccess").removeClass("d-block");
                        $("#alert-addsuccess").addClass("d-none");
                    }else{
                        $("#alert-error-assign").removeClass('d-none');
                        $("#alert-error-assign").addClass('d-block');
                        $("#err_msg_assign").text(res.err_msg);
                    }
                    $('#table-dealer-sales').DataTable().ajax.reload();
                }
            });
        }
        function editDealer(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('dealer-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(res.dealer_name);
                    $("#groupid").val(data);
                    $("#groupname").val(res.dealer_name);
                    $("#groupaddress").val(res.address);
                    $("#groupphone").val(res.phone);
                    $("#groupmobilphone").val(res.mobilephone);
                    $("#groupemail").val(res.email);
                }
            });

            // $("#groupname").val('');
            $("#hiddendealerid").val(data);


            $("#add-group").removeClass("d-none");
            $("#add-group").addClass("d-block");
            $("#main-group").removeClass("d-block");
            $("#main-group").addClass("d-none");
            $("#savegroupbutton").addClass('d-none');
            $("#editgroupbutton").removeClass('d-none');
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
                    $("#groupmobilphone").val(res.mobilephone);
                    $("#groupemail").val(res.email);
                }
            });
        });
        $("#updategroup").on("click", function () {
            var groupid = $("#hiddendealerid").val();
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
                    url  : "{{ url('dealer-update/submit') }}",
                    data : {
                        'dealer_id' : groupid,
                        'dealer_name' : groupname,
                        'address': groupaddress,
                        'phone': groupphone,
                        'mobile_phone': groupmobilephone,
                        'email': groupemail,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            if (res.status === "00"){
                                $("#resetgroupadd").click();
                                $('#table-reggroup').DataTable().ajax.reload();

                                $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
                                $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');

                                $("#add-group").removeClass("d-block");
                                $("#add-group").addClass("d-none");
                                $("#main-group").removeClass("d-none");
                                $("#main-group").addClass("d-block");
                                $("#savegroupbutton").removeClass('d-none');
                                $("#editgroupbutton").addClass('d-none');

                                $("#update_dealer_notification").text(res.group);
                                $("#alert-success-update").removeClass("d-none");
                                $("#alert-success-update").addClass("d-block");
                                $("#alert-success-registrasi").removeClass("d-block");
                                $("#alert-success-registrasi").addClass("d-none");
                            }else{
                                $("#alert-error-registrasi").addClass('d-block');
                                $("#alert-error-registrasi").removeClass('d-none');
                                $("#err_msg").text(res.err_msg);
                            }
                        }
                    }
                });
            }
        });
        $("#canceleditgroup").on("click", function () {
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

            $("#alert-error-registrasi").addClass('d-none');
            $("#alert-error-registrasi").removeClass('d-block');

            $("#alert-error-assign").addClass('d-none');
            $("#alert-error-assign").removeClass('d-block');
        }

        $("#cancelgroup").on("click", function () {
            var res =  $("#groupid").val()+$("#groupname").val()+$("#groupaddress").val()+$("#groupphone").val()+$("#groupmobilphone").val()+$("#groupemail").val();
            res = res.trim();
            if(res.length > 0){
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

        $("#btn-current1").on("click", function(){
            getGroup();
        });

        function getGroup() {
            var id = $("#dealerID").val();

            if(id === ''){
                $("#groupGet").val('');
                $('#table-reggroup').DataTable().ajax.reload();
            } else {
                $.ajax({
                    type : "GET",
                    url  : "{{ url('dealerGetName') }}",
                    data : {
                        'id' : id,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            $("#groupGet").val(res[0].dealer_name);
                        } else {
                            $("#groupGet").val('');
                        }
                        $('#table-reggroup').DataTable().ajax.reload();
                    }
                });
            }
        }
        function closeAlert(){
            $("#alert-del").removeClass("d-block");
            $("#alert-del").addClass("d-none");
            $("#alert-addsuccess").removeClass("d-block");
            $("#alert-addsuccess").addClass("d-none");
        }
        function closeAlertAssign(){
            $("#alert-error-assign").removeClass('d-block');
            $("#alert-error-assign").addClass('d-none');
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
                        <li class="breadcrumb-item active" aria-current="page">Dealer</li>
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
                <label class="form-control-label pr-5 mb-2">Dealer ID</label>
                <input class="form-control mb-2" placeholder="Input ID Dealer Group" id="dealerID" onchange="getGroup()">
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
                                    <input class="form-control col-sm-6" id="groupid" type="text" onchange="changeCheck('groupid')" maxlength="20" placeholder="Dealer ID"/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>

                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Dealer Name" onchange="changeCheck('groupname')" required id="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Address</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Address" required onchange="changeCheck('groupaddress')" id="groupaddress"/>
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
                                    <input class="form-control col-sm-6" type="email" placeholder="Email" onchange="changeCheck('groupemail')" required id="groupemail"/>
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
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetgroupadd">Reset</button>
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
    <div class="card shadow d-none" id="sales-group">
        <input type="hidden" id="idCurrDealer">
        <input type="hidden" id="typeCurrUser">

        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Dealer ID</label>
                <input class="form-control mb-2" placeholder="Input ID Dealer Group" id="groupID" onchange="getGroup()">
                <input class="form-control mb-2 ml-input-2" placeholder="Nama Detail Dealer Group" readonly id="groupGetSales">
                <button class="form-control-btn btn btn-default mb-2" type="button" data-toggle="modal" data-target="#exampleModal" onclick="refreshTableList()"><i class="fa fa-search"></i></button>
                <button class="form-control-btn btn btn-primary mb-2" type="button" id="btn-current1">Search</button>
            </form>
        </div>

        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-error-assign">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <span class="alert-inner--text"><strong>Err.</strong><span id="err_msg_assign"></span></span>
                    <button type="button" class="close" onclick="closeAlertAssign()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-addsuccess">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                    <span class="alert-inner--text">Sales has registered.</span>
                    <button type="button" class="close" onclick="closeAlert()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-del">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="fa fa-trash"></i></span>
                    <span class="alert-inner--text">Sales has un-registered.</span>
                    <button type="button" class="close" onclick="closeAlert()" aria-label="Close">
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
                                <table class="table table-striped table-bordered table-hover" id="table-dealer-sales">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        {{--<th>ID</th>--}}
                                        <th>#</th>
                                        <th>Sales Id</th>
                                        <th>Sales Name</th>
                                        <th>Adress</th>
                                        <th>Phone</th>
                                        <th>Mobile Phone</th>
                                        <th>Email</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Dealer List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-grouplist">
                            <thead class="bg-gradient-primary text-lighter">
                            <tr>
                                <th>Dealer Id</th>
                                <th>Dealer Name</th>
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
