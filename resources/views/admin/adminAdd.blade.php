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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/plugin/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/plugin/font-awesome/css/font-awesome.min.css">
</head>

<body>
<div style="margin: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加管理员</legend>
    </fieldset>

    <form class="layui-form" action="javascript:;" enctype="multipart/form-data" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>用户名</label>
            <div class="layui-input-block">
                <input type="text" name="userName" lay-verify="required" autocomplete="off" placeholder="请输入用户名"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>密码</label>
            <div class="layui-input-block">
                <input type="password" name="pswO" autocomplete="off" placeholder="请输入密码"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>重复密码</label>
            <div class="layui-input-block">
                <input type="password" name="pswT" lay-verify="passCheck" autocomplete="off"
                       placeholder="请输入重复密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-upload">
            <label class="layui-form-label"><span style="color: red">*</span>头像</label>
            <div class="layui-input-block">
                <input type="file" name="file" class="layui-upload-file uploadFile">
                <img alt="" id="photoShow" width="200px" height="200px"/> <br>
                <div class="site-demo-upbar">
                    <button type="button" class="layui-btn  layui-btn-primary"
                            {{-- style="background-color: white"--}} id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <input type="hidden" name="userPhoto" lay-verify="required" value="">
                </div>
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
<script type="text/javascript" src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/http.js') }}"></script>
<script>
    layui.use(['form', 'upload'], function () {
        var form = layui.form,
            layer = layui.layer,
            upload = layui.upload,
            $ = layui.jquery;
        var index;
        $.ajaxSetup({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });
        //自定义验证规则
        form.verify({
            passCheck: function (value) {
                if (value != $("input[name=pswO]").val()) {
                    return '两次密码不一致';
                }
            }
        });
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: '/tools/uploadPhoto'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#photoShow').attr('src', result); //图片链接（base64）
                });
//                request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            }
            , done: function (res) {
                //如果上传失败
                if (false == res.img) {
                    return layer.msg('上传失败');
                }
                //上传成功
                $('input[name="userPhoto"]').val(res.img);
                return layer.msg('上传成功');
            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
        //监听提交
        form.on('submit(demo1)', function (data) {
            post('adminAdd', data.field, function (data) {
                if (data) {
                    if (200 == data.code) {
                        layer.msg('添加成功', {icon: 1, time: 2000});
                        setTimeout(function(){
                            window.location.href='/admin/list';
                        },2000);
                    } else {
                        return layer.msg(data.msg);
                    }
                } else {
                    return layer.msg('接口出错');
                }
            });
        });
    });

</script>
</body>

</html>