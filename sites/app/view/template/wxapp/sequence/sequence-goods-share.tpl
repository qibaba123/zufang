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
	<link rel="stylesheet" href="/public/wxapp/sequence/css/base.css" />
	<link rel="stylesheet" href="/public/wxapp/sequence/css/index.css" />
</head>
<body>
<div class="main-content"  id="job-wrap">
	<div class="new-share-content" >
		<img src="/public/wxapp/sequence/images/poster-bg.png" class="share-bg" alt="分享海报">
		<div class="poster-info">
			<img src="<{$cover}>" class="poster-cover" alt="封面">
			<div class="title"><{$name}></div>
			<div class="infor-wrap">
				<div class="price">￥<{$price}></div>
				<{if $oldPrice > 0}>
				<div class="ori-price">门店价:￥<{$oldPrice}></div>
				<{/if}>
				<div class="stock-wrap">已有<{$total}>人购买</div>
			</div>
		</div>
	</div>
	<div class="applet-code">
		<div class="left-code" style="display: inline-block;">
			<img src="/public/wxapp/sequence/images/img_frame.png" class="code-bg" alt="小程序码背景">
			<img src="<{$qrcode}>" class="code-img" alt="小程序码">
		</div>
		<div class="code-intro" style="display: inline-block;">
			<div class="code-title">长按识别小程序码参与活动</div>
			<div class="code-sub">分享来自<{$appletCfg['ac_name']}></div>
		</div>
	</div>
</div>
</body>
</html>