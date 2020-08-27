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
    <link rel="stylesheet" href="/public/wxapp/blessing/css/base.css">
    <link rel="stylesheet" href="/public/wxapp/blessing/css/index.css?4">
</head>
<body>
<div class="greeting-wrap" id="job-wrap">
    <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/new/bg.png" class="top_bg" />
    <div class="greet-info">
        <div class="user-avatar"><img src="<{if $blessing['m_avatar']}><{$blessing['m_avatar']}><{/if}>" /></div>
        <div class="name-input">
            <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/new/input_bg.png"/>
            <div class="greet-txt"><{if $blessing['m_nickname']}><{$blessing['m_nickname']}><{/if}><{$blessing['abl_name']}></div>
        </div>
        <div class="common-wrap">
            <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/new/up.png" class="border"/>
            <div class="content">
                <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/new/middle.png" class="middle"/>
                <div class="greet-detail"><{$blessing['abl_content']}></div>
            </div>
            <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/new/down.png" class="border border-bottom"/>
        </div>
        <!-- <div class="common-wrap">
            <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/up.png" class="border"/>
            <div class="content">
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/img1.png"/>
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/img2.png"/>
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/gif_sz.gif" style="width:203px;margin:0 auto;"/>
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/img4.png"/>
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/img5.png"/>
                <img class="txt-img" src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/img6.png"/>
            </div>
            <img src="http://tiandiantong.oss-cn-beijing.aliyuncs.com/images/greetimg/down.png" class="border border-bottom"/>
        </div> -->
        <div class="code-show">
            <img src="<{if $qrcode}><{$qrcode}><{/if}>" alt="">
        </div>
    </div>
</div>
</body>
</html>