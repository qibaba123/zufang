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
    <link rel="stylesheet" href="/public/wxapp/meetingshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/meetingshare/css/index.css?16" />
</head>
<body>
    <div class="content" id="job-wrap">
        <div class="share-content">
            <div class="img-cover">
                <img src="<{$meeting['am_cover']}>" alt="" />
            </div>
            <div class="meeting-infor">
                <div class="title-wrap">
                    <div class="title"><{$meeting['am_title']}></div>
                </div>
                <div class="price-wrap">
                    <span class="new-price">￥<{$meeting['am_price_range']}></span>
                </div>
                <div class="address-time">
                    <div class="address"><{$city}>·<{$meeting['am_address']}></div>
                    <div><{date('Y.m.d', $meeting['am_start_time'])}></div>
                </div>
            </div>
            <div class="applet-code">
                <img src="<{$meeting['am_qrcode']}>" alt="" />
                <span>长按识别小程序了解更多</span>
            </div>
        </div>
    </div>
</body>
</html>