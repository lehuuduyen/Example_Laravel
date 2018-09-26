@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            Vai trò
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
                        <form action="{{route('user.postEmloyment')}}" method="post" id="frm-user">

                            {!! csrf_field() !!}
                            <input name="user_id" id="flag" value="{{$infor['user_id']}}" type="hidden">
                            <div class="form-group has-feedback">
                                <input type="text" value="{{$infor['full_name']}}" class="form-control" placeholder="Họ Và Tên" name="name" id="name">
                                <span class="fa fa-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" value="{{$infor['email']}}" placeholder="Email" name="email" id="email">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" value="{{$infor['phone']}}" placeholder="Số Điện Thoại" name="phone" id="phone">
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
        </div>
    </section>

@endsection

@push('scripts')


    <script>
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

        var id={{$infor['user_id']}};
        if( id !== 'undefined'){
            $('.add_data').html('Cập Nhật');
        }
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


        $('#list_doctor .alert').delay('3000').slideUp();
        $('.sub-role').on('click', function(event){
            event.preventDefault();
            var flag = $('#flag').val();
            if(flag == 0){
                $('#frm-role').submit();
            }else{
                var id = $('#role_id').val();
                var selected = [];
                var name = $('#role').val();
                var description = $('#description').val();// console.log(description);return false;
                $('#frm-role input:checked').each(function(){
                    selected.push($(this).val());
                });
                $.ajax({
                    url :'{{url('/user/roles')}}' + '/' + id,
                    type:'PUT',
                    data:{data:selected, id_role:id, name:name, description:description},
                })
                    .done(function(response){
                        location.reload();
                    })
            }
        });
        $('.edit').on('click', function(event){
            event.preventDefault();
            var id = $(this).attr('val_id');
            $('#frm-role input[type=checkbox]').prop('checked', false);
            $('.sub-role').html("Cập nhật");
            $('.new_role').css('display', 'inline');
            $('#flag').val(1);
            $('#role_id').val(id);
            $.ajax({
                url :'{{url('/user/getPermissionOne')}}' + '/' + id,
                type:'GET',
            })
                .done(function(data){
                    $.each(data, function(index, el){
                        $('#permission_' + el.permission_id).prop('checked', true);
                        $('#role').val(el.name);
                        $('#description').val(el.description);
                    });
                })
        });
        $('.new_role').on('click', function(event){
            event.preventDefault();
            location.reload();
        });

        function myclick(id){
            toastr.error("<br /><br /><a href='{{url('user/roles/delete')}}" + '/' + id + "\'><button type='button' id='confirmationRevertYes' class='btn clear' style='color: black'>Yes</button></a><button type='button' id='confirmationRevertNo' class='btn' style='margin-left: 10px;color: black;'>No</button>", 'Bạn có chắc chắn xóa mục này?',
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
