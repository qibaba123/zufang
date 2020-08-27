<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:10:34
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/paystyle.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5337509375e859dfa4417c9-24886086%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cff878d47b108f425d76019350e21574222a722' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/paystyle.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5337509375e859dfa4417c9-24886086',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'payType' => 0,
    'menuType' => 0,
    'paySort' => 0,
    'applet_cfg' => 0,
    'appletPay' => 0,
    'secretKey' => 0,
    'appletCfg' => 0,
    'sequenceShowAll' => 0,
    'baiduPay' => 0,
    'alipay' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859dfa4d4d08_24410805',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859dfa4d4d08_24410805')) {function content_5e859dfa4d4d08_24410805($_smarty_tpl) {?><style>
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
.watermrk-show{
	display: inline-block;
	vertical-align: middle;
	margin-left: 20px;
	margin-bottom: 20px;
}
.watermrk-show .label-name,.watermrk-show .watermark-box{
	display: inline-block;
	vertical-align: middle;
}
.watermrk-show .watermark-box{
	width: 150px;
}
</style>
<!--
<div class="alert alert-block alert-info" style="line-height: 22px;">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <b>自有：</b>需要绑定微信公众号微信支付功能，由微信方结算。 <b>代销：</b>不需绑定微信公众号微信支付功能，由天店通结算。
</div>
-->
<div class="payment-style">
	<!--
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
				<h3>微信支付--代销</h3>
				<span class="tips-txt">支持信用卡付款</span>
				<label id="choose-onoff" class="choose-onoff">
					<input class="ace ace-switch ace-switch-5" id="wxpay_ds" data-type="wxpay_ds" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_wxpay_ds']) {?> checked<?php }?>>
					<span class="lbl"></span>
				</label>
			</div>
			<div class="payment-block-body js-wxpay-body-region">
				<div>
				    <h4>启用天店通微信支付（代销账户），您的店铺可以通过天店通代销商品，并由您发起提现申请与天店通结算相应货款。</h4>
				    <div class="form-horizontal form-label-text-left">
				        <div class="control-group">
				            <label class="control-label">当前微信支付：</label>
				            <div class="controls">
				                <div class="control-action">
				                    <span>微信支付 - 代销</span>
				                </div>
				            </div>
				        </div>
				        <div class="control-group">
				            <div class="controls">
				                <p class="ui-message-warning pay-test-status">
				                    注意：您正在使用天店通微信支付账号。 买家通过朋友圈、微信好友聊天窗口和微信群进入购买，可以通过天店通微信支付付款。
				                </p>
				            </div>
				        </div>
				    </div>

				    <dl>
				        <dt>提现时间：</dt>
				        <dd>
				            当天18点前申请提现，当天审核完成，实际到账时间以银行入账时间为准。
				            <a class="new-window" target="_blank" href="#">查看收入</a>
				        </dd>
				        <dt>交易手续费：</dt>
				        <dd>
				            天店通不收取任何提现手续费；
				            <br> 天店通交易手续费补贴政策依据不同商家及交易类型有所不同。
				            <a target="_blank" href="#">查看详细补贴政策</a>
				        </dd>
				    </dl>

				</div>
			</div>
		</div>
	</div>
	-->
	<?php if (true||$_smarty_tpl->tpl_vars['menuType']->value=='weixin') {?>
	<!-- 
		content:小程序类型为微信时显示微信支付配置
		author:zhangzc
		date:2019-01-28
	-->
	<div class="page-header" style="min-height: 50px">
		<div class="watermrk-show">
			<span class="label-name">微信支付排序：</span>
			<div class="watermark-box">
				<input type="number" style="width: 60px" maxlength="2" class="form-control" id="wxpay_sort" value="<?php echo $_smarty_tpl->tpl_vars['paySort']->value['wxpay'];?>
" oninput="if(value.length>2)value=value.slice(0,2)">

			</div>
		</div>
		<div class="watermrk-show">
			<span class="label-name">余额支付排序：</span>
			<div class="watermark-box">
				<input type="number" style="width: 60px" maxlength="2" class="form-control" id="coin_sort" value="<?php echo $_smarty_tpl->tpl_vars['paySort']->value['coin'];?>
" oninput="if(value.length>2)value=value.slice(0,2)">

			</div>
		</div>
		<div class="watermrk-show">
			<span class="label-name">货到付款支付排序：</span>
			<div class="watermark-box">
				<input type="number" style="width: 60px" maxlength="2" class="form-control" id="cash_sort" value="<?php echo $_smarty_tpl->tpl_vars['paySort']->value['cash'];?>
" oninput="if(value.length>2)value=value.slice(0,2)">

			</div>
		</div>
		<!--
		<div class="watermrk-show">
			<span class="label-name">微财猫微信支付排序：</span>
			<div class="watermark-box">
				<input type="number" style="width: 60px" maxlength="2" class="form-control" id="vcmwx_sort" value="<?php echo $_smarty_tpl->tpl_vars['paySort']->value['vcmwx'];?>
" oninput="if(value.length>2)value=value.slice(0,2)">
			</div>
		</div>

		<div class="watermrk-show">
			<span class="label-name">微财猫储值卡支付排序：</span>
			<div class="watermark-box">
				<input type="number" style="width: 60px" maxlength="2" class="form-control" id="vcmcoin_sort" value="<?php echo $_smarty_tpl->tpl_vars['paySort']->value['vcmcoin'];?>
" oninput="if(value.length>2)value=value.slice(0,2)">

			</div>
		</div>
		-->
		<span class="input-group-btn" style="left: 20px;">
            <span class="btn btn-blue" id="save-payType-sort">确认</span>
            <span>数值越小越靠前</span>
        </span>
	</div>
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
		        <h3>微信支付</h3>
		        <div class="tips-box">
		        	<span class="tips-txt">支持信用卡付款</span>
			        <div class="applet-pay">
			        	<img src="/public/wxapp/images/icon_applet.png" class="icon_applet" alt="小程序图标">
			        	<div class="pay-code-box">
			        		<img src="/public/wxapp/images/qrc_miniapp.jpg" alt="小程序二维码">
							<p>微信扫码，手机端经营管理</p>
			        	</div>
			        </div>
		        </div>
		        <label id="choose-onoff" class="choose-onoff" style="left: 300px;">
		        	<input name="sms_start" class="ace ace-switch ace-switch-5" id="wxpay_applet" data-type="wxpay_applet" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_wxpay_applet']) {?> checked<?php }?>>
		        	<span class="lbl"></span>
		        </label>
		    </div>

		    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
				<?php if (true) {?>
				<div class="ui-message-warning" >
					<p>
						温馨提示：小程序开通微信支付分为两种：
					</p>
					<p>
						1、小程序单独开通的微信支付，该方式直接配置即可。
						<br>
						2、小程序在公众号里申请，公众号里开通的微信支付；该方式需要先登录商户号->产品中心->APPID授权管理->新增该小程序的授权，然后再配置商户号和密钥。
					</p>
				</div>
				<?php } else { ?>
				<div class="ui-message-warning" >
					<p>
						温馨提示：请确保微信支付商户号中JSAPI支付已开通；开通方式登录商户号->产品中心->我的产品
					</p>
				</div>
				<?php }?>
		    	<div>
		    		<form action="">
		    			<div class="form-group">
		    			    <label for="firstname" class="col-sm-2 control-label text-right">AppID<font color="red">*</font></label>
		    			    <div class="col-sm-10">
		    			        <input type="text" class="form-control" id="appid" value="<?php if ($_smarty_tpl->tpl_vars['applet_cfg']->value&&$_smarty_tpl->tpl_vars['applet_cfg']->value['ac_appid']) {?><?php echo $_smarty_tpl->tpl_vars['applet_cfg']->value['ac_appid'];?>
<?php }?>" data-msg="填写您的AppID，并保存" readonly placeholder="填写您的AppID">
		    			            <?php if (true) {?><p>微信小程序AppID</p><?php } else { ?>微信公众号AppID<?php }?>
		    			    </div>
		    			</div>
		    			<!---
		    			<div class="form-group">
		    			    <label for="firstname" class="col-sm-2 control-label text-right">AppleSecret<font color="red">*</font></label>
		    			    <div class="col-sm-10">
		    			        <input type="text" class="form-control" id="appsecret" value="<?php if ($_smarty_tpl->tpl_vars['appletPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['appletPay']->value['ap_appsecret'];?>
<?php }?>" data-msg="填写您的AppleSecret，并保存" placeholder="填写您的AppleSecret">
		    			            <p>请填写微信公众号的AppleSecret</p>
		    			    </div>
		    			</div>
		    			-->
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">支付商户号<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="mchid" value="<?php if ($_smarty_tpl->tpl_vars['appletPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['appletPay']->value['ap_mchid'];?>
<?php }?>" data-msg="填写您的支付商户号，并保存" placeholder="填写您的支付商户号">
								<p>请填写微信商户平台商户号</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">API秘钥<font color="red">*</font></label>
							<div class="col-sm-10" style="position: relative;">
								<input type="password" class="form-control" id="mchkey" value="<?php if ($_smarty_tpl->tpl_vars['appletPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['appletPay']->value['ap_mchkey'];?>
<?php }?>" data-msg="填写您的API秘钥，并保存" placeholder="请填写您的API秘钥">
								<div class="showhide-secreskey">显示</div>
								<p>请填写微信商户平台的API秘钥<a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=362&extra=page%3D1" target="_blank">查看教程</a>&nbsp;&nbsp;&nbsp;
									<!--
									<span style="display: inline-flex;"><span id="show-secretKey" style="background-color: #d3eafb;padding: 2px 5px;border-radius: 3px;color: #1f94e9;margin-right:6px;font-size: 13px;">生成秘钥</span><span id="secretKey" style="display: none;line-height: 28px;"><?php echo $_smarty_tpl->tpl_vars['secretKey']->value;?>
</span></span>
									-->
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">证书路径</label>
							<div class="col-sm-10">
								<div  class="form-control" style="position: relative;">
									<span><?php if ($_smarty_tpl->tpl_vars['appletPay']->value&&$_smarty_tpl->tpl_vars['appletPay']->value['ap_sslcert']) {?> 已上传 <?php } else { ?> 未上传 <?php }?></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-zhengshu" data-click-upload data-type="cert" data-msg="请上传apiclient_cert.pem的支付证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="sslcert" id="sslcert" data-msg="填上传证书路径" value="<?php if ($_smarty_tpl->tpl_vars['appletPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['appletPay']->value['ap_sslcert'];?>
<?php }?>">
								</div>
								<p>请上传apiclient_cert.pem的支付证书文件</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">秘钥路径</label>
							<div class="col-sm-10">
								<div class="form-control" style="position: relative;">
									<span><?php if ($_smarty_tpl->tpl_vars['appletPay']->value&&$_smarty_tpl->tpl_vars['appletPay']->value['ap_sslkey']) {?> 已上传 <?php } else { ?> 未上传 <?php }?></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-miyao" data-click-upload data-type="key" data-msg="请上传apiclient_key.pem的支付密钥证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="sslkey" id="sslkey" data-msg="填上传秘钥路径" value="<?php if ($_smarty_tpl->tpl_vars['appletPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['appletPay']->value['ap_sslkey'];?>
