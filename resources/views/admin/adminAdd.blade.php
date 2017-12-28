@extends('admin.template.list')
@section('title','添加管理员')
@section('table')
    <form class="layui-form" action="javascript:;" enctype="multipart/form-data" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>用户名</label>
            <div class="layui-input-block">
                <input type="text" name="userName" lay-verify="required" autocomplete="off" placeholder="请输入用户名"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>密码</label>
            <div class="layui-input-block">
                <input type="password" name="pswO" autocomplete="off" placeholder="请输入密码"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>重复密码</label>
            <div class="layui-input-block">
                <input type="password" name="pswT" lay-verify="passCheck" autocomplete="off"
                       placeholder="请输入重复密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-upload">
            <label class="layui-form-label"><span style="color: red">*</span>头像</label>
            <div class="layui-input-block">
                <input type="file" name="file" class="layui-upload-file uploadFile">
                <img alt="" id="photoShow" width="200px" height="200px"/> <br>
                <div class="site-demo-upbar">
                    <button type="button" class="layui-btn  layui-btn-primary"
                            {{-- style="background-color: white"--}} id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <input type="hidden" name="userPhoto" lay-verify="required" value="">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span style="color: red">*</span>权限分配</label>
            <div class="layui-input-block">
                @if($menuList)
                    @foreach($menuList as $key => $v)
                        <ul class="nofloat" style="overflow:hidden;width:25%;float: left">
                            <li class="left w25pre h36 checkBoxId" value="{{ $v['id'] }}">
                                <input type="checkbox" name="checkMenu" value="{{ $v['id'] }}">
                                <label for="brand_{{ $v['id'] }}">{{ $v['display_name'] }}</label>
                            </li>
                        </ul>
                        @if($v['has_many_child_menu'])
                            @foreach($v['has_many_child_menu'] as $k => $value)
                                <ul class="nofloat" style="overflow:hidden;width:25%;float: left">
                                    <li class="left w25pre h36 checkBoxId" value="{{ $value['id'] }}">
                                        <input type="checkbox" name="checkMenu" value="{{ $value['id'] }}">
                                        <label for="brand_{{ $value['id'] }}">{{ $value['display_name'] }}</label>
                                    </li>
                                </ul>
                            @endforeach
                        @endif
                    @endforeach
                @else
                    暂无数据
                @endif
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
<script src="{{asset('admin/js/adminAdd.js')}}"></script>