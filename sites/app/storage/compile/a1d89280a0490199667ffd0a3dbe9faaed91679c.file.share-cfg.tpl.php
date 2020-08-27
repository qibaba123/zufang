<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:44:30
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/share-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10838226715dea14ee22b0d2-09414841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1d89280a0490199667ffd0a3dbe9faaed91679c' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/share-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10838226715dea14ee22b0d2-09414841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea14ee263aa2_93962095',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea14ee263aa2_93962095')) {function content_5dea14ee263aa2_93962095($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/share/css/index.css">
<link rel="stylesheet" href="/public/wxapp/share/css/style.css">
<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }

    .label-left{
        display: inline-block;
    }
    .span-right{
        display: inline-block;
        margin-left: 10px;
    }
    .edit-con .cus-input{
        padding: 5px 8px !important;
    }
    .open{
        position: relative;
    }
    .img-tips{
        font-size: 13px;
        color: #999;
        font-weight: normal;
    }
</style>
<div class="authorize-tip flex-wrap">
    <div class="shop-logo">
        <img src="/public/wxapp/setup/images/weixin_share.png" alt="logo">
    </div>
    <div class="flex-con">
        <h4>分享小程序到微信单聊、群聊、朋友圈</h4>
        <p class="state" style="color: #999;">
            <span>分享到微信朋友圈需要引导用户保存海报,然后选择朋友圈发布!&nbsp;&nbsp;&nbsp;<!--<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=281&extra=" target="_blank" style="color: blue">查看教程</a>--></span>
        </p>
    </div>
    <div>
        <?php if ($_smarty_tpl->tpl_vars['row']->value['ac_share_open']) {?>
        <a href="javascript:void(0)" onclick="openShare(this,event)" data-open="0" class="btn btn-sm btn-danger">关闭分享</a>
        <?php } else { ?>
        <a href="javascript:void(0)" onclick="openShare(this,event)" data-open="1" class="btn btn-sm btn-green">开启分享</a>
        <?php }?>
    </div>
</div>
<div class="preview-page">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit">
                海报图片
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="post-wrap cur-edit" data-left-preview>
                        <div class="post-img">
                            <img id="previewImg" src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_addr']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_addr'];?>
<?php } else { ?>/public/wxapp/share/images/haibao.png<?php }?>" alt="海报图片" >
                        </div>
                    </div>
                    <div class="opera-btn">
                        <span class="orange-btn">分享给朋友</span>
                        <span class="green-btn">保存卡片</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div class="poster-manage" style="display: block;">
                <div class="applet-code">
                    <p>小程序二维码</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['ac_wxacode'];?>
" alt="二维码图片" >
                   	<a href="/wxapp/setup/downloadQrcode" class="btn btn-sm btn-green">下载二维码</a>
                </div>
                <div class="input-group" style="margin-bottom: 10px;margin-top: 10px">
                    <div class="open">
                        <label class="label-left" style="letter-spacing: 0.5px;
font-weight: bold;">开启自定义分享</label>
                        <span class="span-right tg-list-item" style="margin-left: 10px;position: relative;
top: 10px;">
                        <input class='tgl tgl-light' id='share_custom' type='checkbox'  <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_custom']==1) {?>checked<?php }?>>
                        <label class='tgl-btn' for='share_custom'></label>
                        </span>
                        </div>
                </div>

                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="" class="label-left">自定义标题</label>
                    <span class="span-right" style="width: 300px"><input type="text" class="cus-input" placeholder="请输入分享标题" id="share_title" maxlength="30" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_title']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_title'];?>
<?php }?>"></span>
                </div>
                <div class="poster-img" style="margin-bottom: 10px;">
                    <label for="">自定义封面<span class="img-tips">（图片建议尺寸500px*400px）</span></label>
                    <div class="cropper-box" data-width="500" data-height="400" >
                        <img style="width: 40% !important;" src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_555_480.png<?php }?>" onload="" />
                        <input type="hidden" id="share_cover" name="cover" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_cover'];?>
<?php }?>" />
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['ac_type']==33||$_smarty_tpl->tpl_vars['row']->value['ac_type']==34) {?>
                <label>海报宣传图片<span>（图片建议尺寸600px*600px）</span></label>
                <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ac_type']!=30) {?>
                <label>海报宣传图片<span>（图片建议尺寸600px*855px）</span></label>
                <?php } else { ?>
                <label>海报宣传图片<span>（图片建议尺寸600px*600px）</span></label>
                <?php }?>
                <div class="poster-img">
                    <div class="cropper-box" data-width="600" <?php if ($_smarty_tpl->tpl_vars['row']->value['ac_type']==33||$_smarty_tpl->tpl_vars['row']->value['ac_type']==34) {?>data-height="600"<?php } elseif ($_smarty_tpl->tpl_vars['row']->value['ac_type']!=30) {?>data-height="855"<?php } else { ?>data-height="600"<?php }?>>
                        <img src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_addr']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_addr'];?>
<?php } else { ?>/public/wxapp/share/images/haibao.png<?php }?>" onload="imgSrcChange(this)" />
                        <input type="hidden" id="share_addr" name="img" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_share_addr']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ac_share_addr'];?>
<?php }?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" onclick="saveShareImg()">  保 存 </button></div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function imgSrcChange(elem) {
        var imgSrc = $(elem).attr('src');
        if(imgSrc){
            $('#previewImg').attr('src',imgSrc);
        }
    }

    function openShare(obj, event) {
        var open    = $(obj).data('open');
        var msg     = open ? '开启分享' : '关闭分享?';
        layer.msg(msg, {
            time: 0
            ,btn: ['确定', '取消']
            ,yes: function (index) {
                layer.close(index);
                var loading = layer.load(2, {time: 10*1000});
                $.ajax({
                    type    : 'post',
                    url     : '/wxapp/currency/openShare',
                    data    : 'open='+open,
                    dataType: 'json',
                    success : function(ret){
                        layer.close(loading);
                        location.reload();
                    }
                });
            }
        });
    }

    function saveShareImg() {
        var shareImg   = $('#share_addr').val();
        var shareCover = $('#share_cover').val();
        var shareCustom= $('#share_custom').is(':checked');
        var shareTitle = $('#share_title').val();
        if(shareImg || shareCover){
            var loading = layer.load(2, {time: 10*1000});

            var data = {
                shareImg : shareImg,
                shareCover : shareCover,
                shareCustom : shareCustom ? 1 : 0 ,
                shareTitle : shareTitle
            };
            console.log(data);
            $.ajax({
                type    : 'post',
                url     : '/wxapp/currency/openShareImg',
                data    : data,
                dataType: 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                }
            });
        }else {
            layer.msg('请上传宣传海报或封面图');
        }
    }


</script>
<?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>

<?php }} ?>
