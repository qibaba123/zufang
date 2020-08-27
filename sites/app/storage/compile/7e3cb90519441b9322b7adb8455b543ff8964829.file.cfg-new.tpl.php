<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:12:36
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/answer/cfg-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5389110965dea1b84df6580-53706694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e3cb90519441b9322b7adb8455b543ff8964829' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/answer/cfg-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5389110965dea1b84df6580-53706694',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cfg' => 0,
    'imgs' => 0,
    'val' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1b84e67bc6_21409503',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1b84e67bc6_21409503')) {function content_5dea1b84e67bc6_21409503($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/addgoods.css">
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
#slide-img p{
	height: 114px !important;
	width: 284px !important;
}
.img-thumbnail{
	height: 114px !important;
	width: 284px !important;
}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="
http://p18m0a32n.bkt.clouddn.com/%E7%AD%94%E9%A2%98%20%281%29.mp4">该插件使用教程请点此查看</a></div>-->
<a href="javascript:;" onclick="pushAnswer()" class="btn btn-green btn-xs" style="margin-left: 150px;margin-bottom: 10px;">答题推送</a>
<div class="payment-style" style="margin-left: 150px">
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="info-group-box">
				<div class="info-group-inner">
					<div class="group-info" style="background-color: #fff">
						<div class="payment-block-body js-wxpay-body-region" style="display: block;">
							<div>
								<form action="">
									<input type="hidden" class="form-control" id="ascId" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_id'];?>
<?php }?>" >
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">是否启用答题活动<font color="red">*</font></label>
								<div class="col-sm-3">
									<label id="choose-onoff" class="choose-onoff">
										<input class="ace ace-switch ace-switch-5" id="open"  data-type="open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_open']) {?>checked<?php }?>>
										<span class="lbl"></span>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">轮播图<font color="red">*</font></label>
								<div class="col-sm-3" style="width: 80%">
									 <h4 class="lighter block green">答题页面轮播图(<small>最多三张，推荐尺寸 710*305</small>)</h4>
									<div id="slide-img" class="pic-box" style="display:inline-block;margin-top: 10px">
										<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['imgs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
										<p>
											<img class="img-thumbnail col" layer-src="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"  layer-pid="" src="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" >
											<span class="delimg-btn">×</span>
											<input type="hidden" id="slide_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="slide_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
">
											<input type="hidden" id="slide_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="slide_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
										</p>
										<?php } ?>
									</div>
									<span onclick="toUpload(this)" data-limit="3" data-width="710" data-height="305" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
									<input type="hidden" id="slide-img-num" name="slide-img-num" value="<?php if ($_smarty_tpl->tpl_vars['imgs']->value) {?><?php echo count($_smarty_tpl->tpl_vars['imgs']->value);?>
<?php } else { ?>0<?php }?>" placeholder="控制图片张数">
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
								<label for="firstname" class="col-sm-2 control-label text-right">每道题的答题时间<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="answerTime" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_answer_time'];?>
<?php } else { ?>10<?php }?>" style="width: 40%;display: inline" data-msg="请填写每道题的答题时间" placeholder="请填写每道题的答题时间" />秒(最大60秒)
								</div>
							</div>

							<!--
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每人每天最多领取红包数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="oneRedPacket" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_one_redpacket_num'];?>
<?php }?>" data-msg="填写每人每天最多领取红包数量" placeholder="填写每人每天最多领取红包数量">
								</div>
							</div>
							-->
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每天分享最多可获得复活卡数量<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="shareNum" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_share_num'];?>
<?php }?>" data-msg="填写每天分享可获得答题机会" placeholder="填写每天分享可获得答题机会">
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">是否启用公共题库<font color="red">*</font></label>
								<div class="col-sm-3">
									<label id="choose-onoff" class="choose-onoff">
										<input class="ace ace-switch ace-switch-5" id="question"  data-type="question" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_open_public_question']) {?>checked<?php }?>>
										<span class="lbl"></span>
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">每次答题允许使用复活卡数<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="allowCard" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_allow_card'];?>
<?php }?>" data-msg="每次答题允许使用复活卡数" placeholder="每次答题允许使用复活卡数">
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">是否允许分享领取复活卡<font color="red">*</font></label>
								<div class="col-sm-3">
									<label id="choose-onoff" class="choose-onoff">
										<input id="shareAllow" class="ace ace-switch ace-switch-5"  data-type="shareAllow" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_open_share_card']) {?>checked<?php }?>>
										<span class="lbl"></span>
									</label>
								</div>
							</div>
							<!--<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">答题规则<font color="red">*</font></label>
								<div class="col-sm-3">
									<label id="choose-onoff" class="choose-onoff">
										<textarea rows="3" id="rule" cols="20"></textarea>
									</label>
								</div>
							</div>-->
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">领奖联系电话<font color="red">*</font></label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="award_phone" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_award_phone'];?>
<?php }?>" data-msg="填写获奖联系电话" placeholder="填写获奖联系电话">
								</div>
							</div>
								<div class="form-group">
									<label for="firstname" class="col-sm-2 control-label text-right">自定义分享标题</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="share_title" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_share_title']) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_share_title'];?>
