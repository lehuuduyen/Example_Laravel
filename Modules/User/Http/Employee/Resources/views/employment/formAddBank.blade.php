<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm mới tài khoản</h4>
            </div>
            <div class="modal-body">


                <form class="form-horizontal formUpdate" id="formAddBank" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" style="text-align: left">Tên ngân hàng
                        </label>
                        <div class="col-sm-9">
                            <input name="bank_id" type="hidden">
                            <input name="user_id" type="hidden" value="{{$id}}">
                            <input name="bank_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" style="text-align: left">Mã số tài khoản
                        </label>
                        <div class="col-sm-9">
                            <input name="bank_number" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" style="text-align: left">Ghi chú
                        </label>
                        <div class="col-sm-9">
                            <input name="bank_description" type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
                <button onclick="submitFormAddBank('#formAddBank')" type="button" class="btn btn-primary">Thêm
                    mới
                </button>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
@push('scripts')
    <script>
        //Form add bank
        function submitFormAddBank(str) {
            var urlUserBank = "{{url('api/UserBank')}}";
            var $form = $(str);
            var _method = 'post';
            var _parameter = '';
            if ($(str + " input[name='bank_id']").val() > 0) {
                _method = 'put';
                _parameter = '/' + $("input[name='bank_id']").val();
            }
            $.ajax({
                url: urlUserBank + _parameter,
                type: _method,
                data: $form.serialize(),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                },
                success: function (data, textStatus, jQxhr) {
                    console.log(jQxhr);
                    toastr["success"](textStatus);
                    $form[0].reset();
                    $tableData.ajax.reload();
                    $('#modal-default').modal('hide');
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
        }

        //
        function ShowFormAddBank() {
            $('#modal-default').modal('show');
            formReset('#formAddBank', true);
        }

        //
        function setUpdateUserBank($id) {
            UserBank($id, function (data) {
                $('#modal-default').modal('show');
                console.log(data.data);
                setData(data.data, '', 'bank_');
            });
        }

        function UserBank(id, handleData) {
            $.ajax({
                url: "{{url('api/UserBank')}}/" + id,
                type: 'get',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                },
                success: function (data, textStatus, jQxhr) {
                    handleData(data);
                }
            });
        }
    </script>
@endpush