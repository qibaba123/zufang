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
    <link rel="stylesheet" type="text/css" href="/public/wxapp/city/css/base.css">
    <link rel="stylesheet" type="text/css" href="/public/wxapp/city/css/poster.css?3" />
</head>
<body>
<div class="main-content"  id="job-wrap">
    <div class="top-infor flex-wrap">
        <div class="infor flex-con">
            <div class="title"><{$category['acc_title']}></div>
            <div class="time"><{date('Y-m-d H:i:s', $post['acp_create_time'])}>发布</div>
            <div class="brow"><{$post['acp_show_num']}>人浏览</div>
        </div>
        <div class="code">
            <img src="<{$post['acp_qrcode']}>" alt="" />
            <span>长按识别二维码查看详情</span>
        </div>
    </div>
    <div class="detail">
        <{if $post['acp_post_type'] == 1 || $post['acp_post_type'] == 3}>
            <{if $post['acp_content']}>
            <div class="text">
                <{$post['acp_content']}>
            </div>
            <{/if}>
        <{/if}>
        <{if $post['acp_post_type'] == 2}>
        <div class="text">
            <{$post['acp_article_title']}>
        </div>
        <{/if}>
        <{if $image}>
        <div class="img-box">
            <img src="<{$image['aca_path']}>" alt="图片" />
        </div>
        <{/if}>
        <{if $post['acp_post_type'] == 2}>
        <div class="img-box">
            <img src="<{$post['acp_article_cover']}>" alt="图片" />
        </div>
        <{/if}>
        <{if $post['acp_post_type'] == 3}>
        <div class="img-box">
            <img src="<{$post['acp_video_cover']}>" alt="图片" />
        </div>
        <{/if}>
    </div>
</div>
</body>
</html>
