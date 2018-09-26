@extends('layouts.app')
@section('css')
    <style>
        animation:godown
        1
        s forwards
        ;

        @-webkit-keyframes godown {
            0% {
                transform : translateX(-600px);
                opacity   : 0;
            }
            100% {
                transform : translateX(0px);
                opacity   : 1;
            }
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Danh sách
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm Quyền</h3>
                    </div>
                    <div class="box-body box-profile">
                        <div class="user-details">
                            <div class="">
                                <input name="" id="permission_id" value="" type="hidden">
                                <form class="" method="POST" id="frm-permission" action="{{url('/user/permissions')}}">
                                    {!! csrf_field() !!}
                                    <input name="" id="flag" value="0" type="hidden">
                                    <label>Tên:</label>
                                    <input name="txt_permission" id="permission" class="form-control">
                                    <label>Mô tả:</label>
                                    <textarea rows="4" cols="50" class="form-control" id="description" name="description"></textarea>
                                </form>
                            </div>
                            <div style="text-align: right; margin-top: 10px;" id="btn_role">
                                <button class="btn btn-primary new_permission" style="display: none;">Làm mới</button>
                                <button class="btn btn-primary add_data">Bấm Thêm</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách quyền</h3>
                    </div>
                    <div class="box-body" id="list_doctor">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="doctor-table" style="text-align: center;vertical-align: middle">
                                <thead>
                                <tr>
                                    <th style="text-align: center;vertical-align: middle">#</th>
                                    <th style="text-align: center;vertical-align: middle">Quyền</th>
                                    <th style="text-align: center;vertical-align: middle">Mô Tả</th>
                                    <th style="text-align: center;vertical-align: middle">Ngày Tạo</th>
                                    <th style="text-align: center;vertical-align: middle"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $item)
                                    <tr>
                                        <td>{{$item['id']}}</td>
                                        <td>{{$item['name']}}</td>
                                        <td>{{$item['description']}}</td>
                                        <td>{{$item['created_at']}}</td>
                                        <td>
                                            <button class="btn btn-xs btn-success edit" val_id={{$item['id']}} style="margin-right:5px;">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger" onclick="myclick({{$item['id']}})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('stylesheet')
    <!-- iCheck for checkboxes and radio inputs -->
    {{--<link rel="stylesheet" href="./public/bower_components/iCheck/all.css">--}}
@endpush

@push('scripts')
    {{--<!-- InputMask -->--}}
    {{--<script src="./public/bower_components/input-mask/jquery.inputmask.js"></script>--}}
    {{--<script src="./public/bower_components/input-mask/jquery.inputmask.date.extensions.js"></script>--}}
    {{--<script src="./public/bower_components/input-mask/jquery.inputmask.extensions.js"></script>--}}
    {{--<!-- iCheck 1.0.1 -->--}}
    {{--<script src="./public/bower_components/iCheck/icheck.min.js"></script>--}}


    <script>
        //iCheck for checkbox and radio inputs
        //        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        //            checkboxClass: 'icheckbox_minimal-blue',
        //            radioClass   : 'iradio_minimal-blue'
        //        })
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            success:function(response, newValue){
                if(response.status == 'ok'){
                    toastr.success('Cập nhật thành công!');
                }
            }
        });
        $('.add_data').on('click', function(event){
            event.preventDefault();
            var flag = $('#flag').val();
            if(flag == 0){
                $('#frm-permission').submit();
            }else{
                var id = $('#permission_id').val();
                var selected = [];
                var name = $('#permission').val()
                var description = $('#description').val()
                $('#frm-permission input:checked').each(function(){
                    selected.push($(this).val());
                });
                // console.log(id);
                // console.log(name);
                // console.log(selected);
                // return false;
                $.ajax({
                    url :'{{url('/user/permissions')}}' + '/' + id,
                    type:'PUT',
                    data:{data:selected, id:id, name:name, description:description},
                })
                    .done(function(response){
                        location.reload();
                    })
            }
        });
        $('.edit').on('click', function(event){
            event.preventDefault();
            var id = $(this).attr('val_id');
            $('#frm-permission input[type=checkbox]').prop('checked', false);
            $('.add_data').html("Cập nhật");
            $('.new_permission').css('display', 'inline');
            $('#flag').val(1);
            $('#permission_id').val(id);
            $.ajax({
                url :'./user/getRoleOne/' + id,
                type:'GET',
            })
                .done(function(data){
                    $.each(data, function(index, el){
                        $('#role_' + el.role_id).prop('checked', true);
                        $('#permission').val(el.name);
                        $('#description').val(el.description);
                    });
                })
        });
        $('.new_permission').on('click', function(event){
            event.preventDefault();
            location.reload();
        });

        function myclick(id){
            toastr.error("<br /><br /><a href='{{url('user/permissions/delete')}}" + '/' + id + "\'><button type='button' id='confirmationRevertYes' class='btn clear' style='color: black'>Yes</button></a><button type='button' id='confirmationRevertNo' class='btn' style='margin-left: 10px;color: black;'>No</button>", 'Bạn có chắc chắn xóa mục này?',
                {
                    closeButton :false,
                    allowHtml   :true,
                    onShown     :function(toast){
                        $("#confirmationRevertNo").click(function(){
                            toastr.clear();
                        });
                    },
                    showDuration:"7000",
                });
        }
    </script>
@endpush
