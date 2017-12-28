@extends('admin.template.list')
@section('title','修改菜单')
@section('table')
    <form class="layui-form" action="javascript:;" enctype="multipart/form-data" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>菜单级别</label>
            <div class="layui-input-block">
                <select name="pid">
                    <option value="0">顶级</option>
                    @foreach($topMenu as $v)
                        <option value="{{ $v['id'] }}" @if($detail['pid']==$v['id']) selected @endif>{{ $v['display_name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">菜单路径</label>
            <div class="layui-input-block">
                <input type="text" name="path" autocomplete="off" placeholder="请输入路径" value="{{ $detail['path'] }}"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>菜单名称</label>
            <div class="layui-input-block">
                <input type="text" name="display_name" lay-verify="required" autocomplete="off" value="{{ $detail['display_name'] }}" placeholder="请输入菜单名称"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>菜单描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" lay-verify="required" value="{{ $detail['description'] }}" autocomplete="off" placeholder="当前名称 or  顶级 > 当前菜单名称"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>菜单图标</label>
            <div class="layui-input-block">
                <input type="text" name="icon" lay-verify="required" value="{{ $detail['icon'] }}" autocomplete="off" placeholder="请输入图标样式"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>菜单排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" lay-verify="required" value="{{ $detail['sort'] }}" autocomplete="off" placeholder="请输入路径"
                       class="layui-input">
            </div>
        </div>
        <input type="hidden" name="id" value="{{ $detail['id'] }}" />
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </form>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/menuEdit.js')}}"></script>