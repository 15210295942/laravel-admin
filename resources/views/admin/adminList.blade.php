<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>{{trans('back/userinfo.userList')}}</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">

	<link rel="stylesheet" href="{{asset('plugin/layui/css/layui.css')}}" media="all" />
	<link rel="stylesheet" href="{{asset('plugin/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/css.css')}}">
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
				<button class="layui-btn addUserAdmin" >立即添加</button>
                </span>
			</li>
		</ul>
	</div>
	<table class="layui-table">
		<colgroup>
			<col width="150">
			<col width="150">
			<col width="250">
			<col>
			<col  width="250">
		</colgroup>
		<thread>
			<tr>
				<th>ID</th>
				<th>用户名</th>
				<th>上次登录时间</th>
				<th>上次登录IP</th>
				<th>创建时间</th>
				<th>操作 </th>
			</tr>
		</thread>
		<tbody>
		{{--{{ $admins }}--}}
		@foreach($adminList as $admin)
			<tr>
				<td>{{$admin->ad_id}} </td>
				<td>{{$admin->ad_userName}} </td>
				<td>
					@if($admin->ad_loginTime!=0)
						{{ date('Y-m-d H:i:s', $admin->ad_loginTime)}}
					@else
						--
					@endif
				</td>
				<td>{{$admin->ad_loginIp}}</td>
				<td>
					@if($admin->createTime!=0)
						{{ date('Y-m-d H:i:s', $admin->createTime)}}
					@else
						--
					@endif
				</td>
				<td>

					{{--<span data-id="{{$admin->ad_id}}" class="layui-btn layui-btn-mini editUser">编辑</span>--}}
					{{--<span data-id="{{$admin->ad_id}}" class="layui-btn layui-btn-mini editPass">修改密码</span>--}}
					<span data-id="{{$admin->ad_id}}" class="layui-btn layui-btn-danger del layui-btn-mini">删除</span>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div style="display:none;">
		<script type="text/javascript">
			var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
			document.write(unescape("%3Cspan id='cnzz_stat_icon_1262896806'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/z_stat.php%3Fid%3D1262896806%26show%3Dpic1 ' type='text/javascript'%3E%3C/script%3E"));
		</script>
	</div>
</div>
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('static/js/common_admin.js')}}"></script>
<script>
    layui.use(['layer'],function () {
        var $ = layui.jquery,t = layui.jquery,e = layui.layer;
        var csrf_token =t('meta[name=csrf-token]').attr('content');

        t(".handle-item").on("click", ".addUserAdmin", function () {
            layer_show("添加", "/admin/userAdmin/create", "", "800", "600")
        });
        /*t(".layui-table").on("click", ".editUser", function () {
            var id = t(this).attr('data-id');
            layer_show("编辑", '/admin/userAdmin/'+id+'/edit', "", "800", "600")
        });*/
        /*t(".layui-table").on("click", ".editPass", function () {
            var id = t(this).attr('data-id');
            layer_show("修改密码", '/admin/userAdmin/userUpPassword/'+id, "", "800", "600")
        });*/
        t(".layui-table").on("click", ".del", function () {
            var n = t(this);
            var id = t(this).attr('data-id');
            e.confirm("确认要删除吗？", {icon: 0, title: "警告", shade: !1}, function (a) {
                $.ajax({
                    url: '/admin/userAdmin/destroy',
                    data: {'id': id},
                    type: 'get',
                    success: function (data) {
                        layer.msg(data.messages);
                        layer.close(index);
                        return false;
                    }
                });
                //$(n).parents("tr").remove(), e.msg("已删除!", {icon: 1, time: 1e3})
            })
        });

	});
</script>
</body>

</html>