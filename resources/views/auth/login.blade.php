<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/plugins/iCheck/square/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{url("public/vendor/adminlte")}}/bower_components/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{url("public/vendor/adminlte")}}/index2.html">LOGIN</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form id="loginForm" action="{{url("api/auth/login")}}" method="post">
            <div class="form-group has-feedback">
                <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
<!-- iCheck -->
<script src="{{url("public/vendor/adminlte")}}/plugins/iCheck/icheck.min.js"></script>
<script src="{{url("public/vendor/adminlte")}}/bower_components/toastr/toastr.min.js"></script>
<script>
    $(function(){
        checkToken(window.sessionStorage.token);
        $('input').iCheck({
            checkboxClass:'icheckbox_square-blue',
            radioClass   :'iradio_square-blue',
            increaseArea :'20%' // optional
        });
    });
    $('#loginForm').submit(function(event){
        event.preventDefault();
        var $form = $(this);
        var email = $form.find("input[name='email']").val();
        var password = $form.find("input[name='password']").val();
        url = $form.attr("action");
        if(getRedirect() != null){
            url += '?redirect=' + getRedirect();
        }
        $.ajax({
            url    :url,
            type   :'post',
            data   :{
                email   :email,
                password:password
            },
            success:function(data, textStatus, jQxhr){
                console.log(jQxhr);
                toastr["success"](textStatus);
                window.sessionStorage.token = jQxhr.responseJSON.token;
                if(jQxhr.responseJSON.redirect != ''){
                    window.location.href = jQxhr.responseJSON.redirect;
                }else{
                    checkToken(window.sessionStorage.token);
                    window.location.href = '{{url('department')}}';
                }
            },
            error  :function(jqXhr, textStatus, errorThrown){
                console.log(jqXhr);
                if(jqXhr.status == 422){
                    $.each(jqXhr.responseJSON.error.errors, function(key, value){
                        toastr["error"](value);
                    });
                }
                if(jqXhr.status == 403){
                    toastr["error"](jqXhr.responseJSON.error.message);
                }
            }
        });
    });

    function checkToken(token){
        $.ajax({
            url       :"{{url('api/auth/me')}}",
            type      :'get',
            beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer ' + token);
            }
        }).done(function(response){
            console.log(response);
            {{--if (jQxhr.responseJSON.redirect != '') {--}}
            {{--window.location.href = jQxhr.responseJSON.redirect;--}}
            {{--} else {--}}
            {{--window.location.href = "{{url('department')}}";--}}
            {{--}--}}
        }).fail(function(err){
            processErrors(err);
        });
    }

    function getRedirect(){
        var url = new URL(window.location.href);
        var redirect = url.searchParams.get("redirect");
        return redirect;
    }
</script>
</body>
</html>
