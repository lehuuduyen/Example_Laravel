@extends('layouts.app')
@section('css')
    <style>
        animation:godown 1s forwards;

        @-webkit-keyframes godown {
            0%{transform:translateX(-600px);opacity:0;}
            100%{transform:translateX(0px);opacity:1;}
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Bác sĩ
            <small>Danh sách</small>
        </h1>
        <div class="col-md-12" style="margin-top: 10px;margin-left: -15px;">
            {{--<a href="{{url("docter/create")}}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Doctor</button></a>--}}
            <a href="{{url("docter/create")}}" class="btn btn-app">
                <i class="fa fa-edit"></i> THÊM MỚI
            </a>
        </div>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Doctor</h3>
                    </div>
                    <div class="box-body" id="list_doctor">

                        <div class="col-md-12">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-{!! Session::get('flash_level') !!}">
                                    {!! Session::get('flash_message') !!}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered" id="doctor-table" style="text-align: center;vertical-align: middle">
                                <thead>
                                <tr>
                                    <th style="text-align: center;vertical-align: middle">ID</th>
                                    <th style="text-align: center;vertical-align: middle">Họ Tên</th>
                                    <th style="text-align: center;vertical-align: middle">Email</th>
                                    <th style="text-align: center;vertical-align: middle">Số  Điện Thoại</th>
                                    <th style="text-align: center;vertical-align: middle">Ngày Sinh</th>
                                    <th style="text-align: center;vertical-align: middle">Chuyên Khoa</th>
                                    <th style="text-align: center;vertical-align: middle">Ngày Tạo</th>
                                    <th style="text-align: center;vertical-align: middle">Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

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
        $('#list_doctor .alert').delay('3000').slideUp();




        function myclick(id){

            toastr.error("<br /><br /><a href='./docter/delete/"+id+"'><button type='button' id='confirmationRevertYes' class='btn clear' style='color: black'>Yes</button></a><button type='button' id='confirmationRevertNo' class='btn' style='margin-left: 10px;color: black;'>No</button>",'Bạn có chắc chắn xóa mục này?',
                {
                    closeButton: false,
                    allowHtml: true,
                    onShown: function (toast) {
                        $("#confirmationRevertNo").click(function(){
                            toastr.clear();
                        });
                    },
                    showDuration: "7000",
                });
        }
    </script>
@endpush
