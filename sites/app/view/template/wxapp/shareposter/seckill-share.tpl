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
                <img src="<{$goods['g_cover']}>" class="poster-cover" alt="封面">
                <div class="title"><{$goods['g_name']}></div>
                <!-- 普通商品显示 -->
                <{if $goods['seckill'] == 0}>
                <div class="good-price">购买价：￥<{$goods['g_price']}></div>
                <{if $goods['g_ori_price']>0}>
                <div class="ori-price">原价:￥<{$goods['g_ori_price']}></div>
                <{/if}>
                <{elseif $goods['seckill'] == 1}>
                <div class="good-price">抢购价：￥<{$goods['g_price']}> <{if $goods['g_ori_price']>0}><span class="ori-price">原价:￥<{$goods['g_ori_price']}></span><{/if}></div>
                <div class="end-time">活动截止日期：<{date('Y-m-d H:i', $limitAct['la_end_time'])}></div>
                <{elseif $goods['seckill'] == 2}>
                <!-- 秒杀商品显示 -->
                <div class="good-price">抢购价：￥<{$goods['g_price']}> <{if $goods['g_ori_price']>0}><span class="ori-price">原价:￥<{$goods['g_ori_price']}></span><{/if}></div>
                <div class="end-time">活动开始时间：<{date('n月d日H:i', $limitAct['la_start_time'])}></div>
                <{/if}>
            </div>
        </div>
        <div class="applet-code">
            <div class="left-code" style="display: inline-block;">
                <img src="/public/wxapp/seckillshare/images/img_frame.png" class="code-bg" alt="小程序码背景">
                <img src="<{$qrcode}>" class="code-img" alt="小程序码">
            </div>
            <div class="code-intro" style="display: inline-block;">
                <div class="code-title">长按识别小程序码查看详情</div>
                <div class="code-sub">分享来自<{$cfg['ac_name']}></div>
            </div>
        </div>
    </div>
</body>
</html>