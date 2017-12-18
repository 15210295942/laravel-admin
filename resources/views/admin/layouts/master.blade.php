<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
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
<body>
<div id="body-wrapper">
    <!-- Wrapper for the radial gradient background -->
    @section('sidebar')
        <div id="sidebar">
            <div id="sidebar-wrapper">
                <!-- Sidebar Profile links -->
                <div id="profile-links"> Hello, @yield('adminName')<br/>
                    <br/>
                    <a href="/admin/logout" title="Sign Out">退出登录</a>
                </div>
                <ul id="main-nav">
                    <!-- Accordion Menu -->
                    <li id="stu-mng">
                        <a href="#" class="nav-top-item">
                            <!-- Add the class "current" to current menu item -->
                            学生管理 </a>
                        <ul>
                            <li class="stu_list"><a href="/admin/stu/list">查看学生</a></li>
                            <li class="stu_import"><a href="/admin/stu/import">导入学生</a></li>
                            <li class="stu_add"><a href="/admin/stu/add">添加学生</a></li>
                        </ul>
                    </li>
                    <li id="setting-mng">
                        <a href="#" class="nav-top-item">
                            <!-- Add the class "current" to current menu item -->
                            设置 </a>
                        <ul>
                            <li class="payRange"><a href="/admin/payRange">缴费设置</a></li>
                            <li class="school"><a href="/admin/school">学校设置</a></li>
                            <li class="config_info"><a href="/admin/config/info">导入截止设置</a></li>
                            <li class="admin_list"><a href="/admin/list">管理员设置</a></li>
                            <li class="psw"><a href="/admin/psw">修改密码</a></li>
                        </ul>
                    </li>
                    <li id="finance-mng">
                        <a href="#" class="nav-top-item">
                            <!-- Add the class "current" to current menu item -->
                            财务管理 </a>
                        <ul>
                            <li class="notPaid"><a href="/admin/stu/report?showForm=0&isPaid=0">欠缴清单</a></li>
                            <li class="report"><a href="/admin/stu/report">报表</a></li>
                        </ul>
                    </li>
                    <li id="recipe-mng">
                        <a href="#" class="nav-top-item">
                            <!-- Add the class "current" to current menu item -->
                            菜谱管理 </a>
                        <ul>
                            <li class="package_list"><a href="/admin/package/list">套餐列表</a></li>
                            <li class="package_add"><a href="/admin/package/add">添加套餐</a></li>
                            <li class="recipe_list"><a href="/admin/recipe/list">菜谱列表</a></li>
                            <li class="recipe_add"><a href="/admin/recipe/add">添加菜谱</a></li>

                        </ul>
                    </li>
                </ul>
                <!-- End #main-nav -->

            </div>
        </div>
        <!-- End #sidebar -->
    @show
    <div id="main-content">
        <!-- Main Content Section with everything -->
        <noscript>
            <!-- Show a notification if the user has disabled javascript -->
            <div class="notification error png_bg">
                <div> Javascript is disabled or is not supported by your browser. Please <a
                            href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser
                    or <a href="http://www.google.com/support/bin/answer.py?answer=23852"
                          title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface
                    properly.
                    Download From <a href="http://www.exet.tk">exet.tk</a></div>
            </div>
        </noscript>


        <!-- End .clear -->
        <div class="content-box" style="min-height: 500px; min-width: 1000px;">
            @yield('content')
        </div>


        <!-- End .content-box -->
        <div class="clear"></div>
        <div id="footer">
            <small>
                <!-- Remove this notice or replace it with whatever you want -->
                &#169; Copyright 2017 谷丰年 | <a href="#">Top</a>
            </small>
            <a href="http://www.guphoner.com/" target="_blank">www.guphoner.com</a></div>
        <!-- End #footer -->
    </div>
    <!-- End #main-content -->
</div>
<div id="loading"></div>
</body>
</html>
