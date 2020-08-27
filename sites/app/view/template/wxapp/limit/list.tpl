<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td p{
        margin:0;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .center{
        text-align: center;
    }
    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 20%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }

</style>
<{include file="../common-second-menu.tpl"}>
<div id="content-con">
    <!-- 复制链接弹出框 -->
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <div  id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">

        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">全部活动<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">准备中<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_zbz']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">进行中<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_jxz']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已结束<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_yjs']}></span>
                </div>
            </div>
        </div>

        <div class="page-header">
            <a href="/wxapp/limit/add" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
            <{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
            <a class="btn btn-green btn-xs goods-setting" href="#" data-toggle="modal" data-target="#settingModal">活动设置</a>
            <{/if}>
        </div><!-- /.page-header -->
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li  class="<{if $status eq all}>active<{/if}>">
                    <a href="/wxapp/limit/index?status=all">
                        全部活动
                    </a>
                </li>
                <li  class="<{if $status eq notStart}>active<{/if}>">
                    <a href="/wxapp/limit/index?status=notStart">
                        未开始
                    </a>
                </li>
                <li class="<{if $status eq runing}>active<{/if}>">
                    <a href="/wxapp/limit/index?status=runing">
                        进行中
                    </a>
                </li>
                <li class="<{if $status eq finish}>active<{/if}>">
                    <a href="/wxapp/limit/index?status=finish">
                        已结束
                    </a>
                </li>
            </ul>
            <div class="tab-content"  style="z-index:1;">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <!--
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            -->
                            <th>活动名称</th>
                            <th>活动时间</th>
                            <th>活动标签</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                状态
                            </th>
                            <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                            <th>是否已推送</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['la_id']}>">
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['la_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td><{$val['la_name']}></td>
                                <td>
                                    <p>开始时间：<{date('Y-m-d H:i:s',$val['la_start_time'])}></p>
                                    <p>结束时间：<{date('Y-m-d H:i:s',$val['la_end_time'])}></p>
                                </td>
                                <td><{$val['la_label']}></td>
                                <td><{if $val['la_start_time'] > time()}>
                                    <!--<span class="label label-sm label-danger">尚未开始</span>-->
                                    <span class="font-color-audit">尚未开始</span>
                                    <{elseif $val['la_start_time'] <= time() && $val['la_end_time'] > time()}>
                                    <!--<span class="label label-sm label-success">进行中</span>-->
                                    <span class="font-color-pass">进行中</span>
                                    <{elseif $val['la_end_time'] <= time()}>
                                    <!--<span class="label label-sm label-green">活动结束</span>-->
                                    <span class="font-color-refuse">活动结束</span>
                                    <{/if}></td>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <td><{if $val['la_push']}>已推送<{else}><span style="color:#333;">未推送</span><{/if}></td>
                                <{/if}>
                                <td style="color:#ccc;">
                                    <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                	<p>
                                        <a href="javascript:;" onclick="pushLimit('<{$val['la_id']}>')" >推送</a> -
                                        <{if !in_array($menuType,['weixin'])}>
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['la_id']}>')">预览</a> -
                                        <{/if}>
                                        <a href="/wxapp/tplpreview/pushHistory?type=limit&id=<{$val['la_id']}>" >记录</a>
                                    </p>
                                    <{/if}>
                                    <p>
                                        <a href="/wxapp/limit/add/?id=<{$val['la_id']}>" >编辑</a> -
                                        <!--<a href="javascript:;" id="link_<{$val['la_id']}>" class="btn-link" data-link="<{$val['link']}>">链接</a> -->
                                        <!--
                                        <{if $appletCfg['ac_type'] != 12 && $appletCfg['ac_type'] != 7 && $appletCfg['ac_type'] != 4}>
                                        <a href="/wxapp/limit/limitBanner/?id=<{$val['la_id']}>" >广告设置</a>-
                                        <{/if}>
                                        -->
                                        <a href="javascript:;" data-id="<{$val['la_id']}>" class="btn-del" style="color:#f00;">删除</a>
                                    </p>    
                                </td>
                            </tr>
                            <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="13"><{$pageHtml}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
            </div>
            </div>
    </div>
</div>
<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 635px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    活动加群设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-top: 10px;margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">是否开启：</label>
                    <div class="col-sm-8">
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='wxgroupshow' type='checkbox' <{if $limitCfg['lc_wxgroup_show']}>checked<{/if}>>
                            <label class='tgl-btn' for='wxgroupshow'></label>
                        </span>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px;margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群LOGO：</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-wxgrouplogo" id="upload-wxgrouplogo"  src="<{if $limitCfg['lc_wxgroup_logo']}><{$limitCfg['lc_wxgroup_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>"  width="200px" height="200px" style="display:inline-block;margin-left:0;width: 30%;height: 30%">
                                <input type="hidden" id="wxgrouplogo"  class="avatar-field bg-img" name="wxgrouplogo" value="<{$limitCfg['lc_wxgroup_logo']}>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群标题：</label>
                    <div class="col-sm-8">
                        <input id="wxgroup-title" class="form-control" placeholder="请填写加群标题" style="height:auto!important" value="<{$limitCfg['lc_wxgroup_title']}>"/>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群描述：</label>
                    <div class="col-sm-8">
                        <input id="wxgroup-desc" class="form-control" placeholder="请填写加群描述" style="height:auto!important" value="<{$limitCfg['lc_wxgroup_desc']}>"/>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">群二维码</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-wxgroupqrcode" id="upload-wxgroupqrcode"  src="<{if $limitCfg['lc_wxgroup_qrcode']}><{$limitCfg['lc_wxgroup_qrcode']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>" height="200px;" width="200px;" style="display:inline-block;margin-left:0;width: 60%;height: 60%">
                                <input type="hidden" id="wxgroupqrcode"  class="avatar-field bg-img" name="wxgroupqrcode" value="<{$limitCfg['lc_wxgroup_qrcode']}>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-wxgroup">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>

    $('#confirm-wxgroup').on('click', function () {
        let data = {
            'show': $('#wxgroupshow:checked').val()=='on'?1:0,
            'title': $('#wxgroup-title').val(),
            'desc': $('#wxgroup-desc').val(),
            'logo': $('#wxgrouplogo').val(),
            'qrcode': $('#wxgroupqrcode').val()
        };

        var loading = layer.load(1, {
            shade: [0.6,'#fff'], //0.1透明度的白色背景
            time: 4000
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/limit/saveLimitCfg',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#settingModal').modal('hide');
                }
            }
        });

    })

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        // console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
        optshide();
    } );
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('id')
        };
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(data.id > 0){
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/limit/delLimit',
	                'data'  : data,
	                'dataType' : 'json',
	                success : function(ret){
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                        $('#tr_'+data.id).hide();
	                    }
	                }
	            });
	        }
        });
    });

    function pushLimit(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/limitPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
    });
    $("body").on('click', function(event) {
        optshide();
    });
    /*隐藏复制链接弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/limitPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }
</script>
