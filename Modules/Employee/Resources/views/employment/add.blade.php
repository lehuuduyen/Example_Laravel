@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> <a href="#">Employee</a></li>
            <li class="active">Add new</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form id="addForm" method="post">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title update">
                            Add new employee
                        </h3>
                    </div>
                        <input type="hidden" id="id" value="<?php echo (isset($_GET['id'])?$_GET['id']:'')?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Full name</label>
                                <input type="text" name="full_name" class="form-control"
                                       placeholder="Họ và tên">
                            </div>
                            <div class="form-group">
                                <label>Phone number</label>
                                <input type="text" name="phone" class="form-control"
                                       placeholder="Số điện thoại">
                            </div>
                            <div class="form-group email">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="password">
                            </div>
                        </div>
                        <div class="box-footer">

                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title update">
                            Permisson for employee
                        </h3>
                    </div>
                    <div class="box-body">
                        <label>
                            Permission list: (<a href="javascript:checkPermissionAll();">Select all</a>)
                        </label>
                        <div id="list-permission">
                            <div class="checkbox del_per" id="check-sample-permission">
                                <label>
                                    <input class="check-permission" type="checkbox" name="permission[]" value="1">
                                    <span>Quyền 1</span>
                                    <code>Mô tả</code>
                                </label>
                            </div>

                        </div>
                        <label>
                            <input class="check-permission" type="checkbox" name="is_email" value="3">
                            <span>Customer</span>
                            <code>It 's Customer</code>
                        </label>
                    </div>
                    <div class="box-footer">

                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title update">
                            Action
                        </h3>
                    </div>
                    <div class="box-body">
                        <button type="submit" id="btn_addForm" class="btn btn-primary pull-right">Add new</button>
                    </div>
                    <div class="box-footer">

                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>

        id= $("#id").val();
        var isCheckAll = false;

        //get thong tin

        var urlDepartment = "{{url('employee')}}";
        $(function () {
            $('#addForm').submit(function (event) {
                event.preventDefault();
                var $form = $(this);
                var _method = 'post';
                var param = '';
                if (id > 0) {
                    var _method = 'put';
                    param = '/' + id;
                }
                $.ajax({
                    url: urlDepartment + param,
                    type: _method,
                    data: $form.serialize(),
                    // beforeSend: function (xhr) {
                    //     xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    // },
                    success: function (data, textStatus, jQxhr) {
                        swalSuccess();

                        $form[0].reset();
                        {{--var id={{Auth::user()->hasRole('superadmin')}};--}}
                        {{--if(id==1 ){--}}
                            {{--window.location.href = '{{url('employee')}}'--}}
                        {{--}--}}
                        {{--else{--}}
                            {{--window.location.href = '{{url('story')}}'--}}

                        {{--}--}}
                            window.location.href = '{{url('employee')}}'

                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(jqXhr);
                        if (jqXhr.status == 422) {
                            $.each(jqXhr.responseJSON.errors, function (key, value) {

                                swalSuccess("Cảnh báo",value[0],"error");

                            });
                        }
                        if (jqXhr.status == 403) {
                            toastr["error"](jqXhr.responseJSON.error.message);
                        }
                    }
                });
            });
        });

        $(document).ready(function () {
            getListPermission();
            if (id > 0) {
                $('.email').css('display','none')
                $(".update").html('Chỉnh sửa')
                $("#btn_addForm").html('Chỉnh sửa')
                $.ajax({
                    url: '{{url('employee/get_id')}}/'+id,
                    type: 'get',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    },
                    success: function (data, textStatus, jQxhr) {
                        var data=data.data;
                        console.log(data);
                        $("input[name=full_name]").val(data.Employment.full_name)

                        $("._hidden").css('display','block');
                        $("input[name=phone]").val(data.Employment.phone)
                        $("input[name=email]").val(data.Employment.email)
//                    $("input[name=gender]").val(data.gender)
//                    $("input[name=department_id]").val(data.department_id)
//                    $("input[name=position_id]").val(data.position_id)
//                    $("input[name=job_title]").val(data.job_title)

                        $("#gender option[value="+data.gender+"]").attr('selected','selected');
                        $("#type option[value="+data.type+"]").attr('selected','selected');
                        $("#department_id option[value="+data.department_id+"]").attr('selected','selected');
                        $("#position_id option[value="+data.position_id+"]").attr('selected','selected');
                        $.each(data.role, function (index, value) {
                            $(":checkbox[value=" + value + "]").prop("checked", true);
                        });
                        $(":checkbox[value=" + data.Employment.is_email + "]").prop("checked", true);


//                    $('#cap option[value='+data.department_id+']' ).attr('selected','selected')











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
        })
        function checkPermissionAll() {
            if (isCheckAll) {
                $(".check-permission").prop('checked', false);
                isCheckAll = false;
            } else {
                $(".check-permission").prop('checked', true);
                isCheckAll = true;
            }
        }
        function getListPermission() {
            $.ajax({
                url: '{{url('user/role')}}',
                type: 'GET',
                beforeSend: function (xhr) {
                    // xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                },
                success: function (data, textStatus, jQxhr) {
                    console.log(data.data);
                    $.each(data.data, function (key, value) {
                        var clone = $("#check-sample-permission").clone().appendTo("#list-permission");
                        $(clone).find('span').text(value.name);
                        $(clone).find('code').text(value.description);
                        var checkBox = $(clone).find('input');
                        checkBox.val(value.id);
                    });
                    $("#check-sample-permission").remove();

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

    </script>

@endpush
