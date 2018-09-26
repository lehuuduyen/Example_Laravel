<!DOCTYPE html>
<html>
<head>
    <base href="{{url('')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | General Form Elements</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{url("public/caleandar-master/css/theme1.css")}}">
    <link rel="stylesheet" href="{{url("public/bower_components/fullcalendar/dist/fullcalendar.min.css")}}">
    <link rel="stylesheet" href="{{url("public/bower_components/fullcalendar/dist/fullcalendar.print.min.css")}}" media="print">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- stack stylesheet -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Login</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="./user/login" method="post" id="form-login" >
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Email" name="email" id="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label style="padding-left: 22px">
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button class="btn btn-primary btn-block btn-flat login">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{url("public/vendor/adminlte")}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url("public/vendor/adminlte")}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="{{url("public/vendor/adminlte")}}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url("public/vendor/adminlte")}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url("public/vendor/adminlte")}}/dist/js/demo.js"></script>
<script src="{{url("public/vendor/adminlte")}}/bower_components/toastr/toastr.min.js"></script>
<script src="{{url("public/caleandar-master/js/caleandar.js")}}"></script>
<script>
    $('.login').on('click',function(event){
        event.preventDefault();
        $('#form-login').submit();
//        var email = $('#email').val();
//        var password = $('#password').val();
//
//        $.ajax({
//            url: '/api/user/login',
//            type: 'POST',
//            data: {email:email,password:password},
//            success: function(data){
//                window.location.href = 'http://hidocter.dev-altamedia.com/docter?token='+data.token;
//            }
//        });
    });
</script>

<script>


    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    {{--@if($errors->any())--}}
        {{--toastr["error"]("{{$errors->first()}}")--}}
    {{--@endif--}}

            {{--@if ($message = Session::get('success'))--}}
        {{--toastr["success"]("{{$message}}")--}}

    {{--@endif--}}

    /**
     * fill data to name
     * @param data
     */
    function setData(data, elementParent, prefix) {
        elementParent = elementParent || '';
        prefix = prefix || '';
        $.each(data, function (key, value) {
            var _this = $(elementParent + ' input[name = ' + prefix + key + ']');
            if (!_this.length) {
                _this = $(elementParent + ' select[name = ' + prefix + key + ']');
            }
            _this.val(value);
        });
    }

    function getDepartments(handleData) {
        $.ajax({
            url: "{{url('api/department')}}",
            type: 'get',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
            }
        }).done(function (response) {
            handleData(response);
        }).fail(function (err) {
            checkLogin(err);
            processErrors(err);
        });
    }

    function getGender(handleData) {
        $.ajax({
            url: "{{url('api/employment/gender')}}",
            type: 'get',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
            }
        }).done(function (response) {
            handleData(response);
        }).fail(function (err) {
            checkLogin(err);
            processErrors(err);
        });
    }

    function getType(handleData) {
        $.ajax({
            url: "{{url('api/employment/type')}}",
            type: 'get',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
            }
        }).done(function (response) {
            handleData(response);
        }).fail(function (err) {
            checkLogin(err);
            processErrors(err);
        });
    }

    function getPosition(handleData) {
        $.ajax({
            url: "{{url('api/employment_position')}}",
            type: 'get',
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", 'Bearer ' + getJwtToken());
            }
        }).done(function (response) {
            handleData(response);
        }).fail(function (err) {
            checkLogin(err);
            processErrors(err);
        });
    }

    /**
     * Reset form from button
     * @param _this
     */
    function formReset(_this, flag) {
        flag = flag || false;
        var _form = $(_this).parent().closest('form');
        if (flag) {
            _form = $(_this);
        }

        _form[0].reset();
        _form.on('reset', function () {
            $("input[type='hidden']", $(this)).each(function () {
                $(this).val('');
            });
        });
    }

    //For Token ====================================
    /**
     * Get token current
     * @returns {any}
     */
    function getJwtToken() {
        return window.sessionStorage.token;
    }

    /**
     * Check login
     */
    function checkLogin(data) {
        if (data.status == 401) {
            window.location.href = "{{url('login')}}";
        }
    }

    /**
     * Check token
     */
    function checkToken(token) {
        $.ajax({
            url: "{{url('api/auth/me')}}",
            type: 'get'
        }).done(function (response) {
            handleData(response);
        }).fail(function (err) {
            checkLogin(err);
            processErrors(err);
        });
    }

    /**
     * Process Error
     */
    function processErrors(data) {
        if (data.status == 422) {
            $.each(data.responseJSON.error.errors, function (key, value) {
                toastr["error"](value);
            });
        }
        if (data.status == 403) {
            toastr["error"](data.responseJSON.error.message);
        }
    }
</script>

</body>
</html>
