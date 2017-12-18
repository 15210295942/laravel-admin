@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','菜谱列表')
@section('sidebar')
@parent
@endsection

@section('content')
        <!-- Start Content Box -->
<div class="content-box-header">
    <h3>菜单列表（<a href="/admin/package/menu/add?id={{ $info['id'] }}">添加</a> ）</h3>
    <div class="clear"></div>
</div>
<!-- End .content-box-header -->
<div class="content-box-content">

    <div class="tab-content default-tab" id="tab1">
        <p>
            <label>学校名称：</label>
            <span >{{ $info['schoolName'] }}
                   </span> &nbsp; &nbsp;
            <label>|   &nbsp; &nbsp; 套餐名称：</label>
            <span >{{ $info['packageName'] }}
                   </span> &nbsp; &nbsp;
            <label>|   &nbsp; &nbsp; 周几：</label>
            <span >{{ $info['weekName'] }}
                   </span>

        </p>
    </div>
    <div class="tab-content default-tab" id="tab1">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>菜名</th>
                <th>图片</th>
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
                    <td>{{ $user['names'] }}</td>
                   <td>@if($user['photo']) <img src="{{ $user['photo'] }}"  width="60" height="45">@else 无 @endif</td>
                    <td>{{ $user['sortId'] }}</td>
                    <td>@if($user['status']== 1) 正常 @else 下架 @endif</td>
                    <td><a href="javascript:;" onclick="delUser({{ $user['id'] }})">删除</a></td>
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
        if (!sure) {
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