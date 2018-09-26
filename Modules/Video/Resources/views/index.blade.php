@extends('layouts.app')
@push('stylesheet')
    <style type="text/css">
        hr,table{
            width: 100% !important;
        }
        hr{
            margin:10px 0px !important;
            padding:0px !important;
        }
        table thead tr th,table tbody tr td{
            text-align: center;
        }
        table#CouponTable tbody tr td:last-child,#CouponTable thead tr th:last-child{
            width: 80px !important;
            text-align: center;
        }
        table#CouponTable tbody tr td:nth-child(2),#CouponTable thead tr th:nth-child(2){
            width: 50px !important;
            text-align: center;
        }

        #abtributeOneProduct li{
            display: inline-block;
        }
        #abtributeOneProduct li a {
            background: #F7F7F7;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush

@section('content')
    <section class="content-header">
        <h1>
            Video <small>Thêm mới và tổng hợp danh sách các video</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li> <a href="#">Customer</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin của video mới</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tệp tin video</label>
                            <input type="file" class="form-control" name="description" id="description">
                        </div>
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh thu nhỏ</label>
                            <input type="file" class="form-control" name="description" id="description">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="javascript:addClick()" id="addGroup" class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách các video</h3>
                    </div>
                    <div class="box-body">
                        <div id="tableData_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"><div class="dataTables_length" id="tableData_length"><label>Số hàng hiển thị <select name="tableData_length" aria-controls="tableData" class="form-control input-sm"><option value="25">25</option><option value="50">50</option><option value="75">75</option><option value="-1">All</option></select> hàng.</label></div></div><div class="col-sm-6"><div id="tableData_filter" class="dataTables_filter"><label>Tìm kiếm nhanh:<input type="search" class="form-control input-sm" placeholder="" aria-controls="tableData"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="tableData" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="tableData_info" style="width: 1061px;">
                                        <thead>
                                        <tr role="row"><th class="sorting" tabindex="0" aria-controls="tableData" rowspan="1" colspan="1" aria-label="#: activate to sort column ascending" style="width: 53px;">#</th><th class="sorting" tabindex="0" aria-controls="tableData" rowspan="1" colspan="1" aria-label="Tên: activate to sort column ascending" style="width: 188px;">Tên</th><th class="sorting" tabindex="0" aria-controls="tableData" rowspan="1" colspan="1" aria-label="Mô tả: activate to sort column ascending" style="width: 105px;">Mô tả</th><th class="sorting" tabindex="0" aria-controls="tableData" rowspan="1" colspan="1" aria-label="Ngày tạo: activate to sort column ascending" style="width: 224px;">Ngày tạo</th><th class="sorting" tabindex="0" aria-controls="tableData" rowspan="1" colspan="1" aria-label="Tình trạng: activate to sort column ascending" style="width: 80px;">Tình trạng</th><th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Hành động" style="width: 200px;">Hành động</th></tr>
                                        </thead>
                                        <tbody><tr role="row" class="odd"><td>1</td><td>
                                                -&nbsp;Phòng lập trình</td><td></td><td>2018-05-21 10:09:37</td><td><span class="btn btn-xs btn-success">Mở</span></td><td> <a class="btn btn-xs btn-success" href="/department/detail/1"><i class="fa fa-eye"></i>&nbsp;&nbsp;Chi tiết</a>
                                                <a class="btn btn-xs btn-primary" href="javascript:setData(1)"><i class="fa  fa-pencil-square-o"></i>&nbsp;&nbsp;Cập nhật</a>
                                                <a class="btn btn-xs btn-danger" href="javascript:deleteDepartment(1)"><i class="fa fa-times"></i>&nbsp;&nbsp;Xóa</a>
                                            </td></tr><tr role="row" class="even"><td>2</td><td>
                                                -&nbsp;Phòng nhân sự</td><td></td><td>2018-05-21 11:56:17</td><td><span class="btn btn-xs btn-success">Mở</span></td><td> <a class="btn btn-xs btn-success" href="/department/detail/2"><i class="fa fa-eye"></i>&nbsp;&nbsp;Chi tiết</a>
                                                <a class="btn btn-xs btn-primary" href="javascript:setData(2)"><i class="fa  fa-pencil-square-o"></i>&nbsp;&nbsp;Cập nhật</a>
                                                <a class="btn btn-xs btn-danger" href="javascript:deleteDepartment(2)"><i class="fa fa-times"></i>&nbsp;&nbsp;Xóa</a>
                                            </td></tr><tr role="row" class="odd"><td>3</td><td>
                                                -&nbsp;Phòng tài xế</td><td></td><td>2018-05-21 15:29:32</td><td><span class="btn btn-xs btn-success">Mở</span></td><td> <a class="btn btn-xs btn-success" href="/department/detail/3"><i class="fa fa-eye"></i>&nbsp;&nbsp;Chi tiết</a>
                                                <a class="btn btn-xs btn-primary" href="javascript:setData(3)"><i class="fa  fa-pencil-square-o"></i>&nbsp;&nbsp;Cập nhật</a>
                                                <a class="btn btn-xs btn-danger" href="javascript:deleteDepartment(3)"><i class="fa fa-times"></i>&nbsp;&nbsp;Xóa</a>
                                            </td></tr></tbody></table><div id="tableData_processing" class="dataTables_processing panel panel-default" style="display: none;">Processing...</div></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="tableData_info" role="status" aria-live="polite">Hiển thị 1 đến 3 trong tổng 3 dòng</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="tableData_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="tableData_previous"><a href="#" aria-controls="tableData" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="tableData" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button next disabled" id="tableData_next"><a href="#" aria-controls="tableData" data-dt-idx="2" tabindex="0">Next</a></li></ul></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    {{--<script>--}}
        {{--var id = {{$id}};--}}
        {{--var urlShowProfile = "{!! url('customer/show') !!}/"+id;--}}
        {{--var urlAnyData = "{!! url('customer/story/show') !!}/"+id;--}}
        {{--$.ajax({--}}
            {{--url: urlShowProfile,--}}
            {{--type: 'GET',--}}
            {{--headers: {--}}
                {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--},--}}
            {{--success: function (data,textStatus,jqXhr) {--}}
                {{--$("#pr-avatars").attr("src", 'http://graph.fb.me/'+data.profile_id+'/picture?type=large');--}}
                {{--$("#pr-link").attr("href", 'http://fb.com/'+data.profile_id+'');--}}
                {{--$("#pr-name").text(data.name);--}}
                {{--$("#pr-email").text(data.email);--}}
                {{--$("#pr-created").text(data.created_at);--}}
                {{--$("#pr-profile_id").text(data.profile_id);--}}
            {{--},--}}
            {{--error: function (jqXhr, status, errorThrown) {--}}
                {{--if (jqXhr.status == 422) {--}}
                    {{--$.each(jqXhr.responseJSON.error.errors, function (key, value) {--}}
                        {{--toastr["error"](value);--}}
                    {{--});--}}
                {{--}--}}
                {{--if (jqXhr.status == 403) {--}}
                    {{--toastr["error"](jqXhr.responseJSON.error.message);--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}

        {{--$('#tblStory').DataTable({--}}
            {{--processing: true,--}}
            {{--serverSide: true,--}}
            {{--ajax: {--}}
                {{--url: urlAnyData,--}}
                {{--beforeSend: function (xhr) {--}}
                    {{--xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());--}}
                {{--}--}}
            {{--},--}}
            {{--order:--}}
                {{--[[0, 'desc']],--}}
            {{--bDeferRender: true,--}}
            {{--columns:--}}
                {{--[--}}
                    {{--{data: 'id', name: 'id'},--}}
                    {{--{data: 'name', name: 'name'},--}}
                    {{--{data: 'count_dow', name: 'count_dow'},--}}
                    {{--{data: 'count_email', name: 'count_email'},--}}
                    {{--{data: 'count_share', name: 'count_share'},--}}
                    {{--{data: 'created_at', name: 'created_at'},--}}
                    {{--{data: 'url_pdf', name: 'url_pdf'}--}}
                {{--],--}}
            {{--columnDefs: [--}}
                {{--{--}}
                    {{--"targets":6,--}}
                    {{--"render": function (data, type, row) {--}}
                        {{--return '<a href="'+row.url_pdf+'"><button class="btn btn-xs btn-success btn-add"><i class="fa fa-cloud-download"></i> Download</button></a>';--}}
                    {{--}--}}
                {{--},--}}
            {{--]--}}
        {{--});--}}
    {{--</script>--}}
@endpush
