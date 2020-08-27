<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/23
 * Time: 下午11:19
 */

class App_Controller_Console_ShopController extends Libs_Mvc_Controller_ConsoleController {

    private $auto_log   = "auto-shop.log";

    public function __construct() {
        parent::__construct();
    }

    public function testAction() {
        $sid    = plum_get_int_param('sid');
        $mid    = plum_get_int_param('mid');

        $member_helper  = new App_Helper_MemberLevel();
        $ret = $member_helper->isRealMember($sid, $mid);
        Libs_Log_Logger::outputConsoleLog($ret);
    }

    /*
     * 获取有赞新创建的订单，定时任务，每五分钟执行一次
     */
    public function fetchYouzanOrderAction() {
        Libs_Log_Logger::outputLog("定时获取有赞店铺新创建订单", $this->auto_log);
        $list   = $this->_fetch_youzan_shop();

        foreach ($list as $item) {
            Libs_Log_Logger::outputLog("获取有赞店铺{$item['s_name']}新创建订单", $this->auto_log);
            $oauth_client   = new App_Plugin_Youzan_OauthClient($item['s_id']);
            $oauth_client->getNewSoldTrades();
        }
    }

    /*
     * 检查店铺订单
     * 按店铺，更新待付款1，待完成2
     */
    public function checkYouzanOrderAction() {
        Libs_Log_Logger::outputLog("定时获取有赞店铺状态更新的订单", $this->auto_log);
        $list   = $this->_fetch_youzan_shop();

        foreach ($list as $item) {
            $redis_order    = new App_Model_Shop_RedisOrderStatusStorage($item['s_id']);
            //获取所有等待更新状态的订单
            $orders         = $redis_order->getAllTidFromHash();
            Libs_Log_Logger::outputLog("定时获取有赞店铺{$item['s_name']}状态更新的订单，数量=".count($orders), $this->auto_log);
            $oauth_client   = new App_Plugin_Youzan_OauthClient($item['s_id']);

            foreach ($orders as $tid => $status) {
                $oauth_client->getTradeOnly($tid, $status);
            }
        }
    }

    /*
     * 获取有赞店铺列表
     */
    private function _fetch_youzan_shop() {
        $shop_type      = plum_parse_config('shop_type', 'app');
        $youzan_t       = $shop_type['youzan'];

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $where[]        = array('name' => 's_type', 'oper' => '=', 'value' => $youzan_t);

        $shop_list      = $shop_storage->getList($where, 0, 0);

        return $shop_list;
    }

    /*
     * 拉取授权有赞店铺的微信粉丝
     * @废弃 不再自动拉取粉丝信息，可由店铺管理员手动拉取
     */
    public function pullYouzanFansAction() {
        $redis_shop_storage = new App_Model_Shop_RedisShopQueueStorage();
        //获取新授权店铺id
        $sid = $redis_shop_storage->popSidFromQueue();

        if ($sid) {
            $oauth_client   = new App_Plugin_Youzan_OauthClient($sid);
            $oauth_client->pullWeixinFollowers();
        } else {
            Libs_Log_Logger::outputLog("没有新授权店铺，未能获取微信粉丝", $this->auto_log);
        }
    }

    public function pullFansBySidAction() {
        $sid    = plum_get_param('sid');

        $oauth_client   = new App_Plugin_Youzan_OauthClient($sid);
        $oauth_client->pullWeixinFollowers();
    }

