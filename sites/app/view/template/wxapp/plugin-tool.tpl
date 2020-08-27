<link rel="stylesheet" href="/public/manage/css/mobilepage-common.css">
<link rel="stylesheet" href="/public/plugin/flexslider/flexslider.css">
<link rel="stylesheet" href="/public/manage/css/powder-news.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    th, td{
        text-align: center;
    }
</style>
<div class="wrap">
    <div class="js-app-board">
        <div class="widget-app-board ui-box">
            <div class="app-board-intro" style="position: relative;height: 40px;">
                <h3 class="title"><{$tool['name']}></h3>
                <p class="intro"><{$tool['brief']}></p>
                <{if $row}>
                <p class="expire" style="color: #FF0000;">到期时间：<{date('Y-m-d H:i:s', $row['apo_expire_time'])}></p>
                <{/if}>
                <p class="intro" style="color: #FF0000;font-size: 16px;font-weight: bold;right: 0;position: absolute;top: 0px">
                    <{if $row}>
                    已到期
                    <{else}>
                    未开通
                    <{/if}>
                </p>
                <{if $pluginId == 'mfyy'}>
                <p>
                    开通免费预约后，入驻商家可在后台配置免费预约相关内容并管理免费预约订单
                </p>
                <{/if}>
            </div>
        </div>
    </div>
</div>
<{if $pluginId == 'anubis'}>
<h2 style="text-align: center;margin-bottom: 20px;">配送费计算规则</h2>
<!--<div style="color: red;text-align: center;">
    <p>春节前7天：即2019年01月28日至2019年02月03日, 加价5元/单</p>
    <p>春节期间7天：即2019年02月04日至2019年02月10日, 加价10元/单</p>
    <p>春节后7天：即2019年02月11日至2019年02月17日, 加价5元/单</p>
</div>-->
<table class="table table-striped table-hover table-avatar">
    <thead>
        <tr>
            <th style="text-align: center">城市基础价(<{$company}>)</th>
        </tr>
    </thead>
    <tbody>
        <td><{$baseFee}>元</td>
    </tbody>
</table>
<table class="table table-striped table-hover table-avatar">
    <thead>
    <tr>
        <th colspan="2" style="text-align: center">距离加价</th>
    </tr>
    <tr>
        <th>配送距离</th>
        <th>加价规则（元/单）</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>[0-1)km</td>
            <td>0元</td>
        </tr>
        <tr>
            <td>[1-2)km</td>
            <td>1元</td>
        </tr>
        <tr>
            <td>[2-3)km</td>
            <td>2元</td>
        </tr>
        <tr>
            <td>[3-4)km</td>
            <td>4元</td>
        </tr>
        <tr>
            <td>[4-5)km</td>
            <td>6元</td>
        </tr>
        <tr>
            <td>[5-6)km</td>
            <td>8元</td>
        </tr>
    </tbody>
</table>
<table class="table table-striped table-hover table-avatar">
    <thead>
    <tr>
        <th colspan="2" style="text-align: center">重量加价</th>
    </tr>
    <tr>
        <th>重量</th>
        <th>加价规则（元/单）</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>[0-5]Kg</td>
            <td>0元</td>
        </tr>
        <tr>
            <td>(5-15]Kg</td>
            <td>每增加1KG加0.5元</td>
        </tr>
    </tbody>
</table>
<table class="table table-striped table-hover table-avatar">
    <thead>
    <tr>
        <th colspan="4" style="text-align: center">时段加价</th>
    </tr>
    <tr>
        <th>时段类型</th>
        <th>加价规则（元/单）</th>
        <th>时间段</th>
        <th>备注</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>午高峰</td>
            <td>￥2.00</td>
            <td>11:00-13:00</td>
            <td>
                以下单时间为准
            </td>
        </tr>
        <tr>
            <td>午夜加价</td>
            <td>￥2.00</td>
            <td>22:00-02:00</td>
            <td>
                以下单时间为准
            </td>
        </tr>
    </tbody>
</table>
<{/if}>
<{include file="./bs-alert-tips.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/flexslider/flexslider.min.js"></script>
<script type="text/javascript">
    var amount  = 0, num = 0;
    var balance = parseFloat("<{$shopRow['s_recharge']}>")*100;
    var tool_type   = "<{$tool['pt_key']}>";
    $(function(){
        $(".js-app-order").click(function(event) {
            event.preventDefault();
            if($(".js-select-click").hasClass('selected')){
                if(amount > 0){
                    var html = $("#layer-dinggou");
                    html.find('span.money').text(amount+"币");
                    html.find('span.total-money').text(amount+"币");
                    var btn = parseFloat(amount)*100 > balance ? '充值' : '支付';
                    html.find('a.zent-btn').text(btn);
                    //页面层
                    layer.open({
                        type: 1,
                        title: '应用服务订购',
                        offset: '100px',
                        // skin: 'layui-layer-rim',
                        area: ['600px'], //宽高
                        content: html
                    });
                }else{
                    toTry();
                }
            }else{
                layer.open({
                    type: 1,
                    title: false, //不显示标题
                    shade:0,
                    skin: 'layui-layer-error', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    shift: 5,
                    content: '请选择期限',
                    time: 3000
                });
            }
        });
        $(".js-select-click").click(function(event) {
            event.preventDefault();
            var that = $(this);
            var id = that.data('item');
            that.addClass('selected').siblings().removeClass('selected');
            var box = $(".original-price .sku-info-"+id);
            box.show().siblings().hide();
            amount  = box.find('span.normal-price').data('price');
            num     = box.find('span.normal-price').data('num');
            //amount  = parseFloat(amount)*100;
        });

        $("#marketingTool").hover(function() {
            var _this = $(this);
            _this.stop().animate({"width": "380px"}, 300,function(){
                _this.find(".tool-order").stop().show();
                _this.find(".opera-btnbox").stop().fadeIn();
            });

        }, function() {
            var _this = $(this);
            _this.find(".tool-order").stop().hide();
            _this.find(".opera-btnbox").stop().hide();
            _this.stop().animate({"width": "190px"}, 300);
        });

        // 广告轮播
        $(".flexslider").flexslider({
            animation:'slide',
            slideshowSpeed:3000,
        });
    });


</script>