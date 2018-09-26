@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            Đánh giá <span id="title"></span>
        </h1>

    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nhân viên</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked employee">
                            @foreach($employments as $employment)
                                <li onclick="onClick(this)" user-id="{{$employment['id']}}"
                                    user-name="{{$employment['full_name']}}" id="user{{$employment['id']}}"
                                    user-select="0">
                                    <a><i class="fa fa-user"></i>{{$employment['full_name']}}
                                    </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title " id="nhanvien"></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="addForm" action="{{route('reply')}}" method="post">
                        <input type="hidden" name="id_event" value=" ">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="box-body" id="reply">
                            @foreach($groupQuestion as $groupQues)
                                @foreach($groupQues['detail_question'] as $question)
                                    <div class="form-group">
                                        <label><?php echo $question['question']['name']; ?></label>
                                        <div class=" ">
                                            <div class="rating-wrapper">
                                                @for($i = 1; $i <= 10; $i ++)
                                                    <input onclick="radioClick(this)"
                                                           question-id="{{$question['question']['id']}}" required
                                                           type="radio" class="rating-input"
                                                           name="{{$question['question']['id']}}"
                                                           style="cursor: pointer" value="{{$i}}"/>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <?php //print_r($groupQues['detail_question']); exit(); ?>

                                @endforeach

                        </div>
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

    <!-- Modal -->

    {{--
    <div class="box box-primary">--}}
        {{--
        <div class="box-header with-border">--}}
            {{--<h3 class="box-title " id="title">Sự kiện mùa xuân</h3>--}}
            {{--
        </div>
        --}}
        {{--<!-- /.box-header -->--}}
        {{--<!-- form start -->--}}
        {{--
        <form id="addForm" action="{{route('reply')}}" method="post">--}}
            {{--<input type="hidden" name="id_event">--}}
            {{--<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">--}}

            {{--<div class="box-body" id="reply">--}}
            {{--danh gia theo muc do--}}

            {{--end chon cau tra loi--}}



            {{--</div>--}}
            {{--<!-- /.box-body -->--}}
            {{--<div class="box-footer">--}}
            {{--<button type="submit" class="btn btn-primary" id="btn_addForm" >Thêm</button>--}}
            {{--<button type="button" onclick="formReset(this)" class="btn btn-default pull-right">Làm mới--}}
            {{--</button>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}



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

                    {{--$("#btn_addForm").click(function () {--}}
                    {{--$.ajax({--}}
                    {{--url:'{{url('danhgia/reply')}}',--}}
                    {{--type: 'post',--}}
                    {{--data:$("#addForm").serialize(),--}}

                    {{--success: function (data, textStatus, jQxhr) {--}}

                    {{--if (textStatus == 'success') {--}}
                    {{--toastr.success(' Thành công');--}}
                    {{--}--}}
                    {{--console.log(data)--}}

                    {{--},--}}
                    {{--error: function (jqXhr, textStatus, errorThrown) {--}}
                    {{--console.log(jqXhr);--}}
                    {{--if (jqXhr.status == 422) {--}}
                    {{--$.each(jqXhr.responseJSON.errors, function (key, value) {--}}
                    {{--toastr["error"](value);--}}
                    {{--});--}}
                    {{--}--}}
                    {{--if (jqXhr.status == 403) {--}}
                    {{--toastr["error"](jqXhr.responseJSON.error.message);--}}
                    {{--}--}}
                    {{--if (jqXhr.status == 500) {--}}
                    {{--toastr["error"](jqXhr.responseJSON.message);--}}
                    {{--}--}}
                    {{--}--}}
                    {{--})--}}

                    {{--})--}}
                    //type1


                    //        //type2
                    //        function type2(stt,name ,id) {
                    //
                    //            var type2 = '<div class="form-group">' +
                    //                '<label>'+stt+' :' + name + '</label>' +
                    //                '<div class="">' +
                    //                '<textarea name="' + id + '" required></textarea>\n' +
                    //                '</div>' +
                    //                '</div>';
                    //
                    //            return type2;
                    //        }
                    //        //type3
                    //            function type3(stt,name ,id) {
                    //                option='<option value="name">name</option>';
                    //                var type3 = '  <div class="form-group">\n' +
                    //                    '<label>'+stt+' :'+name+'</label>\n' +
                    //                    '<div class="">\n' +
                    //                    '<select  class="selectpicker" name="'+id+'">\n' ;
                    //                 type3 +=option;
                    //
                    //                type3 +='</select>\n' +
                    //                    '</div>\n' +
                    //                    '</div>';
                    //                return type3;
                    //
                    //            }

                            {{--$.ajax({--}}
                            {{--url: "{{url('danhgia/reply/get_event/')}}/" + id,--}}
                            {{--type: 'get',--}}
                            {{--success: function (data, textStatus, jQxhr) {--}}
                            {{--$("input[name=id_event]").val(data['event'][0].id)--}}
                            {{--$("#title").html(data['event'][0]['description'])--}}

                            {{--//question--}}
                            {{--$stt = 1;--}}
                            {{--$.each(data['question'], function (key, value) {--}}
                            {{--if (value.type == 1) {--}}
                            {{--$("#reply").append(type1($stt, value.name, value.id))--}}
                            {{--}--}}
                            {{--$stt++;--}}
                            {{--})--}}

                            {{--//employ--}}
                            {{--var employee = "";--}}
                            {{--$.each(data['nhanvien'], function (key, value) {--}}
                            {{--employee += '<li class=""><a href="javascript:onClick(' + value.id + ')"><i class="fa fa-user"></i>' + value.full_name + '</a></li>';--}}
                            {{--$(".employee").html(employee)--}}
                            {{--})--}}


                            {{--}--}}

                            {{--})--}}
                            @foreach($employments as $employment)
                    var idCurrent = {{$employment['id']}};
                    var name = " {{$employment['full_name']}} ";
                            @break
                            @endforeach

                    var allData = [
                                    @foreach($employments as $employment)
                            {
                                userID: {{$employment['id']}},
                                questions: [
                                        @foreach($groupQuestion as $groupQues)
                                        @foreach($groupQues['detail_question'] as $question)
                                    {
                                        id: {{$question['question']['id']}}, answer: ''
                                    },
                                    @endforeach
                                    @endforeach

                                ],
                                status: 0
                            },
                                @endforeach
                        ]


                    function onClick(_this) {
                        var userID = $(_this).attr('user-id');
                        var userName = $(_this).attr('user-name');

                        idCurrent = userID;
                        add_name(userName);
                        color(_this);
                        set_value(userID)
                    }

                    function radioClick(_this) {
                        //Khi ng dung click vao thi cap nhat vao allData
                        var questionID = $(_this).attr('question-id');
                        var val = $(_this).val();
                        var user = getDataUser(idCurrent, questionID);
                        user.answer = val;

                        if (user.false == false) {
                            color_red('#user' + idCurrent);
                            user.selected.answer = val;

                        }
                        console.log(user)
                        show_submit()


                    }

                    //Dau userID vaf tra ve doi dong userID do
                    function getDataUser(userID, questionID) {
                        var selected = false;
                        $i = 0;
                        json={};
                        $.each(allData, function (key, value) {
                            if (value.userID == userID) {
                                console.log(value)

                                $.each(value.questions, function (key1, value1) {
                                        if (value1.id == questionID) {
                                            selected = value1;
                                        }
                                        if (value1.answer == "") {

                                            $i++;
                                        }

                                    })
                            }
                        });

                        if ($i == 1) {
                            json.false=false;
                            json.selected=selected;
                            return json;
                        }
                        return selected;
                    }

                    //color
                    function color(_this) {
                        $('.employee li').removeClass('btn-default');
                        $(_this).addClass('btn-default')
                    }

                    function color_red(_this) {
//            $('.employee li').removeClass('btn-primary');
                        $(_this).addClass('btn-success')
                    }

                    add_name(name);

                    //add ten nguoi danh gia
                    function add_name(name) {
                        html = "";
                        html = "<strong>Đánh giá cho</strong> <i>" + name + "</i>"
                        $('#nhanvien').html(html)
                    }

                    //set gia tri lai cho nguoi ta
                    function set_value(userID) {
                        var selected = false;
                        $i = 0;
                        $("#addForm")[0].reset();

                        $.each(allData, function (key, value) {
                            if (value.userID == userID) {
                                $.each(value.questions, function (key1, value1) {
                                    if (value1.answer != "") {
//                                        $("input[name="+value1.id+"][value=" + value1.answer + "]").attr('checked', 'checked');
                                        $("input[name="+value1.id+"]").val([value1.answer]);

                                    }

                                })
                            }
                        });
                    }

                    function show_submit() {
                        $i=0;
                        $.each(allData, function (key, value) {
                                $.each(value.questions, function (key1, value1) {
                                    if (value1.answer == "") {
                                        console.log('ok')
                                        $i++
                                    }

                                })

                        });
                        console.log($i)
                        if($i==0){
                            $('#btn_addForm').css('display','block');
                        }
                    }

                    //submit
                    $("#btn_addForm").click(function () {
                        console.log(allData)
                        $.ajax({
                            url: '{{url('danhgia/reply')}}',
                            type: 'post',
                            data: {
                                'data' : allData,
                                'event_id': {{$event['id']}},
                                'event':{{$event['event_id']}}
                            },

                            success: function (data, textStatus, jQxhr) {
                                console.log(data)
                                if (textStatus == 'success') {
                                    toastr.success(' Thành công');
                                    window.location.href ="{{url('danhgia/reply/success')}}";
                                }


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


                </script>

    @endpush
