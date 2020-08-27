<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:16:37
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/answer/answer-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1624463125e4dfa15db5bb3-81721541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb749538a38897bbda2e65bde33d37fe42a6391a' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/answer/answer-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1624463125e4dfa15db5bb3-81721541',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wxapp_cfg' => 0,
    'cfg' => 0,
    'sid' => 0,
    'currency' => 0,
    'key' => 0,
    'val' => 0,
    'awardList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfa15e4b048_99422108',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfa15e4b048_99422108')) {function content_5e4dfa15e4b048_99422108($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
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
.payment-block .payment-block-body { display: none; }
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
.payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
.info-group-inner .group-title{
	width: 13% !important;
}
.group-info{
	/*background-color: #fff !important;*/
}
.info-group-box{
	margin-bottom: 5px !important;
}
.info-group-inner .group-info .control-label{
	width: 180px !important;
}
.col-sm-3{
	width: 30% !important;
}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['wxapp_cfg']->value!=32) {?>
<div style="margin-left:135px;"><a target="_blank" style="color:red; "  href="
http://p18m0a32n.bkt.clouddn.com/%E7%AD%94%E9%A2%98%20%281%29.mp4">该插件使用教程请点此查看</a></div>
<?php }?>
<div class="payment-style" style="margin-left: 150px">
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="info-group-box">
				<div class="info-group-inner">
					<div class="group-title">
						<span>红包赛配置</span>
					</div>
					<div class="group-info">
						<div class="payment-block-body js-wxpay-body-region" style="display: block;">
							<div>
								<div action="">
							<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">是否启用红包赛</label>
							<div class="col-sm-3">
								<label id="choose-onoff" class="choose-onoff">
									<input class="ace ace-switch ace-switch-5" id="redpacket_open"  data-type="redpacket_open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_open']) {?>checked<?php }?>>
									<span class="lbl"></span>
								</label>
							</div>
						</div>
									<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">设置答题时间<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="text" id="openTime" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_open_time'];?>
<?php }?>"  style="width: 40%;display: inline;margin-right: 7px" onchange="" >-
									<input type="text" id="endTime" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_end_time'];?>
<?php }?>" style="width: 40%;display: inline;" onchange="" >
								</div>
							</div>
									<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每次答题数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="answerNum" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_subject_num'];?>
<?php }?>" data-msg="填写每次答题数量"  placeholder="填写每次答题数量">
									<input type="hidden" class="form-control" id="ascId" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_id'];?>
<?php }?>" >
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">答题正确数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="right" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_answer_right'];?>
<?php }?>" data-msg="填写答题正确数量" placeholder="填写答题正确数量">
									<p style="font-size: 12px;">请填写答题正确数量（每次答对多少题可获得相应奖励）</p>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天最多答题次数<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="moreNum" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_answer_num'];?>
<?php }?>" data-msg="填写每天最多答题次数" placeholder="填写每天最多答题次数">
								</div>
							</div>
						<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天发放红包总量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="redPacket" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_num'];?>
<?php }?>" data-msg="填写每天发放红包总量" placeholder="填写每天发放红包总量">
								</div>
							</div>
						<?php if ($_smarty_tpl->tpl_vars['sid']->value==7126) {?>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">红包币种类型<font color="red">*</font></label>
								<div class="col-sm-3">
									<select class="form-control" id="currency" onchange="selectedType(this)">
										<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['currency']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
										<option value ="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['cfg']->value['asc_currency']) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } else { ?>
							  <input type="hidden" class="form-control" id="currency" value="0">
							<?php }?>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">红包类型<font color="red">*</font></label>
								<div class="col-sm-3">
									<select class="form-control" id="redPacket_type" onchange="selectedType(this)">
										<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_type']==1) {?>
											<option value ="1" selected="selected">固定金额</option>
											<option value ="2">随机金额</option>
										<?php } elseif ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_type']==2) {?>
											<option value ="1">固定金额</option>
											<option value ="2" selected="selected">随机金额</option>
										<?php } else { ?>
											<option value ="1">固定金额</option>
											<option value ="2">随机金额</option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">红包最小金额<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="min" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_min'];?>
<?php }?>" data-msg="填写红包最小金额" placeholder="填写红包最小金额">
									<p style="font-size: 12px;">请填写红包最小金额（如果为固定红包，则为固定红包金额）</p>
								</div>
							</div>
							<div id="selectMax" class="form-group"<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_type']==1) {?>style="display:none"<?php }?>>
								<label for="firstname" class="col-sm-2 control-label text-right">红包最大金额<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="max" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_redpacket_max'];?>
