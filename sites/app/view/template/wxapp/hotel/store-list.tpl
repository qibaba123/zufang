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
    <div class="alert alert-block alert-warning" style="line-height: 20px;">
        商家登录管理地址：<a href="http://<{$curr_domain}>/shop/user/index"> http://<{$curr_domain}>/shop/user/index</a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<{$curr_domain}>/shop/user/index" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>
        <br>
    </div>


    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/hotel/addStore"><i class="icon-plus bigger-80"></i>添加门店</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>门店名称</th>
                            <th>联系方式</th>
                            <th>登录账号</th>
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
                            <tr id="tr_<{$val['ahs_id']}>">
                                <td><{$val['ahs_name']}></td>
                                <td><{$val['ahs_contact']}></td>
                                <td> <{if $val['esm_mobile']}><{$val['esm_mobile']}><{else}>无账号<{/if}>
                                    <p style="margin:0;text-align: left;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<{$val['esm_id']}>"  data-mobile="<{$val['esm_mobile']}>" data-ahsid="<{$val['ahs_id']}>" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p></td>
                                <td><{$val['ahs_address']}></td>
                                <td><{date('Y-m-d H:i:s',$val['ahs_create_time'])}></td>
                                <td>
                                    <a class="confirm-handle" href="/wxapp/hotel/addStore/id/<{$val['ahs_id']}>">编辑</a>
                                    <a class="delete-btn" data-id="<{$val['ahs_id']}>">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="6"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <input type="hidden" id="ahsid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    信息修改
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">账号：</label>
                    <div class="col-sm-8">
                        <input id="mobile" class="form-control" placeholder="请填写联系电话" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码：</label>
                    <div class="col-sm-8">
                        <input id="password" type="password" autocomplete="off" class="form-control" placeholder="请填写登录密码" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script>
    $(function () {
        // 定义一个新的复制对象
        var clipboard = new ClipboardJS('.copy-button');
        console.log(clipboard);
        // 复制内容到剪贴板成功后的操作
        clipboard.on('success', function(e) {
            console.log(e);
            layer.msg('复制成功');
        });
        clipboard.on('error', function(e) {
            console.log(e);
            console.log('复制失败');
        });
    });


    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/hotel/delStore',
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

    $('.edit-info').on('click',function () {
        $('#esmid').val($(this).data('esmid'));
        $('#ahsid').val($(this).data('ahsid'));
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var ahsId    = $('#ahsid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            ahsId  : ahsId,
            mobile   : mobile,
            password : password
        };
        if(mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/hotel/changeInfo',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请完善账户信息');
        }
    });
</script>