<link rel="stylesheet" href="/public/manage/css/bindsetting.css?7">
<style>
	.breadcrumbs {z-index: 1!important;}
	.red { color: #f30; }
	.alert-yellow { color: #FF6330; background-color: #FFFFCC; border-color: #FFDA89; margin: 10px 0; letter-spacing: 0.5px; border-radius: 2px; }
	.btn-green { background-color: #1AB709 !important; border-color: #1AB709; }
	.ace-nav>li.light-blue>a { background-color: #0c1627; }
	.main-container-inner, .page-content { background-color: #f8f8f8; }
	.wrap { padding: 5px; }
	.wechat-setting { background-color: rgba(0, 0, 0, 0); border: none; padding: 0; }
	.wechat-setting .function { background-color: #fff; padding: 15px; box-shadow: 2px 2px 5px #ddd; margin-bottom: 20px; }
	.wechat-setting .function .function-box { overflow: hidden; }
	.wechat-setting .function h4 { margin: 0; padding: 5px 0; line-height: 35px; font-size: 18px; margin-bottom: 10px; }
	.wechat-setting .function h4 span { font-size: 14px; color: blue; cursor: pointer; }
	.wechat-setting .function .left table td.title { width: 200px; }
	pre { margin: 0; }
	.btn-box { text-align: center; }
	.set-angle { position: relative; }
	.set-angle .icon-angle-down { margin: 0; font-size: 16px; font-weight: bold; }
	.more-opera { position: absolute; right: 0; top: 124%; padding: 0 10px; height: 35px; line-height: 35px; border-radius: 4px; box-shadow: 0 0 8px #ccc; min-width: 60px; text-align: center; color: #555; font-size: 14px; display: none; cursor: pointer; }
	.more-opera:hover { color: #333; }
	.layer_notice { width: 630px; overflow: hidden; background: #5FB878; padding: 10px; }
	.layer_notice li { list-style: none; line-height: 25px; }
	.layer_notice a { color: #fff; }
</style>
<{if $overdue == 'yes'}>
	<div class="alert alert-block alert-yellow " style="clear: both;">
		<div class="pull-right">
			<a href="<{$auth_uri}>" class="btn btn-sm btn-green">重新授权</a>
		</div>
		<div>
			重要提示：您授权的小程序已过期,更新代码、同步信息等功能将无法使用,请点击右侧按钮重新授权。
		</div>
	</div>
<{/if}>

<div class="alert alert-block alert-success" style="margin-top: 10px">
	<ol>
		<li>
			小程序名称：已上线的小程序修改名称的话需要交纳300元认证费重新认证改名
		</li>
		<li>
			小程序头像：登录<a href="https://mp.weixin.qq.com" target="_blank">https://mp.weixin.qq.com</a><微信公众平台>微信小程序后台-> 设置-> 基本设置-> 小程序头像修改。一年内可申请修改5次
		</li>
	</ol>
</div>

<div class="wrap">
	<div class="wechat-setting">
		<div class="function">
			<h4>开发信息</h4>
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">小程序名称：</td>
							<td style="border-right: none;">
								<{if $row['ac_name']}>
								<{$row['ac_name']}>
								<{else}>
								<span style="color: #d81b1b;">小程序还未设置昵称、头像、简介。请先<a href="https://mp.weixin.qq.com" target="_blank">设置</a>完后再重新授权。</span><br>
								<span style="color: #d81b1b">未初始化的小程序将无法提交代码审核!</span>
								<{/if}>
							</td>
							<td style="text-align: right;border-left: none;">
								<a href="javascript:void(0)" onclick="openAuthuri(this,event)" data-authdomain="<{$authdomain}>" data-authtype="<{$authtype}>" data-authuri="<{$authcode}>" class="btn btn-sm btn-green">重新授权</a>
							</td>
						</tr>
						<tr>
							<td class="title">认证类型：</td>
							<td style="border-right: none;">
								<{if $row['ac_verify_type'] == -1}>
								未认证
								<{elseif $row['ac_verify_type'] == 0}>
								微信认证
								<{/if}>
							</td>
							<td style="text-align: right;border-left: none;">
							</td>
						</tr>
						<tr>
							<td class="title">回调URL：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
		                            <input type="text" class="form-control" id="copy-input" value="<{$plat_info['cb_url']}>" placeholder="" readonly="">
		                            <a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input">复制</a>
		                        </div>
							</td>
						</tr>
						<tr>
							<td class="title">回调Token：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
		                            <input type="text" class="form-control" id="copy-input1" value="<{$plat_info['cb_token']}>" placeholder="" readonly=""> 
		                            <a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input1">复制</a>
		                        </div>
							</td>
						</tr>
						<tr>
							<td class="title">服务类目：</td>
							<td style="border-right: none;">
								<{foreach $plat_info['cb_category'] as $item}>
									<{foreach $item as $val}>
										<span><{$val}></span>
									<{/foreach}>
								<{/foreach}>
							</td>
							<td style="text-align: right;border-left: none;">
								<a href="javascript:void(0)" onclick="syncCategory(this, event)" class="btn btn-sm btn-green">同步</a>
							</td>
						</tr>
						<tr>
							<td class="title">权限集：</td>
							<td style="border-right: none;">
								<{$func_scope}>
								<span style="color: red;font-size: 12px;">提示：若有权限集显示"未授权"，则先登录(https://mp.weixin.qq.com)微信小程序平台->设置->第三方服务->停止授权，然后再重新授权即可</span>
							</td>
							<td style="text-align: right;border-left: none;">

							</td>
						</tr>
						<tr>
							<td class="title">技术支持水印：</td>
							<td style="border-right: none;"><{if $row['ac_watermark']}><{$row['ac_watermark']}><{else}>天店通<{/if}>提供技术支持</td>
							<td style="text-align: right;border-left: none;">
								<!--
								<{if $row['ac_self_renewal'] gt 0}>
								<a href="javascript:;" class="btn btn-sm btn-green update-watermark" data-watermark="<{$row['ac_watermark']}>">自定义</a>
								<{/if}>
								-->
							</td>

						</tr>
					</table>
				</div>
				<div class="right">
					<div class="erweima" style="padding: 15px 0;">
						<img src="<{$row['ac_wxacode']}>" style="width: 80%;" alt="小程序二维码">
					</div>
					<div class="btn-box">
						<a href="/wxapp/setup/downloadQrcode" class="btn btn-sm btn-green js_submit_check">下载小程序码</a>
						<span class="btn btn-sm btn-green set-angle js-set-angle">
							<b class="icon-angle-down"></b>
							<span class="more-opera" onclick="resetWxacode(this)">重置小程序码</span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="function">
			<h4>小程序信息</h4>
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">小程序APPID：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input21" value="<{$row['ac_appid']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input21">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">小程序原始ID：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input22" value="<{$row['ac_gh_id']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input22">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">小程序头像：</td>
							<td style="border-right: none;">
								<img style="width:50px;height: 50px;border-radius: 50%;" src="<{$row['ac_avatar']}>">
							</td>
							<td style="text-align: right;border-left: none;">
								<a href="" target="_blank" class="link"></a>
							</td>
						</tr>
						<tr>
							<td class="title">小程序主体：</td>
							<td style="border-right: none;">
								<{$row['ac_principal']}>
							</td>
							<td style="text-align: right;border-left: none;">
								<a href="" target="_blank" class="link"></a>
							</td>
						</tr>
						<tr>
							<td class="title">小程序介绍：</td>
							<td style="border-right: none;">
								<{$row['ac_signature']}>
							</td>
							<td style="text-align: right;border-left: none;">
								<a href="" target="_blank" class="link"></a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<!--
		<div class="function">
			<h4>微信开放平台帐号管理
				<span class="pull-right">
					<{if $row['ac_open_appid']}>
					<a href="javascript:void(0)" onclick="bindOpen(this, event)" data-bind="1" class="btn btn-sm btn-green">绑定新公众号/小程序</a>
					<a href="javascript:void(0)" onclick="unbindOpen(this, event)" class="btn btn-sm btn-danger">将当前小程序从已有开放平台账号下解绑</a>
					<{else}>
					<a href="javascript:void(0)" onclick="createOpen(this, event)" class="btn btn-sm btn-green">为当前小程序创建开放平台账号</a>
					<a href="javascript:void(0)" onclick="bindAppid(this, event)" class="btn btn-sm btn-yellow">将当前小程序绑定到已有开放平台账号下</a>
					<{/if}>
				</span>
			</h4>
			<p>开放平台账号：<{if $row['ac_open_appid']}><{$row['ac_open_appid']}><{else}>请点击上方重新授权按钮, 将权限"开放平台帐号管理权限"授权给天店通平台方可使用功能<{/if}></p>
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">当前已管理小程序APPID：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input21" value="<{$row['ac_appid']}>" placeholder="" readonly="">
									<a class="input-group-addon copy_input" data-clipboard-target="copy-input21">复制</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		-->
		<div class="function">
			<h4>服务器域名
				<span class="pull-right">
					于<{date('Y-m-d H:i:s', $row['ac_domain_time'])}>修改
				</span>
			</h4>
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">request合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input2" value="<{$domain['req']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input2">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">socket合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input3" value="<{$domain['wss']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input3">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">uploadFile合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input4" value="<{$domain['upl']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input4">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">downloadFile合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input5" value="<{$domain['dow']}>" placeholder="" readonly="">
									<a class="input-group-addon new_copy_input"  data-clipboard-action="copy" data-clipboard-target="#copy-input5">复制</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="right">
					<div class="btn-box">
						<a href="javascript:void(0)" onclick="fetchDomain(this, event)" class="btn btn-sm btn-green">获取服务器域名</a>
						<span class="btn btn-sm btn-green set-angle js-set-angle">
							<b class="icon-angle-down"></b>
							<span class="more-opera" onclick="syncDomain(this, event)">重置服务器域名</span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!--
		<div class="function">
			<h4>小程序子帐号管理<span class="pull-right"><a href="/wxapp/child/index" class="btn btn-sm btn-green">进入子账号管理</a></span></h4>
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">功能说明：</td>
							<td style="border-right: none;"></td>
							<td style="text-align: right;border-left: none;">

							</td>
						</tr>
						<tr>
							<td class="title">已绑定数量：</td>
							<td style="border-right: none;">

							</td>
							<td style="text-align: right;border-left: none;">

							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		-->
	</div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 560px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="stopShow(this)">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					自定义水印
				</h4>
			</div>
			<div class="modal-body">
				<!--修改水印-->
				<div id="update-watermark">
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">修改技术支持水印：</label>
						<div class="col-sm-8 level-box">
							<input type="text" class="form-control" name="update_watermark" id="update_watermark" oninput="changeName(this)" style="width: 100%">
							<p id="watermark_tips" style="color: red;font-size: 12px;">修改水印将会收取50元费用，水印格式（<span style="text-decoration: underline;color: green" class="company_name">　　　</span>提供技术支持）</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消
						</button>
						<button type="button" class="btn btn-primary" id="conform-update-watermark">
							确认修改
						</button>
					</div>
				</div>
				<div class="nowbuy-con" style="display: none">
					<div class="zent-dialog-body clearfix">
						<div class="pay-info" style="margin-bottom: 5px;">
							<dl>
								<dt>生效时间：</dt>
								<dd>支付成功后，立即生效</dd>
							</dl>
							<dl>
								<dt>修改价格：</dt>
								<dd><span class="money" id="produce-price">￥50</span></dd>
							</dl>
						</div>
						<div class="ui-nav clearfix">
							<ul class="pull-left">
								<li class="pay-way-nav js-online-pay active">
									<a href="javascript:;">微信扫码支付</a>
								</li>
								<li class="pay-way-nav js-offline-pay">
									<a href="javascript:;">支付宝扫码支付</a>
								</li>
							</ul>
						</div>
						<div class="online-pay-content" style="display: block;">
							<div class="zent-alert">
								<span class="red">提醒：</span>支付成功后，水印信息立即生效
							</div>
							<div class="pay-qrcode image-code">
								<img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
							</div>
							<div class="weixin-btn">
								<p>微信扫码支付，成功后水印信息立即生效</p>
								<input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
								<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
							</div>
						</div>
						<div class="online-pay-content" style="display: none;">
							<div class="zent-alert">
								<span class="red">提醒：</span>支付成功后，水印信息立即生效
							</div>
							<div class="pay-qrcode image-code">
								<img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
							</div>
							<div class="weixin-btn">
								<p>支付宝扫码支付，成功后水印信息立即生效</p>
								<input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
								<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>
</div>
<{include file="../bs-alert-tips.tpl"}>
<div id="domain-show" style="display: none;">
	<ul class="layer_notice" style="display: block;">
		<li>request. <a href="#" id="requestdomain"></a></li>
		<li>socket. <a href="#" id="wsrequestdomain"></a></li>
		<li>uploadFile. <a href="#" id="uploaddomain"></a></li>
		<li>downloadFile. <a href="#" id="downloaddomain"></a></li>
	</ul>
</div>
<script type="text/javascript" src="/public/plugin/clipboard/clipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/mobile/js/cookie.js"></script>
<script>
	var currSwitch = 0, currSuid = '<{$curr_shop['s_unique_id']}>',watermark='';
	$(function() {
		/*
		//设置指定时间后页面刷新，以重新获取预授权码
		var expires = 600*1000;
		window.setTimeout(function() {
			window.location.reload();
		}, expires);
		*/
		$(".js-set-angle").on('click', function(event) {
			$(this).find(".more-opera").stop().fadeToggle();
		});
		$(".more-opera").on('click', function(event) {
			event.stopPropagation();
		});
		$(".js-set-angle").on('click', function(event) {
			event.stopPropagation();
		});
		$("body").on('click', function(event) {
			var isShow = $(".more-opera").css("display");
			if(isShow == 'block'){
				$(".more-opera").stop().fadeOut();
			}
		});
	});
	// 复制通用js
	var clipboard = new ClipboardJS('.new_copy_input');
    clipboard.on('success', function(e) {
        console.log(e);
        showTips('复制成功');
    });
	/*开启关闭快速关注*/
	$("#on-off input").click(function(event) {
		if($('#on').is(':checked')){
			$('#on-input').stop().show();
		}else{
			$('#on-input').stop().hide();
		}
	});
	$(".save-btn").on('click',function() {
		var follow = $('#wx_follow').val();
		if(follow){
			var data = {
				'follow' : follow
			};
			$.ajax({
				'type'  : 'post',
				'url'   : '/manage/wechat/follow',
				'data'  : data,
				'dataType' : 'json',
				success : function(ret){
					layer.msg(ret.em);
				}
			});
		}
	});

	function jiebangTip(){
		layer.msg('解除绑定微信号，会造成当前店铺的重要信息丢失（包括粉丝信息等），请谨慎操作!如需解绑，请点击右侧联系客服，协助处理解绑。',{
			time: 5000
		});
	}

	function syncCategory(obj, event) {
		event.preventDefault();
		var index = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/syncCategory',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					layer.close(index);
					location.reload();
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}

	function resetWxacode(obj) {
		var index = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/resetWxacode',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					layer.close(index);
					location.reload();
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}

	function unbindOpen(obj, event) {
		event.preventDefault();
		var loading = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/unbindOpen',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(loading);
				if(ret.ec == 200){
					layer.msg(ret.data, {
						time: 0 //不自动关闭
						,btn: ['确定']
						,yes: function(index){
							layer.close(index);
							location.reload();
						}
					});
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}

	function createOpen(obj, event) {
		event.preventDefault();
		var loading = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/createOpen',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(loading);
				if(ret.ec == 200){
					layer.msg(ret.data, {
						time: 0 //不自动关闭
						,btn: ['确定']
						,yes: function(index){
							layer.close(index);
							location.reload();
						}
					});
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}

	function bindOpen(obj, event) {
		event.preventDefault();
		var type	= $(obj).data('bind');
		layer.prompt({title: '请输入公众号/小程序的APPID'}, function(val, index){
			layer.close(index);
			if (val) {
				var loading = layer.load(2, {time: 10*1000});
				$.ajax({
					type    : 'post',
					url     : '/wxapp/setup/bindOpen',
					data    : {
						'appid' : val,
						'type'	: type
					},
					dataType: 'json',
					success : function(ret){
						layer.close(loading);
						if(ret.ec == 200){
							layer.msg(ret.data, {
								time: 0 //不自动关闭
								,btn: ['确定']
								,yes: function(index){
									layer.close(index);
									location.reload();
								}
							});
						}else{
							layer.msg(ret.em);
						}
					}
				});
			}
		});
	}

	function bindAppid(obj, event) {
		event.preventDefault();
		layer.prompt({title: '请输入开放平台的APPID'}, function(val, index){
			layer.close(index);
			if (val) {
				var loading = layer.load(2, {time: 10*1000});
				$.ajax({
					type    : 'post',
					url     : '/wxapp/setup/bindAppid',
					data    : {
						'appid' : val
					},
					dataType: 'json',
					success : function(ret){
						layer.close(loading);
						if(ret.ec == 200){
							layer.msg(ret.data, {
								time: 0 //不自动关闭
								,btn: ['确定']
								,yes: function(index){
									layer.close(index);
									location.reload();
								}
							});
						}else{
							layer.msg(ret.em);
						}
					}
				});
			}
		});
	}

    //水印名称变化
    function changeName(ele) {
        var val = $(ele).val();
        if(val.length>0){
            val = ' '+ val+' ';
        }else {
            val = '　　　';
        }
        $('.company_name').text(val)
    }

    $('.update-watermark').on('click',function () {
        $('#myModal').modal('show');
		watermark = $(this).data('watermark');
        if(watermark.length>0){
            $('#update_watermark').val(watermark);
            watermark = ' '+ watermark+' ';
        }else {
            $('#update_watermark').val('');
            watermark = '　　　';
        }
        $('.company_name').text(watermark);
    });

	/*支付方式tab栏切换*/
    $(".pay-way-nav").click(function(event) {
        currSwitch++;
        var that    = this;
        changePay(that);
    });

	/*选购*/
    $("#conform-update-watermark").on('click', function(event) {
		watermark = $('#update_watermark').val();
		if(watermark){
            event.preventDefault();
            currSwitch  = 0;//重置
            $('#myModal').modal('show');//选购弹出层显示
            $('#update-watermark').stop().hide();
            $('.nowbuy-con').stop().show();
            changePay(null);
		}else{
		    layer.msg('请填写水印');
			return;
		}
        console.log(watermark);
    });

    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/setup/chargeQrcode?unique='+currSuid+'&channel='+type[index]+'&watermark='+watermark;
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }

    function hadPay(obj, event) {
        event.preventDefault();
        var new_url = "/wxapp/setup/index?select_suid="+currSuid;
        window.location.replace(new_url);
    }

    function changePay(obj) {
        obj = obj ? obj : $('.pay-way-nav').first();
        $(obj).addClass('active').siblings().removeClass('active');
        var index = $(obj).index();
        $(".online-pay-content").eq(index).stop().show();
        $(".online-pay-content").eq(index).siblings('.online-pay-content').stop().hide();
        if (currSwitch < 2) {
            qrcode(index);
        }
    }
    //用于弹窗内容隐藏
	function stopShow(ele){
		$('.nowbuy-con').stop().hide();
		$('#update-watermark').stop().show();
	}

	function openAuthuri(obj, event) {
		event.preventDefault();
		var type 	= $(obj).data('authtype');
		var authcode= $(obj).data('authuri');
		var domain	= $(obj).data('authdomain');
		if (type == 'domain') {
			window.open(authcode);
		} else {
			window.open(domain+"/manage/user/center?loginid="+authcode);
		}
	}

	function openCenter(obj, event) {
		event.preventDefault();
		layer.open({
			type: 1
			,title: false //不显示标题栏
			,closeBtn: false
			,area: '300px;'
			,shade: 0.8
			,id: 'LAY_layuipro' //设定一个id，防止重复弹出
			,resize: false
			,btn: ['重新登录', '暂不授权']
			,btnAlign: 'c'
			,moveType: 1 //拖拽模式，0或者1
			,content: '<div style="padding: 30px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
			'由于在微信开放平台中绑定的域名为: www.tiandiantong.com,与当前访问域名(' + location.hostname +
			')不符,如欲继续授权,需要在www.tiandiantong.com域名下的管理后台重新登录。' +
			'<span style="color: orangered;">如遇提示为非安全性网站,请忽略,并继续访问,或者<a href="http://se.360.cn/" style="color: #45d983;" target="_blank">下载360安全浏览器</a>访问。</span></div>'
			,success: function(layero){
				var btn = layero.find('.layui-layer-btn');
				btn.find('.layui-layer-btn0').attr({
					href: 'http://www.tiandiantong.com/manage/user/index'
					,target: '_blank'
				});
			}
		});
	}

	function syncDomain(obj, event) {
		event.preventDefault();
		layer.msg('确定再次同步服务器域名？', {
			time: 0 //不自动关闭
			,btn: ['确定', '取消']
			,yes: function(index){
				layer.close(index);
				var loading = layer.load(2, {time: 10*1000});
				$.ajax({
					type    : 'post',
					url     : '/wxapp/setup/syncDomain',
					data    : '',
					dataType: 'json',
					success : function(ret){
						layer.close(loading);
						if(ret.ec == 200){
							layer.msg('服务器域名同步成功', {
								time: 0 //不自动关闭
								,btn: ['确定']
								,yes: function(index){
									layer.close(index);
									location.reload();
								}
							});
						}else{
							layer.msg(ret.em);
						}
					}
				});
			}
		});
	}

	function fetchDomain(obj, event) {
		event.preventDefault();

		var loading = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/fetchDomain',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(loading);
				if(ret.ec == 200){
					//处理
					for (var item in ret.data) {
						$("#"+item).text(ret.data[item].join(','));
					}
					layer.open({
						type: 1,
						shade: false,
						title: false,
						content: $('#domain-show'),
						cancel: function(){

						}
					});
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}
</script>