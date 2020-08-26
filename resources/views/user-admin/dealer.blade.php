@extends('layouts.app-argon')

@section('js')
    <script>
        var groupname = '';
        var groupaddress = '';
        var groupphone = '';
        var groupmobilephone = '';
        var groupemail = '';
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
            var $form = $('#myFormDealer');
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
                        url: "{{ url('getDealerId') }}",
                        data: {
                            'id': groupid,
                        },
                        success: function (res) {
                            if (res.status === "01") {
                                $("#cekGroupId").text('Dealer Id not available, try another ID');
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
                    if ($("#hiddendealerid").val() === ''){
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

        function clickOK(id) {
            $("#dealerID").val(id);
            getGroup();
        }

        function getTableList() {
            $("#table-grouplist").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

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
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'dealer_id', name: 'dealer_id'},
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
                    searchable : true,
                    targets : [2],
                    className: 'text-center',
                    render : function (data, type, row) {
                        return '' +
                            '<button class="btn btn-sm btn-primary" type="button" data-dismiss= "modal" onclick="clickOK('+row.dealer_id+')">Pick</button>'
                    }
                },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                ]
            });
        }

        function getTableGroup(){
            var tableGroup = $("#table-reggroup").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,

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
                    {data : 'dealer_name', name: 'dealer_name'},
                    {data : 'dealer_id', name: 'dealer_id'},
                    {data : 'address', name: 'address'},
                    {data : 'phone', name: 'phone'},
                    {data : 'mobilephone', name: 'mobilephone'},
                    {data : 'email', name: 'email'},
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
                    searchable : true,
                    targets : [5],
                    searchable : true,
                },{
                    targets : [6],
                    orderable : true,
                    className: "text-center",
                    render : function (data, type, row) {
                        var id = row.group_id;
                        return '' +
                            '<button class="btn btn-sm btn-warning fa fa-pen" type="button" data-dismiss= "modal" onclick="editDealer(\''+data+'\')"></button>' +
                            '<button class="btn btn-sm btn-info fa fa-user-cog" type="button" data-dismiss= "modal" onclick="assignSales(\''+data+'\')"></button>'
                    }
                },{
                    responsivePriority: 1, target: 0,
                    responsivePriority: 2, target: 1,
                    responsivePriority: 3, target: 2,
                }
                ]
            });
        }

        function savegroup() {
            var groupname = $("#groupname").val();
            var groupid = $("#groupid").val();
            var groupaddress = $("#groupaddress").val();
            var groupmobile = $("#groupmobilphone").val();
            var groupphone = $("#groupphone").val();
            var groupemail = $("#groupemail").val();

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

                            clearVariable();
                        }else{
                            $("#alert-error-registrasi").addClass('d-block');
                            $("#alert-error-registrasi").removeClass('d-none');
                            $("#err_msg").text(res.err_msg);
                        }
                    }
                }
            });
        }

        function updategroup() {
            var groupid = $("#hiddendealerid").val();
            var groupname = $("#groupname").val();
            var groupaddress = $("#groupaddress").val();
            var groupphone = $("#groupphone").val();
            var groupmobilephone = $("#groupmobilphone").val();
            var groupemail = $("#groupemail").val();

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

                            clearVariable();
                        }else{
                            $("#alert-error-registrasi").addClass('d-block');
                            $("#alert-error-registrasi").removeClass('d-none');
                            $("#err_msg").text(res.err_msg);
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

            $("#hiddendealerid").val('');
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

        function assignSales(data){
            $.ajax({
                type: "GET",
                url : "{{ url('dealer-nouser') }}",
                data: {
                    'dealer_id': data,
                },
                success: function (res) {
                    if ($.trim(res)){
                        $.ajax({
                            type: "GET",
                            url: "{{ url('dealer-update/') }}",
                            data: {
                                'id': data,
                            },
                            success: function (res) {
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
                        getAssignSalesTable(data, "01");
                    } else {
                        swal({
                            title: "No Assign",
                            text: "Please create users for dealer, before assign sales to dealer.",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonClass: 'btn-warning',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
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
                responsive: true,

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
                    orderable : true,
                    searchable : true,
                },{
                    targets : [5],
                    orderable : true,
                    searchable : true,
                },{
                    searchable : true,
                    targets : [6],
                    orderable : true,
                    className: 'text-center',
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
                }]
            });
        }

        function selectChange(code){
            var data = $("#idCurrDealer").val();
        }

        function addThis(salesId){
            dealerId = $("#idCurrDealer").val();

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
                }
            );
        }

        function removeThis(salesId){
            dealerId = $("#idCurrDealer").val();

            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    cancelButtonText: "No",
                    confirmButtonText: "Yes",
                    closeOnCancel: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
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
                }
            );
        }

        function editDealer(data){
            $("#groupid").attr( "disabled", "disabled" );
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

                    groupname = res.dealer_name;
                    groupaddress = res.address;
                    groupphone = res.phone;
                    groupmobilephone = res.mobilephone;
                    groupemail = res.email;
                }
            });

            // $("#groupname").val('');
            $("#hiddendealerid").val(data);


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
            $("#groupid").val('');
            $("#groupname").val('');
            $("#groupaddress").val('');
            $("#groupphone").val('');
            $("#groupmobilphone").val('');
            $("#groupemail").val('');

            $("#alert-error-registrasi").addClass('d-none');
            $("#alert-error-registrasi").removeClass('d-block');

            $("#alert-error-assign").addClass('d-none');
            $("#alert-error-assign").removeClass('d-block');
        }

        function clearVariable() {
            groupname = '';
            groupaddress = '';
            groupphone = '';
            groupmobilephone = '';
            groupemail = '';
        }

        function cancelEdit(){
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
            $("#add-group").removeClass("d-block");
            $("#add-group").addClass("d-none");
            $("#main-group").removeClass("d-none");
            $("#main-group").addClass("d-block");

            clearVariable();
        }

        $("#canceleditgroup").on("click", function () {
            var groupnameN = $("#groupname").val();
            var groupaddressN = $("#groupaddress").val();
            var groupphoneN = $("#groupphone").val();
            var groupmobilephoneN = $("#groupmobilphone").val();
            var groupemailN = $("#groupemail").val();

            if (groupname === groupnameN && groupaddress === groupaddressN && groupphone === groupphoneN &&
                groupmobilephone === groupmobilephoneN && groupemail === groupemailN) {
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
                    function(isConfirm) {
                        if (isConfirm) {
                            cancelEdit();
                        }
                    }
                )
            }
        });

        $("#cancelgroup").on("click", function () {
            var res =  $("#groupid").val()+$("#groupname").val()+$("#groupaddress").val()+$("#groupphone").val()+$("#groupmobilphone").val()+$("#groupemail").val();
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
                                        <th data-priority="1">Dealer Name</th>
                                        <th data-priority="3">Dealer Id</th>
                                        <th data-priority="10001">Address</th>
                                        <th data-priority="10002">Phone</th>
                                        <th data-priority="10003">Mobile Phone</th>
                                        <th data-priority="10004">Email</th>
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
        <form id="myFormDealer">
            <input type="hidden" id="hiddendealerid">

            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">

                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer ID</label>
                                    <input class="form-control col-sm-6" id="groupid" name="groupid" type="text" onchange="cacheError();" maxlength="20" placeholder="Dealer ID"/>
                                    <label id="cekGroupId" class="error invalid-feedback small d-block col-sm-4" for="groupid"></label>

                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer Name</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Dealer Name" onchange="cacheError();" id="groupname" name="groupname"/>
                                    <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Address</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Address" onchange="cacheError();" id="groupaddress" name="groupaddress"/>
                                    <label id="cekGroupAddress" class="error invalid-feedback small d-block col-sm-4" for="groupaddress"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Phone" maxlength="15" onchange="cacheError();" id="groupphone" name="groupphone"/>
                                    <label id="cekGroupPhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Mobile Phone</label>
                                    <input class="form-control col-sm-6" type="text" placeholder="Mobile Phone" maxlength="15" onchange="cacheError();" id="groupmobilphone" name="groupmobilphone"/>
                                    <label id="cekGroupMobilePhone" class="error invalid-feedback small d-block col-sm-4" for="groupphone"></label>
                                </div>
                                <div class="form-group form-inline lbl-group">
                                    <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Email</label>
                                    <input class="form-control col-sm-6" type="email" placeholder="Email" onchange="cacheError();" id="groupemail" name="groupemail"/>
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
                                        <th data-priority="1">Sales Name</th>
                                        <th data-priority="3">Sales Id</th>
                                        <th data-priority="10001">Adress</th>
                                        <th data-priority="10002">Phone</th>
                                        <th data-priority="10003">Mobile Phone</th>
                                        <th data-priority="10004">Email</th>
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
                                <th>Dealer Name</th>
                                <th>Dealer Id</th>
                                <th>Action</th>
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
