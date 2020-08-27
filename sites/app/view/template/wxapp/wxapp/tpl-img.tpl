<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv=X-UA-Compatible content="IE=EmulateIE10">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>模板导图</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/site/css/userCase.css">
    <style>
        a{
            text-decoration: none;
            color: #333;
        }
        ul{
            list-style-type: none;
        }

        .case-list li {
            width: auto;
            height: auto;
            border: 0;
        }

        .case-list .case-code img {
            margin: 100px 10px;
        }

        .case-list li .case-code {
            height: 88%;
        }

        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
    </style>

</head>

<div class="userCase-wrap">
    <!--<div class="case-title">
        <img src="/public/agent/index/images/yonghuanli.png" alt="banner-title">
    </div>
    <div class="case_nav">
        <nav class="inv-type">
            <div id="navul" style="display: inline-block;">
                <span class="tab <{if !$type}>tab-active<{/if}>"><a href="/agent/index/case">全部</a></span>
                <{foreach $category as $key=>$value}>
                <span class="tab <{if $type == $key}>tab-active<{/if}>"><a href="/agent/index/case/type/<{$key}>"><{$value}></a></span>
                <{/foreach}>
            </div>
        </nav>
    </div>-->
    <div class="case-list">
        <ul class="clearfix">
            <li>
                <img class="lazy" src="/public/wxapp/tplimage/images/<{$tplimg}>" alt="案例图片">
                <!--<div class="case-code">
                    <img class="lazy" data-original="<{$value['cc_qrcode']}>" alt="二维码">
                </div>
                <div class="cc_name"><{$value['cc_name']}></div>-->
            </li>
        </ul>
    </div>
</div>
<script src="/public/common/js/jquery-1.11.1.min.js"></script>
<script src="/public/plugin/lazyload/jquery.lazyload.min.js"></script>
<script>
    /*图片预加载*/
    $("img.lazy").lazyload({effect: "fadeIn"});
</script>
</body>
</html>