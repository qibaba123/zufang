<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="apple-mobile-web-app-title" content/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="email=no" name="format-detection" />
    <link rel="stylesheet" href="/public/wxapp/shopshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/shopshare/css/index.css?3" />
</head>
<body>
    <div class="detail-wrap"  id="job-wrap">
        <div class="shop-cover">
            <img src="<{$shop['cover']}>" class="cover" alt="封面">
            <img src="/public/wxapp/shopshare/images/img_arc.png" class="arc" alt="弧边">
        </div>
        <div class="shop-info">
            <div class="shop-logo"><img src="<{$shop['logo']}>" alt=""></div>
            <div class="shop-name"><{$shop['name']}></div>
            <div class="open-time">营业时间：<{$shop['openTime']}></div>
            <div class="activity-label clearfix">
                <{if $hasCoupon}>
            	<div class="label-item">
            		<img src="/public/wxapp/shopshare/images/icon_coupon.png" alt="" />
            		<span>优惠券</span>
            	</div>
                <{/if}>
                <{if $hasGroup}>
            	<div class="label-item">
            		<img src="/public/wxapp/shopshare/images/icon_pt.png" alt="" />
            		<span>拼团活动</span>
            	</div>
                <{/if}>
                <{if $hasLimit}>
            	<div class="label-item">
            		<img src="/public/wxapp/shopshare/images/icon_spike.png" alt="" />
            		<span>秒杀活动</span>
            	</div>
                <{/if}>
                <{if $hasBargain}>
            	<div class="label-item">
            		<img src="/public/wxapp/shopshare/images/icon_kj.png" alt="" />
            		<span>砍价活动</span>
            	</div>
                <{/if}>
                <{if $hasFree}>
            	<div class="label-item">
            		<img src="/public/wxapp/shopshare/images/icon_bespeak.png" alt="" />
            		<span>预约</span>
            	</div>
                <{/if}>
            </div>
            <div class="addr-tel">
                <div class="info-item">
                    <img src="/public/wxapp/shopshare/images/icon_address.png" class="icon" alt="">
                    <p><{$shop['address']}></p>
                </div>
                <div class="info-item">
                    <img src="/public/wxapp/shopshare/images/icon_tel.png" class="icon" alt="">
                    <p><{$shop['mobile']}></p>
                </div>
            </div>
            <div class="applet-code">
                <img src="<{$shop['qrcode']}>" class="code-img" alt="小程序码">
                <p>长按识别小程序了解更多</p>
            </div>
        </div>
    </div>
</body>
</html>