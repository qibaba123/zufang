<?php


class App_Controller_Applet_TradeController extends App_Controller_Applet_InitController
{
    //生成图片存储实际路径
    protected $hold_dir;
    //生成图片访问路径
    protected $access_path;
    public function __construct()
    {
        parent::__construct();
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';

    }


    //



    //订单续租
    public function ServiceTradeReletAction(){
        $tid         = $this->request->getStrParam('tid');
        $end_time    = $this->request->getStrParam('end_time');

        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $trade       = $trade_model->findUpdateTradeByTid($tid);

        if($trade['rt_type'] == 1){
            $start_time = $trade['rt_end_time'];
            $end_time   = strtotime($end_time);
            if($end_time <= $start_time){
                $this->displayJsonError('续租时间有误');
            }
            // Libs_Log_Logger::outputLog(($end_time - $start_time),'trade.log');
            $time_num = round(($end_time - $start_time+86400)/(60*60*24));
            $time_type = 1;
        }else{
            $start_time =  date('Y',$trade['rt_end_time']);
            if($end_time <= $start_time){
                $this->displayJsonError('续租时间有误');
            }
            $time_num = $end_time - $start_time;
            $time_type = 3;
            $end_time  = mktime(0,0,0,date('m',time()),date('d',time()),$end_time);
        }
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        $appid    = 'wxe57483a62f88b851';
        if ($trade) {
            $update['rt_relet_tid'] = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid);//生成唯一性订单ID
            $trade_model->findUpdateTradeByTid($tid,$update);
            $tid = $update['rt_relet_tid'];
            $body = $trade['rt_g_name'];
            $amount = floatval($trade['rt_g_price'] * $time_num);
            $openid = $trade['rt_openid'];
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $notify_url = $this->response->responseHost() . '/mobile/wxpay/tradeReserveReletNotifyApplet'; //回调地址

            $attach = array(
                'suid' => $this->shop['s_unique_id'],
                'mid' => $this->member['m_id'],
                'appid' => $appid,
                'end_time' => $end_time,
                'time_num' => $time_num,
                'amount'   => $amount
            );
            $other = array(
                'attach' => json_encode($attach),
            );

            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            $ret    = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other);


            if (is_array($ret)) {
                // 将prepay_id保存到数据库
                $updata = array('rt_prepay_id' => $ret['prepay_id']);
                $trade_model->findUpdateTradeByTid($tid, $updata);
                $params = array(
                    'appId' => $ret['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr' => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package' => "prepay_id={$ret['prepay_id']}",
                    'signType' => 'MD5',
                );
                $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                $this->outputSuccess(array('data' => $params));
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        }


    }


    //订单详情
    public function ServiceTradeDetailAction(){
        $tid          = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $row         = $trade_model->findUpdateTradeByTid($tid);
        $status_arr = array(
            1 => '待支付',
            2 => '租聘中',
            3 => '已过期'
        );
        $data[]      = array(
            'tid'    => $row['rt_tid'],
            'number' => $row['rt_number'],
            'name'   => $row['rt_g_name'],
            'cover'  => $this->dealImagePath($row['rt_cover']),
            'price'  => $row['rt_g_price'],
            'price_fee' => $row['rt_fee'],
            'create_time' => date('Y-m-d H:i',$row['rt_create_time']),
            'status'     => $row['rt_status'],
            'status_desc'=> $status_arr[$row['rt_status']],
            'end_time'   => date('Y-m-d H:i',$row['rt_end_time']),
            'm_name'     => $row['rt_m_name'],
            'm_mobile'   => $row['rt_m_mobile'],
            'm_note'     => $row['rt_note']

        );
        $this->displayJsonSuccess($data,true,'获取成功');
    }



    //预约订单列表
    public function ServiceTradeListAction(){
        $status = $this->request->getIntParam('status');//0.全部  1.待支付  2.进行中  3.已过期 4.续租
        $page   = $this->request->getIntParam('page');
        $index  =  $page*$this->count;
        if($status == 4){
            $status = 2;
        }
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        if($status){
            $where[] = array('name'=>"rt_status",'oper'=>"=",'value'=>$status);
        }else{
            $where[] = array('name'=>"rt_status",'oper'=>"in",'value'=>array(1,2,3));
        }

        $where[] = array('name'=>"rt_m_id",'oper'=>"=",'value'=>$this->member['m_id']);
        $where[] = array('name'=>"rt_type",'oper'=>"in",'value'=>array(1,2,3));
       // Libs_Log_Logger::outputLog($where);
        $list    = $trade_model->getList($where,$index,$this->count,array('rt_create_time'=>'DESC'));
    //    Libs_Log_Logger::outputLog($list);
        $house_model = new App_Model_Resources_MysqlResourcesStorage();
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $data['list'] = array();
        $status_arr = array(
            1 => '待支付',
            2 => '租聘中',
            3 => '已过期'
        );
        foreach($list as $val){
            if($val['rt_type'] == 1){
                $row         = $house_model->getRowById($val['rt_g_id']);
                $g_name      = $row['ahr_title'];
                $number      = $row['ahr_number'];
                $cover       = $row['ahr_cover'];
                $brief       = $row['ahr_brief'];
                $price       = $row['ahr_price'];
            }elseif($val['rt_type'] == 2){
                $row           = $service_model->getRowById($val['rt_g_id']);
                $g_name        = $row['es_name'];
                $cover         = $row['es_cover'];
                $brief         = $row['es_brief'];
                $price         = $row['es_price'];
            }
            $data['list'][] = array(
                'tid'    => $val['rt_tid'],
                'type'   => $val['rt_type'],
                'number' => $number,
                'name'   => $g_name,
                'cover'  => $this->dealImagePath($cover),
                'brief'  => $brief,
                'price_fee'  => $val['rt_fee'],
                'start_time' => date('Y-m-d',$val['rt_start_time']),
                'end_time'   => date('Y-m-d',$val['rt_end_time']),
                //'type'       => $val['rt_type'],
                'status'     => $val['rt_status'],
                'status_desc'=> $status_arr[$val['rt_status']],
                'close_time' => $val['rt_status'] == 1?$val['rt_create_time'] + (15 * 60):0
            );
        }
        $this->displayJsonSuccess($data,true,'获取成功');
    }



