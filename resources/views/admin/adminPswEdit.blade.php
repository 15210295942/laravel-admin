<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>修改密码</title>
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
				<legend>修改</legend>
			</fieldset>
			<form action="" method="post" name="listform" class="layui-form layui-form-pane">
				<div class="layui-tab-content">
					<div class="layui-tab-item layui-show">
						<div class="layui-form-item">
							<label class="layui-form-label">原始密码</label>
							<div class="layui-input-block">
								<input name="password"   autocomplete="off" value="" lay-verify="required"  placeholder="6~18密码" class="layui-input" type="password">
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label">新密码</label>
							<div class="layui-input-block">
								<input name="newPassword"   autocomplete="off" value="" lay-verify="newPassword" placeholder="6~18密码" class="layui-input" type="password">
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label">重复新密码</label>
							<div class="layui-input-block">
								<input name="confirmPassword"   autocomplete="off" value="" lay-verify="confirm_password" placeholder="6~18密码" class="layui-input" type="password">
							</div>
						</div>
					</div>
				</div>
				<div class="page-footer">
					<div class="btn-list">
						<div class="btnlist"style="position: absolute;left: 25px;">
							<button class="layui-btn" lay-submit lay-filter="from_submit" >立即提交</button>
						</div>
					</div>
				</div>

			</form>

		</div>
		<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
		<script src="{{asset('static/js/common_admin.js')}}"></script>
        <script>
            layui.use(['layer','form'],function () {
                var layer = layui.layer,
                        $ = layui.jquery,
                        form = layui.form();
                //自定义验证规则
                form.verify({
                    newPassword:function (value) {
                        if (value.length<6 || value.length>18) {
                            return '新密码长度在6~18位之间';
                        }
                    },
                    confirm_password:function (value) {
                        if (value !=$("input[name=newPassword]").val() ) {
                            return '两次密码不一致';
                        }
                    }
                });
                var url = '/admin/userAdmin/userUpPassword'+'{{isset($id)?"/$id":""}}';
                form.on('submit(from_submit)',function(data){
                    var index;
                    $.ajax({
                        url:url,
                        type:'post',
                        dataType:'json',
                        data:{
                            password:data.field.password,
                            newPassword:data.field.newPassword,
                            password_confirmation :data.field.confirmPassword,
                            _token:"{{csrf_token()}}"
                        },
                        success:function (data) {
                            if (data == null) {
                                layer.msg('服务端错误', {icon: 2, time: 2000});
                                return;
                            }
                            if (data.status == 0) {
								layer.msg(data.message, {icon: 1, time: 2000});
                                layer.close(index);
                                return;
                            }
                            if (data.status == 2) {
								layer.msg(data.message, {icon: 2, time: 2000});
								layer.close(index);
								return;
                            }
                            if (data.status == 1) {
								layer.msg(data.message, {icon: 2, time: 2000});
								layer.close(index);
								return;
                            }

                        },error:function (xhr, status, error) {
                            layer.msg('ajax error', {icon: 2, time: 2000});
                            layer.close(index);
                        },beforeSend:function (xhr) {
                            index = layer.load(0, {shade: false});
                        }
                    });
                    return false;//禁用掉表单的提交功能,强制使用
                });
            })
        </script>
	</body>

</html>