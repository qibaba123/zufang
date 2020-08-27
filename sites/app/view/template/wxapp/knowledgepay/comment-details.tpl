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
            <h3>评论信息</h3>
        </div>
        <div class="code-version-con">
            <{$comment['akc_comment']}>
        </div>
    </div>
</div>

<{if $commentList}>
    <div class="version-item-box" style="width: 96%;margin-left: 2%;">
        <div class="code-version-title">
            <h3>回复</h3>
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
                                    <th>回复评论人</th>
                                    <th>评论内容</th>
                                    <th>评论时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <{foreach $commentList as $val}>
                                    <tr id="tr_<{$val['acp_id']}>">
                                        <td style="max-width: 120px"><{if $val['akc_m_id'] == -1}><{$curr_shop['s_name']}><{else}><{$val['m_nickname']}><{/if}></td>
                                        <td>
                                            <{if $val['akc_reply_mid']>0 && $val['rm_nickname']}><a href="#"><{$val['rm_nickname']}></a>
                                            <{else}>
                                            <{if $val['akc_reply_mid'] == -1}>
                                            <{$curr_shop['s_name']}>
                                            <{else}>
                                            无
                                            <{/if}>
                                            <{/if}>
                                        </td>
                                        <td style="max-width: 200px;white-space: normal;overflow: hidden"><{$val['akc_comment']}></td>
                                        <td><{if $val['akc_time'] > 0}><{date('Y-m-d H:i',$val['akc_time'])}><{/if}></td>
                                        <td>

                                            <a href="#" id="delete-confirm" onclick="deletePostComment('<{$val['akc_id']}>')" >删除</a>
                                        </td>
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

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
    });




</script>