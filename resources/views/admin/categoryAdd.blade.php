@extends('admin.template.list')
@section('title','添加分类')
@section('table')
    <form class="layui-form" action="javascript:;" enctype="multipart/form-data" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>级别</label>
            <div class="layui-input-block">
                <select name="pid">
                    <option value="0">顶级</option>
                    @foreach($topCate as $v)
                        <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入名称"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" lay-verify="required" autocomplete="off" placeholder="当前名称 or  顶级 > 当前名称"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </form>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/cateAdd.js')}}"></script>