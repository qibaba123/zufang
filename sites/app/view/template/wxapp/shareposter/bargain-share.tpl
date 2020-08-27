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
    <link rel="stylesheet" href="/public/wxapp/bargain/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/bargain/css/index.css?16" />
</head>
<body>
<div class="main-content"  id="job-wrap">
    <div class="new-share-content">
        <img src="/public/wxapp/bargain/images/poster-bg.png" class="share-bg" alt="分享海报">
        <div class="poster-info">
            <img src="<{$goods['g_cover']}>" class="poster-cover" alt="封面">
            <div class="title"><{$goods['g_name']}></div>
            <div class="shop-info">
                <img src="<{$member['m_avatar']}>" class="shop-logo" alt="店铺logo">
                <!--<div class="share-intro"><{$shareDesc}></div>-->
                <div class="share-intro" style="line-height: 1.5em">我在<{$cfg['ac_name']}>参加砍价活动，原价<{$goods['g_price']}>元，最低价<{$activity['ba_kj_price_limit']}>元即可获得，快来帮我砍一刀吧~</div>
            </div>
        </div>
    </div>
    <div class="applet-code">
        <div class="left-code" style="display: inline-block;">
            <img src="/public/wxapp/bargain/images/img_frame.png" class="code-bg" alt="小程序码背景">
            <img src="<{$qrcode}>" class="code-img" alt="小程序码">
        </div>
        <div class="code-intro" style="display: inline-block;">
            <div class="code-title">长按识别小程序码参与活动</div>
            <div class="code-sub">分享来自<{$cfg['ac_name']}></div>
        </div>
    </div>
</div>
</body>
</html>