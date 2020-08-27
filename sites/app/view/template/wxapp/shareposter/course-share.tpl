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
    <link rel="stylesheet" href="/public/wxapp/courseshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/courseshare/css/index.css?2" />
    <style>
        .new-share-content .share-bg {
            height: 280px;
        }
        .poster-info {
            min-height: 260px;
        }
    </style>
</head>
<body>
    <div  id="job-wrap">
        <div class="share-content">
            <div class="img-cover">
                <img src="<{$course['atc_cover']}>" alt="" />
            </div>
            <div class="course-infor">
                <div class="title-wrap border-b">
                    <div class="title"><{$course['atc_title']}></div>
                    <div class="desc"><span><{$course['atc_hour']}>课时</span> <span><{$course['atc_apply']}>人参与</span></div>
                </div>
                <div class="price-wrap">
                    <span class="new-price"><{$course['atc_price']}></span>
                    <span class="old-price">原价：<{$course['atc_ori_price']}></span>
                </div>
                <div class="time">
                    <{if $course['atc_start_time']}>
                        <{date('Y.m.d', $course['atc_start_time'])}>
                    <{/if}>
                    <{if $course['atc_start_time'] && $course['atc_end_time']}>
                    -
                    <{/if}>
                    <{if $course['atc_end_time']}>
                    <{date('Y.m.d', $course['atc_end_time'])}>
                    <{/if}>
                </div>
                <div class="brief">
                    <div class="title"><span>课程简介</span></div>
                    <div class="con"><{$course['atc_brief']}></div>
                </div>
            </div>
            <div class="applet-code">
                <img src="<{$qrcode}>" alt="" />
                <span>长按识别小程序了解更多</span>
            </div>
        </div>
    </div>
</body>
</html>