<link rel="stylesheet" href="/public/wxapp/analysis/css/index.css">
<link rel="stylesheet" href="/public/wxapp/analysis/css/main.css">

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual_metteyya visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<{$todaySaleMoneyTotal}>"><{$todaySaleMoneyTotal}></span>
                </div>
                <div class="desc"> 今日订单金额</div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-sales" href="#">
            <div class="visual">
                <i class="fa fa-area-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<{$yesterdaySaleMoneyTotal}>"><{$yesterdaySaleMoneyTotal}></span>
                </div>
                <div class="desc"> 昨日订单金额 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-month-sales" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="thisMonthTotals  counterup" data-value="<{$thisMonthSaleMoneyTotal}>" data-counter="counterup"><{$thisMonthSaleMoneyTotal}></span>
                </div>
                <div class="desc"> 本月订单金额 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-total" href="#">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-value="<{$saleMoneyTotal}>" data-counter="counterup" class="allTotals  counterup"><{$saleMoneyTotal}></span></div>
                <div class="desc">总订单金额 </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-total" href="#">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-value="<{$todayCashMoney}>" data-counter="counterup" class="allTotals  counterup"><{$todayCashMoney}></span></div>
                <div class="desc">今日收银金额 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-total" href="#">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-value="<{$yesterdayCashMoney}>" data-counter="counterup" class="allTotals  counterup"><{$yesterdayCashMoney}></span></div>
                <div class="desc">昨日收银金额 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-total" href="#">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-value="<{$thisMonthCashMoney}>" data-counter="counterup" class="allTotals  counterup"><{$thisMonthCashMoney}></span></div>
                <div class="desc">本月收银金额 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-total" href="#">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-value="<{$totalCashMoney}>" data-counter="counterup" class="allTotals  counterup"><{$totalCashMoney}></span></div>
                <div class="desc">总收银金额 </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat dashboard-stat dashboard-stat-v2 red" href="#">
            <div class="visual_metteyya visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="todayAllsales counterup" data-counter="counterup" data-value="<{$saleingGoodsTotal}>"><{$saleingGoodsTotal}></span>
                </div>
                <div class="desc"> 在售房间数 </div>
            </div>
        </a>

    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-sales" href="#">
            <div class="visual">
                <i class="fa fa-area-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="yestodayAllsales  counterup" data-counter="counterup" data-value="<{$soldoutGoodsTotal}>"><{$soldoutGoodsTotal}></span>
                </div>
                <div class="desc"> 售罄房间数</div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat  dashboard-stat dashboard-stat-v2 green" href="#">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="thisMonthAllsales  counterup" data-counter="counterup" data-value="<{$nosaleGoodsTotal}>"><{$nosaleGoodsTotal}></span>
                </div>
                <div class="desc"> 下架房间数 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2   order-month-sales" href="#">
            <div class="visual">
                <i class="fa fa-line-chart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="thisAllsales  counterup" data-value="<{$goodsTotal}>" data-counter="counterup"><{$goodsTotal}></span>
                </div>
                <div class="desc"> 总房间数</div>
            </div>
        </a>
    </div>

