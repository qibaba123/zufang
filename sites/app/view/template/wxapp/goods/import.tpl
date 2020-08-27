<link rel="stylesheet" href="/public/manage/css/service.css">
<style>
    .ui-step-2 li{
        width: 50%;
    }
    .tip-text{
        padding:20px;
        margin:20px auto;
        background-color:#f5f5f5;
    }
    .tip-text p{
        margin:0;
        line-height: 1.8;
        color:#333;
    }
</style>
<div class="app-inner clearfix">
    <div class="page-choose-service-info">
        <div class="step-region">
            <ul class="ui-step ui-step-2">
                <li class="ui-step-done">
                    <div class="ui-step-title">批量导入商品</div>
                    <div class="ui-step-number">1</div>
                </li>
                <li class="<{if $step == 2}>ui-step-done<{/if}>">
                    <div class="ui-step-title">完成</div>
                    <div class="ui-step-number">2</div>
                </li>
            </ul>
        </div>
    </div>
    <div class="tip-text" style="">
        <{foreach $desc as $item}>
        <p><{$item}></p>
        <{/foreach}>
    </div>
    <div class="text-center">
        <a class="zent-btn zent-btn-primary" onclick="openLoading(this)" href="<{$button['link']}>"><{$button['name']}></a>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function openLoading(obj) {
        layer.msg('加载中', {icon: 16, time : 600000});
    }
</script>