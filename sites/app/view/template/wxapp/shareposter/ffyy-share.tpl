<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="format-detection" content="telephone=no">
    <meta content="email=no" name="format-detection">
    <link rel="stylesheet" href="/public/wxapp/ffyyshare/css/base.css">
    <link rel="stylesheet" href="/public/wxapp/ffyyshare/css/index.css?8">
</head>
<body>
<div class="ffyy-share" id="job-wrap">
    <div class="good-img"><img src="<{$goods['g_cover']}>" alt=""></div>
    <div class="good-name"><{$goods['g_name']}></div>
    <div class="good-price">￥<{$goods['g_price']}></div>
    <div class="code-show">
        <img src="<{$goods['g_qrcode']}>" alt="">
        <p>长按小程序码查看更多信息</p>
    </div>
</div>
</body>
</html>