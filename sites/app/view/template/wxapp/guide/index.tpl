<link rel="stylesheet" href="/public/manage/css/chooseShop.css">
<link rel="stylesheet" href="/public/wxapp/guide/css/select.css">
<div class="applet-muban">
    <div class="alert alert-block alert-success" style="line-height: 20px;">
        <a href="/wxapp/index" class="manage-center-btn">
            <span>管<br>理<br>中<br>心</span>
        </a>
        <div class="cur-choose-info">
            <div class="item-info">
                <span class="label-name">当前店铺：</span>
                <p><{$currinfo['sname']}></p>
            </div>
            <div class="item-info">
                <span class="label-name">开通模板：</span>
                <p><{$currinfo['tplname']}></p>
            </div>
            <div class="item-info">
                <span class="label-name">开通时间：</span>
                <p><{$currinfo['open']}></p>
            </div>
            <div class="item-info">
                <span class="label-name">到期时间：</span>
                <p><{$currinfo['expire']}></p>
            </div>
            <div class="item-info" style="width: 96%;">
                <span class="label-name">说　　明：</span>
                <p><{$currinfo['desc']}></p>
            </div>
        </div>
    </div>
	<h3 class="title">选择小程序行业模板</h3>
	<div class="row">
        <{foreach $category as $key => $item}>
		<div class="col-xs-4">
			<div class="applet-mb-wrap">
				<div class="mb-intro">
					<div class="left-logo">
						<img src="/public/wxapp/guide/images/<{$item['logo']}>.png" class="logo" alt="logo">
					</div>
					<div class="right-intro">
                        <{if $item['enable'] || $key eq 28}>
						<a href="javascript:void" class="buy-btn js-buy-btn"
                           data-xid="<{$key}>" data-xname="<{$item['name']}>" data-xprice="<{$item['saleprice']}>"
                           data-xbrief="<{$item['brief']}>">选购</a>
                        <{else}>
                        <a href="#" class="wait-btn">研发中</a>
                        <{/if}>
						<h4 class="applet-title"><{$item['name']}></h4>
						<p class="intro-txt"><{$item['brief']}></p>
					</div>
				</div>
				<div class="see-detail-price">
					<a href="#" class="detail-btn">查看详情</a>
					<p class="price"><{$item['suggestPrice']}></p>
				</div>
			</div>
		</div>
        <{/foreach}>
	</div>
</div>
<div class="modal fade" id="taocanBuyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="cooperateTitle">选购小程序行业模板</h4>
            </div>
            <div class="modal-body">
                <div class="nowbuy-con">
                    <div class="zent-dialog-body clearfix">
                        <div class="pay-info" style="margin-bottom: 5px;">
                            <dl>
                                <dt>应用名称：</dt>
                                <dd id="product-name"></dd>
                            </dl>
                            <dl>
                                <dt>应用简介：</dt>
                                <dd id="product-brief"></dd>
                            </dl>
                            <dl>
                                <dt>生效时间：</dt>
                                <dd>支付成功后，服务立即开通</dd>
                            </dl>
                            <dl>
                                <dt>应用价格：</dt>
                                <dd><span class="money" id="produce-price"></span></dd>
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
    var currSuid = "<{$currinfo['suid']}>", currVersion = 0, currSwitch = 0;
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
            event.preventDefault();
            currSwitch  = 0;//重置
            var xid     = $(this).data('xid');
            var xname   = $(this).data('xname');
            var xbrief  = $(this).data('xbrief');
            var xprice  = $(this).data('xprice');

            currVersion = xid;
            $('#product-name').text(xname);
            $('#product-brief').text(xbrief);
            $('#produce-price').text(xprice);
            $("#taocanBuyModal").modal('show');//选购弹出层显示
            changePay(null);
        });
    });

    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/guide/wxAlipayChargeQrcode/version/'+currVersion+'/unique/'+currSuid+'/channel/'+type[index];
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
</script>