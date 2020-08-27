<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 17/3/16
 * Time: 上午9:34
 */
class App_Controller_Wxapp_OrderCommonController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }

    /**
     * @param array $where
     * @param int $needExpress
     * @param int $isrefund
     * 商城订单，维权列表，积分订单，抽奖订单，通用方法
     */
    public function show_trade_list_data($where= array(),$needExpress=1,$isrefund=0,$type=0,$hideLink = 0){
//        if(in_array($this->wxapp_cfg['ac_type'],[21])){
//            $output['status'] = $this->request->getStrParam('status','hadpay');
//        }else{
//            $output['status'] = $this->request->getStrParam('status','all');
//        }
        $output['status'] = $this->request->getStrParam('status','all');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货'
        );
        //社区团购没有快递发货
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            unset($expressMethod[3]);
        }
        $output['expressMethod'] = $expressMethod;

//        //获取配置信息
//        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
//        $cfg        = $applet_cfg->findShopCfg();

        // 是否为维权订单
        if($isrefund==1){
            //table上导航链接
            $link = App_Helper_Trade::$trade_refund_link_status;
            // 订单维权状态
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_feedback','oper'=>'=','value'=>$link[$output['status']]['id']);
            }
        }else{
            //table上导航链接
            $link = App_Helper_Trade::$trade_link_status;
            //没有开通拼团购的，则不显示拼团菜单
            $group_model = new App_Model_Group_MysqlCfgStorage($this->curr_sid);
            $group       = $group_model->getRowUpdata();
            if(empty($group) && $this->wxapp_cfg['ac_type'] != 2 && $this->wxapp_cfg['ac_type'] != 6 && $this->wxapp_cfg['ac_type'] != 8 && $this->wxapp_cfg['ac_type'] != 21 && $this->wxapp_cfg['ac_type'] != 27 && $this->wxapp_cfg['ac_type'] != 9 && $this->wxapp_cfg['ac_type'] != 12 && $this->wxapp_cfg['ac_type'] != 18) unset($link['tuan']);

            //培训版订单没有 支付 退款状态
            if($this->wxapp_cfg['ac_type'] == 12){
                unset($link['hadpay']);
                unset($link['refund']);
            }
            //社区团购没哟
            if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                $link['hadpay']['label'] = '已付款';
                $link['finish']['label'] = '已完成';
                $link['refund']['label'] = '退款';
                unset($link['tuan']);
                unset($link['ship']);
            }

            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] == 0 && $type == App_Helper_Trade::TRADE_AUCTION){
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>1);
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>7);
            }
            // 订单状态
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$output['status']]['id']);
            }elseif($output['status'] == 'winNOPay'){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>11);
            }
        }
        if(!$hideLink){
            $this->output['link'] = $link;
        }

        $this->output['statusNote'] = plum_parse_config('trade_status');
        $this->output['legworkStatusNote'] = App_Helper_Legwork::$trade_status_note;
        $this->output['trade_screen'] = plum_parse_config('trade_screen');
        //@todo 获取物流列表，供发货使用,全部状态下或待发货状态下
        if(in_array($output['status'],array('all','hadpay')) && $needExpress){
            $express_model  = new App_Model_Trade_MysqlExpressStorage();
            $express = $express_model->getExpressList(1);
        }else{
            $express = array();
        }
        $this->output['express'] = $express;

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sort       = array('t_create_time' => 'DESC');
        //检索条件整理

        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_status','oper'=>'>','value'=>0);
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[]= array('name'=>'t_title','oper'=>'like','value'=>"%{$output['title']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[]= array('name'=>'t_tid','oper'=>'=','value'=>$output['tid']);
        }
        $output['buyer']  = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]= array('name'=>'t_buyer_nick','oper'=>'like','value'=>"%{$output['buyer']}%");
        }
        $output['harvest']  = $this->request->getStrParam('harvest');
        if($output['harvest']){
            $where[]= array('name'=>'ma_name','oper'=>'like','value'=>"%{$output['harvest']}%");
        }
        $output['phone']  = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]= array('name'=>'ma_phone','oper'=>'=','value'=>$output['phone']);
        }
        //酒店搜索
        $output['mobile']  = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[]= array('name'=>'t_express_code','oper'=>'=','value'=>$output['mobile']);
        }
        $output['realName']  = $this->request->getStrParam('realName');
        if($output['realName']){
            $where[]= array('name'=>'t_express_company','oper'=>'like','value'=>"%{$output['realName']}%");
        }
        if(!$type){
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        }else{
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>$type);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        //门店id
        $output['esId'] = $this->request->getIntParam('esId',0);
        if($output['esId'] > 0){
             $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => $output['esId']);
        }elseif ($output['esId'] < 0){
            $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        }
        $output['postType'] = $this->request->getIntParam('postType',0);
        if($output['postType'] > 0){
            $where[]    = array('name' => 't_express_method', 'oper' => '=', 'value' => $output['postType']);
        }
        //自提门店id
        $output['osId'] = $this->request->getIntParam('osId',0);
        if($output['osId'] > 0){
            $where[]    = array('name' => 't_store_id', 'oper' => '=', 'value' => $output['osId']);
            if($this->wxapp_cfg['ac_type'] != 18){
                $output['postType'] = 2; //有自提门店即为门店自取
            }
        }
        //小区名称
        $output['community'] = $this->request->getStrParam('community','');
        if($output['community']){
            $where[]= array('name'=>'asc_name','oper'=>'like','value'=>"%{$output['community']}%");
        }
        //团长名称
        $output['leader'] = $this->request->getStrParam('leader','');
        if($output['leader']){
            $where[]= array('name'=>'asl_name','oper'=>'like','value'=>"%{$output['leader']}%");
        }
        //活动名称
        $output['activity'] = $this->request->getStrParam('activity','');
        if($output['activity']){
            $where[]= array('name'=>'asa_title','oper'=>'like','value'=>"%{$output['activity']}%");
        }
        //活动名称
        $output['groupId'] = $this->request->getIntParam('groupId','');
        if($output['groupId'] > 0){
            $where[]= array('name'=>'asg_id','oper'=>'=','value'=>$output['groupId']);
        }

        $output['tradeScreen'] = $this->request->getStrParam('tradeScreen','valid');
        if($output['tradeScreen'] && $output['status'] != 'closed'){
            switch ($output['tradeScreen']){
                case 'valid':
                    $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
                case 'close':
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
            }
        }

        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE);
        //分页，列表数据展示
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total       = $trade_model->getAddressCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        $list     = array();
        $trader   = array();
        if($total > $index){
            $list = $trade_model->getAddressList($where,$index,$this->count,$sort);
            //@todo 根据订单ID获取交易详情，并统计本次交易产生订单数量
            $ids  = array();
            $store_storage = new App_Model_Cake_MysqlCakeStoreStorage($this->curr_sid);
            foreach($list as $key=>$val){
                $ids[] = $val['t_id'];
                if($val['t_store_id']){ 
                    $store  = $store_storage->getRowById($val['t_store_id']);
                    $list[$key]['storeName'] = $store['acs_name']; 
                }
            }
            $trade_order    = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $temp   =  $trade_order->getListByGoIds($ids);
            foreach($temp as $val){
                if(isset($trader[$val['to_t_id']]['count'])){
                    $trader[$val['to_t_id']]['count'] ++ ;
                }else{
                    $trader[$val['to_t_id']]['count']  = 1;
                }
                $trader[$val['to_t_id']]['data'][] = $val;
            }
        }
        $output['trader'] = $trader;
        //餐饮外卖的，如果为单店，显示第一个店铺的名称
        if($this->wxapp_cfg['ac_type'] == 4){
            //获取第一个分店信息
            $where      = array();
            $where[]    = array('name' => 'ams_s_id','oper' => '=','value' =>$this->curr_sid);
            $sort = array('ams_create_time' => 'ASC');
            $store_model    = new App_Model_Meal_MysqlMealStoreStorage($this->curr_sid);
            $store_list = $store_model->fetchStoreList($where,0,1,$sort);
            $store_info = $store_list[0];
        }
        $date_now = date('Y-m-d');
        foreach ($list as $key=>$val){
            $list[$key]['t_remark_extra'] = json_decode($val['t_remark_extra'], true);
            //餐饮外卖的，如果为单店，显示第一个店铺的名称
            if($this->wxapp_cfg['ac_type'] == 4) {
                $list[$key]['es_name'] = $list[$key]['es_name'] ? $list[$key]['es_name'] : $store_info['es_name'];
            }
            if($val['t_legwork_num'] > 0){
                if(date('Y-m-d',$val['t_pay_time']) == $date_now){
                    $list[$key]['legworkNum'] = '今日 '.$val['t_legwork_num'].'号';
                }else{
                    $list[$key]['legworkNum'] = date('Y年m月d日').$val['t_legwork_num'].'号';
                }
            }
        }
        $output['list']   = $list;

        if($isrefund){
            //获得退款订单统计信息
            if(in_array($this->wxapp_cfg['ac_type'],[4,7])){
                $independent = 1;
            }else{
                $independent = 0;
            }
            $where_total = $where_going = $where_done = [];
            $where_total[] = $where_going[] = $where_done[] = ['name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid];
            $where_total[] = $where_going[] = $where_done[] = ['name'=>'t_status','oper'=>'>','value'=>0];
            $where_total[] = $where_going[] = $where_done[] =['name'=>'t_feedback','oper'=>'!=','value'=>0];
            $where_total[] = $where_going[] = $where_done[] =['name'=>'t_independent_mall','oper'=>'=','value'=>$independent];
            $where_going[] = ['name'=>'t_feedback','oper'=>'=','value'=>1];
            $where_done[] = ['name'=>'t_fd_result','oper'=>'=','value'=>2];
            $refund_total = $trade_model->getCount($where_total);
            $going = $trade_model->getCount($where_going);
            $done = $trade_model->getCount($where_done);
            $output['statInfo'] = [
                'total' => intval($refund_total),
                'going' => intval($going),
                'done'  => intval($done)
            ];
        }
        $this->showOutput($output);
    }

    /**
     * 统计订单信息
     */
    protected function _show_order_stat($where,$today = true){
        if($today){
            $time = strtotime(date('Y-m-d',time())); // 获取今天0点的时间
            $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$time);
        }

        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $order_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        return $order_model->statOrderStatistic($where);
    }

    /*
     * 获得自提门店
     */
    protected function _get_offline_store($delivery = false){
        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $sort = array('os_create_time' => 'DESC');
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        if($delivery){
            $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
        }
        $list = $store_model->getList($where,0,0,$sort,array(),true);
        //列表数据
        $this->output['storeSelect'] = $list ? $list : array();
    }


    public function show_mall_trade_list_data($where= array(),$needExpress=1,$isrefund=0,$type=0){
       // if(in_array($this->wxapp_cfg['ac_type'],[21])){
       //     $output['status'] = $this->request->getStrParam('status','hadpay');
       // }else{
       //     $output['status'] = $this->request->getStrParam('status','all');
       // }
        $output['status'] = $this->request->getStrParam('status','all');
        $expressMethod = array(
            1 => '商家配送',
            2 => '门店自取',
            3 => '快递发货'
        );
        //社区团购没有快递发货
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
            unset($expressMethod[3]);
        }
        $output['expressMethod'] = $expressMethod;

       // //获取配置信息
       // $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
       // $cfg        = $applet_cfg->findShopCfg();

        // 是否为维权订单
        if($isrefund==1){
            //table上导航链接
            $link = App_Helper_Trade::$trade_refund_link_status;
            // 订单维权状态
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_feedback','oper'=>'=','value'=>$link[$output['status']]['id']);
            }
        }else{
            //table上导航链接
            $link = App_Helper_Trade::$trade_link_status;
            //没有开通拼团购的，则不显示拼团菜单
            $group_model = new App_Model_Group_MysqlCfgStorage($this->curr_sid);
            $group       = $group_model->getRowUpdata();
            if(empty($group) && $this->wxapp_cfg['ac_type'] != 2 && $this->wxapp_cfg['ac_type'] != 6 && $this->wxapp_cfg['ac_type'] != 8 && $this->wxapp_cfg['ac_type'] != 21 && $this->wxapp_cfg['ac_type'] != 27 && $this->wxapp_cfg['ac_type'] != 9 && $this->wxapp_cfg['ac_type'] != 12 && $this->wxapp_cfg['ac_type'] != 18) unset($link['tuan']);

            //培训版订单没有 支付 退款状态
            if($this->wxapp_cfg['ac_type'] == 12){
                unset($link['hadpay']);
                unset($link['refund']);
            }
            //社区团购没哟
            if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                $link['hadpay']['label'] = '已付款';
                $link['finish']['label'] = '已完成';
                $link['refund']['label'] = '退款';
                unset($link['tuan']);
                unset($link['ship']);
            }

            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] == 0 && $type == App_Helper_Trade::TRADE_AUCTION){
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>1);
                $where[]= array('name'=>'t_status','oper'=>'!=','value'=>7);
            }
            // 订单状态
            if($output['status'] && isset($link[$output['status']]) && $link[$output['status']]['id'] > 0){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>$link[$output['status']]['id']);
            }elseif($output['status'] == 'winNOPay'){
                $where[]= array('name'=>'t_status','oper'=>'=','value'=>11);
            }
        }
        $this->output['link'] = $link;
        $this->output['statusNote'] = plum_parse_config('trade_status');
        $this->output['trade_screen'] = plum_parse_config('trade_screen');
        //@todo 获取物流列表，供发货使用,全部状态下或待发货状态下
        if(in_array($output['status'],array('all','hadpay')) && $needExpress){
            $express_model  = new App_Model_Trade_MysqlExpressStorage();
            $express = $express_model->getExpressList(1);
        }else{
            $express = array();
        }
        $this->output['express'] = $express;

        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        if($output['status'] == 'hadpay'){
            $sort       = array('t_remind_time' => 'DESC', 't_create_time' => 'DESC');
        }else{
            $sort       = array('t_create_time' => 'DESC');
        }
        //检索条件整理

        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_status','oper'=>'>','value'=>0);
        $output['title'] = $this->request->getStrParam('title');
        if($output['title']){
            $where[]= array('name'=>'t_title','oper'=>'like','value'=>"%{$output['title']}%");
        }
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[]= array('name'=>'t_tid','oper'=>'=','value'=>$output['tid']);
        }
        $output['code'] = $this->request->getStrParam('code');
        if($output['code']){
            $where[]= array('name'=>'t_pickup_code','oper'=>'=','value'=>$output['code']);
        }
        $output['buyer']  = $this->request->getStrParam('buyer');
        if($output['buyer']){
            $where[]= array('name'=>'t_buyer_nick','oper'=>'like','value'=>"%{$output['buyer']}%");
        }
        $output['harvest']  = $this->request->getStrParam('harvest');
        if($output['harvest']){
            $where[]= array('name'=>'ma_name','oper'=>'like','value'=>"%{$output['harvest']}%");
        }
        $output['phone']  = $this->request->getStrParam('phone');
        if($output['phone']){
            $where[]= array('name'=>'ma_phone','oper'=>'=','value'=>$output['phone']);
        }
        //酒店搜索
        $output['mobile']  = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[]= array('name'=>'t_express_code','oper'=>'=','value'=>$output['mobile']);
        }
        $output['realName']  = $this->request->getStrParam('realName');
        if($output['realName']){
            $where[]= array('name'=>'t_express_company','oper'=>'like','value'=>"%{$output['realName']}%");
        }
        if(!$type){
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        }else{
            $where[]     = array('name'=>'t_type','oper'=>'=','value'=>$type);
        }
        $output['start']   = $this->request->getStrParam('start');
        if($output['start']){
            $where[]    = array('name' => 't_create_time', 'oper' => '>=', 'value' => strtotime($output['start']));
        }
        $output['end']     = $this->request->getStrParam('end');
        if($output['end']){
            $where[]    = array('name' => 't_create_time', 'oper' => '<=', 'value' => (strtotime($output['end']) + 86400));
        }
        //门店id
        $output['esId'] = $this->request->getIntParam('esId',0);
        if($output['esId'] > 0){
            $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => $output['esId']);
        }elseif ($output['esId'] < 0){
            $where[]    = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        }
        $output['postType'] = $this->request->getIntParam('postType',0);
        if($output['postType'] > 0){
            $where[]    = array('name' => 't_express_method', 'oper' => '=', 'value' => $output['postType']);
        }
        //自提门店id
        $output['osId'] = $this->request->getIntParam('osId',0);
        if($output['osId'] > 0){
            $where[]    = array('name' => 't_store_id', 'oper' => '=', 'value' => $output['osId']);
            if($this->wxapp_cfg['ac_type'] != 18){
                $output['postType'] = 2; //有自提门店即为门店自取
            }
        }
        //小区名称
        $output['community'] = $this->request->getStrParam('community','');
        if($output['community']){
            $where[]= array('name'=>'asc_name','oper'=>'like','value'=>"%{$output['community']}%");
        }
        //团长名称
        $output['leader'] = $this->request->getStrParam('leader','');
        if($output['leader']){
            $where[]= array('name'=>'asl_name','oper'=>'like','value'=>"%{$output['leader']}%");
        }
        //活动名称
        $output['activity'] = $this->request->getStrParam('activity','');
        if($output['activity']){
            $where[]= array('name'=>'asa_title','oper'=>'like','value'=>"%{$output['activity']}%");
        }
        //活动名称
        $output['groupId'] = $this->request->getIntParam('groupId','');
        if($output['groupId'] > 0){
            $where[]= array('name'=>'asg_id','oper'=>'=','value'=>$output['groupId']);
        }

        $output['tradeScreen'] = $this->request->getStrParam('tradeScreen','valid');
        if($output['tradeScreen'] && $output['status'] != 'closed'){
            switch ($output['tradeScreen']){
                case 'valid':
                    $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
                case 'close':
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                    break;
                case 'finished':
                    $where[] = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH);
                    break;
            }
        }

        $output['searchTradeInfo'] = $this->_show_order_stat($where,FALSE);
        //分页，列表数据展示
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $total       = $trade_model->getTradeAddressCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['page_html'] = $page_lib->render();
        $list     = array();
        $trader   = array();
        if($total > $index){
            $list = $trade_model->getTradeListLight($where,$index,$this->count,$sort);
            //@todo 根据订单ID获取交易详情，并统计本次交易产生订单数量
            $ids  = array();
            foreach($list as $key=>$val){
                $ids[] = $val['t_id'];
            }
            $trade_order    = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);

            $temp   =  $trade_order->getListByGoIds($ids);
            foreach($temp as $val){
                if(isset($trader[$val['to_t_id']]['count'])){
                    $trader[$val['to_t_id']]['count'] ++ ;
                }else{
                    $trader[$val['to_t_id']]['count']  = 1;
                }
                $trader[$val['to_t_id']]['data'][] = $val;
            }
        }
        $output['trader'] = $trader;
        $date_now = date('Y-m-d');
        foreach ($list as $key=>$val){
            $list[$key]['t_remark_extra'] = json_decode($val['t_remark_extra'], true);
            if($val['t_legwork_num'] > 0){
                if(date('Y-m-d',$val['t_pay_time']) == $date_now){
                    $list[$key]['legworkNum'] = '今日 '.$val['t_legwork_num'].'号';
                }else{
                    $list[$key]['legworkNum'] = date('Y年m月d日').$val['t_legwork_num'].'号';
                }
            }
        }
        $output['list']   = $list;
        $this->showOutput($output);
    }
}