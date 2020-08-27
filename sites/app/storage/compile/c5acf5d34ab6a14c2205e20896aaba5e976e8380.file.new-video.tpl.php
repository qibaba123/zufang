<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:44:22
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/new-video.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20060464775e4df286bd5433-77502594%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5acf5d34ab6a14c2205e20896aaba5e976e8380' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/new-video.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20060464775e4df286bd5433-77502594',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df286c071c8_93669269',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df286c071c8_93669269')) {function content_5e4df286c071c8_93669269($_smarty_tpl) {?><style>
    .password-redpack .info-title{
        padding:10px 0;
        border-bottom: 1px solid #eee;
    }
    .password-redpack .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .password-redpack .input-table{
        width: 100%;
    }
    .password-redpack .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .password-redpack .input-table td>div{
        display: inline-block;
        vertical-align: middle;
    }
    .password-redpack .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .password-redpack label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 145px;
        line-height: 34px;
    }
    .password-redpack .input-table .form-control{
        width: 400px;
    }
    .password-redpack {
        margin-left: 140px;
    }
    .password-redpack .input-group .form-control{
        width: 120px;
    }

    .input-table textarea.form-control{
        width: 100%;
        max-width: 750px;
        height: auto;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--<div class="alert alert-block alert-success" style="margin-left: 130px">
    <ol>
        <li>
            <small>视频配置教程：<a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=347&extra=%EF%BC%89" class="xxmb-bnt" target="_blank">https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=347&extra=%EF%BC%89</a></small>
        </li>
    </ol>
</div>-->
<div class="password-redpack">
    <h4 class="info-title"><span>添加展示视频</span></h4>
    <form id="keyword-redpack">
        <table class="input-table">
            <tr>
                <td class="label-td"><label><span class="red">*</span>开启视频:</label></td>
                <td>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='video_is_open' type='checkbox' onclick="showCfg()" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_is_open']) {?>checked<?php }?>>
                        <label class='tgl-btn' for='video_is_open'></label>
                    </span>
                    <span style="color:#999;margin-top: 5px;display: inline-block;">提示：此处添加的视频用于小程序首页轮播图位置展示使用</span>
            </tr>
            <tr class="cfg-row" <?php if (!'row'||$_smarty_tpl->tpl_vars['row']->value['av_is_open']==0) {?>style="display:none;"<?php }?> >
                <td class="label-td"><label><span class="red">*</span>视频链接:</label></td>
                <td>
                    <div><textarea rows="3" id="videoUrl" name="videoUrl" class="form-control" placeholder="请填写视频链接"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_video_url']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['av_video_url'];?>
<?php }?></textarea>
                        <span style="color:#999;">说明：仅支持七牛云源链接，不支持腾讯、优酷的视频等网站链接；链接中不可出现中文，暂不支持苹果手机。</span>
                    </div>
                </td>
            </tr>
            <tr class="cfg-row" <?php if (!'row'||$_smarty_tpl->tpl_vars['row']->value['av_is_open']==0) {?>style="display:none;"<?php }?> >
                <td class="label-td"><label><span class="red">*</span>视频时长:</label></td>
                <td>
                    <div>
                        <input type="number" id="videoTime" style="height: 34px;" name="videoTime" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_time']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['av_time'];?>
<?php }?>" class="form-control" placeholder="请填写视频时长单位秒，2分15秒则填写135" />
                        <span style="margin-left: 410px;position: relative;top: -28px;font-size: 16px;font-weight: bold;">秒</span>
                    </div>
                </td>
            </tr>
            <tr class="cfg-row" <?php if (!'row'||$_smarty_tpl->tpl_vars['row']->value['av_is_open']==0) {?>style="display:none;"<?php }?> >
                <td class="label-td"></td>
                <td>
                    <a href="javascript:;" class="btn btn-sm btn-green" onclick="saveVideo()"> 保 存 </a>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>

<script>
    // 保存视频信息
    function saveVideo() {
        var videoUrl = $('#videoUrl').val();
        var videoTime = $('#videoTime').val();
        var open     = $('#video_is_open:checked').val();
        console.log(open);
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveVideoOpen',
            'data'  : { videoUrl:videoUrl,videoTime:videoTime,open:open == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
            }
        });
    }
    
    function showCfg() {
        var open     = $('#video_is_open:checked').val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveVideoOpenSwitch',
            'data'  : { open:open == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(ret.open == 1){
                        $('.cfg-row').css('display','');
                    }else{
                        $('.cfg-row').css('display','none');
                    }
                }
                layer.close(index);
            }
        });
    }
</script><?php }} ?>
