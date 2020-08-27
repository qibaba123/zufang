<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 09:11:42
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/mall-template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1222741615e853bcee38d14-53232018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b92b03766060286c8efb7026d4be66db8e9fbc6e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/mall-template.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1222741615e853bcee38d14-53232018',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'list' => 0,
    'val' => 0,
    'cfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e853bcee75d31_96299799',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e853bcee75d31_96299799')) {function content_5e853bcee75d31_96299799($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/applet/applet-temp.css?2">
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
            <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['it_img'];?>
<?php } else { ?>/public/manage/images/tem1.png<?php }?>" alt="模板">
        </div>
        <div class="opera-box">
            <a href="/manage/applet/fixture?tpl=<?php echo $_smarty_tpl->tpl_vars['row']->value['it_id'];?>
" class="btn btn-md btn-blue edit">编辑模版</a>
        </div>
    </div> -->
    <h3 class="cst_h3">首页模板</h3>
    <div class="all-template">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li <?php if ($_smarty_tpl->tpl_vars['val']->value['it_id']==$_smarty_tpl->tpl_vars['row']->value['it_id']) {?>class="usingtem" <?php }?>>
            <div class="temp-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['it_img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['it_name'];?>
">
                <div class="use-edit">
                    <a href="javascript:;" class="btn btn-xs btn-green js_btn-preview" data-src="<?php echo $_smarty_tpl->tpl_vars['val']->value['it_img'];?>
">预览</a>
                    <a href="#" class="btn btn-xs btn-success btn-start" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['it_id'];?>
">启用</a>
                    <a href="/wxapp/mall/fixture?tpl=<?php echo $_smarty_tpl->tpl_vars['val']->value['it_id'];?>
" class="btn btn-xs btn-primary">编辑</a>
                </div>
            </div>
            <p><?php echo $_smarty_tpl->tpl_vars['val']->value['it_name'];?>
</p>
            </li>
            <?php } ?>
            <?php if ($_smarty_tpl->tpl_vars['cfg']->value['ac_type']!=5&&$_smarty_tpl->tpl_vars['cfg']->value['ac_type']!=2) {?>
            <li <?php if ($_smarty_tpl->tpl_vars['cfg']->value['ac_index_tpl']==0) {?> class="usingtem" <?php }?>>
            <div class="temp-img" style="text-align: center">
                <img src="/public/wxapp/customtpl/images/custom-tpl-edit.jpg" style="height: 106px;margin-top: 80px;width: 82px;" alt="自定义模板编辑">
                <div class="use-edit">
                    <a href="#" class="btn btn-xs btn-success btn-start" data-id="0">启用</a>
                    <a href="/wxapp/customtpl/setting" class="btn btn-xs btn-primary">编辑</a>
                </div>
            </div>
            <p>自定义模板</p>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
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
        layer.confirm('启用新模板时请确保您的小程序版本是最新版本，<a href="/wxapp/setup/code">查看版本</a> ', {
            title: '确认',
            btn: ['确定','取消']    //按钮
        }, function(){
            var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mall/startAppletTpl',
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
        }, function() {
            $('#myModal').modal('hide');
        });
    })

</script><?php }} ?>