<?php }?>">
								</div>
								<p>请上传apiclient_key.pem的支付密钥证书文件</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">生成商户平台秘钥</label>
							<div class="col-sm-10">
									<p><span style="display: inline-flex;"><span id="show-secretKey" style="background-color: #d3eafb;padding: 2px 5px;border-radius: 3px;color: #1f94e9;margin-right:6px;font-size: 13px;">生成秘钥</span><span id="secretKey" style="display: none;line-height: 28px;"><?php echo $_smarty_tpl->tpl_vars['secretKey']->value;?>
</span></span></p>
								<p>此功能为商户平台辅助功能</p>
							</div>
						</div>
		    			<div class="form-group">
		    				<div class="col-sm-2"></div>
		    			    <div class="col-sm-10 col-sm-offset-2">
		    			        <button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveWxPay()"> 保 存 </button>
		    			    </div>
		    			</div>
		    		</form>
		    	</div>
		    </div>
		</div>
	</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['menuType']->value=='aliapp') {?>
	<!-- 
		content:小程序类型为支付宝时显示支付宝信息配置
		author:zhangzc
		date:2019-01-28
	-->
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
				<h3>支付宝支付</h3>
				<label id="choose-onoff" class="choose-onoff" style="left: 110px">
					<input name="alipay_applet" class="ace ace-switch ace-switch-5" id="alipay_applet" data-type="alipay_applet" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_alipay_applet']) {?> checked<?php }?>>
					<span class="lbl"></span>
				</label>
			</div>
			<div class="payment-block-body js-wxpay-body-region">
				<h4>启用后买家可在下单时选择支付宝支付。</h4>
				<div class="ui-message-warning">
					<p>
						<!-- 描述信息暂时未填写 -->
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php }?>

	<div class="payment-block-wrap" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==34||$_smarty_tpl->tpl_vars['sequenceShowAll']->value==0) {?> style="display:none;"<?php }?>>
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
		        <h3>货到付款</h3>
		        <label id="choose-onoff" class="choose-onoff" style="left: 110px">
		        	<input name="cash" class="ace ace-switch ace-switch-5" id="cash" data-type="cash" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_cash']) {?> checked<?php }?>>
		        	<span class="lbl"></span>
		        </label>
		    </div>
		    <div class="payment-block-body js-wxpay-body-region">
		    	<h4>启用后买家可选择货到付款下单，您需自行通过合作快递安排配送。买家开箱验货无误后，快递公司向买家收款并与您结算费用。</h4>
		    	<div class="ui-message-warning">
		    	    <p>
		    	        注意：本功能服务商不参与配送和货款代收服务，需您自行与快递公司合作，完成配送和货款结算。 同时，由于业务特殊性，请勿使用价格虚高商品（单笔金额最高10万），用于测试商品和订单，否则将终止向您提供该功能。
		    	        <a class="new-window" target="_blank" href="#">查看说明</a>
		    	    </p>
		    	    <p>
		    	        此外，您可以启用货到付款后，关闭微信支付、银行卡付款功能，仅向买家提供货到付款、或到店自提时使用到店付款服务。
		    	    </p>
		    	</div>
		    </div>
		</div>
	</div>

	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
				<h3>余额支付</h3>
				<label id="choose-onoff" class="choose-onoff" style="left: 110px">
					<input name="coin" class="ace ace-switch ace-switch-5" id="coin" data-type="coin" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_coin']) {?> checked<?php }?>>
					<span class="lbl"></span>
				</label>
			</div>
			<div class="payment-block-body js-wxpay-body-region">
				<h4>启用后买家可在下单时选择余额金币支付。</h4>
				<div class="ui-message-warning">
					<p>
						此功能需结合会员充值使用，商家可给予用户充值优惠，以吸引更多用户充值消费。用户充值得实惠，商家产品销售的同时，能积累资金，达到双赢。
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['menuType']->value=='bdapp') {?>
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
				<h3>百度支付</h3>
				<div class="tips-box">
					<span class="tips-txt">支持信用卡付款</span>
				</div>
				<label id="choose-onoff" class="choose-onoff" style="left: 300px;">
				<input name="sms_start" class="ace ace-switch ace-switch-5" id="baidu_pay" data-type="baidu_pay" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_baidu_pay']||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32) {?> checked<?php }?>>
				<span class="lbl"></span>
				</label>
			</div>
			<div class="payment-block-body js-wxpay-body-region" style="display: block;">
				<div>
					<form action="">
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">dealId<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="dealid" value="<?php if ($_smarty_tpl->tpl_vars['baiduPay']->value&&$_smarty_tpl->tpl_vars['baiduPay']->value['abp_dealid']) {?><?php echo $_smarty_tpl->tpl_vars['baiduPay']->value['abp_dealid'];?>
<?php }?>" data-msg="填写您的百度支付配置的dealId，并保存" placeholder="填写您的支付配置的dealId">
								<p>百度小程序支付配置的dealId</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">APP KEY<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="appkey" value="<?php if ($_smarty_tpl->tpl_vars['baiduPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['baiduPay']->value['abp_appkey'];?>
<?php }?>" data-msg="填写您的支付APP KEY，并保存" placeholder="填写您的百度支付的APP KEY">
								<p>填写您的百度支付的APP KEY</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">百度支付的平台公钥<font color="red">*</font></label>
							<div class="col-sm-10" style="position: relative;">
								<textarea type="text" rows="4" class="form-control" id="public_key" data-msg="百度支付的平台公钥，并保存" placeholder="百度支付的平台公钥"><?php if ($_smarty_tpl->tpl_vars['baiduPay']->value&&$_smarty_tpl->tpl_vars['baiduPay']->value['abp_public_key']) {?><?php echo $_smarty_tpl->tpl_vars['baiduPay']->value['abp_public_key'];?>
<?php }?></textarea>
								<p>百度支付的平台公钥</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">RSA公钥路径</label>
							<div class="col-sm-10">
								<div  class="form-control" style="position: relative;">
									<span><?php if ($_smarty_tpl->tpl_vars['baiduPay']->value&&$_smarty_tpl->tpl_vars['baiduPay']->value['abp_public_rsa_key']) {?> 已上传 <?php } else { ?> 未上传 <?php }?></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-gongyao" data-click-upload data-type="key" data-msg="请上传生成的rsa_public_key.pem的支付公钥证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="publicKey" id="public_rsa_key" data-msg="填上传证书路径" value="<?php if ($_smarty_tpl->tpl_vars['baiduPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['baiduPay']->value['abp_public_rsa_key'];?>
<?php }?>">
								</div>
								<p>请上传生成的rsa_public_key.pem的私钥证书文件</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">RSA秘钥路径</label>
							<div class="col-sm-10">
								<div class="form-control" style="position: relative;">
									<span><?php if ($_smarty_tpl->tpl_vars['baiduPay']->value&&$_smarty_tpl->tpl_vars['baiduPay']->value['abp_private_rsa_key']) {?> 已上传 <?php } else { ?> 未上传 <?php }?></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-siyao" data-click-upload data-type="key" data-msg="请上传生成的rsa_private_key.pem的支付私钥证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="privateKey" id="private_rsa_key" data-msg="填上传秘钥路径" value="<?php if ($_smarty_tpl->tpl_vars['baiduPay']->value) {?><?php echo $_smarty_tpl->tpl_vars['baiduPay']->value['abp_private_rsa_key'];?>
<?php }?>">
								</div>
								<p>请上传生成的rsa_private_key.pem的私钥证书文件</p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-10 col-sm-offset-2">
								<button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveBaiduPay()"> 保 存 </button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<!--
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="payment-block-header js-wxpay-header-region">
		        <h3>支付宝支付</h3>
		        <span class="tips-txt">支持信用卡付款</span>
		        <label id="choose-onoff" class="choose-onoff">
		        	<input name="alipay" class="ace ace-switch ace-switch-5" id="alipay" data-type="alipay" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payType']->value['pt_alipay']) {?> checked<?php }?>>
		        	<span class="lbl"></span>
		        </label>
		    </div>
		    <div class="payment-block-body js-wxpay-body-region">
		        <h4>启用支付宝后，买家可使用支付宝进行付款。货款将先进入您的天店通店铺账户余额，您可以随时申请提现。</h4>
		        <p class="ui-message-warning">
		            由于支付宝无法在微信、QQ的购物环境中使用，目前启用支付宝将不在前述的两个APP内提供支付入口。买家可在支付宝服务窗、微博、Safari、Chrome等其他APP支付时，使用支付宝付款。
		        </p>
		        <dl>
		            <dt>提现时间：</dt>
		            <dd>
		                当天18点前申请提现，当天审核完成，实际到账时间以银行入账时间为准。
		                <a class="new-window" target="_blank" href="#">查看收入</a>
		            </dd>
		            <dt>交易手续费：</dt>
		            <dd>
		                天店通不收取任何提现手续费；
		                <br> 天店通交易手续费补贴政策依据不同商家及交易类型有所不同。
		                <a target="_blank" href="#">查看详细补贴政策</a>
		            </dd>
		        </dl>
		    </div>

		    <div class="payment-block-body js-wxpay-body-region">
		    	<div>
		    		<form action="">
		    						<div class="form-group">
		    							<label for="secondname" class="col-sm-2 control-label text-right">合作者身份（PID）</label>
		    							<div class="col-sm-10">
		    								<input type="text" class="form-control" id="pid" value="<?php if ($_smarty_tpl->tpl_vars['alipay']->value) {?><?php echo $_smarty_tpl->tpl_vars['alipay']->value['ap_pid'];?>
