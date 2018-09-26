@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Application
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
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Application</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="{{url("api/SysApp")}}" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Prefix</label>
                                <input type="text" class="form-control" name="abbreviate">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Project</h3>
                    </div>
                    <div class="box-body">
                        <table id="tableData" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Prefix</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>State</th>
                                <th>Action</th>
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

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url('api/SysApp/anyData')}}",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    }
                },
                order:
                    [[0, 'desc']],
                columns:
                    [
                        {data: 'id', name: 'id'},
                        {data: 'abbreviate', name: 'abbreviate'},
                        {data: 'name', name: 'name'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'state', name: 'state'},
                        {data: 'action', name: 'action'}
                    ]
            });
            $('#addForm').submit(function (event) {
                event.preventDefault();
                var $form = $(this);
                url = $form.attr("action");
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $form.serialize(),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    },
                    success: function (data, textStatus, jQxhr) {
                        console.log(jQxhr);
                        toastr["success"](textStatus);
                        $form[0].reset();
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
    </script>
@endpush
