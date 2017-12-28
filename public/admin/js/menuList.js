layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'laypage'], function () {
    var $ = layui.jquery;
    $(".menuAdd").click(function () {
        var index = layui.layer.open({
            title: "添加菜单",
            type: 2,
            content: "/admin/menu/add",
            success: function (layero, index) {
                layui.layer.tips('返回列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
            }
        })
        $(window).resize(function () {
            layui.layer.full(index);
        })
        layui.layer.full(index);
    })
    $(".editMenu").click(function () {
        var id = $(this).attr('data-id');
        var index = layui.layer.open({
            title: "修改菜单",
            type: 2,
            content: "/admin/menu/edit?id=" + id,
            success: function (layero, index) {
                layui.layer.tips('返回列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
            }
        })
        $(window).resize(function () {
            layui.layer.full(index);
        })
        layui.layer.full(index);
    })
    $("body").on("click", ".remove", function () {
        var _this = $(this);
        layer.confirm('确定删除此信息？', {icon: 3, title: '提示信息'}, function (index) {
            post('/admin/menu/remove', {id: _this.attr('data-id')}, function (data) {
                if (data) {
                    if (200 == data.code) {
                        layer.msg('删除成功', {icon: 1, time: 2000});
                        setTimeout(function () {
                            location.href = '/admin/menu/list';
                        }, 2000);
                    } else {
                        return layer.msg(data.msg);
                    }
                } else {
                    return layer.msg('接口出错');
                }
            });
            layer.close(index);
        });
    })
})