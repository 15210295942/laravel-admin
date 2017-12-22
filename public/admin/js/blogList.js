layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'laypage'], function () {
    var form = layui.form(), layer = parent.layer === undefined ? layui.layer : parent.layer, laypage = layui.laypage,
        $ = layui.jquery;
    var newsData = '';
    $.get("../../json/newsList.json", function (data) {
        var newArray = [];
        if ($(".top_tab li.layui-this cite", parent.document).text() == "待审核文章") {
            if (window.sessionStorage.getItem("addNews")) {
                var addNews = window.sessionStorage.getItem("addNews");
                newsData = JSON.parse(addNews).concat(data);
            } else {
                newsData = data;
            }
            for (var i = 0; i < newsData.length; i++) {
                if (newsData[i].newsStatus == "待审核") {
                    newArray.push(newsData[i]);
                }
            }
            newsData = newArray;
            newsList(newsData);
        } else {
            newsData = data;
            if (window.sessionStorage.getItem("addNews")) {
                var addNews = window.sessionStorage.getItem("addNews");
                newsData = JSON.parse(addNews).concat(newsData);
            }
            newsList();
        }
    })
    $(".search_btn").click(function () {
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
    })
    $(".newsAdd_btn").click(function () {
        var index = layui.layer.open({
            title: "添加文章",
            type: 2,
            content: "newsAdd.html",
            success: function (layero, index) {
                layui.layer.tips('点击此处返回文章列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
            }
        })
        $(window).resize(function () {
            layui.layer.full(index);
        })
        layui.layer.full(index);
    })
    $(".recommend").click(function () {
        var $checkbox = $(".news_list").find('tbody input[type="checkbox"]:not([name="show"])');
        if ($checkbox.is(":checked")) {
            var index = layer.msg('推荐中，请稍候', {icon: 16, time: false, shade: 0.8});
            setTimeout(function () {
                layer.close(index);
                layer.msg("推荐成功");
            }, 2000);
        } else {
            layer.msg("请选择需要推荐的文章");
        }
    })
    $(".audit_btn").click(function () {
        var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
        if ($checkbox.is(":checked")) {
            var index = layer.msg('审核中，请稍候', {icon: 16, time: false, shade: 0.8});
            setTimeout(function () {
                for (var j = 0; j < $checked.length; j++) {
                    for (var i = 0; i < newsData.length; i++) {
                        if (newsData[i].newsId == $checked.eq(j).parents("tr").find(".news_del").attr("data-id")) {
                            $checked.eq(j).parents("tr").find("td:eq(3)").text("审核通过").removeAttr("style");
                            $checked.eq(j).parents("tr").find('input[type="checkbox"][name="checked"]').prop("checked", false);
                            form.render();
                        }
                    }
                }
                layer.close(index);
                layer.msg("审核成功");
            }, 2000);
        } else {
            layer.msg("请选择需要审核的文章");
        }
    })
    $(".batchDel").click(function () {
        var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
        if ($checkbox.is(":checked")) {
            layer.confirm('确定删除选中的信息？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                setTimeout(function () {
                    for (var j = 0; j < $checked.length; j++) {
                        for (var i = 0; i < newsData.length; i++) {
                            if (newsData[i].newsId == $checked.eq(j).parents("tr").find(".news_del").attr("data-id")) {
                                newsData.splice(i, 1);
                                newsList(newsData);
                            }
                        }
                    }
                    $('.news_list thead input[type="checkbox"]').prop("checked", false);
                    form.render();
                    layer.close(index);
                    layer.msg("删除成功");
                }, 2000);
            })
        } else {
            layer.msg("请选择需要删除的文章");
        }
    })
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
    form.on("checkbox(choose)", function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
        var childChecked = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"]):checked')
        if (childChecked.length == child.length) {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
        } else {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    })
    form.on('switch(isShow)', function (data) {
        var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
        setTimeout(function () {
            layer.close(index);
            layer.msg("展示状态修改成功！");
        }, 2000);
    })
    $("body").on("click", ".news_edit", function () {
        layer.alert('您点击了文章编辑按钮，由于是纯静态页面，所以暂时不存在编辑内容，后期会添加，敬请谅解。。。', {icon: 6, title: '文章编辑'});
    })
    $("body").on("click", ".news_collect", function () {
        if ($(this).text().indexOf("已收藏") > 0) {
            layer.msg("取消收藏成功！");
            $(this).html("<i class='layui-icon'>&#xe600;</i> 收藏");
        } else {
            layer.msg("收藏成功！");
            $(this).html("<i class='iconfont icon-star'></i> 已收藏");
        }
    })
    $("body").on("click", ".news_del", function () {
        var _this = $(this);
        layer.confirm('确定删除此信息？', {icon: 3, title: '提示信息'}, function (index) {
            for (var i = 0; i < newsData.length; i++) {
                if (newsData[i].newsId == _this.attr("data-id")) {
                    newsData.splice(i, 1);
                    newsList(newsData);
                }
            }
            layer.close(index);
        });
    })
    function newsList(that) {
        function renderDate(data, curr) {
            var dataHtml = '';
            if (!that) {
                currData = newsData.concat().splice(curr * nums - nums, nums);
            } else {
                currData = that.concat().splice(curr * nums - nums, nums);
            }
            if (currData.length != 0) {
                for (var i = 0; i < currData.length; i++) {
                    dataHtml += '<tr>'
                        + '<td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>'
                        + '<td align="left">' + currData[i].newsName + '</td>'
                        + '<td>' + currData[i].newsAuthor + '</td>';
                    if (currData[i].newsStatus == "待审核") {
                        dataHtml += '<td style="color:#f00">' + currData[i].newsStatus + '</td>';
                    } else {
                        dataHtml += '<td>' + currData[i].newsStatus + '</td>';
                    }
                    dataHtml += '<td>' + currData[i].newsLook + '</td>'
                        + '<td><input type="checkbox" name="show" lay-skin="switch" lay-text="是|否" lay-filter="isShow"' + currData[i].isShow + '></td>'
                        + '<td>' + currData[i].newsTime + '</td>'
                        + '<td>'
                        + '<a class="layui-btn layui-btn-mini news_edit"><i class="iconfont icon-edit"></i> 编辑</a>'
                        + '<a class="layui-btn layui-btn-normal layui-btn-mini news_collect"><i class="layui-icon">&#xe600;</i> 收藏</a>'
                        + '<a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="' + data[i].newsId + '"><i class="layui-icon">&#xe640;</i> 删除</a>'
                        + '</td>'
                        + '</tr>';
                }
            } else {
                dataHtml = '<tr><td colspan="8">暂无数据</td></tr>';
            }
            return dataHtml;
        }

        var nums = 13;
        if (that) {
            newsData = that;
        }
        laypage({
            cont: "page", pages: Math.ceil(newsData.length / nums), jump: function (obj) {
                $(".news_content").html(renderDate(newsData, obj.curr));
                $('.news_list thead input[type="checkbox"]').prop("checked", false);
                form.render();
            }
        })
    }
})