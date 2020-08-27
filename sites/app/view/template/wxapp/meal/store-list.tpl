<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
    .tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
</style>
 <!-- 推广商品弹出框 -->
<div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">门店二维码</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange" style="text-align: center">扫一扫，在手机上查看</div>
                    <div class="code-fenlei">
                        <div style="text-align: center;margin: 0 auto">
                            <div class="text-center show" >
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后进入门店</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>

<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_amsId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary js-save my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<div id="content-con">

    <div  id="mainContent" >

        <div class="alert alert-block alert-warning" style="line-height: 20px;">
            商家登录管理地址：<a href="http://<{$curr_domain}>/shop/user/index<{$ext_query}>" target="_blank"> http://<{$curr_domain}>/shop/user/index<{$ext_query}></a><a href="javascript:;" class="copy-path btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<{$curr_domain}>/shop/user/index<{$ext_query}>" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>
            <br>
            <span style="color: red;">提示：商家的账号密码均默认为填写的手机号</span>
        </div>

        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/meal/addStore"><i class="icon-plus bigger-80"></i>添加门店</a>
            <div class="watermrk-show">
                <span class="label-name">店铺订单抽成比例(%)：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="text" style="width: 60px" class="form-control" id="default-maid" value="<{$maid}>">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-default-maid">确认修改</span>
                            <span>（微信在线支付提现会收取0.6%手续费）</span>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>门店名称</th>
                            <th>门店编号</th>
                            <th>绑定用户</th>
                            <th>联系方式</th>
                            <th>管理员账号</th>
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
                            <tr id="tr_<{$val['ams_id']}>" class="tr-content">
                                <td><{$val['es_name']}></td>
                                <td><{$val['ams_store_number']}></td>
                                <td>
                                    <{if $val['m_show_id']}>
                                    用户编号：<{$val['m_show_id']}><br>
                                    <{$val['m_nickname']}>
                                    <{/if}>
                                </td>
                                <td><{$val['ams_contact']}></td>
                                <td>
                                    <{if $val['esm_mobile']}><{$val['esm_mobile']}><{else}><{$val['es_phone']}><{/if}>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend edit-info" data-esmid="<{$val['esm_id']}>"  data-mobile="<{$val['esm_mobile']}>" onclick="" data-toggle="modal" data-target="#infoModal" />
                                    <!--<p style="margin:0;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<{$val['esm_id']}>"  data-mobile="<{$val['esm_mobile']}>" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p>-->
                                </td>
                                <td><{$val['ams_address']}></td>
                                <td><{date('Y-m-d H:i:s',$val['ams_create_time'])}></td>
                                <td class="jg-line-color">
                                	<p>
                                		<a href="javascript:;" class="btn-tuiguang" data-id="<{$val['ams_es_id']}>" data-share="<{$val['es_qrcode']}>">二维码</a>
                                         - <a href="javascript:;" class="copy-path" data-clipboard-action="copy" data-clipboard-text="pages/mulShopDetail/mulShopDetail?esId=<{$val['es_id']}>">复制路径</a>
                                    </p>
                                    <p>
                                        <a class="confirm-handle" href="/wxapp/meal/addStore/esId/<{$val['ams_es_id']}>">编辑</a>
                                        - <a class="delete-btn" data-id="<{$val['ams_id']}>" data-esid="<{$val['ams_es_id']}>" style="color:#f00;">删除</a>
                                        - <a class="set-member" data-id="<{$val['ams_id']}>" >绑定用户</a>
                                    </p>            
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <div class="table-page-box">
            <{$paginator}>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
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
        var clipboard = new ClipboardJS('.copy-path');
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




    $('.edit-info').on('click',function () {
        $('#esmid').val($(this).data('esmid'));
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            mobile   : mobile,
            password : password
        };
        if(id && mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeInfo',
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

    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
        var esId = $(this).data('esid');
        console.log(esId);
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meal/delStore',
                'data'  : {id:id,esId:esId},
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

    $("#content-con").on('click', function(event) {
        optshide();
    });

    //重新生成店铺二维码图片
    function reCreateQrcode(){
        var esId = $('#qrcode-goods-id').val();
        console.log(esId);
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/meal/createStoreQrcode',
            'data'  : {esId:esId},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                    console.log(ret.url);
                    $(".btn-tuiguang[data-id|='"+esId+"']").attr('data-share',ret.url);
               }
            }
        });
    }
    // 推广商品弹出框
    //$("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
    $(".btn-tuiguang").on('click', function(event) {
        var that = $(this);
//        that.load(that);
        var shareImg  = that.data('share');
//        console.log(shareImg);
//        console.log('↑上面的是二维码路径↑');
        var esId  = that.data('id');
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(esId);
            $('#download-goods-qrcode').attr('href', '/wxapp/meal/downloadStoreQrcode?esId='+esId);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-368,'top':top-conTop-110}).stop().show();

    });
    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();

        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
            $(this).remove();
        });
    }

    $("#content-con").on('click', 'table td a.set-member', function(event) {
        var id = $(this).data('id');
        $('#hid_amsId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-349,'top':top-conTop-90}).stop().show();
    });

    $('.js-save').on('click',function(){
        var amsId = $('#hid_amsId').val();
        var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
        if(!mid){
            layer.msg('请选择用户');
            return;
        }

        console.log(amsId);
        console.log(mid);
        var data = {
            'id' : amsId,
            'mid': mid
        };
        console.log(data);
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/meal/changeBelong',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
//                        optshide();
                    window.location.reload();
                }
            }
        });

    });

    /**
     * 修改默认抽成比例
     */
    $('#save-default-maid').on('click',function(){
        var defaultmaid = $('#default-maid').val();    // 默认抽成比例
        if(defaultmaid){
            if(defaultmaid=='<{$maid}>'){
                return;
            }
            var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            var data = {
                'defaultmaid' : defaultmaid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/Basiccfg/updateDefaultMaid',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        }
    });
</script>