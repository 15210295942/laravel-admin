<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trans('blogCommon.web.title') }}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/uploads/photo/favicon.ico">
    <link rel="stylesheet" href="{{ asset('plugin/layui/css/layui.css') }}" media="all"/>
    <link rel="stylesheet" href="{{ asset('admin/css/font_eolqem241z66flxr.css') }}" media="all"/>
    <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}" media="all"/>
</head>
<style>
    .container_3c6APS_.textCenter_1KzIPcR.weakText_3WcXGdI.baseText_dqsVpMD.copyright_2Ob_0Cg{display: none}
</style>
<body class="main_body">
<div class="layui-layout layui-layout-admin">

    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo">后台管理</a>
            <input type="hidden" id="menuList" value="{{ $menu }}"/>
            <div class="weather" pc>
                <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
                <script>tpwidget("init", {
                        "flavor": "bubble",
                        "location": "WTW3SJ5ZBJUY",
                        "geolocation": "disabled",
                        "position": "top-left",
                        "margin": "3px 138px",
                        "language": "zh-chs",
                        "unit": "c",
                        "theme": "chameleon",
                        "uid": "UC1AEC9E02",
                        "hash": "40fc81924542888fcfeaa6c8acabd406"
                    });
                    tpwidget("show");
                    var navs = JSON.parse(document.getElementById('menuList').value);
                </script>
            </div>

            <ul class="layui-nav top_menu">
                {{--<li class="layui-nav-item showNotice" id="showNotice" pc>
                    <a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
                </li>--}}
                {{--<li class="layui-nav-item" mobile>--}}
                {{--<a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>设置</cite></a>--}}
                {{--</li>--}}
                <li class="layui-nav-item" mobile>
                    <a href="/admin/logout"><i class="iconfont icon-loginout"></i> 退出</a>
                </li>
                <li class="layui-nav-item lockcms" pc>
                    <a href="javascript:;"><i class="iconfont icon-lock1"></i><cite>锁屏</cite></a>
                </li>
                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="{{ session('adminUser.userPhoto') }}" class="layui-circle" width="35" height="35">
                        <cite>{{ session('adminUser.userName') }}</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a>
                        </dd>
                        <dd><a href="/admin/logout"><i class="iconfont icon-loginout"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="user-photo">
            <a class="img" title="我的头像"><img src="{{ session('adminUser.userPhoto') }}"></a>
            <p>你好！<span class="userName">{{ session('adminUser.userName') }}</span>, 欢迎登录</p>
        </div>
        <div class="navBar layui-side-scroll"></div>
    </div>

    <div class="layui-body layui-form">
        <div class="layui-tab marg0" lay-filter="bodyTab">
            <ul class="layui-tab-title top_tab">
                <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="/admin/welcome"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
{{--<a onclick="donation()" class="layui-btn layui-btn-danger l·ayui-btn-small">捐赠作者</a>--}}
<div class="admin-header-lock" id="lock-box" style="display: none;">
    <div class="admin-header-lock-img"><img src="{{ session('adminUser.userPhoto') }}"/></div>
    <div class="admin-header-lock-name" id="lockUserName">{{ session('adminUser.userName') }}</div>
    <div class="input_btn">
        <input type="password" class="admin-header-lock-input layui-input" placeholder="请输入密码解锁.." name="lockPwd"
               id="lockPwd"/>
        <button class="layui-btn" id="unlock">解锁</button>
    </div>
    <p>请输入密码，否则不会解锁成功哦！！！</p>
</div>

<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>
<script type="text/javascript" src="{{ asset('plugin/layui/layui.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/leftNav.js') }}"></script>
<script type="text/javascript" src="/admin/js/index.js"></script>
{{--<script type="text/javascript" src="//idm-su.baidu.com/su.js"></script>--}}
</body>
</html>