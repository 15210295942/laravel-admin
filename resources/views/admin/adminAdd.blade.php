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
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </form>
@endsection
<script type="text/javascript" src="{{asset('plugin/layui/layui.js')}}"></script>
<script src="{{asset('admin/js/adminAdd.js')}}"></script>