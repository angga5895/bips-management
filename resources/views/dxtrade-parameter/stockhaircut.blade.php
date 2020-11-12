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
    <script src="{{ url('inputmask/dist/jquery.inputmask.js') }}"></script>
    <script type="text/javascript">
        var ustockcode = '';
        var uhaircut = '';
        var uhaircutcomite = '';
        var uhc1 = '';
        var uhc2 = '';
        var constockdate = 0;

        var rulesobj = {
            "stockcode" : {
                required : true
            },
            "haircut" : {
                required : true
            },
            "haircutcomite" : {
                required : true
            },
            "hc1" : {
                required : true
            },
            "hc2" : {
                required : true
            }
        }

        var messagesobj = {
            "stockcode" : "Field is required.",
            "haircut" : "Field is required.",
            "haircutcomite" : "Field is required.",
            "hc1" : "Field is required.",
            "hc2" : "Field is required."
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
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $form.find("#saveUser").on('click', function () {
                if ($form.valid()) {
                    var data = $("#stockcode").val().toUpperCase();
                    $.ajax({
                        type : "GET",
                        url  : "{{ url('stockhaircutcode-check') }}",
                        data : {
                            'stockcode' : data,
                        },
                        success : function (res) {
                            if (res.status === "01"){
                                $("#stockcode").val('');
                                $("#stockcode").valid();
                                $(".lbl-group").removeClass('focused');

                                constockdate = 1;
                            } else {
                                constockdate = 0;
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
            var stockcode = $("#stockcode").val().toUpperCase();
            var haircut = parseFloat($("#haircut").val().replace(/,/g, ''));
            var haircutcomite = parseFloat($("#haircutcomite").val().replace(/,/g, ''));
            var hc1 = parseFloat($("#hc1").val().replace(/,/g, ''));
            var hc2 = parseFloat($("#hc2").val().replace(/,/g, ''));

            $.get("/mockjax");

            $.ajax({
                type : "GET",
                url  : "{{ url('stockhaircut-registrasi') }}",
                data : {
                    'stockcode':stockcode,
                    'haircut':haircut,
                    'haircutcomite':haircutcomite,
                    'hc1':hc1,
                    'hc2':hc2
                },
                success : function (res) {
                    if ($.trim(res)){
                        $("#breadAdditional").addClass("d-none"); $("#breadAdditional").removeClass("d-block");$("#breadAdditional").text("");
                        if (res.status === "00"){
                            $('#table-stockhaircut').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#regisuser").text(res.stock_code);
                            $("#alert-success-registrasi").removeClass("d-none");
                            $("#alert-success-registrasi").addClass("d-block");
                            $("#alert-error-registrasi").removeClass("d-block");
                            $("#alert-error-registrasi").addClass("d-none");

                            clearVariable();
                        } else {
                            $('#table-stockhaircut').DataTable().ajax.reload();
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
                            var stockcode = $("#stockcode").val().toUpperCase();
                            var stockcodeN = $("#hiddenuseradminid").val();

                            if (stockcode !== stockcodeN){
                                $.ajax({
                                    type : "GET",
                                    url  : "{{ url('stockhaircutcode-check') }}",
                                    data : {
                                        'stockcode' : stockcode,
                                    },
                                    success : function (res) {
                                        if (res.status === "01"){
                                            $("#stockcode").val('');
                                            $("#stockcode").valid();
                                            $(".lbl-group").removeClass('focused');

                                            constockdate = 1;
                                        } else {
                                            constockdate = 0;
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
            var stockcode = $("#stockcode").val().toUpperCase();
            var haircut = parseFloat($("#haircut").val().replace(/,/g, ''));
            var haircutcomite = parseFloat($("#haircutcomite").val().replace(/,/g, ''));
            var hc1 = parseFloat($("#hc1").val().replace(/,/g, ''));
            var hc2 = parseFloat($("#hc2").val().replace(/,/g, ''));

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('stockhaircut-update/submit') }}",
                data: {
                    'id': id,
                    'stockcode':stockcode,
                    'haircut':haircut,
                    'haircutcomite':haircutcomite,
                    'hc1':hc1,
                    'hc2':hc2
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            $('#table-stockhaircut').DataTable().ajax.reload();
                            $("#add-user").removeClass("d-block");
                            $("#add-user").addClass("d-none");
                            $("#main-user").removeClass("d-none");
                            $("#main-user").addClass("d-block");
                            $("#update_user_notification").text(res.stock_code);
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
            ustockcode = '';
            uhaircut = '';
            uhaircutcomite = '';
            uhc1 = '';
            uhc2 = '';
        }

        $(document).ready(function () {
            $(".input-mask-decimal").inputmask({
                'alias': 'decimal',
                rightAlign: false,
                'groupSeparator': '.',
                'autoGroup': true
            });

            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();

            setInterval(function () {
                if(constockdate > 0){
                    $('#stockcode-error').text('Stock code already exist.');
                }
            },100);

            tablegetStockHaircut();
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function exportExcel() {
            $.ajax({
                type    : "GET",
                url     : "{{url('/export-stockhaircut/submit')}}",
                complete : function (){
                    //window.open(this.url, '_blank');
                    window.location = this.url;
                    console.log('Export Excel Success..');
                }
            });
        }


        function tablegetStockHaircut() {
            var tableData = $("#table-stockhaircut").DataTable({
                /*processing: true,
                serverSide: true,*/
                responsive: true,
                aaSorting: [[1, 'asc']],
                bFilter: false,
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button class="form-control-btn-0 btn btn-primary mb-2" type="button" id="adduser" onclick="addUser()">Add</button>' +
                        '<button type="button" class="form-control-btn-0 btn btn-outline-default mb-2" data-toggle="modal" data-target="#importExcel">' +
                        '<i style="color: #00b862" class="fa fa-file-excel"></i> Import Excel' +
                        '</button>' +
                        '<button class="form-control-btn-0 btn btn-outline-default mb-2" type="button" onclick="exportExcel()">' +
                        '<i style="color: #00b862" class="fa fa-file-excel"></i> Export Excel</button>');
                },
                ajax : {
                    url: '{{ url("datastockhaircut-get") }}',
                    data: function (d) {
                        var search_data = {
                            stock_code: $("#stock_code").val()
                        };
                        d.search_param = search_data;
                    }
                },
                columns : [
                    {data : 'stock_code', name: 'stock_code'},
                    {data : 'stock_code', name: 'stock_code'},
                    {data : 'haircut', name: 'haircut'},
                    {data : 'haircut_comite', name: 'haircut_comite'},
                    {data : 'hc1', name: 'hc1'},
                    {data : 'hc2', name: 'hc2'},
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
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : data;
                    }
                },{
                    targets : [2],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(Number(data))+'</div>';
                    }
                },{
                    targets : [3],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(Number(data))+'</div>';
                    }
                },{
                    targets : [4],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(Number(data))+'</div>';
                    }
                },{
                    targets : [5],
                    searchable : true,
                    orderable : true,
                    render : function (data, type, row) {
                        return data === '' || data === null ? '<div style="text-align: center; font-weight: bold">-</div>' : '<div style="text-align: right;">'+numberWithCommas(Number(data))+'</div>';
                    }
                }]
            });
        }

        function tableRefresh() {
            $('#table-stockhaircut').DataTable().ajax.reload();
        }

        function allRefresh() {
            $("#stock_code").val('');
            $('#table-stockhaircut').DataTable().ajax.reload();
        }

        function addUser() {
            /*$("[id=status]").val('');
            $("[data-id=status] > .filter-option > .filter-option-inner > .filter-option-inner-inner").text('Choose Status');*/
            $("#stockcode").val('');
            $("#haircut").val('');
            $("#haircutcomite").val('');
            $("#hc1").val('');
            $("#hc2").val('');
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
            constockdate = 0;
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

            $("#stockcode-error").text('');
            $("#haircut-error").text('');
            $("#haircutcomite-error").text('');
            $("#hc1-error").text('');
            $("#hc2-error").text('');

            $("#stockcode").removeClass("is-invalid");
            $("#haircut").removeClass("is-invalid");
            $("#haircutcomite").removeClass("is-invalid");
            $("#hc1").removeClass("is-invalid");
            $("#hc2").removeClass("is-invalid");

            $("#cekStockcode").text('');
            $("#cekHaircut").text('');
            $("#cekHaircutcomite").text('');
            $("#cekHC1").text('');
            $("#cekHC2").text('');
        }

        $("#canceluser").on("click", function () {
            var stockcode = $("#stock_code").val();
            var haircut = parseFloat($("#haircut").val().replace(/,/g, ''));
            var haircutcomite = parseFloat($("#haircutcomite").val().replace(/,/g, ''));
            var hc1 = parseFloat($("#hc1").val().replace(/,/g, ''));
            var hc2 = parseFloat($("#hc2").val().replace(/,/g, ''));

            var res = stockcode+haircut+haircutcomite+hc1+hc2;
            res = res.trim();
            if(res.length > 0) {
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
            $("#stockcode").val('');
            $("#haircut").val('');
            $("#haircutcomite").val('');
            $("#hc1").val('');
            $("#hc2").val('');
            clearCache();
        }

        $("#resetuser").on('click', function(){
            cacheError();
            var data = $("#hiddenuseradminid").val();

            $.ajax({
                type : "GET",
                url  : "{{ url('stockhaircut-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    var stockcode = res[0].stock_code;
                    var haircut = res[0].haircut;
                    var haircutcomite = res[0].haircut_comite;
                    var hc1 = res[0].hc1;
                    var hc2 = res[0].hc2;

                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(stockcode);
                    $("#hiddenuseradminid").val(stockcode);


                    $("#stockcode").val(stockcode);
                    $("#haircut").val(Number(haircut));
                    $("#haircutcomite").val(Number(haircutcomite));
                    $("#hc1").val(Number(hc1));
                    $("#hc2").val(Number(hc2));
                }
            });
        });

        function editUser(data){
            $.ajax({
                type : "GET",
                url  : "{{ url('stockhaircut-update/') }}",
                data : {
                    'id' : data,
                },
                success : function (res) {
                    // console.log(res.name);
                    var stockcode = res[0].stock_code;
                    var haircut = res[0].haircut;
                    var haircutcomite = res[0].haircut_comite;
                    var hc1 = res[0].hc1;
                    var hc2 = res[0].hc2;

                    $("#breadAdditional").removeClass("d-none").addClass("d-block").text("Edit");
                    $("#breadAdditionalText").removeClass("d-none").addClass("d-block").text(stockcode);
                    $("#hiddenuseradminid").val(stockcode);

                    $("#stockcode").val(stockcode);
                    $("#haircut").val(Number(haircut));
                    $("#haircutcomite").val(Number(haircutcomite));
                    $("#hc1").val(Number(hc1));
                    $("#hc2").val(Number(hc2));

                    ustockcode = stockcode;
                    uhaircut = Number(haircut);
                    uhaircutcomite = Number(haircutcomite);
                    uhc1 = Number(hc1);
                    uhc2 = Number(hc2);
                }
            });

            $("#hiddenuseradminid").val(data);

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
                            url: "{{ url('stockhaircut-delete/submit') }}",
                            data: {
                                'id': data,
                            },
                            success: function (res) {
                                var vdata = res.stock_code;
                                swal({
                                    title: vdata,
                                    text: "Has Deleted",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn-success',
                                    confirmButtonText: 'OK'
                                }, function () {
                                    $('#table-stockhaircut').DataTable().ajax.reload();
                                });
                            }
                        });
                    }
                }
            )
        }

        $("#canceledituser").on("click", function () {
            var stockcodeN = $("#stockcode").val().toUpperCase();
            var haircutN = parseFloat($("#haircut").val().replace(/,/g, ''));
            var haircutcomiteN = parseFloat($("#haircutcomite").val().replace(/,/g, ''));
            var hc1N = parseFloat($("#hc1").val().replace(/,/g, ''));
            var hc2N = parseFloat($("#hc2").val().replace(/,/g, ''));

            console.log(stockcodeN,' ',ustockcode);
            console.log(haircutN,' ',uhaircut);
            console.log(haircutcomiteN,' ',uhaircutcomite);
            console.log(hc1N,' ',uhc1);
            console.log(hc2N,' ',uhc2);

            if (ustockcode === stockcodeN && uhaircut === haircutN && uhaircutcomite === haircutcomiteN
                && uhc1 === hc1N && uhc2 === hc2N) {
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

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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
            <div class="form-inline">
                <label class="form-control-label pr-5 mb-2">Filter by :</label>
                <div class="ml-input-2 input-group">
                    <input type="text" class="form-control" id="stock_code" style="text-transform: uppercase;" onchange="tableRefresh();">
                </div>&nbsp;&nbsp;
                <button class="form-control-btn btn btn-default mb-1" type="button" id="btn-current" onclick="allRefresh();">All Data</button>
            </div>
        </div>
        <div class="card card-body" style="min-height: 365px">
            <div class="d-none" id="alert-success-registrasi">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="regisuser" style="text-transform:uppercase"></strong>, has registered.</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-none" id="alert-success-update">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong id="update_user_notification" style="text-transform:uppercase"></strong>, has updated.</span>
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

            {{-- notifikasi form validasi --}}
            @if ($errors->has('file'))
                <div>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-inner--text">Error Because =>&nbsp;<strong>{{ $errors->first('file') }}</strong></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            {{-- notifikasi sukses --}}
            @if ($sukses = Session::get('importsuccess'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $sukses }}</strong>
                </div>
            @endif

            {{-- notifikasi error --}}
            @if ($error = Session::get('importerror'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $error }}</strong>
                </div>
            @endif
            <section class="content">

                <!-- Default box -->
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-stockhaircut">
                                    <thead class="bg-gradient-primary text-lighter">
                                    <tr>
                                        <th>Action</th>
                                        <th>Stock Code</th>
                                        <th>Haircut</th>
                                        <th>Haircut Comite</th>
                                        <th>HC1</th>
                                        <th>HC2</th>
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
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Stock Code</label>
                                            <input type="text" class="form-control col-sm-12" placeholder="Stock Code"
                                                   id="stockcode" name="stockcode" style="text-transform:uppercase;"/>
                                            <label id="cekStockcode" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekStockcode"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Haircut</label>
                                            <input type="text" class="form-control col-sm-12 input-mask-decimal" placeholder="Haircut"
                                                   id="haircut" name="haircut"/>
                                            <label id="cekHaircut" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekHaircut"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">Haircut Comite</label>
                                            <input type="text" class="form-control col-sm-12 input-mask-decimal" placeholder="Haircut Comite"
                                                   id="haircutcomite" name="haircutcomite"/>
                                            <label id="cekHaircutcomite" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekHaircutcomite"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">HC1</label>
                                            <input type="text" class="form-control col-sm-12 input-mask-decimal" placeholder="HC1"
                                                   id="hc1" name="hc1"/>
                                            <label id="cekHC1" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekHC1"></label>
                                        </div>
                                        <div class="form-group lbl-group">
                                            <label class="form-control-label col-sm-3 mb-2 px-0">HC2</label>
                                            <input type="text" class="form-control col-sm-12 input-mask-decimal" placeholder="HC2"
                                                   id="hc2" name="hc2"/>
                                            <label id="cekHC2" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekHC2"></label>
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
    <!-- Import Excel -->
    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ url('/import-stockhaircut/submit') }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel Data Stock Haircut</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Choose file excel</label>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="file" required="required">
                            <label class="custom-file-label" for="customFile"
                                  style="white-space: nowrap;
                                  width: 100%;
                                  overflow: hidden;
                                  text-overflow: ellipsis;"
                            >Choose file excel</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
