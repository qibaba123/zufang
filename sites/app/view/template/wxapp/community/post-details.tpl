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

</style>
<div class="version-manage">
    <div class="version-item-box">
        <div class="code-version-title">
            <h3>帖子信息</h3>
            <div style="float:right;width: 300px">
                <span style="font-size: 16px">帖子审核<span style="font-size: 10px">（如果封禁帖子将不会在手机端显示）</span></span>
                <span class='tg-list-item'>
                     <input class='tgl tgl-light' id='post_status' type='checkbox' onchange="postStatusChange()" <{if $post && $post['acp_status']}>checked<{/if}> >
                     <label class='tgl-btn' for='post_status'></label>
                </span>
            </div>
        </div>
        <div class="code-version-con">
            <{$post['acp_content']}>
            <div>
                <{if $post['acp_images']}>
                <div class="infopic">
                    <div class="picbox">
                        <ul class="gallery piclist">
                            <{foreach $post['acp_images'] as $val}>
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
    <div class="version-item-box">
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
        </div>
    </div>
    <{/if}>
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
            pid : '<{$post['acp_id']}>',
            status : status ? 1 : 0
        };
//        var index = layer.load(10, {
//            shade: [0.6,'#666']
//        });
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/postStatusChange',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
               // layer.close(index);
               // layer.msg(ret.em);
                if(ret.ec == 200){
                    console.log(data);
                   // window.location.reload();
                }
            }
        });
    }
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
            'url'   : '/wxapp/community/deletePostComment',
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
    }

</script>