<?php }?>" placeholder="填写合作者身份（PID）">
		    								<p>请填写支付宝的合作者身份（PID）</p>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label for="firstname" class="col-sm-2 control-label text-right">支付宝账号</label>
		    							<div class="col-sm-10">
		    								<input type="text" class="form-control" id="account" value="<?php if ($_smarty_tpl->tpl_vars['alipay']->value) {?><?php echo $_smarty_tpl->tpl_vars['alipay']->value['ap_account'];?>
<?php }?>" placeholder="填写您的支付宝账号">
		    								<p>请填写您的支付宝账号</p>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label for="firstname" class="col-sm-2 control-label text-right">安全校验码（Key）</label>
		    							<div class="col-sm-10">
		    								<input type="text" class="form-control" id="key" value="<?php if ($_smarty_tpl->tpl_vars['alipay']->value) {?><?php echo $_smarty_tpl->tpl_vars['alipay']->value['ap_key'];?>
<?php }?>"  placeholder="填写您的安全校验码">
		    								<p>请填写您的安全校验码（Key）</p>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label for="firstname" class="col-sm-2 control-label text-right">合作支付宝公钥</label>
		    							<div class="col-sm-10">
		    								<textarea class="form-control" id="ssl_pub" placeholder="填写您的合作支付宝公钥"><?php if ($_smarty_tpl->tpl_vars['alipay']->value) {?><?php echo $_smarty_tpl->tpl_vars['alipay']->value['ap_ssl_pub'];?>
<?php }?></textarea>
		    								<p>合作伙伴密钥管理 =>RSA 加密：查看支付宝公钥</p>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label for="firstname" class="col-sm-2 control-label text-right">商户 RSA 私钥</label>
		    							<div class="col-sm-10">
		    								<textarea class="form-control" id="ssl_pri" placeholder="填写您的商户 RSA 私钥"><?php if ($_smarty_tpl->tpl_vars['alipay']->value) {?><?php echo $_smarty_tpl->tpl_vars['alipay']->value['ap_ssl_pri'];?>
<?php }?></textarea>
		    								<p>（非 PKCS8 编码）</p>
		    							</div>
		    						</div>
		    
		    			<div class="form-group">
		    				<div class="col-sm-2"></div>
		    			    <div class="col-sm-10">
		    			        <button type="button" class="btn btn-primary  btn-sm" onclick="saveAlipay()"> 保 存 </button>
		    			    </div>
		    			</div>
		    		</form>
		    	</div>
		    </div>
		</div>
	</div>
	-->

