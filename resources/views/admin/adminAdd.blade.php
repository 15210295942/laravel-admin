<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加管理员</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/plugin/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/plugin/font-awesome/css/font-awesome.min.css">
</head>

<body>
<div style="margin: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加</legend>
    </fieldset>

    <form class="layui-form" action="" enctype="multipart/form-data" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>用户名</label>
            <div class="layui-input-block">
                <input type="text" name="ad_userName" lay-verify="name" autocomplete="off" placeholder="请输入用户名"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" lay-verify="pass" autocomplete="off" placeholder="请输入密码"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>重复密码</label>
            <div class="layui-input-block">
                <input type="password" name="password_confirmation" lay-verify="com_pass" autocomplete="off"
                       placeholder="请输入重复密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/plugin/layui/layui.js"></script>
<script src="/admin/js/common_admin.js"></script>
<script>
    layui.use(['form'], function () {
        var form = layui.form(),
            layer = layui.layer,
            $ = layui.jquery;
        var index;
        //自定义验证规则
        form.verify({
            com_pass: function (value) {
                console.log(value);
                if (value != $("input[name=password]").val()) {
                    return '两次密码不一致';
                }
            }
        });
        //监听提交
        form.on('submit(demo1)', function (data) {
            data.field._token = "{{csrf_token()}}";
            var url = '/admin/userAdmin/addSave';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data.field,
                success: function (data) {
                    if (data == null) {
                        layer.msg('服务端错误', {icon: 2, time: 2000});
                        return;
                    }
                    if (data.status == 1) {
                        var obj = data.messages;
                        if (obj) {
                            for(var i in obj){//用javascript的for/in循环遍历对象的属性
                                msg = obj[i][0];
                                layer.msg(msg , {icon: 2, time: 2000});
                                break;
                            }
                        }
                        layer.close(index);
                        return false;
                    }
                    if (data.status == 3) {
                        layer.msg(data.messages);
                        setTimeout(function(){
                            layer_close();
                            parent.window.location.href="/admin/userAdmin/index";
                        },2000)
                    }
                    if (data.status == 2) {
                        layer.msg(data.messages);
                        layer.close(index);
                        return false;
                    }
                }, error: function (xhr, status, error) {
                    layer.msg('ajax error', {icon: 2, time: 2000});
                    layer.close(index);
                }, beforeSend: function (xhr) {
                    index = layer.load(0, {shade: false});
                }
            });
            return false;
        });
    });

</script>
</body>

</html>