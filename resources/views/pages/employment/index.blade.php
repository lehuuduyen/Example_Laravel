@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nhân Viên
            <small>Preview</small>
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
    <section class="content">
        <a href="{{url('employment/create')}}" class="btn btn-app">
            <i class="fa fa-edit"></i> THÊM MỚI
        </a>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Danh sách</h3>
            </div>
            <div class="box-body">
                <table id="tableData" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>TÊN</th>
                        <th>CẤP BẬC</th>
                        <th>LOẠI HÌNH CÔNG VIỆC</th>
                        <th>Email / Phone</th>
                        <th>NGÀY TẠO</th>
                        <th>TRẠNG THÁI</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

@endsection
@push('stylesheet')

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        var urlAnyData = "{{url('api/employment/anyData')}}";
        var urlDepartment = "{{url('api/department')}}";
        $(function () {
            var $tableData = $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: urlAnyData,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    }

                },
                order:
                    [[0, 'desc']],
                bDeferRender: true,
                columns:
                    [
                        {data: 'id', name: 'id'},
                        {data: 'full_name', name: 'full_name'},
                        {data: 'position.name', name: 'position.name'},
                        {data: 'type_name', name: 'type_name'},
                        {data: 'email_phone', name: 'email_phone'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'state', name: 'state'},
                        {data: 'action', name: 'action'}
                    ]
            });
            $('#addForm').submit(function (event) {
                event.preventDefault();
                var $form = $(this);
                var _method = 'post';
                var _parameter = '';
                if ($("input[name='id']").val() > 0) {
                    _method = 'put';
                    _parameter = '/' + $("input[name='id']").val();
                }
                $.ajax({
                    url: urlDepartment + _parameter,
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
        A


        getDepartments(function (data) {
            var $mySelect = $('#mySelect');
            var str;
            $.each(data.data, function (i, item) {
                str += "<option value='" + item.id + "'> " + item.name + "</option>";
            });
            $mySelect.html(str);
        });

        function getDepartment(id, handleData) {
            $.ajax({
                url: urlDepartment + '/' + id,
                type: 'get',
                success: function (data, textStatus, jQxhr) {
                    handleData(data);
                }
            });
        }

        function setUpdate(id) {
            getDepartment(id, function (output) {
                console.log(output);
                setData(output.data);
            })
        }

        /**
         * Reset form from button
         * @param _this
         */
        function formReset(_this) {
            var _form = $(_this).parent().closest('form');
            _form[0].reset();
            _form.on('reset', function () {
                $("input[type='hidden']", $(this)).each(function () {
                    $(this).val('');
                });
            });
        }
    </script>
@endpush
