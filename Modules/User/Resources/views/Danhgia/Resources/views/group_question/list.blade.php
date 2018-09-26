@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nhóm Câu Hỏi
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tạo nhóm câu hỏi</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên nhóm câu hỏi</label>
                                <input type="hidden" id="id">
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="form-group " >
                                <label>Mô ta</label>
                                <textarea id="editor" name="editor" ></textarea>

                            </div>
                            <div class="form-group">
                                <label>Tình trạng</label>
                               <select name="status"  class="form-control" id="status">
                                   <option value="1" id="1" >Mở</option>
                                   <option value="2" id="1" >Đóng</option>
                               </select>
                            </div>
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
                        <h3 class="box-title">Danh sách nhóm câu hỏi</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" style="text-align: center"  id="tableData">
                            <thead>
                            <tr>
                                 <th width="50px" style="text-align: center;">#</th>
                                <th width="" style="text-align: center;">Tên nhóm câu hỏi</th>
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
        CKEDITOR.replace('editor', {
            height: 250,
//                extraPlugins: 'colorbutton',
//                colorButton_colors: 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16',
//                colorButton_enableAutomatic: false,

        });

//        $('#status').select2();
        //
        var $tableData = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{url('danhgia/group_question/anydata')}}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
//                    { data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
        });
        //add
        $("#btn_addForm").click(function () {
            var data = new FormData();
            name =$('input[name=name]').val();
            select =$('#status').val();
            editor =CKEDITOR.instances.editor.getData();
            console.log(editor)
            urlPermission ="{{url('danhgia/group_question/')}}";
            method='post';
            id=$("#id").val();
            param='';
            if(id!=""){
                method="put";
                param='/'+id;
            }
            $.ajax({
                url: urlPermission +param,
                type: method,
                data: {
                    name:name,
                    description:editor,
                    status:select,
                },

                success: function (data, textStatus, jQxhr) {
                    console.log(data)
                    $("#addForm")[0].reset();
                    $("#id").val('');
                    $tableData.ajax.reload();
                    if (textStatus == 'success') {
                        toastr.success(' Thành công');

                    }
                    CKEDITOR.instances.editor.setData("");

                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(jqXhr);
                    if (jqXhr.status == 422) {
                        $.each(jqXhr.responseJSON.errors, function (key, value) {
                            toastr["error"](value);
                        });
                    }
                    if (jqXhr.status == 403) {
                        toastr["error"](jqXhr.responseJSON.error.message);
                    }
                    if (jqXhr.status == 500) {
                        toastr["error"](jqXhr.responseJSON.message);
                    }
                }
            })
        })


        function setDelete(id) {
            var deleteCustomerURL = 'http://danhgia.dev-altamedia.com/danhgia/group_question/delete/' + id;
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
                url: 'group_question/show/'+id ,
                type: 'get',

                success: function (data, textStatus, jQxhr) {
                    console.log(data)
                    $("input[name='name']").val(data['name']);

                    if(data['status']==1){
                        $( "option[value=1]" ).removeAttr('selected','selected');
                        $( "option[value=2]" ).removeAttr('selected','selected');
                        $( "option[value=1]" ).attr('selected','selected')

                    }
                    else{
                        $( "option[value=1]" ).removeAttr('selected','selected');
                        $( "option[value=2]" ).removeAttr('selected','selected');
                        $( "option[value=2]" ).attr('selected','selected')

                    }
                    CKEDITOR.instances.editor.setData( data['description'] );


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
