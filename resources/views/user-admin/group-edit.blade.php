@extends('layouts.app-argon')

@section('js')
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'AOID'
            });
            $('.bootstrap-select').selectpicker();
        });

        function checking() {
            var groupname = $("#groupname").val();

            if(groupname !== ''){$("#cekGroupname").text('');$("#groupname").removeClass("is-invalid");}
        }

        $("#savegroup").on("click", function () {
            var groupname = $("#groupname").val();
            var hgroupname = $("#hgroupname").val();
            var id = $("#addgroupID").val();

            var required = "Field is required.";
            if (groupname !== ''){
                $.get("/mockjax");
                $.ajax({
                    type : "GET",
                    url  : "{{ url('group-update') }}",
                    data : {
                        'group_id' : id,
                        'name' : groupname,
                    },
                    success : function (res) {
                        if ($.trim(res)){
                            if (res.status === "00"){
                                var title = 'Has updated.';
                                var type = 'success';
                                var button = 'btn-success';
                                var text = hgroupname+' replaced by '+res.group;

                                if (res.group === hgroupname){
                                    title = 'Nothing updated.';
                                    type = 'error';
                                    button = 'btn-danger';
                                    text = '';
                                }

                                swal({
                                    title: title,
                                    text: text,
                                    type: type,
                                    showCancelButton: false,
                                    confirmButtonClass: button,
                                    confirmButtonText: 'OK'
                                }, function () {
                                    window.location.href = "{{route('group')}}";
                                });
                            }
                        }
                    }
                });
            } else{
                if(groupname === ''){$("#cekGroupname").text(required);$("#groupname").addClass("is-invalid");$("#groupname").focus();}
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
                        <li class="breadcrumb-item active"><i class="@foreach($clapps as $p) {{ $p->cla_icon }} @endforeach" style="color: #8898aa!important;"></i> @foreach($clapps as $p) {{ $p->cla_name }} @endforeach</li>
                        <li class="breadcrumb-item active" aria-current="page"> @foreach($clmodule as $p) {{ $p->clm_name }} @endforeach</li>
                        <li class="breadcrumb-item active">Edit</li>
                        @foreach($group as $p)
                            <li class="breadcrumb-item active" aria-current="page">{{ $p->name }}</li>
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
                            @foreach($group as $p)
                                <div class="container-fluid py-2 card d-border-radius-0 mb-2">
                                    <div class="form-group form-inline">
                                        <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer Group ID</label>
                                        <input class="form-control col-sm-6" type="text" readonly id="addgroupID" value="{{ $p->group_id }}"/>
                                    </div>
                                    <div class="form-group form-inline">
                                        <label class="form-control-label form-inline-label col-sm-2 mb-2 px-0">Dealer Group Name</label>
                                        <input class="form-control col-sm-6" type="text" placeholder="Please Input" required id="groupname" value="{{ $p->name }}" onchange="checking();"/>
                                        <input type="hidden" id="hgroupname" value="{{ $p->name }}"/>
                                        <label id="cekGroupname" class="error invalid-feedback small d-block col-sm-4" for="groupname"></label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
            <div class="card card-footer">
                <div class="form-inline justify-content-end">
                    <button class="form-control-btn btn btn-success mb-2" type="button" id="savegroup">Update</button>
                    <a class="form-control-btn btn btn-danger mb-2" type="button" id="cancelgroup" href="{{ route('group') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
