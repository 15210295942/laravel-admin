@extends('admin.template.list')
@section('title','菜单列表')
@section('navUl')
    <ul>
        <li class="handle-item" style="float: right;margin-bottom: 5px">
                <span class="fr">
                    <a class="layui-btn" id="refresh">刷新</a>
				<button class="layui-btn menuAdd">立即添加</button>
                </span>
        </li>
    </ul>
@endsection
@section('table')
    <table class="layui-table">
        <thread>
            <tr>
                <th>ID</th>
                <th>路径</th>
                <th>别名</th>
                <th>描述</th>
                <th>图标</th>
                <th>排序</th>
                <th>父级ID</th>
                <th>操作</th>
            </tr>
        </thread>
        <tbody>
        @foreach($list as $value)
            <tr>
                <td>{{ $value['id'] }} </td>
                <td>{{ $value['path'] }} </td>
                <td>{{ $value['display_name'] }} </td>
                <td>{{ $value['description'] }} </td>
                <td>{{ $value['icon'] }} </td>
                <td>{{ $value['sort'] }} </td>
                <td>{{ $value['pid'] }} </td>
                <td>
                    <span data-id="{{ $value['id'] }}" class="layui-btn layui-btn-mini editMenu">编辑</span>
                    <span data-id="{{ $value['id'] }}" class="layui-btn layui-btn-danger remove layui-btn-mini">删除</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/menuList.js')}}"></script>