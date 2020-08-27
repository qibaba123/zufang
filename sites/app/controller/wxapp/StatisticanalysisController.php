<?php


class App_Controller_Wxapp_StatisticanalysisController extends App_Controller_Wxapp_InitController
{
    private $startToday;
    private $endToday;
    private $startYesterday;
    private $endYesterday;
    private $startThisMonth;
    private $endThisMonth;
    private $startLastMonth;
    private $endLastMonth;
    private $startFifteenDays;
    private $endFifteenDays;
    private $fifteenDays;

    public function __construct()
    {
        parent::__construct();
        $this->startToday = strtotime(date('Y-m-d'));
        $this->endToday = time();
        $this->startYesterday = strtotime('-1 day', strtotime(date('Y-m-d')));
        $this->endYesterday = strtotime(date('Y-m-d'));
        $this->startThisMonth = strtotime(date('Y-m'));
        $this->endThisMonth = time();
        $this->startLastMonth = strtotime('-1 month', strtotime(date('Y-m')));
        $this->endLastMonth = strtotime(date('Y-m'));
        $this->startFifteenDays = strtotime('-14 days', strtotime(date('Y-m-d')));
        $this->endFifteenDays  = time();
        $this->_get_fifteen_days();
    }

    private function _get_fifteen_days(){
        $daysArr = [];
        for($i=14; $i>0; $i--){
            $daysArr[] = date('m/d', strtotime('-'.$i.' day', strtotime(date('Y-m-d'))));
        }
        $daysArr[] = date('m/d', strtotime(date('Y-m-d')));
        $this->fifteenDays = $daysArr;
        $this->output['daysArr'] = json_encode($daysArr);
    }

