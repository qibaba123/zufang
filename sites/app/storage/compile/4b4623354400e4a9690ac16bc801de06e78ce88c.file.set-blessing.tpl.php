<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:13:34
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/blessing/set-blessing.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8728315265dea1bbe8c4029-10199168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b4623354400e4a9690ac16bc801de06e78ce88c' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/blessing/set-blessing.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8728315265dea1bbe8c4029-10199168',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'blessingCfg' => 0,
    'notice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1bbe8f9946_16022914',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1bbe8f9946_16022914')) {function content_5dea1bbe8f9946_16022914($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
.table.table-avatar tbody>tr>td { line-height: 48px; }
body { min-width: 1200px; }
.main-container-inner, .page-content { background-color: #f8f8f8; }
.page-content { padding-top: 15px; }
.form-group input { width: 80%; }
.panel { width: 393px; margin-bottom: 15px; display: inline-block; vertical-align: top; margin-right: 10px; }
.panel form { padding-top: 20px; }
.pass-wrap { background-color: #fff; margin-bottom: 20px; box-shadow: 1px 1px 5px #ddd; }
.name-logo { overflow: hidden; padding: 15px 20px; border-bottom: 1px solid #e8e8e8; font-size: 16px; }
.name-logo .logo { height: 60px; width: 60px; border-radius: 50%; overflow: hidden; float: left; }
.name-logo .logo img { height: 100%; width: 100%; }
.name-logo .name-info { padding: 10px 0; margin-left: 75px; color: #333; font-size: 15px; }
.name-logo .name-info p { margin: 0; line-height: 20px; }
.name-logo .name-info p span { margin-left: 20px; cursor: pointer; color: #1766B1; font-size: 13px; }
.name-logo .name-info p span:hover { opacity: 0.9; }
.login-condition>div { padding: 20px; }
.login-condition .cur-login { border-right: 1px solid #e8e8e8; width: 400px; font-size: 14px; float: left; }
.login-condition .prev-login { margin-left: 400px; }
.login-condition p { margin: 0; padding-left: 10px; position: relative; margin-bottom: 8px; }
.login-condition p:before { content: ''; position: absolute; left: 0; height: 14px; width: 2px; top: 50%; margin-top: -7px; background-color: #1766B1; }
.login-condition .ip-address { font-size: 0; }
.login-condition .ip-address span { width: 160px; font-size: 14px; display: inline-block; }
.shop-logo{width: 90px;height: 90px;margin:0 auto;border-radius: 50%;overflow: hidden;margin-bottom: 18px;}
.shop-logo img{width: 100%;height: 100%;}

.business-time{
    width: 29% !important;
    display: inline-block !important;
    margin-left: 10px;
    margin-right: 10px;
    border-radius: 4px !important;
}
</style>
<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-box">
                <div class="panel panel-default" style="width: 550px;<?php if ($_smarty_tpl->tpl_vars['manager']->value['m_fid']>0) {?>display:none;<?php }?>" >
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            店铺祝福语设置（请将版本更新到最新版本才能使用此功能）
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<?php if ($_smarty_tpl->tpl_vars['blessingCfg']->value&&$_smarty_tpl->tpl_vars['blessingCfg']->value['abc_id']) {?><?php echo $_smarty_tpl->tpl_vars['notice']->value['abc_id'];?>
<?php }?>"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="yuan-pass"> 祝福标题：</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control col-sm-8" id="blessingTitle" value="<?php if ($_smarty_tpl->tpl_vars['blessingCfg']->value&&$_smarty_tpl->tpl_vars['blessingCfg']->value['abc_blessing_title']) {?><?php echo $_smarty_tpl->tpl_vars['blessingCfg']->value['abc_blessing_title'];?>
<?php }?>" placeholder="请输入祝福标题">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="new-pass"> 祝福内容： </label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control col-sm-8" rows="8" id="blessingContent" placeholder="请输入默认祝福内容"><?php if ($_smarty_tpl->tpl_vars['blessingCfg']->value&&$_smarty_tpl->tpl_vars['blessingCfg']->value['abc_blessing']) {?><?php echo $_smarty_tpl->tpl_vars['blessingCfg']->value['abc_blessing'];?>
<?php }?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="yuan-pass"> 祝福背景音乐：</label>
                                <div class="col-sm-10">
                                    <select class="form-control prov"  style="height: 38px;padding: 6px 12px;" id="blessingMusic">
                                        <option value="http://pxsp.tiandiantong.net/music4.mp3">恭祝大家新年好</option>
                                        <option value="http://pxsp.tiandiantong.net/music1.mp3">新年喜洋洋</option>
                                        <option value="http://pxsp.tiandiantong.net/music2.mp3">花好月圆</option>
                                        <option value="http://pxsp.tiandiantong.net/music3.mp3">祝福你</option>
                                        <option value="http://pxsp.tiandiantong.net/music5.mp3">春节序曲</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary btn-save-notice" type="button">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/plugin/citySelect/jquery.cityselect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
    $('.btn-save-notice').on('click',function(){
        var blessingMusic = $('#blessingMusic').val();
        var blessingTitle = $('#blessingTitle').val();
        var blessingContent = $('#blessingContent').val();
        var data = {
            'blessingMusic'   : blessingMusic,
            'blessingTitle'   : blessingTitle,
            'blessingContent' : blessingContent
        };

        if(blessingTitle && blessingContent){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/plugin/saveBlessing',
                'data'	: data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        }else{
            layer.msg('请填写完整数据');
        }
    });
</script>
<?php }} ?>
