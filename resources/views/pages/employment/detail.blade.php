@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhân Viên
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#">Examples</a>
            </li>
            <li class="active">User profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.modal -->
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{url('public/images/noavatar.gif')}}" alt="User profile picture">
                        <h3 id="full_name" class="profile-username text-center">...</h3>
                        <p id="job_title" class="text-muted text-center">...</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="height: 80px;">
                                <b>Email</b>
                                <a id="email" class="pull-right">...</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b>
                                <a id="phone" class="pull-right">...</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phòng ban</b>
                                <a id="department_id" class="pull-right">...</a>
                            </li>
                            <li class="list-group-item">
                                <b>Địa chỉ</b>
                                <a id="normal_address" class="pull-right">...</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#syll" data-toggle="tab">Sơ yêu lý lịch</a>
                        </li>
                        <li>
                            <a href="#tk" data-toggle="tab">Tài khoản ngân hàng</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="syll">
                            <div class="row">
                                <div class="col-md-2">
                                    <ul class="nav nav-tabs btn-group-vertical" style="border-bottom: none !important;">
                                        <li role="presentation" class="active col-lg-12">
                                            <a href="#cn" aria-controls="cn" role="tab" data-toggle="tab" class="btn btn-default btn-app no-margin" style="border-bottom: none">
                                                <i class="fa fa-user"></i>
                                                Cá nhân
                                            </a>
                                        </li>
                                        <li role="presentation" class="col-lg-12">
                                            <a href="#ll" aria-controls="ll" role="tab" data-toggle="tab" class="btn btn-default btn-app no-margin" style="border-bottom: none">
                                                <i class="fa fa-home"></i>
                                                Liên lạc
                                            </a>
                                        </li>
                                        <li role="presentation" class="col-lg-12">
                                            <a href="#cm" aria-controls="cm" role="tab" data-toggle="tab" class="btn btn-default btn-app no-margin" style="border-bottom: none">
                                                <i class="fa fa-briefcase"></i>
                                                Chuyên môn
                                            </a>
                                        </li>
                                        <li role="presentation" class="col-lg-12">
                                            <a href="#sk" aria-controls="sk" role="tab" data-toggle="tab" data-toggle="tab" class="btn btn-default btn-app no-margin">
                                                <i class="fa fa-heart"></i>
                                                Sức khỏe
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-10 tab-content">
                                    <div class="active tab-pane" id="cn">
                                        <form class="form-horizontal formUpdate" id="formCN" method="post">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Nơi sinh
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="action" type="hidden" value="personal">
                                                    <input name="id" type="hidden" value="{{$id}}">
                                                    <input name="birth_place" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Quê quán
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="origin_place" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Dân tộc
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="ethnic_group" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Tôn giáo
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="religious" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Địa chỉ
                                                    thường
                                                    trú
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="normal_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Địa chỉ
                                                    tạm trú
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="temporary_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Ngày sinh
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="dob" type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-info pull-right">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="ll">
                                        <form class="form-horizontal formUpdate" id="formLL" method="post">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Mã số
                                                    thuế</label>
                                                <div class="col-sm-9">
                                                    <input name="action" type="hidden" value="contact">
                                                    <input name="id" type="hidden" value="{{$id}}">
                                                    <input name="tax_number" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Số CMND
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="social_number" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Nơi cấp
                                                    CMND
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="social_number_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Ngày cấp
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="social_date_create" type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-info pull-right">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="cm">
                                        <form class="form-horizontal formUpdate" id="formCM" method="post">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Ngoại ngữ
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="action" type="hidden" value="technique">
                                                    <input name="id" type="hidden" value="{{$id}}">
                                                    <input name="foreign_language" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Tin học
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="computer" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Trình độ
                                                    văn hóa
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="education_level" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Trình học
                                                    vấn
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="academic_level" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Trình
                                                    chuyên
                                                    ngành
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="professional" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-info pull-right">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="sk">
                                        <form class="form-horizontal formUpdate" id="formSK" method="post">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Số bảo
                                                    hiểm
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="action" type="hidden" value="health">
                                                    <input name="id" type="hidden" value="{{$id}}">
                                                    <input name="ensurance_number" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Ngày tham
                                                    gia
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="ensurance_date_create" type="date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Địa chỉ
                                                    đăng ký
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="ensurance_address" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Nơi khám
                                                    bệnh
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="ensurance_hospital" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Sức khỏe
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="health" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Cân nặng
                                                    (Kg)
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="weight" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label" style="text-align: left">Chiều cao
                                                    (Cm)
                                                </label>
                                                <div class="col-sm-9">
                                                    <input name="height" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-info pull-right">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tk">
                            <a href="javascript:ShowFormAddBank()" class="btn btn-app">
                                <i class="fa fa-edit"></i> THÊM MỚI
                            </a>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Danh sách tài khoản</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table id="tableData" class="table">
                                        <thead>
                                        <tr>
                                            <th>Tên ngân hàng</th>
                                            <th>Mã số tài khoản</th>
                                            <th>Thơi gian tạo</th>
                                            {{--<th style="width: 100px">Trạng thái</th>--}}
                                            <th></th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>

        </div>
        <!-- /.row -->
        @include('pages.employment.formAddBank')

        @endsection
        @push('stylesheet')
            <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
            <style>
                #tableData_filter input {
                    -webkit-appearance: searchfield !important;
                }

            </style>
        @endpush
        @push('scripts')
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

            <script>
                var urlUserBankAnyData = "{{url('api/UserBank/anyData')}}";
                var $tableData = $('#tableData').DataTable({
                    processing: true,
                    serverSide: true,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Vietnamese.json"
                    },

                    ajax: {
                        url: urlUserBankAnyData,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                        }
                    },
                    order:
                        [[2, 'desc']],
                    bDeferRender: true,
                    columns:
                        [
                            {data: 'name', name: 'name'},
                            {data: 'number', name: 'number'},
                            {data: 'created_at', name: 'created_at'},
                            // {data: 'state', name: 'state'},
                            {data: 'action', name: 'action'}
                        ]
                });
                var urlDepartment = "{{url('api/employment/'.$id)}}";
                $(function () {
                    $('.formUpdate').submit(function (event) {
                        event.preventDefault();
                        var $form = $(this);
                        var _method = 'put';
                        $.ajax({
                            url: urlDepartment,
                            type: _method,
                            data: $form.serialize(),
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                            },
                            success: function (data, textStatus, jQxhr) {
                                console.log(jQxhr);
                                toastr["success"](textStatus);
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                console.log(jqXhr);
                                if (jqXhr.status == 422) {
                                    $.each(jqXhr.responseJSON.error.errors, function (key, value) {
                                        toastr["error"](value);
                                    });
                                }
                                if (jqXhr.status == 403) {
                                    toastr["error"](jqXhr.responseJSON.error.message);
                                }
                            }
                        });
                    });
                });

                getEmployment("{{$id}}", function (data) {
                    $.each(data.data.user, function (i, item) {
                        $('#' + i).text(item);
                    });
                    $.each(data.data.userDetail, function (i, item) {
                        $('#' + i).text(item);
                    });
                    setData(data.data.user);
                    setData(data.data.userDetail);
                    //Convert department id to name
                    getDepartment(data.data.userDetail.department_id, function (data) {
                        $('#department_id').text(data.data.name);
                    })
                });

                function getEmployment(id, handleData) {
                    $.ajax({
                        url: "{{url('api/employment/')}}/" + id,
                        type: 'get',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                        },
                        success: function (data, textStatus, jQxhr) {
                            handleData(data);
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(jqXhr);
                            if (jqXhr.status == 422) {
                                $.each(jqXhr.responseJSON.error.errors, function (key, value) {
                                    toastr["error"](value);
                                });
                            }
                            if (jqXhr.status == 403) {
                                toastr["error"](jqXhr.responseJSON.error.message);
                            }
                        }
                    });
                }

                function getDepartment(id, handleData) {
                    $.ajax({
                        url: "{{url('api/department/')}}/" + id,
                        type: 'get',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                        },
                        success: function (data, textStatus, jQxhr) {
                            handleData(data);
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(jqXhr);
                            if (jqXhr.status == 422) {
                                $.each(jqXhr.responseJSON.error.errors, function (key, value) {
                                    toastr["error"](value);
                                });
                            }
                            if (jqXhr.status == 403) {
                                toastr["error"](jqXhr.responseJSON.error.message);
                            }
                        }
                    });
                }

                //Delete user bank
                function deleteUserBank(id) {

                    swal({
                        title: "Cảnh báo thao tác?",
                        text: "Dữ liệu có thể mất",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) = > {
                        if(willDelete) {
                            $.ajax({
                                url: "{{url('api/UserBank/')}}/" + id,
                                type: 'delete',
                                beforeSend: function (xhr) {
                                    xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                                },
                                success: function (data, textStatus, jQxhr) {
                                    $tableData.ajax.reload();
                                    swal("Dữ liệu đã được xóa", {
                                        icon: "success",
                                    });
                                },
                                error: function (jqXhr, textStatus, errorThrown) {
                                    console.log(jqXhr);
                                    if (jqXhr.status == 422) {
                                        $.each(jqXhr.responseJSON.error.errors, function (key, value) {
                                            toastr["error"](value);
                                        });
                                    }
                                    if (jqXhr.status == 403) {
                                        toastr["error"](jqXhr.responseJSON.error.message);
                                    }
                                }
                            });

                        } else {
                            swal("Dữ liệu đã an toàn!"
                )
                    ;
                }
                })
                    ;
                }


            </script>
    @endpush
