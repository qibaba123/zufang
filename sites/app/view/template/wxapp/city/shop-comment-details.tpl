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

            <!--<div style="float:right;width: 300px">
                <span style="font-size: 16px">回复评论</span></span>
                <span class='tg-list-item'>
                     <a href="#" data-toggle="modal" data-target="#myModal" style="font-size: 16px;display: inline-block;margin-left: 15px;" onclick="replyComment('<{$post['gc_id']}>')">回复</a>
                </span>
            </div>-->
        </div>
        <div class="code-version-con">
            <{$post['acs_comment']}>
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
    <!--
    <{if $post['gc_reply']}>
    <div class="version-item-box">
        <div class="code-version-title">
            <h3>评论回复</h3>
        </div>
        <div class="code-version-con">
            <div class="table-responsive">
                <{$post['gc_reply']}>
            </div><!-- /.table-responsive -->
        </div>
    </div>
    <{/if}>
    -->
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
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
    });

//    function replyComment(id) {
//        $('#c_id').val(id);
//    }
//
//    $('#conform-update').on('click',function () {
//        var c_id = $('#c_id').val();
//        var reply = $('#comment_reply').val();
//        if(c_id){
//            var data = {
//                cid       : c_id,
//                reply  : reply
//            };
//            var load_index = layer.load(2,
//                    {
//                        shade: [0.1,'#333'],
//                        time: 10*1000
//                    }
//            );
//            $.ajax({
//                'type'      : 'post',
//                'url'       : '/wxapp/order/replyComment',
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