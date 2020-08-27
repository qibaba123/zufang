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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

