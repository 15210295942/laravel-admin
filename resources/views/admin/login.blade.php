<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('blogCommon.web.title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/uploads/photo/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="{{asset('plugin/layui/css/layui.css')}}" media="all"/>
    <link rel="stylesheet" href="{{asset('admin/css/login.css')}}"/>
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/http.js') }}"></script>
</head>
<body class="beg-login-bg">
<div class="beg-login-box">
    <header>
        <h1>管理登录</h1>
    </header>
    <div class="beg-login-main">
        <form action="javascript:;" class="layui-form" method="post">
            <div class="layui-form-item">
                <label class="beg-login-icon">
                    <i class="layui-icon">&#xe612;</i>
                </label>

                <input type="text" name="userName" value="" autocomplete="off" placeholder="请输入登录名" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="beg-login-icon">
                    <i class="layui-icon">&#xe642;</i>
                </label>
                <input type="password" name="psw" value="" autocomplete="off" placeholder="请输入登录密码" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="beg-login-icon">
                    <i class="layui-icon">&#xe642;</i>
                </label>
                <input type="text" name="codeGoogle" autocomplete="false" placeholder="请输入验证码" style=" float:left; width: 60%" class="layui-input"/>
                <img class="verify_code" style="width: 38%;height: 37px;float: right;" id="getCodeByG" src="/tools/getCaptcha" alt="captcha"><br/><br/>
            </div>
            <div class="layui-form-item">
                <div class="beg-pull-right">
                    <button id="submit-btn" class="layui-btn layui-btn-warm layui-btn-radius">
                        <i class="layui-icon">&#xe650;</i> 登录
                    </button>
                </div>
                <div class="beg-clear"></div>
            </div>
        </form>
    </div>
    <footer>
        {{--<p>不爱吃鱼的猫、</p>--}}
    </footer>
</div>
<!-- End #login-wrapper -->
<div id="loading"></div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        $('#submit-btn').click(function () {
            var uname = $('input[name="userName"]').val();
            var psw = $('input[name="psw"]').val();
            var codeGoogle = $('input[name="codeGoogle"]').val();
            post('login', {uname: uname, psw: psw, codeGoogle: codeGoogle}, function (data) {
                if (data) {
                    if (200 == data.code) {
                        window.location.href = 'index';
                    } else {
                        alert(data.msg);
                        return false;
                    }
                } else {
                    alert('接口出错');
                    return false;
                }
            });
        });
        //验证码
        $("#getCodeByG").click(function(){
            $(this).attr("src",'/tools/getCaptcha?' + Math.random());
        });
    });

</script>
</body>
</html>
