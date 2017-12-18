<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>超的博客</title>
    <!--                       CSS                       -->
    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="{{ asset('admin/css/reset.css') }}" type="text/css" media="screen"/>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" type="text/css" media="screen"/>
    <!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
    <link rel="stylesheet" href="{{ asset('admin/css/invalid.css') }}" type="text/css" media="screen"/>
    <!--                       Javascripts                       -->
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('admin/scripts/jquery.min.js') }}"></script>
    <!-- jQuery Configuration -->
    <script type="text/javascript" src="{{ asset('admin/scripts/simpla.jquery.configuration.js') }}"></script>
    <!-- Facebox jQuery Plugin -->
    <script type="text/javascript" src="{{ asset('admin/scripts/facebox.js') }}"></script>
    <!-- jQuery WYSIWYG Plugin -->
    <script type="text/javascript" src="{{ asset('admin/scripts/jquery.wysiwyg.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/scripts/http.js') }}"></script>
    <style>
        #loading{
            background-color: rgba(0,0,0,.5);
            position: fixed;
            width: 100%;
            height: 100%;
            top:0;
            left:0;
            z-index: 1;
            background-image: url({{ asset('admin/images/loading.gif') }});
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50px;
            display: none;
        }
    </style>
</head>
<body id="login">
<div id="login-wrapper" class="png_bg">
    <div id="login-top">
        <h1>博客后台</h1>
        <!-- Logo (221px width) -->
        <a href="#"><img id="logo" style="width: 150px;" src="{{--{{ asset('admin/images/logo.png') }}--}}"
                         alt="Simpla Admin logo"/></a></div>
    <!-- End #logn-top -->
    <div id="login-content">
        <form method="POST" action="javascript:;" >
            <div class="notification information png_bg hide" style="display: none;">
                <div> Just click "Sign In". No password needed.</div>
            </div>
            <p>
                <label>用户名</label>
                <input name="userName" class="text-input" type="text"/>
            </p>
            <div class="clear"></div>
            <p>
                <label>密码</label>
                <input name="psw" class="text-input" type="password"/>
            </p>
            <div class="clear"></div>
            <p id="remember-password" style="display: none;">
                <input type="checkbox"/>
                Remember me </p>
            <div class="clear"></div>
            <p>
                <input id="submit-btn" class="button" type="submit" value="登录"/>
            </p>
        </form>
    </div>
    <!-- End #login-content -->
</div>
<!-- End #login-wrapper -->
<div id="loading"></div>
<script >
    $(function () {
        $('#submit-btn').click(function(){
            var uname = $('input[name="userName"]').val();
            var psw = $('input[name="psw"]').val();

            if (uname.length < 4 || psw.length < 6) {
                alert('请输入正确的用户名和密码');
                return false;
            }
            post('login',{uname: uname, psw: psw},function (data) {
                if(data){
                    if(200==data.code){
                        window.location.href = 'index';
                    }else {
                        alert('用户名或密码错误');
                        return false;
                    }
                } else {
                    alert('接口出错');
                    return false;
                }
            });
        });

    });

</script>
</body>
</html>
