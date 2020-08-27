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
	<link rel="stylesheet" href="/public/wxapp/mobile/css/base.css?2" />
	<link rel="stylesheet" href="/public/wxapp/mobile/css/index.css?23" />
</head>
<body>
<div class="new-share-content" id="job-wrap">
	<div class="info-show">
		<div class="name"><{$row['ams_name']}></div>
		<div class="company"><{$row['ams_contacts']}></div>
		<img src="<{$row['ams_logo']}>" class="logo" alt="logo">
	</div>
	<div class="tel-addr">
		<div class="info-item icon-tel"><{$row['ams_mobile']}></div>
		<div class="info-item icon-addr"><{$row['ams_address']}><{$row['ams_addr_detail']}></div>
	</div>
	<div class="main-business">
		<div class="label-title">主营业务</div>
		<p class="business-intro"><{$row['ams_management']}></p>
	</div>
	<div class="applet-code">
		<div class="left-code" style="display: inline-block;">
			<img src="<{$row['ams_qrcode']}>" class="code-img" alt="小程序码">
		</div>
		<div class="code-intro" style="display: inline-block;">
			<div class="code-title">长按识别小程序码</div>
			<div class="code-sub">分享来自<{$cfg['ac_name']}></div>
		</div>
	</div>
</div>
</body>
</html>