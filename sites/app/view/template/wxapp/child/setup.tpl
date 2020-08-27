<link rel="stylesheet" href="/public/manage/css/bindsetting.css">
<style>
	.red {
		color: #f30;
	}
	.alert-yellow {
		color: #FF6330;
		background-color: #FFFFCC;
		border-color: #FFDA89;
		margin:10px 0;
		letter-spacing: 0.5px;
		border-radius: 2px;
	}
	.btn-green {
		background-color: #1AB709 !important;
		border-color: #1AB709;
	}
	.ace-nav>li.light-blue>a{
		background-color: #0c1627;
	}
	.main-container-inner,.page-content{
	    background-color: #f8f8f8;
	}
	.wrap{
		padding: 5px;
	}
	.wechat-setting{
		background-color: rgba(0,0,0,0);
		border:none;
		padding: 0;
	}
	.wechat-setting .function{
		background-color: #fff;
    	padding: 15px;
    	box-shadow: 2px 2px 5px #ddd;
    	margin-bottom: 20px;
	}
	.wechat-setting .function .function-box{
		overflow: hidden;
	}
	.wechat-setting .function h4{
		margin:0;
		padding: 5px 0;
		line-height: 35px;
		font-size: 18px;
		margin-bottom: 10px;
	}
	.wechat-setting .function h4 span{
		font-size: 14px;
		color: blue;
		cursor: pointer;
	}
	.wechat-setting .function .left table td.title{
		width: 200px;
	}
	pre{
		margin: 0;
	}
	.btn-box {
		text-align: center;
	}
	.set-angle{
		position: relative;
	}
	.set-angle .icon-angle-down{
		margin: 0;
    	font-size: 16px;
    	font-weight: bold;
	}
	.more-opera{
		position: absolute;
		right: 0;
		top: 124%;
		padding: 0 10px;
		height: 35px;
		line-height: 35px;
		border-radius: 4px;
		box-shadow: 0 0 8px #ccc;
		min-width: 60px;
		text-align: center;
		color: #555;
		font-size: 14px;
		display: none;
		cursor: pointer;
	}
	.more-opera:hover{
		color: #333;
	}
</style>
<div class="wrap">
	<div class="wechat-setting">
		<div class="function">
			<div class="function-box">
				<div class="left">
					<table>
						<tr>
							<td class="title">小程序名称：</td>
							<td style="border-right: none;"><{$row['ac_name']}></td>
							<td style="text-align: right;border-left: none;">
								<a href="/wxapp/child/grantAuth/appid/<{$row['ac_appid']}>" target="_blank" class="btn btn-sm btn-green">重新授权</a>
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
								<a href="" target="_blank" class="link"></a>
							</td>
						</tr>
						<tr>
							<td class="title">回调URL：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
		                            <input type="text" class="form-control" id="copy-input" value="<{$plat_info['cb_url']}>" placeholder="" readonly="">
		                            <a class="input-group-addon copy_input" data-clipboard-target="copy-input">复制</a>
		                        </div>
							</td>
						</tr>
						<tr>
							<td class="title">回调Token：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
		                            <input type="text" class="form-control" id="copy-input1" value="<{$plat_info['cb_token']}>" placeholder="" readonly="">
		                            <a class="input-group-addon copy_input" data-clipboard-target="copy-input1">复制</a>
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
							</td>
							<td style="text-align: right;border-left: none;">

							</td>
						</tr>
					</table>
				</div>
				<div class="right">
					<div class="erweima" style="padding: 15px 0;">
						<img src="<{$row['ac_wxacode']}>" style="width: 80%;" alt="小程序二维码">
					</div>
					<div class="btn-box">
						<a href="/wxapp/child/downloadQrcode/appid/<{$row['ac_appid']}>" class="btn btn-sm btn-green js_submit_check">下载小程序码</a>
						<span class="btn btn-sm btn-green set-angle js-set-angle">
							<b class="icon-angle-down"></b>
							<span class="more-opera" onclick="resetWxacode(this)">重置小程序码</span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="function">
			<h4>服务器域名
				<span class="pull-right">
					于<{date('Y-m-d H:i:s', $row['ac_domain_time'])}>修改
					<a href="javascript:void(0)" onclick="syncDomain(this, event)" class="btn btn-sm btn-green js_submit_check">同步服务器域名</a>
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
									<a class="input-group-addon copy_input" data-clipboard-target="copy-input2">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">socket合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input3" value="<{$domain['wss']}>" placeholder="" readonly="">
									<a class="input-group-addon copy_input" data-clipboard-target="copy-input3">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">uploadFile合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input4" value="<{$domain['upl']}>" placeholder="" readonly="">
									<a class="input-group-addon copy_input" data-clipboard-target="copy-input4">复制</a>
								</div>
							</td>
						</tr>
						<tr>
							<td class="title">downloadFile合法域名：</td>
							<td colspan="2">
								<div class="input-group" style="width: 100%;">
									<input type="text" class="form-control" id="copy-input5" value="<{$domain['dow']}>" placeholder="" readonly="">
									<a class="input-group-addon copy_input" data-clipboard-target="copy-input5">复制</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<{include file="../bs-alert-tips.tpl"}>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
	var appid	= "<{$row['ac_appid']}>";
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
	// 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
	// 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        //console.log("复制成功的内容是："+args.text);
        showTips('复制成功');
    } );

	function syncCategory(obj, event) {
		event.preventDefault();
		var index = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/child/syncCategory',
			data    : 'appid='+appid,
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
			url     : '/wxapp/child/resetWxacode',
			data    : 'appid='+appid,
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
					url     : '/wxapp/child/syncDomain',
					data    : 'appid='+appid,
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
</script>