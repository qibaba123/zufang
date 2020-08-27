<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 15:47:37
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/vcm-card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14756519915e86ea19c44d77-65803040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '826f9f8660a97db1137e5723a6f8843b1afcbf09' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/vcm-card.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14756519915e86ea19c44d77-65803040',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'vcmCfg' => 0,
    'appletCfg' => 0,
    'vcmData' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86ea19c7bbb9_27392412',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86ea19c7bbb9_27392412')) {function content_5e86ea19c7bbb9_27392412($_smarty_tpl) {?><style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    a.new-window { color: blue; }
    .page-content { padding: 20px; }
    .payment-block-wrap { font-family: '黑体'; }
    .payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
    .payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
    .payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
    .payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
    .payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
    .payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
    .payment-block .payment-block-body { display: none; padding: 25px; }
    .payment-block-body .form-group { overflow: hidden; }
    .payment-block-body .form-group label { font-weight: bold; }
    .payment-block-body .form-group p { color: #999; margin: 0; margin-top: 5px; }
    .payment-block .payment-block-body h4 { color: #333; margin-bottom: 20px; font-size: 14px; }
    .form-horizontal { margin-bottom: 30px; width: auto; }
    .form-horizontal .control-group { margin-bottom: 10px; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after { clear: both; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right; }
    .form-horizontal .control-label { width: 120px; font-size: 14px; line-height: 18px; }
    .page-payment .form-label-text-left .control-label { text-align: left; width: 100px; }
    .controls { font-size: 14px; }
    .form-horizontal .controls { margin-left: 180px; }
    .form-horizontal .controls { margin-left: 130px; word-break: break-all; }
    .page-payment .form-label-text-left .controls { margin-left: 100px; }
    .form-horizontal .control-action { padding-top: 5px; display: inline-block; font-size: 14px; line-height: 18px; }
    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }
    .pay-test-status { font-size: 12px; margin-top: 10px; width: 400px; }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-box { position: absolute; top: 5px; left: 115px; }
    .payment-block-header .tips-box .tips-txt{ font-size: 13px; text-align: left; color: #999;display: inline-block;vertical-align: middle;margin-right: 15px;}
    .showhide-secreskey { position: absolute; top: 4px; right: 18px; height: 26px; line-height: 26px; border-radius: 3px; background-color: #0095e5; color: #fff; z-index: 1; padding: 0 7px; font-size: 12px; cursor: pointer; }
    .showhide-secreskey:hover { opacity: 0.9; }
    .payment-block-header .tips-box .applet-pay{display: inline-block;vertical-align: middle;height: 40px;position: relative;padding: 2px;box-sizing: border-box;}
    .tips-box .applet-pay .icon_applet{height: 36px;width: 36px;vertical-align: middle;display: block;}
    .tips-box .applet-pay .pay-code-box{border:1px solid #ddd; background-color:#fff;position: absolute;top:50px;left:50%;margin-left: -110px;width: 220px;padding: 15px;box-sizing: border-box; z-index: 2;display: none;}
    .tips-box .applet-pay .pay-code-box:before,.tips-box .applet-pay .pay-code-box:after{content:'';position: absolute;left:50%;top:-15px;margin-left:-8px;border-width: 8px;border-style: dashed dashed solid dashed;border-color: transparent transparent #fff transparent;z-index: 2;}
    .tips-box .applet-pay .pay-code-box:after{z-index: 1;border-color: transparent transparent #ddd transparent;top:-16px;}
    .tips-box .applet-pay:hover .pay-code-box{display: block;}
    .tips-box .applet-pay .pay-code-box img{width: 180px;height: 180px;margin:0 auto;}
    .tips-box .applet-pay .pay-code-box p{font-size: 13px;display: block;margin:0;margin-top: 8px;line-height: 2;text-align: center;}
    .choose-onoff{
        width: 100px !important;
    }
</style>
<div class="alert alert-block alert-info" style="line-height: 22px;">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <b>提示：</b>使用微财猫会员卡，需先开通微财猫会员卡账户才能使用此功能，如有疑问请联系客服咨询
</div>
<div class="payment-style">
    <div class="payment-block-wrap">
        <div class="payment-block">
            <div class="payment-block-header js-wxpay-header-region">
                <h3>微财猫会员卡</h3>
                <label id="choose-onoff" class="choose-onoff" style="left: 150px;">
                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="vw_isopen" data-type="vw_isopen" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['vcmCfg']->value['vw_isopen']) {?> checked<?php }?>>
                    <span class="lbl"></span>
                </label>
            </div>
            <div class="payment-block-body js-wxpay-body-region" style="display: block;">
                <div>
                    <form action="">
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label text-right">AppID<font color="red">*</font></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="appid" value="<?php if ($_smarty_tpl->tpl_vars['appletCfg']->value&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_appid']) {?><?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_appid'];?>
<?php }?>" readonly />
                                <p>微信小程序AppID</p>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label text-right">微信支付商户号<font color="red">*</font></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mchid" value="<?php if ($_smarty_tpl->tpl_vars['vcmCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['vcmCfg']->value['vw_mchid'];?>
<?php }?>" data-msg="填写您的微信支付的商户号，并保存" placeholder="填写您的支付商户号">
                                <p>请填写微信商户平台商户号</p>
                            </div>
                        </div>
                        -->
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label text-right">设备ID<font color="red">*</font></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="deviceId" value="<?php if ($_smarty_tpl->tpl_vars['vcmCfg']->value&&$_smarty_tpl->tpl_vars['vcmCfg']->value['vw_device_id']) {?><?php echo $_smarty_tpl->tpl_vars['vcmCfg']->value['vw_device_id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['vcmData']->value['deviceid'];?>
<?php }?>" readonly />
                                <p>微财猫设备号</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label text-right">支付秘钥<font color="red">*</font></label>
                            <div class="col-sm-10">
                                <input type="password" autocomplete="off" class="form-control" id="paySecret" value="<?php if ($_smarty_tpl->tpl_vars['vcmCfg']->value&&$_smarty_tpl->tpl_vars['vcmCfg']->value['vw_pay_secret']) {?><?php echo $_smarty_tpl->tpl_vars['vcmCfg']->value['vw_pay_secret'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['vcmData']->value['paysecret'];?>
<?php }?>" readonly />
                                <p>微财猫支付秘钥</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10 col-sm-offset-2">
                                <button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveVcmCfg()"> 保 存 </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script>
    /*阻止开启关闭按钮事件冒泡*/
    $('.payment-block-header input[type=checkbox]').on('click', function(event) {
        //event.stopPropagation();
        var value = $('#vw_isopen:checked').val();
        var data  = {
            'isopen' : value
        };
        if(value == 'on'){
            var appid = $('#appid').val();
            if(appid){
                var check = new Array('paySecret','deviceId');
                for(var i=0; i < check.length;i++){
                    var temp = $('#'+check[i]).val();
                    if(temp){
                        data[check[i]] = temp;
                    }else{
//                        var msg = $('#'+check[i]).attr('placeholder');
//                        layer.msg(msg);
                        layer.msg('请先开通微财猫会员卡，到微财猫后台绑定小程序才能使用');
                        return false;
                    }
                }
            }else{
                layer.msg('请先开通微财猫会员卡，到微财猫后台绑定小程序才能使用');
                return false;
            }

        }
        console.log(data);
        saveVcmDataCfg(data);
    });
    function saveVcmCfg(){
//        var mchid = $('#mchid').val();
//        if(!mchid){
//            layer.msg('填写您的微信支付的商户号');
//            return false;
//        }
        var deviceId = $('#deviceId').val();
        if(!deviceId){
            layer.msg('请先开通微财猫会员卡，到微财猫后台绑定小程序才能使用');
            return false;
        }
        var paySecret = $('#paySecret').val();
        if(!paySecret){
            layer.msg('请先开通微财猫会员卡，到微财猫后台绑定小程序才能使用');
            return false;
        }
        var data  = {
            deviceId  : deviceId,
            paySecret : paySecret
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/membercard/saveVcaimaoCfg',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.msg(response.em);
            }
        });
    }

    function saveVcmDataCfg(data) {
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/membercard/changeVcaimaoCfg',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.msg(response.em);
            }
        });
    }
</script>
<?php }} ?>
