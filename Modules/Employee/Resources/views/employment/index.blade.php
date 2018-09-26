@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Employee <small>Management staff system</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Employee</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 style="float: left" class="box-title">List of employee</h3>
                        <div style="float: right;">
                            <a href="{{url('employee/create')}}" class="btn btn-default">
                                <i class="fa fa-plus"></i> Add new
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="tableData" class="table table-bordered table-striped" style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center;width: 10px;">#</th>
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Email </th>
                                <th style="text-align: center">Permission </th>
                                <th style="text-align: center;width: 100px;">Created At</th>
                                <th style="text-align: center;width: 100px;">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('stylesheet')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <script>
        var urlAnyData = "{{url('employee/anyData')}}";

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

                        {data: 'email', name: 'email'},
                        {data: 'permission', name: 'permission'},
                        {data: 'created_at', name: 'created_at'},
//                        {data: 'state', name: 'state'},
//                        {data: 'taikhoan', name: 'taikhoan'},
                        {data: 'action', name: 'action'}
                    ]
            });
  


            function setDelete(id) {
                var deleteCustomerURL = '{{url('employee/delete/')}}/' + id;
                toastr.error("<button type='button' id='confirmationRevertYes' class='btn clear'>Yes</button><button type='button' id='confirmationRevertNo' class='btn' style='margin-left: 10px;'>No</button>", 'Bạn có muốn xóa chức vụ này?',
                    {
                        closeButton: false,
                        allowHtml: true,
                        onShown: function (toast) {
                            $("#confirmationRevertYes").click(function () {
                                $.ajax({
                                    url: deleteCustomerURL,
                                    type: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (data,textStatus,jqXhr) {
                                        if (jqXhr.status == 204) {
                                            toastr.success('Bạn xóa thành công');


                                        }
                                        $tableData.ajax.reload();


                                    },
                                    error: function (jqXhr, status, errorThrown) {
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
                            $("#confirmationRevertNo").click(function () {
                                console.log('clicked No');
                                toastr.clear();
                            });
                        },
                        showDuration: "2000",
                    });
            }
    </script>
@endpush
