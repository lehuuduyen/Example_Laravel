@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Thống kê
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sự kiện</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">

                       <div class="col-md-11" style="margin:10px;">
                           <select name="user_id event" id="events" class="form-control">
                               <option value=""></option>

                           @foreach($events as $key => $event)
                                   <option value="{{ $event['id'] }}">{{ $event['description'] }}</option>
                               @endforeach
                           </select>
                       </div>



                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Phòng ban</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav_test nav-pills nav-stacked department">


                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <!-- /.col -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Danh sách nhân viên</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-striped" id="tableData">
                                    <thead>
                                    <tr>
                                        <th width="100px" style="text-align: center;"  field="id">Id</th>
                                        <th width="" style="text-align: center;"  field="name">Tên nhân viên</th>
                                        {{--<th width="" style="text-align: center;"  field="created_at">Ngày tạo</th>--}}
                                        <th width="100px" style="text-align: center;"  field="number">Số người đã đánh giá</th>
                                        <th width="100px" style="text-align: center;"  field="sum">Tổng điểm</th>
                                        {{--<th width="50px" style="text-align: center;"  field="count_send">Số lần gửi link</th>--}}
                                        <th width="150px" style="text-align: center;"  field="action">Xem chi tiết đánh giá</th>
                                        {{--<th width="" style="text-align: center;">Delete</th>--}}
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
@push('stylesheet')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{url('public/css/custom.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <style>
        .nav_test{
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }
        .nav_test a{
            margin-left:20px;
        }
        .nav_test li{
            height: 35px;
            line-height: 35px;
        }
        .nav_test span{
            margin-top:10px;
            margin-right:10px;
        }
        .active_nav{
            border-left: 5px solid #3c8dbc;
        }
    </style>
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!-- daterangepicker -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
    $("#events").select2();
        $("#events").change(function () {

            var id = $(this).val();
            get_any(id)
            $.ajax({
                url: "http://danhgia.dev-altamedia.com/danhgia/event/get_department/" + id,
                type: 'get',


                success: function (data, textStatus, jQxhr) {

                    html = '';
                    html += ' <li class="all" data-event="'+id+'" data-index="all" onclick="color_department(this)"  data_id="" data_type="1"><a href="#" ><i class="fa fa-inbox"></i> Tất cả\n' +
                        '<span class="label label-primary pull-right">12</span></a></li>'
                    $.each(data.department, function (key, value) {
                        html += '<li class="" data-event="'+id+'"  data_id="' + value.id + '"   onclick="color_department(this)" data_type="1"><a href="#"><i class="fa fa-inbox"></i> ' + value.name +
                            ' <span class="label label-primary pull-right">12</span></a></li>';
                    });

                    $(".department").html(html)
                }

            })

    });

//
//            $("li").on('click', function () {
//                type = $(this).attr('data_type');
//                dataIndex = $(this).attr('data-index');
//                if (dataIndex == 'all') {
//                    //Tat ca
//                    $('li').attr('data_type', '1');
//                } else {
//                    if (type == 1) {
//                        $(this).attr('data_type', '2');
//                    } else {
//                        $(this).attr('data_type', '1');
//                    }
//                }
//                processABC();
//                getData();
//            });
//
//            // chieu trach nhiem cap nhat mau dua vao tang thai cua li
//            function processABC() {
//                $("ul >li").each(function (data) {
//                        type = $(this).attr('data_type');
//                        if (type == 2) {
//                            $(this).addClass('active');
//                        } else {
//                            $(this).removeClass('active');
//                        }
//                    }
//                );
//            }
//
//            // Chieu trach nhiem gom du lieu
//            var dataAll = [];
//            function getData() {
//               $("ul >li").each(function (data) {
//                        type = $(this).attr('data_type');
//                        if (type == 2) {
//                            $(this).addClass('active');
//                        } else {
//                            $(this).removeClass('active');
//                        }
//                    }
//                );
//            }

//            get_any(id);
        arr = [];

            function color_department(_this){

                data_id = $(_this).attr('data_id');
                id = $(_this).attr('data-event');
                type = $(_this).attr('data_type');
                console.log(type)
                if (data_id == '' && arr.length > 0 && type == 1) {
                    $('.department li').removeClass('active_nav');
                    $('.department li').removeClass('btn-default');
                    $(_this).addClass('active_nav');
                    $(_this).addClass('btn-default');
                    $(_this).attr('data_type', '2');
                    $('.department li').attr('data_type', '1');
                    arr = []

                }
                else {

                    if (type == 1) {
                        $('.all').removeClass('active_nav');
                        $('.all').removeClass('btn-default');
                        $(_this).addClass('active_nav');
                        $(_this).addClass('btn-default');
                        $(_this).attr('data_type', '2');
                        remove(arr, "");
                        arr.push(data_id);
                        console.log(data_id)

                    }
                    if (type == 2) {
                        $(_this).removeClass('active_nav');
                        $(_this).removeClass('btn-default');
                        $(_this).attr('data_type', '1');
                        remove(arr, data_id);
                    }
                }
                console.log(arr)
                get_any(id,arr)


        }


        function remove(array, element) {
            const index = array.indexOf(element);

            if (index !== -1) {
                array.splice(index, 1);
            }
        }

        function get_any(id,request) {
            fields=[];
            $('#tableData').DataTable().destroy();

            $('#tableData > thead > tr > th').each(function () {

                var value = $(this).attr('field');

                fields.push({data: value, name: value});

            }).promise().done(function () {

                datatables = $('#tableData').DataTable({

                    processing: true,

                    serverSide: true,

                    "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],

                    "iDisplayLength": 25,

                    ajax: {

                        url:'http://danhgia.dev-altamedia.com/danhgia/statistic/anyData_detail/'+ id,

                        data: function (d) {

                            d.data = request;
                        }

                    },

                    order:

                        [[0, 'desc']],

                    dom: 'Bfrtip',

                    buttons: [

                        'copy', 'csv', 'excel', 'pdf', 'print'

                    ],

                    columns: fields

                });

            });

        }
        $.ajax({
            url: "http://danhgia.dev-altamedia.com/danhgia/statistic/sum/" ,
            type: 'get',
            success: function (data, textStatus, jQxhr) {
                console.log(data)
            }

        })

    </script>

@endpush