<?php }?>" data-msg="填写红包最大金额" placeholder="填写红包最大金额">
								</div>
							</div>
						</form>
							</div>
						</div>
					</div>
		    	</div>
			    </div>
			</div>
			<div class="info-group-box">
				<div class="info-group-inner">
					<div class="group-title">
						<span>奖品赛配置</span>
					</div>
					<div class="group-info">
						<div class="payment-block-body js-wxpay-body-region" style="display: block;">
							<div>
								<form action="">
							<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">是否启用奖品赛</label>
							<div class="col-sm-3">
								<label id="choose-onoff" class="choose-onoff">
									<input class="ace ace-switch ace-switch-5" id="award_open"  data-type="award_open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_award_open']) {?>checked<?php }?>>
									<span class="lbl"></span>
								</label>
							</div>
						</div>
									<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">设置答题时间<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="text" id="award_open_time" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_open_time'];?>
<?php }?>"  style="width: 40%;display: inline;margin-right: 7px" onchange="" >-
									<input type="text" id="award_end_time" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_end_time'];?>
<?php }?>" style="width: 40%;display: inline;" onchange="" >
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每次答题数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="award_sub_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_sub_num'];?>
<?php }?>" data-msg="填写每次答题数量"  placeholder="填写每次答题数量">
									<!--<input type="hidden" class="form-control" id="ascId" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_id'];?>
<?php }?>" >-->
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">答题正确数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="award_sub_right" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_sub_right'];?>
<?php }?>" data-msg="填写答题正确数量" placeholder="填写答题正确数量">
									<p style="font-size: 12px;">请填写答题正确数量（每次答对多少题可获得相应奖励）</p>
								</div>
							</div>

							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天最多答题次数<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="award_answer_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_answer_num'];?>
<?php }?>" data-msg="填写每天最多答题次数" placeholder="填写每天最多答题次数">
								</div>
							</div>
						<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天发放奖品总量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="award_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_num'];?>
<?php }?>" data-msg="填写每天发放奖品总量" placeholder="填写每天发放奖品总量">
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">选择奖品<font color="red">*</font></label>
								<div class="col-sm-3">
									<select class="form-control" id="award_id" >
										<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['awardList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['asa_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['asc_award_id']==$_smarty_tpl->tpl_vars['val']->value['asa_id']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['asa_name'];?>
</option>
										<?php } ?>
									</select>
									<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_id'];?>
" id="award_id_old">
								</div>
							</div>
						</form>
							</div>
						</div>
					</div>
		    	</div>
			</div>
			<div class="info-group-box">
				<div class="info-group-inner">
					<div class="group-title">
						<span>积分赛配置</span>
					</div>
					<div class="group-info">
						<div class="payment-block-body js-wxpay-body-region" style="display: block;">
							<div>
								<div action="">
							<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">是否启用积分赛</label>
							<div class="col-sm-3">
								<label id="choose-onoff" class="choose-onoff">
									<input class="ace ace-switch ace-switch-5" id="points_open"  data-type="points_open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_points_open']) {?>checked<?php }?>>
									<span class="lbl"></span>
								</label>
							</div>
						</div>
						<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">设置答题时间<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="text" id="points_open_time" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_open_time'];?>
<?php }?>"  style="width: 40%;display: inline;margin-right: 7px" onchange="" >-
									<input type="text" id="points_end_time" class="cus-input time form-control" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_end_time'];?>
<?php }?>" style="width: 40%;display: inline;" onchange="" >
								</div>
							</div>
						<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每次答题数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_sub_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_sub_num'];?>
<?php }?>" data-msg="填写每次答题数量"  placeholder="填写每次答题数量">
									<!--<input type="hidden" class="form-control" id="ascId" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_id'];?>
<?php }?>" >-->
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">答题正确数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_sub_right" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_sub_right'];?>
<?php }?>" data-msg="填写答题正确数量" placeholder="填写答题正确数量">
									<p style="font-size: 12px;">请填写答题正确数量（每次答对多少题可获得相应奖励）</p>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每人每天答题次数<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_answer_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_answer_num'];?>
<?php }?>" data-msg="填写每天答题次数" placeholder="填写每天答题次数">
								</div>
							</div>
							<!--<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天奖励积分总量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_num" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_num'];?>
