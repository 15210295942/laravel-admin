layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'laypage'], function () {
    var form = layui.form, layer = parent.layer === undefined ? layui.layer : parent.layer, laypage = layui.laypage,
        $ = layui.jquery;
    /*$(".search_btn").click(function () {
     var newArray = [];
     if ($(".search_input").val() != '') {
     var index = layer.msg('查询中，请稍候', {icon: 16, time: false, shade: 0.8});
     setTimeout(function () {
     $.ajax({
     url: "../../json/newsList.json", type: "get", dataType: "json", success: function (data) {
     if (window.sessionStorage.getItem("addNews")) {
     var addNews = window.sessionStorage.getItem("addNews");
     newsData = JSON.parse(addNews).concat(data);
     } else {
     newsData = data;
     }
     for (var i = 0; i < newsData.length; i++) {
     var newsStr = newsData[i];
     var selectStr = $(".search_input").val();

     function changeStr(data) {
     var dataStr = '';
     var showNum = data.split(eval("/" + selectStr + "/ig")).length - 1;
     if (showNum > 1) {
     for (var j = 0; j < showNum; j++) {
     dataStr += data.split(eval("/" + selectStr + "/ig"))[j] + "<i style='color:#03c339;font-weight:bold;'>" + selectStr + "</i>";
     }
     dataStr += data.split(eval("/" + selectStr + "/ig"))[showNum];
     return dataStr;
     } else {
     dataStr = data.split(eval("/" + selectStr + "/ig"))[0] + "<i style='color:#03c339;font-weight:bold;'>" + selectStr + "</i>" + data.split(eval("/" + selectStr + "/ig"))[1];
     return dataStr;
     }
     }

     if (newsStr.newsName.indexOf(selectStr) > -1) {
     newsStr["newsName"] = changeStr(newsStr.newsName);
     }
     if (newsStr.newsAuthor.indexOf(selectStr) > -1) {
     newsStr["newsAuthor"] = changeStr(newsStr.newsAuthor);
     }
     if (newsStr.newsStatus.indexOf(selectStr) > -1) {
     newsStr["newsStatus"] = changeStr(newsStr.newsStatus);
     }
     if (newsStr.newsLook.indexOf(selectStr) > -1) {
     newsStr["newsLook"] = changeStr(newsStr.newsLook);
     }
     if (newsStr.newsTime.indexOf(selectStr) > -1) {
     newsStr["newsTime"] = changeStr(newsStr.newsTime);
     }
     if (newsStr.newsName.indexOf(selectStr) > -1 || newsStr.newsAuthor.indexOf(selectStr) > -1 || newsStr.newsStatus.indexOf(selectStr) > -1 || newsStr.newsLook.indexOf(selectStr) > -1 || newsStr.newsTime.indexOf(selectStr) > -1) {
     newArray.push(newsStr);
     }
     }
     newsData = newArray;
     newsList(newsData);
     }
     })
     layer.close(index);
     }, 2000);
     } else {
     layer.msg("请输入需要查询的内容");
     }
     })*/ //搜索
    $(".adminAdd").click(function () {
        var index = layui.layer.open({
            title: "添加管理员",
            type: 2,
            content: "adminAdd",
            success: function (layero, index) {
                layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
            }
        })
        $(window).resize(function () {
            layui.layer.full(index);
        })
        layui.layer.full(index);
    })
    $(".editUser").click(function () {
        var id = $(this).attr('data-id');
        var index = layui.layer.open({
            title: "修改管理员",
            type: 2,
            content: "adminEdit?id=" + id,
            success: function (layero, index) {
                layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
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
            post('adminRemove', {id: _this.attr('data-id')}, function (data) {
                if (data) {
                    if (200 == data.code) {
                        layer.msg('删除成功', {icon: 1, time: 2000});
                        setTimeout(function () {
                            window.location.href = '/admin/list';
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