<link rel="stylesheet" href="/public/manage/css/chooseShop.css">
<link rel="stylesheet" href="/public/wxapp/css/index.css?4">
<style>
.alert-yellow { color: #333; font-weight: normal; background-color: #FFFFCC; border-color: #FFDA89; letter-spacing: 0.5px; margin: -20px -20px 15px; border-radius: 2px; font-size: 16px; font-weight: 600; font-family: "黑体"; line-height: 1.8; border: none; padding: 25px 15px; }
.alert-yellow a { color: #38f; }
.alert-yellow i { color: red; }
.update-content { font-size: 13px; margin-left: 20px; }
.base-wrap {overflow: unset;}
.base-info{background-color: #fff;border-color: #e8e8e8;}
.applet-helper{width: 330px;height: 194px;background-color: #fff;float: right;padding: 15px 20px;border:1px solid #e8e8e8;}
.applet-helper .helper-code{position: relative;width: 60px;margin:0 auto;}
.applet-helper .helper-code .little-code{height: 60px;width: 60px;border-radius: 10px;display: block;margin:0 auto;}
.applet-helper .helper-code .big-code{height: 300px;width: 300px;position: absolute;left: 50%;top:60px;margin-left: -150px;display: none;border:1px solid #ddd;box-shadow: 2px 2px 10px #ccc;}
.applet-helper .helper-code:hover .big-code{display: block;}
.applet-helper .helper-title{font-size: 15px;font-weight: bold;padding:10px 0;text-align: center;}
.applet-helper .helper-intro{font-size: 13px;color: #999;line-height: 1.7;}
</style>

	<div class="alert alert-block alert-yellow" style="margin-bottom: 0;">
		<{if $sys_notice && isset($sys_notice[0])}>
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<i class="icon-exclamation-sign"></i>
		[公告] <{$sys_notice[0]['sn_title']}>
		<a target="_blank" href="#">点此查看</a>
		<div class="update-content">
			<{$sys_notice[0]['sn_content']}>
		</div>
		<{/if}>
	</div>

<div class="index-wrap">
	<div class="base-wrap">
		<!--
		<{if $appletCfg['ac_type'] eq 1}>
		<div class="tdt-xcx pull-right">
			<div class="tdt-xcx-con">
				<div class="top-logo">
					<div class="pull-left">
						<img src="/public/wxapp/images/index/logo-tdt.png" alt="logo">
						<p>天店通微商城</p>
					</div>
					<div class="pull-right">
						<img src="/public/wxapp/images/index/logo-xcx.png" alt="logo">
						<p>天店通小程序</p>
					</div>
					<div class="icon-duijie">
						<img src="/public/wxapp/images/index/icon_duijie.png" alt="对接">
					</div>
				</div>
				<div class="opera-box">
					<a href="/manage/index/index" class="enter-btn">进入天店通微商城</a>
				</div>
			</div>
		</div>
		<{/if}>
		-->
		<div class="applet-helper">
			<div class="helper-code">
				<img src="/public/wxapp/images/applet-data-code.jpg" class="little-code" alt="数据统计小程序二维码">
				<img src="/public/wxapp/images/applet-data-code.jpg" class="big-code" alt="数据统计小程序二维码">
			</div>
			<div class="helper-title">小程序数据助手</div>
			<div class="helper-intro">微信公众平台发布的官方小程序，帮助相关开发和运营人员查看自身小程序的运营数据，扫描下面小程序码即可体验。</div>
		</div>
		<div class="base-info">
			<div class="row">
				<div class="col-xs-12">
					<h3>基本信息</h3>
					<div class="shop-name">
						<h4 class="name">店铺名称：<span><{$outinfo['sname']}></span></h4>
						<span class="icon-edit-box" onclick="modifyShopName(this, event)">修改<i class="icon-edit"></i></span>
					</div>
					<div class="kt-time">
						开通时间：<{$outinfo['open_time']}>
					</div>
					<div class="end-time">
						到期时间：<{$outinfo['expire_time']}> <a href="javascript:void(0)" data-xid="<{$outinfo['curr_type']}>" class="xufei-link js-buy-btn">续费</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="data-statistics">
		<div class="data-title">小程序数据助手<span>微信公众平台发布的官方小程序，帮助相关开发和运营人员查看自身小程序的运营数据，扫描下面小程序码即可体验。</span></div>
		<div class="data-applet-code">
			<img src="/public/wxapp/images/applet-data-code.jpg" alt="数据统计小程序二维码">
			<p>小程序数据助手二维码</p>
		</div>
	</div> -->
	<div class="tool-wrap">
		<h3 class="title-name">常用工具</h3>
		<ul class="tool-list">
			<{foreach $shortcut as $item}>
			<li>
				<a href="/wxapp<{$item['link']}>" class="tool-item bg-blue icon-qyzy" style="background-color: <{$item['color']}>;">
					<p><{$item['title']}></p>
					<h4><{$item['name']}></h4>
				</a>
			</li>
			<{/foreach}>
		</ul>
	</div>
	<!--
	<div class="hyfa-wrap">
		<h3 class="title-name">行业方案 <a href="/wxapp/guide/index" class="pull-right">切换类型</a></h3>
		<ul class="hyfa-list">
            <{foreach $catelist as $item}>
			<li class="<{if $item['used']}>used<{/if}>">
				<p class="no-used-txt">未启用</p>
				<a href="#" class="hyfa-item">
					<img src="/public/wxapp/guide/images/<{$item['logo']}>.png" alt="<{$item['name']}>">
					<p><{$item['name']}></p>
				</a>
			</li>
            <{/foreach}>
		</ul>
	</div>
	-->
</div>
<div class="modal fade" id="taocanBuyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="cooperateTitle"><{$outinfo['curr_wxapp']['name']}>小程序行业模板续费</h4>
			</div>
			<div class="modal-body">
				<div class="nowbuy-con">
					<div class="zent-dialog-body clearfix">
						<div class="pay-info" style="margin-bottom: 5px;">
							<dl>
								<dt>应用名称：</dt>
								<dd id="product-name"><{$outinfo['curr_wxapp']['name']}></dd>
							</dl>
							<dl>
								<dt>应用简介：</dt>
								<dd id="product-brief"><{$outinfo['curr_wxapp']['brief']}></dd>
							</dl>
							<dl>
								<dt>生效时间：</dt>
								<dd>支付成功后，服务时间将叠加</dd>
							</dl>
							<dl>
								<dt>应用价格：</dt>
								<dd><span class="money" id="produce-price"><{$outinfo['curr_wxapp']['priced']}></span></dd>
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
								<span class="red">提醒：</span>支付成功后，服务立即开通
							</div>
							<div class="pay-qrcode image-code">
								<img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
							</div>
							<div class="weixin-btn">
								<p>微信扫码支付，成功后服务立即开通</p>
								<input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
								<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
							</div>
						</div>
						<div class="online-pay-content" style="display: none;">
							<div class="zent-alert">
								<span class="red">提醒：</span>支付成功后，服务立即开通
							</div>
							<div class="pay-qrcode image-code">
								<img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
							</div>
							<div class="weixin-btn">
								<p>支付宝扫码支付，成功后服务立即开通</p>
								<input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
								<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" >
	var currSuid = "<{$outinfo['suid']}>", currVersion = 0, currSwitch = 0;
	var renewal = '<{$appletCfg['ac_self_renewal']}>';
	$(function(){
		// 动态修改导航z-index
		$(".modal").on('show.bs.modal', function () {
			$("#navbar").css("z-index",0);
		});
		$(".modal").on('hide.bs.modal', function () {
			$("#navbar").css("z-index",1);
		});

		/*支付方式tab栏切换*/
		$(".pay-way-nav").click(function(event) {
			currSwitch++;
			var that    = this;
			changePay(that);
		});

		/*选购*/
		$(".js-buy-btn").on('click', function(event) {
		    console.log(renewal);
		    if(renewal==1){
                event.preventDefault();
                currSwitch  = 0;//重置
                currVersion = $(this).data('xid');
                $("#taocanBuyModal").modal('show');//选购弹出层显示
                changePay(null);
			}else{
				layer.msg('暂不支持自助续费请和代理商联系');
			}
		});
	});

	//获取扫码
	function qrcode(index) {
		layer.load(2, {time: 1000});
		var type    = ['wxpay', 'alipay'];
		var url = '/wxapp/guide/chargeQrcode/version/'+currVersion+'/unique/'+currSuid+'/channel/'+type[index];
		var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

		img.attr('src', url);
	}

	function hadPay(obj, event) {
		event.preventDefault();
		var new_url = "/wxapp/index/index?select_suid="+currSuid;
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

	function modifyShopName(obj, event) {
		layer.prompt({title: '请输入新的店铺名称'}, function(val, index){
			layer.close(index);
			if (val) {
				var loading = layer.load(2, {time: 10*1000});
				$.ajax({
					type    : 'post',
					url     : '/wxapp/setup/modifyName',
					data    : {
						'name' : val
					},
					dataType: 'json',
					success : function(ret){
						layer.close(loading);
						if(ret.ec == 200){
							layer.msg('店铺名称修改成功', {
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