<?php }?>" data-msg="填写每天奖励积分总量" placeholder="填写每天奖励积分总量">
								</div>
							</div>-->
									<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">奖励积分类型<font color="red">*</font></label>
								<div class="col-sm-3">
									<select class="form-control" id="points_type" onchange="selectedPointsType(this)">
										<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_points_type']==1) {?>
											<option value ="1" selected="selected">固定积分</option>
											<option value ="2">随机积分</option>
										<?php } elseif ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_points_type']==2) {?>
											<option value ="1">固定积分</option>
											<option value ="2" selected="selected">随机积分</option>
										<?php } else { ?>
											<option value ="1">固定积分</option>
											<option value ="2">随机积分</option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">最小奖励积分<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points'];?>
<?php }?>" data-msg="填写最小奖励积分" placeholder="填写最小奖励积分">
									<p style="font-size: 12px;">请填写最小奖励积分（如果为固定积分，则为固定积分数值）</p>
								</div>
							</div>
							<div id="selectPointsMax" class="form-group"<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_points_type']==1) {?>style="display:none"<?php }?>>
								<label for="firstname" class="col-sm-2 control-label text-right">最大奖励积分<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_max" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_max'];?>
<?php }?>" data-msg="填写最大奖励积分" placeholder="填写最大奖励积分">
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">兑换答题次数所需积分<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="points_chance_cost" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_points_chance_cost'];?>
<?php }?>" data-msg="填写积分" placeholder="填写积分">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-3 col-sm-offset-2">
									<button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveCfg()"> 保 存 </button>
								</div>
							</div>
						</form>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
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
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script>
	$(function() {
		/*阻止开启关闭按钮事件冒泡*/
		$('.form-group input[type=checkbox]').on('click', function (event) {
			var id = $('#ascId').val();
			var type = $(this).data('type');
			var value = $('#' + type + ':checked').val();
			var data = {
				'id' : id,
				'type': type,
				'value': value
			};
			$.ajax({
				'type': 'post',
				'url': '/wxapp/answer/saveCfgChecked',
				'data': data,
				'dataType': 'json',
				success: function (response) {
					layer.msg(response.em);
//					window.location.reload();
				}
			});
		});
	});
	function saveCfg() {
		var id = $('#ascId').val();

		//基本配置
		var data = {
			'id': id,
		};
    	//红包赛
		data['answerNum']      = $('#answerNum').val();
		data['right']          = $('#right').val();
		data['moreNum']        = $('#moreNum').val();
		data['redPacket']      = $('#redPacket').val();
		data['redPacket_type'] = $('#redPacket_type').val();
		data['min']            = $('#min').val();
		data['max']            = $('#max').val();
		data['openTime']       = $('#openTime').val();
		data['endTime']        = $('#endTime').val();
		data['currency']       = $('#currency').val();
		//奖品赛
		data['award_id']        = $('#award_id').val();
		data['award_id_old']    = $('#award_id_old').val();
		data['award_num']       = $('#award_num').val();
		data['award_sub_num']   = $('#award_sub_num').val();
		data['award_sub_right'] = $('#award_sub_right').val();
		data['award_answer_num']= $('#award_answer_num').val();
		data['award_open_time'] = $('#award_open_time').val();
		data['award_end_time']  = $('#award_end_time').val();

		//积分赛
		data['points']          = $('#points').val();
		data['points_type']     = $('#points_type').val();
		data['points_max']	    = $('#points_max').val();
//		data['points_num']       = $('#points_num').val();
		data['points_sub_num']   = $('#points_sub_num').val();
		data['points_sub_right'] = $('#points_sub_right').val();
		data['points_answer_num']= $('#points_answer_num').val();
		data['points_chance_cost']= $('#points_chance_cost').val();
		data['points_open_time'] = $('#points_open_time').val();
		data['points_end_time']  = $('#points_end_time').val();

		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           	$.ajax({
				'type': 'post',
				'url': '/wxapp/answer/saveAnswerCfg',
				'data': data,
				'dataType': 'json',
				success: function (response) {
					layer.msg(response.em);
					window.location.reload();
				}
			}); 
        });
	}
    function selectedType(obj){
		var type=$(obj).val();
		if(type==1){
			$('#selectMax').css('display','none')
		}else{
			$('#selectMax').css('display','block')
		}
	}

	function selectedPointsType(obj){
		var type=$(obj).val();
		if(type==1){
			$('#selectPointsMax').css('display','none')
		}else{
			$('#selectPointsMax').css('display','block')
		}
	}

	$('.time').click(function(){
		WdatePicker({
			dateFmt:'HH:mm',
			minDate:'00:00:00'
		})
	})


</script>
<?php }} ?>
