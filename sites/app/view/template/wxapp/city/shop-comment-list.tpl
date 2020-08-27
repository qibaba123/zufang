<meta http-equiv="Content-Type" content="text/html; charset=utf8mb4" />
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .search-box .form-group{
        margin-bottom: 10px !important;
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
        width: calc(100% / 4);
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

    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "\a0\a0允许\a0\a0\a0\a0\a0\a0\a0不允许"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }


</style>

<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
    <div class="balance-info">
        <div class="balance-title">全部评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">5分评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total_5']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">4分评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total_4']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">3分评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total_3']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">2分评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total_2']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">1分评论<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['total_1']}></span>
        </div>
    </div>

</div>

<div class="page-header">
    <span style="">
        允许评论商家：
        <label id="choose-onoff" class="choose-onoff">
            <input name="sms_start" class="ace ace-switch ace-switch-5" id="shopComment" data-type="open" onchange="changeOpen()" type="checkbox" <{if $curr_shop && $curr_shop['s_shop_comment']}> checked<{/if}>>
            <span class="lbl"></span>
        </label>
    </span>
</div>


<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/city/commentList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">评论人昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="评论人微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">商家名称</div>
                            <input type="text" class="form-control" name="shopName" value="<{$shopName}>"  placeholder="商家名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">评论内容</div>
                            <input type="text" class="form-control" name="content" value="<{$content}>"  placeholder="评论内容">
                        </div>
                    </div>
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">评论时间：</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                                <em style="padding:0 3px;">到</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="<{$status}>">
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 35%;right: 2%;">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>                            
                            <th>评论人头像</th>
                            <th>评论人</th>
                            <th>商家名称</th>
                            <th>评分</th>
                            <th>评论内容</th>
                            <th>评论时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acs_id']}>">                               
                                <td><img src="<{$val['m_avatar']}>" width="50" style="border-radius:4px;"></td>
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><{$val['shopName']}></td>
                                <td><{$val['acs_stars']}></td>
                                <td style="max-width: 500px;overflow: hidden"><{$val['acs_comment']}></td>
                                <td><{if $val['acs_time'] > 0}><{date('Y-m-d H:i',$val['acs_time'])}><{/if}></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/city/commentDetails/id/<{$val['acs_id']}>">详情</a> -
                                    <a href="#" id="delete-confirm" data-id="<{$val['acs_id']}>" onclick="deleteComment('<{$val['acs_id']}>')" style="color:red;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="8"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    回复评论
                </h4>
                <input type="hidden" id="c_id" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">回复：</label>
                        <div class="col-sm-12">
                            <textarea name="comment_reply" id="comment_reply" class="form-control" rows="5" placeholder="请输入回复内容"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认回复
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");

    });
    function deleteComment(id) {
        //var id = $(this).data('id');
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            console.log(id);
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/city/deleteComment',
                'data'  : { cid:id},
                'dataType'  : 'json',
                'success'  : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

    }

    function changeOpen() {
        var open   = $('#shopComment:checked').val();
        console.log(open);
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/changeShopCommentOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }

//    function replyComment(id) {
//        $('#c_id').val(id);
//    }

//    $('#conform-update').on('click',function () {
//        var c_id = $('#c_id').val();
//        var reply = $('#comment_reply').val();
//        if(c_id){
//            var data = {
//                cid       : c_id,
//                reply  : reply
//            };
//            var load_index = layer.load(2,
//                {
//                    shade: [0.1,'#333'],
//                    time: 10*1000
//                }
//            );
//            $.ajax({
//                'type'      : 'post',
//                'url'       : '/wxapp/city/replyComment',
//                'data'      : data,
//                'dataType'  : 'json',
//                'success'   : function(ret){
//                    layer.close(load_index);
//                    layer.msg(ret.em);
//                    if(ret.ec == 200){
//                        window.location.reload();
//                    }
//                }
//            });
//        }
//    })
</script>
