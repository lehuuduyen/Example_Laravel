@extends('layouts.app')

@push('stylesheet')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/plugins/iCheck/all.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <h1>
            Device
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active">Device</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add new device</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="{{ route('device.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label>IP address</label>
                                <input type="text" class="form-control" name="ip_address">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Online</label>
                                <input type="checkbox" name="is_online" value="1" checked>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List device</h3>
                    </div>
                    <div class="box-body">
                        <table id="tableListDevice" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>IP Address</th>
                                <th>Online</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Bạn có muốn xóa <strong><span id="name_delete"></span></strong> không?</p>
                    <input type="hidden" name="id_delete" id="id_delete" class="form-control" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteSubmit" data-dismiss="modal">Delete</button>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('public/vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        $(function() {
            $('#tableListDevice').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('device.datatable') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'ip_address', name: 'ip_address' },
                    { 
                        data: 'is_online',
                        name: 'is_online',
                        render: function (data, type, full, meta) {
                            if(data) {
                                return `<button class="btn btn-success">Online</button>`
                            }

                            return `<button class="btn btn-default">Offline</button>`
                        }
                    },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: null, 
                        render: function (data, type, full, meta) {
                            return `<button data-id='${full.id}' data-name='${full.name}' class='btn btn-info btn-sm btn-edit'><i class="fa fa-edit"></i> Edit</button>
                                    <button data-id='${full.id}' data-name='${full.name}' class='btn btn-danger btn-sm btn-delete'><i class="fa fa-trash"></i> Delete</button>`;
                        }
                    }
                ]
            });
        });


        // Delete
        var deleteModal = $('#deleteModal');
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var name = $(this).data('name');
            $('#name_delete').text(name);

            var id = $(this).data('id');
            $('#id_delete').text(id);
            deleteModal.modal('show');
        });

        $('#deleteSubmit').on('click', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('device.destroy') }}',
                data: {
                    _method: 'DELETE',
                    id_delete: $('#id_delete').text()
                },
                success: function () {
                    deleteModal.modal('hide');

                    toastr.success('Xóa thành công');
                    $('#tableListDevice').DataTable().draw(false);
                },
                error: function (res, status, error) {
                    toastr.error(res.responseText);
                }
            });
        });

    </script>
@endpush
