@extends('admin.layouts.master')

@section('adminName',$user['typeName'].' '.$user['uname'])
@section('title','添加菜谱')
@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .icons-list {
            overflow: hidden;
        }

        .icons-list > li {
            font-size: 14px;
            line-height: 35px;
            float: left;
            margin-bottom: 5px;
        }

        .icons-list:nth-child(1) input[type="text"] {
            width: 90px;
        }

        .checkbox .parent {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .containerIn {
            margin-left: 30px;
        }
    </style>
    <!-- Page header -->
    <div class="content-box-header">
        <h3>添加套餐下的菜名</h3>
        <div class="clear"></div>
    </div>
    <br/>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- content -->
        <div class="panel panel-flat">
            <form id="form" method="POST">
                @foreach($menu as $d)
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="checkbox row">
                                <label class="parent"><input type="checkbox" class="title"
                                                             value="{{$d['id']}}" @if ($d['isHave'] == 1) checked="checked" @endif>{{$d['names']}}</label>
                            </div>
                            <div class="row titleChilder">
                            </div>
                        </div>
                    </div>
                    <hr/>
                @endforeach
                <div class="text-right" style="margin-bottom:20px;">
                    <input type="hidden" value="" name="roleRouteIds" >
                    <input type="hidden" class="form-control" id="packageId" name="packageId" value="{{ $info['id'] }}">
                    <input id="sub-btn" class="button" type="button" value="保存"/>
                </div>
            </form>

        </div>
        <!-- /content -->
    </div>
    <!-- /content area -->

    <script type="text/javascript" language="JavaScript">
        $(function () {
            $('#recipe-mng .nav-top-item').addClass('current');
            $('#recipe-mng ul').css('display', 'block');
            $('#recipe-mng ul .package_list a').addClass('current');

            $('.titleChilder [type="checkbox"]').click(function () {
                _thisCk = $(this).parents('.row').siblings('.row').find('input')
                if (this.checked) {
                    _thisCk.prop("checked", true);
                } else if ($(this).parents('.row').find('input[type="checkbox"]:checked').length == 0) {
                    _thisCk.prop("checked", false);
                }
            });

            $('#sub-btn').click(function () {
                var _role = [];
                $('[type="checkbox"]:checked').each(function () {
                    _role.push($(this).val());
                });
                $('[name="roleRouteIds"]').val(_role);
               if (_role.length == 0){
                   alert('请选择菜单');
                   return;
               }
                var sure = confirm('确认保存吗？');
                if(!sure){
                    return;
                }
                post('/admin/package/menu/relSave', {
                    id: $('#packageId').val(),
                    menuId: _role.join(",")
                }, function (res) {
                    if (res.code === 200) {
                        alert('添加成功');
                        location.href = '/admin/package/list?id=' + res.data.packageId;
                    } else {
                        alert(res.msg);
                        $('#loading').hide();
                    }
                });


            });
        });


    </script>

@endsection