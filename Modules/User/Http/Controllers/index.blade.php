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
                @if(count($errors) > 0)
                <div class="alert alert-danger errors">
                <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
                </div>
                @endif()
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Thêm </h3>
                            @if(count($errors)>0)
                             <span>Có lỗi</span>
                                @else
                            <span>Không Có lỗi</span>
                            @endif
                    </div>
                    <div class="box-body box-profile">
                        <div class="user-details">
                            <div class="">
                                <input name="" id="role_id" value="" type="hidden">
                                <form class="" method="POST" id="frm-role" action="{{url('/user/roles')}}">
                                    {!! csrf_field() !!}
                                    <input name="" id="flag" value="0" type="hidden">
                                    <label>Tên:</label>
                                    <input name="txt_role" id="role" class="form-control">
                                    <label>Mô tả:</label>
                                    <textarea rows="4" cols="50" class="form-control" id="description" name="description"></textarea>
                                    <h5>Chọn quyền</h5>
                                    
                                    @foreach($permissions as $item)
                                        <p>
                                            <input type="checkbox" id="permission_{{$item['id']}}" name="permission[]" value="{{$item['id']}}"> {{$item['name']}}
                                        </p>
                                    @endforeach
                                </form>
                            </div>
                            <div style="text-align: right; margin-top: 10px;" id="btn_role">
                                <button class="btn btn-primary new_role" style="display: none;">Làm mới</button>
                                <button class="btn btn-primary sub-role">Thêm</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách vai trò</h3>
                    </div>
                    <div class="box-body" id="list_doctor">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="doctor-table" style="text-align: center;vertical-align: middle">
                                <thead>
                                <tr>
                                    <th style="text-align: center;vertical-align: middle">#</th>
                                    <th style="text-align: center;vertical-align: middle">Vai trò</th>
                                    <th style="text-align: center;vertical-align: middle">Mô Tả</th>
                                    <th style="text-align: center;vertical-align: middle">Ngày Tạo</th>
                                    <th style="text-align: center;vertical-align: middle">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
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
