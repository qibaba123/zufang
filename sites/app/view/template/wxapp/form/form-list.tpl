<link rel="stylesheet" href="/public/manage/applet/applet-temp.css?2">
<style>
    .all-template li .use-edit .btn { margin: 0 auto; }
    .preview-modal { position: fixed; left: 0; top: 0; height: 100%; width: 100%; overflow: auto; background-color: rgba(0, 0, 0, .5); display: none; z-index: 2000; }
    .preview-modal .mask { position: absolute; left: 0; top: 0; width: 100%; height: 100%; z-index: 1; }
    .preview-modal .preview-box { position: relative; width: 50%; max-width: 480px; margin: 0 auto; display: block; z-index: 3; padding: 20px 0; }
    .preview-modal .preview-box img { width: 100%; display: block; }
</style>
<div id="mainContent" class="choose-template">
    <h3 class="cst_h3">自定义表单</h3>
    <div class="all-template">
        <ul>
            <{foreach $list as $val}>
        <li <{if $val['acf_selected'] == 1}>class="usingtem" <{/if}>>
            <div class="temp-img">
                <img src="<{if $val['acf_cover']}><{$val['acf_cover']}><{else}>/public/wxapp/customtpl/images/custom-tpl-edit.jpg<{/if}>" <{if !$val['acf_cover']}>style="margin-left: 45px;height: 106px;margin-top: 80px;width: 82px;"<{/if}> alt="<{$val['acf_header_title']}>">
                <div class="use-edit">
                    <a href="javascript:;" class="btn btn-xs btn-success btn-start" data-id="<{$val['acf_id']}>">启用</a>
                    <a href="/wxapp/form/index?id=<{$val['acf_id']}>" class="btn btn-xs btn-primary">编辑</a>
                    <a href="javascript:;" class="btn btn-xs btn-danger btn-delete" data-id="<{$val['acf_id']}>">删除</a>
                </div>
            </div>
            <div class="input-group copy-div" style="width: 175px;margin-top: 5px">
                <input type="text" class="form-control" id="copy<{$val['acf_id']}>" value="pages/generalForm/generalForm?id=<{$val['acf_id']}>" readonly style="width: 135px;">
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-action="copy" data-clipboard-target="#copy<{$val['acf_id']}>" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:40px;text-align:center">复制</a>
                </span>
            </div>
            <p><{$val['acf_header_title']}></p>
            </li>
            <{/foreach}>
            <li>
            <div class="temp-img" style="text-align: center;position: relative;top: -40px;">
                <img src="/public/wxapp/customtpl/images/custom-tpl-edit.jpg" style="height: 106px;margin-top: 80px;width: 82px;" alt="自定义表单编辑">
                <div class="use-edit">
                    <a href="/wxapp/form/index" class="btn btn-xs btn-primary">创建</a>
                </div>
            </div>
            <p>创建新表单</p>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/clipboard/clipboard.min.js"></script>

<script>
    // 复制通用js
    var clipboard = new ClipboardJS('.copy_input');
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    // 启用表单
    $('.btn-start').on('click',function(){
        var data = {
            'id'	: $(this).data('id')
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/form/startFormTpl',
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

    //删除表单
    $('.btn-delete').on('click',function(){
        var data = {
            'id'	: $(this).data('id')
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/form/delFormTpl',
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