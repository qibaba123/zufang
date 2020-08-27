<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/12/5
 * Time: 下午5:05
 */

class App_Controller_Applet_AppointmentOrderController extends App_Controller_Applet_InitController{
    // 订单状态
    private $order_status_desc = array(
        App_Helper_Trade::TRADE_NO_PAY          => '等待买家付款',
        App_Helper_Trade::TRADE_WAIT_PAY_RETURN => '待支付确认',
        App_Helper_Trade::TRADE_HAD_PAY         => '买家已付款',
        App_Helper_Trade::TRADE_SHIP            => '卖家已派送',
        App_Helper_Trade::TRADE_FINISH          => '已完成',
        App_Helper_Trade::TRADE_CLOSED          => '已关闭',
        App_Helper_Trade::TRADE_REFUND          => '已退款',
    );

    public function __construct()
    {
        // if($_POST['test']==1)
        //     parent::__construct(true);
        // else
        parent::__construct();

    }

    /*
     * 预约下单
     */
    public function createTradeAction() {
        $buys   = $this->request->getStrParam('buys');
        $buys   = json_decode(urldecode($buys), true);

        if (!$buys || count($buys) == 0) {
            $this->displayJsonError("未订购任何商品");
        }
        $num_sum    = 0;
        $gids       = array();//商品ID
        $nums       = array();//商品数量
        $fids       = array();//商品规格ID
        $remarkExtra = array();
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        foreach ($buys as $one) {
            $num                       = abs(intval($one['num']));
            $num_sum                   += $num;
            $gids[]                    = intval($one['gid']);
            $nums[]                    = $num;
            $fids[intval($one['gid'])] = intval($one['gfid']);
            $good                      = $goods_model->findGoodsBySidGid($this->sid, intval($one['gid']));
        }

        if ($num_sum <= 0) {
            $this->displayJsonError("请选择订购的商品数量");
        }
        $list   = $goods_model->fetchGoodsBySidGids($this->sid, $gids);
        if (!$list) {
            $this->displayJsonError("未订购任何商品");
        }
        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        // 判断报名人数是否已满--付费预约下单时商品数量应该为1
        if(count($list)==1){
            $now_join=$this->_getJoinCount($list[0]['g_id']);
            $limit_num=$list[0]['g_number_limit'];
            if((!empty($limit_num)) && $limit_num<=$now_join)
                $this->displayJsonError("预约名额已满");


            // 判断当前用户报名的总次数与今日报名的总次数
            $g_limit        =$list[0]['g_limit'];       // 获取单人总共可报名的次数
            $g_day_limit    =$list[0]['g_day_limit'];   // 获取单人每日可报名的次数

            $limit_where=['name'=>'to_m_id','oper'=>'=','value'=>$this->member['m_id']];
            if($g_limit){
                $g_limit_now=$order_model->getJoinCount($list[0]['g_id'],$limit_where);      //已报名的总次数  
                if($g_limit<($g_limit_now+$nums[0]))
                    $this->displayJsonError("该活动最多可参与".$g_limit.'次');
            }
            if($g_day_limit){
                $limit_where[]=['name'=>'FROM_UNIXTIME(to_create_time,"%Y%m%d")','oper'=>'=','value'=>date('Ymd',time())];              
                $g_day_limit_now=$order_model->getJoinCount($list[0]['g_id'],$limit_where);  //今日已报名的次数
                if($g_day_limit<($g_day_limit_now+$nums[0]))
                    $this->displayJsonError("每天最多可参与".$g_day_limit.'次');
            }
           
        }

        foreach ($list as $val){
            foreach (json_decode($val['g_extra_message'], true) as $value){
                if(!in_array($value, $remarkExtra)){
                    $remarkExtra[] = $value;
                }
            }
        }

        $goods_fee  = 0;

      
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);

