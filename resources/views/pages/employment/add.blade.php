@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Nhân viên
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#">Forms</a>
            </li>
            <li class="active">General Elements</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Thêm mới
                        </h3>
                    </div>
                    <form id="addForm" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Thông tin cá nhân</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Họ tên</label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Họ và tên">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Giới tính</label>
                                        <select id="gender" name="gender" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Thông tin nhân viên</label>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Loại công việc</label>
                                        <select id="type" name="type" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phòng ban</label>
                                        <select id="department_id" name="department_id" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <div class="form-group">
                                        <label>Cấp bậc</label>
                                        <select id="position_id" name="position_id" class="form-control">
                                        </select>
                                        <select name="office_id" class="form-control" style="display: none">
                                            <option value="1" selected></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Chức vụ</label>
                                        <input type="text" name="job_title" class="form-control" placeholder="Chức vụ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        var urlDepartment = "{{url('api/employment')}}";
        $(function () {
            $('#addForm').submit(function (event) {
                event.preventDefault();
                var $form = $(this);
                var _method = 'post';
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
                        $form[0].reset();
                        $tableData.ajax.reload();
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
        getDepartments(function (data) {
            var $mySelect = $('#department_id');
            var str;
            $.each(data.data, function (i, item) {
                str += "<option value='" + item.id + "'> " + item.name + "</option>";
            });
            $mySelect.html(str);
        });
        getGender(function (data) {
            var $mySelect = $('#gender');
            var str;
            $.each(data.data, function (i, item) {
                str += "<option value='" + item.id + "'> " + item.name + "</option>";
            });
            $mySelect.html(str);
        });
        getType(function (data) {
            var $mySelect = $('#type');
            var str;
            $.each(data.data, function (i, item) {
                str += "<option value='" + item.id + "'> " + item.name + "</option>";
            });
            $mySelect.html(str);
        });
        getPosition(function (data) {
            console.log(data);
            var $mySelect = $('#position_id');
            var str;
            $.each(data.data, function (i, item) {
                str += "<option value='" + item.id + "'> " + item.name + "</option>";
            });
            $mySelect.html(str);
        })
    </script>
@endpush
