<{include file="../common-second-menu.tpl"}>
<style>
    .applet-pay{display: inline-block;vertical-align: middle;height: 40px;position: relative;padding: 2px;box-sizing: border-box;}
.applet-pay .icon_applet{
        /*height: 36px;width: 36px;*/
        vertical-align: middle;display: block;
    }
    .applet-pay .pay-code-box{border:1px solid #ddd; background-color:#fff;position: absolute;top:40px;left:50%;margin-left: -110px;width: 220px;padding: 15px;box-sizing: border-box; z-index: 2;display: none;}  .applet-pay .pay-code-box:before, .applet-pay .pay-code-box:after{content:'';position: absolute;left:50%;top:-15px;margin-left:-8px;border-width: 8px;border-style: dashed dashed solid dashed;border-color: transparent transparent #fff transparent;z-index: 2;}  .applet-pay .pay-code-box:after{z-index: 1;border-color: transparent transparent #ddd transparent;top:-16px;}  .applet-pay:hover .pay-code-box{display: block;}  .applet-pay .pay-code-box img{width: 180px;height: 180px;margin:0 auto;}  .applet-pay .pay-code-box p{font-size: 13px;display: block;margin:0;margin-top: 8px;line-height: 2;text-align: center;}

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
        width: 25%;
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
<div id="mainContent">
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">累计申请人数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">待审核<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['audit']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已通过<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['pass']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已拒绝<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['refuse']}></span>
            </div>
        </div>
    </div>

    <a href="/wxapp/three/branchcfg" class="btn btn-xs btn-green" >页面设置</a>
    <div class="applet-pay">
        <a href="javascript:;" class="btn btn-xs btn-green icon_applet" style="margin-top: 5px">邀请二维码</a>
        <!--
        <img src="/public/wxapp/images/icon_applet.png" class="icon_applet" alt="小程序图标">
        -->
        <div class="pay-code-box">
            <img src="<{$apply_qrcode}>" id="three-qrcode" alt="小程序二维码">
            <p><a href="javascript:;" onclick="reCreateQrcode()">重置</a>-<a href="/wxapp/three/downloadQrcode">下载二维码</a></p>
        </div>
    </div>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/three/branch" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">申请人名称</div>
                                <input type="text" class="form-control" name="realname" value="<{$realname}>" placeholder="申请人名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">申请人电话</div>
                                <input type="text" class="form-control" name="mobile" value="<{$mobile}>" placeholder="申请人电话">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table id="sample-table-1" class="table table-striped table-hover table-button">
            <thead>
            <tr>
                <th>申请会员昵称</th>
                <th>申请人姓名</th>
                <th>申请人手机</th>
                 <th>申请省份</th>
                <th>申请城市</th>
                <th>申请区域</th>
                <th>审核状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <{foreach $list as $item}>
                <tr id="tr_<{$item['sb_id']}>">
                    <td><{$item['m_nickname']}></td>
                    <td><{$item['sb_realname']}></td>
                    <td><{$item['sb_phone']}></td>
                     <td><{$item['p_name']}></td>
                    <td><{$item['c_name']}></td>
                    <td><{$item['a_name']}></td>
                    <td id="status_<{$item['sb_id']}>">
                        <!--
                        <span class="label label-sm label-<{$color[$item['sb_status']]}>"><{$statusDesc[$item['sb_status']]}></span>
                        -->
                        <span class="<{$fontColor[$item['sb_status']]}>"><{$statusDesc[$item['sb_status']]}></span>
                    </td>
                    <td>
                        <{if $item['sb_status'] eq 0 }>
                            <a href="javascript:void();" id="audit_<{$item['sb_id']}>" class="btn btn-primary btn-xs btn-audit" data-id="<{$item['sb_id']}>">审核</a>
                        <{/if}>

                        <{if $item['sb_status'] eq 1 || $item['sb_status'] eq 2 }>
                        <a href="javascript:void();" onclick="branchHide(this)" class="btn btn-danger btn-xs" data-id="<{$item['sb_id']}>">删除</a>
                        <{/if}>

                        <!--<a href="javascript:void();" class="btn btn-danger btn-xs btn-del" data-id="<{$item['sb_id']}>">删除</a>-->
                    </td>
                </tr>
                <{/foreach}>
            <{if $paginator}>
                 <tr><td colspan="7"><{$paginator}></td></tr>
            <{/if}>
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
    <div id="modal-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">审核处理</h4>
                </div>
                <div class="modal-body" style="padding: 10px 20px;">
                    <form class="form-inline">
                        <input type="hidden" id="hid_id" value="0">
                        <div class="checkbox col-sm-12" style="margin-bottom: 5px;">
                            <!-- <label>审核状态 ： &nbsp;&nbsp;</label>
                            <label>
                                <input type="radio" name="status" checked value="1"> &nbsp; 通 &nbsp; 过 &nbsp;
                            </label>
                            <label>
                                <input type="radio" name="status" value="2">  &nbsp; 拒 &nbsp; 绝 &nbsp;
                            </label> -->
                            <label><b>审核状态</b></label>
                            <div class="radio-box">
                                <span>
                                    <input type="radio" name="status" value="1" id="status1" checked>
                                    <label for="status1">通过</label>
                                </span>
                                <span>
                                    <input type="radio" name="status" value="2" id="status2">
                                    <label for="status2">拒绝</label>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label><b>审核备注</b></label>
                            <textarea type="text" class="form-control" id="note" name="note" rows="3" cols="80" placeholder="请输入审核备注"></textarea>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save" >保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $('.btn-audit').on('click',function(){
        var id = $(this).data('id');
        $('#hid_id').val(id);
        $('#modal-form').modal('show');
    });
    $('.modal-save').on('click',function(){
        var data = {
            'id'     : $('#hid_id').val(),
            'status' : $('input[name="status"]:checked').val()
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{time:10*1000});

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/branch/status',
            'data'  : data,
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);

                if(json_ret.ec == 200){
                    var statusNote = '';
                    switch (data.status){
                        case "1" :
                            statusNote = '<span class="label label-sm label-success">审核通过</span>';
                            break;
                        case "2" :
                            statusNote = '<span class="label label-sm label-danger">审核拒绝</span>';
                            break;
                    }
                    if(statusNote){
                        $('#status_'+data.id).html(statusNote);
                        $('#audit_'+data.id).hide();
                    }
                    $('#modal-form').modal('hide');
                }else{
                    window.location.reload();
                }
            }

        })
    });

    function reCreateQrcode(){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/three/createQrcode',
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(JSON.stringify(ret));
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#three-qrcode').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }

    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('id')
        };
        layer.confirm('您确定要删除分店吗？', {
            btn: ['删除','取消'] //按钮
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/branch/delete',
                'data'  : data,
                'dataType'  : 'json',
                success : function(json_ret){
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        $('#tr_'+data.id).hide();
                    }
                }

            })
        });
    });


    function branchHide(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/branch/branchHide',
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
</script>


