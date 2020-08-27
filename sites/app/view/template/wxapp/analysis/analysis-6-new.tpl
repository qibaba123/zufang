<!--新版样式开始-->
<style>
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box;display: flex; align-items: center; }
    .flex-wrap1 { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box;display: flex; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .flex-vertical { -webkit-box-orient: vertical; -webkit-flex-direction: column; -ms-flex-direction: column; -webkit-flex-flow: column; -flex-direction: column; flex-flow: column; }
    .page-content{padding:15px 25px 15px;background-color:#f9f9f9;}
    .col-lg-8,.col-lg-4,.col-md-12,.col-sm-12,.col-xs-12{padding-left:15px;}
    .margin-bottom{
        margin-bottom:15px;
    }
    .common-content{
        background-color:#fff;
        box-shadow: 0px 3px 13px 2px rgba(185, 185, 185, 0.2);
        box-sizing: border-box;
        padding:20px;
    }
    .common-title{
        color:#333;
        font-size:18px;
        letter-spacing: 1px;
        padding-bottom:25px;
    }
    .tab-wrap{
        border-bottom:1px solid #eee;
    }
    .common-tab .tab-item{
        display:inline-block;
        font-size:15px;
        height:30px;
        color:#999;
        margin-right:20px;
        position:relative;
        cursor: pointer;
        letter-spacing: 1px;
    }
    .common-tab .tab-item.active{
        color:#0083fb;
    }
    .common-tab .tab-item.active:after{
        content:'';
        width:100%;
        height:3px;
        background-color:#0786FA;
        position:absolute;
        bottom:0;
        left:0;
    }
    .sell-status,.good-status{
        height:420px;
    }
    #sell-chart{margin:10px auto 0;}
    #good-chart{width:100%;margin:0 auto;}
    .sell-status .sell-money{
        margin-bottom:25px;
    }
    .sell-status .sell-money .num-wrap{
        margin-left:30px;
        color:#333;
        font-size:16px;
    }
    .sell-status .sell-money .num-wrap .num{
        color:#118bfb;
        font-size:26px;
        letter-spacing: -1px;
        padding-left:15px;
        vertical-align: middle;
    }
    .sell-status .choose-time{
        padding-bottom:10px;
    }
    .sell-status .choose-time span{
        color:#999;
        padding-left:10px;
        font-size:15px;
        cursor: pointer;
    }
    .sell-status .choose-time span.active{
        color:#0083fb;
    }
    /*.sell-status-chart div{width:100%!important;}*/
    .good-status .good-chart{height:160px;}
    .good-status .chart-tips{
        width:60%;
        margin:0 auto;
    }
    .good-status .chart-tips .tip-item{
        margin-top:30px;
        color:#333;
        font-size:16px;
        letter-spacing: 1px;
    }
    .good-status .chart-tips .tip-item span{
        display: inline-block;
        width:24px;
        height:13px;
        border-radius:1px;
        margin-right:20px;
        vertical-align: middle;
    }
    .good-status .chart-tips .tip-item span.selling{
        background-color:#1285EF;
    }
    .good-status .chart-tips .tip-item span.over{
        background-color:#F46167;
    }
    .good-status .chart-tips .tip-item span.down{
        background-color:#F4C652;
    }
    .good-status .chart-tips .tip-item .num{
        color:#333;
        letter-spacing: 0;
    }
    .growth-rate,.coupon-points{
        height:430px;
    }
    .growth-rate .status-tips{
        padding-bottom:10px;
    }
    .growth-rate .status-tips .tip{
        margin-left:20px;
        font-size:14px;
        color:#333;
        letter-spacing: 1px;
    }
    .growth-rate .status-tips .tip .color-lump{
        display: inline-block;
        width:24px;
        height:13px;
        vertical-align: middle;
        border-radius:1px;
        margin-right:10px;
    }
    .growth-rate .status-tips .tip .color-lump.color-blue{
        background-color:#1285EF;
    }
    .growth-rate .status-tips .tip .color-lump.color-green{
        background-color:#80E3BE;
    }
    .growth-rate .rate-chart{
        height:330px;
        margin:24px auto;
    }
    .growth-rate .total-num,.order-user .total-num{
        width:90%;
        margin:0 auto;
        display: table;
        border:1px solid #f1f1f1;
        box-sizing:border-box;
        padding:10px 0;
    }
    .growth-rate .total-num .num-wrap,.order-user .total-num .num-wrap{
        display: table-cell;
        text-align: center;
        color:#666;
        font-size:14px;
        letter-spacing: 1px;
    }
    .growth-rate .total-num .num-wrap .num,.order-user .total-num .num-wrap .num{
        color:#333;
        font-size:17px;
        letter-spacing: 0;
        margin-left:10px;
    }
    .coupon-points .coupon-wrap{
        margin-bottom:16px;
    }
    .coupon-points .coupon-wrap,.coupon-points .points-wrap{
        height:207px;
    }
    .coupon-points .coupon-desc{
        margin:15px 0 30px;
    }
    .coupon-points .coupon-desc .desc{
        font-size:16px;
        letter-spacing: 1px;
        color:#999;
    }
    .coupon-points .coupon-desc .num-wrap{
        font-size:18px;
        color:#333;
    }
    .coupon-points .coupon-desc .num-wrap span.used-blue{
        color:#1285ef;
    }
    .coupon-points .coupon-desc .num-wrap span.used-green{
        color:#45e3ab;
    }
    .coupon-points .precent-wrap{
        height:15px;
        border-radius:8px!important;
        background-color:#ecf6ff;
        position:relative;
    }
    .coupon-points .precent-wrap.points-precent{
        background-color:#E8F4F0;
    }
    .coupon-points .precent-wrap .precent-bg{
        height:15px;
        border-radius:8px!important;
        background-color:#1285EF;
        position:absolute;
        left:0;
        bottom:0;
        text-align: right;
        color:#fff;
        line-height:15px;
        letter-spacing: 0;
        font-size:12px;
    }
    .coupon-points .precent-wrap.points-precent .precent-bg{
        background-color:#45E3AB;
    }
    .community-rank,.order-user{
        height:500px;
    }
    .community-rank .status-tips{
        padding-bottom:10px;
    }
    .community-rank .status-tips .tip{
        color:#999;
        font-size:15px;
        margin-left:15px;
        cursor: pointer;
    }
    .community-rank .status-tips .tip.active{
        color:#0083fb;
    }
    .community-rank .look-community a{
        display: block;
        color:#0083fb;
        font-size:15px;
        padding:20px 0;
    }
    .community-rank .community-tab{
        color:#bcbcbc;
        font-size:14px;
        margin-right:2%;
        margin-top: 15px;
    }
    .community-rank .num-width{width:50px;}
    .community-rank .community-width{width:40%;}
    .community-rank .community-list{
        height:340px;
        overflow-y: auto;
        margin-top:10px;
    }
    .community-rank .community-list .community-item{
        padding:16px 0;
        box-sizing:border-box;
        border-bottom:1px solid #f5f5f5;
        font-size:17px;
        color:#333;
    }
    .community-rank .community-list .community-item:last-child{
        border-bottom:0;
    }
    .community-rank .community-list .num img{
        display: block;
        width:26px;
    }
    .community-rank .community-list .num span{
        display: block;
        width:30px;
        min-width:30px;
        height:30px;
        line-height:30px;
        color:#118BFB;
        font-size:12px;
        text-align: center;
        background-color:#E1EFFF;
        border-radius:50%!important;
    }
    .community-rank .community-list .avatar{
        display:block;
        width:50px;
        height:50px;
        border-radius:50%!important;
        margin-right:10px;
    }
    .community-rank .community-list .infor{
        padding:0 20px;
        box-sizing:border-box;
    }
    .community-rank .community-list .name{
        font-size:15px;
        letter-spacing: 1px;
    }
    .community-rank .community-list .tz{
        color:#999;
        font-size:13px;
        margin-top:6px;
    }
    .community-rank .community-list .con{
        /*padding:0 15px;*/
        box-sizing:border-box;
        text-align:center;
    }
    .community-rank .community-list .con a{
        color:#118BFB;
        font-size:15px;
    }
    .order-user .order-chart{
        height:330px;
        margin:24px auto;
    }
    @media (max-width: 1200px){
        .good-status-wrap,.coupon-points-wrap,.order-user-wrap{
            padding-left:0;
            margin-top:12px;
        }
    }
    .rate-change{
        color:#333;
        font-size:14px;
        text-align: center;
        padding-left:2%;
        margin:5px auto 16px;
        box-sizing:border-box;
        /*margin-bottom:20px;*/
    }
    .rate-change img{
        display: inline-block;
        width:14px;
        height:14px;
        vertical-align: middle;
        margin-right:5px;
    }
    .rate-change span{
        vertical-align: middle;
    }
</style>
<!--新版样式结束-->
<!--新版布局开始-->
<div class="row margin-bottom">
    <!--销售情况开始-->
    <div class="sell-status-wrap col-lg-8 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
        <div class="sell-status common-content">
            <div class="title-wrap flex-wrap">
                <div class="common-title flex-con">收益情况</div>
                <div class="sell-money">
                    <span class="num-wrap">今日商家收益<span class="num" id="sellMoney"><{$todayEnterProfit}></span></span>
                    <span class="num-wrap">今日平台销售额<span class="num" id="goodsNum"><{$todaySaleMoneyTotal}></span></span>
                    <span class="num-wrap">今日收银台收益<span class="num" id="cashMoney"><{$todayCashMoney}></span></span>
                </div>
            </div>
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item enter-money-tab active" data-type="enter">入驻商家收益</span>
                    <span class="tab-item enter-money-tab" data-type="money">平台销售金额</span>
                    <span class="tab-item enter-money-tab" data-type="cashier">收银台收益金额</span>
                </div>
                <div class="choose-time">
                    <span class="day-type-tab active" data-type="today">今天</span>
                    <span class="day-type-tab" data-type="yesterday">昨天</span>
                    <span class="day-type-tab" data-type="week">近一周</span>
                    <span class="day-type-tab" data-type="month">本月</span>
                </div>
            </div>
            <div class="sell-status-chart" id="sell-chart" style="height:280px;">

            </div>
        </div>
    </div>
    <!--销售情况结束-->
    <!--商品情况开始-->
    <div class="good-status-wrap col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-right:0;">
        <div class="good-status common-content">
            <div class="title-wrap flex-wrap">
                <div class="common-title flex-con">商品情况</div>
            </div>
            <div class="good-chart" id="good-chart">

            </div>
            <div class="chart-tips">
                <div class="tip-item flex-wrap">
                    <div class="desc-wrap flex-con"><span class="selling"></span>在售商品数</div>
                    <div class="num"><{$saleingGoodsTotal}>件</div>
                </div>
                <div class="tip-item flex-wrap">
                    <div class="desc-wrap flex-con"><span class="over"></span>售罄商品数</div>
                    <div class="num"><{$soldoutGoodsTotal}>件</div>
                </div>
                <div class="tip-item flex-wrap">
                    <div class="desc-wrap flex-con"><span class="down"></span>下架商品数</div>
                    <div class="num"><{$nosaleGoodsTotal}>件</div>
                </div>
            </div>
        </div>
    </div>
    <!--商品情况结束-->
</div>
<div class="row margin-bottom">
    <!--小区排行榜开始-->
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
        <div class="community-rank common-content" style="height: 430px">
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item" data-type="month" style="color: #333;font-weight: bold;">商家收益排行</span>
                </div>
                <div class="status-tips">
                    <span class="tip community-sale-change active" data-type="nums">商品销售数排行榜</span>
                    <span class="tip community-sale-change" data-type="money">商品销售额排行榜</span>
                </div>
            </div>
            <div class="community-wrap">
                <div class="community-tab flex-wrap">
                    <div class="tab-item num-width" style="margin-left:10px;box-sizing:border-box;">#</div>
                    <div class="tab-item community-width">商家信息</div>
                    <div class="tab-item flex-con" style="text-align: center;">商品销售数</div>
                    <div class="tab-item flex-con" style="text-align: center;">商品销售额</div>
                    <div class="tab-item flex-con" style="text-align: center;">商家让利</div>
                    <div class="tab-item flex-con" style="text-align: center;">商家详情</div>
                </div>

                <div class="community-list">
                    <{foreach $allSaleGoodsRank as $key => $val}>
                    <div class="community-item flex-wrap">
                        <div class="num num-width">
                            <{if $key +1 < 4}>
                        <img src="/public/wxapp/analysis/image/icon_ph<{$key +1 }>.png" alt="图标" />
                            <{else}>
                            <span><{$key +1 }></span>
                            <{/if}>
                        </div>
                        <div class="community-infor community-width flex-wrap">
                            <img src="<{$val['acs_img']}>" class="avatar" alt="头像" />
                            <div class="infor flex-con">
                                <div class="name"><{$val['acs_name']}></div>
                            </div>
                        </div>
                        <div class="con flex-con"><{$val['nums']}></div>
                        <div class="con flex-con"><{$val['total']}></div>
                        <div class="con flex-con"><{$val['profit']}></div>
                        <div class="con flex-con"><a href="/wxapp/city/addAreaShop?id=<{$val['acs_id']}>">查看</a></div>
                    </div>
                    <{/foreach}>
                </div>
                <div class="community-list" style="display: none">
                    <{foreach $allSaleMoneyRank as $key => $val}>
                    <div class="community-item flex-wrap">
                        <div class="num num-width">
                            <{if $key +1 < 4}>
                        <img src="/public/wxapp/analysis/image/icon_ph<{$key +1 }>.png" alt="图标" />
                            <{else}>
                            <span><{$key +1 }></span>
                            <{/if}>
                        </div>
                        <div class="community-infor community-width flex-wrap">
                            <img src="<{$val['acs_img']}>" class="avatar" alt="头像" />
                            <div class="infor flex-con">
                                <div class="name"><{$val['acs_name']}></div>
                            </div>
                        </div>
                        <div class="con flex-con"><{$val['nums']}></div>
                        <div class="con flex-con"><{$val['total']}></div>
                        <div class="con flex-con"><{$val['profit']}></div>
                        <div class="con flex-con"><a href="/wxapp/city/addAreaShop?id=<{$val['acs_id']}>">查看</a></div>
                    </div>
                    <{/foreach}>
                </div>
            </div>
        </div>
    </div>
    <!--小区排行榜结束-->
    <!--优惠券-积分情况开始-->
    <div class="coupon-points-wrap col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-right:0;">
        <div class="coupon-points">
            <div class="coupon-wrap common-content">
                <div class="title-wrap flex-wrap">
                    <div class="common-title flex-con">优惠券情况</div>
                </div>
                <div class="coupon-desc flex-wrap">
                    <div class="desc flex-con">已使用优惠券/总发放优惠券</div>
                    <div class="num-wrap"><span class="used-blue"><{$usedCouponTotal}></span>/<{$couponTotal}></div>
                </div>
                <div class="precent-wrap">
                    <div class="precent-bg" style="width:<{$couponPercent}>%;"><span><{$couponPercent}>%</span></div>
                </div>
            </div>
            <div class="points-wrap common-content">
                <div class="title-wrap flex-wrap">
                    <div class="common-title flex-con">积分情况</div>
                </div>
                <div class="coupon-desc flex-wrap">
                    <div class="desc flex-con">已使用积分数/总发放积分数</div>
                    <div class="num-wrap"><span class="used-green"><{$outPointTotal}></span>/<{$inPointTotal}></div>
                </div>
                <div class="precent-wrap points-precent">
                    <div class="precent-bg" style="width:<{$pointPercent}>%;"><span><{$pointPercent}>%</span></div>
                </div>
            </div>
        </div>
    </div>
    <!--优惠券-积分情况结束-->
</div>
<div class="row margin-bottom">
    <!--增长率情况开始-->
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
        <div class="growth-rate common-content" style="height: 500px">
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item today-tab active">今日</span>
                    <span class="tab-item yesterday-tab">昨日</span>
                    <span class="tab-item month-tab">本月</span>
                    <span class="tab-item lastmonth-tab">上月</span>
                </div>
            </div>
            <div class="rate-chart" id="rate-chart"></div>
            <div class="total-num">
                <div class="num-wrap">总用户数<span class="num"><{$totalMember}></span></div>
                <div class="num-wrap">总订单数<span class="num"><{$orderTotal}></span></div>
                <div class="num-wrap">总分销会员数<span class="num"><{$totalDistribMember}></span></div>
                <div class="num-wrap">总退款订单<span class="num"><{$refundTotal}></span></div>
                <div class="num-wrap">发帖总数<span class="num"><{$allPostTotal}></span></div>
                <div class="num-wrap">入驻商家<span class="num"><{$allEnterTotal}></span></div>
            </div>
        </div>
    </div>
    <!--增长率情况结束-->
    <!--近15日订单量-新增用户数开始-->
    <div class="order-user-wrap col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-right:0;">
        <div class="order-user common-content">
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item active fifteen-post-change">近15日发帖量</span>
                    <span class="tab-item fifteen-enter-change">近15日商家入驻量</span>
                    <span class="tab-item fifteen-member-change">近15日新增用户数</span>
                </div>
            </div>
            <div class="order-chart" id="order-chart"></div>
            <div class="total-num">
                <div class="num-wrap">新增发帖量<span class="num"><{$fifteenPostTotal}></span></div>
                <div class="num-wrap">新增入驻量<span class="num"><{$fifteenEnterTotal}></span></div>
                <div class="num-wrap">新增用户数<span class="num"><{$fifteenMemberTotal}></span></div>
            </div>
        </div>
    </div>
    <!--近15日订单量-新增用户数结束-->
</div>

<div class="row">
    <!--销售情况开始-->
    <div class="sell-status-wrap col-lg-8 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
        <div class="sell-status common-content" style="height: 500px;" >
            <div class="title-wrap flex-wrap">
                <div class="common-title flex-con">销售情况</div>
                <div class="sell-money">
                    <span class="num-wrap">今日售出商品<span class="num" id="sellMoney"><{$todaySaleMoneyTotal}></span></span>
                    <span class="num-wrap">今日发帖收益额<span class="num" id="goodsNum"><{$todaySaleGoodsTotal}></span></span>
                </div>
            </div>
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item goods-post-tab active" data-type="goods">售出商品数</span>
                    <span class="tab-item goods-post-tab" data-type="post">发帖收益</span>
                </div>
                <div class="choose-time">
                    <span class="chart6-day-type-tab active" data-type="today">今天</span>
                    <span class="chart6-day-type-tab" data-type="yesterday">昨天</span>
                    <span class="chart6-day-type-tab" data-type="week">近一周</span>
                    <span class="chart6-day-type-tab" data-type="month">本月</span>
                </div>
            </div>
            <div class="sell-status" id="goods-post-profit-chart" style="height:380px;">

            </div>
        </div>
    </div>
    <!--销售情况结束-->
    <!--近15日订单量-新增用户数开始-->
    <div class="order-user-wrap col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-right:0;">
        <div class="order-user common-content">
            <div class="tab-wrap flex-wrap">
                <div class="common-tab flex-con">
                    <span class="tab-item active fifteen-order-change">近15日订单量</span>
                    <span class="tab-item fifteen-goods-change">近15日售出商品数</span>
                    <span class="tab-item fifteen-money-change">近15日商品额</span>
                </div>
            </div>
            <div class="order-chart" id="chart-5"></div>
            <div class="total-num">
                <div class="num-wrap">新增订单数<span class="num"><{$fifteenOrderTotal}></span></div>
                <div class="num-wrap">售出商品数<span class="num"><{$fifteenSaleGoodsTotal}></span></div>
                <div class="num-wrap">商品销售额<span class="num"><{$fifteenSaleMoneyTotal}></span></div>
            </div>
        </div>
    </div>
</div>
<!--新版布局结束-->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/wxapp/analysis/js/jquery.animateNumber.min.js"></script>
<script type="text/javascript" src="
https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script>
    //点击事件
    $(function(){
        //销售情况点击事件
        $('.sell-status .common-tab .tab-item').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });
        $('.sell-status .choose-time span').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });
        //用户增长率点击事件
        $('.growth-rate .common-tab .tab-item').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });
        //小区排行榜点击事件
        $('.community-rank .common-tab .tab-item').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });
        $('.community-rank .status-tips .tip').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });
        //订单点击事件
        $('.order-user .common-tab .tab-item').click(function(){
            if($(this).hasClass('active')){return};
            $(this).addClass('active').siblings().removeClass('active');
        });

        $('.today-tab').click(function () {
            $('.day-month-tips .change-item').eq(0).children('span').text("<{$dayAddMemberPercent}>%");
            $('.day-month-tips .change-item').eq(1).children('span').text("<{$dayOrderPercent}>%");
            $('.day-month-tips .change-item').eq(2).children('span').text("<{$dayCommunityPercent}>%");
            $('.day-month-tips .change-item').eq(3).children('span').text("<{$dayRefundPercent}>%");
            chart3([<{$todayNewMember}>, <{$todayOrderTotal}>, <{$todayDistribMember}>, <{$todayRefundTotal}>, <{$todayPostTotal}>, <{$todayEnterTotal}>]);
        });

        $('.yesterday-tab').click(function () {
            $('.day-month-tips .change-item').eq(0).children('span').text("<{$dayAddMemberPercent}>%");
            $('.day-month-tips .change-item').eq(1).children('span').text("<{$dayOrderPercent}>%");
            $('.day-month-tips .change-item').eq(2).children('span').text("<{$dayCommunityPercent}>%");
            $('.day-month-tips .change-item').eq(3).children('span').text("<{$dayRefundPercent}>%");
            chart3([<{$yesterdayNewMember}>, <{$yesterdayOrderTotal}>, <{$yesterdayDistribMember}>, <{$yesterdayRefundTotal}>, <{$yesterdayPostTotal}>, <{$yesterdayEnterTotal}>]);
        });

        $('.month-tab').click(function () {
            $('.day-month-tips .change-item').eq(0).children('span').text("<{$monthAddMemberPercent}>%");
            $('.day-month-tips .change-item').eq(1).children('span').text("<{$monthOrderPercent}>%");
            $('.day-month-tips .change-item').eq(2).children('span').text("<{$monthCommunityPercent}>%");
            $('.day-month-tips .change-item').eq(3).children('span').text("<{$monthRefundPercent}>%");
            chart3([<{$thisMonthMember}>, <{$thisMonthOrderTotal}>, <{$thisMonthDistribMember}>, <{$thisMonthRefundTotal}>, <{$thisMonthPostTotal}>, <{$thisMonthEnterTotal}>]);
        });

        $('.lastmonth-tab').click(function () {
            $('.day-month-tips .change-item').eq(0).children('span').text("<{$monthAddMemberPercent}>%");
            $('.day-month-tips .change-item').eq(1).children('span').text("<{$monthOrderPercent}>%");
            $('.day-month-tips .change-item').eq(2).children('span').text("<{$monthCommunityPercent}>%");
            $('.day-month-tips .change-item').eq(3).children('span').text("<{$monthRefundPercent}>%");
            chart3([<{$lastMonthMember}>, <{$lastMonthOrderTotal}>, <{$lastMonthDistribMember}>, <{$lastMonthRefundTotal}>, <{$lastMonthPostTotal}>, <{$lastMonthEnterTotal}>]);
        });

        $(".fifteen-post-change").click(function () {
            chart4(<{$daysArr}>,<{$fifteenPostStatistic}>);
        });

        $(".fifteen-enter-change").click(function () {
            chart4(<{$daysArr}>,<{$fifteenEnterStatistic}>);
        });

        $(".fifteen-member-change").click(function () {
            chart4(<{$daysArr}>,<{$fifteenMemberStatistic}>);
        });

        $(".fifteen-order-change").click(function () {
            chart5(<{$daysArr}>,<{$fifteenOrderStatistic}>);
        });

        $(".fifteen-goods-change").click(function () {
            chart5(<{$daysArr}>,<{$fifteenSaleGoodsStatistic}>);
        });

        $(".fifteen-money-change").click(function () {
            chart5(<{$daysArr}>,<{$fifteenSaleMoneyStatistic}>);
        });

        $(".enter-money-tab").click(function () {
            let type = $(this).data('type');
            let atype = $('.data-type-tab.active').data('type');
            getTimeGroupEnterSaleStatistic(type, atype);
        });

        $(".day-type-tab").click(function () {
            let type = $(this).data('type');
            let atype = $('.enter-money-tab.active').data('type');
            getTimeGroupEnterSaleStatistic(atype, type);
        });


        $(".goods-post-tab").click(function () {
            let type = $(this).data('type');
            let atype = $('.chart6-day-type-tab.active').data('type');
            getTimeGroupGoodsPostProfitStatistic(type, atype);
        });

        $(".chart6-day-type-tab").click(function () {
            let type = $(this).data('type');
            let atype = $('.goods-post-tab.active').data('type');
            getTimeGroupGoodsPostProfitStatistic(atype, type);
        });

        $(".community-time-change").click(function () {
            let type = $(this).data('type');
            let atype = $('.community-sale-change.active').data('type');
            if(type == 'month' && atype == 'nums'){
                $(".community-list").eq(0).show().siblings('.community-list').hide()
            }
            if(type == 'all' && atype == 'nums'){
                $(".community-list").eq(1).show().siblings('.community-list').hide()
            }
            if(type == 'month' && atype == 'money'){
                $(".community-list").eq(2).show().siblings('.community-list').hide()
            }
            if(type == 'all' && atype == 'money'){
                $(".community-list").eq(3).show().siblings('.community-list').hide()
            }
        });

        $(".community-sale-change").click(function () {
            let type = $(this).data('type');
            if(type == 'nums'){
                $(".community-list").eq(0).show().siblings('.community-list').hide()
            }
            if(type == 'money'){
                $(".community-list").eq(1).show().siblings('.community-list').hide()
            }
            if(type == 'profit'){
                $(".community-list").eq(2).show().siblings('.community-list').hide()
            }
        });

        //  初始化设置图表的宽
        $('#sell-chart').width($('.sell-status').width());
        $('#good-chart').width($('.good-status').width());
        $('#rate-chart').width($('.growth-rate').width());
        $('.rate-change').innerWidth($('.growth-rate').width());
        $('#order-chart').width($('.order-user').width());

        //加载图表
        getTimeGroupEnterSaleStatistic('enter', 'today');
        chart2();
        chart3([<{$todayNewMember}>, <{$todayOrderTotal}>, <{$todayDistribMember}>, <{$todayRefundTotal}>, <{$todayPostTotal}>, <{$todayEnterTotal}>]);
        chart4(<{$daysArr}>,<{$fifteenPostStatistic}>);
        chart5(<{$daysArr}>,<{$fifteenOrderStatistic}>);
        //加载图表
        getTimeGroupGoodsPostProfitStatistic('goods', 'today');

        //	    数字滚动效果
        setTimeout(function(){
            var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
            $('#sellMoney').animateNumber(
                {
                    number: <{$todaySaleMoneyTotal}>,
                numberStep: comma_separator_number_step
        },
            3000
        );
            $('#goodsNum').animateNumber(
                {
                    number: <{$todaySaleGoodsTotal}>,
                numberStep: comma_separator_number_step
        },
            3000
        );
        },200);
    });

    function getTimeGroupEnterSaleStatistic(type, time) {
        var load_index = layer.load(
            2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'data' : {type, time},
            'url'   : '/wxapp/statisticanalysis/cityTimeGourpEnterSaleProfitStatistic',
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                let x = ret['data']['dayTime'];
                let data = [];
                if(type == 'enter'){
                    data = ret['data']['profitStatistic'];
                }
                if(type == 'money'){
                    data = ret['data']['saleMoneyStatistic'];
                }
                if(type == 'cashier'){
                    data = ret['data']['cashierStatistic'];
                }
                chart(x,data);
            }
        });
    }

    function getTimeGroupGoodsPostProfitStatistic(type, time) {
        var load_index = layer.load(
            2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'data' : {type, time},
            'url'   : '/wxapp/statisticanalysis/cityTimeGourpGoodsPostProfitStatistic',
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                let x = ret['data']['dayTime'];
                let data = [];
                if(type == 'goods'){
                    data = ret['data']['saleGoodsStatistic'];
                }
                if(type == 'post'){
                    data = ret['data']['profitStatistic'];
                }
                chart6(x,data);
            }
        });
    }

    function chart(x,data){
        // 基于准备好的dom，初始化echarts实例
        var sellChart = echarts.init(document.getElementById('sell-chart'));
        var option1 = {
            textStyle:'#ffffff',
            legent:{
                textStyle:'#ffffff'
            },
            grid:{
                containLabel:true,
                left:'0',
                right:'0',
                bottom:'10%',
                top:'5%'
            },
            tooltip: {
                trigger: 'axis',
                backgroundColor:'rgba(0,0,0,0.2)',
                confine:true, //将 tooltip 框限制在图表的区域内。
                textStyle: {
                    color:'#fff'
                },
                axisPointer:{
                    lineStyle:{
                        color:'#A9D6FF'
                    },
                    label:{
                        width:'20%',
                        backgroundColor:'' //文本标签的背景颜色，默认是和 axis.axisLine.lineStyle.color 相同。
                    }
                },
            },
            xAxis: {
                type: 'category',
                data: x,
                axisLine:{
                    show:false
                },
                axisTick:{
                    show:false
                },
                axisLabel: {
                    show: true,
                    interval:0,
                    textStyle: {
                        color: '#666',
                        fontSize:'14'
                    }
                },
                splitLine:{
                    show:false
                }
            },
            yAxis: {
                show:true,
                type: 'value',
                axisLine:{
                    show: false
                },
                axisTick:{
                    show: false
                },
                axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#666',
                        fontSize:'16'
                    }
                },
                splitLine:{
                    show:true,
                    lineStyle:{
                        color:'#f3f3f3'
                    }
                }
            },
            series: [{
                data: data,
//		        name:'收入',
                type: 'line',
                itemStyle: {
                    normal: {
                        color: "#118bfb",
                        lineStyle: {
                            color: "rgba(7,134,250,0.5)"
                        }
                    }
                },
                areaStyle:{
                    color:"rgba(7,134,250,0.2)"
                },
                smooth:false
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        sellChart.setOption(option1);
        window.addEventListener('resize', function () {
            $('#sell-chart').width($('.sell-status').width());
            sellChart.resize();
        });
    }
    function chart2(){
        // 基于准备好的dom，初始化echarts实例
        var goodChart = echarts.init(document.getElementById('good-chart'));
        var option2 = {
            tooltip: {
                trigger: 'item',
                backgroundColor:'rgba(0,0,0,0.5)',
                formatter: "{a} <br/>{b}: {c}"
            },
            title:{
                text:'共<{$goodsTotal}>件',
                textAlign:'center',
                top:'center',
                left:'49%',
                textStyle:{
                    color:'#108cee',
                    fontFamily:'Microsoft YaHei',
                    fontWeight:'200',
                    fontSize:'16'
                }
            },
            color:['#1285EF','#F46167','#F4C652'],
            series: [
                {
                    name:'商品情况',
                    type:'pie',
                    radius: ['55%', '85%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: false,
                            textStyle: {
                                fontSize: '12',
                                fontWeight: '400'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:<{$saleingGoodsTotal}>, name:'在售商品数'},
                        {value:<{$soldoutGoodsTotal}>, name:'售罄商品数'},
                        {value:<{$nosaleGoodsTotal}>, name:'下架商品数'}
                    ]
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        goodChart.setOption(option2);
        window.addEventListener('resize', function () {
            $('#good-chart').width($('.good-status').width());
            goodChart.resize();
        })
    }
    function chart3(thisData){
        // 基于准备好的dom，初始化echarts实例
        var rateChart = echarts.init(document.getElementById('rate-chart'));
        var labelOption = {
            normal: {
                show: true,
                position: 'top',
                distance: 10,
                align: 'center',
                verticalAlign:'middle',
                rotate: 0,
                formatter: '{c}',
                fontSize: 16,
                fontWeight: 'bolder',
                color: '#333'
            }
        };
        var option3 = {
            color: ['#1285EF'],
            tooltip: {
                trigger: 'axis',
                backgroundColor:'rgba(0,0,0,0.5)',
                axisPointer: {
                    type: 'none'
                }
            },
            grid:{
                containLabel:true,
                left:'0',
                right:'0',
                bottom:'10%',
                top:'5%'
            },
            xAxis:{
                type: 'category',
                data: ['用户增长数', '订单增长数', '分销会员增长数', '订单退款数', '论坛发帖数', '商家入驻数'],
                axisLine:{
                    show:false
                },
                axisTick:{
                    show:false
                },
                axisLabel: {
                    show: true,
                    interval:0,
                    rotate:0,
                    textStyle: {
                        color: '#333',
                        fontSize:'15'
                    }
                },
                splitLine:{
                    show:false
                }
            },
            yAxis: {
                show:true,
                type: 'value',
                axisLine:{
                    show: false
                },
                axisTick:{
                    show: false
                },
                axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#666',
                        fontSize:'16'
                    }
                },
                splitLine:{
                    show:true,
                    lineStyle:{
                        color:'#f3f3f3'
                    }
                }
            },
            series: [
                {
                    name: '今日',
                    type: 'bar',
                    barGap: 0,
                    barWidth:'30',
                    label: labelOption,
                    data: thisData,
                    barMinHeight: 5
                }
            ]
        };
        // 使用刚指定的配置项和数据显示图表。
        rateChart.setOption(option3);
        window.addEventListener('resize', function () {
            $('#rate-chart').width($('.growth-rate').width());
            $('.rate-change').innerWidth($('#rate-chart').width());
            rateChart.resize();
        })
    }
    function chart4(x4,data4){
        // 基于准备好的dom，初始化echarts实例
        var orderChart = echarts.init(document.getElementById('order-chart'));
        var option4 = {
            textStyle:'#ffffff',
            legent:{
                textStyle:'#ffffff'
            },
            grid:{
                containLabel:true,
                left:'0',
                right:'6%',
                bottom:'10%',
                top:'5%'
            },
            dataZoom: [
                {
                    type: 'inside',
                    zoomLock:true,
                    preventDefaultMouseMove:true,
                    throttle:'60',
                    maxValueSpan:5,
                    start: 0,
                    end: 35
                }
            ],
            tooltip: {
                trigger: 'axis',
                backgroundColor:'rgba(0,0,0,0.2)',
                confine:true, //将 tooltip 框限制在图表的区域内。
                textStyle: {
                    color:'#fff'
                },
                axisPointer:{
                    lineStyle:{
                        color:'#A9D6FF'
                    }
                },
            },
            xAxis: {
                type: 'category',
                data: x4,
                boundaryGap: false,
                axisLine:{
                    show:false
                },
                axisTick:{
                    show:false
                },
                axisLabel: {
                    show: true,
                    interval:0,
                    showMaxLabel:true,
                    rotate:0,
                    textStyle: {
                        color: '#666',
                        fontSize:'14'
                    }
                },
                splitLine:{
                    show:false,
                    lineStyle:{
                        color:'#eee'
                    }
                }
            },
            yAxis: {
                show:true,
                type: 'value',
                axisLine:{
                    show: false
                },
                axisTick:{
                    show: false
                },
                axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#666',
                        fontSize:'16'
                    }
                },
                splitLine:{
                    show:true,
                    lineStyle:{
                        color:'#f3f3f3'
                    }
                }
            },
            series: [{
                data: data4,
                type: 'line',
                itemStyle: {
                    normal: {
                        color: "#0FA2F9",
                        lineStyle: {
                            color: "rgba(7,134,250,0.5)"
                        }
                    }
                },
                areaStyle:{
                    color:"rgba(7,134,250,0.2)"
                },
                smooth:false
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        orderChart.setOption(option4);
        window.addEventListener('resize', function () {
            $('#order-chart').width($('.order-user').width());
            orderChart.resize();
        })
    }

    function chart5(x4,data4){
        // 基于准备好的dom，初始化echarts实例
        var orderChart = echarts.init(document.getElementById('chart-5'));
        var option4 = {
            textStyle:'#ffffff',
            legent:{
                textStyle:'#ffffff'
            },
            grid:{
                containLabel:true,
                left:'0',
                right:'6%',
                bottom:'10%',
                top:'5%'
            },
            dataZoom: [
                {
                    type: 'inside',
                    zoomLock:true,
                    preventDefaultMouseMove:true,
                    throttle:'60',
                    maxValueSpan:5,
                    start: 0,
                    end: 35
                }
            ],
            tooltip: {
                trigger: 'axis',
                backgroundColor:'rgba(0,0,0,0.2)',
                confine:true, //将 tooltip 框限制在图表的区域内。
                textStyle: {
                    color:'#fff'
                },
                axisPointer:{
                    lineStyle:{
                        color:'#A9D6FF'
                    }
                },
            },
            xAxis: {
                type: 'category',
                data: x4,
                boundaryGap: false,
                axisLine:{
                    show:false
                },
                axisTick:{
                    show:false
                },
                axisLabel: {
                    show: true,
                    interval:0,
                    showMaxLabel:true,
                    rotate:0,
                    textStyle: {
                        color: '#666',
                        fontSize:'14'
                    }
                },
                splitLine:{
                    show:false,
                    lineStyle:{
                        color:'#eee'
                    }
                }
            },
            yAxis: {
                show:true,
                type: 'value',
                axisLine:{
                    show: false
                },
                axisTick:{
                    show: false
                },
                axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#666',
                        fontSize:'16'
                    }
                },
                splitLine:{
                    show:true,
                    lineStyle:{
                        color:'#f3f3f3'
                    }
                }
            },
            series: [{
                data: data4,
                type: 'line',
                itemStyle: {
                    normal: {
                        color: "#0FA2F9",
                        lineStyle: {
                            color: "rgba(7,134,250,0.5)"
                        }
                    }
                },
                areaStyle:{
                    color:"rgba(7,134,250,0.2)"
                },
                smooth:false
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        orderChart.setOption(option4);
        window.addEventListener('resize', function () {
            $('#chart-5').width($('.order-user').width());
            orderChart.resize();
        })
    }

    function chart6(x,data){
        // 基于准备好的dom，初始化echarts实例
        var sellChart = echarts.init(document.getElementById('goods-post-profit-chart'));
        var option1 = {
            textStyle:'#ffffff',
            legent:{
                textStyle:'#ffffff'
            },
            grid:{
                containLabel:true,
                left:'0',
                right:'0',
                bottom:'10%',
                top:'5%'
            },
            tooltip: {
                trigger: 'axis',
                backgroundColor:'rgba(0,0,0,0.2)',
                confine:true, //将 tooltip 框限制在图表的区域内。
                textStyle: {
                    color:'#fff'
                },
                axisPointer:{
                    lineStyle:{
                        color:'#A9D6FF'
                    },
                    label:{
                        width:'20%',
                        backgroundColor:'' //文本标签的背景颜色，默认是和 axis.axisLine.lineStyle.color 相同。
                    }
                },
            },
            xAxis: {
                type: 'category',
                data: x,
                axisLine:{
                    show:false
                },
                axisTick:{
                    show:false
                },
                axisLabel: {
                    show: true,
                    interval:0,
                    textStyle: {
                        color: '#666',
                        fontSize:'14'
                    }
                },
                splitLine:{
                    show:false
                }
            },
            yAxis: {
                show:true,
                type: 'value',
                axisLine:{
                    show: false
                },
                axisTick:{
                    show: false
                },
                axisLabel: {
                    show: true,
                    textStyle: {
                        color: '#666',
                        fontSize:'16'
                    }
                },
                splitLine:{
                    show:true,
                    lineStyle:{
                        color:'#f3f3f3'
                    }
                }
            },
            series: [{
                data: data,
//		        name:'收入',
                type: 'line',
                itemStyle: {
                    normal: {
                        color: "#118bfb",
                        lineStyle: {
                            color: "rgba(7,134,250,0.5)"
                        }
                    }
                },
                areaStyle:{
                    color:"rgba(7,134,250,0.2)"
                },
                smooth:false
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        sellChart.setOption(option1);
        window.addEventListener('resize', function () {
            $('#goods-post-profit-chart').width($('.sell-status').width());
            sellChart.resize();
        });
    }
</script>

