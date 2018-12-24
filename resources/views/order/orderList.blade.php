@extends('admin.template.list')
@section('title','订单列表')
@section('navUl')
    <ul>
        <li class="handle-item" style="float: right;margin-bottom: 5px">
                <span class="fr">
                    <a class="layui-btn" id="refresh">刷新</a>
				{{--<button class="layui-btn adminAdd">立即添加</button>--}}
                </span>
        </li>
    </ul>
@endsection
@section('table')
    <table class="layui-table">
        <thread>
            <tr>
                <th>订单号</th>
                <th>订单号</th>
                <th>订单号</th>
                <th>订单号</th>
                <th>订单号</th>
                {{--<th>用户名</th>--}}
                {{--<th>头像</th>--}}
                {{--<th>上次登录时间</th>--}}
                {{--<th>上次登录IP</th>--}}
                {{--<th>操作</th>--}}
            </tr>
        </thread>
        <tbody>
        @foreach($list as $admin)
            <tr>
                <td>{{$admin['orderId']}} </td>
                <td>{{$admin['orderId']}} </td>
                <td>{{$admin['orderId']}} </td>
                <td>{{$admin['orderId']}} </td>
                <td>{{$admin['orderId']}} </td>
{{--                <td>{{$admin['userName']}} </td>--}}
                {{--                <td><img src="{{ $admin['userPhoto'] }}" width="50px" height="50px"/></td>--}}
{{--                <td>{{ $admin['loginTime']?date('Y-m-d H:i:s', $admin['loginTime']):'-' }}</td>--}}
{{--                <td>{{$admin['loginIp']}}</td>--}}
                {{--<td>--}}

                    {{--<span data-id="{{$admin['id']}}" class="layui-btn layui-btn-mini editUser">编辑</span>--}}
                    {{--<span data-id="{{$admin['id']}}" class="layui-btn layui-btn-mini editPass">修改密码</span>--}}
                    {{--<span data-id="{{$admin['id']}}" class="layui-btn layui-btn-danger remove layui-btn-mini">删除</span>--}}
                {{--</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/adminList.js')}}"></script>