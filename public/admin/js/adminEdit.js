layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'upload'], function () {
    var form = layui.form, upload = layui.upload, $ = layui.jquery;
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
        post('adminEdit', data.field, function (data) {
            if (data) {
                if (200 == data.code) {
                    layer.msg('修改成功', {icon: 1, time: 2000});
                    setTimeout(function(){
                        parent.window.location.href='/admin/list';
                    },2000);
                } else {
                    return layer.msg(data.msg);
                }
            } else {
                return layer.msg('接口出错');
            }
        });
    });
})