    /*
     * 修复订单
     * 执行示例：php /alidata/www/sale/scripts/console.php "shop/restoreOrder" sid=12 tid=E20160420080704071395125
     */
    public function restoreOrderAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $oauth_client   = new App_Plugin_Youzan_OauthClient($sid);
        $oauth_client->getSingleTrade($tid);
    }

    /*
     * 排查订单
     * 执行示例：php /alidata/www/sale/scripts/console.php "shop/screenOrder" sid=12 tid=E20160420080704071395125
     */
    public function screenOrderAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $oauth_client   = new App_Plugin_Youzan_OauthClient($sid);
        $oauth_client->getTradeOnly($tid);
    }
    /*
     * 完成超时未完成订单
     */
    public function finishTradeAction() {
        set_time_limit(0);
        $over_time      = plum_parse_config('trade_overtime');
        //超时未完成订单时间==当前时间前推7天,再前推1小时,避免重复处理
        $end_time       = time() - $over_time['finish'] - 60*60;
        $trade_model    = new App_Model_Trade_MysqlTradeStorage();
        $sort       = array('t_id' => 'ASC');
        $field      = array('t_id', 't_s_id', 't_tid', 't_finish_check_long', 't_express_time');
        $index      = 0;
        $count      = 50;
        $noGet      = array();
        //首先处理未延长收货订单
        $where      = array();
        $where[0]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_SHIP);//待收货状态
        //$where[]    = array('name' => 't_express_time', 'oper' => '<', 'value' => $end_time);
        $where[1]    = array('name' => 't_express_method', 'oper' => '!=', 'value' => 2);//非门店自提订单
        $where[2]    = array('name' => 't_had_extend', 'oper' => '=', 'value' => 0);//未延长收货
        $where[4]    = array('name' => 't_fd_status', 'oper' => 'in', 'value' => [0,3]);//未延长收货

        Libs_Log_Logger::outputLog("未延长收货订单任务在执行");
        do {
            if(!empty($noGet)){
                $where[3]    = array('name' => 't_id', 'oper' => 'not in', 'value' => $noGet);
            }
            $list   = $trade_model->getList($where, $index, $count, $sort, $field);
            foreach ($list as $item) {
                if((time() - ($item['t_finish_check_long']?$item['t_finish_check_long']:$over_time['finish']) - 60*60) > $item['t_express_time']){
                    Libs_Log_Logger::outputLog("超时订单{$item['t_tid']}在处理中");
                    $trade_helper   = new App_Helper_Trade($item['t_s_id']);
                    $trade_helper->completeOvertimeTrade($item['t_id']);
                }else{
                    $noGet[] = $item['t_id'];
                }
            }
            
        }while(count($list) == $count);

        $noGet      = array();
        //处理延长收货订单
        $end_time   = $end_time - $over_time['extend'];
        $where      = array();
        $where[0]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_SHIP);//待收货状态
        //$where[]    = array('name' => 't_express_time', 'oper' => '<', 'value' => $end_time);
        $where[1]    = array('name' => 't_express_method', 'oper' => '!=', 'value' => 2);//非门店自提订单
        $where[2]    = array('name' => 't_had_extend', 'oper' => '=', 'value' => 1);//延长收货

        Libs_Log_Logger::outputLog("延长收货订单任务在执行");
        do {
            if(!empty($noGet)){
                $where[3]    = array('name' => 't_id', 'oper' => 'not in', 'value' => $noGet);
            }
            $list   = $trade_model->getList($where, $index, $count, $sort, $field);
            foreach ($list as $item) {
                if((time() - ($item['t_finish_check_long']?$item['t_finish_check_long']:$over_time['finish']) - 60*60 - $over_time['extend']) > $item['t_express_time']) {
                    Libs_Log_Logger::outputLog("超时订单{$item['t_tid']}在处理中");
                    $trade_helper = new App_Helper_Trade($item['t_s_id']);
                    $trade_helper->completeOvertimeTrade($item['t_id']);
                }else{
                    $noGet[] = $item['t_id'];
                }
            }

        }while(count($list) == $count);
    }
    /*
     * 关闭超时未支付订单
     */
    public function closeTradeAction() {
        set_time_limit(0);
        $over_time      = plum_parse_config('trade_overtime');
        //超时未支付订单时间==当前时间前推1小时,再前推5分钟,避免重复处理
        //$end_time       = time() - $over_time['close'] - 5*60;
        $trade_model    = new App_Model_Trade_MysqlTradeStorage();
        $sort       = array('t_id' => 'ASC');
        $field      = array('t_id', 't_s_id', 't_tid', 't_create_time');
        $index      = 0;
        $count      = 50;
        $searchId   = array();
        //首先处理未延长收货订单
        $where      = array();
        // $where[0]    = array('name' => 't_status', 'oper' => '<', 'value' => App_Helper_Trade::TRADE_WAIT_PAY_RETURN);//未支付状态
        $where[0]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_NO_PAY);//未支付状态
        
        //$where[]    = array('name' => 't_create_time', 'oper' => '<', 'value' => $end_time);
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        Libs_Log_Logger::outputLog("未支付订单任务在执行");
        do {
            if($searchId){
                $where[1] = array('name' => 't_id', 'oper' => 'not in', 'value' => $searchId);
            }
            $list   = $trade_model->getList($where, $index, $count, $sort, $field);
            
            foreach ($list as $item) {
                $shop = $shop_storage->getRowById($item['t_s_id']);
                $overTime = $shop['s_close_trade'] && $shop['s_close_trade'] > 0 ? $shop['s_close_trade']*60 : $over_time['close'];
                $end_time       = time() - $overTime - 5*60;
                if($item['t_create_time']<$end_time){
                    Libs_Log_Logger::outputLog("未支付订单{$item['t_tid']}在处理中");
                    $trade_helper   = new App_Helper_Trade($item['t_s_id']);
                    $trade_helper->closeOvertimeTrade($item['t_id']);
                }else{
                    $searchId[] = $item['t_id'];
                }
            }

        }while(count($list) == $count);
    }


    public function watchdogAction(){
        $watch_dog = new App_Model_Watchdog_MysqlWatchDogStorage();
        Libs_Log_Logger::outputLog('清空watchdog','test.log');
        Libs_Log_Logger::outputLog(date('Y-m-d H:i:s'),'test.log');
        $res = $watch_dog->truncateRecord();
    }

}