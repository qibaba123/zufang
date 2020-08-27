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
</style>
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/hotel/commentList" method="get">
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
            <div class="col-xs-1 pull-right search-btn">
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
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>评论人</th>
                            <th>评论人头像</th>
                            <th>入住门店</th>
                            <th>入住房间</th>
                            <th>评论内容</th>
                            <th>评论时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acp_id']}>">
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><img src="<{$val['m_avatar']}>" width="50"></td>
                                <td><{$val['ahs_name']}></td>
                                <td><{$val['g_name']}></td>
                                <td style="max-width: 500px;overflow: hidden"><{$val['gc_content']}></td>
                                <td><{if $val['gc_create_time'] > 0}><{date('Y-m-d H:i',$val['gc_create_time'])}><{/if}></td>
                                <td>
                                    <a href="/wxapp/hotel/commentDetails/id/<{$val['gc_id']}>">详情</a>--
                                    <{if !$val['gc_reply']}>
                                    <a href="#" data-toggle="modal" data-target="#myModal" onclick="replyComment('<{$val['gc_id']}>')">回复</a>--
                                    <{/if}>
                                    <a href="#" id="delete-confirm" data-id="<{$val['acp_id']}>" onclick="deleteComment('<{$val['gc_id']}>')" >删除</a>
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
        $(".form-group-box .form-container").css("width",sumWidth+"px");

    });
    function deleteComment(id) {
        //var id = $(this).data('id');
        console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/hotel/deleteComment',
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
    }

    function replyComment(id) {
        $('#c_id').val(id);
    }

    $('#conform-update').on('click',function () {
        var c_id = $('#c_id').val();
        var reply = $('#comment_reply').val();
        if(c_id){
            var data = {
                cid       : c_id,
                reply  : reply
            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/hotel/replyComment',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    })
</script>
