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
    <link rel="stylesheet" href="/public/wxapp/sequence/css/index-share.css?8" />
</head>
<body>
<div class="main-content" id="job-wrap">
    <img class="bg" src="<{$cfg['asc_shareposter_bg']}>" alt="" />
    <div class="content">
        <div class="goods-wrap">
            <{if $cfg['asc_shareposter_num'] == 2}>
            <!-- 2件商品 -->
            <div class="good-style1" style="">
                <{foreach $goods_list as $val}>
                <div class="good-item flex-wrap common-wrap">
                    <div class="cover">
                        <img src="<{$val['g_cover']}>" alt="" />
                    </div>
                    <div class="info-wrap flex-con">
                        <div class="name-wrap"><div class="name"><{$val['g_name']}></div></div>
                        <div class="money-wrap">
                            <span class="money"><span class="label">￥</span><{$val['g_price']}></span>
                            <span class="ori-money">￥<{$val['g_ori_price']}></span>
                        </div>
                    </div>
                </div>
                <{/foreach}>
            </div>
            <{elseif $cfg['asc_shareposter_num'] == 4}>
            <!-- 4件商品 -->
            <div class="good-style2 common-wrap clearfix" style="">
                <{foreach $goods_list as $val}>
                <div class="good-item">
                    <div class="cover">
                        <img class="img-label" src="/public/wxapp/sequence/images/img_cir.png" alt="" />
                        <img class="img" src="<{$val['g_cover']}>" alt="" />
                    </div>
                    <div class="name">
                        <{$val['g_name']}>
                    </div>
                    <div class="price-wrap">
                        <span class="price"><span>￥</span><{$val['g_price']}></span>
                        <span class="ori-price">￥<{$val['g_ori_price']}></span>
                    </div>
                </div>
                <{/foreach}>
            </div>
            <{elseif $cfg['asc_shareposter_num'] == 6}>
            <!-- 6件商品 -->
            <div class="good-style3 common-wrap clearfix" style="">
                <{foreach $goods_list as $val}>
                <div class="good-item">
                    <div class="cover">
                        <img src="<{$val['g_cover']}>" alt="" />
                    </div>
                    <div class="name"><{$val['g_name']}></div>
                    <div class="price"><span>￥</span><{$val['g_price']}></div>
                </div>
                <{/foreach}>
            </div>
            <{elseif $cfg['asc_shareposter_num'] == 8}>
            <!-- 8件商品 -->
            <div class="good-style4 common-wrap clearfix" style="">
                <{foreach $goods_list as $val}>
                <div class="good-item flex-wrap">
                    <div class="cover">
                        <img src="<{$val['g_cover']}>" alt="" />
                    </div>
                    <div class="info flex-con">
                        <div class="name"><{$val['g_name']}></div>
                        <div class="price"><span>￥</span><{$val['g_price']}></div>
                    </div>
                </div>
                <{/foreach}>
            </div>
            <{/if}>
        </div>
        <div class="colonel-wrap common-wrap">
            <div class="colonel-info">
                <div class="info-item flex-wrap">
                    <div class="desc">小区团长</div>
                    <div class="con flex-con"><{$qrcode_info['leader']}></div>
                </div>
                <!--
                <div class="info-item flex-wrap">
                    <div class="desc">抢购时间</div>
                    <div class="con flex-con">2019.07.20 18:20</div>
                </div>-->
                <div class="info-item flex-wrap">
                    <div class="desc">提货地址</div>
                    <div class="con flex-con"><{$qrcode_info['address']}></div>
                </div>
            </div>
            <div class="qrcode-wrap flex-wrap">
                <div class="code">
                    <img src="<{$qrcode_info['qrcode']}>" alt="" />
                </div>
                <div class="desc-wrap flex-con">
                    <p>长按识别小程序码</p><p>更多爆款抢先购买</p>
                    <div class="triangle_border_left">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
