<?php


class App_Controller_Console_ServiceController extends Libs_Mvc_Controller_ConsoleController {
    public function __construct() {
        parent::__construct();
    }


    public function ceshiAction(){
        Libs_Log_Logger::outputLog(111,'console.log');
    }


    //订单到期处理
    public function tradeExpireAction(){
        $time        = time();//每天23:59的时间戳
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $where[]     = array('name'=>"rt_status",'oper'=>'=','value'=>2);
        $where[]     = array('name'=>"rt_end_time",'oper'=>'<','value'=>$time);
        $list        = $trade_model->getList($where,0,0,array());
        $house_model = new App_Model_Resources_MysqlResourcesStorage();
        foreach ($list as $val){
            $update['rt_status'] = 3;
            $trade_model->updateById($update,$val['rt_id']);
            if($val['rt_type'] == 1){  //如果是园区服务  到期库存要加一
                $house = $house_model->getRowById($val['rt_g_id']);
                $h_update['ahr_stock'] = $house['ahr_stock'] + 1;
                $house_model->updateById($h_update,$val['rt_g_id']);
            }
        }
    }

}