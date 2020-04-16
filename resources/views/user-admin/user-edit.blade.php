@extends('layouts.app-argon')

@section('js')
    <script>
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
                    $(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");
                }
            }
        }

        function checkCache(){
            var user_name = $("#user_name");
            var email_address = $("#email_address");
            var msidn = $("#msidn");
            var user_status = $("#user_status");

            //lbl
            var cekUser_name = $("#cekUser_name");
            var cekEmail_address = $("#cekEmail_address");
            var cekMsidn = $("#cekMsidn");
            var cekUser_status = $("#cekUser_status");

            if(!user_status[0].checkValidity()){cekUser_status.text(user_status[0].validationMessage);$(".lbl-user-status > .dropdown.bootstrap-select").addClass("is-invalid");user_status.focus();}
            else {cekUser_status.text('');$(".lbl-user-status > .dropdown.bootstrap-select").removeClass("is-invalid");}

            if(!user_name[0].checkValidity()){cekUser_name.text(user_name[0].validationMessage);user_name.addClass("is-invalid");user_name.focus();}
            else {cekUser_name.text('');user_name.removeClass("is-invalid");}

            if(!email_address[0].checkValidity()){cekEmail_address.text(email_address[0].validationMessage);email_address.addClass("is-invalid");email_address.focus();}
            else {cekEmail_address.text('');email_address.removeClass("is-invalid");}

            if(!msidn[0].checkValidity()){cekMsidn.text(msidn[0].validationMessage);msidn.addClass("is-invalid");msidn.focus();}
            else {cekMsidn.text('');msidn.removeClass("is-invalid");}
        }

        $("#canceluser").on("click", function () {
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
                        window.location.href="{{ route('useradmin.user') }}"
                    }
                }
            );
        });

        $("#saveuser").on("click", function () {
            var user_name = $("#user_name").val();
            var email_address = $("#email_address").val();
            var msidn = $("#msidn").val();
            var user_status = $("#user_status").val();


            var username = $("#user_name");
            var emailaddress = $("#email_address");
            var msidn_no = $("#msidn");
            var userstatus = $("#user_status");

            if (username[0].checkValidity() && msidn_no[0].checkValidity()
                && userstatus[0].checkValidity() && emailaddress[0].checkValidity()
            ){
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
            } else {
                checkCache();
            }
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
        <form>
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
                                            <div class="form-group form-inline">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Type</label>
                                                <div class="col-sm-9 pr-0 row" id="useridCDS">
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
                                                <div class="col-sm-9 pr-0 d-none row" id="useridT">
                                                    <input class="form-control col-sm-12" type="text" placeholder="User ID" id="client_id_t" onchange="checking(this)" required
                                                           oninvalid="this.setCustomValidity('Field is required')"
                                                    />
                                                    <label id="cekClient_id_t" class="error invalid-feedback small col-sm-12 px-0" for="client_id_t"></label>
                                                </div>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User ID</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12 readonly" type="text" placeholder="User ID" readonly id="userID" value="{{ $p->user_id }}"
                                                           oninvalid="this.setCustomValidity('Field is required')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">User Name</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="text" placeholder="User Name" id="user_name" value="{{ $p->user_name }}" onchange="checking(this)" required
                                                           oninvalid="this.setCustomValidity('Field is required')"
                                                    />
                                                    <label id="cekUser_name" class="error invalid-feedback small d-block col-sm-12 px-0" for="user_name"></label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Email</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="email" placeholder="Email"
                                                           id="email_address" value="{{ $p->email_address }}" onchange="checking(this)" required
                                                           oninvalid="this.setCustomValidity('Field is required')"
                                                    />
                                                    <label id="cekEmail_address" class="error invalid-feedback small d-block col-sm-12 px-0" for="email_address"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">MSIDN</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <input class="form-control col-sm-12" type="text" placeholder="MSIDN"
                                                           id="msidn" value="{{ $p->msidn }}" onchange="checking(this)" required
                                                           oninvalid="this.setCustomValidity('Field is required')"
                                                    />
                                                    <label id="cekMsidn" class="error invalid-feedback small d-block col-sm-12 px-0" for="msidn"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline lbl-group">
                                                <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Status</label>
                                                <div class="col-sm-9 pr-0 row">
                                                    <div class="input-group col-sm-12 px-0">
                                                        <select class="form-control bootstrap-select" data-live-search="true"
                                                                data-style="btn-white" id="user_status" onchange="checking(this)"
                                                                oninvalid="this.setCustomValidity('Status can not be null')"
                                                        >
                                                            <option value="" disabled>Choose User Status</option>
                                                            @foreach($userstatus as $r)
                                                                <option @if($p->status === $r->id) selected="selected" @endif value="{{ $r->id }}">{{ $r->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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
