layui.config({base: "js/"}).use(['form', 'layer', 'jquery', 'laypage'], function () {
    var form = layui.form(), layer = parent.layer === undefined ? layui.layer : parent.layer, laypage = layui.laypage,
        $ = layui.jquery;
    var linksData = '';
    $.ajax({
        url: "../../json/linksList.json", type: "get", dataType: "json", success: function (data) {
            linksData = data;
            if (window.sessionStorage.getItem("addLinks")) {
                var addLinks = window.sessionStorage.getItem("addLinks");
                linksData = JSON.parse(addLinks).concat(linksData);
            }
            linksList();
        }
    })
    $(".search_btn").click(function () {
        var newArray = [];
        if ($(".search_input").val() != '') {
            var index = layer.msg('查询中，请稍候', {icon: 16, time: false, shade: 0.8});
            setTimeout(function () {
                $.ajax({
                    url: "../../json/linksList.json", type: "get", dataType: "json", success: function (data) {
                        if (window.sessionStorage.getItem("addLinks")) {
                            var addLinks = window.sessionStorage.getItem("addLinks");
                            linksData = JSON.parse(addLinks).concat(data);
                        } else {
                            linksData = data;
                        }
                        for (var i = 0; i < linksData.length; i++) {
                            var linksStr = linksData[i];
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

                            if (linksStr.linksName.indexOf(selectStr) > -1) {
                                linksStr["linksName"] = changeStr(linksStr.linksName);
                            }
                            if (linksStr.linksUrl.indexOf(selectStr) > -1) {
                                linksStr["linksUrl"] = changeStr(linksStr.linksUrl);
                            }
                            if (linksStr.showAddress.indexOf(selectStr) > -1) {
                                linksStr["showAddress"] = changeStr(linksStr.showAddress);
                            }
                            if (linksStr.linksName.indexOf(selectStr) > -1 || linksStr.linksUrl.indexOf(selectStr) > -1 || linksStr.showAddress.indexOf(selectStr) > -1) {
                                newArray.push(linksStr);
                            }
                        }
                        linksData = newArray;
                        linksList(linksData);
                    }
                })
                layer.close(index);
            }, 2000);
        } else {
            layer.msg("请输入需要查询的内容");
        }
    })
    $(".linksAdd_btn").click(function () {
        var index = layui.layer.open({
            title: "添加友情链接",
            type: 2,
            content: "linksAdd.html",
            success: function (layero, index) {
                layui.layer.tips('点击此处返回文章列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
            }
        })
        $(window).resize(function () {
            layui.layer.full(index);
        })
        layui.layer.full(index);
    })
    $(".batchDel").click(function () {
        var $checkbox = $('.links_list tbody input[type="checkbox"][name="checked"]');
        var $checked = $('.links_list tbody input[type="checkbox"][name="checked"]:checked');
        if ($checkbox.is(":checked")) {
            layer.confirm('确定删除选中的信息？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                setTimeout(function () {
                    for (var j = 0; j < $checked.length; j++) {
                        for (var i = 0; i < linksData.length; i++) {
                            if (linksData[i].linksId == $checked.eq(j).parents("tr").find(".links_del").attr("data-id")) {
                                linksData.splice(i, 1);
                                linksList(linksData);
                            }
                        }
                    }
                    $('.links_list thead input[type="checkbox"]').prop("checked", false);
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
        data.elem.checked;
        if (childChecked.length == child.length) {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
        } else {
            $(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    })
    $("body").on("click", ".links_edit", function () {
        layer.alert('您点击了友情链接编辑按钮，由于是纯静态页面，所以暂时不存在编辑内容，后期会添加，敬请谅解。。。', {icon: 6, title: '友链编辑'});
    })
    $("body").on("click", ".links_del", function () {
        var _this = $(this);
        layer.confirm('确定删除此信息？', {icon: 3, title: '提示信息'}, function (index) {
            for (var i = 0; i < linksData.length; i++) {
                if (linksData[i].linksId == _this.attr("data-id")) {
                    linksData.splice(i, 1);
                    linksList(linksData);
                }
            }
            layer.close(index);
        });
    })
    function linksList(that) {
        function renderDate(data, curr) {
            var dataHtml = '';
            if (!that) {
                currData = linksData.concat().splice(curr * nums - nums, nums);
            } else {
                currData = that.concat().splice(curr * nums - nums, nums);
            }
            if (currData.length != 0) {
                for (var i = 0; i < currData.length; i++) {
                    dataHtml += '<tr>'
                        + '<td><input type="checkbox" name="checked" lay-skin="primary" lay-filter="choose"></td>'
                        + '<td align="left">' + currData[i].linksName + '</td>'
                        + '<td><a style="color:#1E9FFF;" target="_blank" href="' + currData[i].linksUrl + '">' + currData[i].linksUrl + '</a></td>'
                        + '<td>' + currData[i].masterEmail + '</td>'
                        + '<td>' + currData[i].linksTime + '</td>'
                        + '<td>' + currData[i].showAddress + '</td>'
                        + '<td>'
                        + '<a class="layui-btn layui-btn-mini links_edit"><i class="iconfont icon-edit"></i> 编辑</a>'
                        + '<a class="layui-btn layui-btn-danger layui-btn-mini links_del" data-id="' + data[i].linksId + '"><i class="layui-icon">&#xe640;</i> 删除</a>'
                        + '</td>'
                        + '</tr>';
                }
            } else {
                dataHtml = '<tr><td colspan="7">暂无数据</td></tr>';
            }
            return dataHtml;
        }

        var nums = 13;
        if (that) {
            linksData = that;
        }
        laypage({
            cont: "page", pages: Math.ceil(linksData.length / nums), jump: function (obj) {
                $(".links_content").html(renderDate(linksData, obj.curr));
                $('.links_list thead input[type="checkbox"]').prop("checked", false);
                form.render();
            }
        })
    }
})