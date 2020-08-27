<?php /* Smarty version Smarty-3.1.17, created on 2020-04-01 18:39:10
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/analysis/analysis-21.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1542619015e846f4e1ce2d2-28373209%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a467c7b4a9546723300c9062ab23848bd5e503e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/analysis/analysis-21.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1542619015e846f4e1ce2d2-28373209',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'todaySaleGoodsTotal' => 0,
    'yesterdaySaleGoodsTotal' => 0,
    'thisMonthSaleGoodsTotal' => 0,
    'saleGoodsTotal' => 0,
    'todaySaleMoneyTotal' => 0,
    'yesterdaySaleMoneyTotal' => 0,
    'thisMonthSaleMoneyTotal' => 0,
    'saleMoneyTotal' => 0,
    'saleingGoodsTotal' => 0,
    'soldoutGoodsTotal' => 0,
    'nosaleGoodsTotal' => 0,
    'goodsTotal' => 0,
    'usedCouponTotal' => 0,
    'couponTotal' => 0,
    'couponPercent' => 0,
    'outPointTotal' => 0,
    'inPointTotal' => 0,
    'pointPercent' => 0,
    'totalMember' => 0,
    'todayNewMember' => 0,
    'yesterdayNewMember' => 0,
    'dayAddMemberPercent' => 0,
    'thisMonthMember' => 0,
    'lastMonthMember' => 0,
    'monthAddMemberPercent' => 0,
    'orderTotal' => 0,
    'todayOrderTotal' => 0,
    'yesterdayOrderTotal' => 0,
    'dayOrderPercent' => 0,
    'thisMonthOrderTotal' => 0,
    'lastMonthOrderTotal' => 0,
    'monthOrderPercent' => 0,
    'totalDistribMember' => 0,
    'todayDistribMember' => 0,
    'yesterdayDistribMember' => 0,
    'dayDistribMemberPercent' => 0,
    'thisMonthDistribMember' => 0,
    'lastMonthDistribMember' => 0,
    'monthDistribMemberPercent' => 0,
    'refundTotal' => 0,
    'todayRefundTotal' => 0,
    'yesterdayRefundTotal' => 0,
    'dayRefundPercent' => 0,
    'thisMonthRefundTotal' => 0,
    'lastMonthRefundTotal' => 0,
    'monthRefundPercent' => 0,
    'daysArr' => 0,
    'fifteenOrderStatistic' => 0,
    'fifteenSaleGoodsStatistic' => 0,
    'fifteenSaleMoneyStatistic' => 0,
    'fifteenMemberStatistic' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e846f4e24f7b5_75764002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e846f4e24f7b5_75764002')) {function content_5e846f4e24f7b5_75764002($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/analysis/css/index.css">
<link rel="stylesheet" href="/public/wxapp/analysis/css/main.css">

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="order-stat dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual_metteyya visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="todayOrders counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['todaySaleGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['todaySaleGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 今日售出商品数 </div>
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
                    <span class="yestodayOrders counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['yesterdaySaleGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['yesterdaySaleGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 昨日售出商品数 </div>
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
                    <span class="thisMonthOrders  counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['thisMonthSaleGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['thisMonthSaleGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 本月售出商品数 </div>
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
                    <span class="allOrders  counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['saleGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['saleGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc">总售出商品数 </div>
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
                    <span class="todayAllTotals counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['todaySaleMoneyTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['todaySaleMoneyTotal']->value;?>
</span>
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
                    <span class="yestodayAllTotals  counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['yesterdaySaleMoneyTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['yesterdaySaleMoneyTotal']->value;?>
</span>
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
                    <span class="thisMonthTotals  counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['thisMonthSaleMoneyTotal']->value;?>
" data-counter="counterup"><?php echo $_smarty_tpl->tpl_vars['thisMonthSaleMoneyTotal']->value;?>
</span>
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
                    <span data-value="<?php echo $_smarty_tpl->tpl_vars['saleMoneyTotal']->value;?>
" data-counter="counterup" class="allTotals  counterup"><?php echo $_smarty_tpl->tpl_vars['saleMoneyTotal']->value;?>
</span></div>
                <div class="desc">总订单金额 </div>
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
                    <span class="todayAllsales counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['saleingGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['saleingGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 在售商品数 </div>
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
                    <span class="yestodayAllsales  counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['soldoutGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['soldoutGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 售罄商品数</div>
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
                    <span class="thisMonthAllsales  counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['nosaleGoodsTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['nosaleGoodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 下架商品数 </div>
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
                    <span class="thisAllsales  counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['goodsTotal']->value;?>
" data-counter="counterup"><?php echo $_smarty_tpl->tpl_vars['goodsTotal']->value;?>
</span>
                </div>
                <div class="desc"> 总商品数</div>
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
                        <span class="counterup font-green-sharp" data-counter="counterup" id="thisMonthSales"><?php echo $_smarty_tpl->tpl_vars['usedCouponTotal']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['couponTotal']->value;?>
</span>
                    </i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress1 progress">
                          <span style="width: <?php echo $_smarty_tpl->tpl_vars['couponPercent']->value;?>
%;" class="thisMonthPriceAllPC  progress-bar progress-bar-success green-sharp">
                                <span class="sr-only progress_percentum"><?php echo $_smarty_tpl->tpl_vars['couponPercent']->value;?>
% progress</span>
                          </span>
                </div>
                <div class="status">
                    <div class="status-number percentage_percentum"><?php echo $_smarty_tpl->tpl_vars['couponPercent']->value;?>
%</div>
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
                        <span class="counterup font-green-sharp thisMonthRegimentals" data-counter="counterup"><?php echo $_smarty_tpl->tpl_vars['outPointTotal']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['inPointTotal']->value;?>
</span>
                    </i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress1  progress">
                          <span style="width: <?php echo $_smarty_tpl->tpl_vars['pointPercent']->value;?>
%;" class="thnisMonthRegimentalPC  progress-bar progress-bar-success red-haze">
                                <span class="sr-only regimentalTotals-percentum"><?php echo $_smarty_tpl->tpl_vars['pointPercent']->value;?>
% progress</span>
                          </span>
                </div>
                <div class="status">
                    <div class="status-number regimentalTotals-progress"><?php echo $_smarty_tpl->tpl_vars['pointPercent']->value;?>
%</div>
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
                        <span class="counterup font-red thisMonthRegimentals2" data-counter="counterup" data-value="108"><?php echo $_smarty_tpl->tpl_vars['totalMember']->value;?>
</span>
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
                                    <span class="todayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><?php echo $_smarty_tpl->tpl_vars['todayNewMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-red-mint">昨日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayAddRegimentalPerson counterup" data-counter="counterup" data-value="0" style="color:#FF2C30;"><?php echo $_smarty_tpl->tpl_vars['yesterdayNewMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayAddRegimentalPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['dayAddMemberPercent']->value;?>
" data-color="#ff2828" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['dayAddMemberPercent']->value;?>
</span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">本月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><?php echo $_smarty_tpl->tpl_vars['thisMonthMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-grey-salsa">上月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthAddTeamersnum  counterup" data-counter="counterup" data-value="13" style="color:#3B94D7"><?php echo $_smarty_tpl->tpl_vars['lastMonthMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddRegimentalPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['monthAddMemberPercent']->value;?>
" data-color="#3598dc" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['monthAddMemberPercent']->value;?>
</span>%</div>
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
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<?php echo $_smarty_tpl->tpl_vars['orderTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['orderTotal']->value;?>
</span>
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
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['todayOrderTotal']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['todayOrderTotal']->value;?>
</span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['yesterdayOrderTotal']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['yesterdayOrderTotal']->value;?>
</span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['dayOrderPercent']->value;?>
" data-color="#abce33" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['dayOrderPercent']->value;?>
</span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['thisMonthOrderTotal']->value;?>
" style="color:#FE2F56;"><?php echo $_smarty_tpl->tpl_vars['thisMonthOrderTotal']->value;?>
</span>&nbsp;单
                                </div>
                            </div>
                            <span class="font-red-mint">上月订单</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['lastMonthOrderTotal']->value;?>
" style="color:#FF2C30;"><?php echo $_smarty_tpl->tpl_vars['lastMonthOrderTotal']->value;?>
</span>&nbsp;单
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['monthOrderPercent']->value;?>
" data-color="#f92d56" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['monthOrderPercent']->value;?>
</span>%</div>
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
                        <span>分销会员增长率</span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="icon-user">
                        <span class="font-green-sharp">共：</span>
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="965"><?php echo $_smarty_tpl->tpl_vars['totalDistribMember']->value;?>
</span>
                        <span class="font-green-sharp">分销会员</span>
                    </i>
                </div>
                <div class="head-bottom"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-grey-salsa">今日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['todayDistribMember']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['todayDistribMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['yesterdayDistribMember']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['yesterdayDistribMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['dayDistribMemberPercent']->value;?>
" data-color="#abce33" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['dayDistribMemberPercent']->value;?>
</span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['thisMonthDistribMember']->value;?>
" style="color:#FE2F56;"><?php echo $_smarty_tpl->tpl_vars['thisMonthDistribMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-red-mint">上月新增</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['lastMonthDistribMember']->value;?>
" style="color:#FF2C30;"><?php echo $_smarty_tpl->tpl_vars['lastMonthDistribMember']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['monthDistribMemberPercent']->value;?>
" data-color="#f92d56" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['monthDistribMemberPercent']->value;?>
</span>%</div>
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
                        <span class="allMbs  counterup" data-counter="counterup" style="color:#FE2F56;" data-value="<?php echo $_smarty_tpl->tpl_vars['refundTotal']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['refundTotal']->value;?>
</span>
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
                                    <span class="thisMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['todayRefundTotal']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['todayRefundTotal']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-grey-salsa">昨日退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="lastMonthNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['yesterdayRefundTotal']->value;?>
" style="color:#A3D04B;"><?php echo $_smarty_tpl->tpl_vars['yesterdayRefundTotal']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="monthAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['dayRefundPercent']->value;?>
" data-color="#abce33" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['dayRefundPercent']->value;?>
</span>%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-widget-2 mt-widget1">
                        <div class="pie-font">
                            <span class="font-red-soft">本月退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="todayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['thisMonthRefundTotal']->value;?>
" style="color:#FE2F56;"><?php echo $_smarty_tpl->tpl_vars['thisMonthRefundTotal']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                            <span class="font-red-mint">上月退款</span>
                            <div class="details" style="margin-bottom: 15px;">
                                <div class="number">
                                    <span class="yestodayNewAddPerson counterup" data-counter="counterup" data-value="<?php echo $_smarty_tpl->tpl_vars['lastMonthRefundTotal']->value;?>
" style="color:#FF2C30;"><?php echo $_smarty_tpl->tpl_vars['lastMonthRefundTotal']->value;?>
</span>&nbsp;人
                                </div>
                            </div>
                        </div>
                        <div class="easy-pie-chart chart-style">
                            <div class="todayNewAddMbsPreCentum number team" data-percent="<?php echo $_smarty_tpl->tpl_vars['monthRefundPercent']->value;?>
" data-color="#f92d56" style="line-height: 144px;"><span><?php echo $_smarty_tpl->tpl_vars['monthRefundPercent']->value;?>
</span>%</div>
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
                    <span class="caption-subject bold uppercase font-dark">近15日售出商品数</span>
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
                    <span class="caption-subject bold uppercase font-dark">近15日商品销售额</span>
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
    let daysArr = <?php echo $_smarty_tpl->tpl_vars['daysArr']->value;?>
;
    let fifteenOrderStatistic = <?php echo $_smarty_tpl->tpl_vars['fifteenOrderStatistic']->value;?>
;
    let fifteenSaleGoodsStatistic = <?php echo $_smarty_tpl->tpl_vars['fifteenSaleGoodsStatistic']->value;?>
;
    let fifteenSaleMoneyStatistic = <?php echo $_smarty_tpl->tpl_vars['fifteenSaleMoneyStatistic']->value;?>
;
    let fifteenMemberStatistic = <?php echo $_smarty_tpl->tpl_vars['fifteenMemberStatistic']->value;?>
;
    drawAxisChart("orderAnalysis", fifteenOrderStatistic, daysArr, '订单量');
    drawAxisChart("saleAnalysis", fifteenSaleGoodsStatistic, daysArr, '售出商品数');
    drawAxisChart("moneyAnalysis", fifteenSaleMoneyStatistic, daysArr, '商品销售额');
    drawAxisChart("memberAnalysis", fifteenMemberStatistic, daysArr, '新增用户数');
</script>

<?php }} ?>
