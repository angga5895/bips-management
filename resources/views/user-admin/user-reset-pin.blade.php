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
            var email_address = $("#email_address");
            var cekEmail_address = $("#cekEmail_address");
            if(!email_address[0].checkValidity()){cekEmail_address.text(email_address[0].validationMessage);email_address.addClass("is-invalid");email_address.focus();}
            else {cekEmail_address.text('');email_address.removeClass("is-invalid");}
        }

        $("#canceluser").on("click", function () {
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href="{{ route('useradmin.user') }}"
                    }
                }
            );
        });

        $("#saveuser").on("click", function () {
            userid = $("#resetUserID").val();
            $.ajax({
                type: "GET",
                url: "{{ url('pin_reset/') }}",
                data: {
                    'userID': userid,
                },
                success: function (res) {
                    if ($.trim(res)) {
                        if (res.status === "00") {
                            swal({
                                title: "Email Sent",
                                text: "Check email for the new password",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: 'btn-success',
                                confirmButtonText: 'OK'
                            }, function () {
                                window.location.href = "{{ route('useradmin.user') }}";
                            });
                        } else {
                            swal({
                                title: "Email Not Sent",
                                text: res.message,
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonClass: 'btn-danger',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                }
            });
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
                        <li class="breadcrumb-item active">Reset PIN</li>
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
                                <input type="hidden" value="{{$p->user_id}}" id="resetUserID">

                                <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                    <div class="form-group form-inline lbl-group">
                                        <label class="form-control-label form-inline-label col-sm-3 mb-2 px-0">Email</label>
                                        <div class="col-sm-9 pr-0 row">
                                            <input class="form-control col-sm-12 readonly" type="email" placeholder="Email" id="email_address" value="{{ $p->email_address }}" onchange="checking(this)" required readonly/>
                                            <label id="cekEmail_address" class="error invalid-feedback small d-block col-sm-12 px-0" for="email_address"></label>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <span class="alert-inner--text">
                                                Note ::
                                                <br/>
                                                <strong>
                                                    The user's new pin will be sent via email. New pins are randomly sent and confidential without the admin knowing.
                                                </strong>
                                            </span>
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
                    <button class="form-control-btn btn btn-info mb-2" type="button" id="saveuser">Reset PIN</button>
                    <button class="form-control-btn btn btn-danger mb-2" type="button" id="canceluser">Cancel</button>
                </div>
            </div>
        </form>
    </div>
@endsection