    public function indexAction(){
        $test = $this->request->getIntParam('test');
        if(method_exists($this, '_get_statistic_analysis_'.$this->wxapp_cfg['ac_type'])){
            $func = '_get_statistic_analysis_'.$this->wxapp_cfg['ac_type'];
            $this->$func();
        }
        $this->buildBreadcrumbs(array(
            array('title' => '商户概览', 'link' => '#'),
        ));
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 6 || $test){
            $this->displaySmarty('wxapp/analysis/analysis-'.$this->wxapp_cfg['ac_type'].'-new.tpl');
        }else{
            $this->displaySmarty('wxapp/analysis/analysis-'.$this->wxapp_cfg['ac_type'].'.tpl');
        }
    }
    private function _get_statistic_analysis_1(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
    }
    private function _get_statistic_analysis_3(){
        $this->_get_member_statistic();
        $this->_get_point_statistic();
    }
    private function _get_statistic_analysis_4(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_cashier_statistic();
        $this->_get_meal_statistic();
    }
    private function _get_statistic_analysis_6(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_distrib_statistic();
        $this->_get_cashier_statistic();
        $this->_get_post_statistic();
        $this->_get_entershop_statistic();
    }
    private function _get_statistic_analysis_7(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_cashier_statistic();
    }
    private function _get_statistic_analysis_8(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_distrib_statistic();
        $this->_get_entershop_statistic();
    }
    private function _get_statistic_analysis_11(){
        $this->_get_member_statistic();
        $this->_get_message_statistic();
    }
    private function _get_statistic_analysis_12(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_distrib_statistic();
    }
    private function _get_statistic_analysis_13(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
    }
    private function _get_statistic_analysis_16(){
        $this->_get_member_statistic();
        $this->_get_house_statistic();
    }
    private function _get_statistic_analysis_18(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_distrib_statistic();
        $this->_get_reservation_statistic();
        $this->_get_refund_order_statistic();
    }
    private function _get_statistic_analysis_20(){
        $this->_get_member_statistic();
        $this->_get_workorder_statistic();
    }
    private function _get_statistic_analysis_21(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
        $this->_get_distrib_statistic();
    }
    private function _get_statistic_analysis_22(){
        $this->_get_member_statistic();
        $this->_get_coupon_statistic();
        $this->_get_order_statistic();
    }
    private function _get_statistic_analysis_23(){
        $this->_get_member_statistic();
        $this->_get_coupon_statistic();
        $this->_get_message_statistic();
    }
    private function _get_statistic_analysis_24(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_refund_order_statistic();
    }
    private function _get_statistic_analysis_27(){
        $this->_get_member_statistic();
        $this->_get_coupon_statistic();
        $this->_get_goods_statistic();
        $this->_get_point_statistic();
        $this->_get_distrib_statistic();
        $this->_get_order_statistic();
    }
    private function _get_statistic_analysis_28(){
        $this->_get_member_statistic();
        $this->_get_job_statistic();
        $this->_get_membercard_statistic();
    }
    private function _get_statistic_analysis_30(){
        $this->_get_member_statistic();
        $this->_get_point_statistic();
        $this->_get_gamebox_statistic();
    }
    private function _get_statistic_analysis_32(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_sequence_statistic();
        $this->_get_refund_order_statistic();

    }
    private function _get_statistic_analysis_36(){
        $this->_get_member_statistic();
        $this->_get_goods_statistic();
        $this->_get_coupon_statistic();
        $this->_get_point_statistic();
        $this->_get_order_statistic();
        $this->_get_sequence_statistic();
        $this->_get_refund_order_statistic();

    }
    private function _get_statistic_analysis_34(){
        $this->_get_member_statistic();
        $this->_get_coupon_statistic();
        $this->_get_legwork_statistic();
    }
    private function _get_member_statistic(){
        $member_model  = new App_Model_Member_MysqlMemberCoreStorage();
        $where_total   = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(1,2,3,4,6,7)];

        $where_today[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $this->startToday];
        $where_today[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '<', 'value' => $this->endToday];

        $where_yesterday[]  = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $this->startYesterday];
        $where_yesterday[]  = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '<', 'value' => $this->endYesterday];

        $where_this_month[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $this->startThisMonth];
        $where_this_month[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '<', 'value' => $this->endThisMonth];

        $where_last_month[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $this->startLastMonth];
        $where_last_month[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '<', 'value' => $this->endLastMonth];

        $todayNewMember     = $member_model->getCount($where_today);
        $yesterdayNewMember = $member_model->getCount($where_yesterday);
        $thisMonthMember    = $member_model->getCount($where_this_month);
        $lastMonthMember    = $member_model->getCount($where_last_month);
        $totalMember        = $member_model->getCount($where_total);

        $this->output['todayNewMember']     = $todayNewMember;
        $this->output['yesterdayNewMember'] = $yesterdayNewMember;
        $this->output['thisMonthMember']    = $thisMonthMember;
        $this->output['lastMonthMember']    = $lastMonthMember;
        $this->output['totalMember']        = $totalMember;
        $this->output['dayAddMemberPercent'] = round((($todayNewMember-$yesterdayNewMember)/$yesterdayNewMember)*100, 2);
        $this->output['monthAddMemberPercent'] = round((($thisMonthMember-$lastMonthMember)/$lastMonthMember)*100, 2);
        $where_fifteen_days[] = array('name'=>'unix_timestamp(m_follow_time)','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'unix_timestamp(m_follow_time)','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenMemberStatistic = array();
        $fifteenMemberTotal = 0;
        foreach ($this->fifteenDays as $val){
            $fifteenMemberStatistic[$val] = 0;
        }
        $fetchNumGroupByDate = $member_model->fetchNumGroupByDate($where_fifteen_days);
        foreach ($fetchNumGroupByDate as $value){
            $fifteenMemberStatistic[$value['curr_date']] = $value['total'];
            $fifteenMemberTotal += $value['total'];
        }
        $this->output['fifteenMemberStatistic'] = json_encode(array_values($fifteenMemberStatistic));
        $this->output['fifteenMemberTotal'] = $fifteenMemberTotal;
    }
    private function _get_post_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name' => 'acp_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $where_today[] = array('name'=>'acp_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'acp_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'acp_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'acp_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'acp_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'acp_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'acp_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'acp_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
        $todayPostTotal     = $post_storage->getCount($where_today);
        $yesterdayPostTotal = $post_storage->getCount($where_yesterday);
        $thisMonthPostTotal = $post_storage->getCount($where_this_month);
        $lastMonthPostTotal = $post_storage->getCount($where_last_month);
        $allPostTotal       = $post_storage->getCount($where_total);
        $this->output['todayPostTotal']     = $todayPostTotal;
        $this->output['yesterdayPostTotal'] = $yesterdayPostTotal;
        $this->output['thisMonthPostTotal'] = $thisMonthPostTotal;
        $this->output['lastMonthPostTotal'] = $lastMonthPostTotal;
        $this->output['allPostTotal']       = $allPostTotal;
        $this->output['dayPostPercent']     = round(($todayPostTotal - $yesterdayPostTotal)/$yesterdayPostTotal * 100, 2);
        $this->output['monthPostPercent']   = round(($thisMonthPostTotal - $lastMonthPostTotal)/$lastMonthPostTotal * 100, 2);

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $where_today[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
        $todayPostProfit     = $pay_model->getProfitMoneyAll($where_today);
        $yesterdayPostProfit = $pay_model->getProfitMoneyAll($where_yesterday);
        $thisMonthProfit     = $pay_model->getProfitMoneyAll($where_this_month);
        $totalProfit         = $pay_model->getProfitMoneyAll($where_total);

        $this->output['todayPostProfit']     = $todayPostProfit?$todayPostProfit:0;
        $this->output['yesterdayPostProfit'] = $yesterdayPostProfit?$yesterdayPostProfit:0;
        $this->output['thisMonthPostProfit'] = $thisMonthProfit?$thisMonthProfit:0;
        $this->output['totalPostProfit']     = $totalProfit?$totalProfit:0;
        $where_fifteen_days[] = array('name'=>'acp_s_id','oper'=>'=','value'=> $this->curr_sid);
        $where_fifteen_days[] = array('name'=>'acp_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'acp_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenPostList = $post_storage->getList($where_fifteen_days, 0, 0);
        $fifteenPostStatistic = array();
        $fifteenPostTotal = count($fifteenPostList);
        foreach ($this->fifteenDays as $val){
            $fifteenPostStatistic[$val] = 0;
        }
        foreach ($fifteenPostList as $value){
            $fifteenPostStatistic[date('m/d', $value['acp_create_time'])] = $fifteenPostStatistic[date('m/d', $value['acp_create_time'])] + 1;
        }
        $this->output['fifteenPostStatistic'] = json_encode(array_values($fifteenPostStatistic));
        $this->output['fifteenPostTotal'] = $fifteenPostTotal;
    }
    private function _get_order_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        if($this->wxapp_cfg['ac_type'] != 22){
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        }

        if($this->wxapp_cfg['ac_type'] == 18){
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_meal_type','oper'=>'=','value'=> 2);
        }

        $where_today[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endLastMonth);
        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $totalOrderStatistic = $order_model->fetchTradeTotalNumMoney($where_total);
        $todayOrderStatistic = $order_model->fetchTradeTotalNumMoney($where_today);
        $yesterdayOrderStatistic = $order_model->fetchTradeTotalNumMoney($where_yesterday);
        $thisMonthOrderStatistic = $order_model->fetchTradeTotalNumMoney($where_this_month);
        $lastMonthOrderStatistic = $order_model->fetchTradeTotalNumMoney($where_last_month);

        $saleGoodsTotal = $totalOrderStatistic['goodsNum'] ? $totalOrderStatistic['goodsNum'] : 0;
        $saleMoneyTotal = $totalOrderStatistic['money'];

        $todaySaleGoodsTotal = $todayOrderStatistic['goodsNum'];
        $todaySaleMoneyTotal = $todayOrderStatistic['money'] ? $todayOrderStatistic['money'] : 0;

        $yesterdaySaleGoodsTotal = $yesterdayOrderStatistic['goodsNum'];
        $yesterdaySaleMoneyTotal = $yesterdayOrderStatistic['money'];

        $thisMonthSaleGoodsTotal = $thisMonthOrderStatistic['goodsNum'];
        $thisMonthSaleMoneyTotal = $thisMonthOrderStatistic['money'];

        $lastMonthSaleGoodsTotal = $lastMonthOrderStatistic['goodsNum'];
        $lastMonthSaleMoneyTotal = $lastMonthOrderStatistic['money'];

        $orderTotal          = $totalOrderStatistic['total'];
        $todayOrderTotal     = $todayOrderStatistic['total'];
        $yesterdayOrderTotal = $yesterdayOrderStatistic['total'];
        $thisMonthOrderTotal = $thisMonthOrderStatistic['total'];
        $lastMonthOrderTotal = $lastMonthOrderStatistic['total'];


        $this->output['saleGoodsTotal'] = $saleGoodsTotal?$saleGoodsTotal:0;
        $this->output['saleMoneyTotal'] = $saleMoneyTotal?$saleMoneyTotal:0;
        $this->output['todaySaleGoodsTotal'] = $todaySaleGoodsTotal?$todaySaleGoodsTotal:0;
        $this->output['todaySaleMoneyTotal'] = $todaySaleMoneyTotal?$todaySaleMoneyTotal:0;
        $this->output['yesterdaySaleGoodsTotal'] = $yesterdaySaleGoodsTotal?$yesterdaySaleGoodsTotal:0;
        $this->output['yesterdaySaleMoneyTotal'] = $yesterdaySaleMoneyTotal?$yesterdaySaleMoneyTotal:0;
        $this->output['daySaleGoodsPercent']     = round(($todaySaleGoodsTotal-$yesterdaySaleGoodsTotal)/($yesterdaySaleGoodsTotal>0?$yesterdaySaleGoodsTotal:1)*100, 2);
        $this->output['thisMonthSaleGoodsTotal'] = $thisMonthSaleGoodsTotal?$thisMonthSaleGoodsTotal:0;
        $this->output['thisMonthSaleMoneyTotal'] = $thisMonthSaleMoneyTotal?$thisMonthSaleMoneyTotal:0;
        $this->output['lastMonthSaleGoodsTotal'] = $lastMonthSaleGoodsTotal?$lastMonthSaleGoodsTotal:0;
        $this->output['monthSaleGoodsPercent']   = round(($thisMonthSaleGoodsTotal-$lastMonthSaleGoodsTotal)/($lastMonthSaleGoodsTotal>0?$lastMonthSaleGoodsTotal:1)*100, 2);

        $this->output['orderTotal']          = $orderTotal;
        $this->output['todayOrderTotal']     = $todayOrderTotal;
        $this->output['yesterdayOrderTotal'] = $yesterdayOrderTotal;
        $this->output['dayOrderPercent']     = round(($todayOrderTotal - $yesterdayOrderTotal)/($yesterdayOrderTotal>0?$yesterdayOrderTotal:1) * 100, 2);
        $this->output['thisMonthOrderTotal'] = $thisMonthOrderTotal;
        $this->output['lastMonthOrderTotal'] = $lastMonthOrderTotal;
        $this->output['monthOrderPercent']   = round(($thisMonthOrderTotal - $lastMonthOrderTotal)/($lastMonthOrderTotal>0?$lastMonthOrderTotal:1) * 100, 2);
        $where_fifteen_days[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByDate($where_fifteen_days);
        $fifteenOrderStatistic = array();
        $fifteenSaleGoodsStatistic = array();
        $fifteenSaleMoneyStatistic = array();
        $fifteenOrderTotal = 0;
        $fifteenSaleGoodsTotal = 0;
        $fifteenSaleMoneyTotal = 0;
        foreach ($this->fifteenDays as $val){
            $fifteenOrderStatistic[$val] = 0;
            $fifteenSaleGoodsStatistic[$val] = 0;
            $fifteenSaleMoneyStatistic[$val] = 0;
        }
        foreach ($totalMoneyNum as $value){
            $fifteenOrderStatistic[$value['curr_date']] = $value['total'];
            $fifteenSaleGoodsStatistic[$value['curr_date']] = $value['goodsNum'];
            $fifteenSaleMoneyStatistic[$value['curr_date']] = $value['money'];
            $fifteenOrderTotal += $value['total'];
            $fifteenSaleGoodsTotal += $value['goodsNum'];
            $fifteenSaleMoneyTotal += $value['money'];
        }
        $this->output['fifteenOrderStatistic']     = json_encode(array_values($fifteenOrderStatistic));
        $this->output['fifteenSaleGoodsStatistic'] = json_encode(array_values($fifteenSaleGoodsStatistic));
        $this->output['fifteenSaleMoneyStatistic'] = json_encode(array_values($fifteenSaleMoneyStatistic));
        $this->output['fifteenOrderTotal']     = $fifteenOrderTotal;
        $this->output['fifteenSaleGoodsTotal'] = $fifteenSaleGoodsTotal;
        $this->output['fifteenSaleMoneyTotal'] = $fifteenSaleMoneyTotal;
    }
    private function _get_refund_order_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'tr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'tr_status','oper'=>'=','value'=>1);

        if($this->wxapp_cfg['ac_type'] == 18){
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_meal_type','oper'=>'=','value'=> 2);
        }

        $where_today[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endLastMonth);
        $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
        $totalRefundStatistic = $refund_model->refundOrderStatistic($where_total);
        $todayRefundStatistic = $refund_model->refundOrderStatistic($where_today);
        $yesterdayRefundStatistic = $refund_model->refundOrderStatistic($where_yesterday);
        $thisMonthRefundStatistic = $refund_model->refundOrderStatistic($where_this_month);
        $lastMonthRefundStatistic = $refund_model->refundOrderStatistic($where_last_month);

        $refundTotal          = $totalRefundStatistic['total'];
        $todayRefundTotal     = $todayRefundStatistic['total'];
        $yesterdayRefundTotal = $yesterdayRefundStatistic['total'];
        $thisMonthRefundTotal = $thisMonthRefundStatistic['total'];
        $lastMonthRefundTotal = $lastMonthRefundStatistic['total'];

        $this->output['refundTotal']          = $refundTotal;
        $this->output['todayRefundTotal']     = $todayRefundTotal;
        $this->output['yesterdayRefundTotal'] = $yesterdayRefundTotal;
        $this->output['dayRefundPercent']     = round(($todayRefundTotal - $yesterdayRefundTotal)/($yesterdayRefundTotal?$yesterdayRefundTotal:1) * 100, 2);
        $this->output['thisMonthRefundTotal'] = $thisMonthRefundTotal;
        $this->output['lastMonthRefundTotal'] = $lastMonthRefundTotal;
        $this->output['monthRefundPercent']   = round(($thisMonthRefundTotal - $lastMonthRefundTotal)/($lastMonthRefundTotal?$lastMonthRefundTotal:1) * 100, 2);
    }
    private function _get_coupon_statistic(){
        $where_used = $where_total = [];
        $where_total[] = $where_used[] = ['name' => 'cl_s_id','oper' => '=','value' =>$this->curr_sid];
        $where_total[] = $where_used[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>0];

        $receive_model = new App_Model_Coupon_MysqlReceiveStorage();
        $couponTotal  = $receive_model->getReceiveStat($where_total);
        $usedTotal    = $receive_model->getReceiveStat($where_total, 'used');

        $this->output['couponTotal']     = $couponTotal['total'];
        $this->output['usedCouponTotal'] = $usedTotal['total'];
        $this->output['couponPercent']   = round($usedTotal['total']/$couponTotal['total']*100, 2);
    }
    private function _get_point_statistic(){
        $in_where = $out_where = array();
        $in_where[]  = $out_where[] = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $in_where[]  = array('name' => 'pi_type', 'oper' => '=', 'value' => 1);
        $out_where[] = array('name' => 'pi_type', 'oper' => '=', 'value' => 2);
        $point_model = new App_Model_Point_MysqlInoutStorage($this->curr_sid);
        $inPointTotal  = $point_model->pointStatistic($in_where);
        $outPointTotal = $point_model->pointStatistic($out_where);

        $this->output['inPointTotal']  = $inPointTotal?$inPointTotal:0;
        $this->output['outPointTotal'] = $outPointTotal?$outPointTotal:0;
        $this->output['pointPercent']  = round($outPointTotal/$inPointTotal * 100, 2);
    }
    private function _get_entershop_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        if($this->wxapp_cfg['ac_type'] == 6){
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 2);
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);

            $where_today[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startToday);
            $where_today[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endToday);

            $where_yesterday[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startYesterday);
            $where_yesterday[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endYesterday);

            $where_this_month[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startThisMonth);
            $where_this_month[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endThisMonth);

            $where_last_month[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startLastMonth);
            $where_last_month[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endLastMonth);

            $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
            $todayEnterProfit = $pay_model->getProfitTotal($where_today);
            $yesterdayEnterProfit = $pay_model->getProfitTotal($where_yesterday);
            $thisMonthEnterProfit = $pay_model->getProfitTotal($where_this_month);
            $totalEnterProfit = $pay_model->getProfitTotal($where_total);

            $todayEnterTotal     = $pay_model->getProfitCountAll($where_today);
            $yesterdayEnterTotal = $pay_model->getProfitCountAll($where_yesterday);
            $thisMonthEnterTotal = $pay_model->getProfitCountAll($where_this_month);
            $lastMonthEnterTotal = $pay_model->getProfitCountAll($where_last_month);
            $allEnterTotal       = $pay_model->getProfitCountAll($where_total);
            $where_fifteen_days[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
            $where_fifteen_days[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $this->endFifteenDays);
            $fifteenPostList = $pay_model->getList($where_fifteen_days, 0, 0);
            $fifteenEnterStatistic = array();
            $fifteenEnterTotal = count($fifteenPostList);
            foreach ($this->fifteenDays as $val){
                $fifteenEnterStatistic[$val] = 0;
            }
            foreach ($fifteenPostList as $value){
                $fifteenEnterStatistic[date('m/d', $value['cpp_create_time'])] = $fifteenEnterStatistic[date('m/d', $value['cpp_create_time'])] + 1;
            }
        }

        if($this->wxapp_cfg['ac_type'] == 8){
            $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name' => 'acap_s_id', 'oper' => '=', 'value' => $this->curr_sid);

            $where_today[] = array('name'=>'acap_create_time','oper'=>'>=','value'=> $this->startToday);
            $where_today[] = array('name'=>'acap_create_time','oper'=>'<','value'=> $this->endToday);

            $where_yesterday[] = array('name'=>'acap_create_time','oper'=>'>=','value'=> $this->startYesterday);
            $where_yesterday[] = array('name'=>'acap_create_time','oper'=>'<','value'=> $this->endYesterday);

            $where_this_month[] = array('name'=>'acap_create_time','oper'=>'>=','value'=> $this->startThisMonth);
            $where_this_month[] = array('name'=>'acap_create_time','oper'=>'<','value'=> $this->endThisMonth);

            $where_last_month[] = array('name'=>'acap_create_time','oper'=>'>=','value'=> $this->startLastMonth);
            $where_last_month[] = array('name'=>'acap_create_time','oper'=>'<','value'=> $this->endLastMonth);

            $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->curr_sid);
            $todayEnterTotal     = $pay_model->getCount($where_today);
            $yesterdayEnterTotal = $pay_model->getCount($where_yesterday);
            $thisMonthEnterTotal = $pay_model->getCount($where_this_month);
            $lastMonthEnterTotal = $pay_model->getCount($where_last_month);
            $allEnterTotal       = $pay_model->getCount($where_total);

            $todayEnterProfit     = $pay_model->getProfitTotal($where_today);
            $yesterdayEnterProfit = $pay_model->getProfitTotal($where_yesterday);
            $thisMonthEnterProfit = $pay_model->getProfitTotal($where_this_month);
            $lastMonthEnterProfit = $pay_model->getProfitTotal($where_last_month);
            $totalEnterProfit     = $pay_model->getProfitTotal($where_total);
            $where_fifteen_days[] = array('name'=>'acap_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
            $where_fifteen_days[] = array('name'=>'acap_create_time','oper'=>'<','value'=> $this->endFifteenDays);
            $fifteenPostList = $pay_model->getList($where_fifteen_days, 0, 0);
            $fifteenEnterStatistic = array();
            $fifteenEnterProfitStatistic = array();
            foreach ($this->fifteenDays as $val){
                $fifteenEnterStatistic[$val] = 0;
                $fifteenEnterProfitStatistic[$val] = 0;
            }
            foreach ($fifteenPostList as $value){
                $fifteenEnterStatistic[date('m/d', $value['acap_create_time'])] = $fifteenEnterStatistic[date('m/d', $value['acap_create_time'])] + 1;
                $fifteenEnterProfitStatistic[date('m/d', $value['acap_create_time'])] = $fifteenEnterProfitStatistic[date('m/d', $value['acap_create_time'])] + $value['acap_money'];
            }
        }

        $this->output['todayEnterProfit']     = $todayEnterProfit?$todayEnterProfit:0;
        $this->output['yesterdayEnterProfit'] = $yesterdayEnterProfit?$yesterdayEnterProfit:0;
        $this->output['dayEnterProfitPercent']= round(($todayEnterProfit-$yesterdayEnterProfit)/$yesterdayEnterProfit*100, 2);
        $this->output['thisMonthEnterProfit'] = $thisMonthEnterProfit?$thisMonthEnterProfit:0;
        $this->output['lastMonthEnterProfit'] = $lastMonthEnterProfit?$lastMonthEnterProfit:0;
        $this->output['monthEnterProfitPercent']= round(($thisMonthEnterProfit-$lastMonthEnterProfit)/$lastMonthEnterProfit*100, 2);
        $this->output['totalEnterProfit']     = $totalEnterProfit?$totalEnterProfit:0;

        $this->output['todayEnterTotal']     = $todayEnterTotal?$todayEnterTotal:0;
        $this->output['yesterdayEnterTotal'] = $yesterdayEnterTotal?$yesterdayEnterTotal:0;
        $this->output['thisMonthEnterTotal'] = $thisMonthEnterTotal?$thisMonthEnterTotal:0;
        $this->output['lastMonthEnterTotal'] = $lastMonthEnterTotal?$lastMonthEnterTotal:0;
        $this->output['allEnterTotal']       = $allEnterTotal?$allEnterTotal:0;
        $this->output['dayEnterPercent']   = round(($todayEnterTotal-$yesterdayEnterTotal)/$yesterdayEnterTotal*100, 2);
        $this->output['monthEnterPercent'] = round(($thisMonthEnterTotal-$lastMonthEnterTotal)/$lastMonthEnterTotal*100, 2);

        $this->output['fifteenEnterStatistic'] = json_encode(array_values($fifteenEnterStatistic));
        $this->output['fifteenEnterTotal'] = $fifteenEnterTotal;
        $this->output['fifteenEnterProfitStatistic'] = json_encode(array_values($fifteenEnterProfitStatistic));

        $where_total = [];
        $where_total[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = array('name'=>'t_es_id','oper'=>'>','value'=>0);
        $where_total[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->curr_sid);

        $allSaleGoodsRank  = $trade_model->enterShopRankStatistic($where_total, 0, 5, array('nums' => 'desc'));
        $allSaleMoneyRank  = $trade_model->enterShopRankStatistic($where_total, 0, 5, array('total' => 'desc'));
        foreach ($allSaleGoodsRank as $key => $val){
            $allSaleGoodsRank[$key]['profit'] = $inout_model->getSumOutAmount($val['es_id']);
        }

        foreach ($allSaleMoneyRank as $key => $val){
            $allSaleMoneyRank[$key]['profit'] = $inout_model->getSumOutAmount($val['es_id']);
        }
        $this->output['allSaleGoodsRank']  = $allSaleGoodsRank;
        $this->output['allSaleMoneyRank']  = $allSaleMoneyRank;

    }
    private function _get_cashier_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'cr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'cr_isrefund','oper'=>'=','value'=>0);

        $where_today[] = array('name'=>'cr_pay_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'cr_pay_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'cr_pay_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'cr_pay_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'cr_pay_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'cr_pay_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'cr_pay_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'cr_pay_time','oper'=>'<','value'=> $this->endLastMonth);

        $cash_recode= new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
        $todayCashStatistic     = $cash_recode->getSumInfo($where_today);
        $yesterdayCashStatistic = $cash_recode->getSumInfo($where_yesterday);
        $thisMonthCashStatistic = $cash_recode->getSumInfo($where_this_month);
        $totalCashStatistic     = $cash_recode->getSumInfo($where_total);

        $this->output['todayCashMoney']     = $todayCashStatistic['money']?$todayCashStatistic['money']:0;
        $this->output['yesterdayCashMoney'] = $yesterdayCashStatistic['money']?$yesterdayCashStatistic['money']:0;
        $this->output['thisMonthCashMoney'] = $thisMonthCashStatistic['money']?$thisMonthCashStatistic['money']:0;
        $this->output['totalCashMoney']     = $totalCashStatistic['money']?$totalCashStatistic['money']:0;

    }
    private function _get_goods_statistic(){
        $where_total   = $where_soldout = $where_nosale = [];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' => $this->curr_sid];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_type','oper' => 'in','value' => array(1,2)];
        if($this->wxapp_cfg['ac_type'] == 18){
            $where_total[] = $where_soldout[] = $where_nosale[]  = array('name' => 'g_kind1','oper' => '!=','value' => 1);
            $where_total[] = $where_soldout[] = $where_nosale[]  = array('name' => 'g_kind1','oper' => '!=','value' => 2);
            $where_total[] = $where_soldout[] = $where_nosale[]  = array('name' => 'g_kind2','oper' => '=','value' =>0);
        }
        $where_soldout[] = ['name' => 'g_stock','oper' => '=','value' => 0];
        $where_soldout[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $where_nosale[]  = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $totalInfo = $goods_model->getStatInfo($where_total);
        $soldout   = $goods_model->getCount($where_soldout);
        $nosale    = $goods_model->getCount($where_nosale);
        $total     = intval($totalInfo['total']);
        $sale      = intval($totalInfo['total']) - intval($soldout) - intval($nosale);


        $this->output['soldoutGoodsTotal'] = intval($soldout);
        $this->output['nosaleGoodsTotal']  = intval($nosale);
        $this->output['goodsTotal']        = intval($total);
        $this->output['saleingGoodsTotal'] = intval($sale);
    }
    private function _get_membercard_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'oo_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'oo_card_type','oper'=>'=','value'=>2);

        $where_today[] = array('name'=>'oo_pay_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'oo_pay_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'oo_pay_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'oo_pay_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'oo_pay_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'oo_pay_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'oo_pay_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'oo_pay_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_model = new App_Model_Store_MysqlOrderStorage($this->curr_sid);
        $todayVipMemberStatistic     = $order_model->getTotalAction($where_today);
        $yesterdayVipMemberStatistic = $order_model->getTotalAction($where_yesterday);
        $thisMonthVipMemberStatistic = $order_model->getTotalAction($where_this_month);
        $lastMonthVipMemberStatistic = $order_model->getTotalAction($where_last_month);

        $member_model= new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $where_total = [];
        $where_total[] = ['name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = ['name' => 'om_type', 'oper' => '=', 'value' => 2];
        $where_total[] = ['name' => 'om_expire_time', 'oper' => '>', 'value' => time()];
        $memberCount = $member_model->getCount($where_total);

        $this->output['todayVipMemberTotal']     = $todayVipMemberStatistic['total'];
        $this->output['yesterdayVipMemberTotal'] = $yesterdayVipMemberStatistic['total'];
        $this->output['dayVipMemberPercent']     = round((($todayVipMemberStatistic['total']-$yesterdayVipMemberStatistic['total'])/$yesterdayVipMemberStatistic['total'])*100, 2);
        $this->output['thisMonthVipMemberTotal'] = $thisMonthVipMemberStatistic['total'];
        $this->output['lastMonthVipMemberTotal'] = $lastMonthVipMemberStatistic['total'];
        $this->output['monthVipMemberPercent']   = round((($thisMonthVipMemberStatistic['total']-$lastMonthVipMemberStatistic['total'])/$lastMonthVipMemberStatistic['total'])*100, 2);
        $this->output['vipMemberTotal']          = $memberCount;

    }
    private function _get_recharge_statistic(){
        $where          = array();
        $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]        = array('name' => 'rr_status', 'oper' => '=', 'value' => 1);
        $where[]        = array('name' => 'rr_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where[]        = array('name' => 'rr_create_time', 'oper'=>'<', 'value'=> $this->endTime);

        $recharge_model = new App_Model_Member_MysqlRechargeStorage($this->curr_sid);
        $rechargeInfo   = $recharge_model->getAmountSumAction($where);

        return array(
            'rechargeTotal' => floatval($rechargeInfo['total']),
            'rechargeCount' => floatval($rechargeInfo['number'])
        );
    }
    private function _get_message_statistic(){
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name' => 'acfd_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $where_today[] = array('name'=>'acfd_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'acfd_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'acfd_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'acfd_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'acfd_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'acfd_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'acfd_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'acfd_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
        $totalMessage  = $data_model->getCount($where_total);
        $todayMessage  = $data_model->getCount($where_today);
        $yesterdayMessage = $data_model->getCount($where_yesterday);
        $thisMonthMessage = $data_model->getCount($where_this_month);
        $lastMonthMessage = $data_model->getCount($where_last_month);

        $this->output['todayMessage'] = $todayMessage;
        $this->output['yesterdayMessage'] = $yesterdayMessage;
        $this->output['thisMonthMessage'] = $thisMonthMessage;
        $this->output['lastMonthMessage'] = $lastMonthMessage;
        $this->output['totalMessage'] = $totalMessage;

    }
    private function _get_withdraw_statistic(){
        $where_total = [];
        $where_total[] = ['name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = ['name' => 'wd_create_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where_total[] = ['name' => 'wd_create_time', 'oper'=>'<', 'value'=> $this->endTime];

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $totalInfo = $withdraw_model->getStatInfo($where_total);

        return array(
            'totalCount' => intval($totalInfo['total']),
            'totalMoney' => floatval($totalInfo['money']),
        );
    }
    private function _get_distrib_statistic(){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $relation_storage   = new App_Model_Member_MysqlMemberRelationStorage();
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'mr_shop_id', 'oper' => '=', 'value' => $this->curr_sid];


        $where_today[] = array('name'=>'mr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'mr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'mr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'mr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'mr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'mr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'mr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'mr_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $totalStatistic = $relation_storage->getCount($where_total);
        $todayStatistic = $relation_storage->getCount($where_today);
        $yesterdayStatistic = $relation_storage->getCount($where_yesterday);
        $thisMonthStatistic = $relation_storage->getCount($where_this_month);
        $lastMonthStatistic = $relation_storage->getCount($where_last_month);

        $where_total = array();
        $where_total[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = ' ( m_1f_id != 0 OR m_is_highest = 1 ) ';
        $totalDistibMember = $member_model->getCount($where_total);

        $this->output['totalDistribMember'] = $totalDistibMember;
        $this->output['todayDistribMember'] = $todayStatistic['total'];
        $this->output['yesterdayDistribMember'] = $yesterdayStatistic['total'];
        $this->output['thisMonthDistribMember'] = $thisMonthStatistic['total'];
        $this->output['lastMonthDistribMember'] = $lastMonthStatistic['total'];
        $this->output['dayDistribMemberPercent']   = round(($todayStatistic['total'] - $yesterdayStatistic['total'])/($yesterdayStatistic['total']>0?$yesterdayStatistic['total']:1)*100, 2);
        $this->output['monthDistribMemberPercent'] = round(($thisMonthStatistic['total'] - $lastMonthStatistic['total'])/($lastMonthStatistic['total']>0?$lastMonthStatistic['total']:1)*100, 2);
    }
    private function _get_job_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where_today[] = array('name'=>'ajr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ajr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ajr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ajr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ajr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ajr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ajr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ajr_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $resume_model = new App_Model_Job_MysqlJobResumeStorage($this->curr_sid);
        $todayResumeTotal     = $resume_model->getCount($where_today);
        $yesterdayResumeTotal = $resume_model->getCount($where_yesterday);
        $thisMonthResumeTotal = $resume_model->getCount($where_this_month);
        $allResumeTotal       = $resume_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'ajr_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ajr_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenResumeList = $resume_model->getList($where_fifteen_days, 0, 0);
        $fifteenResumeStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenResumeStatistic[$val] = 0;
        }
        foreach ($fifteenResumeList as $value){
            $fifteenResumeStatistic[date('m/d', $value['ajr_create_time'])] = $fifteenResumeStatistic[date('m/d', $value['ajr_create_time'])] + 1;
        }
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where_today[] = array('name'=>'ajp_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ajp_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ajp_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ajp_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ajp_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ajp_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ajp_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ajp_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $position_model = new App_Model_Job_MysqlJobPositionStorage($this->curr_sid);
        $todayPositionTotal     = $position_model->getCount($where_today);
        $yesterdayPositionTotal = $position_model->getCount($where_yesterday);
        $thisMonthPositionTotal = $position_model->getCount($where_this_month);
        $allPositionTotal       = $position_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'ajp_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ajp_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenPositionList = $position_model->getList($where_fifteen_days, 0, 0);
        $fifteenPositionStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenPositionStatistic[$val] = 0;
        }
        foreach ($fifteenPositionList as $value){
            $fifteenPositionStatistic[date('m/d', $value['ajp_create_time'])] = $fifteenPositionStatistic[date('m/d', $value['ajp_create_time'])] + 1;
        }
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ajc_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ajc_status', 'oper' => '=', 'value' => 2];

        $where_today[] = array('name'=>'ajc_deal_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ajc_deal_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ajc_deal_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ajc_deal_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ajc_deal_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ajc_deal_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ajc_deal_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ajc_deal_time','oper'=>'<','value'=> $this->endLastMonth);

        $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->curr_sid);
        $todayCompanyTotal     = $company_model->getCount($where_today);
        $yesterdayCompanyTotal = $company_model->getCount($where_yesterday);
        $thisMonthCompanyTotal = $company_model->getCount($where_this_month);
        $allCompanyTotal       = $company_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'ajc_deal_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ajc_deal_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenCompanyList = $company_model->getList($where_fifteen_days, 0, 0);
        $fifteenCompanyStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenCompanyStatistic[$val] = 0;
        }
        foreach ($fifteenCompanyList as $value){
            $fifteenCompanyStatistic[date('m/d', $value['ajc_deal_time'])] = $fifteenCompanyStatistic[date('m/d', $value['ajc_deal_time'])] + 1;
        }
        $delivery_model=new App_Model_Job_MysqlJobSendStorage($this->curr_sid);
        $delivery_where_fifteen_days[] = array('name'=>'ajs_s_id','oper'=>'=','value'=> $this->curr_sid);
        $delivery_where_fifteen_days[] = array('name'=>'ajs_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $delivery_where_fifteen_days[] = array('name'=>'ajs_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenDeliveryList           = $delivery_model->getList($delivery_where_fifteen_days, 0, 0);
        $fifteendeliveryStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteendeliveryStatistic[$val] = 0;
        }
        foreach ($fifteenDeliveryList as $value){
            $fifteendeliveryStatistic[date('m/d', $value['ajs_create_time'])] = $fifteendeliveryStatistic[date('m/d', $value['ajs_create_time'])] + 1;
        }

        if($this->curr_sid==11380){
            Libs_Log_Logger::outputLog($delivery_where_fifteen_days,'zhangzc.log');
        }
        $this->output['fifteendeliveryStatistic']=json_encode(array_values($fifteendeliveryStatistic));

        $this->output['todayResumeTotal']       = $todayResumeTotal;
        $this->output['yesterdayResumeTotal']   = $yesterdayResumeTotal;
        $this->output['thisMonthResumeTotal']   = $thisMonthResumeTotal;
        $this->output['allResumeTotal']         = $allResumeTotal;
        $this->output['todayPositionTotal']     = $todayPositionTotal;
        $this->output['yesterdayPositionTotal'] = $yesterdayPositionTotal;
        $this->output['thisMonthPositionTotal'] = $thisMonthPositionTotal;
        $this->output['allPositionTotal']       = $allPositionTotal;
        $this->output['todayCompanyTotal']      = $todayCompanyTotal;
        $this->output['yesterdayCompanyTotal']  = $yesterdayCompanyTotal;
        $this->output['thisMonthCompanyTotal']  = $thisMonthCompanyTotal;
        $this->output['allCompanyTotal']        = $allCompanyTotal;

        $this->output['fifteenResumeStatistic'] = json_encode(array_values($fifteenResumeStatistic));
        $this->output['fifteenPositionStatistic'] = json_encode(array_values($fifteenPositionStatistic));
        $this->output['fifteenCompanyStatistic'] = json_encode(array_values($fifteenCompanyStatistic));
    }
    private function _get_workorder_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'awo_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where_today[] = array('name'=>'awo_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'awo_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'awo_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'awo_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'awo_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'awo_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'awo_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'awo_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_storage = new App_Model_Workorder_MysqlWorkOrderStorage($this->curr_sid);
        $todayWorkOrderTotal     = $order_storage->getCount($where_today);
        $yesterdayWorkOrderTotal = $order_storage->getCount($where_yesterday);
        $thisMonthWorkOrderTotal = $order_storage->getCount($where_this_month);
        $lastMonthWorkOrderTotal = $order_storage->getCount($where_last_month);
        $allWorkOrdertotal       = $order_storage->getCount($where_total);

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'awo_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'awo_status', 'oper' => '=', 'value' => 2];

        $where_today[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_storage = new App_Model_Workorder_MysqlWorkOrderStorage($this->curr_sid);
        $todayDealingWorkOrderTotal     = $order_storage->getCount($where_today);
        $yesterdayDealingWorkOrderTotal = $order_storage->getCount($where_yesterday);
        $thisMonthDealingWorkOrderTotal = $order_storage->getCount($where_this_month);
        $lastMonthDealingWorkOrderTotal = $order_storage->getCount($where_last_month);
        $allDealingWorkOrdertotal       = $order_storage->getCount($where_total);

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'awo_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'awo_status', 'oper' => '=', 'value' => 3];

        $where_today[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'awo_deal_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'awo_deal_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_storage = new App_Model_Workorder_MysqlWorkOrderStorage($this->curr_sid);
        $todayFinishWorkOrderTotal     = $order_storage->getCount($where_today);
        $yesterdayFinishWorkOrderTotal = $order_storage->getCount($where_yesterday);
        $thisMonthFinishWorkOrderTotal = $order_storage->getCount($where_this_month);
        $lastMonthFinishWorkOrderTotal = $order_storage->getCount($where_last_month);
        $allFinishWorkOrdertotal       = $order_storage->getCount($where_total);

        $this->output['todayWorkOrderTotal']     = $todayWorkOrderTotal;
        $this->output['yesterdayWorkOrderTotal'] = $yesterdayWorkOrderTotal;
        $this->output['thisMonthWorkOrderTotal'] = $thisMonthWorkOrderTotal;
        $this->output['lastMonthWorkOrderTotal'] = $lastMonthWorkOrderTotal;
        $this->output['allWorkOrdertotal']       = $allWorkOrdertotal;

        $this->output['todayDealingWorkOrderTotal']     = $todayDealingWorkOrderTotal;
        $this->output['yesterdayDealingWorkOrderTotal'] = $yesterdayDealingWorkOrderTotal;
        $this->output['dayDealingWorkOrderPercent']     = round(($todayDealingWorkOrderTotal-$yesterdayDealingWorkOrderTotal)/$yesterdayDealingWorkOrderTotal*100, 2);
        $this->output['thisMonthDealingWorkOrderTotal'] = $thisMonthDealingWorkOrderTotal;
        $this->output['lastMonthDealingWorkOrderTotal'] = $lastMonthDealingWorkOrderTotal;
        $this->output['monthDealingWorkOrderPercent']   = round(($thisMonthDealingWorkOrderTotal-$lastMonthDealingWorkOrderTotal)/$lastMonthDealingWorkOrderTotal*100, 2);
        $this->output['allDealingWorkOrdertotal']       = $allDealingWorkOrdertotal;

        $this->output['todayFinishWorkOrderTotal']      = $todayFinishWorkOrderTotal;
        $this->output['yesterdayFinishWorkOrderTotal']  = $yesterdayFinishWorkOrderTotal;
        $this->output['dayFinishWorkOrderPercent']     = round(($todayFinishWorkOrderTotal-$yesterdayFinishWorkOrderTotal)/$yesterdayFinishWorkOrderTotal*100, 2);
        $this->output['thisMonthFinishWorkOrderTotal']  = $thisMonthFinishWorkOrderTotal;
        $this->output['lastMonthFinishWorkOrderTotal']  = $lastMonthFinishWorkOrderTotal;
        $this->output['monthFinishWorkOrderPercent']    = round(($thisMonthFinishWorkOrderTotal-$lastMonthFinishWorkOrderTotal)/$lastMonthFinishWorkOrderTotal*100, 2);
        $this->output['allFinishWorkOrdertotal']        = $allFinishWorkOrdertotal;
    }
    private function _get_house_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'aha_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'aha_type', 'oper' => '=', 'value' => 1];

        $where_today[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $apply_model = new App_Model_House_MysqlHouseApplyStorage();
        $todayApplyBuyTotal     = $apply_model->getCount($where_today);
        $yesterdayApplyBuyTotal = $apply_model->getCount($where_yesterday);
        $thisMonthApplyBuyTotal = $apply_model->getCount($where_this_month);
        $lastMonthApplyBuyTotal = $apply_model->getCount($where_last_month);
        $allApplyBuyTotal       = $apply_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenApplyBuyList = $apply_model->getList($where_fifteen_days, 0, 0);
        $fifteenApplyBuyStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenApplyBuyStatistic[$val] = 0;
        }
        foreach ($fifteenApplyBuyList as $value){
            $fifteenApplyBuyStatistic[date('m/d', $value['aha_create_time'])] = $fifteenApplyBuyStatistic[date('m/d', $value['aha_create_time'])] + 1;
        }

        $this->output['todayApplyBuyTotal']       = $todayApplyBuyTotal;
        $this->output['yesterdayApplyBuyTotal']   = $yesterdayApplyBuyTotal;
        $this->output['thisMonthApplyBuyTotal']   = $thisMonthApplyBuyTotal;
        $this->output['allApplyBuyTotal']         = $allApplyBuyTotal;
        $this->output['fifteenApplyBuyStatistic'] = json_encode(array_values($fifteenApplyBuyStatistic));

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'aha_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'aha_type', 'oper' => '=', 'value' => 2];

        $where_today[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $todayApplyRentTotal     = $apply_model->getCount($where_today);
        $yesterdayApplyRentTotal = $apply_model->getCount($where_yesterday);
        $thisMonthApplyRentTotal = $apply_model->getCount($where_this_month);
        $lastMonthApplyRentTotal = $apply_model->getCount($where_last_month);
        $allApplyRentTotal       = $apply_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'aha_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'aha_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenApplyRentList = $apply_model->getList($where_fifteen_days, 0, 0);
        $fifteenApplyRentStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenApplyRentStatistic[$val] = 0;
        }
        foreach ($fifteenApplyRentList as $value){
            $fifteenApplyRentStatistic[date('m/d', $value['aha_create_time'])] = $fifteenApplyRentStatistic[date('m/d', $value['aha_create_time'])] + 1;
        }

        $this->output['todayApplyRentTotal']       = $todayApplyRentTotal;
        $this->output['yesterdayApplyRentTotal']   = $yesterdayApplyRentTotal;
        $this->output['thisMonthApplyRentTotal']   = $thisMonthApplyRentTotal;
        $this->output['allApplyRentTotal']         = $allApplyRentTotal;
        $this->output['fifteenApplyRentStatistic'] = json_encode(array_values($fifteenApplyRentStatistic));

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ahr_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ahr_sale_type', 'oper' => '=', 'value' => 1];

        $where_today[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $resources_model = new App_Model_Resources_MysqlResourcesStorage();
        $todayHouseBuyTotal     = $resources_model->getCount($where_today);
        $yesterdayHouseBuyTotal = $resources_model->getCount($where_yesterday);
        $thisMonthHouseBuyTotal = $resources_model->getCount($where_this_month);
        $lastMonthHouseBuyTotal = $resources_model->getCount($where_last_month);

        $allHouseBuyTotal       = $resources_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenHouseBuyList = $resources_model->getList($where_fifteen_days, 0, 0);
        $fifteenHouseBuyStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenHouseBuyStatistic[$val] = 0;
        }
        foreach ($fifteenHouseBuyList as $value){
            $fifteenHouseBuyStatistic[date('m/d', $value['ahr_create_time'])] = $fifteenHouseBuyStatistic[date('m/d', $value['ahr_create_time'])] + 1;
        }

        $this->output['todayHouseBuyTotal']       = $todayHouseBuyTotal;
        $this->output['yesterdayHouseBuyTotal']   = $yesterdayHouseBuyTotal;
        $this->output['thisMonthHouseBuyTotal']   = $thisMonthHouseBuyTotal;
        $this->output['allHouseBuyTotal']         = $allHouseBuyTotal;
        $this->output['fifteenHouseBuyStatistic'] = json_encode(array_values($fifteenHouseBuyStatistic));

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ahr_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = ['name' => 'ahr_sale_type', 'oper' => '=', 'value' => 2];

        $where_today[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $todayHouseRentTotal     = $resources_model->getCount($where_today);
        $yesterdayHouseRentTotal = $resources_model->getCount($where_yesterday);
        $thisMonthHouseRentTotal = $resources_model->getCount($where_this_month);
        $lastMonthHouseRentTotal = $resources_model->getCount($where_last_month);
        $allHouseRentTotal        = $resources_model->getCount($where_total);
        $where_fifteen_days[] = array('name'=>'ahr_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ahr_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenHouseRentList = $resources_model->getList($where_fifteen_days, 0, 0);
        $fifteenHouseRentStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenHouseRentStatistic[$val] = 0;
        }
        foreach ($fifteenHouseRentList as $value){
            $fifteenHouseRentStatistic[date('m/d', $value['ahr_create_time'])] = $fifteenHouseRentStatistic[date('m/d', $value['ahr_create_time'])] + 1;
        }

        $this->output['todayHouseRentTotal']       = $todayHouseRentTotal;
        $this->output['yesterdayHouseRentTotal']   = $yesterdayHouseRentTotal;
        $this->output['thisMonthHouseRentTotal']   = $thisMonthHouseRentTotal;
        $this->output['allHouseRentTotal']          = $allHouseRentTotal;
        $this->output['fifteenHouseRentStatistic'] = json_encode(array_values($fifteenHouseRentStatistic));
    }
    private function _get_sequence_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = ['name' => 'asc_s_id', 'oper' => '=', 'value' => $this->curr_sid];

        $where_today[] = array('name'=>'asc_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'asc_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'asc_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'asc_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'asc_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'asc_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'asc_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'asc_create_time','oper'=>'<','value'=> $this->endLastMonth);
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($this->curr_sid);
        $todayCommunityTotal     = $community_model->getCount($where_today);
        $yesterdayCommunityTotal = $community_model->getCount($where_yesterday);
        $thisMonthCommunityTotal = $community_model->getCount($where_this_month);
        $lastMonthCommunityTotal = $community_model->getCount($where_last_month);
        $allCommunityTotal       = $community_model->getCount($where_total);

        $this->output['todayCommunityTotal']     = $todayCommunityTotal;
        $this->output['yesterdayCommunityTotal'] = $yesterdayCommunityTotal;
        $this->output['dayCommunityPercent']     = round(($todayCommunityTotal - $yesterdayCommunityTotal)/$yesterdayCommunityTotal, 2);
        $this->output['thisMonthCommunityTotal'] = $thisMonthCommunityTotal;
        $this->output['lastMonthCommunityTotal'] = $lastMonthCommunityTotal;
        $this->output['monthCommunityPercent']   = round(($thisMonthCommunityTotal - $lastMonthCommunityTotal)/$lastMonthCommunityTotal, 2);
        $this->output['allCommunityTotal']       = $allCommunityTotal;

        $where_this_month = $where_total = [];
        $where_total[] = $where_this_month[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_this_month[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endThisMonth);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $thisMonthSaleGoodsRank = $trade_model->sequenceCommunityRankStatistic($where_this_month, 0, 5, array('nums' => 'desc'));
        $thisMonthSaleMoneyRank = $trade_model->sequenceCommunityRankStatistic($where_this_month, 0, 5, array('total' => 'desc'));

        $allSaleGoodsRank = $trade_model->sequenceCommunityRankStatistic($where_total, 0, 5, array('nums' => 'desc'));
        $allSaleMoneyRank = $trade_model->sequenceCommunityRankStatistic($where_total, 0, 5, array('total' => 'desc'));

        $this->output['thisMonthSaleGoodsRank'] = $thisMonthSaleGoodsRank;
        $this->output['thisMonthSaleMoneyRank'] = $thisMonthSaleMoneyRank;
        $this->output['allSaleGoodsRank']       = $allSaleGoodsRank;
        $this->output['allSaleMoneyRank']       = $allSaleMoneyRank;
    }
    private function _get_legwork_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'alt_status','oper'=>'in','value'=>array(3,4,5,6));
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'alt_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where_today[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->curr_sid);
        $totalOrderStatistic = $trade_model->statOrderStatistic($where_total);
        $todayOrderStatistic = $trade_model->statOrderStatistic($where_today);
        $yesterdayOrderStatistic = $trade_model->statOrderStatistic($where_yesterday);
        $thisMonthOrderStatistic = $trade_model->statOrderStatistic($where_this_month);
        $lastMonthOrderStatistic = $trade_model->statOrderStatistic($where_last_month);

        $todayOrderTotal     = $todayOrderStatistic['total']?$todayOrderStatistic['total']:0;
        $yesterdayOrderTotal = $yesterdayOrderStatistic['total']?$yesterdayOrderStatistic['total']:0;
        $thisMonthOrderTotal = $thisMonthOrderStatistic['total']?$thisMonthOrderStatistic['total']:0;
        $lastMonthOrderTotal = $lastMonthOrderStatistic['total']?$lastMonthOrderStatistic['total']:0;
        $totalOrderTotal     = $totalOrderStatistic['total']?$totalOrderStatistic['total']:0;
        $todayOrderMoney     = $todayOrderStatistic['money']?$todayOrderStatistic['money']:0;
        $yesterdayOrderMoney = $yesterdayOrderStatistic['money']?$yesterdayOrderStatistic['money']:0;
        $thisMonthOrderMoney = $thisMonthOrderStatistic['money']?$thisMonthOrderStatistic['money']:0;
        $lastMonthOrderMoney = $lastMonthOrderStatistic['money']?$lastMonthOrderStatistic['money']:0;
        $totalOrderMoney     = $totalOrderStatistic['money']?$totalOrderStatistic['money']:0;

        $totalOrderList = $trade_model->getList($where_total, 0, 0);
        $todayOrderList = $trade_model->getList($where_today, 0, 0);
        $yesterdayOrderList = $trade_model->getList($where_yesterday, 0, 0);
        $thisMonthOrderList = $trade_model->getList($where_this_month, 0, 0);
        $lastMonthOrderList = $trade_model->getList($where_last_month, 0, 0);

        $todayRiderFee     = 0;
        $yesterdayRiderFee = 0;
        $thisMonthRiderFee = 0;
        $totalRiderFee     = 0;
        foreach ($todayOrderList as $val){
            $allRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'] + $val['alt_time_fee'] + $val['alt_weight_fee'] + $val['alt_volume_fee'];
            $postPercent = floatval($val['alt_post_percent']);
            $riderFee = $postPercent > 0 ? round($allRiderFee - $allRiderFee*$postPercent/100,2) : $allRiderFee;
            $todayRiderFee += $riderFee;
        }

        foreach ($yesterdayOrderList as $val){
            $allRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'] + $val['alt_time_fee'] + $val['alt_weight_fee'] + $val['alt_volume_fee'];
            $postPercent = floatval($val['alt_post_percent']);
            $riderFee = $postPercent > 0 ? round($allRiderFee - $allRiderFee*$postPercent/100,2) : $allRiderFee;
            $yesterdayRiderFee += $riderFee;
        }

        foreach ($thisMonthOrderList as $val){
            $allRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'] + $val['alt_time_fee'] + $val['alt_weight_fee'] + $val['alt_volume_fee'];
            $postPercent = floatval($val['alt_post_percent']);
            $riderFee = $postPercent > 0 ? round($allRiderFee - $allRiderFee*$postPercent/100,2) : $allRiderFee;
            $thisMonthRiderFee += $riderFee;
        }

        foreach ($totalOrderList as $val){
            $allRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'] + $val['alt_time_fee'] + $val['alt_weight_fee'] + $val['alt_volume_fee'];
            $postPercent = floatval($val['alt_post_percent']);
            $riderFee = $postPercent > 0 ? round($allRiderFee - $allRiderFee*$postPercent/100,2) : $allRiderFee;
            $totalRiderFee += $riderFee;
        }

        $this->output['todayOrderTotal']     = $todayOrderTotal;
        $this->output['yesterdayOrderTotal'] = $yesterdayOrderTotal;
        $this->output['thisMonthOrderTotal'] = $thisMonthOrderTotal;
        $this->output['lastMonthOrderTotal'] = $lastMonthOrderTotal;
        $this->output['totalOrderTotal']     = $totalOrderTotal;

        $this->output['todayOrderMoney']     = $todayOrderMoney;
        $this->output['yesterdayOrderMoney'] = $yesterdayOrderMoney;
        $this->output['thisMonthOrderMoney'] = $thisMonthOrderMoney;
        $this->output['lastMonthOrderMoney'] = $lastMonthOrderMoney;
        $this->output['totalOrderMoney']     = $totalOrderMoney;

        $this->output['todayRiderFee']       = $todayRiderFee;
        $this->output['yesterdayRiderFee']   = $yesterdayRiderFee;
        $this->output['thisMonthRiderFee']   = $thisMonthRiderFee;
        $this->output['totalRiderFee']       = $totalRiderFee;
        $where_fifteen_days[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenOrderList = $trade_model->getList($where_fifteen_days, 0, 0);
        $fifteenOrderTotalStatistic = array();
        $fifteenOrderMoneyStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenOrderTotalStatistic[$val] = 0;
            $fifteenOrderMoneyStatistic[$val] = 0;
        }
        foreach ($fifteenOrderList as $value){
            $fifteenOrderTotalStatistic[date('m/d', $value['alt_create_time'])] = $fifteenOrderTotalStatistic[date('m/d', $value['alt_create_time'])] + 1;
            $fifteenOrderMoneyStatistic[date('m/d', $value['alt_create_time'])] = $fifteenOrderMoneyStatistic[date('m/d', $value['alt_create_time'])] + $value['alt_payment'];
        }

        $this->output['fifteenOrderTotalStatistic'] = json_encode(array_values($fifteenOrderTotalStatistic));
        $this->output['fifteenOrderMoneyStatistic'] = json_encode(array_values($fifteenOrderMoneyStatistic));
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'alt_status','oper'=>'=','value'=>7);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'alt_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where_today[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $totalCancelTotal     = $trade_model->getCount($where_total);
        $todayCancelTotal     = $trade_model->getCount($where_today);
        $yesterdayCancelTotal = $trade_model->getCount($where_yesterday);
        $thisMonthCancelTotal = $trade_model->getCount($where_this_month);
        $lastMonthCancelTotal = $trade_model->getCount($where_last_month);

        $this->output['totalCancelTotal']     = $totalCancelTotal;
        $this->output['todayCancelTotal']     = $todayCancelTotal;
        $this->output['yesterdayCancelTotal'] = $yesterdayCancelTotal;
        $this->output['dayCancelPercent']     = round(($todayCancelTotal-$yesterdayCancelTotal)/$yesterdayCancelTotal*100, 2);
        $this->output['thisMonthCancelTotal'] = $thisMonthCancelTotal;
        $this->output['lastMonthCancelTotal'] = $lastMonthCancelTotal;
        $this->output['monthCancelPercent']   = round(($thisMonthCancelTotal-$lastMonthCancelTotal)/$lastMonthCancelTotal*100, 2);


        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'alr_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where_today[] = array('name'=>'alr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'alr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'alr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'alr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'alr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'alr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'alr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'alr_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($this->curr_sid);
        $todayRiderTotal     = $rider_model->getCount($where_today);
        $yesterdayRiderTotal = $rider_model->getCount($where_yesterday);
        $thisMonthRiderTotal = $rider_model->getCount($where_this_month);
        $lastMonthRiderTotal = $rider_model->getCount($where_last_month);
        $allRiderTotal       = $rider_model->getCount($where_total);

        $this->output['todayRiderTotal']     = $todayRiderTotal;
        $this->output['yesterdayRiderTotal'] = $yesterdayRiderTotal;
        $this->output['dayRiderPercent']     = round(($todayRiderTotal-$yesterdayRiderTotal)/$yesterdayRiderTotal*100, 2);
        $this->output['thisMonthRiderTotal'] = $thisMonthRiderTotal;
        $this->output['lastMonthRiderTotal'] = $lastMonthRiderTotal;
        $this->output['monthRiderPercent']   = round(($thisMonthRiderTotal-$lastMonthRiderTotal)/$lastMonthRiderTotal*100, 2);
        $this->output['allRiderTotal']       = $allRiderTotal;
        $where_fifteen_days[] = array('name'=>'alr_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'alr_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenRiderList = $rider_model->getList($where_fifteen_days, 0, 0);
        $fifteenRiderTotalStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenRiderTotalStatistic[$val] = 0;
        }
        foreach ($fifteenRiderList as $value){
            $fifteenRiderTotalStatistic[date('m/d', $value['alr_create_time'])] = $fifteenRiderTotalStatistic[date('m/d', $value['alr_create_time'])] + 1;
        }
        $this->output['fifteenRiderTotalStatistic'] = json_encode(array_values($fifteenRiderTotalStatistic));

    }
    private function _get_meeting_statistic(){

    }
    private function _get_meal_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name' =>'t_home_id', 'oper' => '!=', 'value' => 0);

        $where_today[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $todayTableUseTotal     = $order_model->getCount($where_today);
        $yesterdayTableUseTotal = $order_model->getCount($where_yesterday);
        $thisMonthTableUseTotal = $order_model->getCount($where_this_month);
        $lastMonthTableUseTotal = $order_model->getCount($where_last_month);

        $where = array();
        $where[]    = array('name' =>'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $table_model = new App_Model_Meal_MysqlMealTableStorage($this->curr_sid);
        $tableTotal = $table_model->getCount($where);

        $this->output['todayTableUseTotal']     = $todayTableUseTotal;
        $this->output['yesterdayTableUseTotal'] = $yesterdayTableUseTotal;
        $this->output['dayTableUsePercent']     = round(($todayTableUseTotal - $yesterdayTableUseTotal)/$yesterdayTableUseTotal*100, 2);
        $this->output['thisMonthTableUseTotal'] = $thisMonthTableUseTotal;
        $this->output['lastMonthTableUseTotal'] = $lastMonthTableUseTotal;
        $this->output['monthTableUsePercent']   = round(($thisMonthTableUseTotal - $lastMonthTableUseTotal)/$lastMonthTableUseTotal*100, 2);
        $this->output['tableTotal']             = $tableTotal;
    }
    private function _get_gamebox_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'agg_s_id','oper'=>'=','value'=> $this->curr_sid);

        $where_today[] = array('name'=>'agg_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'agg_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'agg_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'agg_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'agg_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'agg_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'agg_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'agg_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->curr_sid);
        $todayGameTotal     = $game_model->getCount($where_today);
        $yesterdayGameTotal = $game_model->getCount($where_yesterday);
        $thisMonthGameTotal = $game_model->getCount($where_this_month);
        $lastMonthGameTotal = $game_model->getCount($where_last_month);
        $allGameTotal       = $game_model->getCount($where_total);

        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[]  = $where_fifteen_days[] = array('name'=>'ags_s_id','oper'=>'=','value'=> $this->curr_sid);

        $where_today[] = array('name'=>'ags_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'ags_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'ags_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'ags_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'ags_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'ags_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'ags_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'ags_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $statistic_model = new App_Model_Gamebox_MysqlGameboxStatisticStorage($this->curr_sid);
        $todayHistoryTotal     = $statistic_model->getClickSum($where_today);
        $yesterdayHistoryTotal = $statistic_model->getClickSum($where_yesterday);
        $thisMonthHistoryTotal = $statistic_model->getClickSum($where_this_month);
        $lastMonthHistoryTotal = $statistic_model->getClickSum($where_last_month);
        $allHistoryTotal       = $statistic_model->getClickSum($where_total);

        $this->output['todayGameTotal']     = $todayGameTotal?$todayGameTotal:0;
        $this->output['yesterdayGameTotal'] = $yesterdayGameTotal?$yesterdayGameTotal:0;
        $this->output['thisMonthGameTotal'] = $thisMonthGameTotal?$thisMonthGameTotal:0;
        $this->output['lastMonthGameTotal'] = $lastMonthGameTotal?$lastMonthGameTotal:0;
        $this->output['allGameTotal']       = $allGameTotal?$allGameTotal:0;

        $this->output['todayHistoryTotal']     = $todayHistoryTotal?$todayHistoryTotal:0;
        $this->output['yesterdayHistoryTotal'] = $yesterdayHistoryTotal?$yesterdayHistoryTotal:0;
        $this->output['dayGameHistoryPercent'] = round(($todayHistoryTotal - $yesterdayHistoryTotal)/($yesterdayHistoryTotal>0?$yesterdayHistoryTotal:1)*100, 2);
        $this->output['thisMonthHistoryTotal'] = $thisMonthHistoryTotal?$thisMonthHistoryTotal:0;
        $this->output['lastMonthHistoryTotal'] = $lastMonthHistoryTotal?$lastMonthHistoryTotal:0;
        $this->output['monthGameHistoryPercent'] = round(($thisMonthHistoryTotal - $lastMonthHistoryTotal)/($lastMonthHistoryTotal>0?$lastMonthHistoryTotal:1)*100, 2);
        $this->output['allHistoryTotal']       = $allHistoryTotal?$allHistoryTotal:0;
        $where_fifteen_days[] = array('name'=>'ags_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'ags_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $historyList = $statistic_model->getList($where_fifteen_days, 0, 0, array('ags_create_time' => 'ASC'));
        $fifteenHistoryStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenHistoryStatistic[$val] = 0;
        }
        foreach ($historyList as $value){
            $fifteenHistoryStatistic[date('m/d', $value['ags_create_time'])] = $fifteenHistoryStatistic[date('m/d', $value['ags_create_time'])] + $value['ags_click_num'];
        }
        $this->output['fifteenHistoryStatistic'] = json_encode(array_values($fifteenHistoryStatistic));
    }
    private function _get_reservation_statistic(){
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = $where_fifteen_days = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_meal_type','oper'=>'=','value'=> 0);

        $where_today[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endLastMonth);

        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $totalOrderStatistic = $order_model->statOrderStatistic($where_total);
        $todayOrderStatistic = $order_model->statOrderStatistic($where_today);
        $yesterdayOrderStatistic = $order_model->statOrderStatistic($where_yesterday);
        $thisMonthOrderStatistic = $order_model->statOrderStatistic($where_this_month);
        $lastMonthOrderStatistic = $order_model->statOrderStatistic($where_last_month);

        $saleReservationGoodsTotal = $totalOrderStatistic['goodsNum'];
        $saleReservationMoneyTotal = $totalOrderStatistic['money'];

        $todaySaleReservationTotal = $todayOrderStatistic['goodsNum'];
        $todaySaleReservationMoneyTotal = $todayOrderStatistic['money'];

        $yesterdaySaleReservationTotal = $yesterdayOrderStatistic['goodsNum'];
        $yesterdaySaleReservationMoneyTotal = $yesterdayOrderStatistic['money'];

        $thisMonthSaleReservationTotal = $thisMonthOrderStatistic['goodsNum'];
        $thisMonthSaleReservationMoneyTotal = $thisMonthOrderStatistic['money'];

        $lastMonthSaleReservationTotal = $lastMonthOrderStatistic['goodsNum'];

        $reservationOrderTotal          = $totalOrderStatistic['total'];
        $todayReservationOrderTotal     = $todayOrderStatistic['total'];
        $yesterdayReservationOrderTotal = $yesterdayOrderStatistic['total'];
        $thisMonthReservationOrderTotal = $thisMonthOrderStatistic['total'];
        $lastMonthReservationOrderTotal = $lastMonthOrderStatistic['total'];


        $this->output['saleReservationGoodsTotal'] = $saleReservationGoodsTotal?$saleReservationGoodsTotal:0;
        $this->output['saleReservationMoneyTotal'] = $saleReservationMoneyTotal?$saleReservationMoneyTotal:0;
        $this->output['todaySaleReservationTotal'] = $todaySaleReservationTotal?$todaySaleReservationTotal:0;
        $this->output['todaySaleReservationMoneyTotal'] = $todaySaleReservationMoneyTotal?$todaySaleReservationMoneyTotal:0;
        $this->output['yesterdaySaleReservationTotal']  = $yesterdaySaleReservationTotal?$yesterdaySaleReservationTotal:0;
        $this->output['yesterdaySaleReservationMoneyTotal'] = $yesterdaySaleReservationMoneyTotal?$yesterdaySaleReservationMoneyTotal:0;
        $this->output['daySaleReservationPercent']     = round(($todaySaleReservationTotal-$yesterdaySaleReservationTotal)/($yesterdaySaleReservationTotal>0?$yesterdaySaleReservationTotal:1)*100, 2);
        $this->output['thisMonthSaleReservationTotal'] = $thisMonthSaleReservationTotal?$thisMonthSaleReservationTotal:0;
        $this->output['thisMonthSaleReservationMoneyTotal'] = $thisMonthSaleReservationMoneyTotal?$thisMonthSaleReservationMoneyTotal:0;
        $this->output['lastMonthSaleReservationTotal'] = $lastMonthSaleReservationTotal?$lastMonthSaleReservationTotal:0;
        $this->output['monthSaleReservationPercent']   = round(($thisMonthSaleReservationTotal-$lastMonthSaleReservationTotal)/($lastMonthSaleReservationTotal>0?$lastMonthSaleReservationTotal:1)*100, 2);

        $this->output['reservationOrderTotal']          = $reservationOrderTotal;
        $this->output['todayReservationOrderTotal']     = $todayReservationOrderTotal;
        $this->output['yesterdayReservationOrderTotal'] = $yesterdayReservationOrderTotal;
        $this->output['dayReservationOrderPercent']     = round(($todayReservationOrderTotal - $yesterdayReservationOrderTotal)/($yesterdayReservationOrderTotal>0?$yesterdayReservationOrderTotal:1) * 100, 2);
        $this->output['thisMonthReservationOrderTotal'] = $thisMonthReservationOrderTotal;
        $this->output['lastMonthReservationOrderTotal'] = $lastMonthReservationOrderTotal;
        $this->output['monthReservationOrderPercent']   = round(($thisMonthReservationOrderTotal - $lastMonthReservationOrderTotal)/($lastMonthReservationOrderTotal>0?$lastMonthReservationOrderTotal:1) * 100, 2);
        $where_fifteen_days[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startFifteenDays);
        $where_fifteen_days[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endFifteenDays);
        $fifteenOrderList = $order_model->getList($where_fifteen_days);
        $fifteenReservationOrderStatistic = array();
        $fifteenSaleReservationStatistic = array();
        $fifteenSaleReservationMoneyStatistic = array();
        foreach ($this->fifteenDays as $val){
            $fifteenReservationOrderStatistic[$val] = 0;
            $fifteenSaleReservationStatistic[$val] = 0;
            $fifteenSaleReservationMoneyStatistic[$val] = 0;
        }
        foreach ($fifteenOrderList as $value){
            $fifteenReservationOrderStatistic[date('m/d', $value['t_create_time'])] = $fifteenReservationOrderStatistic[date('m/d', $value['t_create_time'])] + 1;
            $fifteenSaleReservationStatistic[date('m/d', $value['t_create_time'])] = $fifteenSaleReservationStatistic[date('m/d', $value['t_create_time'])] + $value['t_num'];
            $fifteenSaleReservationMoneyStatistic[date('m/d', $value['t_create_time'])] = $fifteenSaleReservationMoneyStatistic[date('m/d', $value['t_create_time'])] + $value['t_payment'];
        }
        $this->output['fifteenReservationOrderStatistic']     = json_encode(array_values($fifteenReservationOrderStatistic));
        $this->output['fifteenSaleReservationStatistic']      = json_encode(array_values($fifteenSaleReservationStatistic));
        $this->output['fifteenSaleReservationMoneyStatistic'] = json_encode(array_values($fifteenSaleReservationMoneyStatistic));
        $where_total   = $where_soldout = $where_nosale = [];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' => $this->curr_sid];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_type','oper' => 'in','value' => array(1,2)];
        $where_total[] = $where_soldout[] = $where_nosale[] = array('name' => 'g_kind1','oper' => '=','value' =>1);

        $where_soldout[] = ['name' => 'g_stock','oper' => '=','value' => 0];
        $where_soldout[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $where_nosale[]  = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $totalInfo = $goods_model->getStatInfo($where_total);
        $soldout   = $goods_model->getCount($where_soldout);
        $nosale    = $goods_model->getCount($where_nosale);
        $total     = intval($totalInfo['total']);
        $sale      = intval($totalInfo['total']) - intval($soldout) - intval($nosale);


        $this->output['soldoutReservationTotal'] = intval($soldout);
        $this->output['nosaleReservationTotal']  = intval($nosale);
        $this->output['reservationTotal']        = intval($total);
        $this->output['saleingReservationTotal'] = intval($sale);
        $where_total = $where_today = $where_yesterday = $where_this_month = $where_last_month = [];
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = array('name'=>'tr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where_total[] = $where_today[] = $where_yesterday[] = $where_this_month[] = $where_last_month[] = $where_fifteen_days[] = array('name'=>'t_meal_type','oper'=>'=','value'=> 0);


        $where_today[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startToday);
        $where_today[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endToday);

        $where_yesterday[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startYesterday);
        $where_yesterday[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endYesterday);

        $where_this_month[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startThisMonth);
        $where_this_month[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endThisMonth);

        $where_last_month[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startLastMonth);
        $where_last_month[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endLastMonth);
        $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->curr_sid);
        $totalRefundStatistic = $refund_model->refundOrderStatistic($where_total);
        $todayRefundStatistic = $refund_model->refundOrderStatistic($where_today);
        $yesterdayRefundStatistic = $refund_model->refundOrderStatistic($where_yesterday);
        $thisMonthRefundStatistic = $refund_model->refundOrderStatistic($where_this_month);
        $lastMonthRefundStatistic = $refund_model->refundOrderStatistic($where_last_month);

        $refundReservationTotal          = $totalRefundStatistic['total'];
        $todayReservationRefundTotal     = $todayRefundStatistic['total'];
        $yesterdayReservationRefundTotal = $yesterdayRefundStatistic['total'];
        $thisMonthReservationRefundTotal = $thisMonthRefundStatistic['total'];
        $lastMonthReservationRefundTotal = $lastMonthRefundStatistic['total'];

        $this->output['refundReservationTotal']          = $refundReservationTotal;
        $this->output['todayReservationRefundTotal']     = $todayReservationRefundTotal;
        $this->output['yesterdayReservationRefundTotal'] = $yesterdayReservationRefundTotal;
        $this->output['dayReservationRefundPercent']     = round(($todayReservationRefundTotal - $yesterdayReservationRefundTotal)/($yesterdayReservationRefundTotal>0?$yesterdayReservationRefundTotal:1) * 100, 2);
        $this->output['thisMonthReservationRefundTotal'] = $thisMonthReservationRefundTotal;
        $this->output['lastMonthReservationRefundTotal'] = $lastMonthReservationRefundTotal;
        $this->output['monthReservationRefundPercent']   = round(($thisMonthReservationRefundTotal - $lastMonthReservationRefundTotal)/($lastMonthReservationRefundTotal>0?$lastMonthReservationRefundTotal:1) * 100, 2);
    }


    public function sequenceTimeGourpOrderStatisticAction(){
        $type = $this->request->getStrParam('type', 'today');
        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);

        $dayTime = array();
        switch ($type){
            case 'today':
                $start_time = $this->startToday;
                $end_time = $this->endToday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'yesterday':
                $start_time = $this->startYesterday;
                $end_time = $this->endYesterday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'week':
                $start_time = strtotime('-7 days', strtotime(date('Y-m-d')));
                $end_time  = time();
                for($i=6; $i>0; $i--){
                    $dayTime[] = date('m/d', strtotime('-'.$i.' days', strtotime(date('Y-m-d'))));
                }
                $dayTime[] = date('m/d', strtotime(date('Y-m-d')));
                break;
            case 'month':
                $start_time = $this->startThisMonth;
                $end_time = $this->endThisMonth;
                for($i=0; $i<31; $i++){
                    if(strtotime('+'.$i.' days', strtotime(date('Y-m'))) < strtotime('+1 month', strtotime(date('Y-m')))){
                        $dayTime[] = date('m/d', strtotime('+'.$i.' days', strtotime(date('Y-m'))));
                    }
                }
                break;
        }
        $where_days[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $start_time);
        $where_days[] = array('name'=>'t_create_time','oper'=>'<','value'=> $end_time);
        $where_days[] = array('name'=>'t_s_id','oper'=>'=','value'=> $this->curr_sid);
        $where_days[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where_days[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );

        if($type == 'today' || $type == 'yesterday'){
            $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByTime($where_days);
        }else{
            $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByDate($where_days);
        }
        $orderStatistic = array();
        $saleGoodsStatistic = array();
        $saleMoneyStatistic = array();
        foreach ($dayTime as $val){
            $orderStatistic[$val] = 0;
            $saleGoodsStatistic[$val] = 0;
            $saleMoneyStatistic[$val] = 0;
        }
        foreach ($totalMoneyNum as $value){
            $orderStatistic[$value['curr_date']] = $value['total'];
            $saleGoodsStatistic[$value['curr_date']] = $value['goodsNum'];
            $saleMoneyStatistic[$value['curr_date']] = $value['money'];
        }
        if($type == 'month'){
            foreach ($dayTime as &$item){
                $item = explode('/', $item)[1];
            }
        }
        if($type == 'today' || $type == 'yesterday'){
            foreach ($dayTime as &$item){
                $item = $item.":00";
            }
        }
        $data['dayTime'] = $dayTime;
        $data['orderStatistic'] = array_values($orderStatistic);
        $data['saleGoodsStatistic'] = array_values($saleGoodsStatistic);
        $data['saleMoneyStatistic'] = array_values($saleMoneyStatistic);
        $this->displayJsonSuccess($data);
    }

    public function cityTimeGourpGoodsPostProfitStatisticAction(){
        $type = $this->request->getStrParam('type', 'goods');
        $time = $this->request->getStrParam('time', 'today');

        $dayTime = array();
        switch ($time){
            case 'today':
                $start_time = $this->startToday;
                $end_time = $this->endToday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'yesterday':
                $start_time = $this->startYesterday;
                $end_time = $this->endYesterday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'week':
                $start_time = strtotime('-7 days', strtotime(date('Y-m-d')));
                $end_time  = time();
                for($i=6; $i>0; $i--){
                    $dayTime[] = date('m/d', strtotime('-'.$i.' days', strtotime(date('Y-m-d'))));
                }
                $dayTime[] = date('m/d', strtotime(date('Y-m-d')));
                break;
            case 'month':
                $start_time = $this->startThisMonth;
                $end_time = $this->endThisMonth;
                for($i=0; $i<31; $i++){
                    if(strtotime('+'.$i.' days', strtotime(date('Y-m'))) < strtotime('+1 month', strtotime(date('Y-m')))){
                        $dayTime[] = date('m/d', strtotime('+'.$i.' days', strtotime(date('Y-m'))));
                    }
                }
                break;
        }

        $data['dayTime'] = $dayTime;

        if($type == 'goods'){
            $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $where_days[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $start_time);
            $where_days[] = array('name'=>'t_create_time','oper'=>'<','value'=> $end_time);
            $where_days[] = array('name'=>'t_s_id','oper'=>'=','value'=> $this->curr_sid);
            $where_days[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
            $where_days[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );

            if($time == 'today' || $time == 'yesterday'){
                $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByTime($where_days);
            }else{
                $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByDate($where_days);
            }
            $saleGoodsStatistic = array();
            foreach ($dayTime as $val){
                $saleGoodsStatistic[$val] = 0;
            }
            foreach ($totalMoneyNum as $value){
                $saleGoodsStatistic[$value['curr_date']] = $value['goodsNum'];
            }
            if($type == 'month'){
                foreach ($dayTime as &$item){
                    $item = explode('/', $item)[1];
                }
            }
            if($type == 'today' || $type == 'yesterday'){
                foreach ($dayTime as &$item){
                    $item = $item.":00";
                }
            }
            $data['saleGoodsStatistic'] = array_values($saleGoodsStatistic);
        }

        if($type == 'post'){
            $where_days   = array();
            $where_days[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
            $where_days[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);

            $where_days[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $start_time);
            $where_days[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $end_time);

            $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
            if($time == 'today' || $time == 'yesterday'){
                $profitMoney = $pay_model->fetchPostProfitGroupByTime($where_days);
            }else{
                $profitMoney = $pay_model->fetchPostProfitGroupByDate($where_days);
            }

            $profitStatistic = array();
            foreach ($dayTime as $val){
                $profitStatistic[$val] = 0;
            }
            foreach ($profitMoney as $value){
                $profitStatistic[$value['curr_date']] =(($type == 'post')?$value['total']: $value['goodsNum']);
            }
            if($type == 'month'){
                foreach ($dayTime as &$item){
                    $item = explode('/', $item)[1];
                }
            }
            if($type == 'today' || $type == 'yesterday'){
                foreach ($dayTime as &$item){
                    $item = $item.":00";
                }
            }
            $data['profitStatistic'] = array_values($profitStatistic);
        }

        $this->displayJsonSuccess($data);
    }

    public function cityTimeGourpEnterSaleProfitStatisticAction(){
        $type = $this->request->getStrParam('type', 'enter');
        $time = $this->request->getStrParam('time', 'today');

        $dayTime = array();
        switch ($time){
            case 'today':
                $start_time = $this->startToday;
                $end_time = $this->endToday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'yesterday':
                $start_time = $this->startYesterday;
                $end_time = $this->endYesterday;
                for($i=0; $i<24; $i++){
                    $dayTime[] = ($i>9?$i:'0'.$i);
                }
                break;
            case 'week':
                $start_time = strtotime('-7 days', strtotime(date('Y-m-d')));
                $end_time  = time();
                for($i=6; $i>0; $i--){
                    $dayTime[] = date('m/d', strtotime('-'.$i.' days', strtotime(date('Y-m-d'))));
                }
                $dayTime[] = date('m/d', strtotime(date('Y-m-d')));
                break;
            case 'month':
                $start_time = $this->startThisMonth;
                $end_time = $this->endThisMonth;
                for($i=0; $i<31; $i++){
                    if(strtotime('+'.$i.' days', strtotime(date('Y-m'))) < strtotime('+1 month', strtotime(date('Y-m')))){
                        $dayTime[] = date('m/d', strtotime('+'.$i.' days', strtotime(date('Y-m'))));
                    }
                }
                break;
        }

        $data['dayTime'] = $dayTime;

        if($type == 'money'){
            $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $where_days[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $start_time);
            $where_days[] = array('name'=>'t_create_time','oper'=>'<','value'=> $end_time);
            $where_days[] = array('name'=>'t_s_id','oper'=>'=','value'=> $this->curr_sid);
            $where_days[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
            $where_days[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );

            if($time == 'today' || $time == 'yesterday'){
                $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByTime($where_days);
            }else{
                $totalMoneyNum = $order_model->fetchTradeTotalNumMoneyGroupByDate($where_days);
            }
            $saleMoneyStatistic = array();
            foreach ($dayTime as $val){
                $saleMoneyStatistic[$val] = 0;
            }
            foreach ($totalMoneyNum as $value){
                $saleMoneyStatistic[$value['curr_date']] = $value['money'];
            }
            if($type == 'month'){
                foreach ($dayTime as &$item){
                    $item = explode('/', $item)[1];
                }
            }
            if($type == 'today' || $type == 'yesterday'){
                foreach ($dayTime as &$item){
                    $item = $item.":00";
                }
            }
            $data['saleMoneyStatistic'] = array_values($saleMoneyStatistic);
        }

        if($type == 'enter'){
            $where_days   = array();
            $where_days[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 2);
            $where_days[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);

            $where_days[] = array('name'=>'cpp_create_time','oper'=>'>=','value'=> $start_time);
            $where_days[] = array('name'=>'cpp_create_time','oper'=>'<','value'=> $end_time);

            $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
            if($time == 'today' || $time == 'yesterday'){
                $profitMoney = $pay_model->fetchPostProfitGroupByTime($where_days);
            }else{
                $profitMoney = $pay_model->fetchPostProfitGroupByDate($where_days);
            }

            $profitStatistic = array();
            foreach ($dayTime as $val){
                $profitStatistic[$val] = 0;
            }
            foreach ($profitMoney as $value){
                $profitStatistic[$value['curr_date']] = $value['goodsNum'];
            }
            if($type == 'month'){
                foreach ($dayTime as &$item){
                    $item = explode('/', $item)[1];
                }
            }
            if($type == 'today' || $type == 'yesterday'){
                foreach ($dayTime as &$item){
                    $item = $item.":00";
                }
            }
            $data['profitStatistic'] = array_values($profitStatistic);
        }

        if($type == 'cashier'){
            $where_days   = array();
            $where_days[] = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $this->curr_sid);

            $where_days[] = array('name'=>'cr_pay_time','oper'=>'>=','value'=> $start_time);
            $where_days[] = array('name'=>'cr_pay_time','oper'=>'<','value'=> $end_time);

            $cash_model= new App_Model_Cash_MysqlRecordStorage($this->curr_sid);
            if($time == 'today' || $time == 'yesterday'){
                $profitMoney = $cash_model->fetchCashierProfitGroupByTime($where_days);
            }else{
                $profitMoney = $cash_model->fetchCashierProfitGroupByDate($where_days);
            }

            $profitStatistic = array();
            foreach ($dayTime as $val){
                $profitStatistic[$val] = 0;
            }
            foreach ($profitMoney as $value){
                $profitStatistic[$value['curr_date']] = $value['total'];
            }
            if($type == 'month'){
                foreach ($dayTime as &$item){
                    $item = explode('/', $item)[1];
                }
            }
            if($type == 'today' || $type == 'yesterday'){
                foreach ($dayTime as &$item){
                    $item = $item.":00";
                }
            }
            $data['cashierStatistic'] = array_values($profitStatistic);
        }

        $this->displayJsonSuccess($data);
    }

}