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
    <link rel="stylesheet" href="/public/wxapp/house/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/house/css/housePoster.css?18" />
</head>
<body>
<div class="main-content"  id="job-wrap">
    <div class="cover">
        <img src="<{$row['ahr_cover']}>" alt="" />
    </div>
    <div class="title"><{$row['ahr_title']}></div>
    <div class="label">
        <{foreach json_decode($row['ahr_label'], true) as $val}>
        <span><{$val}></span>
        <{/foreach}>
    </div>
    <div class="price-wrap">
        <{if $row['ahr_s_id'] eq 12253}>
        <span class="money"><{$row['ahr_area']}>m²</span>
        <span class="desc"><{$row['ahr_build_time']}></span>
        <span class="desc"><{$row['ahr_fitment']}></span>
        <{else}>
        <span class="money"><{$row['ahr_price']}><{if $row['ahr_sale_type']==2}>元/月<{else}>万<{/if}></span>
        <span class="desc"><{$row['ahr_area']}>m²</span>
        <span class="desc"><{$row['ahr_home_num']}>室<{$row['ahr_hall_num']}>厅</span>
        <{/if}>
    </div>
    <div class="code-wrap">
        <div class="code">
            <img src="<{$row['ahr_qrcode']}>" alt="" />
        </div>
        <span>长按小程序码查看更多信息</span>
    </div>
    <div class="mobile-wrap">
    	<span>联系人：</span>
        <span><{$row['ahr_contact']}></span>
        <span>·</span>
        <span><{$row['ahr_mobile']}></span>
    </div>
</div>
</body>
</html>