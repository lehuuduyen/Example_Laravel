@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sự Kiện
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tạo Sự Kiện</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên sự kiện</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group group_question">
                                <label>Nhóm câu hỏi</label>
                                <select name="type" id="group_question" class="form-control">
                                    @foreach($group_question as $key => $group_questions)

                                        <option value="{{ $key }}">{{ $group_questions }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group department">
                                <label>Lựa chòn phòng</label>
                                <select name="type" id="department" class="form-control" multiple>
                                    @foreach($department as $key => $departments)

                                        <option value="{{ $key }}">{{ $departments }}</option>

                                    @endforeach
                                </select>
                            </div>
                            {{--<div class="form-group employees">--}}
                                {{--<label>Nhân viên kèm theo</label>--}}
                                {{--<select name="type" id="employees" class="form-control" multiple>--}}
                                    {{--@foreach($employment as $key => $employments)--}}

                                        {{--<option value="{{ $key }}">{{ $employments }}</option>--}}

                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" id="btn_addForm" >Thêm</button>
                            {{--<button type="button" onclick="formReset(this)" class="btn btn-default pull-right">Làm mới--}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách câu hỏi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" style="text-align: center"  id="tableData">
                            <thead>
                            <tr>
                                 <th width="50px" style="text-align: center;">#</th>
                                <th width="" style="text-align: center;">Tên sự kiện</th>
                                <th width="" style="text-align: center;">Nhóm câu hỏi</th>
                                <th width="100px" style="text-align: center;">Ngày tạo</th>
                                <th width="100px" style="text-align: center;"></th>
                                {{--<th width="" style="text-align: center;">Delete</th>--}}
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('stylesheet')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{url('public/css/custom.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!-- daterangepicker -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
//        CKEDITOR.replace('editor', {
//            height: 250,
////                extraPlugins: 'colorbutton',
////                colorButton_colors: 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16',
////                colorButton_enableAutomatic: false,
//
//        });

        $('#type').select2();
        $('#department').select2();
        $('#employees').select2();

//
        $('#type').change(function () {
            type =$("#type").val();
            $(".dacc").css('display','none')

            if(type==3){
                $(".dacc").css('display','block')
            }

        })
var $tableData = $('#tableData').DataTable({
    processing: true,
    serverSide: true,
    ajax: 'http://danhgia.dev-altamedia.com/danhgia/event/anydata/',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'description', name: 'description' },
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false},
//                    { data: 'delete', name: 'delete', orderable: false, searchable: false}
    ],
});
$.ajax({
    url: "http://danhgia.dev-altamedia.com/danhgia/event/anydata/",
    type: 'get',


    success: function (data, textStatus, jQxhr) {
        console.log(data)


    },
})
$("#btn_addForm").click(function () {
    user_id=1;
    name =$('input[name=name]').val();
    Gquestion =$("#group_question").val();
    department =$("#department").val();
    nhanvien =$("#employees").val();
    $.ajax({
        url: "{{url('danhgia/event/')}}",
        type: 'post',
        data: {
            name:name,
            Gquestion:Gquestion,
            department:department,
            nhanvien:nhanvien,
            user_id:user_id
        },

        success: function (data, textStatus, jQxhr) {
            console.log(data)
            $tableData.ajax.reload();


            if (jQxhr.status == 201) {
                toastr.success(' Thành công');
            }
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

    })
})



function setDelete(id) {
    var deleteCustomerURL = 'http://danhgia.dev-altamedia.com/danhgia/event/delete/'+id;
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
                            console.log(jqXhr)
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
            showDuration: "5000",
        });
}


function setUpdate(id) {


    $.ajax({
        url: 'event/show/'+id ,
        type: 'get',

        success: function (data, textStatus, jQxhr) {
            console.log(data)
//            $("input[name='name']").val(data['name']);
//
//            $("#select2-type-container").html(data['type']);
//            if(data['type']=='Chọn đáp án'){
//                $(".dacc").css('display','block')
//                html='';
//                $.each(data['data'],function (key,value) {
//                    $.each(value,function (key1,value1) {
//                        html+=key1+':'+value1+',';
//
//                    })
//                })
//                if(data['data']==null){
//
//                    html='Không có dữ liệu';
//                }
//                $("input[name=data]").val(html);
//            }
//            else {
//                $(".dacc").css('display','none')
//            }


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
    $("#id").val(id);
}
    </script>

@endpush
