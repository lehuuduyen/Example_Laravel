@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thông tin ứng dụng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Quyền Hệ Thống</a></li>
                        <li><a href="#timeline" data-toggle="tab">Nhân Viên</a></li>
                        <li><a href="#settings" data-toggle="tab">Phòng Ban</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Thêm Quyền Mới</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <form id="addForm" action="{{url("api/SysApp")}}" method="post">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Khóa</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tên hiển thị</label>
                                                    <input type="text" class="form-control" name="name_display">
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="description">
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary">Thêm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">List Project</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="tableData" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Prefix</th>
                                                    <th>Name</th>
                                                    <th>Created At</th>
                                                    <th>State</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                                <!-- timeline time label -->
                                <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-envelope bg-blue"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-user bg-aqua"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your
                                            friend request
                                        </h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-comments bg-yellow"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post
                                        </h3>

                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-camera bg-purple"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                        <div class="timeline-body">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and
                                                    conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->


@endsection
@push('stylesheet')

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#tableData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url('api/SysApp/anyData')}}",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
                    }
                },
                order:
                    [[0, 'desc']],
                columns:
                    [
                        {data: 'id', name: 'id'},
                        {data: 'abbreviate', name: 'abbreviate'},
                        {data: 'name', name: 'name'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'state', name: 'state'},
                        {data: 'action', name: 'action'}
                    ]
            });
            $('#addForm').submit(function (event) {
                event.preventDefault();
                var $form = $(this);
                url = $form.attr("action");
                $.ajax({
                    url: url,
                    type: 'post',
                    data: $form.serialize(),
                    success: function (data, textStatus, jQxhr) {
                        console.log(jQxhr);
                        toastr["success"](textStatus);
                        $form[0].reset();
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
            });
        });
    </script>
@endpush