</div>
<div id="zhengshu" style="display: none;padding:5px 20px;">
	<div class="upload-tips">
		<form action="/wxapp/currency/pemcert" enctype="multipart/form-data" method="post">
			<label style="height:35px;line-height: 35px;">本地上传</label>
			<span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="pem_cert" type="file"></span>
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传pem类型的文件</p>
			<div style="font-size: 14px;padding-left: 29px;margin-top: 10px;" >注意　<span id="show-notice">apiclient_cert.pem为支付证书文件，apiclient_key.pem为支付密钥证书文件</span></div>
		</form>
	</div>
</div>
<style>
.layui-layer-btn { border-top: 1px solid #eee; }
.upload-tips {		/* overflow: hidden; */ }
.upload-tips label { display: inline-block; width: 70px; }
.upload-tips p { display: inline-block; font-size: 13px; margin: 0; color: #666; margin-left: 10px; }
.upload-tips .upload-input { display: inline-block; text-align: center; height: 35px; line-height: 35px; background-color: #1276D8; color: #fff; width: 90px; position: relative; cursor: pointer; }
.upload-tips .upload-input>input { display: block; height: 35px; width: 90px; opacity: 0; margin: 0; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer; }
</style>
<script src="/public/plugin/layer/layer.js"></script>
<script>
	$(function(){
		/*阻止开启关闭按钮事件冒泡*/
		$('.payment-block-header input[type=checkbox]').on('click', function(event) {
			//event.stopPropagation();
			var type  = $(this).data('type');
			var value = $('#'+type+':checked').val();
			var data  = {
				'type' : type
			};
			if(type == 'wxpay_applet' && value == 'on'){
				var appid = $('#appid').val();
				if(appid){
					var check = new Array('mchid','mchkey');
					for(var i=0; i < check.length;i++){
						var temp = $('#'+check[i]).val();
						if(temp){
							data[check[i]] = temp;
						}else{
							var msg = $('#'+check[i]).attr('placeholder');
							layer.msg(msg);
							return false;
						}
					}
				}else{
					layer.msg('请绑定微信');
					window.location.href = '/wxapp/guide/grantAuth';
					return false;
				}

			}
			changePayType(data);
		});
		/*隐藏显示配置区域*/
		$(".js-wxpay-header-region").on('click', function(event) {
			var that = $(this).next('.js-wxpay-body-region');
			var thatWrap = $(this).parents('.payment-block-wrap');
			var isDisplay = that.css("display");
			console.log(isDisplay=='block');
			if(isDisplay=='block'){
				that.stop().slideUp();
				thatWrap.removeClass('open');
			}else{
				that.stop().slideDown();
				thatWrap.addClass('open');
			}
		});

		$('[data-click-upload]').on('click', function(){
			var type    = $(this).data('type');
			var msg     = $(this).data('msg');
			$('#show-notice').html(msg);
			var htmlTxt=$("#zhengshu");
			var that    = this;
			//页面层
			var layIndex = layer.open({
				type: 1,
				title: '证书路径',
				shadeClose: true, //点击遮罩关闭
				shade: 0.6, //遮罩透明度
				skin: 'layui-anim',
				area: ['500px', '200px'], //宽高
				btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
				content: htmlTxt,
				yes : function() {
					var loading = layer.load(2);
					var $form = htmlTxt.find('form');
					var url = $form.attr("action"),
							data = new FormData($form[0]);
					$.ajax(url, {
						type: "post",
						data: data,
						processData: false,
						contentType: false,
						dataType: 'json',
						success: function (data) {
							if (data.ec == 200) {
								$(that).prev('span').text('上传成功');
								$(that).next('input').val(data.data.path);
							} else {
								layer.alert('上传失败，请重试');
							}
						},
						complete: function () {
							layer.close(loading);
							layer.close(layIndex);
						}
					});
				}
			});
		});

	});
	//选择文件
	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}

	function saveWxPay(){
		var appid = $('#appid').val();
		var data  = {
			'appid' : appid,
		};
		if(appid){
			var check = new Array('mchid','mchkey');
			for(var i=0; i < check.length;i++){
				var temp = $('#'+check[i]).val();
				if(temp){
					data[check[i]] = temp;
				}else{
					var msg = $('#'+check[i]).attr('placeholder');
					layer.msg(msg);
					return false;
				}
			}
		}else{
			layer.msg('请绑定微信');
			window.location.href = '/wxapp/guide/grantAuth';
			return false;
		}

		data['sslcert'] = $('#sslcert').val();
		data['sslkey']  = $('#sslkey').val();
		console.log(data);
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/currency/savePay',
			'data'  : data,
			'dataType'  : 'json',
			success : function(response){
				layer.msg(response.em);
			}
		});
	}

	function saveAlipay(){
		var check = new Array('pid','account','key','ssl_pub','ssl_pub','ssl_pri');
		var data  = {};
		for(var i=0; i < check.length;i++){
			var temp = $('#'+check[i]).val();
			if(temp){
				data[check[i]] = temp;
			}else{
				var msg = $('#'+check[i]).attr('placeholder');
				layer.msg(msg);
				return false;
			}
		}
		//console.log(data);
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/currency/saveAlipay',
			'data'  : data,
			'dataType'  : 'json',
			success : function(response){
				layer.msg(response.em);
			}
		});
	}

	function changePayType(data){
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/currency/changePay',
			'data'  : data,
			'dataType'  : 'json',
			success : function(response){
				layer.msg(response.em, {icon: 6})
				window.location.reload();
			}
		});
	}

	$('#show-secretKey').on('click',function () {
	     console.log('1234444');
		 $('#secretKey').css('display','block');
    })
	// 显示秘钥明文
    $(".showhide-secreskey").mousedown(function(event) {
    	$(this).text("隐藏");
    	$("#mchkey").prop("type","text");
    });
    $(".showhide-secreskey").mouseup(function(event) {
    	$(this).text("显示");
    	$("#mchkey").prop("type","password");
    });

    function saveBaiduPay(){
        var data  = {};
        var check = new Array('dealid','appkey','public_key','public_rsa_key','private_rsa_key');
        for(var i=0; i < check.length;i++){
            var temp = $('#'+check[i]).val();
            if(temp){
                data[check[i]] = temp;
            }else{
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveBaiduPay',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.msg(response.em);
            }
        });
    }
    $('#save-payType-sort').on('click',function () {
        var wxpay = $('#wxpay_sort').val();
        var coin = $('#coin_sort').val();
        var cash = $('#cash_sort').val();
        var data = {
            wxpay: wxpay,
            coin : coin,
            cash : cash
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/paySort',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });
</script>
<?php }} ?>
