@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','修改密码')
@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- Start Content Box -->
    <div class="content-box-header">
        <h3>修改密码</h3>
        <div class="clear"></div>
    </div>
    <!-- End .content-box-header -->
    <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
            <div>
                <form id="form" method="POST">
                    <fieldset>
                        <p>
                            <label>原密码</label>
                            <input class="text-input small-input" type="password" name="oldPsw"/>
                        </p>
                        <p>
                            <label>新密码</label>
                            <input class="text-input small-input" type="password" name="newPsw"/>
                        </p>
                        <p>
                            <label>确认密码</label>
                            <input class="text-input small-input" type="password" name="rePsw"/>
                        </p>
                        <p>
                            <input id="sub-btn" class="button" type="button" value="修改"/>
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
            $('#setting-mng .nav-top-item').addClass('current');
            $('#setting-mng ul').css('display', 'block');
            $('#setting-mng ul .psw a').addClass('current');

            $('#sub-btn').click(function () {
                var formData = new FormData($('#form')[0]);
                if(formData.get('oldPsw').length < 6 || formData.get('newPsw').length < 6 || formData.get('rePsw').length < 6){
                    alert('请输入6位以上的原密码、新密码以及重复密码');
                    return;
                }
                if(formData.get('newPsw') !== formData.get('rePsw')){
                    alert('两次输入的密码不匹配');
                    return;
                }
                $('#loading').show();
                post('/admin/psw',{oldPsw:formData.get('oldPsw'),newPsw:formData.get('newPsw')},function (res) {
                    if(res.code === 200){
                        alert('修改成功');
                        location.href = '/admin/logout'
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