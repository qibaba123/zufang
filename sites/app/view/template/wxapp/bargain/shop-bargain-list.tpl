<{include file="../common-second-menu.tpl"}>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .message-muban .form-horizontal .control-label{
        font-weight: bold;
        margin-bottom:0;
        line-height: 34px;
        padding-top: 0;
    }
    .message-muban select.form-control{
        height: 34px;
    }
    .message-fenlei{
        background-color: #f6f6f6;
        border:1px solid #e8e8e8;
        border-radius: 4px;
        margin-bottom: 10px;
        padding: 0 10px;
        padding-top: 15px;
    }
    .message-fenlei:last-child{
        margin-bottom: 0;
    }
    .message-fenlei .fenlei-name{
        font-size: 14px;
        line-height: 35px;
        font-weight: bold;
        border-right: 1px dashed #ddd;
        height: 35px;
        color: #02a802;
    }
    .modal-body{
        max-height: 650px;
        overflow: auto;
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
</style>
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
    <!-- 推广活动弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <div style="height: 150px;width: 150px;margin: 0 auto"><img src="" id="act-code-img" alt="请重新生成二维码" style="width: 150px"></div>
                                <p>扫码后进入活动详情</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>

                                     <span class="download-span" style="display: none"><a href="" id="download-goods-qrcode" class="new-window" >下载二维码</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <div  id="mainContent" style="margin-left: 130px;" ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <div class="choose-state">
            <{foreach $choseLink as $val}>
            <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
            <{/foreach}>
            <!--
            <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
                <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
            </button>
            -->
            <{if $type eq 'highest'}>
            <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                    data-type="highest" data-title="添加最高级">
                添加最高级
            </button>
            <{/if}>
            <{if $type eq 'refer'}>
            <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                    data-type="refer" data-title="添加官方推荐人">
                添加官方推荐人
            </button>
            <{/if}>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
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
                            <th><{$goodsName}></th>
                            <th><{$goodsName}>图片</th>
                            <th>单价</th>
                            <th>活动时间</th>
                            <th>活动状态</th>
                            <th>参与情况</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                添加时间
                            </th>
                            <th>是否在活动首页展示</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['ba_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td><{$val['g_name']}></td>
                                <td><img src="<{$val['g_cover']}>" height="50"></td>
                                <td><{$val['g_price']}></td>
                                <td>
                                    <p>开始时间：<{date('Y-m-d H:i:s',$val['ba_start_time'])}></p>
                                    <p>结束时间：<{date('Y-m-d H:i:s',$val['ba_end_time'])}></p>
                                </td>
                                <!--
                                <td><{date('Y-m-d H:i',$val['ba_end_time'])}></td>
                                -->
                                <td>
                                    <!--<span class="label label-sm label-<{$bargainStatus[$val['ba_status']]['css']}>">
                                        <{$bargainStatus[$val['ba_status']]['label']}>
                                    </span>-->

                                    <{if $val['ba_start_time'] > time()}>
                                        <span class="label label-sm label-<{$bargainStatus[0]['css']}>">
                                            <{$bargainStatus[0]['label']}>
                                        </span>
                                    <{elseif $val['ba_start_time'] <= time() && $val['ba_end_time'] > time()}>
                                        <span class="label label-sm label-<{$bargainStatus[1]['css']}>">
                                            <{$bargainStatus[1]['label']}>
                                        </span>
                                    <{elseif $val['ba_end_time'] <= time()}>
                                        <span class="label label-sm label-<{$bargainStatus[2]['css']}>">
                                            <{$bargainStatus[2]['label']}>
                                        </span>
                                    <{/if}>
                                </td>
                                <td><{if $join && $join[$val['ba_id']]['total']}><a style="" href="/wxapp/bargain/join?id=<{$val['ba_id']}>" ><B><{$join[$val['ba_id']]['total']}> 次</B></a><{/if}> </td>
                                <td><{date('Y-m-d',$val['ba_create_time'])}></td>
                                <td>  <{if $val['ba_index_show']}>
                                    <span style="color: green">展示</span>
                                    <{else}>
                                    <span style="color: red">不展示</span>
                                    <{/if}></td>
                                <td>
                                    <p>
                                        <{if !$val['ba_index_show']}>
                                        <a href="javascript:;"  onclick="changeShow(1, <{$val['ba_id']}>)">展示</a> -
                                        <{else}>
                                        <a href="javascript:;" style="color: red;" onclick="changeShow(0, <{$val['ba_id']}>)">不展示</a> -
                                        <{/if}>
                                    </p>
                                    <p>
                                        <a href="javascript:;" onclick="pushBargain('<{$val['ba_id']}>')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['ba_id']}>')">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=bargain&id=<{$val['ba_id']}>" >推送记录</a>
                                    </p>
                                    <p>
                                        <a href="javascript:;"  class="info-btn" id="msg_a_<{$val['ba_id']}>"
                                           data-id="<{$val['ba_id']}>"
                                           data-kjwc-msg="<{$val['ba_kjwc_msgid']}>"  data-toggle="modal" data-target="#myMessageMuban"
                                        >模版消息</a>
                                         - <a href="javascript:;" class="btn-tuiguang" data-link="subpages/bargainGoodDetail/bargainGoodDetail?id=<{$val['ba_id']}>" data-share="<{$val['ba_qrcode']}>" data-id="<{$val['ba_id']}>">活动推广</a>
                                        <{if $val['ba_end_time'] <= time()}>
                                        - <a href="javascript:;" onclick="deleteBargain('<{$val['ba_id']}>')"  style="color:#f00;">删除</a>
                                        <{/if}>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="11"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myMessageMuban" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;padding-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myMessageMubanLabel">
                    消息模板
                </h4>
            </div>
            <div class="modal-body">
                <div class="message-muban">
                    <div class="form-group">
                        <a href="/wxapp/tplmsg/tpl" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 添加模版消息</a>
                    </div>
                    <form class="form-horizontal" id="msg-form" role="form">
                        <input type="hidden" id="hid_id" name="hid_id" value="">
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">砍价成功</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="kjwc_msgid" name="kjwc_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <{foreach $msg as $mal}>
                                            <option value="<{$mal['awt_id']}>"><{$mal['awt_title']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary msg-save-btn">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
<script>
    $('.info-btn').on('click',function(){
        $('#hid_id').val($(this).data('id'));
        var field = new Array('kjwc');
        for(var i=0;i<field.length;i++){
            $('#'+field[i]+'_msgid').val($(this).data(field[i]+'-msg'));
            $('#'+field[i]+'_nwid').val($(this).data(field[i]+'-nw'));
        }

    });

    $('.msg-save-btn').on('click',function(){
        var loading = layer.load(1, {
            shade: [0.6,'#fff'], //0.1透明度的白色背景
            time: 4000
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/bargain/bargainMsg',
            'data'  : $('#msg-form').serialize(),
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#myMessageMuban').modal('hide');
                    window.location.reload();
                }
            }
        });
    });
</script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>

<script>

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
    
    $('.btn-end').on('click',function(){
        var id = $(this).data('id');
        if(id){
            var data = {
              'id' : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/bargain/end',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });

    function pushBargain(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/bargainPush',
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
    //删除结束的砍价活动
    function deleteBargain(id) {
        layer.confirm('你确定要删除吗？', {
            btn: ['确定','取消'], //按钮
            title : '删除'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/bargain/delete',
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
             // console.log(link);
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
         // initCopy();
     });
     /*$(".ui-popover.ui-popover-link").on('click', function(event) {
         event.preventDefault();
         event.stopPropagation();
     });*/
     $("body").on('click', function(event) {
         optshide();
     });
     /*隐藏复制链接弹出框*/
     function optshide(){
         $('.ui-popover').stop().hide();
     }

     $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
         console.log('work');
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        var link   = $(this).data('link');
//        $('#copyLink').val(link); //购买链接
        if(shareImg){
            $(".download-span").css('display','');
        }
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(id);
            $('#download-goods-qrcode').attr('href', '/wxapp/bargain/downloadBargainQrcode?id='+id);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
//        }
     });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/bargain/createQrcode',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    console.log(ret);
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                    $(".download-span").css('display','');
                }
            }
        });
    }

    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', '.code-fenlei .pull-left li', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".code-fenlei .pull-right .text-center").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', function(event) {
        event.stopPropagation();
    });
     $("body").on('click', function(event) {
         $(".download-span").css('display','none');
        optshide();
     });

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/bargainPreview',
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

    function changeShow(status, actid) {
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/bargain/changeShow',
            'data'  : {status, actid},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    }
</script>