</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span>已使用优惠券数/总发放优惠券数</span>
                    </h3>
                    <!--<small></small>-->
                </div>
                <div class="icon">
                    <i class="icon-pie-chart">
                        <span class="counterup font-green-sharp" data-counter="counterup" id="thisMonthSales"><{$usedCouponTotal}>/<{$couponTotal}></span>
                    </i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress1 progress">
                          <span style="width: <{$couponPercent}>%;" class="thisMonthPriceAllPC  progress-bar progress-bar-success green-sharp">
                                <span class="sr-only progress_percentum"><{$couponPercent}>% progress</span>
                          </span>
                </div>
                <div class="status">
                    <div class="status-number percentage_percentum"><{$couponPercent}>%</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-green">
                        <span>已使用积分数/总发放积分数</span>
                        <!--<small class="font-green-sharp">12346</small>-->
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-like">
                        <span class="counterup font-green-sharp thisMonthRegimentals" data-counter="counterup"><{$outPointTotal}>/<{$inPointTotal}></span>
                    </i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress1  progress">
                          <span style="width: <{$pointPercent}>%;" class="thnisMonthRegimentalPC  progress-bar progress-bar-success red-haze">
                                <span class="sr-only regimentalTotals-percentum"><{$pointPercent}>% progress</span>
                          </span>
                </div>
                <div class="status">
                    <div class="status-number regimentalTotals-progress"><{$pointPercent}>%</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-haze ">
                        <span>用户增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class=" font-green-sharp">共：</span>
                        <span class="counterup font-red thisMonthRegimentals2" data-counter="counterup" data-value="108"><{$totalMember}></span>
                        <span class=" font-green-sharp">用户</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-mint">今日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$todayNewMember}></span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-red-mint">昨日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$yesterdayNewMember}></span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayAddRegimentalPreCentum number team" data-percent="<{$dayAddMemberPercent}>" data-color="#ff2828" style="line-height: 144px;"><span><{$dayAddMemberPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">本月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$thisMonthMember}></span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-grey-salsa">上月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$lastMonthMember}></span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddRegimentalPreCentum number team" data-percent="<{$monthAddMemberPercent}>" data-color="#3598dc" style="line-height: 144px;"><span><{$monthAddMemberPercent}></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-mint">
                        <span>订单增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class="font-green-sharp">共：</span>
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<{$orderTotal}>"><{$orderTotal}></span>
                        <span class="font-green-sharp">订单</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">今日订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$todayOrderTotal}>" style="color:#A3D04B;"><{$todayOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$yesterdayOrderTotal}>" style="color:#A3D04B;"><{$yesterdayOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<{$dayOrderPercent}>" data-color="#abce33" style="line-height: 144px;"><span><{$dayOrderPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<{$thisMonthOrderTotal}>" style="color:#FE2F56;"><{$thisMonthOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-red-mint">上月订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<{$lastMonthOrderTotal}>" style="color:#FF2C30;"><{$lastMonthOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<{$monthOrderPercent}>" data-color="#f92d56" style="line-height: 144px;"><span><{$monthOrderPercent}></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-mint">
                        <span>房间售出增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class="font-green-sharp">共：</span>
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<{$goodsTotal}>"><{$goodsTotal}></span>
                        <span class="font-green-sharp">房间</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">今日使用</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$todaySaleGoodsTotal}>" style="color:#A3D04B;"><{$todaySaleGoodsTotal}></span>&nbsp;次
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日使用</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$yesterdaySaleGoodsTotal}>" style="color:#A3D04B;"><{$yesterdaySaleGoodsTotal}></span>&nbsp;次
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<{$dayOrderPercent}>" data-color="#abce33" style="line-height: 144px;"><span><{$daySaleGoodsPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月使用</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<{$thisMonthSaleGoodsTotal}>" style="color:#FE2F56;"><{$thisMonthSaleGoodsTotal}></span>&nbsp;次
                                </div>
                            </div>
                            <span class="font-red-mint">上月使用</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<{$lastMonthSaleGoodsTotal}>" style="color:#FF2C30;"><{$lastMonthSaleGoodsTotal}></span>&nbsp;次
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<{$monthSaleGoodsPercent}>" data-color="#f92d56" style="line-height: 144px;"><span><{$monthSaleGoodsPercent}></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-mint">
                        <span>订单退款率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class="font-green-sharp">共：</span>
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<{$refundTotal}>"><{$refundTotal}></span>
                        <span class="font-green-sharp">维权订单</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">今日退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$todayRefundTotal}>" style="color:#A3D04B;"><{$todayRefundTotal}></span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$yesterdayRefundTotal}>" style="color:#A3D04B;"><{$yesterdayRefundTotal}></span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<{$dayRefundPercent}>" data-color="#abce33" style="line-height: 144px;"><span><{$dayRefundPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<{$thisMonthRefundTotal}>" style="color:#FE2F56;"><{$thisMonthRefundTotal}></span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-red-mint">上月退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<{$lastMonthRefundTotal}>" style="color:#FF2C30;"><{$lastMonthRefundTotal}></span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<{$monthRefundPercent}>" data-color="#f92d56" style="line-height: 144px;"><span><{$monthRefundPercent}></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- BEGIN : 近15日订单量   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日订单量</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="orderAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END :  近15日订单量   -->
    <!-- BEGIN :  近15日商品销售数   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日售出房间数</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="saleAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END : 近15日商品销售数  -->
    <!-- BEGIN : 近15日销售额  -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日房间销售额</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="moneyAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END : 近15日销售额  -->
    <!-- BEGIN : 近15日团长增长数  -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日新增用户数</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="memberAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END 近15日团长增长数  -->
</div>
<script src="/public/wxapp/analysis/js/easypiechart/jquery.easypiechart.js"></script>
<script type="text/javascript" src="
https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript" src="/public/wxapp/analysis/js/draw.js"></script>
<script>
    let daysArr = <{$daysArr}>;
    let fifteenOrderStatistic = <{$fifteenOrderStatistic}>;
    let fifteenSaleGoodsStatistic = <{$fifteenSaleGoodsStatistic}>;
    let fifteenSaleMoneyStatistic = <{$fifteenSaleMoneyStatistic}>;
    let fifteenMemberStatistic = <{$fifteenMemberStatistic}>;
    drawAxisChart("orderAnalysis", fifteenOrderStatistic, daysArr, '订单量');
    drawAxisChart("saleAnalysis", fifteenSaleGoodsStatistic, daysArr, '售出商品数');
    drawAxisChart("moneyAnalysis", fifteenSaleMoneyStatistic, daysArr, '商品销售额');
    drawAxisChart("memberAnalysis", fifteenMemberStatistic, daysArr, '新增用户数');
</script>

