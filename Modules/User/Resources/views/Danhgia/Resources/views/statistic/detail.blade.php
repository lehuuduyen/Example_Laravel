@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            Đánh giá <span id="title"></span>
        </h1>

    </section>
    <section class="content">
        <div class="row">

            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title " >Chi tiết đánh giá</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="" method="post">





                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" id="btn_addForm" style="display: none">Thêm</button>

                        </div>
                    </form>
                </div>
                <!-- /.box-body -->


                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>


            @endsection
            @push('stylesheet')
                <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
                <!-- Date Picker -->
                <link rel="stylesheet" href="{{url('public/css/custom.css')}}">
                <!-- Daterange picker -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
                <style>
                    .rating-input {
                        background: url('http://css-stars.com/wp-content/uploads/2013/12/stars.png') 0 -16px;
                    }

                </style>

            @endpush

            @push('scripts')
                <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                <!-- daterangepicker -->

                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                <script>

                </script>
                <script>
                    var id = location.pathname.split('/')[4];



                </script>

    @endpush
