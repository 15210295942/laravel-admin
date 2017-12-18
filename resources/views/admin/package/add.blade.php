@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','添加套餐')
@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- Start Content Box -->
    <div class="content-box-header">
        <h3>添加套餐</h3>
        <div class="clear"></div>
    </div>
    <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
            <div>
                <form id="form" method="POST">
                    <fieldset>
                        <p>
                            <label>套餐名称</label>
                            <input class="text-input small-input" type="text" name="packageName" value=""/>
                        </p>
                        <p>
                            <select name="schoolId" style="width: 150px;">
                                <option value="">学校</option>
                                @foreach($schools as $v)
                                    <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <select name="weekName" style="width: 150px;">
                                <option value="">周几</option>
                                @foreach($week as $w)
                                    <option schoolId="{{ $w }}" value="{{ $w }}">{{ $w }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <select name="meal" style="width: 150px;">
                                <option value="">餐时</option>
                                <option value="1">中餐</option>
                                <option value="2">晚餐</option>
                            </select>
                        </p>
                        <p>
                            <select name="status" style="width: 150px;">
                                <option value="">状态</option>
                                <option value="1">上架</option>
                                <option value="0">下架</option>
                            </select>
                        </p>
                        <p>
                            <label>排序</label>
                            <input class="text-input small-input" type="text" name="sortId" value="0"/>
                        </p>
                        <p>
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
                if('' === formData.get('packageName')){
                    alert('请输入套餐名称');
                    return;
                }
                if('' === formData.get('schoolId')){
                    alert('请选择学校');
                    return;
                }
                if('' === formData.get('weekName')){
                    alert('请选择星期几');
                    return;
                }
                if('' === formData.get('meal')){
                    alert('请选择餐时');
                    return;
                }
                if('' === formData.get('status')){
                    alert('请选择状态');
                    return;
                }
                if('' === formData.get('sortId')){
                    alert('请输入排序权重');
                    return;
                }

                $('#loading').show();
                post('/admin/package/add',{
                    packageName:formData.get('packageName'),
                    schoolId:formData.get('schoolId'),
                    weekName:formData.get('weekName'),
                    meal:formData.get('meal'),
                    status:formData.get('status'),
                    sortId:formData.get('sortId')
                },function (res) {
                    if(res.code === 200){
                        alert('添加成功');
                        location.href = '/admin/package/list'
                    }else{
                        alert(res.msg);
                    }
                },function (){
                    $('#loading').hide();
                });
            });
        });


    </script>
@endsection