    //创建预约订单
    public function createServiceTradeAction(){
        $type      = $this->request->getIntParam('type');//1.园区预约  2.服务预约  3.VIP
        $gid       = $this->request->getIntParam('gid');//商品ID
        $format_id = $this->request->getIntParam('format_id');//规格ID  只有服务有
        $time_type = $this->request->getIntParam('time_type');//时间类型 1.天 2.月 3.年
        $time_num  = $this->request->getIntParam('time_num'); //天数/月数/年数
        $start_time = $this->request->getStrParam('start_time');//开始时间
        $end_time   = $this->request->getStrParam('end_time');//结束时间
   //     $m_name     = $this->request->getStrParam('m_name');//预约人
  //      $m_mobile   = $this->request->getStrParam('m_mobile');//联系电话
        Libs_Log_Logger::outputLog($type,'trade.log');
        Libs_Log_Logger::outputLog($gid,'trade.log');
        Libs_Log_Logger::outputLog($format_id,'trade.log');
        Libs_Log_Logger::outputLog($start_time,'trade.log');
        Libs_Log_Logger::outputLog($end_time,'trade.log');
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();

        if($type == 1){
            $start_time = strtotime($start_time);
            if($start_time > time()){
                $this->displayJsonError('开始日期有误');
            }
            $end_time   = strtotime($end_time);
           // Libs_Log_Logger::outputLog(($end_time - $start_time),'trade.log');
            $time_num = round(($end_time - $start_time+86400)/(60*60*24));
            $time_type = 1;
        }else{
            if($start_time < date('Y',time())){
                $this->displayJsonError('开始年份有误');
            }
            $time_num = $end_time - $start_time;
            $time_type = 3;
            $start_time = mktime(0,0,0,date('m',time()),date('d',time()),$start_time);
            $end_time = mktime(0,0,0,date('m',time()),date('d',time()),$end_time);

        }

       // $end_time -
        $number      = '';
        if($type == 1){
            $house_model = new App_Model_Resources_MysqlResourcesStorage();
            $row         = $house_model->getRowById($gid);
            if($row['ahr_stock'] <= 0 ){
                $this->displayJsonError('库存不足');
            }
            $g_name      = $row['ahr_title'];
            $number      = $row['ahr_number'];
            $cover       = $row['ahr_cover'];
            $brief       = $row['ahr_brief'];
            $price       = $row['ahr_price'];
        }else{
            $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
            $row           = $service_model->getRowById($gid);
            $g_name        = $row['es_name'];
            $cover         = $row['es_cover'];
            $brief         = $row['es_brief'];
            $price         = $row['es_price'];
        }
        $fee = $time_num * $price;
        $insert = array(
            'rt_s_id' => $this->sid,
            'rt_m_id' => $this->member['m_id'],
            'rt_type' => $type,
            'rt_m_nickname' => $this->member['m_nickname'],
            'rt_openid'   => $this->member['m_openid'],
  //          'rt_m_name'   => $m_name,
  //          'rt_m_mobile' => $m_mobile,
            'rt_g_id'     => $gid,
            'rt_g_price'  => $price,
            'rt_fee'      => $fee,
            'rt_cover'    => $cover,
            'rt_g_name'   => $g_name,
            'rt_format_id' => $format_id,
            'rt_number'    => $number,
            'rt_tid'       => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid),//生成唯一性订单ID
            'rt_time_type' => $time_type,
            'rt_time_num'  => $time_num,
            'rt_start_time' => $start_time,
            'rt_end_time'   => $end_time,
        );
        $ret = $trade_model->insertValue($insert);
        $time_status = array(
           1 => '天',
           2 => '月',
           3 => '年'
        );
        $data = array(
            'tid'    => $insert['rt_tid'],
            'number' => $number,
            'name'   => $g_name,
            'cover'  => $this->dealImagePath($cover),
            'brief'  => $brief,
            'price'  => $price,
            'price_fee'  => $fee,
//            'm_name'  => $m_name,
//            'm_mobile' => $m_mobile,
            'time_type' => $time_status[$time_type],
            'time_num' => $time_num,
        );
        if($ret){
            $this->displayJsonSuccess($data,true,'订单创建成功');
        }else{
            $this->displayJsonError('订单创建失败');
        }
    }


    //确认订单
    public function confirmServiceTradeAction(){
        $tid        = $this->request->getStrParam('tid');
        $note       = $this->request->getStrParam('note');
        $m_name     = $this->request->getStrParam('m_name');//预约人
        $m_mobile   = $this->request->getStrParam('m_mobile');//联系电话
        Libs_Log_Logger::outputLog($tid,'trade.log');
        Libs_Log_Logger::outputLog($note,'trade.log');
        Libs_Log_Logger::outputLog($m_name,'trade.log');
        Libs_Log_Logger::outputLog($m_mobile,'trade.log');
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $data = array(
            'rt_m_name'   => $m_name,
            'rt_m_mobile' => $m_mobile,
            'rt_note'     => $note,
            'rt_status'   => 1,//待支付
            'rt_create_time' => time()
        );
        $ret      = $trade_model->findUpdateTradeByTid($tid,$data);
        if($ret){
            $trade    = $trade_model->findUpdateTradeByTid($tid);
            //如果是园区商品  库存减一
            if($trade['rt_type'] == 1){
                $house_model   = new App_Model_Resources_MysqlResourcesStorage();
                $house         = $house_model->getRowById($trade['rt_g_id']);
                $update['ahr_stock'] = $house['ahr_stock'] - 1;
                $house_model->updateById($update,$trade['rt_g_id']);
            }
            //订单置于超时关闭队列
            $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
            $overTime       = 15*60;//关闭时间15分钟
            $trade_redis->setTradeCloseTtl($tid, $overTime);
            $data        = array();
            $data['tid'] = $tid;
            $this->displayJsonSuccess($data,true,'订单提交成功');
        }else{
            $this->displayJsonError('订单提交失败，请稍后重试');
        }
    }


    //订单支付
    public function TradePayAction(){
        $tid      = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlReserveTradeStorage();
        $trade    = $trade_model->findUpdateTradeByTid($tid);

        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        $appid    = 'wxe57483a62f88b851';
        if ($trade) {
            $body = $trade['rt_g_name'];
            $amount = floatval($trade['rt_fee']);
            $openid = $trade['rt_openid'];
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $notify_url = $this->response->responseHost() . '/mobile/wxpay/tradeReserveNotifyApplet'; //回调地址

            $attach = array(
                'suid' => $this->shop['s_unique_id'],
                'mid' => $this->member['m_id'],
                'appid' => $appid,
            );
            $other = array(
                'attach' => json_encode($attach),
            );

            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg = $appletPay_Model->findRowPay();
            $ret = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other);


            if (is_array($ret)) {
                // 将prepay_id保存到数据库
                $updata = array('rt_prepay_id' => $ret['prepay_id']);
                $trade_model->findUpdateTradeByTid($tid, $updata);
                $params = array(
                    'appId' => $ret['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr' => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package' => "prepay_id={$ret['prepay_id']}",
                    'signType' => 'MD5',
                );
                $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                $this->outputSuccess(array('data' => $params));
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        }
    }



    //创建表单订单
    public function createFormTradeAction(){
        $data['ft_type']    = $this->request->getIntParam('type');
        $data['ft_ser_id']  = $this->request->getIntParam('gid');
        $data['ft_name']    = $this->request->getStrParam('name');
        $data['ft_mobile']  = $this->request->getStrParam('mobile');
        $data['ft_pro']     = $this->request->getIntParam('pro');
        $data['ft_city']    = $this->request->getIntParam('city');
        $data['ft_area']    = $this->request->getIntParam('area');
        $data['ft_pro_name']    = $this->request->getStrParam('pro_name');
        $data['ft_city_name']   = $this->request->getStrParam('city_name');
        $data['ft_area_name']   = $this->request->getStrParam('area_name');
        $data['ft_c_name']      = $this->request->getStrParam('c_name');
        $trade_model = new App_Model_Trade_MysqlFormTradeStorage();
        $data['ft_s_id'] = $this->sid;
        $data['ft_create_time'] = time();
        $ret = $trade_model->insertValue($data);
        if($ret){
            $this->displayJsonSuccess(array(),true,'提交成功');
        }else{
            $this->displayJsonError('提交失败，请稍后重试');
        }
    }



    public function createTradeAction(){
        $buys    = $this->request->getStrParam('buys');

        $buys    = json_decode(urldecode($buys), true);
        $extra   = $this->request->getStrParam('extra');
        $baId    = $this->request->getIntParam('baId');  //砍价活动id
        $isPoint = $this->request->getIntParam('isPoint'); //是否是积分订单
        //$isVip  = $this->member['m_level_long'] > time() ? 1:0;
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $single_goods_total_info = [];
        $independent = 0;
        $timeNow = time();
        //判断是否营业 基础商城 万能商城 营销商城
        $appletType = intval($this->applet_cfg['ac_type']);
        if(in_array($appletType,array(21,1,24))  && $this->shop['s_start_time'] != '' && $this->shop['s_end_time'] != '') {
            $isOpen = 0;
            $openTime = strtotime($this->shop['s_start_time']);
            $closeTime = strtotime($this->shop['s_end_time']);
            //如果结束营业之间小于开始营业时间，将营业时间分为两部分
            if ($openTime >= $closeTime) {
                //获得当天0点时间戳
                $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                //获得当天24点时间戳
                $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                    $isOpen = 1;
                }

            }else{
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $isOpen = 1;
                }
            }
            if (!$isOpen) {
                $this->outputError('请在营业时间内 ('.$this->shop['s_start_time'].'-'.$this->shop['s_end_time'].') 下单');
            }
        }
        // 判断商品是否为空如果不为空
        if(!empty($buys) && count($buys) > 0){
            $num_sum    = 0;      //购买商品总数
            $gids       = array();//商品ID
            $nums       = array();//商品数量
            $fids       = array();//商品规格ID
            $cartIds    = array();//商品对应购物车id
            $global     = 0 ;    // 是否有全球购跨境商品
            $remarkExtra = array();
            $needAddress = 0;
            foreach ($buys as $one) {
                $num        = abs(intval($one['num']));
                $num_sum    += $num;
                $gids[]     = intval($one['gid']);
                $nums[]     = $num;
                $cartIds[$one['gid']] = $one['cartId'];
                $fids[]     = intval($one['gfid']);
                $good       = $goods_model->findGoodsBySidGid($this->sid, intval($one['gid']));

                if($good['g_type'] == 1 || $good['g_type'] == 4){
                    $needAddress = 1;//如果有实物商品 需要收货地址
                }

                //判断商品库存是否足够，可以购买
                if($one['gfid'] > 0){
                    //有规格 以规格库存为准
                    $goodsFormat = $format_model->findFormatByGfid($one['gfid'],$one['gid']);
                    if($goodsFormat['gf_stock'] < $num){
                        $this->outputError('你所选的商品库存不足!');
                    }
                }else{
                    //无规格 以商品本身库存为准
                    if($good['g_stock'] < $num){
                        Libs_Log_Logger::outputLog($good);
                        Libs_Log_Logger::outputLog($num);
                        $this->outputError('你所选的商品库存不足!');
                    }
                }

                //判断是否低于最小购买数量
                if($one['num'] < $good['g_small_num']){
                    $goods_unit_name =  $good['g_unit_name'] ? $good['g_unit_name'] : '件';
                    $this->outputError('商品'.$good['g_name'].'购买数量最少为'.$good['g_small_num'].$goods_unit_name.'!');
                }

                //判断是否为独立商城
                if($good['g_independent_mall'] == 1 && in_array($this->applet_cfg['ac_type'],[4,7,27])){

                    $independent = 1;
                }

            }

            $noStoreGoodsData = [];
            $no_receive_gids = [];
            //获得不能自提的商品id数组
            if($this->applet_cfg['ac_type'] == 21 && $this->shop['s_store_goods_limit'] == 1){
                $store_goods_model = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->sid);
                $where_store = [];
                $store_gids = [];
                $where_store[] =['name' => 'asgl_s_id', 'oper' => '=', 'value' => $this->sid];
                $where_store[] =['name' => 'asgl_g_id', 'oper' => 'in', 'value' => $gids];
                $store_gids_list = $store_goods_model->getStoreGoods($where_store,0,0,[]);
                foreach ($store_gids_list as $store_gid){
                    $store_gids[] = $store_gid['asgl_g_id'];
                }
                $no_receive_gids = array_diff($gids,$store_gids);
            }

            // 订购商品数量必须大于0
            if ($num_sum > 0) {
                // 获取购买商品
                $list   = $goods_model->fetchGoodsBySidGids($this->sid, $gids);
                $retcode    = $this->_abnormal_order($list, $num_sum, $goodsFormat);
                $barginCode = $this->_bargain_order($list);
                if ($retcode['errcode'] < 0) {
                    $this->outputError($retcode['errmsg']);
                }
                if ($barginCode['errcode'] < 0) {
                    $this->outputError($barginCode['errmsg']);
                }
                // 如果商品存在
                if ($list) {
                    $goodsList = array();
                    foreach ($list as $val){
                        $goodsList[$val['g_id']] = $val;
                        if($val['g_message_tpid']){
                            $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
                            $messageData = $message_storage->getRowById($val['g_message_tpid']);
                            $messageList = json_decode($messageData['amt_data'], true);
                            foreach ($messageList as $key => $value){
                                $messageList[$key]['date'] = $value['date']=='true'?true:false;
                                $messageList[$key]['multi'] = $value['multi']=='true'?true:false;
                                $messageList[$key]['require'] = $value['require']=='true'?true:false;
                            }
                        }else{
                            $messageList = json_decode($val['g_extra_message'], true);
                        }
                        if($messageList){
                            foreach ($messageList as $key => $value){
                                if(!in_array($value, $remarkExtra)){
                                    $remarkExtra[] = $value;
                                }
                            }
                        }
                    }
                    if(!$remarkExtra && $this->applet_cfg['ac_type'] != 27){
                        $remarkExtra[] = array(
                            'name' => '备注',
                            'type' => 'text',
                            'multi'=> false,
                            'require' => false,
                            'date' => false,
                            'placeholder' => '请输入备注信息'
                        );
                    }
                    $post_fee   = 0;  // 总运费
                    $goods_fee  = 0;  // 商品总金额
                    $allPoints  = 0;  //总积分
                    $total_weight = 0; //总重量
                    $oriPrice   = 0;  // 砍价商品原价
                    $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $trade_type = App_Helper_Trade::TRADE_APPLET;//设置订单为小程序类型订单
                    $applet_trade_type = App_Helper_Trade::TRADE_APPLET_NORMAL;//小程序订单类型默认为普通
                    if($isPoint){
                        $applet_trade_type = App_Helper_Trade::TRADE_APPLET_POINT;//小程序订单类型默认为积分
                    }
                    //$trade_extra= json_encode(array('gid' => current($gids),'needAddress' => $needAddress));//设置第一个商品ID
                    $trade_extra= json_encode(array('gid' => current($gids)));//设置第一个商品ID
                    $goodsData = array();  //获取商品数据
                    $address   = $this->_get_member_default_address();
                    $post_array = array();
                    for ($i=0; $i<count($gids); $i++) {
                        $goodsList[$gids[$i]]['order_type'] = App_Helper_Trade::TRADE_ORDER_NORMAL;//普通
                        $price  = floatval($goodsList[$gids[$i]]['g_price']);  // 商品价格默认为商品价格
                        $points = floatval($goodsList[$gids[$i]]['g_points']);  // 积分默认为商品积分

                        $weight = floatval($goodsList[$gids[$i]]['g_goods_weight']);  // 商品重量默认为商品重量
                        $weightType = $goodsList[$gids[$i]]['g_goods_weight_type'];
                        if($this->applet_cfg['ac_type'] == 27){
                            //如果是知识付费，检查是否有正在拼团的订单
                            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                            $hadTuan = $order_model->getTuanTradeByGid($goodsList[$gids[$i]]['g_id'], $this->member['m_id']);
                            if($hadTuan){
                                //如果有待拼团的订单， 就暂时不能下单， 防止重复购买
                                $this->outputError('您有正在拼团的订单， 暂时不能购买');
                            }
                        }

                        //检查商品限购情况
                        if ($goodsList[$gids[$i]]['g_limit'] > 0) {
                            $had_buy    = $order_model->fetchMemberHadBuy($this->member['m_id'], $goodsList[$gids[$i]]['g_id']);
                            if (($had_buy['hadbuy']+$nums[$i]) > $goodsList[$gids[$i]]['g_limit']) {
                                $this->outputError("商品 {$goodsList[$gids[$i]]['g_name']} 已超出最大限购数{$goodsList[$gids[$i]]['g_limit']}, 无法继续购买, 敬请谅解!");
                                break;
                            }
                        }
                        //检查商品当天限购情况
                        if ($goodsList[$gids[$i]]['g_day_limit'] > 0) {
                            $had_buy    = $order_model->fetchMemberDayHadBuy($this->member['m_id'], $goodsList[$gids[$i]]['g_id']);
                            if (($had_buy['hadbuy']+$nums[$i]) > $goodsList[$gids[$i]]['g_day_limit']) {
                                $this->outputError("商品 {$goodsList[$gids[$i]]['g_name']} 已超出当天最大限购数{$goodsList[$gids[$i]]['g_day_limit']}, 请明天再来购买, 敬请谅解!");
                                break;
                            }
                        }
                        $goodsList[$gids[$i]]['g_has_format']   = $format_model->getFromatCountByGid($goodsList[$gids[$i]]['g_id']);
                        if ($goodsList[$gids[$i]]['g_has_format'] == 0) {//无商品规格时
                            //$price  = $isVip && $goodsList[$gids[$i]]['g_vip_price'] != 0?floatval($goodsList[$gids[$i]]['g_vip_price']):floatval($goodsList[$gids[$i]]['g_price']);
                            //计算会员价
                            if($this->applet_cfg['ac_type'] == 27){
                                //知识付费
                                $price = App_Helper_Trade::getKnowpayGoodsVipPirce($price, $this->sid, $goodsList[$gids[$i]]['g_id'], 0,$this->member['m_id']);
                            }else{
                                $price = App_Helper_Trade::getGoodsVipPirce($price, $this->sid, $goodsList[$gids[$i]]['g_id'], 0,$this->member['m_id']);
                            }
                        } else if ($goodsList[$gids[$i]]['g_has_format'] > 0) {  // 如果商品规格存在时重新计算价格
                            if ($fids[$i] > 0) {
                                $format     = $format_model->findFormatByGfid($fids[$i], $goodsList[$gids[$i]]['g_id']);
                                if ($format && $format['gf_price']) {
                                    $price = $format['gf_price'];
                                    // $price  = $isVip && $format['gf_vip_price']!= 0?floatval($format['gf_vip_price']):floatval($format['gf_price']);
                                    //计算会员价
                                    $price = App_Helper_Trade::getGoodsVipPirce($price, $this->sid, $goodsList[$gids[$i]]['g_id'], $fids[$i],$this->member['m_id']);
                                    $weight = floatval($format['gf_format_weight']);
                                    $weightType = $format['gf_format_weight_type'];
                                    $goodsList[$gids[$i]]['g_format'] = $format['gf_name'];
                                }
                            }else{
                                $this->outputError("请选择商品 {$goodsList[$gids[$i]]['g_name']} 规格");
                            }
                        }


                        // 商品是否是全球购跨境商品
                        if($goodsList[$gids[$i]]['g_is_global']){
                            $global     += 1 ;
                        }

                        //重新计算商品活动价格
                        if ($retcode['errcode'] > 0) {
                            $applet_trade_type = $retcode['type'];
                            //$retcode['extra']['needAddress'] = $needAddress;
                            $trade_extra= json_encode($retcode['extra']);
                            $price  = floatval($retcode['price']);
                            $goodsList[$gids[$i]]['order_type'] = $retcode['type'] == App_Helper_Trade::TRADE_LOTTERY ? App_Helper_Trade::TRADE_ORDER_LOTTERY : App_Helper_Trade::TRADE_ORDER_GROUP;
                        }
                        //砍价  重新计算商品活动价格
                        if ($barginCode['errcode'] > 0) {
                            $applet_trade_type = App_Helper_Trade::TRADE_APPLET_BARGAIN;
                            $price  = floatval($barginCode['price']);
                            $oriPrice  = floatval($barginCode['oriPrice']);
                            $bjId      = $barginCode['bjId'];
                            $goodsList[$gids[$i]]['order_type'] = App_Helper_Trade::TRADE_ORDER_BARGAIN;
                        }
                        $limit_goods    = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
                        $limit_act      = $limit_goods->getActByGid($goodsList[$gids[$i]]['g_id'],'', 1);
                        //限时秒杀,商品价格重新计算
                        if ($limit_act && !$extra && !$baId) {
                            $limit_goods_format = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                            $limitFormat = $limit_goods_format->getRowByActIdGfid($limit_act['la_id'], $fids[$i]);
                            if($limitFormat){

                                //dn 2019-11-09 修改秒杀判断逻辑
                                $sec_ret    = $this->_limit_seckill_goods_format_new($goodsList[$gids[$i]]['g_id'], $nums[$i],$price,$goodsList[$gids[$i]], $limitFormat);
                                //$sec_ret    = $this->_limit_seckill_goods_format($goodsList[$gids[$i]]['g_id'], $nums[$i],$price,$goodsList[$gids[$i]], $limitFormat);

                            }else{
                                //dn 2019-11-09 修改秒杀判断逻辑
                                $sec_ret    = $this->_limit_seckill_goods_new($goodsList[$gids[$i]]['g_id'], $nums[$i],$price,$goodsList[$gids[$i]]);
                                //$sec_ret    = $this->_limit_seckill_goods($goodsList[$gids[$i]]['g_id'], $nums[$i],$price,$goodsList[$gids[$i]]);

                            }
                            if ($sec_ret['errcode']) {
                                if($sec_ret['errcode'] == 1){
                                    $applet_trade_type = App_Helper_Trade::TRADE_APPLET_SECKILL;
                                }else{
                                    // 秒杀时增加的错误异常提示信息
                                    // zhangzc
                                    // 2019-03-25
                                    // $this->displayJson(['em'=>$sec_ret['errmsg']],1);
                                    if($sec_ret['errcode']==4)
                                        $this->displayJson(['em'=>$sec_ret['errmsg']],1);

                                }
                                //$sec_ret['extra']['needAddress'] = $needAddress;
                                $trade_extra= json_encode($sec_ret['extra']);
                                $price  = floatval($sec_ret['price']);
                                $goodsList[$gids[$i]]['actid'] = $sec_ret['extra']['actid'];
                                $goodsList[$gids[$i]]['order_type'] = App_Helper_Trade::TRADE_ORDER_SECKILL;
                            }
                        }
                        $goodsList[$gids[$i]]['g_price'] = $price;
                        //计算运费及总价
                        //$post_fee   += (floatval($goodsList[$gids[$i]]['g_unified_fee'])*$nums[$i]);  // 计算运费总价
                        if($goodsList[$gids[$i]]['g_expfee_type'] == 1 || $goodsList[$gids[$i]]['g_expfee_type'] == 0){
                            $post_array['g'.$goodsList[$gids[$i]]['g_id']]['num'] += $nums[$i];
                            $post_array['g'.$goodsList[$gids[$i]]['g_id']]['gid'] = $gids[$i];
                        }else{
                            $post_array[$goodsList[$gids[$i]]['g_unified_tpid']]['num'] += $nums[$i];
                            if ($fids[$i] > 0) {
                                $format     = $format_model->findFormatByGfid($fids[$i], $goodsList[$gids[$i]]['g_id']);
                                if ($format) {
                                    if($format['gf_format_weight_type'] == 2){
                                        $formatWeight = $format['gf_format_weight'] * 1000;
                                    }else{
                                        $formatWeight = $format['gf_format_weight'];
                                    }
                                    $post_array[$goodsList[$gids[$i]]['g_unified_tpid']]['weight'] += $formatWeight * $nums[$i];
                                }
                            }else{
                                if($goodsList[$gids[$i]]['g_goods_weight_type'] == 2){
                                    $goodsWeight = $goodsList[$gids[$i]]['g_goods_weight'] * 1000;
                                }else{
                                    $goodsWeight = $goodsList[$gids[$i]]['g_goods_weight'];
                                }
                                $post_array[$goodsList[$gids[$i]]['g_unified_tpid']]['weight'] += $goodsWeight * $nums[$i];
                            }
                            $post_array[$goodsList[$gids[$i]]['g_unified_tpid']]['gid'] = $gids[$i];
                        }
                        //$post_fee   += $this->_get_post_fee($gids[$i],$nums[$i],$address['province'],$address['city']);
                        $goods_fee  += ($price*$nums[$i]);//计算商品总价
                        $allPoints += ($points*$nums[$i]); //商品积分
                        $total_weight += (($weightType == 1?$weight:$weight*1000)*$nums[$i]);
                        $single_goods_total_info[$gids[$i]] = [
                            'total' => $price*$nums[$i],
                            'num'   => $nums[$i]
                        ];

                        $formatDesc = '';
                        //获取规格类型
                        if($goodsList[$gids[$i]]['g_format_type'] && isset($format)){
                            $formatType = json_decode($goodsList[$gids[$i]]['g_format_type'], true);
                            if($formatType[0]){
                                $formatDesc .= $formatType[0]['name'].':'.$format['gf_name'].' ';
                            }
                            if($formatType[1]){
                                $formatDesc .= $formatType[1]['name'].':'.$format['gf_name2'].' ';
                            }
                            if($formatType[2]){
                                $formatDesc .= $formatType[2]['name'].':'.$format['gf_name3'].' ';
                            }
                        }elseif(isset($format)){
                            $formatDesc .= '规格:'.$format['gf_name'];
                        }

                        $goodsData[] = array(
                            'id'       => $goodsList[$gids[$i]]['g_id'],
                            'gid'      => $goodsList[$gids[$i]]['g_id'],
                            'gfid'     => $fids[$i],
                            'name'     => $goodsList[$gids[$i]]['g_name'],
                            'type'     => $goodsList[$gids[$i]]['g_type'],
                            'img'      => plum_deal_image_url($goodsList[$gids[$i]]['g_cover']),
                            'format'   => $formatDesc,
                            'num'      => $nums[$i],
                            'points'   => $points,
                            'price'    =>$price,
                            'weight'   => floatval($weight)>0?($weight.($weightType==1?'g':'Kg')):0,
                            //'goodsFee' =>floatval (floatval(str_replace(',','',$price))*$nums[$i]),   //计算商品总价
                            'goodsFee' =>floatval (floatval($price)*$nums[$i]),
                            'postFee'  => (floatval($goodsList[$gids[$i]]['g_unified_fee'])*$nums[$i]), // 计算运费总价,
                            'orderType'=> $goodsList[$gids[$i]]['order_type'],
                            'sendDay' => $goodsList[$gids[$i]]['g_sequence_day'],
                            'actid'    => $goodsList[$gids[$i]]['actid'],
                            'showSendDay' => $goodsList[$gids[$i]]['g_sequence_day_show'],
                            'canBuy' => 1,
                            'noStore' => in_array($gids[$i],$no_receive_gids) && $this->shop['s_store_goods_limit'] == 1 ? 1 : 0,
                            'cartId' => $cartIds[$gids[$i]] ? $cartIds[$gids[$i]] : 0
                        );
                    }

                    if($no_receive_gids){
                        foreach ( $no_receive_gids as $no_receive_gid){
                            $noStoreGoodsData[] =[
                                'gid'      => $goodsList[$no_receive_gid]['g_id'],
                                'name'     => $goodsList[$no_receive_gid]['g_name'],
                                'img'      => plum_deal_image_url($goodsList[$no_receive_gid]['g_cover']),
                            ];
                        }
                    }

                    $post_fee = 0;
                    $post_fee_arr = [0];
                    foreach($post_array as $val){
                        $one_post_fee = $this->_get_post_fee($val['gid'], $val['num'], $address['province'],$address['city'], $val['weight']);
                        $post_fee += $one_post_fee;
                        $post_fee_arr[] = $one_post_fee;
                    }
                    if($this->sid == 11){
                        $post_fee = max($post_fee_arr);
                    }
                    // 订单合计总价
                    $total_fee      = round(($goods_fee + $post_fee),2);
                    if($allPoints > $this->member['m_points']){
                        $this->outputError('积分不足');
                    }
                    //根据订单总价获取配送方式
                    $postWay = $this->_get_post_way($total_fee);
                    //创建交易--开始
                    $esId   = $list[0]['g_es_id'] ? $list[0]['g_es_id'] : 0;  //入驻店铺的id

                    //判断是否超过入驻店铺的营业时间
                    $enter_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                    $entershop = $enter_model->getRowById($esId);
                    if($this->applet_cfg['ac_type'] == 6){
                        if($entershop) {
                            $acs_model = new App_Model_City_MysqlCityShopStorage($this->sid);
                            $acsRow = $acs_model->findUpdateByEsId($entershop['es_id']);
                            if($acsRow['acs_open_time']){

                                $isOpen = 0;
                                $openTime = strtotime(explode('-', $acsRow['acs_open_time'])[0]);
                                $closeTime = strtotime(explode('-', $acsRow['acs_open_time'])[1]);
                                //如果结束营业之间小于开始营业时间，将营业时间分为两部分
                                if ($openTime >= $closeTime) {
                                    //获得当天0点时间戳
                                    $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                                    //获得当天24点时间戳
                                    $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                                    if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                                        $isOpen = 1;
                                    }

                                    //$closeTime = $closeTime + 86400;
                                }else{
                                    if($openTime <= $timeNow && $timeNow <= $closeTime){
                                        $isOpen = 1;
                                    }
                                }
                                if (!$isOpen) {
                                    $this->outputError('请在营业时间内 ('.explode('-', $acsRow['acs_open_time'])[0].'-'.explode('-', $acsRow['acs_open_time'])[1].') 下单');
                                }
                                if($entershop['es_hand_close'] == 1){
                                    $this->outputError('商家正在休息中~');
                                }

                            }
                        }
                    }

                    if($this->applet_cfg['ac_type'] == 8){
                        if($this->appletType != 4) { // 抖音小程序
                            if($entershop) {
                                if($entershop['es_common_business_time']){

                                    $isOpen = 0;
                                    $openTimeStr = '';
                                    if($entershop['es_week'.date('w').'_business_time']){
                                        $timeArr = json_decode($entershop['es_week'.date('w').'_business_time'], true);
                                        foreach ($timeArr as $time){
                                            $openTime = strtotime($time['open']);
                                            $closeTime = strtotime($time['close']);
                                            if($openTime <= $timeNow && $timeNow <= $closeTime){
                                                $isOpen = 1;
                                            }
                                            $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                                        }
                                    }else{
                                        $timeArr = json_decode($entershop['es_common_business_time'], true);
                                        foreach ($timeArr as $time){
                                            $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                                            $openTime = strtotime($time['open']);
                                            $closeTime = strtotime($time['close']);
                                            if($openTime <= $timeNow && $timeNow <= $closeTime){
                                                $isOpen = 1;
                                            }
                                        }
                                    }
                                    if (!$isOpen) {
                                        $this->outputError('请在营业时间内 ('.$openTimeStr.') 下单');
                                    }
                                    if($entershop['es_hand_close'] == 1){
                                        $this->outputError('商家正在休息中~');
                                    }
                                }else{
                                    if($entershop['es_business_time'] && $entershop['es_close_time']){
                                        $isOpen = 0;
                                        $openTime = strtotime($entershop['es_business_time']);
                                        $closeTime = strtotime($entershop['es_close_time']);
                                        //如果结束营业之间小于开始营业时间，将营业时间分为两部分
                                        if ($openTime >= $closeTime) {
                                            //获得当天0点时间戳
                                            $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                                            //获得当天24点时间戳
                                            $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                                            if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                                                $isOpen = 1;
                                            }
                                        }else{
                                            if($openTime <= $timeNow && $timeNow <= $closeTime){
                                                $isOpen = 1;
                                            }
                                        }
                                        if (!$isOpen) {
                                            $this->outputError('请在营业时间内 ('.$entershop['es_business_time'].'-'.$entershop['es_close_time'].') 下单');
                                        }
                                        if($entershop['es_hand_close'] == 1){
                                            $this->outputError('商家正在休息中~');
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //计算自提配送时间
                    $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                    $sendCfg = $send_model->findUpdateBySid(null);
                    $day_plus = 0;
                    $dayTime = plum_parse_config('day_time');
                    $days = intval($sendCfg['acs_sequence_day']);
                    if($sendCfg['acs_sequence_daytime'] && in_array($sendCfg['acs_sequence_daytime'],$dayTime)){
                        $timestemp = strtotime($sendCfg['acs_sequence_daytime']);
                        if($timeNow > $timestemp){
                            $day_plus = 1;
                        }
                    }




                    $indata = array(
                        't_s_id'        => $this->sid,
                        't_es_id'       => $esId,  //入驻店铺的id
                        't_bj_id'       => $bjId,
                        't_m_id'        => $this->member['m_id'],
                        't_buyer_nick'  => $this->member['m_nickname'],
                        't_buyer_openid'=> $this->member['m_openid'],
                        't_tid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid),//生成唯一性订单ID
                        't_title'       => $list[0]['g_name'],//取第一个商品名称作为订单标题
                        't_pic'         => $list[0]['g_cover'],//取第一个商品封面作为订单图片
                        't_num'         => $num_sum,
                        't_goods_fee'   => $goods_fee,
                        't_points'      => $allPoints,
                        't_ori_fee'     => $oriPrice?$oriPrice:0,
                        't_total_fee'   => $total_fee,
                        't_total_weight'=> $total_weight>1000?($total_weight/1000).'Kg':$total_weight.'g',
                        't_post_fee'    => $post_fee,
                        't_post_way'    => $postWay,
                        't_payment'     => 0,
                        't_status'      => 0,
                        't_knowpay_type'=> $list[0]['g_knowledge_pay_type'],//知识付费类型 1图文 2音频 3视频
                        't_type'        => $trade_type,//订单类型
                        't_applet_type'=> $applet_trade_type, //小程序订单类型
                        't_extra_data'  => $trade_extra,//订单附加数据
                        't_create_time' => $timeNow,
                        't_pickup_code' => plum_random_code(8),
                        't_independent_mall' => $independent,
                        't_platform_type'    => $this->appletType
                    );

                    $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                    $t_id   = $trade_model->insertValue($indata);
                    $full_helper    = new App_Helper_FullAct($this->sid);
                    if(in_array($applet_trade_type,array(1,2,5))){
                        $isallow = false;
                    }else{
                        $isallow = true;
                    }

                    //获取会员的优惠券信息
                    $youhuiq    = $full_helper->getCouponListByGids($gids, $this->member['m_id'], $goods_fee,false,$isallow, $esId);
                    //获取订单可用的优惠活动列表
                    $full_act   = $full_helper->getFullActByGidsAmount($gids, $goods_fee, $num_sum, $single_goods_total_info,$isallow,$esId);



                    // 订单创建成功
                    if ($t_id) {
                        //创建交易订单
                        foreach ($goodsData as $key => $item) {
                            $todata = array(
                                'to_s_id'       => $this->sid,
                                'to_t_id'       => $t_id,
                                'to_g_id'       => $item['id'],
                                'to_gf_id'      => $fids[$key],//规格ID,默认为0
                                'to_gf_name'    => isset($item['format']) ? $item['format'] : '',
                                'to_m_id'       => $this->member['m_id'],
                                'to_num'        => $nums[$key],
                                'to_title'      => $item['name'],
                                'to_weight'     => $item['weight'],
                                'to_pic'        => $item['img'],
                                'to_price'      => $item['price'],
                                'to_points'     => $item['points'],
                                'to_limit_act'  => $item['actid'],
                                'to_total'      => floatval($item['price'])*$nums[$key],
                                'to_type'       => $item['orderType'],
                                'to_create_time'=> $timeNow,
                                'to_m_nickname' => $this->member['m_nickname'],
                                'to_m_avatar'   => $this->member['m_avatar']
                            );
                            if($item['showSendDay'] > 0){
                                $goodsDays = $item['sendDay'] > 0 ? ($item['sendDay'] + $day_plus) : $day_plus;
                                $goodsSendDay = $timeNow + $goodsDays * 86400;
                                $todata['to_se_send_time'] = $goodsSendDay;
                            }

                            $order_model->insertValue($todata);
                        }
                        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
                        $payType = $pay_type->findRowPay();
                        $type = array();
                        if($payType['pt_wxpay_applet']==1){
                            $type[] = array(
                                'type'     => 1,
                                'typeNote' => '在线支付',
                            );
                        }
                        if($payType['pt_cash']==1){
                            $type[] = array(
                                'type'     => 2,
                                'typeNote' => '货到付款',
                            );
                        }
                        if($payType['pt_coin']==1){
                            $type[] = array(
                                'type'     => 3,
                                'typeNote' => '余额支付',
                                'balance'  => floatval($this->member['m_gold_coin']),
                            );
                        }
                        //店铺配送方式
                        $send_type    = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                        $sendType = $send_type->findUpdateBySid(null,$esId);
                        if($sendType['acs_platform_send']){
                            $send_type    = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                            $sendType = $send_type->findUpdateBySid(null,0);
                        }

                        $receiveStoreNew = $this->_get_receive_store_new($sendType,$esId,$goodsData);


                        $info['data'] = array(
                            'needAddress' => $needAddress,
                            'isallow'    => $isallow,
                            'tid'         => $indata['t_tid'],
                            'goodsData'  => $goodsData,
                            'coupon'     => $this->_format_coupon($youhuiq),
                            'fullAct'    => $this->_format_full_act($full_act),
                            'address'    => $address,
                            'goodsTotal' => $goods_fee,
                            'pointsTotal'=> $allPoints,
                            'totalWeight'=> $total_weight > 0 ? ($total_weight>1000?($total_weight/1000).'Kg':$total_weight.'g') : 0,
                            'oriFee'     => $oriPrice?$oriPrice:0,
                            'postTotal'  => $post_fee,
                            'total'      => $total_fee,
                            'num'        => $num_sum,
                            'global'     => $global,
                            'tradeType' => $applet_trade_type==3?2:$applet_trade_type,
                            'idcard'     => isset($this->member['m_id_num']) ? $this->member['m_id_num'] : '',
                            'wxpayPayment'   => $payType['pt_wxpay_applet'] == 1 ? 1 : 0,   // 是否启用微信支付，0未启用，1启用
                            'cashPayment'    => $payType['pt_cash'] == 1 ? 1 : 0,   // 是否启用线下支付，0未启用，1启用
                            'payType'        => $type,
                            'postWay'        => $postWay,
                            'expressWay'     => $this->_get_express_way($sendType,$receiveStoreNew),
                            'receiveStore'   => $this->_get_receive_store($sendType,$esId),
                            'receiveStoreNew'   => $receiveStoreNew,
                            'postScope'      => isset($sendType['acs_send_scope']) && $sendType['acs_send_scope'] ? plum_parse_img_path($sendType['acs_send_scope']) : '',
                            'shopAddress'    => isset($sendType['acs_shop_address']) && $sendType['acs_shop_address'] ? $sendType['acs_shop_address'] : '',
                            'shopLng'        => isset($sendType['acs_shop_lng']) && $sendType['acs_shop_lng'] ? $sendType['acs_shop_lng'] : '',
                            'shopLat'        => isset($sendType['acs_shop_lat']) && $sendType['acs_shop_lat'] ? $sendType['acs_shop_lat'] : '',
                            'satisfySend'    => isset($sendType['acs_satisfy_send']) && $sendType['acs_satisfy_send'] ? floatval($sendType['acs_satisfy_send']) : 0,
                            'shopName'       => $this->shop['s_name'],
                            'remarkExtra'    => $remarkExtra,
                            'independent'    => $independent,
                            'storeGoodsLimit' => intval($this->shop['s_store_goods_limit']),
                            'noStoreGoodsData' => $noStoreGoodsData,
                            'receivePriceLimit' => floatval($sendType['acs_receive_price']), //门店自提最低限制金额
                            'is_area'           => $this->member['m_is_area']//是否选择区域
                        );
                        if($list[0]['g_es_id'] && $list[0]['g_es_id']>0){
                            if($entershop){
                                $info['data']['shopName'] = $entershop['es_name'];
                            }
                        }
                        if($this->applet_cfg['ac_type'] == 27){
                            //知识付费返回支付说明
                            $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
                            $tpl   = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']);
                            $info['data']['payTips'] = $tpl['aki_pay_tips']?$tpl['aki_pay_tips']:'你将购买的商品为虚拟内容服务, 购买后不支持退订、退换,请斟酌购买。';
                        }

                        $this->outputSuccess($info);
                    }else{
                        $this->outputError("订单创建失败,请返回重试");
                    }
                }else{
                    $this->outputError("未订购任何商品");
                }
            }else{
                $this->outputError("请选择订购的商品数量");
            }
        }else{
            $this->outputError("未订购任何商品");
        }
    }




    protected function _get_post_way($total){
        $post_model = new App_Model_Goods_MysqlPostWayStorage();
        $where[] = array('name' => 'apw_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'apw_min_price', 'oper' => '<', 'value' => $total);
        $where[] = array('name' => 'apw_max_price', 'oper' => '>', 'value' => $total);
        $way = $post_model->getRow($where);
        if($way){
            return $way['apw_name'];
        }else{
            return '快递发货';
        }
    }


    protected function _get_express_way($sendType,$receiveStore = []){
        $expressWay = array();
        if($sendType && ($sendType['acs_send'] || $sendType['acs_receive'] || $sendType['acs_express_delivery'])){
            if($sendType['acs_send'] || $sendType['acs_platform_send']){
                $expressWay[] = array(
                    'id' => 1,
                    'name' => '商家配送',
                    'sort' => intval($sendType['acs_send_sort'])
                );
            }
            if($sendType['acs_express_delivery'] && $this->applet_cfg['ac_type'] != 32 && $this->applet_cfg['ac_type'] != 36){
                $expressWay[] = array(
                    'id' => 3,
                    'name' => '快递发货',
                    'sort' => intval($sendType['acs_express_sort'])
                );
            }
            if($sendType['acs_receive'] && ($this->shop['s_store_goods_limit'] != 1 || ($this->shop['s_store_goods_limit'] == 1 && !empty($receiveStore)))){
                $expressWay[] = array(
                    'id' => 2,
                    'name' => '门店自取',
                    'sort' => intval($sendType['acs_receive_sort'])
                );
            }
            if($sendType['acs_leader_send'] && $this->applet_cfg['ac_type'] == 32){
                $expressWay[] = array(
                    'id' => 6,
                    'name' => '团长配送',
                    'sort' => intval($sendType['acs_leader_sort'])
                );
            }
            //根据权重排序
            $len = count($expressWay);
            for ($i=0;$i<$len-1;$i++){
                for($j=0;$j<$len-1-$i;$j++){
                    if($expressWay[$j]['sort'] < $expressWay[$j+1]['sort']){
                        $temp = $expressWay[$j];
                        $expressWay[$j] = $expressWay[$j+1];
                        $expressWay[$j+1] = $temp;
                    }
                }
            }

        }else{
            if($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                $expressWay[] = array(
                    'id' => 6,
                    'name' => '团长配送',
                    'sort' => 0
                );
            }else{
                $expressWay[] = array(
                    'id' => 3,
                    'name' => '快递发货',
                    'sort' => 0
                );
            }

        }
        return $expressWay;
    }


    private function _get_receive_store($sendType = array(),$esId = 0){

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->sid);

        if($esId){
            //门店商品订单 取门店本身信息
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $es_row = $es_model->findShopBySid($esId);

            $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
            $sendCfg = $send_model->findUpdateBySid(null,$esId);
            if($sendCfg && $sendCfg['acs_shop_address'] && $sendCfg['acs_shop_lng'] && $sendCfg['acs_shop_lat']){
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $sendCfg['acs_shop_address'],
                    'lng'       => $sendCfg['acs_shop_lng'],
                    'lat'       => $sendCfg['acs_shop_lat'],
                );
            }else{
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $es_row['es_addr'] ? $es_row['es_addr'] : '',
                    'lng'       => $es_row['es_lng'] ? $es_row['es_lng'] : 0,
                    'lat'       => $es_row['es_lat'] ? $es_row['es_lat'] : 0,
                );
            }

        }else{
            $where = array();
            $data  = array();
            $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->sid);
            $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
            $sort = array('os_create_time' => 'DESC');
            $list = $store_model->getList($where,0,50,$sort);
            if($list){
                foreach ($list as $val){
                    $data[] = array(
                        'id'        => intval($val['os_id']),
                        'name'      => $val['os_name'],
                        'address'   => $val['os_addr'] ? $val['os_addr'] : '',
                        'lng'       => $val['os_lng'],
                        'lat'       => $val['os_lat']
                    );
                }

            }else{
                //未添加自提门店却开启了门店自提  取原配置
                if($sendType){
                    $data[] = array(
                        'id'        => -1,
                        'name'      => $this->shop['s_name'],
                        'address'   => $sendType['acs_shop_address'] ? $sendType['acs_shop_address'] : '',
                        'lng'       => $sendType['acs_shop_lng'],
                        'lat'       => $sendType['acs_shop_lat']
                    );
                }
            }
        }

        return $data;
    }

    private function _get_receive_store_new($sendType = array(),$esId = 0,$goodsData = []){

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->sid);
        $data = array();
        if($esId){
            //门店商品订单 取门店本身信息
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $es_row = $es_model->findShopBySid($esId);
            $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
            $sendCfg = $send_model->findUpdateBySid(null,$esId);
            if($sendCfg && $sendCfg['acs_shop_address'] && $sendCfg['acs_shop_lng'] && $sendCfg['acs_shop_lat']){
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $sendCfg['acs_shop_address'],
                    'lng'       => $sendCfg['acs_shop_lng'],
                    'lat'       => $sendCfg['acs_shop_lat'],
                );
            }else{
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $es_row['es_addr'] ? $es_row['es_addr'] : '',
                    'lng'       => $es_row['es_lng'] ? $es_row['es_lng'] : 0,
                    'lat'       => $es_row['es_lat'] ? $es_row['es_lat'] : 0,
                );
            }
        }else{
            $where = array();
            $data  = array();
            $storeIds = [];
            $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
            $sort = array('os_create_time' => 'DESC');
            if($this->applet_cfg['ac_type'] == 21 && $this->shop['s_store_goods_limit'] == 1){
                $store_goods_model = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->sid);
                $gids = [];
                //开启了门店自提限制
                foreach ($goodsData as $goods){
                    $gids[] = $goods['gid'];
                }
                if($gids){
                    $storeIds = $store_goods_model->getStoreIdsByGids($gids);
                }
                if($storeIds){
                    //开启了限制并获得了自提门店id
                    $where[]    = array('name' => 'os_id','oper' => 'in','value' =>$storeIds);
                    $list = $store_model->getListRegion($where,0,0,$sort);
                }else{
                    //开启了限制但未获得符合条件的自提门店id
                    $list = [];
                }
            }else{
                //未开启限制
                $list = $store_model->getListRegion($where,0,0,$sort);
            }

            //$list = $store_model->getList($where,0,0,$sort);
            if($list){
                $zoneArr = array();
                $cityIds = array();
                $cityArr = array();
                $cityArrKey = array();
                $storeArr = array();
                foreach ($list as $val){
                    //获得所有市
                    $cityIds[] = $val['os_city'];
                    if(empty($cityArrKey[$val['os_city']])){
                        $cityArr[] = array(
                            'id'    => intval($val['os_city']),
                            'name'  => $val['city_name'],
                            'submenu' => array()
                        );
                        $cityArrKey[$val['os_city']] = array(
                            'id'    => intval($val['os_city']),
                            'name'  => $val['city_name'],
                            'submenu' => array()
                        );
                    }
                    $storeArr[$val['os_zone']][] = array(
                        'id'        => intval($val['os_id']),
                        'name'      => $val['os_name'],
                        'address'   => $val['os_addr'] ? $val['os_addr'] : '',
                        'lng'       => $val['os_lng'],
                        'lat'       => $val['os_lat']
                    );
                }
                //去重
                $cityIds = array_unique($cityIds);
                //$cityArr = array_unique($cityArr);
                if(!empty($cityIds)){
                    //根据市id获得所有的区
                    $region_model = new App_Model_Member_MysqlRegionStorage();
                    $where_region[] = array('name' => 'parent_id','oper' => 'in','value' =>$cityIds);
                    $where_region[] = array('name' => 'region_type','oper' => '=','value' =>3);
                    $zoneList = $region_model->getListTable($where_region,0,0);
                    if($zoneList){
                        foreach ($zoneList as $zone){
                            foreach ($storeArr as $key => $store){
                                if($key == $zone['region_id']){
                                    $zoneArr[$zone['parent_id']][] = array(
                                        'id' => intval($zone['region_id']),
                                        'name' => $zone['region_name'],
                                        'submune' => $storeArr[$zone['region_id']]
                                    );
                                }
                            }
                        }
                    }
                    foreach ($cityArr as &$val){
                        $val['submenu'] = $zoneArr[$val['id']];
                    }
                }
                $data = $cityArr;
            }else{
                //未添加自提门店却开启了门店自提  取原配置
                if($sendType){
                    if($this->shop['s_store_goods_limit'] == 1){
                        //限制了自提门店商品但没有可使用的自提门店
                        $data = [];
                    }else{
                        $data[] = array(
                            'id'        => -1,
                            'name'      => $this->shop['s_name'],
                            'address'   => $sendType['acs_shop_address'] ? $sendType['acs_shop_address'] : '',
                            'lng'       => $sendType['acs_shop_lng'],
                            'lat'       => $sendType['acs_shop_lat']
                        );
                    }

                }
            }
        }

        return $data;
    }


    public function getReceiveStoreNewAction(){
        $lng = $this->request->getStrParam('lng');
        $lat = $this->request->getStrParam('lat');
        $tid = $this->request->getStrParam('tid','');
        $goodsData = $this->request->getStrParam('goodsData');
        $goodsData = json_decode($goodsData,1);

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        $esId = $trade['t_es_id'];
        $oneId = -1;
        $twoId = -1;
        $threeId = -1;
        //店铺配送方式
        $send_type    = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendType = $send_type->findUpdateBySid(null,$esId);
        if($esId){
            //门店商品订单 取门店本身信息
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $es_row = $es_model->findShopBySid($esId);
            $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
            $sendCfg = $send_model->findUpdateBySid(null,$esId);
            if($sendCfg && $sendCfg['acs_shop_address'] && $sendCfg['acs_shop_lng'] && $sendCfg['acs_shop_lat']){
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $sendCfg['acs_shop_address'],
                    'lng'       => $sendCfg['acs_shop_lng'],
                    'lat'       => $sendCfg['acs_shop_lat'],
                );
            }else{
                $data[] = array(
                    'id'        => -1,
                    'name'      => $es_row['es_name'],
                    'address'   => $es_row['es_addr'] ? $es_row['es_addr'] : '',
                    'lng'       => $es_row['es_lng'] ? $es_row['es_lng'] : 0,
                    'lat'       => $es_row['es_lat'] ? $es_row['es_lat'] : 0,
                );
            }
        }else{
            $store_model    = new App_Model_Store_MysqlStoreStorage($this->sid);
            $where = array();
            $data  = array();
            $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1); //是自提门店

            if($this->applet_cfg['ac_type'] == 21 && $this->shop['s_store_goods_limit'] == 1){
                $store_goods_model = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->sid);
                $gids = [];
                //开启了门店自提限制
                foreach ($goodsData as $goods){
                    $gids[] = $goods['gid'];
                }
                if($gids){
                    $storeIds = $store_goods_model->getStoreIdsByGids($gids);
                }
                if($storeIds){
                    //开启了限制并获得了自提门店id
                    $where[]    = array('name' => 'os_id','oper' => 'in','value' =>$storeIds);
                    $list = $store_model->fetchListOrderLocation($lat,$lng,$where,0,1);//取最近的一条
                }else{
                    //开启了限制但未获得符合条件的自提门店id
                    $list = [];
                }
            }else{
                //未开启限制
                $list = $store_model->fetchListOrderLocation($lat,$lng,$where,0,1);//取最近的一条
            }


