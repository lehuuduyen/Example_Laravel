@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Danh sách SMS
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bộ lọc</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Từ ngày:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker" id="dateStart">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label>Đến ngày:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker" id="dateEnd">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default">Làm mới</button>
                            <button type="button" class="btn btn-info pull-right" id="js-filter">Lọc</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách SMS</h3>
                    </div>
                    <div class="box-body">
                        <table id="tableData" class="table table-bordered table-striped" style="text-align: center">
                            <thead>
                            <tr>
                                <th width="" style="text-align: center;" field="id">Mã</th>
                                <th width="" style="text-align: center;" field="username">Hệ Thống Gọi</th>
                                <th width="" style="text-align: center;" field="telecom">Nhà Mạng</th>
                                <th width="" style="text-align: center;" field="phone">Số Nhận</th>
                                <th width="" style="text-align: center;" field="content">Nội Dung</th>
                                <th width="" style="text-align: center;" field="created_at">Thời Gian</th>
                                <th width="" style="text-align: center;" field="status_view">Tình Trạng</th>
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
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <!-- bootstrap datepicker -->
    <script src="{{url("public/vendor/adminlte")}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


    <script>
        var fields = [];
        var datatables = null;
        $('#tableData > thead > tr > th').each(function(){
            var value = $(this).attr('field');
            fields.push({data:value, name:value});
        }).promise().done(function(){
            datatables = $('#tableData').DataTable({
                processing      :true,
                serverSide      :true,
                "aLengthMenu"   :[[25, 50, 75, -1], [25, 50, 75, "All"]],
                "iDisplayLength":25,
                ajax            :{
                    url :"{{route('sms.datatables')}}",
                    data:function(d){
                        d.dateStart = $('#dateStart').val();
                        d.dateEnd = $('#dateEnd').val();
                    }
                },
                order           :
                    [[0, 'desc']],
                dom             :'Bfrtip',
                buttons         :[
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columns         :fields
            });
        });
        //Date picker
        $('.datepicker').datepicker({
            autoclose:true
        })
        $('#js-filter').click(function(){
            datatables.ajax.reload();
        });
    </script>
@endpush
