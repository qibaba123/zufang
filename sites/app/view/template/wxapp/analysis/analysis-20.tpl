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
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<{$todayWorkOrderTotal}>"><{$todayWorkOrderTotal}></span>
                </div>
                <div class="desc"> 今日新增工单数</div>
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
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<{$yesterdayWorkOrderTotal}>"><{$yesterdayWorkOrderTotal}></span>
                </div>
                <div class="desc"> 昨日新增工单数 </div>
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
                    <span class="thisMonthTotals  counterup" data-value="<{$thisMonthWorkOrderTotal}>" data-counter="counterup"><{$thisMonthWorkOrderTotal}></span>
                </div>
                <div class="desc"> 本月新增工单数 </div>
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
                    <span data-value="<{$allWorkOrdertotal}>" data-counter="counterup" class="allTotals  counterup"><{$allWorkOrdertotal}></span></div>
                <div class="desc">总工单数 </div>
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
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<{$todayNewMember}>"><{$todayNewMember}></span>
                </div>
                <div class="desc"> 今日新增用户数</div>
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
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<{$yesterdayNewMember}>"><{$yesterdayNewMember}></span>
                </div>
                <div class="desc"> 昨日新增用户数 </div>
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
                    <span class="thisMonthTotals  counterup" data-value="<{$thisMonthMember}>" data-counter="counterup"><{$thisMonthMember}></span>
                </div>
                <div class="desc"> 本月新增用户数 </div>
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
                    <span data-value="<{$totalMember}>" data-counter="counterup" class="allTotals  counterup"><{$totalMember}></span></div>
                <div class="desc">总用户数 </div>
            </div>
        </a>
    </div>

</div>
<div class="row">
    <div class="col-lg-6  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-haze ">
                        <span>工单处理增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class=" font-green-sharp">共：</span>
                        <span class="counterup font-red thisMonthRegimentals2" data-counter="counterup" data-value="108"><{$allDealingWorkOrdertotal}></span>
                        <span class=" font-green-sharp">处理中工单</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-mint">今日处理</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$todayDealingWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-red-mint">昨日处理</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$yesterdayDealingWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayAddRegimentalPreCentum number team" data-percent="<{$dayDealingWorkOrderPercent}>" data-color="#ff2828" style="line-height: 144px;"><span><{$dayDealingWorkOrderPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">本月处理</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$thisMonthDealingWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-grey-salsa">上月处理</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$lastMonthDealingWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddRegimentalPreCentum number team" data-percent="<{$monthDealingWorkOrderPercent}>" data-color="#3598dc" style="line-height: 144px;"><span><{$monthDealingWorkOrderPercent}></span>%</div>
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
                        <span>工单完成增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class="font-green-sharp">共：</span>
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<{$allFinishWorkOrdertotal}>"><{$allFinishWorkOrdertotal}></span>
                        <span class="font-green-sharp">已完成工单</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">今日完成</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$todayFinishWorkOrderTotal}>" style="color:#A3D04B;"><{$todayFinishWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日完成</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<{$yesterdayFinishWorkOrderTotal}>" style="color:#A3D04B;"><{$yesterdayFinishWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<{$dayFinishWorkOrderPercent}>" data-color="#abce33" style="line-height: 144px;"><span><{$dayFinishWorkOrderPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月完成</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<{$thisMonthFinishWorkOrderTotal}>" style="color:#FE2F56;"><{$thisMonthFinishWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-red-mint">上月完成</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<{$lastMonthFinishWorkOrderTotal}>" style="color:#FF2C30;"><{$lastMonthFinishWorkOrderTotal}></span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<{$monthFinishWorkOrderPercent}>" data-color="#f92d56" style="line-height: 144px;"><span><{$monthFinishWorkOrderPercent}></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- BEGIN : 近15日新增用户数  -->
    <div class="col-lg-12 col-xs-12 col-sm-12">
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
    <!-- END 近15日新增用户数  -->
</div>
<script src="/public/wxapp/analysis/js/easypiechart/jquery.easypiechart.js"></script>
<script type="text/javascript" src="
https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript" src="/public/wxapp/analysis/js/draw.js"></script>
<script>
    let daysArr = <{$daysArr}>;
    let fifteenMemberStatistic = <{$fifteenMemberStatistic}>;
    drawAxisChart("memberAnalysis", fifteenMemberStatistic, daysArr, '新增用户数');
</script>

