<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/12/5
 * Time: 下午5:05
 */
class App_Controller_Applet_OrderController extends App_Controller_Applet_InitController
{
    // 订单状态
    private $order_status_desc = array(
        App_Helper_Trade::TRADE_NO_PAY          => '待付款',
        App_Helper_Trade::TRADE_WAIT_PAY_RETURN => '待支付确认',
        App_Helper_Trade::TRADE_HAD_PAY         => '待发货',
        App_Helper_Trade::TRADE_SHIP            => '待收货',
        App_Helper_Trade::TRADE_FINISH          => '已完成',
        App_Helper_Trade::TRADE_CLOSED          => '已关闭',
        App_Helper_Trade::TRADE_REFUND          => '已退款',
    );

    private $order_post_type = array(
        1 => '商家配送',
        2 => '门店自提',
        3 => '快递发货',
        4 => '平台配送',
        5 => '商家配送',
        6 => '团长配送',
        7 => '骑手配送',
    );

    private $group_status_desc = array(
        App_Helper_Group::GROUP_STATUS_RUNNING => '待成团',
        App_Helper_Group::GROUP_STATUS_SUCCESS => '拼团成功',
        App_Helper_Group::GROUP_STATUS_FAILURE => '拼团失败',
    );

    public function __construct()
    {
        parent::__construct();

    }
    /*
     * 订单列表、订单条件查询
     */
    public function orderListAction()
    {
        $status      = $this->request->getStrParam('status', 'all'); // 订单状态
        $title       = $this->request->getStrParam('title'); // 商品名称
        $number      = $this->request->getStrParam('number'); // 订单编号
        $type        = $this->request->getIntParam('type'); //小程序订单类型
        $knowpayType = $this->request->getIntParam('knowpayType'); //知识付费类型 1图文 2音频 3视频
        $independent = $this->request->getIntParam('independent', 0);
        // 检索条件
        $where   = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 't_status', 'oper' => '<>', 'value' => 0);
        $where[] = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
        if ($type == 0 || $this->applet_cfg['ac_type'] == 7) {
            $where[] = array('name' => 't_independent_mall', 'oper' => '=', 'value' => $independent);
        }
        if ($type) {
            $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => $type);
        }
        // 获取订单状态
        $link = App_Helper_Trade::$trade_link_status;
        if ($status && isset($link[$status]) && ($link[$status]['id'] > 0)) {
            if ($status == 'refund') {
                $where[] = array('name' => 't_feedback', 'oper' => '=', 'value' => App_Helper_Trade::FEEDBACK_YES);
            } else {
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$status]['id']);
            }
        }
        if ($knowpayType) {
            $where[] = array('name' => 't_knowpay_type', 'oper' => '=', 'value' => $knowpayType);
        }
        //砍价订单只显示已经付完款的
        if ($type == 5 && (!$status || $status == 'all')) {
            $where[] = array('name' => 't_status', 'oper' => '>', 'value' => 2);
        }
        if ($title) {
            $where[] = array('name' => 't_title', 'oper' => 'like', 'value' => "%{$title}%");
        }
        if ($number) {
            $where[] = array('name' => 't_id', 'oper' => '=', 'value' => $number);
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
        $page        = $this->request->getIntParam('page');
        $index       = $page * $this->count;
        $sort        = array('t_create_time' => 'DESC');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $list        = $trade_model->getListEnterShop($where, $index, $this->count, $sort);

        if ($list) {
            $statusNote        = plum_parse_config('trade_status');
            $legworkStatusNote = App_Helper_Legwork::$trade_status_note;
            $data              = array();
            // $tids = array();
            foreach ($list as $val) {
                $data[] = array(
                    'tid'          => $val['t_tid'],
                    'nickname'     => $val['t_buyer_nick'],
                    'paytype'      => $val['t_pay_type'],
                    'cover'        => plum_deal_image_url($val['t_pic']),
                    'title'        => $val['t_title'],
                    'num'          => $val['t_num'],
                    'total'        => $val['t_total_fee'],
                    'discount'     => $val['t_discount_fee'],
                    'promotion'    => $val['t_promotion_fee'],
                    'freight'      => $val['t_post_fee'],
                    'needExpress'  => $val['t_need_express'],
                    'express_code' => $val['t_express_code'],
                    'status'       => $val['t_status'],
                    'statusNote'   => $val['t_express_method'] == 7 ? (isset($legworkStatusNote[$val['t_status']]) ? $legworkStatusNote[$val['t_status']] : '') : ($val['t_status'] == 3 && $val['t_pay_type'] == 4 ? '货到付款' : (isset($statusNote[$val['t_status']]) ? $statusNote[$val['t_status']] : '')),
                    'feedback'     => $val['t_feedback'],
                    'fdstatus'     => $val['t_fd_status'],
                    'result'       => $val['t_fd_result'],
                    'iscomment'    => $this->shop['s_order_comment'] == 0 ? 1 : $val['t_had_comment'],
                    'time'         => date('Y-m-d H:i:s', $val['t_create_time']),
                    'paytime'      => isset($val['t_pay_time']) && $val['t_pay_time'] ? date('Y-m-d H:i:s', $val['t_pay_time']) : '',
                    'goods'        => $this->show_trade_goods_detail_data($val['t_id']),
                    'postType'     => $val['t_express_method'],
                    'shopName'     => isset($val['es_name']) && $val['es_name'] ? $val['es_name'] : $this->shop['s_name'],

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
        $tid = $this->request->getStrParam('tid'); // 订单编号
        if ($tid) {
            $trade = $this->show_trade_details_data($tid);
            if ($trade) {
                $info['data'] = $trade;
                $this->outputSuccess($info);
            } else {
                $this->outputError('订单不存在或已被删除');
            }
        } else {
            $this->outputError('网络链接错误请重试！');
        }
    }

    /*
     * 订单详情数据展示
     */
    private function show_trade_details_data($tid)
    {
        $data = array();
        if ($tid) {
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade       = $trade_model->getRowBySid($tid);
            if ($trade) {
                $statusNote        = plum_parse_config('trade_status');
                $legworkStatusNote = App_Helper_Legwork::$trade_status_note;
                $payType           = App_Helper_Trade::$trade_pay_type_note;
                $verify            = $this->_fetch_order_verify($trade);

                $allowCustomPostName = plum_parse_config('custom_post_name', 'allow');
                $order_post_type     = in_array($this->applet_cfg['ac_type'], $allowCustomPostName) ? $this->_get_custom_post_name() : $this->order_post_type;

                // 获取入驻店铺信息
                $settledShop = array();
                if ($trade['t_es_id']) {
                    $settledShop = array(
                        'id'      => $trade['t_es_id'],
                        'name'    => $trade['es_name'],
                        'phone'   => $trade['es_phone'],
                        'address' => $trade['es_addr'] ? $trade['es_addr'] : '',
                        'lng'     => $trade['es_lng'],
                        'lat'     => $trade['es_lat'],
                    );
                }

                $receiveStore = array();
                if ($trade['t_express_method'] == 2) {
                    if ($trade['t_store_id']) {
                        //如果有自提门店id  取自提门店信息
                        $store_model = new App_Model_Store_MysqlStoreStorage($this->sid);
                        $row         = $store_model->getRowById($trade['t_store_id']);
                        if ($row) {
                            $receiveStore = array(
                                'id'      => intval($row['os_id']),
                                'name'    => $row['os_name'],
                                'phone'   => $row['os_contact'],
                                'address' => $row['os_addr'] ? $row['os_addr'] : '',
                                'lng'     => $row['os_lng'],
                                'lat'     => $row['os_lat'],
                            );
                        }
                    } elseif ($trade['t_es_id']) {
                        //自提且为多店订单 取门店信息
                        $receiveStore = array(
                            'id'      => $trade['t_es_id'],
                            'name'    => $trade['es_name'],
                            'phone'   => $trade['es_phone'],
                            'address' => $trade['es_addr'] ? $trade['es_addr'] : '',
                            'lng'     => $trade['es_lng'],
                            'lat'     => $trade['es_lat'],
                        );
                    } else {
                        //如果没有id  取订单店铺配送配置
                        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                        $sendCfg    = $send_model->findUpdateBySid();
                        if ($sendCfg) {
                            $receiveStore = array(
                                'id'      => -1,
                                'name'    => $this->shop['s_name'],
                                'phone'   => $this->shop['s_phone'],
                                'address' => $sendCfg['acs_shop_address'] ? $sendCfg['acs_shop_address'] : '',
                                'lng'     => $sendCfg['acs_shop_lng'],
                                'lat'     => $sendCfg['acs_shop_lat'],
                            );
                        }
                    }
                }


                $data = array(
                    'id'             => $trade['t_id'],
                    'tid'            => $trade['t_tid'],
                    'title'          => $trade['t_title'],
                    'num'            => $trade['t_num'],
                    'total'          => $trade['t_total_fee'],
                    'coinPayment'    => $trade['t_coin_payment'],
                    'payment'        => floatval($trade['t_total_fee'] - $trade['t_coin_payment']),
                    'points'         => floor($trade['t_points']),
                    'nickname'       => $trade['t_buyer_nick'],
                    'status'         => $trade['t_status'],
                    'statusNote'     => $trade['t_express_method'] == 7 ? (isset($legworkStatusNote[$trade['t_status']]) ? $legworkStatusNote[$trade['t_status']] : '') : ($trade['t_status'] == 3 && $trade['t_pay_type'] == 4 ? '货到付款' : (isset($statusNote[$trade['t_status']]) ? $statusNote[$trade['t_status']] : '')),
                    'needExpress'    => $trade['t_need_express'],
                    'expressCompany' => isset($trade['t_express_company']) && $trade['t_express_company'] ? $trade['t_express_company'] : '无需物流',
                    'expressCode'    => isset($trade['t_express_code']) && $trade['t_express_code'] ? $trade['t_express_code'] : '无需物流',
                    'freight'        => $trade['t_post_fee'],
                    'goodsFee'       => $trade['t_goods_fee'],
                    'totalWeight'    => floatval($trade['t_total_weight']) ? $trade['t_total_weight'] : 0,
                    'oriFee'         => $trade['t_ori_fee'],
                    'discount'       => $trade['t_discount_fee'],
                    'promotion'      => $trade['t_promotion_fee'],
                    'feedback'       => $trade['t_feedback'],
                    'fdstatus'       => $trade['t_fd_status'],
                    'result'         => $trade['t_fd_result'],
                    'consignee'      => isset($trade['ma_name']) ? $trade['ma_name'] : '',
                    'phone'          => isset($trade['ma_phone']) ? $trade['ma_phone'] : '',
                    'postcode'       => isset($trade['ma_post']) ? $trade['ma_post'] : '',
                    'address'        => $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] .$trade['ma_pcda']. $trade['ma_detail'],
                    'createTime'     => date('Y-m-d H:i:s', $trade['t_create_time']),
                    'payType'        => $trade['t_pay_type'],
                    'payTypeNote'    => $payType[$trade['t_pay_type']],
                    'payTime'        => isset($trade['t_pay_time']) && $trade['t_pay_time'] ? date('Y-m-d H:i:s', $trade['t_pay_time']) : '',
                    'goods'          => $this->show_trade_goods_detail_data($trade['t_id'], $trade['t_extra_data'], $trade['t_es_id']),
                    'compartment'    => $trade['t_home'],
                    'qrcode'         => $this->dealImagePath($trade['t_qrcode']),
                    'remarks'        => $trade['t_note'],
                    'note'           => $trade['t_note'],
                    'todayNum'       => $this->_get_trade_number($trade),
                    'isComment'      => $this->shop['s_order_comment'] == 0 ? 1 : $trade['t_had_comment'],
                    'orderType'      => $trade['t_applet_type'],
                    'postType'       => $trade['t_express_method'],
                    'postTypeNote'   => $trade['t_express_method'] ? $order_post_type[$trade['t_express_method']] : '无需物流',
                    'receiverName'   => isset($trade['t_express_company']) ? $trade['t_express_company'] : '',
                    'receiverPhone'  => isset($trade['t_express_code']) ? $trade['t_express_code'] : '',
                    'shopAddress'    => '郑州市郑东新区',
                    'shopLng'        => '113.5',
                    'shopLat'        => '35.5',
                    'verifyCode'     => $verify['code'],
                    'verifyQrcode'   => $verify['qrcode'],
                    'shopName'       => isset($trade['es_name']) && $trade['es_name'] ? $trade['es_name'] : $this->shop['s_name'],
                    'extraRemark'    => $trade['t_remark_extra'] ? $this->_deal_extra_remark($trade['t_remark_extra']) : [],
                    'receiveStore'   => $receiveStore,
                    'expressNote'    => $trade['t_express_note'] ? $trade['t_express_note'] : '',
                    'settledShop'    => $settledShop,
                    'shopPhone'      => $trade['es_id'] && $trade['es_phone'] ? $trade['es_phone'] : $this->shop['s_phone']
                );
            //  if(($trade['t_status'] == 3 || $trade['t_status'] == 4) && $trade['t_feedback'] == 0){
            //  	 $data['return_status'] = 1;
            //  }else{
              	if($trade['t_status'] == 6){
                    if(($trade['t_finish_time']+(3600*24*$this->shop['s_return_time']))>time()){
                        $data['return_status'] = 1;
                    }else{
                        $data['return_status'] = 0;
                    }
                }else{
                    $data['return_status'] = 0;
               }
             // } 
                if ($trade['t_status'] == 3 && $trade['t_pay_type'] == 4) {
                    // 货到付款方式
                    $data['statusNote'] = $payType[$trade['t_pay_type']];
                }

                $riderName     = '';
                $riderMobile   = '';
                $riderAvatar   = '';
                $legworkCode   = '';
                $legworkQrcode = '';
                if ($trade['t_express_method'] == 7) {
                    $legwork_trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
                    $legworkTrade        = $legwork_trade_model->getTradeRowOther($trade['t_tid']);
                    $riderName           = $legworkTrade['alr_name'] ? $legworkTrade['alr_name'] : '';
                    $riderAvatar         = $legworkTrade['alt_rider'] ? ($legworkTrade['alr_avatar'] ? $this->dealImagePath($legworkTrade['alr_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png')) : '';
                    $riderMobile         = $legworkTrade['alr_mobile'] ? $legworkTrade['alr_mobile'] : '';
                    $legworkCode         = $legworkTrade['alt_code'];
                    $legworkQrcode       = $legworkTrade['alt_qrcode'] ? $this->dealImagePath($legworkTrade['alt_qrcode']) : '';
                }
                $data['riderName']     = $riderName;
                $data['riderMobile']   = $riderMobile;
                $data['riderAvatar']   = $riderAvatar;
                $data['legworkCode']   = $legworkCode;
                $data['legworkQrcode'] = $legworkQrcode;
            }
        }
        return $data;
    }

    private function _deal_extra_remark($remark)
    {
        $data = json_decode($remark, true);
        foreach ($data as $key => $val) {
            if ($val['type'] == 'image') {
                $data[$key]['value'] = $this->dealImagePath($val['value']);
            }
            if ($val['type'] == 'checkbox') {
                $data[$key]['value'] = implode(',', $val['value']);
            }
        }
        return $data;
    }

    /**
     * @param $tid
     * @return array获取该订单是今天第几单
     */
    private function _get_trade_number($trade)
    {
        $num = 1;
        if ($trade['t_create_time'] > 0) {
            $where       = array();
            $where[]     = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]     = array('name' => 't_create_time', 'oper' => '>', 'value' => strtotime(date('y-m-d')));
            $where[]     = array('name' => 't_create_time', 'oper' => '<=', 'value' => $trade['t_create_time']);
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $num         = $trade_model->currentOrderNum($where);
        }
        return $num;

    }

    /*
     * 订单商品详情数据
     */
    private function show_trade_goods_detail_data($tid, $extra = '', $esId = 0)
    {
        $extra = json_decode($extra, true);
        //获取交易订单商品
        $order_model      = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order            = $order_model->getGoodsListByTid($tid);
        $refundStatusNote = array('退款中', '拒绝退款', '已退款', '撤销维权');
        $data             = array();
        if ($order) {
            foreach ($order as $val) {
                $data[] = array(
                    'toid'             => $val['to_id'],
                    'actid'            => $extra['actid'] ? $extra['actid'] : 0,
                    'gid'              => $val['to_g_id'],
                    'title'            => $val['to_title'],
                    'spec'             => isset($val['to_gf_name']) ? $val['to_gf_name'] : '',
                    'img'              => isset($val['to_pic']) ? plum_deal_image_url($val['to_pic']) : '',
                    'price'            => $val['to_price'],
                    'weight'           => floatval($val['g_goods_weight']) ? floatval($val['g_goods_weight']) . ($val['g_goods_weight_type'] == 1 ? 'g' : 'Kg') : 0,
                    'num'              => $val['to_num'],
                    'total'            => $val['to_total'],
                    'type'             => $val['to_type'],
                    'gtype'            => $val['g_type'],
                    'sendDate'         => $val['to_se_send_time'] ? date('Y-m-d', $val['to_se_send_time']) : '',
                    'refundStatus'     => $val['to_feedback'],
                    'refundStatusNote' => $refundStatusNote[$val['to_fd_result']],
                    'esId'             => $esId,
                );
            }
        }
        return $data;
    }

    /*
     * 培训订单商品课程数据
     */
    private function show_trade_course_detail_data($tid, $extra = '')
    {
        $extra = json_decode($extra, true);
        //获取交易订单商品
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order       = $order_model->getCourseByTid($tid);
        $data        = array();
        if ($order) {
            $data[] = array(
                'toid'  => $order['to_id'],
                'gid'   => $order['atc_id'],
                'title' => $order['to_title'],
                'spec'  => isset($order['to_gf_name']) ? $order['to_gf_name'] : '',
                'img'   => isset($order['to_pic']) ? plum_deal_image_url($order['to_pic']) : '',
                'price' => $order['to_price'],
                'num'   => $order['to_num'],
                'total' => $order['to_total'],
                'type'  => $order['to_type'],
            );
        }
        return $data;
    }

    /*
     * 取消订单
     */
    public function cancelOrderAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            if ($trade['t_m_id'] == $this->member['m_id']) {
                if ($trade['t_status'] <= App_Helper_Trade::TRADE_NO_PAY) {
                    $trade_helper = new App_Helper_Trade($this->sid);
                    $ret          = $trade_helper->closeOvertimeTrade($trade['t_id']);
                    if ($ret) {
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '取消订单成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError("订单取消失败");
                    }
                } else {
                    $this->outputError('订单无法取消');
                }
            } else {
                $this->outputError('非法操作');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /**
     * 获取订单物流跟踪信息
     */
    public function fetchTrackAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            if ($trade['t_need_express'] && isset($trade['t_need_express'])) {
                //$track = App_Helper_ExpressTrack::fetchJsonTrack($trade['t_company_code'], $trade['t_express_code']);
                $aliyun_storage = new App_Plugin_Aliyun_Apiset();
                $result         = $aliyun_storage->queryExpressData($trade['t_express_code']);
                if (!$result['errcode']) {
                    $info['data'] = array(
                        'track'    => array(),
                        'goodsImg' => $this->dealImagePath($trade['t_pic']),
                        'company'  => $trade['t_express_company'],
                        'result'   => $result['result'],
                    );
                    $this->outputSuccess($info);
                } else {
                    $this->displayJsonError("物流信息查询失败,请稍后重试!");
                }
            } else {
                $this->outputError('无需物流');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 申请退款
     * 重构（用户申请退款逻辑优化）
     * zhangzc
     * 2019-09-27
     */
    public function applyRefundAction()
    {
        $tid       = $this->request->getStrParam('tid');
        $toid      = $this->request->getIntParam('toid');
        $reason    = $this->request->getStrParam('reason');
        $contact   = $this->request->getStrParam('contact');
        $reasonImg = $this->request->getStrParam('reasonImg');
        $money     = $this->request->getFloatParam('money', 0);
        $overtime  = plum_parse_config('trade_overtime');

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        // $trade       = $trade_model->findUpdateTradeByTid($tid);
        $trade = $trade_model->findTradeByTidToid($tid, $toid);

        if (!$trade) {
            $this->displayJsonError('订单不存在');
        }

        // 检查退款金额是否符合要求
        if (!($money >= 0 && $money <= $trade['t_total_fee'])) {
            $this->outputError("退款金额已超过订单的总金额");
        }

        if (!(in_array($trade['t_status'], array(3, 4, 5)) || (($trade['t_status'] == App_Helper_Trade::TRADE_FINISH) && ((intval($trade['t_finish_time']) + intval($overtime['none'])) > time())))) {
            $this->displayJsonError('该订单暂不支持退款操作');
        }

        // 整单退款时如果已有子订单是否已经有核销
        // 子订单退款时判断当前子订单是已被核销
        // 查询出该订单中所有的子订单-(若传入了toid 仅查询子订单)
        $order_model   = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $where_order[] = ['name' => 'to_t_id', 'oper' => '=', 'value' => $trade['t_id']];
        if ($toid) {
            $where_order[] = ['name' => 'to_id', 'oper' => '=', 'value' => $toid];
        }
        $order_list = $order_model->getList($where_order);

        // 社区团购判断订单中是否有商品已经被核销
        if ($this->applet_cfg['ac_type'] == 32) {
            $has_verify = array_column($order_list, 'to_se_verify');
            if (in_array(1, $has_verify)) {
                $this->outputError('订单已有商品被核销，不能退款');
            }
        }

        if ($toid) {
            $order = $order_list[0];
            // 计算单品退款的金额
            if ($order['to_fee']) {
                $to_money = floatval($order['to_fee'] / 100);
            } else {
                $to_money = round(($order['to_total'] / $trade['t_goods_fee']) * ($trade['t_total_fee'] - $trade['t_post_fee']), 2);
            }

            // 单品退款判断退款金额是否合理
            // zhangzc
            // 2019-09-04
            if ($money > $to_money) {
                $this->outputError('当前退款金额超过该商品可退款金额');
            }

            // 单品是否存在已经进行中的维权
            // 0：无退款
            // 2：申请退款
            // 3：拒绝后再申请
            // 4：拒绝退款
            // 7：主动退款|同意退款
            // 8：买家撤销|自动撤销
            $order_status = intval($order['to_feedback']) + intval($order['to_fd_status']) + intval($order['to_fd_result']);
            if (in_array($order_status, [2, 3, 7])) {
                $this->displayJsonError('该商品已存在维权处理~');
            }

        } else {
            $trade_status = intval($trade['t_feedback']) + intval($trade['t_fd_status']) + intval($trade['t_fd_result']);
            if (in_array($trade_status, [2, 3, 7])) {
                $this->displayJsonError('该订单已存在维权处理~');
            }

        }

        //创建退款申请（先进行退款记录的插入）
        $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
        // 查看现有的退款记录是否可以进行退款操作
        // zhangzc
        // 2019-12-31
        $refund_where = [
            ['name' => 'tr_s_id', 'oper' => '=', 'value' => $this->sid],
            ['name' => 'tr_tid', 'oper' => '=', 'value' => $tid],
        ];
        $refund_exist = $refund_model->getList($refund_where);
        foreach ($refund_exist as $key => $value) {
            if (empty($value['tr_to_id'])) {
                $this->displayJsonError("该订单已进行过整单退款处理，无法在进行子订单退款");
            }
            if (!empty($toid) && $value['tr_to_id'] == $toid) {
                $this->displayJsonError('请勿重复生成退款订单');
            }
        }

        $indata = array(
            'tr_s_id'        => $this->sid,
            'tr_es_id'       => $trade['t_es_id'], //入驻店铺id
            'tr_wid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
            'tr_tid'         => $tid,
            'tr_to_id'       => $toid,
            'tr_reason'      => $reason,
            'tr_contact'     => $contact,
            'tr_money'       => $money,
            'tr_create_time' => time(),
        );
        if ($reasonImg) {
            $indata['tr_reason_img'] = $reasonImg;
        }
        $rfid = $refund_model->insertValue($indata);

        // 后修改订单状态
        $trade_updata = array(
            't_feedback'      => App_Helper_Trade::FEEDBACK_YES,
            't_feedback_type' => $toid ? 1 : 0,
            't_fd_status'     => App_Helper_Trade::FEEDBACK_REFUND_SELLER, //待商家处理
        );
        $toupdata = array(
            'to_feedback'  => App_Helper_Trade::FEEDBACK_YES,
            'to_fd_status' => App_Helper_Trade::FEEDBACK_REFUND_SELLER, //待商家处理
        );
        if ($toid) {
            // 因为单品退款也会更新主订单的退款状态 FEEDBACK_YES=1 代表有正在进行中的维权 -(有维权且状态为等待商家处理的不进行更新)
            if ($trade['t_feedback'] == App_Helper_Trade::FEEDBACK_YES && $trade['t_fd_status'] == App_Helper_Trade::FEEDBACK_REFUND_SELLER) {
                $ret = true;
            } else {
                $ret = $trade_model->findUpdateTradeByTid($tid, $trade_updata);
            }

            // 单品退款更新单个
            $order_model->updateById($toupdata, $toid);
        } else {
            // 整单退款更新全部
            $ret = $trade_model->findUpdateTradeByTid($tid, $trade_updata);
            $order_model->updateOrderListByTid($toupdata, $trade['t_id']);
        }

        // 自动退款的相关逻辑（自动退款不走后台同意的相关逻辑操作，直接进行退款处理）
        $hadRefund = false;
        if ($this->shop['s_auto_refund'] > 0 && ($trade['t_pay_time'] + $this->shop['s_auto_refund'] * 60) > time()) {
            //设置了自动退款时间，并且在时间范围内，自动退款
            $trade['to_feedback'] = 2;
            $trade['t_feedback']  = 2;
            $this->_auto_refund($trade, $trade_model);

        }
        // 自动退款失败或者是没有设置自动退款走后台人工退款
        if (!$hadRefund) {
            //设置N日后自动退款
            if ($toid) {
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->setTradeOrderRefundTtl($toid, $overtime['refund']);
            } else {
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->setTradeRefundTtl($trade['t_id'], $overtime['refund']);
            }

            //如果是跑腿配送订单 更新跑腿订单状态
            if ($trade['t_express_method'] == 7) {
                $trade_helper = new App_Helper_Trade($this->sid);
                $trade_helper->_update_legwork_trade_refund_status($trade, App_Helper_Trade::FEEDBACK_REFUND_SELLER);
            }

            //取消订单自动完成
            $trade_redis->delTradeFinish($trade['t_id']);
            // 申请退款推送通知给管理员
            $help_model = new App_Helper_XingePush($this->sid);
            $help_model->pushNotice($help_model::TRADE_RIGHTS, $trade); // 推送退款申请通知
            $notice_model = new App_Helper_JiguangPush($this->sid);
            $notice_model->pushNotice($notice_model::TRADE_RIGHTS, $trade);
            // 后台店铺消息
            $message_helper = new App_Helper_ShopMessage($this->sid);
            $message_helper->messageRecord($message_helper::TRADE_RIGHTS, $trade);
            //短信通知
            $sms_helper = new App_Helper_Sms($this->sid);
            $sms_helper->sendNoticeSms($trade, 'sqtktz');
        }

        // 退款申请后消息返回
        if ($rfid && $ret) {
            $info['data'] = array(
                'result' => true,
                'msg'    => '退款申请成功',
            );
            $this->outputSuccess($info);
        } else {
            $this->outputError('退款申请失败');
        }
    }

    /**
     * 自动退款更换新的退款方法
     * zhangzc
     * 2019-12-24
     * @param  [type] $trade       [description]
     * @param  [type] $trade_model [description]
     * @return [type]              [description]
     */
    private function _auto_refund($trade, $trade_model)
    {
        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
        //删除自动打印倒计时
        if ($toid) {
            $trade_redis->delTradeOrderRefundTtl($trade['to_id']);
        } else {
            $trade_redis->delTradePrintTtl($trade['t_id']);
        }
        try {
            $refund_helper = new App_Helper_OrderRefund($this->sid, $this->applet_cfg, $trade_model);
            // FEEDBACK_RESULT_AGREE =2 同意退款
            $result = $refund_helper->appletRefund($trade, App_Helper_Trade::FEEDBACK_RESULT_AGREE, '系统主动退款', $trade['to_id'], [], 2);
        } catch (Exception $e) {
            $this->outputError($e->getMessage());
            return false;
        }
        // 退款成功的记录信息
        if ($result['ec'] != 200) {
            return true;
        }
    }

    /*
     * 取消退款申请
     */
    public function cancelRefundAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            // 正在维权中的订单
            if ($trade['t_feedback'] == App_Helper_Trade::FEEDBACK_YES) {
                $updata = array(
                    't_feedback'  => App_Helper_Trade::FEEDBACK_OVER, //维权结束
                    't_fd_status' => App_Helper_Trade::FEEDBACK_REFUND_SOLVE, //维权已解决
                    't_fd_result' => App_Helper_Trade::FEEDBACK_RESULT_CANCEL, //买家撤销退款
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //修改单商品的维权状态
                $toupdate = array(
                    'to_feedback'  => App_Helper_Trade::FEEDBACK_OVER, //维权结束
                    'to_fd_status' => App_Helper_Trade::FEEDBACK_REFUND_SOLVE, //维权已解决
                    'to_fd_result' => App_Helper_Trade::FEEDBACK_RESULT_CANCEL, //买家撤销退款
                );
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $order_model->updateRefundingOrderByTid($toupdate, $trade['t_id']);
                //修改维权订单信息
                $refund = array(
                    'tr_finish_time' => time(),
                    'tr_status'      => App_Helper_Trade::FEEDBACK_REFUND_HANDLE, // 已处理
                    'tr_fd_result'   => App_Helper_Trade::FEEDBACK_RESULT_CANCEL, // 买家撤销退款
                );
                $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                //获取最新一条维权订单信息
                $refund_new = $refund_model->getLastRecord($tid);
                // 修改最近一次维权订单信息
                $refund_model->findUpdateByTrid($refund_new['tr_id'], $refund);
                //删除退款超时
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->delTradeRefundTtl($trade['t_id']);
                //待收货状态下,取消退款,需重设订单自动完成时间
                if ($trade['t_status'] == App_Helper_Trade::TRADE_SHIP) {
                    $overtime = plum_parse_config('trade_overtime');
                    $ttl      = intval($trade['t_express_time']) + $overtime['finish'] - time(); //剩余完成时间
                    $trade_redis->setTradeFinishTtl($trade['t_id'], $ttl);
                }
                if ($ret) {
                    //将订单退款的会计申请记录删除
                    $where_confirm[]  = ['name' => 'aac_s_id', 'oper' => '=', 'value' => $this->sid];
                    $where_confirm[]  = ['name' => 'aac_confirm_id', 'oper' => '=', 'value' => $trade['t_id']];
                    $where_confirm[]  = ['name' => 'aac_type', 'oper' => '=', 'value' => 2];
                    $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->sid);
                    $accountant_model->deleteValue($where_confirm);

                    if ($trade['t_express_method'] == 7) {
                        $trade_helper = new App_Helper_Trade($this->sid);
                        $trade_helper->_update_legwork_trade_refund_status($trade, App_Helper_Trade::FEEDBACK_REFUND_SOLVE);
                    }

                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '取消退款申请成功',
                    );
                    $this->outputSuccess($info);
                } else {
                    $this->outputError('取消退款失败');
                }
            } else {
                $this->outputError("订单维权已结束,无效提交");
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 确认收货
     */
    public function confirmAcceptAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            // 判断是否是自己的订单
            if ($trade['t_m_id'] == $this->member['m_id']) {
                // 判断订单状态是否是待收货状态
                if ($trade['t_status'] == App_Helper_Trade::TRADE_SHIP) {
                    $updata = array(
                        't_finish_time' => time(),
                        't_status'      => App_Helper_Trade::TRADE_FINISH, //置于完成状态
                    );
                    $trade_helper = new App_Helper_Trade($this->sid);
                    //是否触发通知
                    $trade_helper->sendTradeStatusMessage($tid, App_Helper_Trade::TRADE_MESSAGE_SEND_MJSH);
                    $trade_helper->dealCompleteTrade($trade); //处理订单完成后续
                    //清除自动完成状态定时
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->delTradeFinish($trade['t_id']);
                    //订单返现
                    $returnModel = new App_Model_Shop_MysqlOrderReturnStorage($this->sid);
                    $return      = $returnModel->findUpdateDeductByTid($tid);
                    if ($return) {
                        if (App_Helper_MemberLevel::goldCoinTrans($this->sid, $return['or_m_id'], $return['or_return'])) {
                            $returnSet = array('or_status' => 1);
                            $returnModel->findUpdateDeductByTid($tid, $returnSet);
                        }
                    }
                    //清除待结算状态 确认收货7天后再结算
                    $settled_model = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                    $settled       = $settled_model->findSettledByTid($tid);
                    if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                        $set = array('ts_order_finish_time' => time());
                        $settled_model->updateById($set, $settled['ts_id']);
                        if ($this->shop['s_enter_settle'] > 0) {
                            $countdown   = plum_parse_config('trade_overtime');
                            $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                            $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->shop['s_enter_settle'] ? $this->shop['s_enter_settle'] * 24 * 60 * 60 : $countdown['settled']);
                        } else {
                            $trade_redis->delTradeSettledTtl($settled['ts_id']);
                            if ($trade['t_es_id'] > 0) {
                                $trade_helper->recordEnterShopSuccessSettled($settled['ts_id']);
                            } else {
                                $trade_helper->recordSuccessSettled($settled['ts_id']);
                            }
                        }

                    }
                    $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                     if($this->shop['s_return_time'] > 0){
                        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                        $trade_redis->setTradeReturn($tid,$this->shop['s_return_time'] * 24 * 60 * 60);
                    }else{
                        //交易佣金提成通知
                        $order_deduct = new App_Helper_OrderDeduct($this->shop['s_id']);
                        $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
                    }
                    //增加商品销量
                    $trade_helper->modifyGoodsSold($trade['t_id']);
                    // 收货完成向管理员发送推送通知
                    $help_model = new App_Helper_XingePush($this->sid);
                    $help_model->pushNotice($help_model::TRADE_FINISH); // 推送确认收货通知
                    $notice_model = new App_Helper_JiguangPush($this->sid);
                    $notice_model->pushNotice($notice_model::TRADE_FINISH);
                    //短信通知卖家订单已收货
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms($trade, 'ddwctz');
                    // 小程序订单推送模板消息

                    plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_QRSH, 'appletType' => $this->appletType));

                    // 结算特殊分佣的订单
                    // zhangzc
                    // 2019-12-10
                    // if($this->sid==5655){
                    //     $helper_model  = new App_Helper_Distribution($this->sid);
                    //     $helper_model->dealTradeRewardAfterFinish($trade['t_id']);
                    // }

                    if ($ret) {
                        //同步更新购物单
                        plum_open_backend('index', 'updateOrder', array('sid' => $this->sid, 'tid' => $tid));
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '确认收货成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('确认收货失败');
                    }
                } else {
                    $this->outputError('订单状态不正确');
                }
            } else {
                $this->outputError('非法操作');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 查看维权记录
     */
    public function feedbackRecordAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            $trade_redis  = new App_Model_Trade_RedisTradeStorage($this->sid);
            $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
            $refund       = $refund_model->getAllRecord($tid);

            $button    = null;
            $countdown = null;
            $statedesc = null;

            switch ($trade['t_fd_status']) {
                //等待顾客处理的退款申请
                case App_Helper_Trade::FEEDBACK_REFUND_SELLER:
                    $countdown = array(
                        'title' => '等待商家处理的剩余时间',
                        'time'  => $trade_redis->getTradeRefundTtl($trade['t_id']),
                    );
                    $statedesc = "等待商家处理";
                    break;
                //等待商家处理的退款操作
                case App_Helper_Trade::FEEDBACK_REFUND_CUSTOMER:
                    $countdown = array(
                        'title' => '等待买家处理的剩余时间',
                        'time'  => $trade_redis->getTradeRefundTtl($trade['t_id']),
                    );
                    $statedesc = "等待买家处理";
                    break;
                case App_Helper_Trade::FEEDBACK_REFUND_SOLVE:
                    $statedesc = "维权已处理";
                    break;
            }
            if ($refund) {
                $info['data'] = array(
                    'tid'          => $trade['t_tid'],
                    'rfStatus'     => $trade['t_fd_status'],
                    'refundStatus' => $statedesc,
                    'refundNum'    => $refund[0]['tr_wid'],
                    'title'        => $trade['t_title'],
                    'cover'        => plum_deal_image_url($trade['t_pic']),
                    'num'          => $trade['t_num'],
                    'status'       => $trade['t_status'],
                    'statusNote'   => isset($this->order_status_desc['t_status']) ? $this->order_status_desc['t_status'] : '',
                    'orderTotal'   => $trade['t_total_fee'],
                    'time'         => isset($countdown['time']) && $countdown['time'] ? $countdown['time'] : '',
                    'refund'       => $this->_format_refund($refund, $trade),
                );
                $this->outputSuccess($info);
            } else {
                $this->outputError('获取维权记录失败');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }
    /**
     * 格式化维权数据
     */
    private function _format_refund($refund, $trade)
    {
        $data = array();
        if ($refund) {
            foreach ($refund as $val) {
                $data[] = array(
                    'wid'          => $val['tr_wid'],
                    'reason'       => $val['tr_reason'],
                    'contact'      => $val['tr_contact'],
                    'money'        => $val['tr_money'],
                    'createTime'   => date('Y-m-d H:i', $val['tr_create_time']),
                    'status'       => $val['tr_status'],
                    'sellerNote'   => $val['tr_seller_note'],
                    'resultTime'   => isset($val['tr_note_time']) && $val['tr_note_time'] ? date('Y-m-d H:i', $val['tr_note_time']) : '',
                    'finishTime'   => isset($val['tr_finish_time']) ? date('Y-m-d H:i', $val['tr_finish_time']) : '',
                    'resultStatus' => $trade['t_fd_result'], // 1拒绝退款，2同意退款，3买家已撤销退款
                    'finishResult' => $val['tr_status'] == 1 && $trade['t_fd_result'] == 3 ? '撤销退款申请' : '',
                );
            }
        }
        return $data;
    }

    /*
     * 发货提醒
     */
    public function remindOrderAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            $curr        = time();
            $five_hour   = 5 * 60 * 60;
            $twelve_hour = 12 * 60 * 60;
            //付款5小时内,提醒无效
            if (($curr - $trade['t_pay_time']) > $five_hour) {
                //距离上次提醒12小时内,提醒无效
                if (!$trade['t_remind_time'] || (($curr - $trade['t_remind_time']) > $twelve_hour)) {
                    //@todo 发送提醒通知
                    $help_model = new App_Helper_XingePush($this->sid);
                    $help_model->pushNotice($help_model::REMIND_DELIVER, $trade); // 推送发货提醒通知
                    $notice_model = new App_Helper_JiguangPush($this->sid);
                    $notice_model->pushNotice($notice_model::REMIND_DELIVER, $trade);
                    // 后台店铺消息
                    $message_helper = new App_Helper_ShopMessage($this->sid);
                    $message_helper->messageRecord($message_helper::REMIND_DELIVER, $trade);
                    $updata = array('t_remind_time' => time());
                    $ret    = $trade_model->updateById($updata, $trade['t_id']);
                    if ($ret) {
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '提醒发货成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('提醒发货失败');
                    }
                } else {
                    $this->outputError("距离上次提醒未超过12小时,请稍后再来提醒,或在订单详情中直接联系商家!");
                }
            } else {
                $this->outputError('商家正在处理中,请稍后再来提醒');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 订单评价页面
     */
    public function commentAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            if ($trade['t_status'] == App_Helper_Trade::TRADE_FINISH) {

                if ($trade['t_had_comment'] == 0) {
                    $info['data'] = array(
                        'tid'        => $trade['t_tid'],
                        'title'      => $trade['t_title'],
                        'createTime' => date('Y-m-d H:i:s', $trade['t_create_time']),
                        'payTime'    => date('Y-m-d H:i:s', $trade['t_pay_time']),
                    );
                    if ($trade['t_applet_type'] == App_Helper_Trade::TRADE_APPLET_TRAIN) {
                        $info['data']['goods'] = $this->show_trade_course_detail_data($trade['t_id']);
                    } else {
                        $info['data']['goods'] = $this->show_trade_goods_detail_data($trade['t_id']);
                    }

                    $this->outputSuccess($info);
                } else {
                    $this->outputError('订单已评价,不支持重复评价');
                }
            } else {
                $this->outputError('订单未完成暂不支持评价');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }
    /*
     * 提交评价
     */
    public function saveCommentAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $speed       = $this->request->getIntParam('speed');
        $attitude    = $this->request->getIntParam('attitude');
        $goods_score = $this->request->getStrParam('goods');
        $goods_score = json_decode(urldecode($goods_score), true);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        // 判断订单是否存在
        if ($trade) {
            // 判断订单状态是否已完成
            if ($trade['t_status'] == App_Helper_Trade::TRADE_FINISH) {
                // 判断订单是否已评价
                if ($trade['t_had_comment'] == 0) {
                    // 判断订单是不是本人订单
                    if ($trade['t_m_id'] == $this->member['m_id']) {
                        $goods_key = array();
                        foreach ($goods_score as &$item) {
                            if (!in_array(intval($item['score']), array(1, 2, 3, 4, 5))) {
                                $item['score'] = 5;
                            }
                            if (!$item['content']) {
                                $item['content'] = "宝贝不错,很喜欢!";
                            }

                            if ($item['image'] && !empty($item)) {
                                $item['image'] = json_encode($item['image']);
                            } else {
                                $item['image'] = '';
                            }
                            $goods_key[$item['toid']] = $item;
                        }
                        //获取交易订单
                        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                        $order       = $order_model->fetchOrderListByTid($trade['t_id']);
                        //商品评价
                        $goods_comment = new App_Model_Goods_MysqlCommentStorage($this->sid);
                        foreach ($order as $item) {
                            $indata = array(
                                'gc_s_id'        => $this->sid,
                                'gc_g_id'        => $item['to_g_id'],
                                'gc_es_id'       => $trade['t_es_id'],
                                'gc_tid'         => $tid,
                                'gc_to_id'       => intval($item['to_id']),
                                'gc_mid'         => $this->member['m_id'],
                                'gc_star'        => intval($goods_key[$item['to_id']]['score']),
                                'gc_content'     => $goods_key[$item['to_id']]['content'],
                                'gc_create_time' => time(),
                                'gc_comment_img' => $goods_key[$item['to_id']]['image'],
                            );
                            $goods_comment->insertValue($indata);
                        }
                        if ($trade['t_es_id']) {
                            //如果是入驻店铺的订单计算入驻店铺的平均分
                            $score       = $goods_comment->getEnterShopAvgScore($trade['t_es_id']);
                            $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
                            $set         = array('es_score' => $score);
                            $store_model->updateById($set, $trade['t_es_id']);
                        }
                        //店铺评分
                        $indata = array(
                            'sc_s_id'          => $this->sid,
                            'sc_tid'           => $tid,
                            'sc_mid'           => $this->member['m_id'],
                            'sc_speed_star'    => in_array(intval($speed), array(1, 2, 3, 4, 5)) ? intval($speed) : 5,
                            'sc_attitude_star' => in_array(intval($attitude), array(1, 2, 3, 4, 5)) ? intval($attitude) : 5,
                            'sc_create_time'   => time(),
                        );
                        $shop_comment = new App_Model_Shop_MysqlCommentStorage($this->sid);
                        $shop_comment->insertValue($indata);
                        //设置订单已评价
                        $updata = array(
                            't_had_comment' => 1,
                        );
                        $ret = $trade_model->updateById($updata, $trade['t_id']);
                        if ($ret) {
                            // 评价订单获取积分
                            $point_storage = new App_Helper_Point($this->sid);
                            $point_storage->gainPointBySource($this->uid, App_Helper_Point::POINT_SOURCE_COMMENT);
                            $info['data'] = array(
                                'result' => true,
                                'msg'    => '订单评价成功',
                            );
                            $this->outputSuccess($info);
                        } else {
                            $this->outputError('订单评价失败');
                        }
                    } else {
                        $this->outputError('您无权操作此订单');
                    }
                } else {
                    $this->outputError('订单已评价');
                }
            } else {
                $this->outputError('订单未完成暂不支持评价');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 订单支付（小程序专用）微信支付
     */
    public function shopRechargeAppletAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $appid       = $this->request->getStrParam('appid');
        $type        = $this->request->getStrParam('payType');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        $this->extendOverTimeTradeTtl($trade['t_id']);
        if ($trade['t_pay_type'] == 11) {
            // 微财猫微信支付
            if ($trade) {
                $body   = $trade['t_title'];
                $amount = floatval($trade['t_total_fee'] - $trade['t_coin_payment']);
                $openid = $trade['t_buyer_openid'];
                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                    'appid' => $appid,
                );
                $other = array(
                    'attach' => json_encode($attach),
                );
                if ($this->sid == 11) {
                    if (!$trade['t_tid_spare']) {
                        $amount = 0.01;
                    } else {
                        $tid    = $trade['t_tid_spare'];
                        $amount = 0.05;
                    }
                } else {
                    if ($trade['t_tid_spare']) {
                        $tid = $trade['t_tid_spare'];
                    }
                }
                $payment = $amount * 100;
                $client  = new App_Plugin_Vcaimao_PayClient($this->sid);
                $payInfo = $client->payWithWeixin($openid, $tid, $payment, $body, $other);

                if ($payInfo && !$payInfo['errcode'] && $payInfo['data']) {
                    // 将prepay_id保存到数据库
                    $updata = array('t_prepay_id' => substr($payInfo['data']['package'], 10));
                    $trade_model->findUpdateTradeByTid($tid, $updata);
                    $params = array(
                        'appId'     => $payInfo['data']['appid'],
                        'timeStamp' => $payInfo['data']['timestamp'],
                        'nonceStr'  => $payInfo['data']['nonceStr'],
                        'package'   => $payInfo['data']['package'],
                        'signType'  => 'MD5',
                        'paySign'   => $payInfo['data']['paySign'],
                    );
                    $this->outputSuccess(array('data' => $params));
                } else {
                    //$this->outputError('支付错误，请稍后重试');
                    $this->outputError($payInfo['errcode'] . $payInfo['errmsg']);
                }
            }
        } else {
            $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
            $payType  = $pay_type->findRowPay();
            if (!$payType || ($payType && $payType['pt_wxpay_applet'] == 0)) {
                $this->outputError('该店铺暂未开启微信支付');
            }
            if ($trade) {
                $body        = $trade['t_title'];
                $amount      = floatval($trade['t_total_fee'] - $trade['t_coin_payment']);
                $openid      = $trade['t_buyer_openid'];
                $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                $notify_url  = $this->response->responseHost().'/mobile/wxpay/tradeNotifyApplet'; //回调地址

                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                    'appid' => $appid,
                );
                $other = array(
                    'attach' => json_encode($attach),
                );
                $test_shop = [4286, 4298, 7209, 11, 24, 4697, 27, 5474, 5742, 4230, 3906, 5741, 6970, 4546, 9800, 5655, 8298];
                if (in_array($this->sid, $test_shop)) {
                    if (!$trade['t_tid_spare']) {
                        $amount = 0.01;
                    } else {
                        $tid    = $trade['t_tid_spare'];
                        $amount = 0.05;
                    }
                } else {
                    if ($trade['t_tid_spare']) {
                        $tid = $trade['t_tid_spare'];
                    }
                }
                if($this->member['m_id'] == 6793287){
                    $amount = 0.01;
                }
                if ($this->sid == 10418) {
                    $amount = $amount * 5.3; // 加拿大同城支付金额改成
                }
                if ($this->sid != 5655) {
                    //获取分身小程序信息
                    $child_cfg       = new App_Model_Applet_MysqlChildStorage();
                    $child           = $child_cfg->fetchUpdateWxcfgByAid($appid);
                    $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                    $appcfg          = $appletPay_Model->findRowPay();
                    if ($child) {
                        if ($appcfg && $appcfg['ap_sub_pay'] == 1 && $child['ac_mchid']) {
                            // 使用服务商模式下支付
                            $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                            $ret            = $subPay_storage->unifiedJsapiOrder($appid, $openid, $amount, $tid, $notify_url, $body, $other, $child['ac_mchid']);
                        } else {
                            $ret = $pay_storage->appletChildOrderPayRecharge($appid, $amount, $openid, $tid, $notify_url, $body, $other);
                        }
                    } else {
                        if ($appcfg && $appcfg['ap_sub_pay'] == 1) {
                            // 服务商模式下支付
                            $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                            $ret            = $subPay_storage->unifiedJsapiOrder($appid, $openid, $amount, $tid, $notify_url, $body, $other);
                        } else {
                            $ret = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other);
                        }
                    }

                    if (is_array($ret)) {
                        // 将prepay_id保存到数据库
                        $updata = array('t_prepay_id' => $ret['prepay_id']);
                        $trade_model->findUpdateTradeByTid($tid, $updata);
                        $params = array(
                            'appId'     => $ret['appid'],
                            'timeStamp' => strval(time()),
                            'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                            'package'   => "prepay_id={$ret['prepay_id']}",
                            'signType'  => 'MD5',
                        );
                        $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                        $this->outputSuccess(array('data' => $params));
                    } else {
                        $this->outputError('支付错误，请稍后重试');
                    }
                } else {
                    $notify_url      = plum_get_base_host() . '/mobile/polymerpay/tradeNotifyApplet'; //回调地址
                    $polymer_storage = new App_Plugin_Polymer_Pay($this->sid);
                    $ret             = $polymer_storage->appletOrderPayRecharge($appid, $openid, $amount, $tid, $notify_url, $body, $other);
                    if (is_array($ret) && !$ret['code']) {
                        // 将prepay_id保存到数据库
                        $updata = array('t_prepay_id' => $ret['package']);
                        $trade_model->findUpdateTradeByTid($tid, $updata);
                        $params = array(
                            'appId'     => $ret['appId'],
                            'timeStamp' => $ret['timeStamp'],
                            'nonceStr'  => $ret['nonceStr'],
                            'package'   => $ret['package'],
                            'signType'  => $ret['signType'],
                            'paySign'   => $ret['paySign'],
                        );
                        $this->outputSuccess(array('data' => $params));
                    } else {
                        $this->outputError('支付错误，请稍后重试');
                    }
                }
            } else {
                $this->outputError('支付订单不存在请重试');
            }
        }
    }
    /**
     * 在订单支付前先获取自动关闭的redis设置，如果ttl在20秒之内的再加2分钟（延长订单超时关闭的ttl时间）
     * zhangzc
     * 2019-12-26
     * @param  [type] $tid [主键id]
     * @return [type]      [description]
     */
    private function extendOverTimeTradeTtl($tid)
    {
        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
        $ttl         = $trade_redis->getTradeCloseTtl($tid);
        if ($ttl <= 20) {
            $trade_redis->setTradeCloseTtl($tid, (2 * 60));
        }
    }

    /*
     * 订单支付（小程序专用）百度支付
     */
    public function shopRechargeBaiduAction()
    {
        $tid      = $this->request->getStrParam('tid');
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        if (!$payType || ($payType && $payType['pt_baidu_pay'] == 0)) {
            $this->outputError('该店铺暂未开启百度支付');
        }
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        if ($trade) {
            $dealTitle = $trade['t_title'];
            $amount    = floatval($trade['t_total_fee']);
            if ($this->sid == 7664) {
                $amount = 0.01;
            }
            $attach = array(
                'suid'      => $this->shop['s_unique_id'],
                'mid'       => $this->member['m_id'],
                'orderType' => 'order',
            );
            $pay_storage = new App_Plugin_Baidu_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $tid, $dealTitle, $attach);
            if (is_array($result)) {
                // 修改订单支付编号
                $set = array('t_pay_trade_no' => $result['bizInfo']['tpData']['tpOrderId']);
                $trade_model->findUpdateTradeByTid($tid, $set);
                $this->outputSuccess(array('data' => $result));
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 订单支付（小程序专用）支付宝支付使用
     */
    public function shopRechargeAlipayAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        if ($trade) {
            $dealTitle  = $trade['t_title'];
            $amount     = floatval($trade['t_total_fee']);
            $notify_url = $this->response->responseHost() . '/alixcx/alipay/orderSuccessAliNotify'; //回调地址

            $attach = array(
                'suid'      => $this->shop['s_unique_id'],
                'mid'       => $this->member['m_id'],
                'orderType' => 'order',
            );
            $pay_storage = new App_Plugin_Alixcx_XcxClient($this->sid);
            $result      = $pay_storage->fetchTradeCreate($trade['t_buyer_openid'], $tid, $amount, $dealTitle, $attach, $notify_url);
            if (is_array($result) && !$result['errcode']) {
                $data['data'] = array(
                    'outTradeNO' => $result['out_trade_no'],
                    'tradeNO'    => $result['trade_no'],
                );
                $this->outputSuccess($data);
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 抖音头条小程序订单支付
     */
    public function shopRechargeToutiaoAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        if ($trade) {
            $dealTitle  = $trade['t_title'];
            $amount     = floatval($trade['t_total_fee']);
            $notify_url = $this->response->responseHost() . '/alixcx/alipay/orderSuccessAliNotify'; //回调地址
            //            $notify_url = plum_parse_config('notify_url','wxxcx').'/alixcx/alipay/orderSuccessAliNotify';//回调地址
            $attach = array(
                'suid'       => $this->shop['s_unique_id'],
                'mid'        => $this->member['m_id'],
                'orderType'  => 'order',
                'appletType' => 'toutiao',
            );
            // 获取超时关闭时间:
            $over_time   = plum_parse_config('trade_overtime');
            $overTime    = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade'] * 60 : $over_time['close'];
            $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $trade['t_buyer_openid'], $tid, $notify_url, $dealTitle, $trade['t_create_time'], $overTime, $attach);
            if (is_array($result) && !$result['code']) {
                $params = array(
                    'app_id'       => $result['appid'],
                    'timestamp'    => $result['timestamp'],
                    'trade_no'     => $result['trade_no'],
                    'merchant_id'  => $result['biz_content']['merchant_id'],
                    'uid'          => $result['uid'],
                    'total_amount' => $result['biz_content']['total_amount'],
                    'sign_type'    => 'MD5',
                    'params'       => json_encode(array(
                        'url' => $result['params_url'],
                    )),
                );
                $params['sign']        = $pay_storage::makeToutiaoSign($params, $result['appsecret']);
                $params['params']      = $result['params_url'];
                $params['method']      = 'tp.trade.confirm';
                $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                $params['pay_type']    = 'ALIPAY_APP';
                $params['risk_info']   = $result['biz_content']['risk_info'];
                $this->outputSuccess(array('data' => $params));
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 抖音头条小程序订单支付(支持支付宝和微信)，已经测试成功可以正常使用
     */
    public function shopRechargeToutiaoWxpayAction()
    {
        $tid = $this->request->getStrParam('tid');

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        if ($trade) {
            $dealTitle = strlen($trade['t_title']) <= 40 ? $trade['t_title'] : substr($trade['t_title'], 0, 40);
            //$amount = floatval($trade['t_total_fee']);
            $amount     = 0.02;
            $notify_url = $this->response->responseHost() . '/toutiao/notify/orderSuccessToutiaoNotify'; //回调地址
            $attach     = array(
                'suid'       => $this->shop['s_unique_id'],
                'mid'        => $this->member['m_id'],
                'orderType'  => 'order',
                'appletType' => 'toutiao',
            );
            // 获取超时关闭时间:
            $over_time   = plum_parse_config('trade_overtime');
            $overTime    = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade'] * 60 : $over_time['close'];
            $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $trade['t_buyer_openid'], $tid, $notify_url, $dealTitle, $trade['t_create_time'], $overTime, $attach);
            if (is_array($result) && !$result['code']) {
                $updata = array('t_prepay_id' => $result['trade_no']);
                $trade_model->findUpdateTradeByTid($tid, $updata);
                $params = array(
                    'merchant_id'  => $result['biz_content']['merchant_id'],
                    'app_id'       => $result['appid'],
                    'sign_type'    => 'MD5',
                    'timestamp'    => $result['timestamp'],
                    'product_code' => 'pay',
                    'payment_type' => 'direct',
                    'out_order_no' => $result['trade_no'],
                    'uid'          => $result['uid'],
                    'total_amount' => $result['biz_content']['total_amount'],
                    'currency'     => 'CNY',
                    'subject'      => $dealTitle,
                    'body'         => $dealTitle,
                    'trade_time'   => $trade['t_create_time'],
                    'valid_time'   => 1800,
                    'notify_url'   => plum_get_base_host(),
                    'alipay_url'   => $result['params_url'],
                    'wx_url'       => $result['wxinfo'] && $result['wxinfo']['mweb_url'] ? $result['wxinfo']['mweb_url'] : '',
                    'version'      => '2.0',
                );
                if ($params['wx_url'] && $result['wxinfo'] && $result['wxinfo']['trade_type']) {
                    $params['wx_type'] = $result['wxinfo']['trade_type'];
                }
                $params['sign']      = $pay_storage::makeToutiaoSign($params, $result['appsecret']);
                $params['risk_info'] = $result['biz_content']['risk_info'];
                $this->outputSuccess(array('data' => $params));
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 订单支付（小程序专用）qq支付使用
     */
    public function shopRechargeQqpayAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade && $trade['t_status'] != 1) {
            $this->outputError('订单状态有误，请稍后重试');
        }
        if ($trade) {
            $dealTitle  = $trade['t_title'];
            $amount     = floatval($trade['t_total_fee']);
            $notify_url = $this->response->responseHost() . '/qq/qqpay/tradeNotifyApplet'; //回调地址

            $attach = array(
                'suid'      => $this->shop['s_unique_id'],
                'mid'       => $this->member['m_id'],
                'orderType' => 'order',
            );
            $pay_storage = new App_Plugin_Qq_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($trade['t_buyer_openid'], $amount, $tid, $notify_url, $dealTitle, $attach);
            if (is_array($result) && !$result['errcode']) {
                $data['data'] = array(
                    'appId'     => $result['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package'   => "prepay_id={$result['prepay_id']}",
                    'signType'  => 'MD5',
                );
                $this->outputSuccess($data);
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 订单延长
     */
    public function orderExtendedDeliveryAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            if ($trade['t_status'] == App_Helper_Trade::TRADE_SHIP && $trade['t_fd_status'] == App_Helper_Trade::FEEDBACK_NO) {
                // 已发货订单无维权状态才允许延长收货
                // 判断是否延长过收货
                if (!$trade['t_had_extend']) {
                    //获取订单超时完成剩余时间
                    $trade_redis = new App_Model_Trade_RedisTradeStorage($this->shop['s_id']);
                    $surplus     = $trade_redis->getTradeFinishTtl($trade['t_id']);
                    if ($surplus < 259200) {
                        //距离收货结束时间3天才能申请延长收货
                        $finish = $surplus + 259200; // 只能延长3天
                        $trade_redis->setTradeFinishTtl($trade['t_id'], $finish);
                        $set = array('t_had_extend' => 1);
                        $ret = $trade_model->updateById($set, $trade['t_id']);
                        if ($ret) {
                            $info['data'] = array(
                                'result' => true,
                                'msg'    => '延长收货成功',
                            );
                            $this->outputSuccess($info);
                        } else {
                            $this->outputError('延长收货成功');
                        }
                    } else {
                        $this->outputError('距离收货结束时间3天才能申请延长收货');
                    }
                } else {
                    $this->outputError('该订单已经延长过一次收货了，不能再次延长了');
                }
            } else {
                $this->outputError('该订单暂不支持延长收货');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 删除订单
     */
    public function deleteTradeAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            if ($trade['t_m_id'] == $this->member['m_id']) {
                if ($trade['t_status'] >= App_Helper_Trade::TRADE_FINISH) {
                    // 订单状态在已完成和已关闭和已退款状态才能删除
                    $updata = array(
                        't_deleted' => 1, //客户删除
                    );
                    $ret = $trade_model->updateById($updata, $trade['t_id']);
                    if ($ret) {
                        //删除已购订单
                        $this->_del_order($trade);
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '删除订单成功',
                        );
                        $this->outputSuccess($info);
                    } else {
                        $this->outputError('删除订单失败');
                    }
                } else {
                    $this->outputError('订单无法取消');
                }
            } else {
                $this->outputError('非法操作');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    private function _del_order($trade)
    {
        $mall_widget = new App_Plugin_Weixin_MallWidget($this->sid);
        $ret         = $mall_widget->deleteOrder($trade['t_buyer_openid'], $trade['t_tid']);
    }

    /*
     * 我的拼团列表
     */
    public function mytuanAction()
    {
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $allow_type = array('all' => '全部', 'dct' => '待成团', 'ptcg' => '拼团成功', 'ptsb' => '拼团失败');
        $type_map   = array('all' => -1, 'dct' => 0, 'ptcg' => 1, 'ptsb' => 2);
        $type       = $this->request->getStrParam('type', 'all');
        $type       = in_array($type, array_keys($allow_type)) ? $type : 'all';
        //获取订单列表
        $mem_model = new App_Model_Group_MysqlMemStorage($this->sid);
        if ($this->applet_cfg['ac_type'] == 12 && $this->sid == 4230) {
            //培训版
            $list = $mem_model->fetchCourseTradeList($this->member['m_id'], 'pt', $type_map[$type], $index, $this->count);
        } else {
            $list = $mem_model->fetchTradeList($this->member['m_id'], 'pt', $type_map[$type], $index, $this->count);
        }

        if ($list) {
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);

            foreach ($list as &$item) {
                $item['trade'] = $trade_model->findUpdateTradeByTid($item['gm_tid']);
            }
        }
        $info['data'] = array();
        $status_desc  = $this->group_status_desc;
        $order_model  = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        if ($list) {
            foreach ($list as $val) {
                if ($this->applet_cfg['ac_type'] == 12 && $this->sid == 4230) {
                    //培训版
                    $gid = $val['atc_id'];
                } else {
                    $gid = $val['g_id'];
                }
                $hadBuy         = $order_model->getTradeByGid($gid, $this->member['m_id']);
                $info['data'][] = array(
                    'tid'         => $val['gm_tid'],
                    'status'      => $val['go_status'],
                    'status_desc' => $status_desc[$val['go_status']],
                    'img'         => $this->dealImagePath($val['trade']['t_pic']),
                    'title'       => $val['trade']['t_title'],
                    'price'       => $val['gb_type'] == 3 && $val['gm_id_tz'] ? $val['gb_tz_price'] : $val['gb_price'],
                    'total'       => $val['go_total'],
                    'type'        => $val['g_knowledge_pay_type'],
                    'gid'         => $gid,
                    'num'         => $val['trade']['t_num'],
                    'total_fee'   => $val['trade']['t_total_fee'],
                    'hadBuy'      => $hadBuy ? 1 : 0,
                    'independent' => intval($val['trade']['t_independent_mall']),
                );
            }
            $this->outputSuccess($info);
        } else {
            $this->outputError('数据加载完毕');
        }
    }
    /*
     * 我的抽奖列表
     */
    public function mycjAction()
    {
        $page      = $this->request->getStrParam('page', 0);
        $index     = $page * $this->count;
        $mem_model = new App_Model_Group_MysqlMemStorage($this->sid);
        $list      = $mem_model->fetchTradeList($this->member['m_id'], 'cj', -1, $index, $this->count);
        $cjDesc    = array(0 => '进行中', 1 => '成功', 2 => '失败');
        if ($list) {
            $trade_model  = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $info['data'] = array();
            foreach ($list as $item) {
                $trade          = $trade_model->findUpdateTradeByTid($item['gm_tid']);
                $info['data'][] = array(
                    'tid'        => $item['gm_tid'],
                    'status'     => $item['go_status'], //0进行中 1成功 2失败
                    'statusDesc' => $cjDesc[$item['go_status']],
                    'price'      => $item['gb_price'],
                    'total'      => $item['gb_total'],
                    'img'        => $this->dealImagePath($trade['t_pic']),
                    'title'      => $trade['t_title'],
                    'num'        => $trade['t_num'],
                    'total_fee'  => $trade['t_total_fee'],
                );
            }
            $this->outputSuccess($info);
        } else {
            $this->outputError('数据加载完毕');
        }

    }

    /*
     * 我的核销订单
     */
    public function myVerifyTradeAction()
    {
        $status = $this->request->getStrParam('status', 'all'); // 订单状态
        // 检索条件
        $where   = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);
        switch ($status) {
            case 'hadpay': //未核销
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => [3, 4]);
                break;
            case 'finish': //已核销
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => 6);
                break;
            default: //全部
                $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => [3, 4, 6]);
        }

        $data = $this->show_trade_list_data($where);
        if ($data) {
            $info['data'] = $data;
            $this->outputSuccess($info);
        } else {
            $this->outputError('订单数据加载完毕');
        }

    }

    /**
     * 订单返现记录
     */
    public function orderReturnAction()
    {
        $page                      = $this->request->getIntParam('page');
        $index                     = $page * $this->count;
        $returnModel               = new App_Model_Shop_MysqlOrderReturnStorage($this->sid);
        $info['data']['noReturn']  = $returnModel->getReturnTotal($this->member['m_id'], 0);
        $info['data']['hadReturn'] = $returnModel->getReturnTotal($this->member['m_id'], 1);
        $where[]                   = array('name' => 'or_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]                   = array('name' => 'or_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $list                      = $returnModel->getList($where, $index, $this->count, array('or_create_time' => 'desc'));
        $info['data']['list']      = array();
        foreach ($list as $val) {
            $info['data']['list'][] = array(
                'tid'        => $val['or_tid'],
                'money'      => $val['or_return'],
                'status'     => $val['or_status'],
                'statusNote' => $val['or_status'] == 0 ? '待返现' : '已返现',
            );
        }
        $this->outputSuccess($info);
    }

    /*
     * 根据类型核销
     */
    public function verifyOrderByPasswdAction()
    {
        $type   = $this->request->getStrParam('type', 'order');
        $code   = $this->request->getStrParam('code');
        $passwd = $this->request->getStrParam('passwd');
        switch ($type) {
            case 'order':
                $this->verifyTrade($type, $code, $passwd);
                break;
            case 'meet':
                $this->verifyTrade($type, $code, $passwd);
                break;
            default:
                $this->outputError('操作异常');
        }
    }

    /*
     * 核销订单 核销
     * t_pickup_code
     */
    private function verifyTrade($type = '', $code, $verifyPasswd)
    {
        $where[]   = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $typeIndex = 2;
        if ($type == 'order') {
            $typeIndex = 2;
        } elseif ($type == 'meet') {
            $typeIndex = 3;
        }
        $where[] = "( (t_pickup_code != '' and t_pickup_code = '{$code}') or t_tid = '{$code}' )";

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $row         = $trade_model->getRow($where);

        // 有维权处理且未处理完成
        if ($row['t_fd_status'] > 0 && $row['t_fd_status'] != 3) {
            $this->outputError('该订单有未完成的退款处理');
        }

        if ($row) {
            $manager = '';
            if ($row['t_es_id']) {
                $enterShop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                $enterShop       = $enterShop_model->getRowById($row['t_es_id']);

                $manager_storage = new App_Model_Entershop_MysqlManagerStorage();
                $manager         = $manager_storage->findManagerEsid($this->sid, $row['t_es_id']);
                $manager_id      = $manager['esm_id'];
                $manager_role    = 'entershop';

                if ($enterShop['es_verify_passwd']) {
                    $passwd = $enterShop['es_verify_passwd'];
                } else {

                    $passwd = $manager[0]['esm_password'];
                }
                if ($passwd != plum_salt_password($verifyPasswd)) {
                    $this->outputError("核销密码不正确");
                }
            } else {
                $manager_model = new App_Model_Member_MysqlManagerStorage();
                $manager       = $manager_model->findManagerByCid($this->shop['s_c_id']);
                $manager_id    = $manager['m_id'];
                $manager_role  = 'admin';

                if ($this->shop['s_verify_passwd']) {
                    $passwd = $this->shop['s_verify_passwd'];
                } else {

                    $passwd = $manager['m_password'];
                }
                if ($passwd != plum_salt_password($verifyPasswd)) {
                    $this->outputError("核销密码不正确");
                }
            }
            if (in_array($row['t_status'], array(3, 4))) {
                $set = array(
                    't_status'         => 6,
                    't_finish_manager' => $manager['m_nickname'] ? $manager['m_nickname'] : $manager['esm_nickname'],
                    't_finish_time'    => time(),
                );

                if (in_array($this->applet_cfg['ac_type'], [21, 6])) {
                    $updata['t_manager_id']   = $manager['m_id'] ? $manager['m_id'] : $manager['esm_id'];
                    $updata['t_finish_type']  = $manager['m_id'] ? 0 : 1;
                    $updata['t_manager_name'] = $manager['m_nickname'] ? $manager['m_nickname'] : $manager['esm_nickname'];
                }

                $trade_helper = new App_Helper_Trade($this->sid);
                //curr_sid
                $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                $trade_redis->delTradeFinish($row['t_id']);
                //交易佣金提成通知
                $order_deduct = new App_Helper_OrderDeduct($this->sid);
                $order_deduct->completeOrderDeduct($row['t_tid'], $row['t_m_id']);
                //清除待结算状态 确认收货7天后再结算
                $settled_model = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                $settled       = $settled_model->findSettledByTid($row['t_tid']);
                if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                    $tset = array('ts_order_finish_time' => time());
                    $settled_model->updateById($tset, $settled['ts_id']);
                    if ($this->shop['s_enter_settle'] > 0) {
                        $countdown   = plum_parse_config('trade_overtime');
                        $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                        $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->shop['s_enter_settle'] ? $this->shop['s_enter_settle'] * 24 * 60 * 60 : $countdown['settled']);
                    } else {
                        $trade_redis->delTradeSettledTtl($settled['ts_id']);
                        if ($row['t_es_id'] > 0) {
                            $trade_helper->recordEnterShopSuccessSettled($settled['ts_id']);
                        } else {
                            $trade_helper->recordSuccessSettled($settled['ts_id']);
                        }
                    }
                }
                //增加商品销量
                $trade_helper->modifyGoodsSold($row['t_id']);
                $res = $trade_model->updateValue($set, $where);
                if ($res) {
                    if ($row['t_applet_type'] == 11) {
                        $sequence_helper = new App_Helper_Sequence($this->sid);
                        $nosettled_model = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($this->sid);
                        //本订单是否有未结算的分佣记录
                        $nosettled_row = $nosettled_model->getRowByTid($row['t_tid'], 1, 0, $row['t_se_leader']);
                        if ($nosettled_row) {
                            $sequence_helper->dealSequenceDeductConfirm($row, 0, 0, $nosettled_row);
                        } else {
                            $sequence_helper->dealSequenceDeduct($row, 0, 0);
                        }

                    } else {
                        $esId = $row['t_es_id'];
                        $osId = $row['t_es_id'] > 0 ? 0 : $row['t_store_id']; //有入驻店铺的订单不再考虑线下门店

                        $this->_save_verify_record($row['t_m_id'], $code, $row['t_store_id'], $typeIndex, $manager_id, $manager_role, $esId, $osId);
                    }

                    //同步更新购物单
                    plum_open_backend('index', 'updateOrder', array('sid' => $this->sid, 'tid' => $row['t_tid']));
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '核销成功',
                    );
                    $this->outputSuccess($info);
                } else {
                    $this->outputError('核销失败');
                }
            } else {
                $this->outputError('该订单无法核销');
            }
        } else {
            $this->outputError('未找到订单信息');
        }
    }

    /*
     * 保存核销记录
     * type 1.会员卡 2.普通订单 3.会议订单 4.转盘抽奖 5.答题获奖 6.社区团购订单
     */
    private function _save_verify_record($mid, $code, $os_id = 0, $type, $manager_id = 0, $manager_role = '', $esId = 0, $osId = 0)
    {
        if ($type) {
            $verify_model = new App_Model_Store_MysqlVerifyStorage($this->sid);

            $role_type = [
                'admin'     => 1,
                'entershop' => 2,
                'store'     => 3,
            ];

            $role_status = $role_type[$manager_role] ? $role_type[$manager_role] : 0;

            $data = array(
                'ov_s_id'         => $this->sid,
                'ov_m_id'         => $mid,
                'ov_st_id'        => $os_id,
                'ov_value'        => $code,
                'ov_type'         => $type,
                'ov_record_time'  => time(),
                'ov_manager_id'   => $manager_id,
                'ov_manager_role' => $role_status,
                'ov_es_id'        => $esId,
                'ov_os_id'        => $osId,
            );
            $verify_model->insertValue($data);
        }

    }

    /**
     * 首页提示订单列表
     * update by zhangzc (功能未开启不要进行数据的查询)
     * 2020-01-13
     * @return [type] [description]
     */
    public function getIndexTradeListAction()
    {
        // 没有开启直接就return,没开启还给她查什么数据，没开启的话接口其实前端都不用请求
        if(!$this->shop['s_order_tip'])
            $this->outputError('功能未开启');
        $page      = $this->request->getIntParam('page');
        $index     = $page * $this->count;
        $use_cache = false;
        //dn 2019-12-12 使用缓存,只缓存第一页
        $allow_cfg = plum_parse_config('order_index_cache', 'allow');
        if ($page == 0 && in_array($this->applet_cfg['ac_type'], $allow_cfg['allow'])) {
            $shop_redis  = new App_Model_Shop_RedisShopQueueStorage();
            $redis_value = $shop_redis->getIndexOrderInRedis($this->suid);
            if ($redis_value) {
                $list      = $redis_value == '-2' ? [] : json_decode($redis_value, 1);
                $use_cache = true;
            }
        }

        if (!$use_cache) { 
            $sort        = array('t_create_time' => 'DESC');
            $where[]     = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));
            $where[]     = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            //不连表 分两次查出用户信息 dn 2019-09-23
            $trade_list  = $trade_model->tradeMemberGroupListNew($where, $index, $this->count, $sort);
            $mids        = [];

            if(empty($trade_list)){
                $this->outputError('没有更多信息了');
            }
            $mids=array_column($trade_list,'t_m_id');
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $where_member[] = ['name' => 'm_id', 'oper' => 'in', 'value' => $mids];
            $list           = $member_model->getList($where_member, 0, count($mids), [], ['m_nickname', 'm_avatar']);
            if ($page == 0 && in_array($this->applet_cfg['ac_type'], $allow_cfg['allow'])) {
                //设置缓存
                $shop_redis = new App_Model_Shop_RedisShopQueueStorage();
                if ($list) {
                    $redis_list = json_encode($list);
                    $expire     = $allow_cfg['time'];
                } else {
                    $redis_list = '-2';
                    $expire     = $allow_cfg['empty_time'];
                }
                $shop_redis->setIndexOrderInRedis($this->suid, $redis_list, $expire);
            }
        }

        foreach ($list as $value) {
            $info['data'][] = array(
                'avatar' => $this->dealImagePath($value['m_avatar']),
                'desc'   => $value['m_nickname'] . " 刚刚购买了一单",
            );
        }
        $this->outputSuccess($info);
    }

    /*
     * 提交培训订单评价
     */
    public function saveTrainCommentAction()
    {
        $tid         = $this->request->getStrParam('tid');
        $goods_score = $this->request->getStrParam('goods');
        $goods_score = json_decode(urldecode($goods_score), true);
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        // 判断订单是否存在
        if ($trade) {
            // 判断订单状态是否已完成
            if ($trade['t_status'] == App_Helper_Trade::TRADE_FINISH) {
                // 判断订单是否已评价
                if ($trade['t_had_comment'] == 0) {
                    // 判断订单是不是本人订单
                    if ($trade['t_m_id'] == $this->member['m_id']) {
                        $goods_key = array();
                        foreach ($goods_score as &$item) {
                            if (!in_array(intval($item['score']), array(1, 2, 3, 4, 5))) {
                                $item['score'] = 5;
                            }
                            if (!$item['content']) {
                                $item['content'] = "好评!";
                            }

                            if ($item['image'] && !empty($item)) {
                                $item['image'] = json_encode($item['image']);
                            } else {
                                $item['image'] = '';
                            }
                            $goods_key[$item['toid']] = $item;
                        }
                        //获取交易订单
                        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                        $order       = $order_model->fetchOrderListByTid($trade['t_id']);
                        //商品评价
                        $goods_comment = new App_Model_Train_MysqlTrainCourseCommentStorage($this->sid);
                        foreach ($order as $item) {
                            $indata = array(
                                'acc_s_id'        => $this->sid,
                                'acc_g_id'        => $item['to_g_id'],
                                'acc_tid'         => $tid,
                                'acc_to_id'       => intval($item['to_id']),
                                'acc_mid'         => $this->member['m_id'],
                                'acc_star'        => intval($goods_key[$item['to_id']]['score']),
                                'acc_content'     => $goods_key[$item['to_id']]['content'],
                                'acc_create_time' => time(),
                                'acc_comment_img' => $goods_key[$item['to_id']]['image'],
                            );
                            $goods_comment->insertValue($indata);
                        }
                        //设置订单已评价
                        $updata = array(
                            't_had_comment' => 1,
                        );
                        $ret = $trade_model->updateById($updata, $trade['t_id']);
                        if ($ret) {
                            // 评价订单获取积分
                            $point_storage = new App_Helper_Point($this->sid);
                            $point_storage->gainPointBySource($this->uid, App_Helper_Point::POINT_SOURCE_COMMENT);
                            $info['data'] = array(
                                'result' => true,
                                'msg'    => '订单评价成功',
                            );
                            $this->outputSuccess($info);
                        } else {
                            $this->outputError('订单评价失败');
                        }
                    } else {
                        $this->outputError('您无权操作此订单');
                    }
                } else {
                    $this->outputError('订单已评价');
                }
            } else {
                $this->outputError('订单未完成暂不支持评价');
            }
        } else {
            $this->outputError('订单不存在');
        }
    }

    /*
     * 获得非普通订单线上支付参数
     */
    public function getOtherTradePayAction()
    {
        $orderType     = $this->request->getStrParam('orderType', 'gift');
        $appid         = $this->request->getStrParam('appid');
        $tid           = $this->request->getStrParam('tid');
        $appletPayType = $this->request->getStrParam('appletPayType', 'wxpay'); //wxpay表示微信支付，Alipay表示支付宝支付，bdpay表示百度支付,toutiao表示抖音头条支付
        if ($appletPayType && $appletPayType == 'bdpay') { // 百度支付
            //            $data  = $this->_get_bdapp_pay($tid,$orderType);
        } elseif ($appletPayType && $appletPayType == 'Alipay') {
            //$data  = $this->_get_alipay_pay($tid,$orderType);
        } elseif ($appletPayType && $appletPayType == 'toutiao') {
            // 抖音头条支付
            $data = $this->_get_toutiao_alipay_pay($tid, $orderType);
        } else {
            $data = $this->_get_wexin_pay($appid, $tid, $orderType);
        }
        $info['data'] = $data;
        $this->outputSuccess($info);
    }

    /*
     * 获取百度支付信息
     */
    private function _get_bdapp_pay($tid, $orderType)
    {
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        if (!$payType || ($payType && $payType['pt_baidu_pay'] == 0)) {
            $this->outputError('该店铺暂未开启在线支付');
        }
        $trade      = [];
        $order_type = '';
        if ($orderType == 'gift') {
            $trade_model = new App_Model_Giftcard_MysqlGiftCardTradeStorage($this->sid);
            $trade       = $trade_model->findUpdateTradeByTid($tid);
            $title       = '礼品卡订单';
            $totalFee    = floatval($trade['agct_total_fee']);
            $order_type  = 'giftOrder';
        }

        if ($trade) {
            $dealTitle = $title;
            $amount    = $totalFee;
            $attach    = array(
                'suid'      => $this->shop['s_unique_id'],
                'mid'       => $this->member['m_id'],
                'orderType' => $order_type,
            );

            if ($this->sid == 4546 || $this->sid == 10043) {
                $amount = 0.03;
            }
            $pay_storage = new App_Plugin_Baidu_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $tid, $dealTitle, $attach);
            return $result;
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 获得微信支付信息
     */
    private function _get_wexin_pay($appid, $tid, $orderType)
    {
        $pay_type = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType  = $pay_type->findRowPay();
        if (!$payType || ($payType && $payType['pt_wxpay_applet'] == 0)) {
            $this->outputError('该店铺暂未开启微信支付');
        }

        $title = '';
        if ($orderType == 'gift') {
            $trade_model = new App_Model_Giftcard_MysqlGiftCardTradeStorage($this->sid);
            $trade       = $trade_model->findUpdateTradeByTid($tid);
            $totalFee    = floatval($trade['agct_total_fee']);
            $open_id     = $trade['agct_m_openid'];
            $title       = '礼品卡订单';
            $notify_url  = '/mobile/wxpay/giftcardTradeNotifyApplet';
        }

        if ($trade) {
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $body        = $title;
            $amount      = $totalFee;
            $openid      = $open_id;
            $notify_url  = $this->response->responseHost() . $notify_url; //回调地址
            $attach      = array(
                'suid'  => $this->shop['s_unique_id'],
                'mid'   => $this->member['m_id'],
                'appid' => $appid,
            );
            $other = array(
                'attach' => json_encode($attach),
            );
            if ($this->sid == 4546 || $this->sid == 10043 || $this->sid == 5655) {
                $amount = 0.01;
            }
            //获取分身小程序信息
            $child_cfg       = new App_Model_Applet_MysqlChildStorage();
            $child           = $child_cfg->fetchUpdateWxcfgByAid($appid);
            $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
            $appcfg          = $appletPay_Model->findRowPay();
            if ($child) {
                if ($appcfg && $appcfg['ap_sub_pay'] == 1 && $child['ac_mchid']) {
                    // 使用服务商模式下支付
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret            = $subPay_storage->unifiedJsapiOrder($appid, $openid, $amount, $tid, $notify_url, $body, $other, $child['ac_mchid']);
                } else {
                    $ret = $pay_storage->appletChildOrderPayRecharge($appid, $amount, $openid, $tid, $notify_url, $body, $other);
                }

            } else {
                if ($appcfg && $appcfg['ap_sub_pay'] == 1) {
                    // 服务商模式下支付
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret            = $subPay_storage->unifiedJsapiOrder($appid, $openid, $amount, $tid, $notify_url, $body, $other);
                } else {
                    $ret = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $notify_url, $body, $other);
                }

            }

            if (is_array($ret)) {
                // 将prepay_id保存到数据库
                $updata = array('agct_prepay_id' => $ret['prepay_id']);
                $trade_model->findUpdateTradeByTid($tid, $updata);
                $params = array(
                    'appId'     => $ret['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package'   => "prepay_id={$ret['prepay_id']}",
                    'signType'  => 'MD5',
                );
                $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                return $params;
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    /*
     * 微信公众号下单 获得支付信息
     */
    public function weixinPayAction()
    {
        $tid   = $this->request->getStrParam('tid'); //获取订单id
        $appid = $this->request->getStrParam('weixin_appid'); //公众号appid

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if (!$trade) {
            $this->outputError("订单不存在");
        }
        $body   = $trade['t_title'];
        $amount = floatval($trade['t_total_fee']);

        if ($this->sid == 8298) {
            $amount = 0.01;
        }

        $attach = array(
            'suid'  => $this->shop['s_unique_id'],
            'mid'   => $this->member['m_id'],
            'appid' => $appid,
        );
        $other = array(
            'attach' => json_encode($attach),
        );
        $openid = $trade['t_buyer_openid'];
        // $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        // $payType = $pay_type->findRowPay();
        $pay_model                 = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appletPay                 = $pay_model->findRowPay();
        $appletPay['weixin_appid'] = $appid;
        $has_wxpay                 = App_Helper_Trade::checkHasWxpay($this->sid, 1);
        // if ($payType && $payType['pt_wxpay_applet'] > 0) {//自有微信支付
        if ($has_wxpay) {
            //自有微信支付
            // $notify_url = $this->response->responseHost().'/mobile/wxpay/tradeNotify';//回调地址
            $notify_url = plum_parse_config('notify_url', 'wxxcx') . '/mobile/wxpay/tradeNotifyApplet'; //回调地址
            $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id'], true);
            $ret        = $wx_pay->unifiedJsapiOrder($openid, $body, $tid, $amount, $notify_url, $other, $appletPay);
        }

        if (is_array($ret)) {
            if ($ret['return_code'] == 'FAIL') {
                $this->outputError($ret['return_msg']);
            }
            $params = array(
                'appId'     => $ret['appid'],
                'timeStamp' => strval(time()),
                'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                'package'   => "prepay_id={$ret['prepay_id']}",
                'signType'  => 'MD5',
            );
            $params['paySign'] = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
            // $this->displayJsonSuccess(array('params' => $params));
            $info['data'] = [
                'params' => $params,
            ];
            $this->outputSuccess($info);
        } else {
            // $this->displayJsonError("微信支付发起失败");
            $this->outputError("微信支付发起失败");
        }
    }

    private function _get_toutiao_alipay_pay($tid, $orderType)
    {

        $notify_url = $this->response->responseHost() . '/alixcx/alipay/orderSuccessAliNotify'; //回调地址

        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade       = $trade_model->findUpdateTradeByTid($tid);
        if ($trade) {
            $dealTitle = $trade['t_title'];
            $amount    = floatval($trade['t_total_fee']);
            $attach    = array(
                'suid'       => $this->shop['s_unique_id'],
                'mid'        => $this->member['m_id'],
                'orderType'  => 'order',
                'appletType' => 'toutiao',
            );
            // 获取超时关闭时间:
            $over_time   = plum_parse_config('trade_overtime');
            $overTime    = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade'] * 60 : $over_time['close'];
            $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
            $result      = $pay_storage->appletOrderPayRecharge($amount, $trade['t_buyer_openid'], $tid, $notify_url, $dealTitle, $trade['t_create_time'], $overTime, $attach);
            if (is_array($result) && !$result['code']) {
                $params = array(
                    'app_id'       => $result['appid'],
                    'timestamp'    => $result['timestamp'],
                    'trade_no'     => $result['trade_no'],
                    'merchant_id'  => $result['biz_content']['merchant_id'],
                    'uid'          => $result['uid'],
                    'total_amount' => $result['biz_content']['total_amount'],
                    'sign_type'    => 'MD5',
                    'params'       => json_encode(array(
                        'url' => $result['params_url'],
                    )),
                );
                $params['sign']        = $pay_storage::makeToutiaoSign($params, $result['appsecret']);
                $params['params']      = $result['params_url'];
                $params['method']      = 'tp.trade.confirm';
                $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                $params['pay_type']    = 'ALIPAY_APP';
                $params['risk_info']   = $result['biz_content']['risk_info'];
                return $params;
            } else {
                $this->outputError('支付错误，请稍后重试');
            }
        } else {
            $this->outputError('支付订单不存在请重试');
        }
    }

    public function queryOrderStatusAction()
    {
        $tid = $this->request->getStrParam('tid');
        plum_msg_dump($tid, 0);
        if ($tid) {
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $where       = array();
            $where[]     = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]     = array('name' => 't_prepay_id', 'oper' => '=', 'value' => $tid);
            $trade       = $trade_model->getRow($where);
            plum_msg_dump($trade, 0);
            if ($trade) {
                if ($trade['t_status'] >= 2 && $trade['t_status'] <= 6) {
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '支付成功',
                        'code'   => 0,
                    );
                    $this->outputSuccess($info);
                } elseif ($trade['t_status'] == 1) {
                    // 待支付状态查询支付情况
                    // 获取小程序配置及支付相关配置
                    $appletPay_Model = new App_Model_Toutiao_MysqlToutiaoPayStorage($this->sid);
                    $paycfg          = $appletPay_Model->findRowPay();
                    $pay_storage     = new App_Plugin_Weixin_NewPay($this->sid);
                    $ret             = $pay_storage->queryOrderStatusWeb($tid, $paycfg);
                    if (is_array($ret)) {
                        if ($ret['resultData']['trade_state'] == 'SUCCESS') {
                            //支付成功
                            //餐饮版如果有包厢号 记录餐桌信息
                            if (json_decode($trade['t_extra_data'], true)['type'] == 'meal' && $trade['t_home_id'] > 0) {
                                $table_model  = new App_Model_Meal_MysqlMealTableStorage($this->shop['s_id']);
                                $where_meal[] = array('name' => 'amt_id', 'oper' => '=', 'value' => $trade['t_home_id']);
                                $where_meal[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->shop['s_id']);
                                $row_meal     = $table_model->getRow($where_meal);
                                if (!$row_meal['amt_use']) {
                                    $set_meal = array(
                                        'amt_use' => 1,
                                    );
                                    $table_model->updateValue($set_meal, $where_meal);
                                }
                                $meal_end = $trade['t_meal_type'] == 2 ? 1 : 0; //如果是堂食 用餐状态标记为正在使用
                            }
                            if ($trade['t_pay_type'] == App_Helper_Trade::TRADE_PAY_HHZF) {
                                $t_pay_type = App_Helper_Trade::TRADE_PAY_HHZF;
                            } else {
                                $t_pay_type = App_Helper_Trade::TRADE_PAY_WXZFZY;
                            }
                            $updata = array(
                                't_pay_type'     => $t_pay_type,
                                't_pay_trade_no' => $ret['transaction_id'],
                                't_status'       => App_Helper_Trade::TRADE_WAIT_PAY_RETURN, //支付完成待确认状态
                                't_pay_time'     => time(),
                                't_meal_end'     => isset($meal_end) ? 1 : 0,
                                't_payment'      => $ret['total_fee'] / 100,
                            );
                            $trade_model->findUpdateTradeByTid($tid, $updata);
                            if ($trade['t_es_id'] > 0) {
                                //入驻店铺添加待结算交易记录
                                $trade_helper = new App_Helper_Trade($this->shop['s_id']);
                                if ($trade['t_express_method'] == 4 || $trade['t_express_method'] == 5) {
                                    //平台配送, 蜂鸟配送，减去配送费
                                    $trade['t_total_fee'] = $trade['t_total_fee'] - $trade['t_post_fee'];
                                }
                                if ($trade['t_express_method'] == 7) {
                                    $legworkExtra = json_decode($trade['t_legwork_extra'], 1);
                                    if (isset($legworkExtra['price']) && $legworkExtra['price'] > 0) {
                                        $trade['t_total_fee'] = floatval($trade['t_total_fee']) - floatval($legworkExtra['price']) - floatval($trade['t_share_post_fee']);
                                    }
                                }
                                $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
                            }
                            //订单活动后续处理
                            plum_open_backend('index', 'tradeBack', array('sid' => $this->shop['s_id'], 'tid' => $tid));
                            $info['data'] = array(
                                'result' => true,
                                'msg'    => '支付成功',
                                'code'   => 0,
                            );
                            $this->outputSuccess($info);
                        } else {
                            $this->outputError('订单支付超时');
                        }
                    } else {
                        $this->outputError('支付错误，请稍后重试');
                    }
                } else {
                    $this->outputError('订单状态错误');
                }
            } else {
                $this->outputError('订单不存在');
            }
        } else {
            $this->outputError('参数错误，请检查');
        }
    }
    /*老废物疗养中心*/

}
