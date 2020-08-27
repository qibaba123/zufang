<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?11">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/lrtk.css?1">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<style>
    .tgl-light+.tgl-btn {
        background: #00CA4D;!important;
    }
    .tgl-light:checked+.tgl-btn {
        background: red;!important;
    }
    *{
        font-size: 14px;
    }

</style>
<div class="version-manage">
    <div class="version-item-box">
        <div class="code-version-title">
            <h3>帖子信息</h3>
            <!--
            <a href="#" data-toggle="modal" data-target="#myModal" onclick="replyComment(0, 0, '<{$post['acp_id']}>')" >回复</a>
            -->

            <div style="float:right;width: 300px">
                <span style="font-size: 16px">帖子审核<span style="font-size: 10px">（如果封禁帖子将不会在手机端显示）</span></span>
                <span class='tg-list-item'>
                     <input class='tgl tgl-light' id='post_status' type='checkbox' onchange="postStatusChange()" <{if $post && $post['asp_status']}>checked<{/if}> >
                     <label class='tgl-btn' for='post_status'></label>
                </span>
            </div>
        </div>
        <div class="code-version-con">
            <{$post['asp_content']}>
            <div>
                <{if $imgList}>
                <div class="infopic">
                    <div class="picbox">
                        <ul class="gallery piclist">
                            <{foreach $imgList as $val}>
                            <li><a href="<{$val}>" rel="prettyPhoto[]"><img src="<{$val}>" /></a></li>
                            <{/foreach}>
                        </ul>
                    </div>
                    <div class="pic_prev"></div>
                    <div class="pic_next"></div>
                </div>
                <{/if}>
            </div>

        </div>
    </div>
    <{if $commentList}>
    <!--<div class="version-item-box">
        <div class="code-version-title">
            <h3>帖子评论</h3>
        </div>
        <div class="code-version-con">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                    <tbody>
                    <{foreach $commentList as $val}>
                        <tr>
                            <td>
                                <{if $val['acc_reply_mid']>0 && $val['rm_nickname']}><a href="#"><{$val['m_nickname']}></a> 回复 <a href="#"><{$val['rm_nickname']}></a> <{$val['acc_comment']}>
                                <{else}>
                                <a href="#"><{$val['m_nickname']}></a> 评论  <{$val['acc_comment']}>
                                <{/if}>
                            </td>
                            <td><a href="#" style="color: red" id="delete-confirm" onclick="deletePostComment('<{$val['acc_id']}>')" >删除</a></td>
                        </tr>
                    <{/foreach}>
                    <tr><td colspan="2"><{$pagination}></td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        <!--</div>
    </div>-->
    <div class="version-item-box" style="width: 90%;margin-left: 5%;">
        <div class="code-version-title" style="margin-bottom: 5px">
            <h3>帖子评论</h3>
        </div>
        <div style="display:none;width: 100%;text-align: right;margin-bottom: 5px">如果封禁评论将不会在手机端显示</div>
        <div id="content-con">
            <div  id="mainContent" >
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-hover table-avatar" style="border: none">
                                <thead>
                                <tr>
                                    <th>评论人</th>
                                    <th>回复评论人</th>
                                    <th>评论内容</th>
                                    <th>评论时间</th>
                                    <th>操作</th>
                                    <!--
                                    <th style="width: 50px"> 评论审核</th>
                                    -->
                                </tr>
                                </thead>
                                <tbody>
                                <{foreach $commentList as $val}>
                                    <tr id="tr_<{$val['asp_id']}>">
                                        <td style="max-width: 120px"><{if $val['aspc_m_id'] == -1}><{$curr_shop['s_name']}><{else}><{$val['m_nickname']}><{/if}></td>
                                        <td>
                                            <{if $val['aspc_reply_mid']>0 && $val['rm_nickname']}><span style=""><{$val['rm_nickname']}></span>
                                            <{else}>
                                                <{if $val['aspc_reply_mid'] == -1}>
                                                <{$curr_shop['s_name']}>
                                                <{else}>
                                                无
                                                <{/if}>
                                            <{/if}>
                                        </td>
                                        <td style="max-width: 200px;white-space: normal;overflow: hidden"><{$val['aspc_content']}></td>
                                        <td><{if $val['aspc_time'] > 0}><{date('Y-m-d H:i',$val['aspc_time'])}><{/if}></td>
                                        <td>
                                            <!--
                                            <a href="#" data-toggle="modal" data-target="#myModal" onclick="replyComment('<{$val['aspc_id']}>', '<{$val['aspc_m_id']}>', '<{$val['aspc_asp_id']}>')" >回复</a>-
                                            -->

                                            <a href="#" id="delete-confirm" onclick="deletePostComment('<{$val['aspc_id']}>')" style="color: red">删除</a>
                                        </td>
                                        <!--
                                        <td>
                                            <span class='tg-list-item'>
                     <input class='tgl tgl-light comment-show' id="comment_show<{$val['aspc_id']}>" type='checkbox' onchange="commantShowChange(<{$val['aspc_id']}>)" <{if $val['aspc_show'] == 0}>checked<{/if}> >
                     <label class='tgl-btn' for='comment_show<{$val['acc_id']}>'></label>
                </span>
                                        </td>
                                        -->
                                    </tr>
                                    <{/foreach}>
                                <tr>
                                    <td colspan="9"><{$pagination}></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /span -->
                </div><!-- /row -->
                <!-- PAGE CONTENT ENDS -->
            </div>
        </div>
    </div>
    <{/if}>
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
                    评论回复
                </h4>
                <input type="hidden" id="reply_id" value="">
                <input type="hidden" id="reply_mid" value="">
                <input type="hidden" id="reply_pid" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">回复内容：</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" rows="5" maxlength="5000" id="reply-content" name="content" placeholder="回复内容" style="max-width: 850px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        提交
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
    })
    
    function postStatusChange() {
        var status = $('#post_status').is(':checked');
        var data = {
            pid : '<{$post['asp_id']}>',
            status : status ? 1 : 0
        };
//        var index = layer.load(10, {
//            shade: [0.6,'#666']
//        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/postStatusChange',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
               // layer.close(index);
               // layer.msg(ret.em);
                if(ret.ec == 200){
                   // window.location.reload();
                }
            }
        });
    }

    function replyComment(id, mid, pid) {
        $('#reply_id').val(id);
        $('#reply_mid').val(mid);
        $('#reply_pid').val(pid);
    }

    $('#conform-update').on('click',function () {
        var replyId = $('#reply_id').val();
        var replyMid = $('#reply_mid').val();
        var replyPid = $('#reply_pid').val();
        var replyContent = $('#reply-content').val();

        if(reply_id && replyContent){
            var data = {
                cid      : replyId,
                cmid     : replyMid,
                pid      : replyPid,
                content  : replyContent
            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/city/commentPost',
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

    function deletePostComment(id) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/deletePostComment',
                'data'  : { id:id},
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
    function commantShowChange(id) {
        var show = $('#comment_show'+id).is(':checked');
        var data = {
            id     : id,
            show : show ? 0 : 1
        };
//        var index = layer.load(10, {
//            shade: [0.6,'#666']
//        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/commentShowChange',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                // layer.close(index);
                // layer.msg(ret.em);
                if(ret.ec == 200){
                    // window.location.reload();
                }
            }
        });
    }

</script>