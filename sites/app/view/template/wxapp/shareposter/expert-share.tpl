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
    <link rel="stylesheet" href="/public/wxapp/expertshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/expertshare/css/index.css?19" />
</head>
<body>
    <div  id="job-wrap">
        <div class="share-content">
            <div class="card-infor">
                <div class="bg-color">
                    <img src="/public/wxapp/expertshare/images/expert-bg1.png" alt="背景" />
                </div>
                <div class="infor-wrap">
                    <div class="avatar-infor flex-wrap">
                        <div class="avatar">
                            <img src="<{$expert['ahe_cover']}>" alt="头像" />
                        </div>
                        <div class="infor-box flex-con">
                            <div class="name"><{$expert['ahe_name']}></div>
                            <div class="tel"><{$expert['ahe_mobile']}></div>
                            <div class="address"><{$expert['area']}>-<{$expert['ahe_agent']}></div>
                        </div>
                    </div>
                    <div class="year-sell flex-wrap border-t">
                        <div class="flex-con">
                            <div class="con"><{$expert['ahe_work_year']}>年</div>
                            <div class="desc">从业年限</div>
                        </div>
                        <div class="flex-con">
                            <div class="con"><{$expert['ahe_traded_num']}>套</div>
                            <div class="desc">成交房源</div>
                        </div>
                        <div class="flex-con">
                            <div class="con"><{if $expert['ahe_label']}><{$expert['ahe_label']}><{else}>暂无<{/if}></div>
                            <div class="desc">资质</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="house-code">
                <img class="bg" src="/public/wxapp/expertshare/images/expert-bg2.png" alt="" />
                <div class="house-code-infor">
                    <div class="house-num flex-wrap">
                        <div class="num-item flex-con">
                            <span>在售房源<{$saleCount}>处</span>
                        </div>
                        <div class="num-item flex-con">
                            <span>出租房源<{$rentCount}>处</span>
                        </div>
                    </div>
                    <div class="applet-code">
                        <img src="<{$expert['ahe_qrcode']}>" alt="" />
                        <span>长按识别小程序码查看更多房产信息</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>