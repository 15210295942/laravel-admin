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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/uploads/photo/favicon.ico">
    <link rel="stylesheet" href="{{asset('plugin/layui/css/layui.css')}}" media="all"/>
    <link rel="stylesheet" href="{{asset('plugin/font-awesome/css/font-awesome.min.css')}}">
</head>

<body>
<div style="margin: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>@yield('title')</legend>
    </fieldset>
    <div class="handle-box">
        @yield('navUl')
    </div>
    @yield('table')
</div>
{{--<script src="{{asset('admin/js/common_admin.js')}}"></script>--}}
<script type="text/javascript" src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/http.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>

</html>