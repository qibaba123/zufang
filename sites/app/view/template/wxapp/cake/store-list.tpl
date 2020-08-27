<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/cake/addStore"><i class="icon-plus bigger-80"></i>添加门店</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>门店名称</th>
                            <th>是否总店</th>
                            <th>联系方式</th>
                            <th>详细地址</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                创建时间
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $storeList as $val}>
                            <tr id="tr_<{$val['os_id']}>">
                                <td><{$val['os_name']}></td>
                                <td><{if $val['os_is_head'] eq 1}>总店<{else}>-<{/if}></td>
                                <td><{$val['os_contact']}></td>
                                <td><{$val['os_addr']}></td>
                                <td><{date('Y-m-d H:i:s',$val['os_create_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle" href="/wxapp/cake/addStore/id/<{$val['os_id']}>">编辑</a> -

                                    <{if $appletCfg['ac_type'] == 18}>
                                    <a href="#" class="btn-manager" data-id="<{$val['os_id']}>" data-mobile="<{$val['os_manager_mobile']}>" data-password="<{if $val['os_manager_password']}>1<{else}>0<{/if}>">管理员</a> -
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] == 18}>
                                    <a href="/wxapp/reservation/tradeList?osId=<{$val['os_id']}>" >门店订单</a> -
                                    <{/if}>
                                    <a class="delete-btn" data-id="<{$val['os_id']}>" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="managerModal" tabindex="-1" role="dialog" aria-labelledby="managerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 500px !important;">
        <div class="modal-content">
            <input type="hidden" id="hid_osId" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="managerModalLabel">
                    管理员
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>手机号</label>
                        <div class="col-sm-8">
                            <input id="manager_mobile" class="form-control" placeholder="请填写管理员手机" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row" style="margin-bottom: 3px !important;">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码
                            <span class="password-green" style="color: green;display: none">(已设置)</span>
                            <span class="password-red" style="color: red;display: none">(未设置)</span>
                        </label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="manager_password" class="form-control" placeholder="请填写管理员密码" style="height:auto!important" />
                        </div>
                    </div>
                    <div class="modal-tip" style="color: #777;display: none;font-size: 12px;padding-left: 120px">不填写则不修改</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveManager">保存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/cake/delStore',
                'data'  : {id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

    $('.btn-manager').on('click',function () {
        var id = $(this).data('id');
        var mobile = $(this).data('mobile');
        var password = $(this).data('password');
        console.log(password);
        $('.password-green').css('display','none');
        $('.password-red').css('display','none');
        $('.modal-tip').css('display','none');
        $('#hid_osId').val('');
        $('#manager_mobile').val('');
        $('#manager_password').val('');
        $('#hid_osId').val(id);
        $('#manager_mobile').val(mobile);

        if(mobile){
            $('.modal-tip').css('display','');
        }

        if(password == 1){
            $('.password-green').css('display','');
        }else if(password == 0){
            $('.password-red').css('display','');
        }

        $('#managerModal').modal('show');

    });

    $('.saveManager').on('click',function () {
        var id =  $('#hid_osId').val();
        var mobile = $('#manager_mobile').val();
        var password = $('#manager_password').val();

        var data = {
            id:id,
            mobile:mobile,
            password:password
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/saveStoreManager',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });
</script>