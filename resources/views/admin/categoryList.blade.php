@extends('admin.template.list')
@section('title','分类列表')
@section('navUl')
    <ul>
        <li class="handle-item" style="float: right;margin-bottom: 5px">
                <span class="fr">
                    <a class="layui-btn" id="refresh">刷新</a>
				<button class="layui-btn add">立即添加</button>
                </span>
        </li>
    </ul>
@endsection
@section('table')
    <table class="layui-table">
        <thread>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>描述</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
        </thread>
        <tbody>
        @foreach($list as $value)
            <tr>
                <td>{{ $value['id'] }} </td>
                <td>{{ $value['name'] }} </td>
                <td>{{ $value['description'] }} </td>
                <td>{{ date('Y-m-d H:i:s', $value['createTime']) }} </td>
                <td>
                    <span data-id="{{ $value['id'] }}" class="layui-btn layui-btn-mini edit">编辑</span>
                    <span data-id="{{ $value['id'] }}" class="layui-btn layui-btn-danger remove layui-btn-mini">删除</span>
                </td>
            </tr>
            @if($value['has_many_cate'])
                @foreach($value['has_many_cate'] as $v)
                    <tr>
                        <td style="padding-left: 5px">{{ $v['id'] }} </td>
                        <td style="padding-left: 5px">{{ $v['name'] }} </td>
                        <td style="padding-left: 5px">{{ $v['description'] }} </td>
                        <td style="padding-left: 5px">{{ date('Y-m-d H:i:s', $v['createTime']) }} </td>
                        <td>
                            <span data-id="{{ $v['id'] }}" class="layui-btn layui-btn-mini edit">编辑</span>
                            <span data-id="{{ $v['id'] }}" class="layui-btn layui-btn-danger remove layui-btn-mini">删除</span>
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/cateList.js')}}"></script>