        $trade_type = App_Helper_Trade::TRADE_APPOINTMENT;//设置订单为预约类型订单
        $trade_extra= json_encode(array('gid' => current($gids)));//设置第一个商品ID
        for ($i=0; $i<count($list); $i++) {
            $list[$i]['order_type'] = App_Helper_Trade::TRADE_ORDER_NORMAL;//普通
            $price  = 0;
            $list[$i]['g_has_format']   = $format_model->getFromatCountByGid($list[$i]['g_id']);
            if ($list[$i]['g_has_format'] == 0) {//无商品规格时
                $price  = floatval($list[$i]['g_price']);
            } else if ($list[$i]['g_has_format'] > 0) {
                if ($fids[$list[$i]['g_id']] > 0) {
                    $format     = $format_model->findFormatByGfid($fids[$list[$i]['g_id']], $list[$i]['g_id']);
                    if ($format) {
                        $price  = floatval($format['gf_price']);
                        $list[$i]['g_format']   = $format['gf_name'];
                    }
                }
            }
            if ($list[$i]['g_has_format'] > 0 && $fids[$list[$i]['g_id']] <= 0) {
                $this->displayJsonError("商品 {$list[$i]['g_name']} 未选择订购规格, 请重新选择后再下单!");
            }

            $list[$i]['g_price']    = $price;
            $goods_fee  += ($price*$nums[$i]);//计算商品总价
        }
        $total_fee = $goods_fee;

        //创建交易--开始
        $indata = array(
            't_s_id'        => $this->sid,
            't_m_id'        => $this->member['m_id'],
            't_buyer_nick'  => $this->member['m_nickname'],
            't_buyer_openid'=> $this->member['m_openid'],
            't_tid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid),//生成唯一性订单ID
            't_title'       => $list[0]['g_name'],//取第一个商品名称作为订单标题
            't_pic'         => $list[0]['g_cover'],//取第一个商品封面作为订单图片
            't_num'         => $num_sum,
            't_goods_fee'   => $goods_fee,
            't_total_fee'   => $total_fee,
            't_payment'     => 0,
            't_status'      => 0,
            't_type'        => $trade_type,//订单类型
            't_extra_data'  => $trade_extra,//订单附加数据
            't_create_time' => time(),
            't_pickup_code' => plum_random_code(8),
        );
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $t_id   = $trade_model->insertValue($indata);
        if (!$t_id) {
            $this->displayJsonError("订单创建失败,请返回重试");
        }
        $orderGoods = array();
        //创建交易订单
        foreach ($list as $key => $item) {
            $todata = array(
                'to_s_id'       => $this->sid,
                'to_t_id'       => $t_id,
                'to_g_id'       => $item['g_id'],
                'to_gf_id'      => $fids[$item['g_id']],//规格ID,默认为0
                'to_gf_name'    => isset($item['g_format']) ? $item['g_format'] : '',
                'to_m_id'       => $this->member['m_id'],
                'to_g_brief'    => $item['g_brief'],
                'to_num'        => $nums[$key],
                'to_title'      => $item['g_name'],
                'to_pic'        => $item['g_cover'],
                'to_price'      => $item['g_price'],
                'to_total'      => floatval($item['g_price'])*$nums[$key],
                'to_type'       => $item['order_type'],
                'to_create_time'=> time(),
            );
            $order_model->insertValue($todata);
            $orderGoods[] = $todata;
        }

