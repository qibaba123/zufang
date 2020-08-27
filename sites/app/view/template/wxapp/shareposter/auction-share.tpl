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
    <link rel="stylesheet" href="/public/wxapp/seckillshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/seckillshare/css/index.css?19" />
</head>
<body>
    <div  id="job-wrap">
        <div class="new-share-content">
            <img src="/public/wxapp/seckillshare/images/poster-bg.png" class="share-bg" alt="分享海报">
            <div class="poster-info">
                <img src="<{$auction['aal_cover']}>" class="poster-cover" alt="封面">
                <div class="title"><{$auction['aal_title']}></div>
                <!-- 普通商品显示 -->
                <div class="good-price">当前价格：￥<{$auction['aal_curr_price']}></div>
                <div class="ori-price">起拍价:￥<{$auction['aal_start_price']}></div>
            </div>
        </div>
        <div class="applet-code">
            <div class="left-code" style="display: inline-block;">
                <img src="/public/wxapp/seckillshare/images/img_frame.png" class="code-bg" alt="小程序码背景">
                <img src="<{$auction['aal_qrcode']}>" class="code-img" alt="小程序码">
            </div>
            <div class="code-intro" style="display: inline-block;">
                <div class="code-title">长按识别小程序码查看详情</div>
                <div class="code-sub">分享来自<{$cfg['ac_name']}></div>
            </div>
        </div>
    </div>
</body>
</html>