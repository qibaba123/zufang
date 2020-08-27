<{if $notice_alert}>
<style>
    .close{
        outline: none;
    }
    .contxt-wrap{
        font-size: 15px;
        line-height: 1.8;
        color: #666;
        min-height: 380px;
        max-height: 450px;
        overflow: auto;
        padding: 15px 20px;
    }
    .contxt-wrap p{
        margin: 0;
        text-indent: 2em;
    }
    .modal-dialog{
        padding-top: 5%;
    }
</style>
<div class="modal fade" id="myModalIntro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;padding: 15px 20px;background-color: #f6f7f8">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalIntroLabel" style="font-size: 20px;padding-right:40px;" id="notice-alert-title">
                    <{$notice_alert['title']}>
                </h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="contxt-wrap" id="notice-alert-content">
                    <{$notice_alert['content']}>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    $(function(){
        $(".contxt-wrap").niceScroll({
            cursorwidth:"7px",
            cursorborder:"0",
            cursorcolor:"#666",
            cursoropacitymax:"0.5",
            // autohidemode:false
        });
        //有未读信息
        if('<{$notice_alert['status']}>' == '200' ){
            $('#myModalIntro').modal('show');
        }
    })
</script>
<{/if}>