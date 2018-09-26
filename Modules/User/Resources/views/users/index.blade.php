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
            TÀI KHOẢN
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tài khoản</h3>
                    </div>
                    <!-- /.login-logo -->
                    <div class="login-box-body">
                        <input name="" id="user_id" value="0" type="hidden">
                        <form action="{{url('/user/users')}}" method="post" id="frm-user">
                            <input name="" id="flag" value="0" type="hidden">
                            {!! csrf_field() !!}
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="Họ Và Tên" name="name" id="name">
                                <span class="fa fa-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="Email" name="email" id="email">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" placeholder="Số Điện Thoại" name="phone" id="phone">
                                <span class="fa fa-phone form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="repassword" class="form-control" placeholder="Repassword" id="repassword">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Cung cấp quyền</label>
                                </br>
                                @foreach($roles as $item)
                                    <p>
                                        <input type="checkbox" id="role_{{$item['id']}}" name="role[]" value="{{$item['name']}}"> {{$item['name']}}
                                    </p>

                                @endforeach
                            </div>
                            <div class="form-group has-feedback">
                                <!-- /.col -->
                                <div style="text-align: right; margin-top: 10px;" id="btn_role">
                                    <button class="btn btn-primary new_permission" style="display: none;">Làm mới
                                    </button>
                                    <button class="btn btn-primary add_data">Thêm</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <!-- /.login-box-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách tài khoản</h3>
                    </div>
                    <div class="box-body" id="list_doctor">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="doctor-table" style="text-align: center;vertical-align: middle">
                                <thead>
                                <tr>
                                    <th style="text-align: center;vertical-align: middle">#</th>
                                    <th style="text-align: center;vertical-align: middle">Tên</th>
                                    <th style="text-align: center;vertical-align: middle">Email</th>
                                    <th style="text-align: center;vertical-align: middle">Số điện thoại</th>
                                    <th style="text-align: center;vertical-align: middle">Ngày tạo</th>
                                    <th style="text-align: center;vertical-align: middle">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
                                        <td>{{$item['name']}}</td>
                                        <td>{{$item['email']}}</td>
                                        <td>{{$item['phone']}}</td>
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

@push('scripts')


    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            //success: function(response, newValue) {
//                if(response.status == 'ok'){
//                    toastr.success('Cập nhật thành công!');
//                }
            // }
        });
        $('.add_data').on('click', function(event){
            event.preventDefault();
            var flag = $('#flag').val();
            if(flag == 0){
                $('#frm-user').submit();
            }else{
                var id = $('#user_id').val();
                var selected = [];
                var name = $('#name').val();
                var phone = $('#phone').val()
                var email = $('#email').val()
                $('#frm-user input:checked').each(function(){
                    selected.push($(this).val());
                });
                // console.log(id);
                // console.log(name);
                // console.log(selected);
                // return false;
                $.ajax({
                    url :'{{url('user/users')}}' + '/' + id,
                    type:'PUT',
                    data:{data:selected, name:name, phone:phone, email:email},
                })
                    .done(function(response){
                        //console.log(response);
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    })
            }
        });
        $('.edit').on('click', function(event){
            event.preventDefault();
            var id = $(this).attr('val_id');
            $('#frm-user input[type=checkbox]').prop('checked', false);
            $('.add_data').html("Cập nhật");
            $('.new_permission').css('display', 'inline');
            $('#flag').val(1);
            $('#user_id').val(id);
            $.ajax({
                url :'{{url('user/RoleOfUser')}}' + '/' + id,
                type:'GET',
            })
                .done(function(data){
                    //console.log(data); return false;
                    $.each(data, function(index, el){
                        //console.log('gia tri index '+index); //return false;
                        // console.log('gia tri el '+el.role_id); //return false;
                        $('#role_' + el.role_id).prop('checked', true);
                    });
                });
            $.ajax({
                url :'{{url('user/UserOne')}}' + '/' + id,
                type:'GET',
            })
                .done(function(data){
                    $('#name').val(data.name);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                });
        });

        function myclick(id){
            toastr.error("<br /><br /><a href='{{url('user/users/delete')}}" + '/' + id + "\'><button type='button' id='confirmationRevertYes' class='btn clear' style='color: black'>Yes</button></a><button type='button' id='confirmationRevertNo' class='btn' style='margin-left: 10px;color: black;'>No</button>", 'Bạn có chắc chắn xóa mục này?',
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