        $info['data'] = array(
            'trade'   => $this->_format_trade($indata),
            'goods'   => $this->_format_goods($orderGoods),
            'remarkExtra'    => $remarkExtra
        );
        $this->outputSuccess($info);
    }

    /**
     * 格式化订单数据
     */
    private function _format_trade($trade){
        return array(
            'mid'       => $trade['t_m_id'],
            'buyerNick' => $trade['t_buyer_nick'],
            'tid'       => $trade['t_tid'],
            'title'     => $trade['t_title'],
            'pic'       => plum_deal_image_url($trade['t_pic']),
            'num'       => $trade['t_num'],
            'goodsFee'  => $trade['t_goods_fee'],
            'totalFee'  => $trade['t_total_fee'],
            'time'      => date('Y-m-d H:i:s', $trade['t_create_time'])
        );
    }

    /**
     * 格式化商品
     */
    private function _format_goods($goods){
        $data = array();
        foreach ($goods as $key => $value) {
            $data[] = array(
                'id'      => $value['to_g_id'],
                'name'    => $value['to_title'],
                'cover'   => plum_deal_image_url($value['to_pic']),
                'price'   => $value['to_price'],
                'format'  => $value['to_gf_name'],
                'num'     => $value['to_num']
            );
        }
        return $data;
    }


    /*
     * 创建待支付订单
     */
    public function createAction() {
        //订单、支付信息
        $tid     = $this->request->getStrParam('tid');        // 订单编号
        $note    = $this->request->getStrParam('note', '');   // 留言
        $name    = $this->request->getStrParam('name');  //姓名
        $phone   = $this->request->getStrParam('phone'); //电话 
        $time    = $this->request->getStrParam('time');  //预约时间
        $address = $this->request->getStrParam('address'); //地址
        $remarkExtra   = $this->request->getStrParam('remarkExtra'); //附加留言
        $payType    = $this->request->getIntParam('payType', 1); //支付方式，1在线支付  2现金支付 3余额支付

//        if(strtotime($time) < time()){
//            $this->outputError('请选择正确的预约时间');
//        }

        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg = $pay_type->findRowPay();

        if(!$name || !$phone ){
            $this->outputError('请将姓名和电话填写完整');
        }

        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $num = $trade['t_num'];

        if($trade && $trade['t_status'] == 0){
            $goods_fee      = floatval($trade['t_goods_fee']);

            //获取订单商品
            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $order_list     = $order_model->fetchOrderListByTid($trade['t_id']);

            $ids    = array();
            foreach ($order_list as $item) {
                $ids[]  = $item['to_g_id'];
            }

            // 计算使用优惠券后的金额
            $total_fee      = floatval($trade['t_total_fee']);

            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
            $info['data'] = array(
                'status' => '',
            );

            //预约费用为0  直接成功
            if($total_fee == 0){
                $updata = array(
                    't_total_fee'          => $total_fee,
                    't_note'               => $note ? $note : $trade['t_note'],
                    't_addr_id'            => $addrid ? $addrid : $trade['t_addr_id'],
                    't_express_company'    => $name,
                    't_express_code'       => $phone,
                    't_address'            => $address,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_status'             => App_Helper_Trade::TRADE_HAD_PAY,//修改订单状态为已付款
                    't_remark_extra'    => $remarkExtra,
                    't_pay_time'        => time(),
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YHQM
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                $info['data']['status'] = 'zfcg';
                $trade_helper->dealTradeType($trade);
            }elseif ($payType == 2){
                $updata = array(
                    't_total_fee'          => $total_fee,
                    't_note'               => $note ? $note : $trade['t_note'],
                    't_addr_id'            => $addrid ? $addrid : $trade['t_addr_id'],
                    't_express_company'    => $name,
                    't_express_code'       => $phone,
                    't_address'            => $address,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_status'             => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,
                    't_remark_extra'    => $remarkExtra,
                    't_pay_time'        => time(),
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_HDFK
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                $info['data']['status'] = 'zfcg';
                $trade_helper->dealTradeType($trade);
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
                    't_total_fee'          => $total_fee,
                    't_note'               => $note ? $note : $trade['t_note'],
                    't_addr_id'            => $addrid ? $addrid : $trade['t_addr_id'],
                    't_express_company'    => $name,
                    't_express_code'       => $phone,
                    't_address'            => $address,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_status'             => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,
                    't_remark_extra'    => $remarkExtra,
                    't_pay_time'        => time(),
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YEZF
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid,$tid, $this->member['m_id'], $fee);
                if($debit){
                    $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $order = $order_model->fetchOrderListByTid($trade['t_id']);

                    $udata = array(
                        'to_num' => $num,
                        'to_total' => $order[0]['to_price']*$num
                    );
                    $order_model->updateById($udata, $order[0]['to_id']);
                    //订单活动后续处理
                    $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
                    $trade_helper->dealTradeType($trade);
                    $info['data']['status'] = 'zfcg';
                }
            } else{
                $updata = array(
                    't_total_fee'          => $total_fee,
                    't_note'               => $note ? $note : $trade['t_note'],
                    't_addr_id'            => $addrid ? $addrid : $trade['t_addr_id'],
                    't_express_company'    => $name,
                    't_express_code'       => $phone,
                    't_address'            => $address,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_status'             => App_Helper_Trade::TRADE_NO_PAY,//修改订单状态为待支付
                    't_remark_extra'    => $remarkExtra
                );
                //订单置于超时关闭队列
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $trade_redis->setTradeCloseTtl($trade['t_id'], $overTime);
                $info['data']['status'] = 'dzf';
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //是否触发通知
                $trade_helper->sendTradeStatusMessage($tid, App_Helper_Trade::TRADE_MESSAGE_SEND_MJXD);
            }

            
            if($ret){
                $this->outputSuccess($info);
            }else{
                $this->outputError('确认订单失败，请重试');
            }
        }else{
            $this->outputError('订单不存在');
        }
    }

    /*
     * 订单列表、订单条件查询
     */
    public function orderListAction()
    {
        $status = $this->request->getStrParam('status', 'all');   // 订单状态
        // 检索条件
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 't_status', 'oper' => '<>', 'value' => 0);
        $where[] = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPOINTMENT);
        // 获取订单状态
        $link = App_Helper_Trade::$trade_link_status;
        if ($status && isset($link[$status]) && ($link[$status]['id'] > 0)) {
            $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$status]['id']);
        }
        $data = $this->show_trade_list_data($where);
        if ($data) {
            $info['data'] = $data;
            $this->outputSuccess($info);
        } else {
            $this->outputError('订单数据加载完毕');
        }
    }


    private function show_trade_list_data($where = array())
    {
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $sort = array('t_create_time' => 'DESC');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $list = $trade_model->getList($where, $index, $this->count, $sort);

        if ($list) {
            $statusNote = plum_parse_config('trade_status');
            $data = array();
            foreach ($list as $val) {
                $store_storage = new App_Model_Cake_MysqlCakeStoreStorage($this->sid);
                $store  = $store_storage->getRowById($val['t_store_id']);
                $data[] = array(
                    'tid'           => $val['t_tid'],
                    'nickname'      => $val['t_buyer_nick'],
                    'cover'         => plum_deal_image_url($val['t_pic']),
                    'title'         => $val['t_title'],
                    'num'           => $val['t_num'],
                    'status'        => $val['t_status'],
                    'statusNote'    => isset($statusNote[$val['t_status']]) ? $statusNote[$val['t_status']] : '',
                    'feedback'      => $val['t_feedback'],
                    'fdstatus'      => $val['t_fd_status'],
                    'result'        => $val['t_fd_result'],
                    'iscomment'     => $this->shop['s_order_comment'] == 0 ? 1 : $val['t_had_comment'],
                    'appointmentTime'=> $val['t_appointment_time'] ? date('Y-m-d H:i', $val['t_appointment_time']) : date('Y-m-d H:i', $val['t_create_time']),
                    'time'          => date('Y-m-d H:i:s', $val['t_create_time']),
                    'paytime'       => isset($val['t_pay_time']) && $val['t_pay_time'] ? date('Y-m-d H:i:s', $val['t_pay_time']) : '',
                    'goods'         => $this->show_trade_goods_detail_data($val['t_id']),
                    'total'         => floatval($val['t_total_fee'])
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    //订单详情
    public function orderDetailsAction()
    {
        $tid = $this->request->getStrParam('tid');  // 订单编号
        if ($tid) {
            $trade = $this->show_trade_details_data($tid);
            if($trade){
                $info['data'] = $trade;
                $this->outputSuccess($info);
            }else{
                $this->outputError('订单不存在或已被删除');
            }
        } else {
                $this->outputError('网络链接错误请重试！');
        }
    }


    /*
     * 订单详情数据展示
     */
    private function show_trade_details_data($tid){
        $data = array();
        if ($tid) {
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade = $trade_model->getRowBySid($tid);
            $payType = App_Helper_Trade::$trade_pay_type_note;
            if ($trade) {
                $statusNote = $this->order_status_desc;
                $verify = $this->_fetch_order_verify($trade);
                $data = array(
                    'id'             => $trade['t_id'],
                    'tid'            => $trade['t_tid'],
                    'title'          => $trade['t_title'],
                    'num'            => $trade['t_num'],
                    'paytype'        => $trade['t_pay_type'],
                    'payTypeNote'    => $payType[$trade['t_pay_type']],
                    'total'          => $trade['t_total_fee'],
                    'goodsFee'       => $trade['t_goods_fee'],
                    'discount'       => $trade['t_discount_fee'],
                    'nickname'       => $trade['t_buyer_nick'],
                    'status'         => $trade['t_status'],
                    'statusNote'     => isset($statusNote[$trade['t_status']]) ? $statusNote[$trade['t_status']] : '',
                    'name'           => $trade['t_express_company'],
                    'phone'          => $trade['t_express_code'],
                    'address'        => $trade['t_address'],
                    'note'           => $trade['t_note'],
                    'feedback'      => $trade['t_feedback'],
                    'fdstatus'      => $trade['t_fd_status'],
                    'result'        => $trade['t_fd_result'],
                    'appointmentTime'=> $trade['t_appointment_time'] ? date('Y-m-d H:i', $trade['t_appointment_time']) : date('Y-m-d H:i',$trade['t_create_time']),
                    'createTime'     => date('Y-m-d H:i:s', $trade['t_create_time']),
                    'payTime'        => date('Y-m-d H:i:s', $trade['t_pay_time']),
                    'goods'          => $this->show_trade_goods_detail_data($trade['t_id']),
                    'verifyCode'     => $verify['code'],
                    'verifyQrcode'   => $verify['qrcode'],
                    'extraRemark'    => $trade['t_remark_extra']?$this->_deal_extra_remark($trade['t_remark_extra']):[],
                );
            }
        }
        return $data;
    }

    private function _deal_extra_remark($remark){
        $data = json_decode($remark, true);
        foreach ($data as $key => $val){
            if($val['type'] == 'image'){
                $data[$key]['value'] = $this->dealImagePath($val['value']);
            }
        }
        return $data;
    }



    /*
    * 订单商品详情数据
     */
    private function show_trade_goods_detail_data($tid)
    {
        //获取交易订单商品
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order = $order_model->fetchOrderListByTid($tid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $data = array();
        if ($order) {
            foreach ($order as $val) {
                $goods = $goods_model->getRowById($val['to_g_id']);
                $data[] = array(
                    'toid'  => $val['to_id'],
                    'gid'   => $val['to_g_id'],
                    'title' => $val['to_title'],
                    'spec'  => isset($val['to_gf_name']) ? $val['to_gf_name'] : '',
                    'img'   => isset($val['to_pic']) ? plum_deal_image_url($val['to_pic']) : '',
                    'length'=> $goods['g_appointment_length'],
                    'appointmentDate' => $goods['g_appointment_date'].' '.$goods['g_appointment_time'],
                    'price' => $val['to_price'],
                    'num'   => $val['to_num'],
                    'total' => $val['to_total'],
                    'brief' => $val['to_g_brief'],
                    'type'  => $val['to_type'],
                );
            }
        }
        return $data;
    }




    /* 
        *付费预约修改
        *2019-02-23
        *zhanzgc
    */

    // 获取报名的人数的列表以及报名的总人数
    public function getJoinCount(){
        $goods_id=$this->request->getStrParam('goods_id');
        $count=$this->_getJoinCount($goods_id);
        $info['data']['count']=intval($count);
        $this->outputSuccess($info);
    }
    private function _getJoinCount($goods_id){
        $t_o_model=new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $count=$t_o_model->getJoinCount($goods_id);
        return $count;
    }
    // 获取报名的列表信息
    public function getJoinList(){
        $goods_id=$this->request->getStrParam('goods_id');
        $page=$this->request->getIntParam('page',1);
        $count=$this->request->getIntParam('count',0);
        if($count>100)
            $count=100;
        $trade_order_model=new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        if($count)
            $res=$trade_order_model->getJoinList($goods_id,$page,$count);
        else
            $res=$trade_order_model->getJoinList($goods_id,$page);
        if(empty($res))
            $this->outputError('已经到底了');
        else
            $info['data']['list']=$res;
            $this->outputSuccess($info);
    }

}