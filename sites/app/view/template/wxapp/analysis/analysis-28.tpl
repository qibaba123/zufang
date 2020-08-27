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
                    <span class="todayOrders counterup" data-counter="counterup" data-value="<{$todayResumeTotal}>"><{$todayResumeTotal}></span>
                </div>
                <div class="desc"> 今日新增简历数 </div>
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
                    <span class="yestodayOrders counterup" data-counter="counterup" data-value="<{$yesterdayResumeTotal}>"><{$yesterdayResumeTotal}></span>
                </div>
                <div class="desc"> 昨日新增简历数 </div>
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
                    <span class="thisMonthOrders  counterup" data-counter="counterup" data-value="<{$thisMonthResumeTotal}>"><{$thisMonthResumeTotal}></span>
                </div>
                <div class="desc"> 本月新增简历数 </div>
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
                    <span class="allOrders  counterup" data-counter="counterup" data-value="<{$allResumeTotal}>"><{$allResumeTotal}></span>
                </div>
                <div class="desc">总简历数 </div>
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
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<{$todayPositionTotal}>"><{$todayPositionTotal}></span>
                </div>
                <div class="desc"> 今日新增职位数</div>
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
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<{$yesterdayPositionTotal}>"><{$yesterdayPositionTotal}></span>
                </div>
                <div class="desc"> 昨日新增职位数 </div>
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
                    <span class="thisMonthTotals  counterup" data-value="<{$thisMonthPositionTotal}>" data-counter="counterup"><{$thisMonthPositionTotal}></span>
                </div>
                <div class="desc"> 本月新增职位数 </div>
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
                    <span data-value="<{$allPositionTotal}>" data-counter="counterup" class="allTotals  counterup"><{$allPositionTotal}></span></div>
                <div class="desc">总职位数 </div>
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
                    <span class="todayAllsales counterup" data-counter="counterup" data-value="<{$todayCompanyTotal}>"><{$todayCompanyTotal}></span>
                </div>
                <div class="desc"> 今日新增公司数 </div>
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
                    <span class="yestodayAllsales  counterup" data-counter="counterup" data-value="<{$yesterdayCompanyTotal}>"><{$yesterdayCompanyTotal}></span>
                </div>
                <div class="desc"> 昨日新增公司数</div>
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
                    <span class="thisMonthAllsales  counterup" data-counter="counterup" data-value="<{$thisMonthCompanyTotal}>"><{$thisMonthCompanyTotal}></span>
                </div>
                <div class="desc"> 本月新增公司数 </div>
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
                    <span class="thisAllsales  counterup" data-value="<{$allCompanyTotal}>" data-counter="counterup"><{$allCompanyTotal}></span>
                </div>
                <div class="desc"> 总公司数</div>
            </div>
        </a>
    </div>

</div>
<div class="row">
    <div class="col-lg-12  col-xs-12  col-sm-6">
        <div class="zczl">
            <div class="zczl-title">
                <div class="number">
                    <h3 class="font-red-haze ">
                        <span>公司会员增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class=" font-green-sharp">共：</span>
                        <span class="counterup font-red thisMonthRegimentals2" data-counter="counterup" data-value="108"><{$vipMemberTotal}></span>
                        <span class=" font-green-sharp">会员公司</span>
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
                                    <span class="todayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$todayVipMemberTotal}></span>&nbsp;家
                                </div>
                            </div>
                            <span class="font-red-mint">昨日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><{$yesterdayVipMemberTotal}></span>&nbsp;家
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayAddRegimentalPreCentum number team" data-percent="<{$dayVipMemberPercent}>" data-color="#ff2828" style="line-height: 144px;"><span><{$dayVipMemberPercent}></span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">本月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$thisMonthVipMemberTotal}></span>&nbsp;家
                                </div>
                            </div>
                            <span class="font-grey-salsa">上月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><{$lastMonthVipMemberTotal}></span>&nbsp;家
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddRegimentalPreCentum number team" data-percent="<{$monthVipMemberPercent}>" data-color="#3598dc" style="line-height: 144px;"><span><{$monthVipMemberPercent}></span>%</div>
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
                    <span class="caption-subject bold uppercase font-dark">近15日新增简历量</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="resumeAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END :  近15日订单量   -->

    <!-- BEGIN : 近15简历投递数量   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日简历投递量</span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="deliveryAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END :  近15简历投递数量   -->



    <!-- BEGIN :  近15日商品销售数   -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日新增公司量</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="companyAnalysis" style="height: 400px"></div>
            </div>
        </div>
    </div>
    <!-- END : 近15日商品销售数  -->
    <!-- BEGIN : 近15日销售额  -->
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">近15日新增职位量</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="positionAnalysis" style="height: 400px"></div>
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
    let fifteenResumeStatistic = <{$fifteenResumeStatistic}>;
    let fifteenPositionStatistic = <{$fifteenPositionStatistic}>;
    let fifteenCompanyStatistic = <{$fifteenCompanyStatistic}>;
    let fifteenMemberStatistic = <{$fifteenMemberStatistic}>;
    let fifteendeliveryStatistic = <{$fifteendeliveryStatistic}>;
    drawAxisChart("resumeAnalysis", fifteenResumeStatistic, daysArr, '新增简历量');
    drawAxisChart("companyAnalysis", fifteenCompanyStatistic, daysArr, '新增公司量');
    drawAxisChart("positionAnalysis", fifteenPositionStatistic, daysArr, '新增职位量');
    drawAxisChart("memberAnalysis", fifteenMemberStatistic, daysArr, '新增用户数');
    drawAxisChart("deliveryAnalysis", fifteendeliveryStatistic, daysArr, '投递量');
    
</script>

