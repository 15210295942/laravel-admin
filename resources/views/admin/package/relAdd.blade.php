@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','添加菜谱')
@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .search-in {
            position: relative;
            height: 270px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ccc;
            width: 25%;
            padding: 10px;
            z-index: 10;
            display: none;
        }

        .search-in li {
            line-height: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
    <!-- Start Content Box -->
    <div class="content-box-header">
        <h3>添加套餐下的菜名</h3>
        <div class="clear"></div>
    </div>
    <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
            <div>
                <form id="form" method="POST">
                    <fieldset>
                        <p class="icons-list">
                            <label>套餐名称</label>
                            {{ $info['packageName'] }}
                        </p>
                        <p class="icons-list" style="padding-bottom: 0px">
                            <label>菜名</label>
                            <input class="text-input small-input menuSelect" type="text" list="tits" name="menuSelect"/>
                        <ul class="search-in">
                        </ul>
                        <input type="hidden" id="menuId" name="menuId"/>
                        <input type="hidden" class="form-control" name="packageId" value="{{ $info['id'] }}">
                        </p>

                        <p>
                            <label>排序</label>
                            <input class="text-input small-input" type="text" name="sortId" value="0"/>
                        </p>
                        <p>
                            <input type="hidden" name="building_id" id="building_id" value=""/>
                            <input id="sub-btn" class="button" type="button" value="确认"/>
                        </p>
                    </fieldset>
                    <div class="clear"></div>
                    <!-- End .clear -->
                </form>
            </div>

        </div>
        <!-- End #tab1 -->

    </div>
    <!-- End .content-box-content -->
    <script>
        $(function () {
            $('#recipe-mng .nav-top-item').addClass('current');
            $('#recipe-mng ul').css('display', 'block');
            $('#recipe-mng ul .package_add a').addClass('current');
            $('#sub-btn').click(function () {
                var formData = new FormData($('#form')[0]);
                if (formData.get('sortId') < 0) {
                    alert('请填写正确的菜单排序');
                    return;
                }
                if ('' === formData.get('menuId')) {
                    alert('请选择菜单');
                    return;
                }
                $('#loading').show();
                post('/admin/package/menu/add', {
                    id: formData.get('packageId'),
                    sortId: formData.get('sortId'),
                    menuId: formData.get('menuId')
                }, function (res) {
                    if (res.code === 200) {
                        alert('添加成功');
                        location.href = '/admin/package/menu/list?id=' + res.data.packageId;
                    } else {
                        alert(res.msg);
                        $('#loading').hide();
                    }
                });

            });
            // ajax实时获取菜单
            $('.menuSelect').bind('input porpertychange', function () {
                $('.search-in').css('display', 'block')
                var menuName = $.trim($(this).val());
                get('/admin/recipe/searchMenuAjax', {'q': menuName}, function (res) {
                    var span = '';
                    var i;
                    if (res) {
                        for (i  in  res) {
                            span += "<li style='background: none' class='addHtml' menuId=" + res[i].id + " >" + res[i].names + "</li>";
                        }
                    } else {
                        span += "<li style='background: none'>暂无</li>";
                    }
                    $(".search-in").html(span);
                });
            })

            // 关于Uncaught TypeError: Cannot read property 'toLowerCase' of undefined的问题
            $(document).on('click', '.addHtml', function () {
                var id = $(this).attr('menuId');
                var name = $(this).html();
                $('.search-in').css("display", "none")
                $('.menuSelect').val(name);
                $('#menuId').val(id);
            });
        });


    </script>
@endsection