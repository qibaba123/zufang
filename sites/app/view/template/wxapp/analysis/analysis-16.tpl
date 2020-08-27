<link rel="stylesheet" href="/public/wxapp/analysis/css/index.css">
<link rel="stylesheet" href="/public/wxapp/analysis/css/main.css">

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual_metteyya visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="todayOrders counterup" data-counter="counterup" data-value="<{$todayApplyRentTotal}>"><{$todayApplyRentTotal}></span>
                </div>
                <div class="desc"> 今日新增求租数 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2  order-stat-bg" href="#">
            <div class="visual">
                <i class="fa fa-briefcase fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="yestodayOrders counterup" data-counter="counterup" data-value="<{$yesterdayApplyRentTotal}>"><{$yesterdayApplyRentTotal}></span>
                </div>
                <div class="desc"> 昨日新增求租数 </div>
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
                    <span class="thisMonthOrders  counterup" data-counter="counterup" data-value="<{$thisMonthApplyRentTotal}>"><{$thisMonthApplyRentTotal}></span>
                </div>
                <div class="desc"> 本月新增求租数 </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat dashboard-stat dashboard-stat-v2 purple" href="#">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="allOrders  counterup" data-counter="counterup" data-value="<{$allApplyRentTotal}>"><{$allApplyRentTotal}></span>
                </div>
                <div class="desc">总求租数 </div>
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
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<{$todayApplyBuyTotal}>"><{$todayApplyBuyTotal}></span>
                </div>
                <div class="desc"> 今日新增求购数</div>
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
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<{$yesterdayApplyBuyTotal}>"><{$yesterdayApplyBuyTotal}></span>
                </div>
                <div class="desc"> 昨日新增求购数 </div>
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
                    <span class="thisMonthTotals  counterup" data-value="<{$thisMonthApplyBuyTotal}>" data-counter="counterup"><{$thisMonthApplyBuyTotal}></span>
                </div>
                <div class="desc"> 本月新增求购数 </div>
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
                    <span data-value="<{$allApplyBuyTotal}>" data-counter="counterup" class="allTotals  counterup"><{$allApplyBuyTotal}></span></div>
                <div class="desc">总新增求购数 </div>
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
                    <span class="todayAllsales counterup" data-counter="counterup" data-value="<{$todayHouseRentTotal}>"><{$todayHouseRentTotal}></span>
                </div>
                <div class="desc"> 今日新增出租数 </div>
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
                    <span class="yestodayAllsales  counterup" data-counter="counterup" data-value="<{$yesterdayHouseRentTotal}>"><{$yesterdayHouseRentTotal}></span>
                </div>
                <div class="desc"> 昨日新增出租数</div>
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
                    <span class="thisMonthAllsales  counterup" data-counter="counterup" data-value="<{$thisMonthHouseRentTotal}>"><{$thisMonthHouseRentTotal}></span>
                </div>
                <div class="desc"> 本月新增出租数 </div>
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
                    <span class="thisAllsales  counterup" data-value="<{$allHouseRentTotal}>" data-counter="counterup"><{$allHouseRentTotal}></span>
                </div>
                <div class="desc"> 总出租数</div>
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
                    <span class="todayAllsales counterup" data-counter="counterup" data-value="<{$todayHouseBuyTotal}>"><{$todayHouseBuyTotal}></span>
                </div>
                <div class="desc"> 今日新增出售数 </div>
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
                    <span class="yestodayAllsales  counterup" data-counter="counterup" data-value="<{$yesterdayHouseBuyTotal}>"><{$yesterdayHouseBuyTotal}></span>
                </div>
                <div class="desc"> 昨日新增出售数</div>
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
                    <span class="thisMonthAllsales  counterup" data-counter="counterup" data-value="<{$thisMonthHouseBuyTotal}>"><{$thisMonthHouseBuyTotal}></span>
                </div>
                <div class="desc"> 本月新增出售数 </div>
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
                    <span class="thisAllsales  counterup" data-value="<{$allHouseBuyTotal}>" data-counter="counterup"><{$allHouseBuyTotal}></span>
                </div>
                <div class="desc"> 总出售数</div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12  col-xs-12  col-sm-12">
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
</div>
<div class="row">
    <!-- BEGIN : 近15日订单量   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日求租量</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="applyRentAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END :  近15日订单量   -->
    <!-- BEGIN :  近15日商品销售数   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日求购量</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="applyBuyAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END : 近15日商品销售数  -->
    <!-- BEGIN : 近15日销售额  -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日出租量</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="houseRentAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END : 近15日销售额  -->
    <!-- BEGIN : 近15日团长增长数  -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日出售量</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="houseBuyAnalysis" style="height: 400px"></div>
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
    let fifteenApplyBuyStatistic  = <{$fifteenApplyBuyStatistic}>;
    let fifteenApplyRentStatistic = <{$fifteenApplyRentStatistic}>;
    let fifteenHouseBuyStatistic  = <{$fifteenHouseBuyStatistic}>;
    let fifteenHouseRentStatistic = <{$fifteenHouseRentStatistic}>;

    drawAxisChart("applyRentAnalysis", fifteenApplyRentStatistic, daysArr, '求租量');
    drawAxisChart("applyBuyAnalysis", fifteenApplyBuyStatistic, daysArr, '求购量');
    drawAxisChart("houseRentAnalysis", fifteenHouseRentStatistic, daysArr, '出租量');
    drawAxisChart("houseBuyAnalysis", fifteenHouseBuyStatistic, daysArr, '出售量');
</script>

