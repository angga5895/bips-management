@extends('layouts.app-argon')

@section('js')
    <script>
        var rulesobj = {
            "user_name" : {
                required : true
            },
            "email_address" : {
                required : true,
                email : true
            },
            "msidn" : {
                required : true
            },
            "user_status" : {
                required : true
            }
        };

        var messagesobj = {
            "user_name" : "Field is required.",
            "email_address" : {
                required : "Field is required.",
                email : "Field must be a valid email address."
            },
            "msidn" : "Field is required.",
            "user_status" : "Please pick an user status.",
        };

        $(function () {
            var $form = $('#myFormUpdate');
            $form.validate({
                rules: rulesobj,
                messages: messagesobj,
                debug: false,
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback offset-label-error-user');
                    element.closest('.form-group').append(error);
                    $(element).addClass('is-invalid');
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');

                    if (element.id === 'user_status'){
                        $(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    if (element.id === 'user_status'){
                        $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                    }
                }
            });

            $form.find("#saveuser").on('click', function () {
                if ($form.valid()) {
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
                                saveUser();
                            }
                        }
                    );
                } else {
                    $('.lbl-group').removeClass('focused');
                }
                return false;
            });

            $form.keypress(function(e) {
                if(e.which == 13) {
                    $("#saveuser").click();
                }
            });
        });

        $(document).ready(function () {
            $('.bootstrap-select').selectpicker();
            $(".readonly").on('keydown paste mousedown mouseup drop', function(e){
                e.preventDefault();
            });
        });

        function checking(these) {
            if ($(these).val() !== ''){
                var str = $(these).attr("id");
                str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });

                $("#cek"+str).text('');

                if (str === 'User_type'){
                    $(".lbl-user-type > .dropdown.bootstrap-select").removeClass("is-invalid");
                }

                if (str === 'User_status'){
                    $("#user_status-error").text('');
                    $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                }
            }
        }

        $("#canceluser").on("click", function () {
            var user_nameN = $("#user_name").val();
            var email_addressN = $("#email_address").val();
            var msidnN = $("#msidn").val();
            var user_statusN = $("#user_status").val();

            var user_name = $("#h_user_name").val();
            var email_address = $("#h_email_address").val();
            var msidn = $("#h_msidn").val();
            var user_status = $("#h_user_status").val();

            if (user_name === user_nameN && email_address === email_addressN &&
                msidn === msidnN && user_status === user_statusN) {
                window.location.href="{{ route('useradmin.user') }}"
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
                            window.location.href="{{ route('useradmin.user') }}"
                        }
                    }
                )
            }
        });

        function saveUser() {
            var user_name = $("#user_name").val();
            var email_address = $("#email_address").val();
            var msidn = $("#msidn").val();
            var user_status = $("#user_status").val();

            $.get("/mockjax");

            $.ajax({
                type: "GET",
                url: "{{ url('username-update') }}",
                data: {
                    'user_id' : "@foreach($userbips as $p){{ $p->user_id }}@endforeach",
                    'user_name' : user_name,
                    'email_address' : email_address,
                    'msidn' : msidn,
                    'user_status' : user_status,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            swal({
                                title: res.user,
                                text: "Has Updated",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: 'btn-success',
                                confirmButtonText: 'OK'
                            }, function () {
                                window.location.href = "{{ route('useradmin.user') }}";
                            });
                        } else {
                            swal({
                                title: res.user,
                                text: res.message,
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonClass: 'btn-danger',
                                confirmButtonText: 'OK'
                            }, function () {
                                window.location.href = "{{ route('useradmin.user') }}";
                            });
                        }
                    }
                }
            });
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
                        <li class="breadcrumb-item active">User</li>
                        <li class="breadcrumb-item active">Edit</li>
                        @foreach($userbips as $p)
                            <li class="breadcrumb-item active" aria-current="page">{{ $p->user_name }}</li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        <hr class="mt-0 bg-white mb-2">
    </div>

    <div class="card shadow">
        <form id="myFormUpdate">
            <div class="card card-body" style="min-height: 365px">
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            @foreach($userbips as $p)
                                <div class="container-fluid py-2 card d-border-radius-0 mb-2">

                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Type</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <div class="input-group col-sm-12 px-0">
                                                        <select class="form-control bootstrap-select w-select-100" data-live-search="true" data-style="btn-white" id="user_type" disabled>
                                                            <option value="" disabled selected>Choose User Type</option>
                                                            @foreach($usertype as $r)
                                                                <option @if($p->user_type === $r->id) selected="selected" @endif value={{ $r->id }}>{{ $r->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label id="cekUser_type" class="error invalid-feedback small d-block col-sm-12 px-0" for="cekUser_type"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User ID</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12 readonly" type="text" placeholder="User ID" readonly id="userID" value="{{ $p->user_id }}"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Name</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="text" placeholder="User Name" id="user_name" name="user_name" value="{{ $p->user_name }}" onchange="checking(this)" />
                                                    <input type="hidden" id="h_user_name" value="{{ $p->user_name }}"/>
                                                    <label id="cekUser_name" class="error invalid-feedback small d-block col-sm-12 px-0" for="user_name"></label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Email</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="email" placeholder="Email"
                                                           id="email_address" name="email_address" value="{{ $p->email_address }}" onchange="checking(this)"
                                                    />
                                                    <input type="hidden" id="h_email_address" value="{{ $p->email_address }}"/>
                                                    <label id="cekEmail_address" class="error invalid-feedback small d-block col-sm-12 px-0" for="email_address"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">MSIDN</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="text" placeholder="MSIDN"
                                                           id="msidn" name="msidn" value="{{ $p->msidn }}" onchange="checking(this)"
                                                    />
                                                    <input type="hidden" id="h_msidn" value="{{ $p->msidn }}"/>
                                                    <label id="cekMsidn" class="error invalid-feedback small d-block col-sm-12 px-0" for="msidn"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Status</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <div class="input-group col-sm-12 px-0">
                                                        <select class="form-control bootstrap-select" data-live-search="true"
                                                                data-style="btn-white" id="user_status" onchange="checking(this)"
                                                        >
                                                            <option value="" disabled>Choose User Status</option>
                                                            @foreach($userstatus as $r)
                                                                <option @if($p->status === $r->id) selected="selected" @endif value="{{ $r->id }}">{{ $r->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="h_user_status" value="{{ $p->status }}"/>
                                                    <label id="cekUser_status" class="error invalid-feedback small d-block col-sm-4" for="user_status"></label>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="saveuser">Update</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
            </div>
        </form>
    </div>
@endsection
