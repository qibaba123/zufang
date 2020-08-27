<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?11">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/lrtk.css?1">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<div class="version-manage">
    <div class="version-item-box">
        <div class="code-version-title">
            <h3>评论列表</h3>
        </div>
        <div class="code-version-con">
            <{if $list}>
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td>
                                <{if ($val['aic_reply_mid'] > 0 && $val['rm_nickname']) || $val['aic_reply_mid'] == -1}>

                                <a href="#">
                                    <{if $val['aic_m_id'] == -1}>
                                    <{$appletCfg['ac_name']}>
                                    <{else}>
                                    <{$val['m_nickname']}>
                                    <{/if}>

                                </a> 回复 <a href="#">
                                <{if $val['aic_reply_mid'] == -1}>
                                <{$appletCfg['ac_name']}>
                                    <{else}>
                                <{$val['rm_nickname']}>
                                    <{/if}>
                            </a> <{$val['aic_comment']}>
                                <{else}>
                                <a href="#"><{$val['m_nickname']}></a> 评论  <{$val['aic_comment']}>
                                <{/if}>
                            </td>
                            <td><a href="#" style="color: red" id="delete-confirm" onclick="deletePostComment('<{$val['aic_id']}>')" >删除</a>
                                <a href="#"  data-toggle="modal" data-target="#myModal" class="reply-comment" data-id="<{if $val['aic_aic_id']}><{$val['aic_aic_id']}><{else}><{$val['aic_id']}><{/if}>" data-mid="<{$val['aic_m_id']}>" data-aid="<{$val['aic_ai_id']}>" >回复</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    <tr><td colspan="2"><{$pagination}></td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
            <{else}>
            <div><p style="font-size: 18px">暂无评论信息</p></div>
            <{/if}>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="hid_mid" >
            <input type="hidden" id="hid_aid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    回复
                </h4>
            </div>
            <div class="modal-body" style="">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea name="reply-comment" id="reply-comment" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-reply">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.reply-comment').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#hid_mid').val($(this).data('mid'));
        $('#hid_aid').val($(this).data('aid'));
        $('#reply-comment').text('');
    });

    function deletePostComment(id) {
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
            'url'   : '/wxapp/currency/deleteInformationComment',
            'data'  : { aid:id},
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

    $('#confirm-reply').on('click',function () {
        var cid = $('#hid_id').val();
        var mid = $('#hid_mid').val();
        var aid = $('#hid_aid').val();
        var content = $('#reply-comment').val();

        var data = {
          cid : cid,
          mid : mid,
          aid : aid,
          content : content
        };
        console.log(data);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/currency/replyInformationComment',
            'data'  : data,
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

    })


</script>