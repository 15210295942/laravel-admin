@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','菜谱列表')
@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- Start Content Box -->
    <div class="content-box-header">
        <h3>套餐列表（<a href="/admin/package/add">添加</a> ）</h3>
        <div class="clear"></div>
    </div>
    <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
            <div>
                <form id="form" method="get">
                    <fieldset>
                        <p>
                            <select name="week" style="width: 150px;">
                                <option value="">周几</option>
                                @foreach($week as $w)
                                    <option weekName="{{ $w }}" value="{{ $w }}">{{ $w }}</option>
                                @endforeach
                            </select>

                            <select name="school" style="width: 150px;">
                                <option value="">学校</option>
                                @foreach($schools as $v)
                                    <option schoolId="{{ $v['id'] }}"
                                            {{ isset($_GET['school']) && $_GET['school'] === $v['id'] ?'selected=selected':'' }}
                                            value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>

                            <input class="button" type="submit" value="搜索"/>
                        </p>
                        <br/>
                        <br/>
                        <!--
                        <p style="padding-left: 30px;"><a id="upd_status" href="#"
                                                          style="font-size: large; color: #2a88bd">[更改支付状态]</a></p> -->
                    </fieldset>
                    <div class="clear"></div>
                    <!-- End .clear -->
                </form>
            </div>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>学校名称</th>
                    <th>周几</th>
                    <th>餐时</th>
                    <th>套餐名称</th>
                    <th>排序权重</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="6">

                        <div class="pagination">
                        </div>
                        <!-- End .pagination -->
                        <div class="clear"></div>
                    </td>
                </tr>
                </tfoot>
                <tbody>
                @foreach($list as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['schoolName'] }}</td>
                        <td>{{ $user['weekName'] }}</td>
                        <td>@if($user['meal']== 1) 中餐 @else 晚餐 @endif</td>
                        <td>{{ $user['packageName'] }}</td>
                        <td>{{ $user['sortId'] }}</td>
                        <td>@if($user['status']== 1) 正常 @else 下架 @endif</td>
                        <td><a href="/admin/package/menu/rel?id={{ $user['id'] }}">添加菜</a> | <a href="javascript:;" onclick="delUser({{ $user['id'] }})">删除</a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- End #tab1 -->

    </div>
    <!-- End .content-box-content -->

    <script>
        $(function () {
            $('#recipe-mng .nav-top-item').addClass('current');
            $('#recipe-mng ul').css('display', 'block');
            $('#recipe-mng ul .package_list a').addClass('current');
        });

        function delUser(id) {
            var sure = confirm('确认删除？');
            if(!sure){
                return;
            }
            $('#loading').show();
            post('/admin/delete', {id: id}, function (res) {
                if (res.code === 200) {
                    alert('删除成功');
                    window.location.reload();
                } else {
                    alert(res.msg);
                }
            }, function () {
                $('#loading').hide();
            });
        }


    </script>
@endsection