<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
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
    .tgl+.tgl-btn {
        width: 3em;
        height: 1.5em;
    }
</style>
<{include file="../common-second-menu-new.tpl"}>
<link href="/public/plugin/datePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
<div id="content-con">
    <div  id="mainContent" >
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
            由于抽奖入口限制，抽奖活动允许添加多个，但只允许一个正在进行中的抽奖活动
        </div>
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">累计抽奖<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">中奖数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['prize']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">未中奖数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['noPrize']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">待核销<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['noVerify']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已核销<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['verify']}></span>
                </div>
            </div>
        </div>
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id='add-lottery'><i class="icon-plus bigger-80"></i>添加活动</a>

        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>活动名称</th>
                            <th>开始时间</th>
                            <th>添加时间</th>
                            <th>状态</th>
                            <th>首页展示</th>
                            <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                            <th>是否已推送</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['amll_id']}>">
                                <td><{$val['amll_name']}></td>
                                <td>
                                    <{if $val['amll_start_time'] != 0}>
                                    <{date('Y-m-d H:i:s',$val['amll_start_time'])}>
                                    <{else}>
                                    <p>未限制</p>
                                    <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i:s', $val['amll_create_time'])}></td>
                                <th>
                                    <{if $val['amll_status']==0}>
                                        <span style="color: deepskyblue">未配置</span>
                                    <{/if}>
                                    <{if $val['amll_status']==1}>
                                        <span style="color: red">进行中</span>
                                    <{/if}>
                                    <{if $val['amll_status']==2}>
                                    <span>已结束</span>
                                    <{/if}>
                                </th>
                                <th>
                                    <{if $val['amll_index_status']==1}>
                                    <span style="color: deepskyblue">开启</span>
                                    <{/if}>
                                    <{if $val['amll_index_status']==2}>
                                    <span style="color: red">隐藏</span>
                                    <{/if}>
                                </th>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <td><{if $val['amll_push']}>已推送<{else}><span style="color: red">未推送</span><{/if}></td>
                                <{/if}>
                                <td>
                                    <p>

                                        <a href="/wxapp/meeting/lottery?id=<{$val['amll_id']}>" >抽奖配置</a>-
                                        <a href="/wxapp/meeting/record?id=<{$val['amll_id']}>" >抽奖记录</a>-
                                        <a class="change_now" href="javascript:;" data-id="<{$val['amll_id']}>" data-type="<{$val['amll_index_status']}>" ><{if $val['amll_index_status'] == 1}>关闭<{else}>开启<{/if}></a>-
                                        
                                        <a href="#" class='edit-lottery'
                                            data-id='<{$val['amll_id']}>' 
                                            data-name='<{$val['amll_name']}>'
                                            data-start='<{$val['amll_start_time']}>'
                                            data-status='<{$val['amll_customer_status']}>'
                                        >编辑</a>-
                                        <a href="#" data-id="<{$val['amll_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                    </p>
                                    <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                    <p style="color:#ccc;">
                                        <a href="javascript:;" onclick="pushLottery('<{$val['amll_id']}>')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['amll_id']}>')">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=lottery&id=<{$val['amll_id']}>" >推送记录</a>
                                    </p>
                                    <{/if}>
                                    <{if $ac_type==21}>
                                    <p>
                                        <a href="javascript:;" data-toggle="modal" data-amllid="<{$val['amll_id']}>" id="show-lottery" data-target="#qrcodeModal" >抽奖小程序码</a>
                                    </p>
                                    <{/if}>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <{$paginator}>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<div class='modal fade' id='qrcodeModal'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">抽奖活动二维码</h4>
            </div>
            <div class="modal-body text-center" >
                <img style='width: 300px;' src="/wxapp/meeting/getQrcode" id="lottery-qrcode" title="右键保存至本地">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加活动
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="lottery-id" >
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">活动名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写活动名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">开始时间：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="start-time" value="" placeholder="开始时间" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="true">
                        <p class='help=block'>
                            <small>时间为空则不限制开始时间</small>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">开启活动：</label>
                    <div class='col-xs-8'>
                        <span class="tg-list-item">
                            <span class="limit-title text-danger" id='status-title'>已开启</span>
                            <input class="tgl tgl-light" id="change-status" type="checkbox" checked>
                            <label class="tgl-btn" for="change-status" style="display: inline-block;"></label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
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
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        console.log($(this).data('cover'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#lottery-id').val();
        var name   = $('#category-name').val();
        var start_time=$('#start-time').val();
        var status=$("#change-status").is(':checked');
        var data = {
            id     : id,
            name   : name,
            start_time:start_time,
            status:status?1:0
        };
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/saveAct',
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
        }
    });

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/meeting/delAct',
	                'data'  : { id:id},
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
    }

    $('.change_now').on('click',function(){
        var id     =  $(this).data('id');
        var type   =  $(this).data('type');
        var str    = '';
        var status = '';
        if(type==1){
            str    = '关闭';
            status = 2;
        }else{
            str  = '开启';
            status = 1;
        }
        var data = {
            'id'     : id,
            'status' : status
        };
        layer.confirm('您确认要'+str+'首页展示吗',function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/changeIndexStatus',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        },function(){

        });
    });

    function pushLottery(id) {

        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/lotteryPush',
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

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/lotteryPreview',
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
    // 时间格式转换
    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D+h+m+s;
    }

    $('.edit-lottery').click(function(){
        let uid =$(this).data('id');
        let name=$(this).data('name');
        let start=$(this).data('start');
        let status=$(this).data('status');
        console.log(status)
        $('#lottery-id').val(uid);
        $('#category-name').val(name);
        if(start==0)
            $('#start-time').val('');
        else
            $('#start-time').val(timestampToTime(start));
        $('#change-status').prop('checked',status==1?true:false);
        $('#status-title').html(status==1?'已开启':'已关闭');
        $('#myModal').modal('show');
    });
    $('#add-lottery').click(function(){
        $('#lottery-id').val('');
        $('#category-name').val('');
        $('#start-time').val('');
        $('#change-status').prop('checked',true);
        $('#status-title').html('已开启');
        $('#myModal').modal('show');
    });
    $('#change-status').change(function(){
        let title=$('#status-title').html();
        if(title=='已开启')
            $('#status-title').html('已关闭');
        else
            $('#status-title').html('已开启');
    });

</script>