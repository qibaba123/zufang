<link rel="stylesheet" href="/public/manage/applet/applet-temp.css?2">
<style>
    .all-template li .use-edit .btn { margin: 0 auto; }
    .preview-modal { position: fixed; left: 0; top: 0; height: 100%; width: 100%; overflow: auto; background-color: rgba(0, 0, 0, .5); display: none; z-index: 2000; }
    .preview-modal .mask { position: absolute; left: 0; top: 0; width: 100%; height: 100%; z-index: 1; }
    .preview-modal .preview-box { position: relative; width: 50%; max-width: 480px; margin: 0 auto; display: block; z-index: 3; padding: 20px 0; }
    .preview-modal .preview-box img { width: 100%; display: block; }
</style>
<div id="mainContent" class="choose-template">
    <!-- <h3 class="cst_h3">当前使用的模板</h3>

    <div class="using-template" style="overflow: hidden;">
        <div class="using-preview">
            <img src="<{if $row}><{$row['it_img']}><{else}>/public/manage/images/tem1.png<{/if}>" alt="模板">
        </div>
        <div class="opera-box">
            <a href="/manage/applet/fixture?tpl=<{$row['it_id']}>" class="btn btn-md btn-blue edit">编辑模版</a>
        </div>
    </div> -->
    <h3 class="cst_h3">首页模板</h3>
    <div class="all-template">
        <ul>
            <{foreach $list as $val}>
        <li <{if $val['it_id'] == $row['it_id']}>class="usingtem" <{/if}>>
            <div class="temp-img">
                <img src="<{$val['it_img']}>" alt="<{$val['it_name']}>">
                <div class="use-edit">
                    <a href="javascript:;" class="btn btn-xs btn-green js_btn-preview" data-src="<{$val['it_img']}>">预览</a>
                    <a href="#" class="btn btn-xs btn-success btn-start" data-id="<{$val['it_id']}>">启用</a>
                    <a href="/wxapp/city/indexTpl?tpl=<{$val['it_id']}>" class="btn btn-xs btn-primary">编辑</a>
                </div>
            </div>
            <p><{$val['it_name']}></p>
            </li>
            <{/foreach}>
            <li <{if $cfg['ac_index_tpl'] == 0}> class="usingtem" <{/if}>>
            <div class="temp-img" style="text-align: center">
                <img src="/public/wxapp/customtpl/images/custom-tpl-edit.jpg" style="height: 106px;margin-top: 80px;width: 82px;" alt="自定义模板编辑">
                <div class="use-edit">
                    <a href="#" class="btn btn-xs btn-success btn-start" data-id="0">启用</a>
                    <a href="/wxapp/customtpl/setting" class="btn btn-xs btn-primary">编辑</a>
                </div>
            </div>
            <p>自定义模板</p>
            </li>
        </ul>
    </div>
</div>
<!-- 模板预览 -->
<div class="preview-modal" id="previewModal">
    <div class="mask"></div>
    <div class="preview-box" id="previewBox">
        <img src="" alt="预览模板">
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $(document).ready(function(){
        $(".js_btn-preview").on('click', function(event) {
            event.preventDefault();
            var imgsrc = $(this).data('src');
            $("#previewBox").find('img').attr("src",imgsrc);
            $("#previewModal").stop().fadeIn();
        });
        $("#previewModal").on('click', function(event) {
            event.preventDefault();
            $(this).stop().fadeOut();
        });
        $("#previewModal #previewBox").on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
    });
    // 启用模板
    $('.btn-start').on('click',function(){
        var data = {
            'id'	: $(this).data('id')
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/startAppletTpl',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })
</script>