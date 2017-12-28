layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'upload'], function () {
    var form = layui.form, upload = layui.upload, $ = layui.jquery;
    var index;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //监听提交
    form.on('submit(demo1)', function (data) {
        post('/admin/menu/edit', data.field, function (data) {
            if (data) {
                if (200 == data.code) {
                    layer.msg('修改成功', {icon: 1, time: 2000});
                    setTimeout(function(){
                        parent.window.location.href='/admin/menu/list';
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