//            $list = $store_model->fetchListOrderLocation($lat,$lng,$where,0,1);//取最近的一条
            if($list){
                $selectShop = array(
                    'id'        => intval($list[0]['os_id']),
                    'name'      => $list[0]['os_name'],
                    'address'   => $list[0]['os_addr'] ? $list[0]['os_addr'] : '',
                    'lng'       => $list[0]['os_lng'],
                    'lat'       => $list[0]['os_lat'],
//                        'distance'  => $val['distance']
                );
                if(count($list) >= 1){
                    $sort = array('os_create_time' => 'DESC');
                    $listRegion = $store_model->getListRegion($where,0,0,$sort);
                    $zoneArr = array();
                    $cityIds = array();
                    $cityArr = array();
                    $cityArrKey = array();
                    $storeArr = array();
                    foreach ($listRegion as $val){
                        //获得所有市
                        $cityIds[] = $val['os_city'];
                        if(empty($cityArrKey[$val['os_city']])){
                            $cityArr[] = array(
                                'id'    => intval($val['os_city']),
                                'name'  => $val['city_name'],
                                'submenu' => array()
                            );
                            $cityArrKey[$val['os_city']] = array(
                                'id'    => intval($val['os_city']),
                                'name'  => $val['city_name'],
                                'submenu' => array()
                            );
                        }
                        $storeArr[$val['os_zone']][] = array(
                            'id'        => intval($val['os_id']),
                            'name'      => $val['os_name'],
                            'address'   => $val['os_addr'] ? $val['os_addr'] : '',
                            'lng'       => $val['os_lng'],
                            'lat'       => $val['os_lat']
                        );
                        if($val['os_id'] == $selectShop['id']){
                            $oneId = intval($val['os_city']);
                            $twoId = intval($val['os_zone']);
                            $threeId = intval($val['os_id']);
                        }
                    }
                    //去重
                    $cityIds = array_unique($cityIds);
                    //$cityArr = array_unique($cityArr);
                    if(!empty($cityIds)){
                        //根据市id获得所有的区
                        $region_model = new App_Model_Member_MysqlRegionStorage();
                        $where_region[] = array('name' => 'parent_id','oper' => 'in','value' =>$cityIds);
                        $where_region[] = array('name' => 'region_type','oper' => '=','value' =>3);
                        $zoneList = $region_model->getListTable($where_region,0,0);
                        if($zoneList){
                            foreach ($zoneList as $zone){
                                foreach ($storeArr as $key => $store){
                                    if($key == $zone['region_id']){
                                        $zoneArr[$zone['parent_id']][] = array(
                                            'id' => intval($zone['region_id']),
                                            'name' => $zone['region_name'],
                                            'submenu' => $storeArr[$zone['region_id']]
                                        );
                                    }
                                }
                            }
                        }
                        foreach ($cityArr as &$val){
//                            if($zoneArr[$val['id']]){
//
//                            }else{
//
//                            }
                            $val['submenu'] = $zoneArr[$val['id']];

                        }
                    }
                    $data = $cityArr;
                }else{
                    $data[] = $selectShop;
                }


            }else{
                //未添加自提门店却开启了门店自提  取原配置
                if($sendType){
                    if($this->shop['s_store_goods_limit'] == 1){
                        $data = [];
                    }else{
                        $data[] = $selectShop = array(
                            'id'        => -1,
                            'name'      => $this->shop['s_name'],
                            'address'   => $sendType['acs_shop_address'] ? $sendType['acs_shop_address'] : '',
                            'lng'       => $sendType['acs_shop_lng'],
                            'lat'       => $sendType['acs_shop_lat']
                        );
                    }
                }
            }
        }

        if(!empty($data)){
            $info['data'] = array(
                'data' => $data,
                'selectShop' => $selectShop,
                'oneId' => $oneId,
                'twoId' => $twoId,
                'threeId' => $threeId
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有自提门店信息');
        }
    }



    private function _limit_seckill_goods($gid, $num,$price,$goods) {
        $return = array('errcode' => 0, 'errmsg' => '');
        $limit_helper   = new App_Helper_LimitBuy($this->sid);

        $limit_act      = $limit_helper->checkLimitAct($gid, 0, 1);
        if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {

            if(($limit_act['lg_stock'] > 0 && $limit_act['lg_sold']>=$limit_act['lg_stock']) || (!$limit_act['lg_stock'] && $limit_act['lg_sold']>=$goods['g_stock'])){

                $return = array(
                    'errcode' => 2, 'errmsg' => "抢购活动已结束",
                    'price'   => $price,
                    'extra'   => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                );
            }else{
                //限时秒杀,限购判断
                if (!$limit_act['lg_limit']) {//不限购
                    $return = array(
                        'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                        'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                    );
                } else {
                    // 获取已下单数量
                    $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                    // 当前会员已购买数量
                    $had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit_act['lg_actid'], $gid);
                    $had_buy    = intval($had_buy)+$num;
                    // 总购买数量
                    $count_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $gid);

                    // 如果限购
                    if($limit_act['lg_limit']>0){
                        // 如果购买数量大于等于总库存
                        if($count_buy>=$limit_act['lg_stock']){
                            $return = array(
                                'errcode' => 2, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else if ($had_buy > intval($limit_act['lg_limit'])) {  //如果当前会员购买数量大于限购数量
                            $return = array(
                                'errcode' => 2, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        } else if($had_buy>$limit_act['lg_stock']){  // 如果购买数量大于库存则无法下单
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else {
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }else{  // 如果不限购
                        if ($had_buy > intval($limit_act['lg_stock'])) {
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else if ($count_buy>=$limit_act['lg_stock']) {
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        } else {
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }



                }
            }
        }
        return $return;
    }



    private function _limit_seckill_goods_new($gid, $num,$price,$goods) {
        $return = array('errcode' => 0, 'errmsg' => '');
        $limit_helper   = new App_Helper_LimitBuy($this->sid);
        $limit_act      = $limit_helper->checkLimitAct($gid, 0, 1);
        if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
            $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
            $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $gid,0,$limit_act['la_start_time'],$limit_act['la_end_time']);

            $ignoreDeduct = intval($limit_act['la_ignore_deduct']);
            // 如果秒杀商品的库存存在，但是一次购买的数量大于剩余的秒杀库存则按照商品的原价格走
            // 或者是商品本身的库存就不存在了-所以第二个判断是不是已经不会在生效了|| (!$limit_act['lg_stock'] && $goods['g_stock'] <= 0)
            if(($limit_act['lg_stock'] > 0 && $had_buy>=$limit_act['lg_stock'])){
                $return = array(
                    'errcode' => 2, 'errmsg' => "抢购活动已结束",
                    'price'   => $price,
                    'had_buy' => $had_buy,
                    'stock'   => $limit_act['lg_stock'],

                    'extra'   => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                );
            }else{
                //限时秒杀,限购判断
                //总购买数量
                $count_buy      = $had_buy+$num;
                // 限购库存为0的时候取商品自有库存
                $limit_has_stock=1; //是否为秒杀商品设置了库存
                if($limit_act['lg_stock']<=0){
                    $limit_has_stock=0;
                    $limit_act['lg_stock']=$goods['g_stock'];
                }

                if (!$limit_act['lg_limit']) {
                    //不限购
                    // 如果秒杀设置的有库存
                    if($limit_has_stock){
                        if ($count_buy>$limit_act['lg_stock']){ //要购买的数量超过秒杀限制的库存的时候 所有商品按原价
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else{  //否则按照正常的秒杀价格计算
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }else{   //如果秒杀没有设置库存的话 返回正常的秒杀价格 --总库存没有的时候的上面会直接截断
                        $return = array(
                            'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                    }
                } else {
                    // 当前会员已购买数量
                    $member_had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit_act['lg_actid'], $gid);
                    $member_had_buy    = intval($member_had_buy)+$num; //之前购买的加上现在购买的是否超过限制

                    // 如果秒杀单独设置的有库存
                    if ($member_had_buy > intval($limit_act['lg_limit'])) {  //如果当前会员购买数量大于限购数量
                        $return = array(
                            'errcode' => 4, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $limit_act['lg_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                        return $return;
                    }
                    // 为秒杀商品设置的有库存的话
                    if($limit_has_stock){
                        if($count_buy>$limit_act['lg_stock']){
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else{
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }else{
                        $return = array(
                            'errcode' => 1, 'errmsg' => '', 'price' => $limit_act['lg_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                    }
                }
            }
        }
        return $return;
    }


    private function _limit_seckill_goods_format_new($gid, $num,$price,$goods, $limitFormat) {
        $return = array('errcode' => 0, 'errmsg' => '');
        $limit_helper   = new App_Helper_LimitBuy($this->sid);
        $limit_act      = $limit_helper->checkLimitAct($gid, 0, 1);

        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format     = $format_model->findFormatByGfid($limitFormat['lgf_gf_id'], $gid);
        if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
            $ignoreDeduct = intval($limit_act['la_ignore_deduct']);
            if(($limitFormat['lgf_stock'] > 0 && $limitFormat['lgf_sold']>=$limitFormat['lgf_stock'])){
                $return = array(
                    'errcode' => 2, 'errmsg' => "该规格已抢完",
                    'price'   => $price,
                    'extra'   => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                );
            }else{
                // 如果秒杀商品未设置规格库存默认读取商品的对应规格的库存
                $limit_has_stock=1;
                if($limitFormat['lgf_stock']<=0){
                    $limitFormat['lgf_stock']=$format['gf_stock'];
                    $limit_has_stock=0;
                }
                $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                $count_buy      = $record_model->countBuyNumByActidFid($limit_act['lg_actid'], $gid, $limitFormat['lgf_gf_id'],$limit_act['la_start_time'],$limit_act['la_end_time']);
                $count_buy      +=$num;

                //限时秒杀,限购判断
                if (!$limit_act['lg_limit']) {//不限购
                    if($limit_has_stock){
                        if($count_buy>$limitFormat['lgf_stock']){
                            $return = array(
                                'errcode' => 2, 'errmsg' => '', 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else{
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }else{
                        $return = array(
                            'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                    }

                } else {
                    // 获取已下单未支付数量 防止通过先下单后支付的方式突破秒杀限购
                    $had_buy_nopay = 0;
                    // 当前会员已购买数量
                    $had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit_act['lg_actid'], $gid);
                    $had_buy    = intval($had_buy) + $num + $had_buy_nopay;

                    if ($had_buy > intval($limit_act['lg_limit'])) {  //如果当前会员购买数量大于限购数量
                        $return = array(
                            'errcode' => 4, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $limitFormat['lgf_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                        return $return;
                    }

                    // 如果设置了秒杀库存
                    if($limit_has_stock){
                        if($count_buy>=$limitFormat['lgf_stock']){
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else{
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }else{
                        $return = array(
                            'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                            'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                        );
                    }
                }
            }
        }
        return $return;
    }


    private function _limit_seckill_goods_format($gid, $num,$price,$goods, $limitFormat) {
        $return = array('errcode' => 0, 'errmsg' => '');
        $limit_helper   = new App_Helper_LimitBuy($this->sid);

        $limit_act      = $limit_helper->checkLimitAct($gid, 0, 1);

        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format     = $format_model->findFormatByGfid($limitFormat['lgf_gf_id'], $gid);
        if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
            if(($limitFormat['lgf_stock'] > 0 && $limitFormat['lgf_sold']>=$limitFormat['lgf_stock']) || (!$limitFormat['lgf_stock'] && $limitFormat['lgf_sold']>=$format['gf_stock'])){
                $return = array(
                    'errcode' => 2, 'errmsg' => "该规格已抢完",
                    'price'   => $price,
                    'extra'   => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                );
            }else{
                //限时秒杀,限购判断
                if (!$limit_act['lg_limit']) {//不限购
                    $return = array(
                        'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                        'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                    );
                } else {
                    // 获取已下单数量
                    $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                    // 当前会员已购买数量
                    $had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit_act['lg_actid'], $gid);
                    $had_buy    = intval($had_buy)+$num;
                    // 总购买数量
                    $count_buy    = $record_model->countBuyNumByActidFid($limit_act['lg_actid'], $gid, $limitFormat['lgf_gf_id']);
                    // 如果限购
                    if($limit_act['lg_limit']>0){
                        // 如果购买数量大于等于总库存
                        if($count_buy>=$limitFormat['lgf_stock']){
                            $return = array(
                                'errcode' => 2, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else if ($had_buy > intval($limit_act['lg_limit'])) {  //如果当前会员购买数量大于限购数量
                            $return = array(
                                'errcode' => 2, 'errmsg' => "超过最大限购数量{$limit_act['lg_limit']}, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        } else if($had_buy>$limitFormat['lgf_stock']){  // 如果购买数量大于库存则无法下单
                            $return = array(
                                'errcode' => 2, 'errmsg' => "库存不足, 下单失败", 'price' => $price,
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }else {
                            $return = array(
                                'errcode' => 1, 'errmsg' => '', 'price' => $limitFormat['lgf_yh_price'],
                                'extra' => array('actid' => $limit_act['lg_actid'], 'gid' => $gid),
                            );
                        }
                    }

                }
            }
        }
        return $return;
    }


    private function _abnormal_order($goods, $sum, $goodsFormat) {
        $extra  = $this->request->getStrParam('extra');
        $extra  = $extra ? json_decode(urldecode($extra), true) : null;

        $return = array('errcode' => 0, 'errmsg' => '');
        if (!$extra) {
            return $return;
        }

        $type   = $extra['type'];
        $actid  = $extra['actid'];
        switch ($type) {
            case 'group' :
                $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
                $group      = $group_model->fetchGroupGoods($actid);
                $group_format_model = new App_Model_Group_MysqlGroupGoodsFormatStorage();
                $actFormat = $group_format_model->getRowByActIdGfid($actid, $goodsFormat['gf_id']);
                if ($group['gb_start_time'] > time() || $group['gb_end_time'] < time()) {
                    $return = array('errcode' => -1, 'errmsg' => '拼团活动状态不正确');
                    break;
                }
                if (count($goods) > 1) {
                    $return = array('errcode' => -1, 'errmsg' => '拼团活动仅支持一种商品');
                    break;
                }
                if ($goods[0]['g_id'] != $group['gb_g_id']) {
                    $return = array('errcode' => -1, 'errmsg' => '拼团活动支持的商品不一致');
                    break;
                }
                if($actFormat){
                    if ($goodsFormat['gf_stock'] <= 0) {
                        $return = array('errcode' => -1, 'errmsg' => '商品库存不足');
                        break;
                    }
                }else{
                    if ($group['g_stock'] <= 0) {
                        $return = array('errcode' => -1, 'errmsg' => '商品库存不足');
                        break;
                    }
                }
                $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
                //检查拼团限购情况
                if ($group['gb_limit'] > 0) {
                    $had_buy    = $mem_model->checkGroupGoodsHadBuy($this->member['m_id'], $actid);
                    if (($had_buy['hadbuy']+$sum) > $group['gb_limit']) {
                        $return = array('errcode' => -1, 'errmsg' => "已超出最大限购数{$group['gb_limit']}, 无法继续购买, 敬请谅解!");
                        break;
                    }
                }
                //判断发起还是参与
                $gbid   = plum_check_array_key('gbid', $extra, 0);
                if ($gbid) {
                    $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
                    $where[]    = array('name' => 'go_id', 'oper' => '=', 'value' => $gbid);
                    $where[]    = array('name' => 'go_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[]    = array('name' => 'go_gb_id', 'oper' => '=', 'value' => $actid);
                    $where[]    = array('name' => 'go_status', 'oper' => '=', 'value' => 0);//进行中

                    $org    = $org_model->getRow($where);
                    if (!$org) {
                        $return = array('errcode' => -1, 'errmsg' => '拼团活动已结束,无法继续参与');
                        break;
                    }
                    // 判断参与人数是否和要求参团人数相同
                    if($org['go_had']>=$group['gb_total']){
                        $return = array('errcode' => -1, 'errmsg' => '拼团活动已成功,无法继续参与');
                        break;
                    }

                    //获取参与者
                    $join_list  = $mem_model->fetchJoinList($gbid);
                    //判断是否参与过
                    foreach ($join_list as $item) {
                        if ($item['gm_mid'] == $this->member['m_id']) {
                            $return = array('errcode' => -1, 'errmsg' => '您已参与过该拼团活动,无法重复参与');
                            break 2;
                        }
                    }
                }
                $price  = $actFormat?$actFormat['gbf_price']:$group['gb_price'];
                //团长优惠券,团长发起,团长价
                if ($group['gb_type'] == App_Helper_Group::GROUP_TYPE_TZYHT && !$gbid) {
                    $price  = $actFormat?$actFormat['gbf_tz_price']:$group['gb_tz_price'];
                }
                $return = array(
                    'errcode' => 1, 'errmsg' => '', 'price' => $price,
                    //设置抽奖团或普通拼团
                    'type' => $group['gb_type'] == App_Helper_Group::GROUP_TYPE_CJT ? App_Helper_Trade::TRADE_APPLET_LOTTERY : App_Helper_Trade::TRADE_APPLET_GROUP,
                    'extra' => array('actid' => $actid, 'ishead' => !$gbid, 'gbid' => $gbid),
                );
                break;
        }

        return $return;
    }


    private function _bargain_order($goods) {
        $baId  = $this->request->getIntParam('baId');
        Libs_Log_Logger::outputLog($baId);
        $return = array('errcode' => 0, 'errmsg' => '');
        if (!$baId) {
            return $return;
        }

        $actid  = $baId;
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        $activity  = $bargain_model->getActivityById($actid);
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $record     = $join_storage->findJoinerByAidMid($actid, $this->member['m_id']);

        if($activity['ba_goods_stock'] > 0){
            Libs_Log_Logger::outputLog('砍价错误信息11111');
            if($activity['ba_buy_num'] + 1 > $activity['ba_goods_stock']){
                return array('errcode' => -1, 'errmsg' => '砍价商品库存不足');
            }
        }

//        if ($activity['ba_status'] != App_Helper_BargainActivity::BARGAIN_ACTIVITY_ONGOING) {
//            return array('errcode' => -1, 'errmsg' => '砍价活动状态不正确');
//        }
        if ($activity['ba_start_time']>time() || $activity['ba_end_time']<time()) {
            return array('errcode' => -1, 'errmsg' => '砍价活动状态不正确');
        }
        if (count($goods) > 1) {
            return array('errcode' => -1, 'errmsg' => '砍价活动仅支持一种商品');
        }
        if ($goods[0]['g_id'] != $activity['ba_g_id']) {
            return array('errcode' => -1, 'errmsg' => '砍价活动支持的商品不一致');
        }
        if(!$record){
            return array('errcode' => -1, 'errmsg' => '你尚未参与本砍价活动');
        }

        if ($record['bj_has_buy']) {
            return array('errcode' => -1, 'errmsg' => "商品支付成功,请勿重复下单");
        }

        $price  = floatval($activity['ba_price']) - floatval($record['bj_amount']);
        $limit  = floatval($activity['ba_buy_price_limit']);
        if ($limit > 0 && bccomp($price,$limit,2)>0) {
            return array('errcode' => -1, 'errmsg' => "砍价到{$limit}元方可下单支付");
        }

        $return = array(
            'errcode' => 1, 'errmsg' => '', 'price' => $price, 'oriPrice' => $activity['ba_price'], 'bjId' => $record['bj_id']
        );

        return $return;
    }


    private function  _format_full_act($full_act){
        if($this->sid == 11163){
            Libs_Log_Logger::outputLog('--------full act3--------','test.log');
            Libs_Log_Logger::outputLog($full_act,'test.log');
        }

        $data = array();
        foreach ($full_act as $key => $value) {
            $data[] = array(
                'id'        => $value['fa_id'],
                'name'      => $value['fa_name'],
                'value'     => $value['rule']['fr_value'],
                'desc'      => $value['rule']['rule_desc'],
                'type'      => $value['fa_type'],
            );
        }
        return $data;
    }


    protected function _format_coupon($coupon){
        $data = array();
        if($coupon && !empty($coupon)){
            foreach ($coupon as $key => $value) {
                $data[] = array(
                    'id'        => $value['cr_id'],
                    'name'      => $value['cl_name'],
                    'value'     => $value['cl_face_val'],
                    'limit'     => $value['cl_use_limit'],
                    'count'     => $value['cl_count'],
                    'receive'   => $value['cl_had_receive'],
                    'desc'      => $value['cl_use_desc'],
                    'start'     => date('Y-m-d', $value['cl_start_time']),
                    'end'       => date('Y-m-d', $value['cl_end_time']),
                    'colorType' => (intval($value['cl_id']%4))+1
                );
            }
        }
        // 不使用优惠券
        $nocoupon[] = array(
            'id'        => 0,
            'name'      =>'不使用优惠券',
            'value'     => 0,
            'limit'     => 0,
            'count'     => 0,
            'receive'   => 0,
            'desc'      => 0,
            'start'     => '',
            'end'       => '',
            'colorType' => 1
        );
        $data = array_merge($nocoupon,$data);
        return $data;
    }


    protected function _get_member_default_address(){
        $addr_storage   = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address    = $addr_storage->getMemberDefaultAddress($this->member['m_id']);
        $data = array();
        if($address){
            $data = array(
                'id'        => $address['ma_id'],
                'name'      => $address['ma_name'],
                'mobile'    => $address['ma_phone'],
                'isdefault' => $address['ma_default'],
                'post'      => $address['ma_post'],
                'province'  => $address['ma_province'],
                'city'      => $address['ma_city'],
                'area'      => $address['ma_zone'],
                'address'   => $address['ma_detail'],
                'detail'    => $address['ma_province'].$address['ma_city'].$address['ma_zone'].$address['ma_detail']
            );
            if($address['ma_lng'] && $address['ma_lat']){
                $addressInfo = $this->_get_address_by_lat_lng($address['ma_lng'],$address['ma_lat']);
                $data['province'] = $addressInfo['prov'];
                $data['city']     = $addressInfo['city'];
            }

        }
        return $data;
    }


    public function createAction() {
        //订单、支付信息
        $tid        = $this->request->getStrParam('tid');        // 订单编号
        $addrid     = $this->request->getIntParam('addrid', 0);  // 收货地址ID
        $yhqid      = $this->request->getIntParam('yhqid', 0);   // 优惠劵ID
        $cxid       = $this->request->getIntParam('cxid', 0);    // 促销ID
        $note       = $this->request->getStrParam('note', '');   // 留言
        $deleteIds  = $this->request->getStrParam('cartids');    // 购物车商品提交订单后把购物车删除
        $idcard     = $this->request->getStrParam('idcard');     // 身份证号
        $payType    = $this->request->getIntParam('payType', 1); //支付方式，1在线支付  2现金支付， 3余额支付 ，4微财猫储值卡余额支付，5微财猫微信支付, 6组合支付
        $postFee    = $this->request->getFloatParam('postFee',0); //运费
        $postType   = $this->request->getIntParam('postType',0); //配送类型 ：3物流发货，1商家配送，2门店自提 4平台配送
        $receiverName  = $this->request->getStrParam('receiverName');  //门店自取，取货人姓名
        $receiverPhone = $this->request->getStrParam('receiverPhone'); //门店自取，取货人电话
        $remarkExtra   = $this->request->getStrParam('remarkExtra'); //附加留言
        $receiveStore = $this->request->getIntParam('receiveStore'); //自提门店id
        $goodsData = $this->request->getStrParam('goodsData'); //商品信息
        $single_goods_total_info = [];
        $storeId = $receiveStore > 0 && $postType == 2 ? $receiveStore : 0; //自提门店id
        $legworkPostInfo = [];
        $addr_storage   = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address   = $addr_storage->getRowById($addrid);
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        if($this->applet_cfg['ac_type'] == 27 && $trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_NORMAL && $payType == 2){
            //知识付费的普通的订单如果是支付方式为2，返回错误信息
            $this->outputError("请选择支付方式");
        }

        $extraData  = json_decode($trade['t_extra_data'],1);

        //如果填了联系方式 判断是否是电话号码
        if($receiverPhone){
            if(!plum_is_mobile_phone($receiverPhone)){
                $this->outputError('请填写正确的联系方式');
            }
        }

        //商家配送 验证配送范围
        if($postType == 1){
            $postFee = 0;
            //获得配送范围配置值及店铺经纬度
            $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
            $sendCfg = $send_model->findUpdateBySid(null,$trade['t_es_id']);
            if($sendCfg['acs_platform_send']){
                //获得配送范围配置值及店铺经纬度
                $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                $sendCfg = $send_model->findUpdateBySid(null,0);
                $postType = 4;
            }
            $sendRange = floatval($sendCfg['acs_send_range']);
            $shopLng   = $sendCfg['acs_shop_lng'];
            $shopLat   = $sendCfg['acs_shop_lat'];
            $lng = 0;
            $lat = 0;
            $distance = 0;
            if($address['ma_lng'] && $address['ma_lat']){
                //如果收货地址有经纬度 直接计算
                $lng = $address['ma_lng'];
                $lat = $address['ma_lat'];
                $distance = (2 * 6378.137* asin(sqrt(pow(sin(pi()*($lng-$shopLng)/360),2)+cos(pi()*$lat/180)* cos($shopLat * pi()/180)*pow(sin(pi()*($lat-$shopLat)/360),2))));

            }else{
                //根据收货地址获得经纬度 再进行计算
                $url = 'http://restapi.amap.com/v3/geocode/geo';
                $params = array(
                    'address' => $address['ma_province'].$address['ma_city'].$address['ma_zone'].$address['ma_detail'],
                    'city'    => $address['ma_city'],
                    'output'  => 'JSON',
                    'key'     => plum_parse_config('mapKay')  //web服务key
                );
                $res = Libs_Http_Client::get($url,$params);
                $geoArr = json_decode($res,1);
                $location = $geoArr['geocodes'][0]['location'];
                if($location){
                    $locationArr = explode(',',$location);
                    $lng = $locationArr[0];
                    $lat = $locationArr[1];

                    $distance = (2 * 6378.137* asin(sqrt(pow(sin(pi()*($lng-$shopLng)/360),2)+cos(pi()*$lat/180)* cos($shopLat * pi()/180)*pow(sin(pi()*($lat-$shopLat)/360),2))));
                    $addr_storage->updateById(['ma_lng'=>$lng,'ma_lat'=>$lat],$addrid);
                }else{
                    $this->outputError('收货地址异常');
                }
            }

            $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->sid);
            $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);



            //判断是否开启蜂鸟配送
            //if($sendCfg['acs_ele_delivery'] == 1 && !($legworkCfg['aolc_open'] == 1 && $legworkCfg['aolc_appid'])){
            if(false){ //不再使用蜂鸟配送
                $postFeeArr = $this->_get_ele_post_fee($trade, $lng, $lat);
                Libs_Log_Logger::outputLog($postFeeArr);
                if($postFeeArr['errcode'] != 0){
                    $this->outputError($postFeeArr['msg']);
                }
                $postFee = $postFeeArr['postFee'];
                $eleStoreId = $postFeeArr['storeId'];
                $postType = 5;
            }elseif($legworkCfg['aolc_open'] == 1 && $legworkCfg['aolc_appid'] && $trade['t_applet_type'] != App_Helper_Trade::TRADE_APPLET_GROUP ){//判断是否使用跑腿配送

                if($this->sid == 10971){
                    Libs_Log_Logger::outputLog('判断是否使用跑腿','test.log');
                }

                $legwork_helper = new App_Helper_Legwork($this->sid);
                $legworkRet = $legwork_helper->_get_legwork_post_price_new($legworkCfg['aolc_appid'],$shopLat,$shopLng,$lat, $lng);


                if($legworkRet['errcode'] != 0){
                    $this->outputError($legworkRet['msg']);
                }else{
                    $postFeeTrue = $legworkRet['data']['price'];
                    $discountPost = 0;
                    $sectionArr = json_decode($legworkCfg['aolc_price_section'],1);
                    if($trade['t_es_id'] > 0){
                        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                        $entershop = $es_model->getRowById($trade['t_es_id']);
                        $shopPhone = $entershop['es_phone'];
                    }else{
                        $shopPhone = $this->shop['s_phone'];
                    }

                    //计算补贴后的运费
                    if(is_array($sectionArr)){
                        foreach ($sectionArr as $item){
                            if($postFeeTrue >= $item['min'] && $postFeeTrue < $item['max']){
                                $discountPost = $item['value'];
                                $postFeeTrue = $postFeeTrue - $item['value'];
                                break;
                            }
                        }
                    }
                    $postType = 7;
                    $postFee = $postFeeTrue;
                    $legworkPostInfo = $legworkRet['data'];
                    $legworkPostInfo['shopAddr'] = $sendCfg['acs_shop_address'];
                    $legworkPostInfo['shopMobile'] = $shopPhone ? $shopPhone : '';
                    $legworkPostInfo['discountPost'] = $discountPost;
                }
            }else{
                if($sendRange){
                    if($distance > 0 || ($shopLng > 0 && $shopLat > 0 && $lng >0 && $lat > 0)){//经纬度全部存在，视为有距离，防止两点相同导致距离为0
                        if(floatval($distance) > $sendRange){
                            $this->outputError('超出商家配送范围，请选择其它配送方式.');
                        }else{
                            //重新计算运费
                            $baseLong = floatval($sendCfg['acs_base_long']);
                            $basePrice = floatval($sendCfg['acs_base_price']);
                            if($baseLong > 0) {
                                //若设置了基本配送范围且在基本范围以内
                                $postFee = $basePrice ? $basePrice : 0;
                                //超出基本配送范围
                                if ($baseLong < $distance) {
                                    $plusLong = floatval($sendCfg['acs_plus_long']);
                                    $plusPrice = floatval($sendCfg['acs_plus_price']);
                                    if($plusLong && $plusPrice){
                                        //如果设置了每段距离和每段额外费用
                                        $plusDistance = $distance - $baseLong;
                                        $num = ceil($plusDistance/$plusLong);
                                        $postFee = $basePrice + $num * $plusPrice;
                                    }
                                }
                            }
                        }
                    }else{
                        $this->outputError('超出商家配送范围，请选择其它配送方式。。');
                    }
                }else{
                    $baseLong = floatval($sendCfg['acs_base_long']);
                    $basePrice = floatval($sendCfg['acs_base_price']);
                    if($baseLong > 0) {
                        //超出基本配送范围
                        if ($baseLong < $distance) {
                            $plusLong = floatval($sendCfg['acs_plus_long']);
                            $plusPrice = floatval($sendCfg['acs_plus_price']);
                            if($plusLong && $plusPrice){
                                //如果设置了每段距离和每段额外费用
                                $plusDistance = $distance - $baseLong;
                                $num = ceil($plusDistance/$plusLong);
                                $total = $basePrice + $num * $plusPrice;
                                $postFee = floatval($total);
                            }else{
                                $postFee = floatval($sendCfg['acs_base_price']);
                            }
                        }else{
                            $postFee = floatval($sendCfg['acs_base_price']);
                        }
                    }else{
                        $postFee = floatval($sendCfg['acs_base_price']);
                    }
                }
            }
        }

        if(($postType==1 || $postType ==3 || $postType ==4)  && (!$address['ma_phone'] || !$address['ma_detail'])){
            $this->outputError('请将收货人电话或地址补充完整');
        }

        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg = $pay_type->findRowPay();
        if($trade && $trade['t_status'] == 0){

            $discount_fee   = 0;//折扣金额，优惠劵金额

            $full_helper    = new App_Helper_FullAct($this->sid);
            $goods_fee      = floatval($trade['t_goods_fee']);

            //获取订单商品
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $order_list     = $order_model->fetchOrderListByTid($trade['t_id']);

            $ids    = array();
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);


            $reduce_num = 0;
            $reduce_fee = 0;
            $order_type_arr = [];
            $change_trade_type = false;
            //如果开启了门店自提限制，获得实际购买的商品 并更新订单
            if($this->applet_cfg['ac_type'] == 21 && $this->shop['s_store_goods_limit'] == 1 && $postType == 2 && $goodsData){
                $curr_gids = [];
                $order_delete_ids = [];
                $goodsData = json_decode($goodsData,1);
                foreach ($goodsData as $curr_goods){
                    $curr_gids[] = $curr_goods['gid'];
                }
                foreach ($order_list as $key => $order_row){
                    if(in_array($order_row['to_g_id'],$curr_gids)){
                        $order_type_arr[] = $order_row['to_type'];
                    }else{
                        //如果现有order_list中又不存在的商品，记录需要减少的订单金额和数量
                        $reduce_num += $order_row['to_num'];
                        $reduce_fee += $order_row['to_total'];
                        $order_delete_ids[] = $order_row['to_id'];
                        unset($order_list[$key]);
                    }
                }
                if(!empty($order_delete_ids)){
                    $where_order_delete[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid];
                    $where_order_delete[] = ['name' => 'to_id', 'oper' => 'in', 'value' => $order_delete_ids];
                    $order_model->deleteValue($where_order_delete);
                }

                if(count($order_list) == 0){
                    $this->outputError('不能下单，请选择其他配送方式');
                }

                $trade['t_num'] = $trade['t_num'] - $reduce_num;
                $trade['t_goods_fee'] = $trade['t_goods_fee'] - $reduce_fee;

                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($order_type_arr && $trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_SECKILL && !in_array(App_Helper_Trade::TRADE_ORDER_SECKILL,$order_type_arr)){
                    $trade['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                    $change_trade_type = true;
                }
            }


            foreach ($order_list as $item) {
                $ids[]  = $item['to_g_id'];

                $single_goods_total_info[$item['to_g_id']] = [
                    'total' => $item['to_total'],
                    'num'   => $item['to_num']
                ];

                if($postType == 3){
                    //只有快递发货时才验证运费
                    $this->_get_post_fee($item['to_g_id'], $item['to_num'], $address['ma_province'],$address['ma_city'], 0, 1);
                }
                //取出此商品所有待支付订单的商品数量
                $noPayNum = $order_model->getNopayCountByGid($item['to_g_id'], $item['to_gf_id']);
                //判断库存
                if(!$item['to_gf_id']){
                    $goods = $goods_model->getRowById($item['to_g_id']);
                    if($item['to_num'] + $noPayNum > $goods['g_stock']){
                        $this->outputError('['.$goods['g_name'].']库存不足！');
                    }
                }else{
                    $goods = $goods_model->getRowById($item['to_g_id']);
                    $format = $format_model->getRowById($item['to_gf_id']);
                    if($item['to_num'] + $noPayNum > $format['gf_stock']){
                        $this->outputError('【'.$goods['g_name'].'】规格【'.$item['to_gf_name'].'】库存不足！');
                    }
                }

            }




            //如果使用优惠劵，计算优惠
            if ($yhqid) {
                $coupon_all     = $full_helper->getCouponListByGids($ids, $this->member['m_id'], $goods_fee,false,true,$trade['t_es_id']);
                foreach ($coupon_all as $coupon) {
                    if ($coupon['cr_id'] == $yhqid) {
                        //优惠可用
                        //创建优惠
                        $indata = array(
                            'tc_s_id'       => $this->sid,
                            'tc_tid'        => $trade['t_tid'],
                            'tc_c_id'       => $coupon['cl_id'],
                            'tc_c_name'     => $coupon['cl_name'],
                            'tc_rc_id'      => $coupon['cr_id'],
                            'tc_discount_fee'   => $coupon['cl_face_val'],
                            'tc_used_time'  => time(),
                        );
                        $trade_coupon   = new App_Model_Trade_MysqlTradeCouponStorage($this->sid);
                        $trade_coupon->insertValue($indata);
                        $discount_fee   = floatval($coupon['cl_face_val']);
                        //设置优惠券已使用
                        $rcupdata   = array(
                            'cr_is_used'    => 1,
                            'cr_used_time'  => time(),
                        );
                        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
                        $receive_model->updateById($rcupdata, $coupon['cr_id']);
                        //使用数量加1
                        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
                        $coupon_model->incrementUsedCount($coupon['cl_id'], 1);
                        break;
                    }
                }
            }

            // 计算使用优惠券后的金额
            $total_fee      = max(0, floatval($trade['t_total_fee']) - $discount_fee - $reduce_fee);

            $promotion_fee  = 0;//促销金额
            //促销减免
            if ($cxid) {
                $full_all   = $full_helper->getFullActByGidsAmount($ids, $goods_fee, $trade['t_num'],$single_goods_total_info,true,$trade['t_es_id']);

                foreach ($full_all as $item) {
                    if ($item['fa_id'] == $cxid) {
                        switch ($item['fa_type']) {
                            case App_Helper_FullAct::FULL_ACT_MANJIAN :
                                $promotion_fee  = floatval($item['rule']['fr_value']);
                                break;
                            case App_Helper_FullAct::FULL_ACT_MANSONG :
                                $promotion_fee  = 0;
                                break;
                            case App_Helper_FullAct::FULL_ACT_MANZHE :
                                $promotion_fee  = $goods_fee*(1-floatval($item['rule']['fr_value'])/10);
                                $promotion_fee  = round($promotion_fee*100)/100;
                                break;
                            case App_Helper_FullAct::FULL_ACT_MANYOU :
                                //$promotion_fee  = floatval($trade['t_post_fee']);
                                //$promotion_fee = $postFee;
                                $postFee = 0;
                                $promotion_fee = 0;
                                break;
                        }
                        //记录促销使用
                        $indata = array(
                            'tf_s_id'       => $this->sid,
                            'tf_es_id'      => $trade['t_es_id'],
                            'tf_tid'        => $trade['t_tid'],
                            'tf_actid'      => $cxid,
                            'tf_name'       => $item['fa_name'],
                            'tf_type'       => $item['fa_type'],
                            'tf_discount_fee'   => $promotion_fee,
                            'tf_used_time'  => time(),
                        );
                        $trade_full = new App_Model_Trade_MysqlTradeFullStorage($this->sid);
                        $trade_full->insertValue($indata);
                        break;
                    }
                }
            }
            if($postType==2){   // 门店自提免运费
                $postFee = 0;
            }
            $postFee = abs($postFee);
            $total_fee  = max(0,$total_fee - $trade['t_post_fee'] + $postFee);



            $total_fee  = max(0, $total_fee-$promotion_fee);

            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
            $info['data'] = array(
                'status' => '',
            );
            if($trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_SECKILL){
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']);
                $where[] = array('name' => 'to_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_ORDER_SECKILL);
                $orderList = $order_model->getList($where);
                $limit_goods    = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
                $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
                $temp = array();
                foreach ($orderList as $value){
                    $limit_act      = $limit_goods->getActByGid($value['to_g_id'],'', 1);
                    $limit_format_model  = new App_Model_Limit_MysqlLimitGoodsFormatStorage($this->sid);
                    $limitFormat = $limit_format_model->getRowByActIdGfid($limit_act['lg_actid'], $value['to_gf_id']);
                    $goods = $goods_model->getRowById($value['to_g_id']);
                    $format = $format_model->getRowById($value['to_gf_id']);
                    if($value['to_gf_id'] && $limitFormat){
                        $limitFormat['lgf_stock'] = $limitFormat['lgf_stock'] == 0? $format['gf_stock']:$limitFormat['lgf_stock'];
                        if($limitFormat['lgf_stock'] > 0){
                            $actid = $limit_act['lg_actid'];
                            $gid = $value['to_g_id'];
                            $set = $trade_redis->getLimitTradeValue($actid, $gid);

                            $buyTotal = $value['to_num'];
                            foreach ($set as $v){
                                $oldOrder = $order_model->getRowById($v);
                                if($oldOrder['to_gf_id'] == $value['to_gf_id']){
                                    $oldTrade = $trade_model->getRowById($oldOrder['to_t_id']);
                                    if(in_array($oldTrade['t_status'], [1,2, 3, 4, 5, 6])){
                                        $buyTotal += $oldOrder['to_num'];
                                    }
                                }
                            }

                            if($buyTotal  <= $limitFormat['lgf_stock']){
                                $temp[] = array(
                                    'actid' => $actid,
                                    'gid'   => $gid,
                                    'toid'  => $value['to_id'],
                                    'endTime' => $limit_act['la_end_time'],
                                    'hadSet'=> $set?true:false
                                );

                            }else{
                                $goods = $goods_model->getRowById($value['to_g_id']);
                                $this->outputError('秒杀商品['.$goods['g_name'].'('.$value['to_gf_name'].')]库存不足!');
                            }
                        }
                    }else{
                        $limit_act['lg_stock'] = $limit_act['lg_stock'] == 0? $goods['g_stock']:$limit_act['lg_stock'];
                        if($limit_act['lg_stock'] > 0){
                            $actid = $limit_act['lg_actid'];
                            $gid = $value['to_g_id'];
                            $set = $trade_redis->getLimitTradeValue($actid, $gid);

                            $buyTotal = $value['to_num'];
                            foreach ($set as $v){
                                $oldOrder = $order_model->getRowById($v);
                                $oldTrade = $trade_model->getRowById($oldOrder['to_t_id']);
                                if(in_array($oldTrade['t_status'], [1,2, 3, 4, 5, 6])){
                                    $buyTotal += $oldOrder['to_num'];
                                }
                            }

                            if($buyTotal  <= $limit_act['lg_stock']){
                                $temp[] = array(
                                    'actid' => $actid,
                                    'gid'   => $gid,
                                    'toid'  => $value['to_id'],
                                    'endTime' => $limit_act['la_end_time'],
                                    'hadSet'=> $set?true:false
                                );

                            }else{
                                $goods = $goods_model->getRowById($value['to_g_id']);
                                $this->outputError('秒杀商品['.$goods['g_name'].']库存不足!');
                            }
                        }
                    }
                }
                foreach ($temp as $val){
                    $trade_redis->setLimitTradeValue($val['actid'], $val['gid'],$val['toid']);
                    if(!$val['hadSet']){
                        $time = $val['endTime'] - time();
                        $trade_redis->setLimitTradeExpire($val['actid'], $val['gid'], $time);
                    }
                }
            }

            //开始分销
            $goods_ratio = false;
            //单品分销  只限普通类型订单
            if(!$deleteIds && $trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_NORMAL){
                Libs_Log_Logger::outputLog('aaa','wxapy.log');
                $goods_ratio = $this->_goods_ratio_deduct($trade['t_id'], $tid, $total_fee, $discount_fee, $promotion_fee);
            }

            if(($deleteIds || !$goods_ratio) && $trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_NORMAL){//购物车结算的订单或者没有单品分享分销 走正常分销
              
                //设置订单分佣及通知信息
                $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                $tcRow         = $copartner_cfg->findShopCfg();
                $round_type = intval($tcRow['tc_round_type']);
                if($tcRow['tc_copartner_isopen'] == 1){
                    $this->_copartner_order_deduct($trade['t_id'], $tid, $total_fee, $discount_fee, $promotion_fee, $trade['t_es_id']);
                }else{
                    $this->_mall_order_deduct($trade['t_id'], $tid, $total_fee, $discount_fee, $promotion_fee, $round_type);
                }
            }

            //优惠全免, 直接支付成功
            if ($total_fee == 0) {
                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_store_id'        => $storeId,
                    't_discount_fee'    => $discount_fee,
                    't_promotion_fee'   => $promotion_fee,
                    't_note'            => $note ? $note : $trade['t_note'],
                    't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YHQM,
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态,
                    't_post_fee'        => $postFee,
                    't_express_method'  => $postType,
                    't_pay_time'        => time(),
                    't_express_company' => $receiverName,
                    't_express_code'    => $receiverPhone,
                    't_ele_store_id'    => $eleStoreId,
                    't_remark_extra'    => $remarkExtra,
                    't_num'             => $trade['t_num'],
                    't_goods_fee'       => $trade['t_goods_fee']
                );
                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($change_trade_type){
                    $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                }

                if($legworkPostInfo){
                    $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                }

                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //订单活动后续处理
                $trade = $trade_model->findUpdateTradeByTid($tid);
                $trade_helper->dealTradeType($trade);
                $info['data']['status'] = 'zfcg';
                plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG,'applet' => $this->applet_cfg['ac_type']));

            } elseif($payType == 2){
                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_discount_fee'    => $discount_fee,
                    't_promotion_fee'   => $promotion_fee,
                    't_note'            => $note ? $note : $trade['t_note'],
                    't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_HDFK,  //货到付款
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态
                    't_post_fee'        => $postFee,
                    't_express_method'  => $postType,
                    't_pay_time'        => time(),
                    't_express_company' => $receiverName,
                    't_express_code'    => $receiverPhone,
                    't_ele_store_id'    => $eleStoreId,
                    't_remark_extra'    => $remarkExtra,
                    't_num'             => $trade['t_num'],
                    't_goods_fee'       => $trade['t_goods_fee']
                );
                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($change_trade_type){
                    $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                }
                if($legworkPostInfo){
                    $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                }
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //订单活动后续处理
                $trade = $trade_model->findUpdateTradeByTid($tid);
                $trade_helper->dealTradeType($trade);
                $info['data']['status'] = 'zfcg';
                plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid,'appletType'=>$this->appletType));

            }elseif($payType == 3){
                if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                    $this->outputError('该店铺暂未开启余额支付');
                }
                //判断账户余额是否冻结
                if($this->member['m_gold_freeze']){
                    $this->outputError('账户已被冻结，请联系管理员');
                }
                $status = intval($trade['t_status']);
                if ($status >= App_Helper_Trade::TRADE_HAD_PAY) {
                    //订单已支付
                    $this->outputError("订单已支付");
                }
                //判断会员余额是否足够支付
                $coin   = floatval($this->member['m_gold_coin']);
                $fee    = floatval($total_fee);//订单总价格
                if ($fee > $coin) {
                    $this->outputError("账户余额不足");
                }

                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_store_id'        => $storeId,
                    't_discount_fee'    => $discount_fee,
                    't_promotion_fee'   => $promotion_fee,
                    't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                    't_note'            => $note ? $note : $trade['t_note'],
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YEZF,
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态
                    't_pay_time'        => time(),
                    't_payment'         => $fee,
                    't_post_fee'        => $postFee,
                    't_express_method'  => $postType,
                    't_express_company' => $receiverName,
                    't_express_code'    => $receiverPhone,
                    't_ele_store_id'    => $eleStoreId,
                    't_remark_extra'    => $remarkExtra,
                    't_num'             => $trade['t_num'],
                    't_goods_fee'       => $trade['t_goods_fee']
                );
                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($change_trade_type){
                    $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                }
                if($legworkPostInfo){
                    $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                }

                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid,$tid, $this->member['m_id'], $fee);

                if($debit){
                    //订单活动后续处理
                    $trade = $trade_model->findUpdateTradeByTid($tid);
                    $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
                    $trade_helper->dealTradeType($trade);

                    //多店的余额支付也要记录待结算交易
                    if($trade['t_es_id']){
                        if($postType == 4 || $postType == 5){//平台配送 || 蜂鸟配送 || 跑腿配送，减去配送费
                            $trade['t_total_fee'] = $updata['t_total_fee'] - $postFee;
                        }
                        if($postType == 7 && isset($legworkRet['data']['price']) && $legworkRet['data']['price'] > 0){
                            $trade['t_total_fee'] = $updata['t_total_fee'] - $legworkRet['data']['price'];
                        }
                        $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
                    }

                    $info['data']['status'] = 'zfcg';
                    plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG,'appletType'=>$this->appletType));

                }
            }elseif($payType == 6){ //组合支付
                if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                    $this->outputError('该店铺暂未开启余额支付');
                }
                //判断账户余额是否冻结
                if($this->member['m_gold_freeze']){
                    $this->outputError('账户已被冻结，请联系管理员');
                }
                $status = intval($trade['t_status']);
                if ($status >= App_Helper_Trade::TRADE_HAD_PAY) {
                    //订单已支付
                    $this->outputError("订单已支付");
                }


                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_store_id'        => $storeId,
                    't_discount_fee'    => $discount_fee,
                    't_promotion_fee'   => $promotion_fee,
                    't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                    't_note'            => $note ? $note : $trade['t_note'],
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_HHZF,
                    't_status'          => App_Helper_Trade::TRADE_NO_PAY,//等待支付完成确认状态
                    't_pay_time'        => time(),
                    't_coin_payment'    => $this->member['m_gold_coin'],
                    't_post_fee'        => $postFee,
                    't_express_method'  => $postType,
                    't_express_company' => $receiverName,
                    't_express_code'    => $receiverPhone,
                    't_ele_store_id'    => $eleStoreId,
                    't_remark_extra'    => $remarkExtra,
                    't_num'             => $trade['t_num'],
                    't_goods_fee'       => $trade['t_goods_fee']
                );
                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($change_trade_type){
                    $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                }
                if($legworkPostInfo){
                    $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                }
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //减少会员金币
                App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$this->member['m_gold_coin']);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid,$tid, $this->member['m_id'], $this->member['m_gold_coin']);
                //订单置于超时关闭队列
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                // 获取超时关闭时间
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $trade_redis->setTradeCloseTtl($trade['t_id'], $overTime);
                $info['data']['status'] = 'dzf';
            }elseif($payType == 4){   //微财猫会员储值卡支付
                $status = intval($trade['t_status']);
                if ($status >= App_Helper_Trade::TRADE_HAD_PAY) {
                    //订单已支付
                    $this->outputError("订单已支付");
                }
                $fee    = floatval($total_fee);//订单总价格
                $client = new App_Plugin_Vcaimao_PayClient($this->sid);
                //获取微信会员卡信息
                $memberCard = $client->getMemberInfo($this->member['m_union_id'],$this->member['m_openid']);
                if($memberCard && !$memberCard['errcode'] && $memberCard['data']){
                    //当前储值卡余额
                    $balance = round(($memberCard['data']['balance']/100),2);
                    //支付总金额
                    $payment = $fee*100;   //单位为分
                    if($balance>=$fee){
                        $orderTypeData = App_Plugin_Vcaimao_PayClient::$trade_applet_type;
                        $debit = $client->payStoredCard($this->member['m_union_id'],$tid,$payment,$trade['t_title'],null,$orderTypeData[$trade['t_applet_type']]);
                        $updata = array(
                            't_total_fee'       => $total_fee,
                            't_store_id'        => $storeId,
                            't_discount_fee'    => $discount_fee,
                            't_promotion_fee'   => $promotion_fee,
                            't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                            't_note'            => $note ? $note : $trade['t_note'],
                            't_pay_type'        => App_Helper_Trade::TRADE_PAY_VCMZF,
                            't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态
                            't_pay_time'        => time(),
                            't_payment'         => $fee,
                            't_post_fee'        => $postFee,
                            't_express_method'  => $postType,
                            't_express_company' => $receiverName,
                            't_express_code'    => $receiverPhone,
                            't_ele_store_id'    => $eleStoreId,
                            't_remark_extra'    => $remarkExtra,
                            't_num'             => $trade['t_num'],
                            't_goods_fee'       => $trade['t_goods_fee']
                        );
                        //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                        if($change_trade_type){
                            $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                        }
                        if($legworkPostInfo){
                            $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                        }
                        if($debit && !$debit['errcode'] && $debit['data']){
                            $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                            //订单活动后续处理
                            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
                            $trade_helper->dealTradeType($trade);

                            //多店的余额支付也要记录待结算交易
                            if($trade['t_es_id']){
                                if($postType == 4 || $postType == 5){//平台配送 || 蜂鸟配送 || 跑腿配送，减去配送费
                                    $trade['t_total_fee'] = $updata['t_total_fee'] - $postFee;
                                }
                                if($postType == 7 && isset($legworkRet['data']['price']) && $legworkRet['data']['price'] > 0){
                                    $trade['t_total_fee'] = $updata['t_total_fee'] - $legworkRet['data']['price'];
                                }
                                $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
                            }

                            $info['data']['status'] = 'zfcg';
                            plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_ZFCG,'appletType'=>$this->appletType));
                            //支付完成打印订单及通知消息
                            $new_pay    = new App_Plugin_Vcaimao_PayClient($trade['t_s_id']);
                            $new_pay->sendPrintNotice($trade,$this->applet_cfg['ac_name'],'你有新的订单请及时处理',$trade['t_es_id']);
                        }else{
                            $this->outputError('支付失败请稍后重试');
                        }
                    }else{
                        $this->outputError('微信储值卡余额不足，请充值后再试');
                    }
                }else{
                    $this->outputError('微信储值卡获取失败请稍后重试');
                }
            }  else {
                // 在线支付判断支付类型（根据小程序类型判断）默认是微信支付
                if($payType==1){
                    if($this->appletType==3 || $this->appletType==4){   // 支付宝小程序   抖音小程序-支持支付宝支付
                        $payType = App_Helper_Trade::TRADE_PAY_ZFBZFDX;
                    }elseif ($this->appletType==6){   // qq小程序使用财付通支付
                        $payType = App_Helper_Trade::TRADE_PAY_QQZF;
                    }
                }
                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_store_id'        => $storeId,
                    't_discount_fee'    => $discount_fee,
                    't_promotion_fee'   => $promotion_fee,
                    't_note'            => $note ? $note : $trade['t_note'],
                    't_addr_id'         => $addrid ? $addrid : $trade['t_addr_id'],
                    't_status'          => App_Helper_Trade::TRADE_NO_PAY,//修改订单状态为待支付
                    't_post_fee'        => $postFee,
                    't_express_method'  => $postType,
                    't_express_company' => $receiverName,
                    't_express_code'    => $receiverPhone,
                    't_ele_store_id'    => $eleStoreId,
                    't_remark_extra'    => $remarkExtra,
                    't_pay_type'        => $payType== 5 ? App_Helper_Trade::TRADE_PAY_VCMWXZF : $payType,
                    't_num'             => $trade['t_num'],
                    't_goods_fee'       => $trade['t_goods_fee']
                );
                //如果订单为秒杀订单，存在秒杀商品，但由于门店自提限制将秒杀商品剔除了。订单重新改为普通订单
                if($change_trade_type){
                    $updata['t_applet_type'] = App_Helper_Trade::TRADE_APPLET_NORMAL;
                }
                if($legworkPostInfo){
                    $updata['t_legwork_extra'] = json_encode($legworkPostInfo,JSON_UNESCAPED_UNICODE);
                }
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //是否触发通知
                $trade_helper->sendTradeStatusMessage($tid, App_Helper_Trade::TRADE_MESSAGE_SEND_MJXD);
                //订单置于超时关闭队列
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                // 获取超时关闭时间
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*10 : $over_time['close'];
                $trade_redis->setTradeCloseTtl($trade['t_id'], $overTime);
                $info['data']['status'] = 'dzf';
            }
            //全球购商品添加身份证号
            $this->_save_member_idcard($idcard,'');
            if($ret){
                // 删除购物车的商品
                if($deleteIds){
                    $this->_delete_cart_Action($deleteIds);
                }
                $this->outputSuccess($info);
            }else{
                $this->outputError('确认订单失败，请重试');
            }
        }else{
            $this->outputError('订单不存在');
        }
    }


    private function _goods_ratio_deduct($tid, $ttid, $total_fee, $discount_fee, $promotion_fee){
        $mid = $this->request->getIntParam('mid');
        Libs_Log_Logger::outputLog('bbb','wxapy.log');
        //存在分享人，进行单品分享分销
        if($mid && $this->shop['s_goods_deduct'] && $mid != $this->member['m_id']){
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orders         = $order_model->fetchOrderListByTid($tid);
            $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
            $order_deduct   = new App_Helper_OrderDeduct($this->sid);
            foreach ($orders as $item) {
                $gd     = $goods_deduct->findOpenDeduct($item['to_g_id']);
                if($gd){
                    $total = $item['to_total'] - $discount_fee - $promotion_fee;
                    //存在商品单品分销
                    $ratio  = $gd ? array(0 => $gd['grd_0f_ratio'], 1 => $gd['grd_1f_ratio']) : array(0 => 0, 1 => 0);
                    //设置商品分佣
                    $order_deduct->createShareOrderDeduct($this->member['m_id'], $mid,$ttid, $total>0?$total:0, $ratio, $item['to_g_id']);
                    return true;
                }
            }
        }
        return false;
    }



    private function _copartner_order_deduct($tid, $ttid, $total_fee, $discount_fee, $promotion_fee, $esId,$round_type = 0) {
        Libs_Log_Logger::outputLog($ttid);
        if($esId){
            $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $entershop   = $store_model->getRowById($esId);
            if(!$entershop['es_join_distrib']){ //店铺不参与分销
                return false;
            }
        }

        //获取店铺分成佣金设置

        $has_buy        = $this->member['m_traded_num'];
        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //判断这个订单是否已经存在分佣记录
        $order_deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $had_deduct = $order_deduct_storage->findOrderDeductListByTid($ttid);

        //如果不存在，设置分佣
        if(!$had_deduct){
            //使用店铺分佣设置
            $ratio  = $this->_deduct_copartner_translate($has_buy);
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orders         = $order_model->fetchOrderListByTid($tid);
            $allTotal = 0;
            foreach ($orders as $item){
                $allTotal += $item['to_total'];
            }

            foreach ($orders as $item) {
                $total = $item['to_total'] - (($discount_fee + $promotion_fee) * ($item['to_total']/$allTotal));
                if($entershop){
                    $pay_model   = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $payCfg      = $pay_model->findRowPay();
                    if($entershop['es_maid_proportion'] && $entershop['es_maid_proportion']>0){
                        $total = number_format($total * $entershop['es_maid_proportion']/100, 2);
                    }elseif($payCfg['ap_shop_percentage']){
                        $total = number_format($total * $payCfg['ap_shop_percentage']/100, 2);
                    }else{
                        $total = 0;
                    }
                }

                //设置商品分佣
                $order_deduct->createOrderDeduct($this->member['m_id'], $ttid, $total, $ratio, $item['to_g_id'],1,$round_type);
            }
        }
    }


    private function _deduct_copartner_translate($has_buy) {
        $three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        $member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($this->uid);
        $deduct_model   = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $data = array();
        for ($i=0; $i<=$three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($benefit);
            $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid, $extra['ame_copartner']);

            //$deduct = $deduct_list[$index];
            $deduct = $deduct_list[1];
            $data[$i] = $deduct['cdc_'.$i.'f_ratio'];
        }
        return $data;
    }



    private function _mall_order_deduct($tid, $ttid , $total_fee, $discount_fee, $promotion_fee,$round_type = 0) {
        Libs_Log_Logger::outputLog('444','wxapy.log');
        //获取店铺分成佣金设置
        $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
        $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid);

        $has_buy        = $this->member['m_traded_num'];
        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //判断这个订单是否已经存在分佣记录
        $order_deduct_storage = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
        $had_deduct = $order_deduct_storage->findOrderDeductListByTid($ttid);

        //如果不存在，设置分佣
        if(!$had_deduct){
            //使用店铺分佣设置
            $gratio  = $this->_deduct_translate($has_buy, $deduct_list);
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orders         = $order_model->fetchOrderListByTid($tid);

            $allTotal = 0;
            foreach ($orders as $item){
                $allTotal += $item['to_total'];
            }

            foreach ($orders as $item) {
                $total = $item['to_total'] - (($discount_fee + $promotion_fee) * ($item['to_total']/$allTotal));
                $gd     = $goods_deduct->findOpenDeduct($item['to_g_id']);
                $ratio  = $gd ? array(0 => $gd['gd_0f_ratio'], 1 => $gd['gd_1f_ratio'], 2 => $gd['gd_2f_ratio'], 3 => $gd['gd_3f_ratio']) : $gratio;
                //设置商品分佣
                Libs_Log_Logger::outputLog('555','wxapy.log');
                $order_deduct->createOrderDeduct($this->member['m_id'], $ttid, $total, $ratio, $item['to_g_id'],1,$round_type);
            }
        }
    }


    private function _deduct_translate($has_buy, $deduct_list) {
        $has_buy    = intval($has_buy) >= 0? intval($has_buy) : 0;
        $has_buy++;
        $range      = array_keys($deduct_list);
        sort($range, SORT_NUMERIC);//按数字来比较
        $index = 1;//提成字段索引
        foreach ($range as $val) {
            $val = intval($val);
            if ($has_buy < $val) {
                break;
            }
            $index = $val;
        }
        $deduct = $deduct_list[$index];
        return array(0 => $deduct['dc_0f_ratio'], 1  => $deduct['dc_1f_ratio'], 2  => $deduct['dc_2f_ratio'], 3  => $deduct['dc_3f_ratio']);
    }


    protected function _delete_cart_Action($ids){
        if($ids){
            if(strpos($ids,',')){    // 如果有多个值
                $ids = explode(',',$ids);
            }else{  // 只有一个值
                $ids = array($ids);
            }
            $where = array();
            $where[] = array('name'=>'sc_id','oper'=>'in','value'=>$ids);
            $where[] = array('name'=>'sc_m_id','oper'=>'=','value'=>$this->member['m_id']);
            $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
            return $cart_storage->deleteValue($where);
        }
    }


    private function _save_member_idcard($idcard,$name){
        if(plum_is_idcard($idcard)){
            if($idcard!=$this->member['m_id_num']){
                $updata = array(
                    'm_id_num' => $idcard
                );
                if(!empty($updata)){
                    $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                    $member_storage->updateById($updata,$this->member['m_id']);
                }
            }
        }
    }


    private function _get_ele_post_fee($trade, $lng, $lat){
        //获取门店
        $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
        $eleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['es_id']);

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->sid);
        $where = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'os_es_id','oper' => '=','value' =>$trade['t_es_id']);
        $where[]    = array('name' => 'os_is_deleted','oper' => '=','value' =>0);
        $where[]    = array('name' => 'os_ele_store_id','oper' => '!=','value' =>'');
        $storeList = $store_model->getList($where,0,0,array());

        $storeIds = array();
        foreach ($storeList as $value){
            $storeIds[] = $value['os_ele_store_id'];
        }

        $ele    = new App_Plugin_Food_AnubisEle();
        $storeRet = $ele->queryChainStore($storeIds);

        $distanceArrInfo  = [];
        $storeArr = [];
        if($storeRet && $storeRet['errcode'] == 0){
            foreach ($storeRet['result'] as $val){
                if($val['status'] == 2){
                    //获取距离
                    $url = 'https://restapi.amap.com/v3/direction/walking';
                    $params = array(
                        'origin'  => $val['longitude'].','.$val['latitude'],
                        'destination' => $lng.','.$lat,
                        'output'  => 'JSON',
                        'key'     => plum_parse_config('mapKay')  //web服务key
                    );
                    $res = Libs_Http_Client::get($url,$params);
                    $distanceArr = json_decode($res,1);
                    $distanceArrInfo[] = $distanceArr['route']['paths'][0]['distance'];
                    $val['distance'] = $distanceArr['route']['paths'][0]['distance'];
                    $storeArr[] = $val;
                }
            }
        }
        $store = $storeArr[array_search(min($distanceArrInfo),$storeArr)];
        if(!$store || ($store['status'] != 2 && $this->sid != 11 && $this->sid != 5741)){
            return array(
                'errcode' => 400,
                'msg' => "暂无法配送，请选择其他配送方式",
            );
        }else{
            $city = $store['city'];
            $post_model = new App_Model_Plugin_MysqlElePostCfgStorage();
            $post = $post_model->findRowByCity($city);

            $baseCfg = plum_parse_config('base', 'ele');
            $grade = $post['epc_grade']?$post['epc_grade']:$post['epc_type'];
            $baseFee = $baseCfg[$grade?$grade:'代理城市'];

            if(
                (time() >= strtotime('2019-01-28') && time() <= strtotime('2019-02-03')) ||
                (time() >= strtotime('2019-02-11') && time() <= strtotime('2019-02-17'))
            ){
                $baseFee += 5;
            }

            if((time() >= strtotime('2019-02-04') && time() <= strtotime('2019-02-10'))){
                $baseFee += 10;
            }


            $checkSend = $ele->queryDelivery($store['chain_store_code'], $lng, $lat, 3);
            Libs_Log_Logger::outputLog($checkSend);
            if($checkSend['errcode'] != 0){
                return array(
                    'errcode' => 400,
                    'msg' => $checkSend['errmsg'],
                );
            }
            //获取距离
            $distance = $store['distance'];
            $distance = $distance/1000; //获取到的是米 ，转化成千米
            $distanceCfg = plum_parse_config('distance', 'ele');
            $distanceFee = 0;
            if($distance > 6){
                return array(
                    'errcode' => 400,
                    'msg' => "超出配送范围",
                );
            }else{
                foreach ($distanceCfg as $val){
                    if($distance >= $val['min'] && $distance < $val['max']){
                        $distanceFee = $val['fee'];
                        break;
                    }
                }
            }
            //计算时间
            $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
            $eleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['t_es_id']);
            $timeCfg = plum_parse_config('time', 'ele');
            $nowTime = time()+($eleCfg['ec_send_timeout']?$eleCfg['ec_send_timeout']*60:10*60);
            $timeFee = 0;
            foreach ($timeCfg as $key => $val){
                if($nowTime >= strtotime($val['min']) && $nowTime <= strtotime($val['max'])){
                    $timeFee = $val['fee'];
                }
            }
            //计算重量
            $weightCfg = plum_parse_config('weight', 'ele');
            $tradeWeight = $trade['t_total_weight'];
            if(strstr($tradeWeight, 'Kg')){
                $tradeWeight = floatval($tradeWeight);
            }else{
                $tradeWeight = floatval($tradeWeight) / 1000;
            }
            if($tradeWeight > 15){
                return array(
                    'errcode' => 400,
                    'msg' => "超出配送重量",
                );
            }else{
                $weightFee = 0;
                foreach ($weightCfg as $key => $val){
                    if($tradeWeight > strtotime($val['min']) && $tradeWeight <= strtotime($val['max'])){
                        $weightFee = $val['fee'];
                    }
                }
                $postFee = $baseFee + $distanceFee + $timeFee + $weightFee;

                return array(
                    'errcode' => 0,
                    'postFee' => $postFee,
                    'storeId' => $store['chain_store_code']
                );
            }
        }
    }


    public function getPoseFeeAction(){
        $goods = $this->request->getStrParam('goods');
        $prov  = $this->request->getStrParam("prov");
        $city  = $this->request->getStrParam("city");
        $goods = json_decode(urldecode($goods), true);
        $post_fee = 0;
        $post_array = array();
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        foreach($goods as $val){
            $good = $goods_model->getRowById($val['gid']);
            if($good['g_expfee_type'] == 1 || $good['g_expfee_type'] == 0){
                //统一运费
                $post_array['g'.$val['gid']]['num'] += $val['num'];
                $post_array['g'.$val['gid']]['gid'] = $val['gid'];
            }else{
                //运费模板
                $post_array[$good['g_unified_tpid']]['num'] += $val['num'];
                if ($val['gfid'] > 0) {
                    $format     = $format_model->findFormatByGfid($val['gfid'], $val['gid']);
                    if ($format) {
                        if($format['gf_format_weight_type'] == 2){
                            $weight = $format['gf_format_weight'] * 1000;
                        }else{
                            $weight = $format['gf_format_weight'];
                        }
                        $post_array[$good['g_unified_tpid']]['weight'] += $weight * $val['num'];
                    }
                }else{
                    if($good['g_goods_weight_type'] == 2){
                        $weight = $good['g_goods_weight'] * 1000;
                    }else{
                        $weight = $good['g_goods_weight'];
                    }
                    $post_array[$good['g_unified_tpid']]['weight'] += $weight * $val['num'];

                }
                $post_array[$good['g_unified_tpid']]['gid'] = $val['gid'];
            }
        }
        $post_fee_arr = [0];
        foreach($post_array as $val){
            $one_post_fee = $this->_get_post_fee($val['gid'], $val['num'], $prov, $city, $val['weight']);
            $post_fee += $one_post_fee;
            $post_fee_arr[] = $one_post_fee;
        }
        if($this->sid == 11){
            $post_fee = max($post_fee_arr);
        }
        $info['data'] = $post_fee;
        $this->outputSuccess($info);
    }

    public function _get_post_fee($gid, $num, $prov, $city, $weight, $throwError = 0){
        if(!$prov && !$city){
            return 0;
        }
        $city_storage = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($gid);
        $addr_helper    = new App_Helper_Address();
        $region = $addr_helper->getLevelRegion($prov,$city,'',2);
        $pid = 0;
        if($region[1]){
            $pid = $region[1]['region_id'];
        }
        $cid = 0;
        if($region[2]){
            $cid = $region[2]['region_id'];
        }
        $post_fee = 0;
        if($goods['g_expfee_type'] == 1 || $goods['g_expfee_type'] == 0){
            $post_fee = $goods['g_unified_fee']*$num;
        }else{
            $row = $city_storage->getCityRow($goods['g_unified_tpid'],$pid,$cid);
            $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
            $template = $template_storage->getRowById($goods['g_unified_tpid']);
            if($row){
                if($template['sdt_type'] == 1){
                    if($num <= $row['sdc_first_num']){
                        $post_fee = $row['sdc_first_fee'];
                    }else{
                        $more = $num - $row['sdc_first_num'];
                        $less = $more % $row['sdc_add_num'];
                        $post_fee = $row['sdc_first_fee']+$row['sdc_add_fee']*floor($more/$row['sdc_add_num'])+($less>0?$row['sdc_add_fee']:0);
                    }
                }else{
                    if($weight <= ($row['sdc_first_num'] * 1000)){
                        $post_fee = $row['sdc_first_fee'];
                    }else{
                        $more = $weight - ($row['sdc_first_num'] * 1000);
                        $less = (($more*100) % ($row['sdc_add_num'] * 1000 * 100))/100;
                        $post_fee = $row['sdc_first_fee']+$row['sdc_add_fee']*floor($more/($row['sdc_add_num'] * 1000))+($less>0?$row['sdc_add_fee']:0);
                    }
                }
            }else{
                if($throwError){
                    $this->outputError($goods['g_name']."不在配送范围内,请修改配送地址");
                }else{
                    return 0;
                }
            }
        }
        return $post_fee;
    }


    public function getShopSendPriceAction(){
        $addrid = $this->request->getIntParam('addrid');
        $tid = $this->request->getStrParam('tid');

        $address_model = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address = $address_model->getRowById($addrid);

        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        //获得配送范围配置值及店铺经纬度
        $info['data'] = array(
            'needSum' => false,
            'price'   => 0
        );
        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendCfg = $send_model->findUpdateBySid(null,$trade['t_es_id']);
        if($sendCfg['acs_platform_send']){
            $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
            $sendCfg = $send_model->findUpdateBySid(null,0);
        }

        $sendRange = floatval($sendCfg['acs_send_range']);
        $shopLng   = $sendCfg['acs_shop_lng'];
        $shopLat   = $sendCfg['acs_shop_lat'];
        $lng = 0;
        $lat = 0;
        $distance = 0;
        if($address['ma_lng'] && $address['ma_lat']){
            //如果收货地址有经纬度 直接计算
            $lng = $address['ma_lng'];
            $lat = $address['ma_lat'];
            $distance = (2 * 6378.137* asin(sqrt(pow(sin(pi()*($lng-$shopLng)/360),2)+cos(pi()*$lat/180)* cos($shopLat * pi()/180)*pow(sin(pi()*($lat-$shopLat)/360),2))));
        }else{
            //根据收货地址获得经纬度 再进行计算
            $url = 'http://restapi.amap.com/v3/geocode/geo';
            $params = array(
                'address' => $address['ma_province'].$address['ma_city'].$address['ma_zone'].$address['ma_detail'],
                'city'    => $address['ma_city'],
                'output'  => 'JSON',
                'key'     => plum_parse_config('mapKay')  //web服务key
            );
            $res = Libs_Http_Client::get($url,$params);
            $geoArr = json_decode($res,1);
            $location = $geoArr['geocodes'][0]['location'];
            if($location){
                $locationArr = explode(',',$location);
                $lng = $locationArr[0];
                $lat = $locationArr[1];
                $distance = (2 * 6378.137* asin(sqrt(pow(sin(pi()*($lng-$shopLng)/360),2)+cos(pi()*$lat/180)* cos($shopLat * pi()/180)*pow(sin(pi()*($lat-$shopLat)/360),2))));
            }
        }

        $legwork_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->sid);
        $legworkCfg = $legwork_model->findUpdateBySidEsId($trade['t_es_id']);


        //验证入驻商家蜂鸟配送是否被平台关闭


        //判断是否开启蜂鸟配送
        //if($sendCfg['acs_ele_delivery'] == 1 && !($legworkCfg['aolc_open'] == 1 && $legworkCfg['aolc_appid'])){
        if(false){ //不再使用蜂鸟配送
            //获取门店
            $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
            $eleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['t_es_id']);
            $store_model    = new App_Model_Store_MysqlStoreStorage($this->sid);
            $where = array();
            $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->sid);
            $where[]    = array('name' => 'os_es_id','oper' => '=','value' =>$trade['t_es_id']);
            $where[]    = array('name' => 'os_is_deleted','oper' => '=','value' =>0);
            $where[]    = array('name' => 'os_ele_store_id','oper' => '!=','value' =>'');
            $storeList = $store_model->getList($where,0,0,array());

            $storeIds = array();
            foreach ($storeList as $value){
                $storeIds[] = $value['os_ele_store_id'];
            }

            if($storeIds){
                $ele    = new App_Plugin_Food_AnubisEle();
                $storeRet = $ele->queryChainStore($storeIds);
            }

            $distanceArrInfo  = [];
            $storeArr = [];
            if($storeRet && $storeRet['errcode'] == 0){
                foreach ($storeRet['result'] as $val){
                    if($val['status'] == 2){
                        //获取距离
                        $url = 'https://restapi.amap.com/v3/direction/walking';
                        $params = array(
                            'origin'  => $val['longitude'].','.$val['latitude'],
                            'destination' => $lng.','.$lat,
                            'output'  => 'JSON',
                            'key'     => plum_parse_config('mapKay')  //web服务key
                        );
                        $res = Libs_Http_Client::get($url,$params);
                        $distanceArr = json_decode($res,1);
                        $distanceArrInfo[] = $distanceArr['route']['paths'][0]['distance'];
                        $val['distance'] = $distanceArr['route']['paths'][0]['distance'];
                        $storeArr[] = $val;
                    }
                }
            }

            $store = '';
            if($storeRet){
                $store = $storeArr[array_search(min($distanceArrInfo),$storeArr)];
            }
            if(!$store || ($store['status'] != 2 && $this->sid != 11 && $this->sid != 5741)){
                $info['data'] = array(
                    'needSum' => false,
                    'price'   => '暂无法配送，请选择其他配送方式。'
                );
            }else{
                $city = $store['city'];
                $post_model = new App_Model_Plugin_MysqlElePostCfgStorage();
                $post = $post_model->findRowByCity($city);

                $baseCfg = plum_parse_config('base', 'ele');
                $grade = $post['epc_grade']?$post['epc_grade']:$post['epc_type'];
                $baseFee = $baseCfg[$grade?$grade:'代理城市'];

                if(
                    (time() >= strtotime('2019-01-28') && time() <= strtotime('2019-02-03')) ||
                    (time() >= strtotime('2019-02-11') && time() <= strtotime('2019-02-17'))
                ){
                    $baseFee += 5;
                }

                if((time() >= strtotime('2019-02-04') && time() <= strtotime('2019-02-10'))){
                    $baseFee += 10;
                }

                $checkSend = $ele->queryDelivery($store['chain_store_code'], $lng, $lat, 3);
                if($checkSend['errcode'] == 0){
                    //获取距离
                    $distance = $store['distance'];
                    $distance = $distance/1000; //获取到的是米 ，转化成千米
                    $distanceCfg = plum_parse_config('distance', 'ele');
                    $distanceFee = 0;
                    if($distance <= 6){
                        foreach ($distanceCfg as $val){
                            if($distance >= $val['min'] && $distance < $val['max']){
                                $distanceFee = $val['fee'];
                                break;
                            }
                        }
                        //计算时间
                        $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($this->sid);
                        $eleCfg = $ele_cfg_model->fetchUpdateCfg(null, $trade['t_es_id']);
                        $timeCfg = plum_parse_config('time', 'ele');
                        $nowTime = time()+($eleCfg['ec_send_timeout']?$eleCfg['ec_send_timeout']*60:10*60);
                        $timeFee = 0;
                        foreach ($timeCfg as $key => $val){
                            if($nowTime >= strtotime($val['min']) && $nowTime <= strtotime($val['max'])){
                                $timeFee = $val['fee'];
                            }
                        }
                        //计算重量
                        $weightCfg = plum_parse_config('weight', 'ele');
                        $tradeWeight = $trade['t_total_weight'];
                        if(strstr($tradeWeight, 'Kg')){
                            $tradeWeight = floatval($tradeWeight);
                        }else{
                            $tradeWeight = floatval($tradeWeight) / 1000;
                        }
                        if($tradeWeight > 15){
                            $info['data'] = array(
                                'needSum' => false,
                                'price'   => '暂无法配送，请选择其他配送方式.'
                            );
                        }else{
                            $weightFee = 0;
                            foreach ($weightCfg as $key => $val){
                                if($tradeWeight > strtotime($val['min']) && $tradeWeight <= strtotime($val['max'])){
                                    $weightFee = $val['fee'];
                                }
                            }
                            $postFee = $baseFee + $distanceFee + $timeFee + $weightFee;

                            $info['data'] = array(
                                'needSum' => true,
                                'price'   => floatval($postFee)
                            );
                        }
                    }else{
                        //超出配送范围
                        $info['data'] = array(
                            'needSum' => false,
                            'price'   => '超出配送范围.'
                        );
                    }
                }else{
                    //超出配送范围
                    $info['data'] = array(
                        'needSum' => false,
                        'price'   => $checkSend['errmsg']
                    );
                }
            }
        }elseif($legworkCfg['aolc_open'] == 1 && $legworkCfg['aolc_appid'] && $trade['t_applet_type'] != App_Helper_Trade::TRADE_APPLET_GROUP){//判断是否使用跑腿配送
            $legwork_helper = new App_Helper_Legwork($this->sid);
            $legworkRet = $legwork_helper->_get_legwork_post_price_new($legworkCfg['aolc_appid'],$shopLat,$shopLng,$lat,$lng);
            if($legworkRet['errcode'] != 0){
                $info['data'] = array(
                    'needSum' => false,
                    'price'   => '暂无法配送，请选择其他配送方式..',
                    'legworkRet' => $legworkRet
                );
            }else{
                $postFeeTrue = $legworkRet['data']['price'];
                $discountPost = 0;
                $sectionArr = json_decode($legworkCfg['aolc_price_section'],1);
                //计算补贴后的运费
                if(is_array($sectionArr)){
                    foreach ($sectionArr as $item){
                        if($postFeeTrue >= $item['min'] && $postFeeTrue < $item['max']){
                            $discountPost = $item['value'];
                            $postFeeTrue = $postFeeTrue - $item['value'];
                            break;
                        }
                    }
                }
                $info['data'] = array(
                    'needSum' => true,
                    'price'   => floatval($postFeeTrue),
                    'discountPost' => $discountPost,
                    'legworkRet' => $legworkRet
                );

            }
        }else{
            if(($distance && $distance > 0) || ($shopLng > 0 && $shopLat > 0 && $lng >0 && $lat > 0)){
                if($sendRange >0 && floatval($distance) > $sendRange){
                    //超出配送范围
                    $info['data'] = array(
                        'needSum' => false,
                        'price'   => '超出配送范围'
                    );
                }else{
                    $baseLong = floatval($sendCfg['acs_base_long']);
                    $basePrice = floatval($sendCfg['acs_base_price']);
                    if($baseLong > 0) {
                        //若设置了基本配送范围且在基本范围以内
                        $info['data'] = array(
                            'needSum' => true,
                            'price'   => floatval($basePrice)
                        );
                        //超出基本配送范围
                        if ($baseLong < $distance) {
                            $plusLong = floatval($sendCfg['acs_plus_long']);
                            $plusPrice = floatval($sendCfg['acs_plus_price']);
                            if($plusLong && $plusPrice){
                                //如果设置了每段距离和每段额外费用
                                $plusDistance = $distance - $baseLong;
                                $num = ceil($plusDistance/$plusLong);
                                $total = $basePrice + $num * $plusPrice;
                                $info['data'] = array(
                                    'needSum' => true,
                                    'price'   => floatval($total)
                                );
                            }
                        }
                    }
                }
            }else{
                //没有计算出有效距离  视为超出配送范围
                $info['data'] = array(
                    'needSum' => false,
                    'price'   => '超出配送范围'
                );
            }
        }

        $info['data']['distance'] = $distance;
        $info['data']['sendRange'] = $sendRange;