<?php } else { ?>趣味答题<?php }?>" data-msg="填写分享标题" placeholder="填写分享标题">
									</div>
								</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label text-right">自定义分享封面</label>
										<div class="cropper-box" data-width="500" data-height="400" data-dom-id="upload-share_cover" id="upload-share_cover">
											<img style="width: 15%;margin-left: 15px" src="<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_share_cover']) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_share_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_555_480.png<?php }?>" onload="" />
											<small>（图片建议尺寸500px*400px）</small>
											<input type="hidden" id="share_cover" name="share_cover" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['asc_share_cover']) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_share_cover'];?>
<?php }?>" />
										</div>
									</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right" >答题规则<font color="red">*</font></label>
								<div class="col-sm-6">
									<textarea class="form-control" style="width:100%;height:300px;visibility:hidden;" id = "rule" name="aptitude" placeholder="请填写答题规则"  rows="15" style=" text-align: left; resize:vertical;" >
									<?php echo $_smarty_tpl->tpl_vars['cfg']->value['asc_rule'];?>

									</textarea>
									<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
									<input type="hidden" name="ke_textarea_name" value="aptitude" />
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
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
		data['shareNum']       = $('#shareNum').val();
		data['allowCard']      = $('#allowCard').val();
		data['rule']           = $('#rule').val();
		var imgArr = [];
    	$('#slide-img').find("img").each(function () {
		   var _this = $(this);
		   imgArr.push(_this.attr('src'))
		});
    	data['imgArr']         = imgArr;
		data['award_phone']    = $('#award_phone').val();
		data['shareCover']     = $('#share_cover').val();
		data['shareTitle']     = $('#share_title').val();
		data['openTime']       = $('#openTime').val();
		data['endTime']        = $('#endTime').val();
		data['answerTime']     = $('#answerTime').val();
		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
				'type': 'post',
				'url': '/wxapp/answer/saveCfg',
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
	/*初始化日期选择器*/
	$('.time').click(function(){
		WdatePicker({
			dateFmt:'HH:mm',
			minDate:'00:00:00'
		})
	})

    function pushAnswer() {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
				'type'  : 'post',
				'url'   : '/wxapp/tplpush/answerPush',
				'dataType' : 'json',
				success : function(ret){
					layer.msg(ret.em,{
						time: 2000, //2s后自动关闭
					},function(){
						if(ret.ec == 200){
							window.location.reload();
						}
					});
				}
			});
        }, function(){

        });
    }


    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-share_cover'){
                    $('#share-cover').val(allSrc[0]);
                }
            }else {
                var img_html = '';
                var cur_num = $('#' + nowId + '-num').val();
                for (var i = 0; i < allSrc.length; i++) {
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="' + allSrc[i] + '"  layer-pid="" src="' + allSrc[i] + '" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_' + key + '" name="slide_' + key + '" value="' + allSrc[i] + '">';
                    img_html += '<input type="hidden" id="slide_id_' + key + '" name="slide_id_' + key + '" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num) + allSrc.length;
                if (now_num <= maxNum) {
                    $('#' + nowId + '-num').val(now_num);
                    $('#' + nowId).prepend(img_html);
                } else {
                    layer.msg('轮播图最多' + maxNum + '张');
                }
            }
        }
    }
</script>
<?php }} ?>
