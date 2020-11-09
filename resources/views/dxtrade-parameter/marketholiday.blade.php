@extends('layouts.app-argon')

@section('css')
    <link rel="stylesheet" href="{{ url('bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ url('bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
@endsection

@section('js')
    <script src="{{ url('moment/moment.js') }}"></script>
    <script src="{{ url('bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ url('bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

    <script src="{{ url('forms_pickers.js') }}"></script>
    <script type="text/javascript">
        var urecdate = '';
        var udescription = '';
        var ustatus = '';
        var conrecdate = 0;

        var rulesobj = {
            "rec_date" : {
                required : true
            },
            "status" : {
                required : true
            },
            "description" : {
                required : true
            }
        }

        var messagesobj = {
            "status" : "Please pick an role admin.",
            "rec_date" : "Field is required.",
            "description" : "Field is required.",
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            var $form = $('#myForm');
            $form.validate({
                rules: rulesobj,
                messages: messagesobj,
                debug: false,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    $(element).addClass('is-invalid');
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');

                    if (element.id === 'status'){
                        $(".lbl-status > .dropdown.bootstrap-select").addClass("is-invalid");
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    if (element.id === 'status'){
                        $(".lbl-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                    }
                }
            });

            $form.find("#saveUser").on('click', function () {
                if ($form.valid()) {
                    var rdate = $("#tgl_rec_date").val();
                    $.ajax({
                        type : "GET",
                        url  : "{{ url('marketholidaydate-check') }}",
                        data : {
                            'tgl_rec_date' : rdate,
                        },
                        success : function (res) {
                            if (res.status === "01"){
                                var ex = $("#rec_date").val();
                                $("#rec_date").val('');
                                $("#rec_date").valid();
                                $(".lbl-group").removeClass('focused');

                                $("#rec_date").val(ex);
                                conrecdate = 1;
                            } else {
                                conrecdate = 0;
                                saveUser();
                            }
                        }
                    });
                } else {
                    $('.lbl-group').removeClass('focused');
                }
                return false;
            });

            $form.find("#updateUser").on('click', function () {
                updateUser($form);
                return false;
            });

            $form.keypress(function(e) {
                if(e.which == 13) {
                    if ($("#hiddenuseradminid").val() === ''){
                        $("#saveUser").click();
                        console.log('save');
                    } else {
                        updateUser($form);
                        console.log('edit');
                    }
                }
            });
        });

        function saveUser() {
            var desc = $("#description").val();
            var recdate = $("#tgl_rec_date").val();
            var status = $("#status").val();

            $.get("/mockjax");

            $.ajax({
                type : "GET",
                url  : "{{ url('marketholiday-registrasi') }}",
                data : {
                    'desc' : desc,
                    'recdate' : recdate,
                    'status' : status,
                },
                success : function (res) {
                    if ($.trim(res)){
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
                        if (res.status === "00"){
                            $('#table-marketholiday').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            var udatadate = new Date(res.rec_date);
                            var udate = udatadate.getFullYear() + "-" + appendLeadingZeroes(udatadate.getMonth() + 1) + "-" + appendLeadingZeroes(udatadate.getDate());
                            $("#regisuser").text(getDateBipsShort(udate));
                            $("#alert-success-registrasi").removeClass("d-none");
                            $("#alert-success-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-block");
                            $("#alert-error-registrasi").addClass("d-none");

                            clearVariable();
                        } else {
                            $('#table-marketholiday').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#messageuser").text(res.message);
                            $("#alert-error-registrasi").removeClass("d-none");
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-success-registrasi").removeClass("d-block");
                            $("#alert-success-registrasi").addClass("d-none");
                        }
                    }

                    $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
                    $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
                }
            });
        };

        function updateUser(form){
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
                            var tgl = $("#tgl_rec_date").val();
                            var tglN = $("#hiddenuseradminid").val();

                            if (tgl !== tglN){
                                $.ajax({
                                    type : "GET",
                                    url  : "{{ url('marketholidaydate-check') }}",
                                    data : {
                                        'tgl_rec_date' : tgl,
                                    },
                                    success : function (res) {
                                        if (res.status === "01"){
                                            var ex = $("#rec_date").val();
                                            $("#rec_date").val('');
                                            $("#rec_date").valid();
                                            $(".lbl-group").removeClass('focused');

                                            $("#rec_date").val(ex);
                                            conrecdate = 1;
                                        } else {
                                            conrecdate = 0;
                                            updateuser();
                                        }
                                    }
                                });
                            }  else {
                                updateuser();
                            }
                        }
                    }
                )
            }  else {
                $('.lbl-group').removeClass('focused');
            }
        }

        function updateuser() {
            var id = $("#hiddenuseradminid").val();
            var recdate = $("#tgl_rec_date").val();
            var status = $("#status").val();
            var desc = $("#description").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('marketholiday-update/submit') }}",
                data: {
                    'id': id,
                    'desc': desc,
                    'recdate': recdate,
                    'status': status,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-marketholiday').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            var udatadate = new Date(res.rec_date);
                            var udate = udatadate.getFullYear() + "-" + appendLeadingZeroes(udatadate.getMonth() + 1) + "-" + appendLeadingZeroes(udatadate.getDate());
                            $("#update_user_notification").text(getDateBipsShort(udate));
                            $("#alert-success-update").removeClass("d-none");
                            $("#alert-success-update").addClass("d-block");

                            clearVariable();
                        } else {
                            $("#err_msg").text(res.message);
                            $("#alert-error-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-none");
                        }
                    }

                    $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
                    $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
                }
            });
        }

        function clearVariable() {
            urecdate = '';
            udescription = '';
            ustatus = '';
        }

        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();

            setInterval(function () {
                if(conrecdate > 0){
                    $('#rec_date-error').text('Rec date already exist.');
                }
            },100);

            tablegetMarketHoliday();

            var lastmonth = new Date($("#tgl_awal").val());
            var thismonth = new Date($("#tgl_akhir").val());
            var recdate = new Date($("#tgl_rec_date").val());
            $("#tgl_awal_current").datepicker("setDate",lastmonth);
            $("#tgl_akhir_current").datepicker("setDate",thismonth);
            $("#rec_date").datepicker("setDate",recdate);
            dateSummary();
        });

        function tablegetMarketHoliday() {
            var tableData = $("#table-marketholiday").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
                aaSorting: [[1, 'desc']],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-primary mb-2" type="button" id="adduser" onclick="addUser()">Add</button>');
                },
                ajax : {
                    url: '{{ url("datamarketholiday-get") }}',
                    data: function (d) {
                        var search_data = {
                            tgl_awal: $("#tgl_awal").val(),
                            tgl_akhir: $("#tgl_akhir").val(),
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'rec_date', name: 'rec_date'},
                    {data : 'rec_date', name: 'rec_date'},
                    {data : 'status', name: 'status'},
                    {data : 'description', name: 'description'},
                ],
                columnDefs: [{
                    searchable : true,
                    targets : [0],
                    orderable : false,
                    className: 'text-center',
                    render : function (data, type, row) {
                        return '<button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" onclick="editUser(\''+data+'\')">' +
                            '<i class="fa fa-pen"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(\''+data+'\')">' +
                            '<i class="fa fa-trash"></i>' +
                            '</button>'
                    }
                },{
                    targets : [1],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<span style="display: none;">'+data+'</span>'+getDateBipsShort(data);
                    }
                },{
                    targets : [2],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        var dt = data;
                        if (dt === 'C'){
                            dt = 'CLOSED';
                        } else if (dt === 'O'){
                            dt = 'OPEN';
                        }
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : dt;
                    }
                },{
                    targets : [3],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                }]
            });
        }

        function getDateBipsShort(tanggal){
            var datetime = tanggal.split(" ");
            var tgl = datetime[0].split("-");

            var year = tgl[0];

            if (tgl[1] == '01' ||tgl[1] == '1'){
                var month = 'Jan';
            } else if (tgl[1] == '02' ||tgl[1] == '2'){
                var month = 'Feb';
            } else if (tgl[1] == '03' ||tgl[1] == '3'){
                var month = 'Mar';
            } else if (tgl[1] == '04' ||tgl[1] == '4'){
                var month = 'Apr';
            } else if (tgl[1] == '05' ||tgl[1] == '5'){
                var month = 'Mei';
            } else if (tgl[1] == '06' ||tgl[1] == '6'){
                var month = 'Jun';
            } else if (tgl[1] == '07' ||tgl[1] == '7'){
                var month = 'Jul';
            } else if (tgl[1] == '08' ||tgl[1] == '8'){
                var month = 'Aug';
            } else if (tgl[1] == '09' ||tgl[1] == '9'){
                var month = 'Sep';
            } else if (tgl[1] == '10'){
                var month = 'Oct';
            } else if (tgl[1] == '11'){
                var month = 'Nov';
            } else if (tgl[1] == '12'){
                var month = 'Dec';
            }

            var date = tgl[2];

            return date+" "+month+" "+year;
        }

        function appendLeadingZeroes(n){
            if(n <= 9){
                return "0" + n;
            }
            return n
        }

        function dateSummary() {
            var tgllast = new Date($("#tgl_awal_current").val());
            var getlastdate = tgllast.getFullYear() + "/" + appendLeadingZeroes(tgllast.getMonth() + 1) + "/" + appendLeadingZeroes(tgllast.getDate());

            var tglthis = new Date($("#tgl_akhir_current").val());
            var getthisdate = tglthis.getFullYear() + "/" + appendLeadingZeroes(tglthis.getMonth() + 1) + "/" + appendLeadingZeroes(tglthis.getDate());

            $("#tgl_awal").val(getlastdate);
            $("#tgl_akhir").val(getthisdate);

            console.log(getlastdate + " & " + getthisdate);
            //$('#table-marketholiday').DataTable().ajax.reload();
        }

        function datetableSummary(check) {
            var tgllast = new Date($("#tgl_awal_current").val());
            var getlastdate = tgllast.getFullYear() + "/" + appendLeadingZeroes(tgllast.getMonth() + 1) + "/" + appendLeadingZeroes(tgllast.getDate());

            var tglthis = new Date($("#tgl_akhir_current").val());
            var getthisdate = tglthis.getFullYear() + "/" + appendLeadingZeroes(tglthis.getMonth() + 1) + "/" + appendLeadingZeroes(tglthis.getDate());

            $("#tgl_awal").val(getlastdate);
            $("#tgl_akhir").val(getthisdate);

            console.log(getlastdate + " & " + getthisdate);


            $.ajax({
                type : "GET",
                url  : "{{ url('get-activityUser') }}",
                data : {
                    'user_id' : 'example',
                },
                success : function (res) {
                    if (check === 1){
                        tableRefresh();
                    }
                }
            });
        }

        function tableRefresh() {
            $('#table-marketholiday').DataTable().ajax.reload();
        }

        function addUser() {
            /*$("[id=status]").val('');
            $("[data-id=status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose Status');*/
            $("#description").val('');
            $("#hiddenuseradminid").val('');

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#breadAdditional").addClass("d-block"); $("#breadAdditional").removeClass("d-none");$("#breadAdditional").text("Add");

            $("#savegroupbutton").addClass('d-block');
            $("#savegroupbutton").removeClass('d-none');
            $("#editgroupbutton").removeClass('d-block');
            $("#editgroupbutton").addClass('d-none');

            resetApp();
        }

        function clearCache(){
            conrecdate = 0;
            cacheError();

            $("#alert-error-registrasi").removeClass("d-block");
            $("#alert-error-registrasi").addClass("d-none");

            $("#alert-success-registrasi").removeClass("d-block");
            $("#alert-success-registrasi").addClass("d-none");

            $("#alert-success-update").removeClass("d-block");
            $("#alert-success-update").addClass("d-none");
        }

        function cacheError() {
            $('.lbl-group').removeClass('focused');

            $("#rec_date-error").text('');
            $("#status-error").text('');
            $("#description-error").text('');

            $(".lbl-status > .dropdown.bootstrap-select").removeClass("is-invalid");
            $("#rec_date").removeClass("is-invalid");
            $("#status").removeClass("is-invalid");
            $("#description").removeClass("is-invalid");

            $("#cekRecDate").text('');
            $("#cekStatus").text('');
            $("#cekDescription").text('');
        }

        $("#canceluser").on("click", function () {
            var rec_date = $("#rec_date").val();
            var description = $("#description").val();
            var status = $("#status").val();

            var rdate = new Date('<?php echo $monththis;?>');
            rdate = rdate.getFullYear() + "/" + appendLeadingZeroes(rdate.getMonth() + 1) + "/" + appendLeadingZeroes(rdate.getDate());
            var fdate = new Date(rec_date);
            fdate = fdate.getFullYear() + "/" + appendLeadingZeroes(fdate.getMonth() + 1) + "/" + appendLeadingZeroes(fdate.getDate());

            var res = description;
            res = res.trim();
            if(res.length > 0 || rdate !== fdate) {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonClass: "btn-danger",
                        confirmButtonClass: "btn-default",
                        cancelButtonText: "No",
                        confirmButtonText: "Yes",
                        closeOnCancel: true,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#breadAdditional").addClass("d-none");
                            $("#breadAdditional").removeClass("d-block");
                            $("#breadAdditional").text("");

                        }
                    }
                )
            } else {
                $("#add-user").removeClass("d-block");
                $("#add-user").addClass("d-none");
                $("#main-user").removeClass("d-none");
                $("#main-user").addClass("d-block");
                $("#breadAdditional").addClass("d-none");
                $("#breadAdditional").removeClass("d-block");
                $("#breadAdditional").text("");
            }
        });

        function resetApp(){
            var recdate = new Date('<?php echo $monththis;?>');
            var rdate = recdate.getFullYear() + "/" + appendLeadingZeroes(recdate.getMonth() + 1) + "/" + appendLeadingZeroes(recdate.getDate());

            $("#rec_date").datepicker("setDate",recdate);
            $("#tgl_rec_date").val(rdate);
            $("#description").val('');
            clearCache();
        }

        $("#resetuser").on('click', function(){
            cacheError();
            var data = $("#hiddenuseradminid").val();

            var datadate = new Date(data);
            var ddate = datadate.getFullYear() + "/" + appendLeadingZeroes(datadate.getMonth() + 1) + "/" + appendLeadingZeroes(datadate.getDate());
            $.ajax({
                type : "GET",
                url  : "{{ url('marketholiday-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    var recdate = new Date(res[0].rec_date);
                    var rdate = recdate.getFullYear() + "/" + appendLeadingZeroes(recdate.getMonth() + 1) + "/" + appendLeadingZeroes(recdate.getDate());
                    var udate = recdate.getFullYear() + "-" + appendLeadingZeroes(recdate.getMonth() + 1) + "-" + appendLeadingZeroes(recdate.getDate());

                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(getDateBipsShort(udate));
                    $("#hiddenuseradminid").val(ddate);


                    $("#rec_date").datepicker("setDate",recdate);
                    $("#tgl_rec_date").val(rdate);

                    $("[id=status]").val(res[0].status);

                    var sstatus = '-';
                    if (res[0].status === 'C'){
                        sstatus = 'CLOSED';
                    } else {
                        sstatus = 'OPEN';
                    }
                    $("[data-id=status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text(sstatus);
                    $("#description").val(res[0].description);
                }
            });
        });

        function editUser(data){
            var datadate = new Date(data);
            var ddate = datadate.getFullYear() + "/" + appendLeadingZeroes(datadate.getMonth() + 1) + "/" + appendLeadingZeroes(datadate.getDate());

            $.ajax({
                type : "GET",
                url  : "{{ url('marketholiday-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    var recdate = new Date(res[0].rec_date);
                    var udate = recdate.getFullYear() + "-" + appendLeadingZeroes(recdate.getMonth() + 1) + "-" + appendLeadingZeroes(recdate.getDate());
                    var rdate = recdate.getFullYear() + "/" + appendLeadingZeroes(recdate.getMonth() + 1) + "/" + appendLeadingZeroes(recdate.getDate());

                    // console.log(res.name);
                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(getDateBipsShort(udate));
                    $("#hiddenuseradminid").val(ddate);

                    $("#rec_date").datepicker("setDate",recdate);
                    $("#tgl_rec_date").val(rdate);

                    $("[id=status]").val(res[0].status);

                    var sstatus = '-';
                    if (res[0].status === 'C'){
                        sstatus = 'CLOSED';
                    } else {
                        sstatus = 'OPEN';
                    }
                    $("[data-id=status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text(sstatus);
                    $("#description").val(res[0].description);

                    ustatus = res[0].status;
                    udescription = res[0].description;

                    var sdatadate = new Date(res[0].rec_date);
                    var sddate = datadate.getFullYear() + "/" + appendLeadingZeroes(datadate.getMonth() + 1) + "/" + appendLeadingZeroes(datadate.getDate());
                    urecdate = sddate;
                }
            });

            $("#hiddenuseradminid").val(ddate);

            $("#add-user").removeClass("d-none");
            $("#add-user").addClass("d-block");
            $("#main-user").removeClass("d-block");
            $("#main-user").addClass("d-none");
            $("#savegroupbutton").addClass('d-none');
            $("#savegroupbutton").removeClass('d-block');
            $("#editgroupbutton").removeClass('d-none');
            $("#editgroupbutton").addClass('d-block');
            clearCache();
        }

        function deleteUser(data){
            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonClass: "btn-default",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnCancel: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('marketholiday-delete/submit') }}",
                            data: {
                                'id': data,
                            },
                            success: function (res) {
                                console.log('--> '+res.rec_date);
                                var vdatadate = new Date(res.rec_date);
                                var vdate = vdatadate.getFullYear() + "-" + appendLeadingZeroes(vdatadate.getMonth() + 1) + "-" + appendLeadingZeroes(vdatadate.getDate());
                                swal({
                                    title: getDateBipsShort(vdate),
                                    text: "Has Deleted",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-success',
                                    confirmButtonText: 'OK'
                                }, function () {
                                    $('#table-marketholiday').DataTable().ajax.reload();
                                });
                            }
                        });
                    }
                }
            )
        }

        $("#canceledituser").on("click", function () {
            var descN = $("#description").val();
            var recdateN = $("#tgl_rec_date").val();
            var statusN = $("#status").val();

            console.log(recdateN,' ',urecdate);
            console.log(descN,' ',udescription);
            console.log(statusN,' ',ustatus);

            if (udescription === descN && urecdate === recdateN && ustatus === statusN) {
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

        function cancelEdit(){
            $("#breadAdditional").removeClass("d-block").addClass("d-none").text('');
            $("#breadAdditionalText").removeClass("d-block").addClass("d-none").text('');
            $("#add-user").removeClass("d-block");
            $("#add-user").addClass("d-none");
            $("#main-user").removeClass("d-none");
            $("#main-user").addClass("d-block");

            clearVariable();
        }

        function chgDate() {
            var recdate = new Date($("#rec_date").val());
            var rdate = recdate.getFullYear() + "/" + appendLeadingZeroes(recdate.getMonth() + 1) + "/" + appendLeadingZeroes(recdate.getDate());

            $("#tgl_rec_date").val(rdate);
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
                        <li class="breadcrumb-item active"><i class="@foreach($clapps as $p) {{ $p->cla_icon }} @endforeach" style="color: #8898aa!important;"></i> @foreach($clapps as $p) {{ $p->cla_name }} @endforeach</li>
                        <li class="breadcrumb-item active" aria-current="page"> @foreach($clmodule as $p) {{ $p->clm_name }} @endforeach</li>
                        <li id="breadAdditional" class="breadcrumb-item active d-none" aria-current="page"></li>
                        <li id="breadAdditionalText" class="breadcrumb-item active d-none" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow" id="main-user">
        <div class="card card-header">
            <form class="form-inline">
                <label class="form-control-label pr-5 mb-2">Filter by :</label>
                <div class="ml-input-2 input-daterange input-group" id="datepicker-range-year">
                    <input type="text" class="form-control" name="start" id="tgl_awal_current" readonly value="{{ $startmonth }}" onchange="datetableSummary(1);">
                    <div class="input-group-prepend">
                        <span class="input-group-text">To</span>
                    </div>
                    <input type="text" class="form-control" name="end" id="tgl_akhir_current" readonly value="{{ $thismonth }}" onchange="datetableSummary(1);">
                </div>&nbsp;&nbsp;
                <button class="form-control-btn btn btn-primary mb-1" type="button" id="btn-current" onclick="datetableSummary(1);">Refresh</button>
                <input value="{{ $startmonth }}" type="hidden" id="tgl_awal"/>
                <input value="{{ $thismonth }}" type="hidden" id="tgl_akhir"/>
            </form>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-success-registrasi">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="regisuser"></strong>, has registered.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-success-update">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="update_user_notification"></strong>, has updated.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-error-registrasi">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-inner--text">Error Because =>&nbsp;<strong id="messageuser"></strong></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-marketholiday">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>Action</th>
                                        <th>Rec Date</th>
                                        <th>Status</th>
                                        <th>Description</th>
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

    <div class="card shadow d-none" id="add-user">
        <form id="myForm">
            <input type="hidden" id="hiddenuseradminid"/>
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="container-fluid py-2 card d-border-radius-0 mb-2">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Rec Date</label>
                                            <div class="input-daterange input-group" id="datepicker-basic">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="px-3 form-control" name="rec_date" id="rec_date" style="text-align: left!important;" readonly value="{{ $monththis }}" onchange="chgDate();">
                                            </div>
                                            <input value="{{ $monththis }}" type="hidden" id="tgl_rec_date"/>
                                            <label id="cekRecDate" class="error invalid-feedback small d-block col-sm-12 px-0" for="recdate"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Status</label>
                                            <div class="input-group col-sm-12 px-0 lbl-status">
                                                <select class="form-control bootstrap-select w-select-100" disabled data-live-search="true"
                                                        data-style="btn-white" id="status" name="status">
                                                    <option value="" disabled>Choose Status</option>
                                                    <option value="C" selected>CLOSED</option>
                                                    <option value="O">OPEN</option>
                                                </select>
                                            </div>
                                            <label id="cekStatus" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekStatus"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Description</label>
                                            <input type="text" class="form-control col-sm-12" placeholder="Description"
                                                      id="description" name="description"/>
                                            <label id="cekDescription" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekDescription"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer text-right">
                <div class="form-inline justify-content-end" id="savegroupbutton">
                    <button class="form-control-btn btn btn-primary mb-2" type="button" id="saveUser">Save</button>
                    <button class="form-control-btn btn btn-info mb-2" type="button" onclick="resetApp()">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
                <div class="form-inline justify-content-end d-none" id="editgroupbutton">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="updateUser">Update</button>
                    <button class="form-control-btn btn btn-info mb-2" type="reset" id="resetuser">Reset</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceledituser">Cancel</button>
                </div>
            </div>
        </form>
    </div>
@endsection
