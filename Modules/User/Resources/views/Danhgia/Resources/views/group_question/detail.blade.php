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
                        <h3 class="box-title">Tạo câu hỏi</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên nhóm câu hỏi</label>
                                <input type="text" class="form-control" disabled="" name="name" value="Nhóm câu hỏi mùa xuân">
                            </div>
                            <div class="form-group">
                                <label>Chọn câu hỏi</label>
                                <select name="question" class="form-control" id="question">
                                    @foreach($QuestionController as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach

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
                        <table class="table table-bordered table-striped"  id="tableData">
                            <thead>
                            <tr>
                                <th width="" style="text-align: center;">Id</th>
                                <th width="" style="text-align: center;">Tên câu hỏi</th>
                                <th width="" style="text-align: center;"></th>
                                {{--<th width="" style="text-align: center;">Delete</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td width="" style="text-align: center;">1</td>
                                <td width="" style="text-align: center;">Nhóm câu hỏi mùa xuân</td>

                                <td width="100px" style="text-align: center;">
                                    <a id="" href="javascript:setDelete(28)" class="btn btn-xs btn-danger" title="Xóa"><i class="fa fa-times"></i></a>
                                </td>
                                {{--<th width="" style="text-align: center;">Delete</th>--}}
                            </tr>

                            </tbody>
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

        var id = location.pathname.split('/')[4];

        $('#question').select2();

        var $tableData = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'http://danhgia.dev-altamedia.com/danhgia/group_question/anydata_detail/'+id,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false},
//                    { data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
        });
        $("#btn_addForm").click(function () {
            var data = new FormData();
            name =$('input[name=name]').val();
            question =$("#question").val();

            $.ajax({
                url: "{{url('danhgia/group_question/store_detail')}}",
                type: 'post',
                data: {
                    group_question_id:id,
                    question_id:question,

                },

                success: function (data, textStatus, jQxhr) {
                    console.log(data)
                    $tableData.ajax.reload();
                    if (textStatus == 'success') {
                        toastr.success(' Thành công');

                    }
                }

            })
        })



        function setDelete(question) {
            var deleteCustomerURL = 'http://danhgia.dev-altamedia.com/danhgia/group_question/delete_detail/' + question+'/'+id;
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


        $.ajax({
            url: 'http://danhgia.dev-altamedia.com/danhgia/group_question/show/'+id ,
            type: 'get',

            success: function (data, textStatus, jQxhr) {

                $("input[name='name']").val(data['name']);


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

    </script>

@endpush