//        $info['data']['sendCfgId'] = $sendCfg['acs_id'];
//        $info['data']['esId'] = $trade['t_es_id'];

        $this->outputSuccess($info);
    }



    protected function _check_store_goods($storeId,$goods){
        $exist_gids = [];
        $store_gids = [];
        $goods_data = [];
        $goods_data_all = [];
        $single_goods_total_info = [];
        $goods_fee = 0;
        $goods_num = 0;
        $isallow = true;
        $store_goods_model = new App_Model_Cake_MysqlCakeStoreGoodsListStorage($this->sid);
        $goods_exist = $store_goods_model->getListByStoreid($storeId);
        if($goods_exist){
            foreach ($goods_exist as $val){
                $exist_gids[] = $val['asgl_g_id'];
            }
        }
        if($exist_gids){
            foreach ($goods as $v){
                if(in_array($v['gid'],$exist_gids)){
                    $v['canBuy'] = 1;
                    $store_gids[] = $v['gid'];
                    $goods_data_all[] = $v;
                    $goods_data[] = $v;
                    $goods_fee += $v['goodsFee'];
                    $goods_num += $v['num'];
                    $single_goods_total_info[] = [
                        'total' => $v['goodsFee'],
                        'num' => $v['num']
                    ];
                    if($v['actid'] > 0){
                        $isallow = false;
                    }
                }else{
                    $v['canBuy'] = 0;
                    $goods_data_all[] = $v;
                }
            }
        }

        $return = [
            'gids' => $store_gids,
            'goods_data' => $goods_data,
            'goods_data_all' => $goods_data_all,
            'goods_fee' => $goods_fee,
            'goods_num' => $goods_num,
            'isallow' => $isallow,
            'single_goods_total_info' => $single_goods_total_info
        ];

        return $return;
    }


}
