<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>{{ trans('blogCommon.web.title') }}</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="{{asset('plugin/layui/css/layui.css')}}" media="all" />
	<link rel="stylesheet" href="{{asset('plugin/font-awesome/css/font-awesome.min.css')}}">
{{--	<link rel="stylesheet" href="{{asset('css/css.css')}}">--}}
</head>

<body>
<div style="margin: 15px;">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
		<legend>管理员列表</legend>
	</fieldset>
	<div class="handle-box">
		<ul>
			<li class="handle-item" style="float: right;margin-bottom: 5px">
                <span class="fr">
                    <a class="layui-btn" id="refresh">刷新</a>
				<button class="layui-btn adminAdd" >立即添加</button>
                </span>
			</li>
		</ul>
	</div>
	<table class="layui-table">
		<thread>
			<tr>
				<th>ID</th>
				<th>用户名</th>
				<th>头像</th>
				{{--<th>上次登录时间</th>--}}
				<th>上次登录IP</th>
				<th>操作 </th>
			</tr>
		</thread>
		<tbody>
		@foreach($list as $admin)
			<tr>
				<td>{{$admin['id']}} </td>
				<td>{{$admin['userName']}} </td>
				<td><img src="{{ $admin['userPhoto'] }}" width="50px" height="50px" /></td>
				<td>{{$admin['loginIp']}}</td>
				<td>

					{{--<span data-id="{{$admin->ad_id}}" class="layui-btn layui-btn-mini editUser">编辑</span>--}}
					{{--<span data-id="{{$admin->ad_id}}" class="layui-btn layui-btn-mini editPass">修改密码</span>--}}
					<span data-id="{{$admin['id']}}" class="layui-btn layui-btn-danger del layui-btn-mini">删除</span>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/common_admin.js')}}"></script>
<script src="{{asset('admin/js/adminList.js')}}"></script>
</body>

</html>