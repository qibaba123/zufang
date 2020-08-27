<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/6
 * Time: 下午9:13
 */

class App_Controller_Console_ReportController extends Libs_Mvc_Controller_ConsoleController{

    private $startTime;
    private $endTime;
    private $reportCfg;
    private $msg_tpl_id;
    public function __construct() {
        parent::__construct();
        $this->startTime = strtotime('-1 day', strtotime(date('Y-m-d')));
        $this->endTime = strtotime(date('Y-m-d'));
        $this->reportCfg = plum_parse_config('managerReport', 'tmplmsg');
        $this->msg_tpl_id = "pYEUp0nJ2I4c7_ENeIA2QlkQGOh4QtvMElO5UF63wzA";
    }

    public function sendReportAction(){
        $where   = array();
        $where[] = array('name' => 'amr_send_time', 'oper' => '=', 'value' => 0); //未发送的
        $report_model = new App_Model_Member_MysqlManagerReportStorage();
        $count = 20;
        $wechat_plugin  = new App_Plugin_Weixin_ClientPlugin(16);
        do {
            $list = $report_model->getList($where, 0, $count);
            foreach ($list as $value){
                $wechat_plugin->sendTemplateMessage($value['amr_openid'], $this->msg_tpl_id,'', json_decode($value['amr_data'], true));
                $report_model->updateById(array('amr_send_time' => time()), $value['amr_id']);
            }
        }while(count($list) == $count);
    }

    public function generateReportAction(){
        //获取所有店铺管理员
        $where   = array();
        $where[] = array('name' => 'm_weixin_mid', 'oper' => '!=', 'value' => 0);  // 绑定过会员的
        $where[] = array('name' => 'm_report_open', 'oper' => '=', 'value' => 1);  // 开启通知的
        $where[] = array('name' => 'ac_report_open', 'oper' => '=', 'value' => 1);  // 开启通知的
        $where[] = array('name' => 'm_report_time', 'oper' => '<', 'value' => strtotime(date('Y-m-d'))); // 当天未通知的
        $where[] = array('name' => 'ac_type', 'oper' => '>', 'value' => 0);

        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $report_model = new App_Model_Member_MysqlManagerReportStorage();
        $count = 20;
        do {
            $managerList = $manager_model->getListWithMember($where, 0, $count, array());
            $managerData = array();
            // 按店铺分组
            foreach ($managerList as $key => $value){
                $managerData[$value['s_id']]['appletType'] = $value['ac_type'];
                $managerData[$value['s_id']]['managerList'][] = $value;
            }

            foreach ($managerData as $sid => $value){
                $data = array();
                if(method_exists($this, '_get_report_data_'.$value['appletType'])){
                    $method = '_get_report_data_'.$value['appletType'];
                    $data = $this->$method($sid);
                }
                foreach ($value['managerList'] as $val){
                    if($data){
                        $manager_model->updateById(array('m_report_time' => time()), $val['m_id']);
                        $indata = array(
                            'amr_s_id' => $sid,
                            'amr_m_id' => $val['m_id'],
                            'amr_openid' => $val['mopenid'],
                            'amr_data' => json_encode($data),
                            'amr_create_time' => time()
                        );
                        $report_model->insertValue($indata);
                    }
                }
            }
        }while(count($managerList) == $count);
    }

    // 组装模板数据
    private function _format_templmsg_data($type, $sid, $data){
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop = $shop_model->getRowById($sid);
        $fieldList = $this->reportCfg['field'][$type];
        $remark = "商户：".$shop['s_name'].'\\n';
        $index = 0;
        foreach ($fieldList as $key => $value){
            foreach ($value as $k => $val){
                $remark .= $val.'：'.$data[$index];
                if($k < count($value) - 1){
                    $remark .= '，';
                }
                $index++;
            }

            if($key < count($fieldList) - 1){
                $remark .= '\\n';
            }
        }
        $tempmsg = '{"first":{"value":"'.$this->reportCfg['first'].'","color":"#5976be"},"keyword1":{"value":"经营报告","color":"#5976be"},"keyword2":{"value":"'.date('Y-m-d').'","color":"#5976be"},"remark":{"value":"'.$remark.'","color":"#5976be"}}';
        $tempmsg = json_decode($tempmsg, true);
        return $tempmsg;
    }

    //基础商城
    private function _get_report_data_1($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //售出计次卡数
        $timesCardCount = $cardStatistic['timesCardCount'];
        //售出计次卡金额
        $timesCardMoney = $cardStatistic['timesCardMoney'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal, $timesCardCount, $timesCardMoney,
            $rechargeCount, $rechargeTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
        );

        $tempData = $this->_format_templmsg_data(1, $sid, $data);
        return $tempData;
    }

    //企业官网
    private function _get_report_data_3($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //售出计次卡数
        $timesCardCount = $cardStatistic['timesCardCount'];
        //售出计次卡金额
        $timesCardMoney = $cardStatistic['timesCardMoney'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $data = array(
            $addMember, $memberTotal, $timesCardCount, $timesCardMoney,
            $cashTotal, $cashMoney,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal,
            $saleTotal, $soldoutTotal, $nosaleTotal,
        );

        $tempData = $this->_format_templmsg_data(3, $sid, $data);
        return $tempData;
    }

    //餐饮
    private function _get_report_data_4($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $rechargeCount, $rechargeTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal,
        );

        $tempData = $this->_format_templmsg_data(4, $sid, $data);
        return $tempData;
    }

    //同城
    private function _get_report_data_6($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $postStatisticData = $this->_get_post_statistic($sid);
        //发帖数量
        $postTotal = $postStatisticData['totalPost'];
        //发帖收益
        $postProfit = $postStatisticData['totalProfit'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney = $orderStatisticData['refundMoney'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $entershopStatisticData = $this->_get_entershop_statistic($sid, 6);
        //商家入驻量
        $shopTotal = $entershopStatisticData['shopTotal'];
        //商家入驻收益
        $shopProfitTotal = $entershopStatisticData['profitTotal'];

        $data = array(
            $addMember, $memberTotal, $postTotal, $postProfit,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal,$refundMoney,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal, $shopTotal, $shopProfitTotal,
        );

        $tempData = $this->_format_templmsg_data(6, $sid, $data);
        return $tempData;
    }

    //酒店
    private function _get_report_data_7($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal
        );

        $tempData = $this->_format_templmsg_data(7, $sid, $data);
        return $tempData;
    }

    //多店
    private function _get_report_data_8($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $orderStatisticData = $this->_get_order_statistic($sid, true);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid, true);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $entershopStatisticData = $this->_get_entershop_statistic($sid, 8);
        //商家入驻量
        $shopTotal = $entershopStatisticData['shopTotal'];
        //商家入驻收益
        $shopProfitTotal = $entershopStatisticData['profitTotal'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal,
            $refundMoney, $saleTotal, $soldoutTotal, $nosaleTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal, $shopTotal, $shopProfitTotal,
        );

        $tempData = $this->_format_templmsg_data(8, $sid, $data);
        return $tempData;
    }

    //婚纱
    private function _get_report_data_9($sid){
        return false;
    }

    //驾校
    private function _get_report_data_10($sid){
        return false;
    }

    //名片
    private function _get_report_data_11($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $messageStatistic = $this->_get_message_statistic($sid);

        // 新增留言
        $newAddMessage = $messageStatistic['newAdd'];
        // 未处理留言
        $nodealMessage = $messageStatistic['nodeal'];
        // 总留言
        $totalMessage  = $messageStatistic['total'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $newAddMessage, $nodealMessage, $totalMessage
        );

        $tempData = $this->_format_templmsg_data(11, $sid, $data);
        return $tempData;
    }

    //培训
    private function _get_report_data_12($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //新增会员
        $memberCardCount = $cardStatistic['memberCardCount'];
        //总会员数
        $membeCardTotal  = $cardStatistic['memberCount'];
        //售出计次卡数
        $timesCardCount = $cardStatistic['timesCardCount'];
        //售出计次卡金额
        $timesCardMoney = $cardStatistic['timesCardMoney'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $orderStatisticData = $this->_get_order_statistic($sid, true);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal, $memberCardCount, $membeCardTotal,
            $timesCardCount, $timesCardMoney, $cashTotal, $cashMoney,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(12, $sid, $data);
        return $tempData;
    }

    //门店
    private function _get_report_data_13($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $orderStatisticData = $this->_get_order_statistic($sid, true);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid, true);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $rechargeCount, $rechargeTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(13, $sid, $data);
        return $tempData;
    }

    //房产
    private function _get_report_data_16($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //新增会员
        $memberCardCount = $cardStatistic['memberCardCount'];
        //总会员数
        $membeCardTotal  = $cardStatistic['memberCount'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $houseStatistic = $this->_get_house_statistic($sid);
        // 新增求租求购数
        $newApply = $houseStatistic['applyAdd'];
        // 累计求租求购数
        $totalApply = $houseStatistic['applyTotal'];
        // 新增商家入驻申请数
        $newShop = $houseStatistic['shopAdd'];
        // 累计入驻申请数
        $totalShop = $houseStatistic['shopTotal'];
        // 新房源数
        $newHouse = $houseStatistic['houseAdd'];
        // 累计房源数
        $totalHouse = $houseStatistic['houseTotal'];

        $data = array(
            $addMember, $memberTotal, $memberCardCount, $membeCardTotal,
            $cashTotal, $cashMoney,
            $newApply, $totalApply,
            $newShop, $totalShop,
            $newHouse, $totalHouse,
        );

        $tempData = $this->_format_templmsg_data(16, $sid, $data);
        return $tempData;
    }

    //预约
    private function _get_report_data_18($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //售出计次卡数
        $timesCardCount = $cardStatistic['timesCardCount'];
        //售出计次卡金额
        $timesCardMoney = $cardStatistic['timesCardMoney'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $orderStatisticData = $this->_get_order_statistic($sid, true);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal, $timesCardCount, $timesCardMoney,
            $cashTotal, $cashMoney, $rechargeCount, $rechargeTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(18, $sid, $data);
        return $tempData;
    }

    //工单
    private function _get_report_data_20($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $workorderStatistic = $this->_get_workorder_statistic($sid);
        //新增工单数
        $newAddOrder = $workorderStatistic['newAdd'];
        //待处理工单数
        $noDealOrder = $workorderStatistic['noDeal'];
        //处理中工单数
        $dealingOrder = $workorderStatistic['dealing'];
        //完成工单数
        $finishOrder = $workorderStatistic['finish'];
        //累计工单数
        $totalOrder = $workorderStatistic['total'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $newAddOrder, $noDealOrder,
            $dealingOrder, $finishOrder, $totalOrder
        );

        $tempData = $this->_format_templmsg_data(20, $sid, $data);
        return $tempData;
    }

    //营销商城
    private function _get_report_data_21($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $data = array(
            $addMember, $memberTotal, $cashTotal, $cashMoney,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal
        );

        $tempData = $this->_format_templmsg_data(21, $sid, $data);
        return $tempData;
    }

    //会务报名
    private function _get_report_data_22($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $meetingStatistic = $this->_get_meeting_statistic($sid);
        //报名中会议
        $meetingCount = $meetingStatistic['meetingCount'];
        //已结束会议
        $meetingEndCount = $meetingStatistic['meetingEndCount'];
        //日售票数
        $goodsTotal = $meetingStatistic['goodsTotal'];
        //日售金额
        $totalMoney = $meetingStatistic['totalMoney'];
        //累售金额
        $allMoney = $meetingStatistic['allMoney'];
        //日签到人数
        $signTotal = $meetingStatistic['signTotal'];
        //累计签到人数
        $allSignTotal = $meetingStatistic['allSignTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal,
            $cashTotal, $cashMoney,
            $meetingCount, $meetingEndCount,
            $goodsTotal, $totalMoney, $allMoney,
            $signTotal, $allSignTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
        );

        $tempData = $this->_format_templmsg_data(22, $sid, $data);
        return $tempData;
    }

    //智慧门店
    private function _get_report_data_23($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $messageStatistic = $this->_get_message_statistic($sid);
        // 新增留言
        $newAddMessage = $messageStatistic['newAdd'];
        // 未处理留言
        $nodealMessage = $messageStatistic['nodeal'];
        // 总留言
        $totalMessage  = $messageStatistic['total'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal,
            $newAddMessage, $nodealMessage, $totalMessage,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(23, $sid, $data);
        return $tempData;
    }

    //万能商城
    private function _get_report_data_24($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $data = array(
            $addMember, $memberTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal
        );

        $tempData = $this->_format_templmsg_data(24, $sid, $data);
        return $tempData;
    }

    //万能企业
    private function _get_report_data_25($sid){
        return false;
    }

    //在线问答
    private function _get_report_data_26($sid){
        return false;
    }

    //知识付费
    private function _get_report_data_27($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //新增会员
        $memberCardCount = $cardStatistic['memberCardCount'];
        //总会员数
        $membeCardTotal  = $cardStatistic['memberCount'];

        $cashStatistic = $this->_get_cashier_statistic($sid);
        //收银笔数
        $cashTotal = $cashStatistic['cashTotal'];
        //收银金额
        $cashMoney = $cashStatistic['cashMoney'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $data = array(
            $addMember, $memberTotal,
            $memberCardCount, $membeCardTotal,
            $cashTotal, $cashMoney,
            $goodsSale, $orderTotal, $orderMoney,
            $saleTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal
        );

        $tempData = $this->_format_templmsg_data(27, $sid, $data);
        return $tempData;
    }

    //求职内推
    private function _get_report_data_28($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $jobStatistic = $this->_get_job_statistic($sid);
        //新增简历
        $resumeAdd   = $jobStatistic['resumeAdd'];
        //总简历数
        $resumeTotal = $jobStatistic['resumeTotal'];
        //新增职位
        $positionAdd = $jobStatistic['positionAdd'];
        //总职位数
        $positionTotal = $jobStatistic['positionTotal'];
        //新申请公司
        $companyAdd = $jobStatistic['companyAdd'];
        //总公司数
        $companyTotal = $jobStatistic['companyTotal'];

        $cardStatistic = $this->_get_membercard_statistic($sid);
        //新增会员
        $memberCardCount = $cardStatistic['memberCardCount'];
        //总会员数
        $membeCardTotal  = $cardStatistic['memberCount'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $withdrawStatistic = $this->_get_withdraw_statistic($sid);
        //用户提现申请
        $withdrawCount = $withdrawStatistic['totalCount'];
        //用户提现申请金额
        $withdrawMoney = $withdrawStatistic['totalMoney'];

        $data = array(
            $addMember, $memberTotal,
            $resumeAdd, $resumeTotal,
            $positionAdd, $positionTotal,
            $companyAdd, $companyTotal,
            $memberCardCount, $membeCardTotal,
            $rechargeCount, $rechargeTotal,
            $withdrawCount, $withdrawMoney,
        );

        $tempData = $this->_format_templmsg_data(28, $sid, $data);
        return $tempData;
    }

    //游戏盒子
    private function _get_report_data_30($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $pointsStatisticData = $this->_get_point_statistic($sid);
        //发放积分
        $inPointsTotal = $pointsStatisticData['inPointTotal'];
        //使用积分
        $outPointsTotal = $pointsStatisticData['outPointTotal'];
        //剩余积分
        $pointsTotal = $pointsStatisticData['pointsTotal'];

        $withdrawStatistic = $this->_get_withdraw_statistic($sid);
        //用户提现申请
        $withdrawCount = $withdrawStatistic['totalCount'];
        //用户提现申请金额
        $withdrawMoney = $withdrawStatistic['totalMoney'];

        //总游戏数
        $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($sid);
        $where = array();
        $where[] = array('name'=>'agg_s_id','oper'=>'=','value'=> $sid);
        $gameTotal = $game_model->getCount($where);

        $data = array(
            $addMember, $memberTotal,
            $inPointsTotal, $outPointsTotal, $pointsTotal,
            $withdrawCount, $withdrawMoney,
            $gameTotal
        );

        $tempData = $this->_format_templmsg_data(30, $sid, $data);
        return $tempData;
    }

    //社区团购
    private function _get_report_data_32($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $sequenceStatistic = $this->_get_sequence_statistic($sid);
        //新增小区
        $communityAdd = $sequenceStatistic['communityAdd'];
        //总小区数
        $communityTotal = $sequenceStatistic['communityTotal'];
        //团长申请
        $leaderAudit = $sequenceStatistic['leaderAudit'];
        //新增团长数
        $leaderAdd = $sequenceStatistic['leaderAdd'];
        //总团长数
        $leaderTotal = $sequenceStatistic['leaderTotal'];

        $orderStatisticData = $this->_get_order_statistic($sid);
        //商品日销量
        $goodsSale    = $orderStatisticData['goodsTotal'];
        //日订单数
        $orderTotal   = $orderStatisticData['orderTotal'];
        //日订单金额
        $orderMoney   = $orderStatisticData['totalMoney'];
        //日退款订单数
        $refundTotal  = $orderStatisticData['refundTotal'];
        //日退款金额
        $refundMoney  = $orderStatisticData['refundMoney'];

        $goodsStatistic = $this->_get_goods_statistic($sid);
        //出售中的商品数
        $saleTotal    = $goodsStatistic['saleTotal'];
        //售罄商品数
        $soldoutTotal = $goodsStatistic['soldoutTotal'];
        //下架商品数
        $nosaleTotal  = $goodsStatistic['nosaleTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal,
            $communityAdd, $communityTotal,
            $leaderAudit, $leaderAdd, $leaderTotal,
            $goodsSale, $orderTotal, $orderMoney, $refundTotal, $refundMoney,
            $saleTotal, $soldoutTotal, $nosaleTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(32, $sid, $data);
        return $tempData;
    }

    //二手车
    private function _get_report_data_33($sid){
        return false;
    }

    //跑腿小程序
    private function _get_report_data_34($sid){
        $memberStatisticData = $this->_get_member_statistic($sid);
        //昨日新增用户数
        $addMember = $memberStatisticData['totalToday'];
        //总用户数
        $memberTotal = $memberStatisticData['totalAll'];

        $legworkStatistic = $this->_get_legwork_statistic($sid);
        //日完成订单数
        $totalNum = $legworkStatistic['totalNum'];
        //日订单金额
        $totalPrice = $legworkStatistic['totalPrice'];
        //返佣金额
        $totalRiderFee = $legworkStatistic['totalRiderFee'];

        //骑手提现申请
        $withdrawNum = $legworkStatistic['withdrawNum'];
        //骑手提现申请金额
        $withdrawMoney = $legworkStatistic['withdrawMoney'];
        //骑手申请
        $messageStatistic = $this->_get_message_statistic($sid);
        $riderApply = $messageStatistic['newAdd'];
        //新增骑手
        $riderAdd = $legworkStatistic['riderAdd'];

        $rechargeStatistic = $this->_get_recharge_statistic($sid);
        //储值笔数
        $rechargeCount = $rechargeStatistic['rechargeCount'];
        //储值金额
        $rechargeTotal = $rechargeStatistic['rechargeTotal'];

        $couponStatisticData = $this->_get_coupon_statistic($sid);
        //发放优惠券数
        $receiveCouponTotal = $couponStatisticData['receiveTotal'];
        //使用优惠券数
        $usedCouponTotal = $couponStatisticData['usedTotal'];
        //失效优惠券数
        $expireCouponTotal = $couponStatisticData['expireTotal'];

        $data = array(
            $addMember, $memberTotal,
            $totalNum, $totalPrice, $totalRiderFee,
            $withdrawNum, $withdrawMoney,
            $riderApply, $riderAdd,
            $rechargeCount, $rechargeTotal,
            $receiveCouponTotal, $usedCouponTotal, $expireCouponTotal
        );

        $tempData = $this->_format_templmsg_data(34, $sid, $data);
        return $tempData;
    }

    //会员统计
    private function _get_member_statistic($sid){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $where_total = $where_today = [];
        $where_total[] = $where_today[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $sid];
        $where_total[] = $where_today[] = ['name' => 'm_source', 'oper' => 'in', 'value' => array(2, 3, 5)];
        $where_today[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '>=', 'value' => $this->startTime];
        $where_today[] = ['name' => 'unix_timestamp(m_follow_time)', 'oper' => '<', 'value' => $this->endTime];

        $totalToday = $member_model->getCount($where_today); //新增会员数
        $total = $member_model->getCount($where_total); //会员总数
        return array(
            'totalToday' => $totalToday,
            'totalAll' => $total
        );
    }

    //发帖统计
    private function _get_post_statistic($sid){
        $where = [];
        $where[] = array('name' => 'acp_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acp_create_time', 'oper' => '>=', 'value' => $this->startTime);
        $where[] = array('name' => 'acp_create_time', 'oper' => '<', 'value' => $this->endTime);
        $post_storage = new App_Model_City_MysqlCityPostStorage($sid);
        $totalPost = $post_storage->getPostListMemberCount($where); //发帖数

        $where = array();
        $where[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'cpp_create_time', 'oper' => '>=', 'value' => $this->startTime);
        $where[] = array('name' => 'cpp_create_time', 'oper' => '<', 'value' => $this->endTime);
        $pay_model = new App_Model_City_MysqlCityPostPayStorage($sid);
        $totalProfit = $pay_model->getProfitMoneyAll($where); //发帖收益
        return array(
            'totalPost'   => $totalPost,  // 总发帖量
            'totalProfit' => $totalProfit?$totalProfit:0 // 总发帖收益
        );
    }

    //订单统计
    private function _get_order_statistic($sid, $isEnterShop=false){
        $where = [];
        $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startTime);
        $where[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endTime);
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$sid);
        if($isEnterShop){
            $where[] = array('name'=>'t_s_id','oper'=>'>','value'=>0);
        }
        $order_model = new App_Model_Trade_MysqlTradeStorage($sid);
        $orderStatistic = $order_model->statOrderStatistic($where);

        $goodsTotal = $orderStatistic['goodsNum'];
        $orderTotal = $orderStatistic['total'];
        $totalMoney = $orderStatistic['money'];

        $where = [];
        $where[] = array('name'=>'tr_s_id','oper'=>'=','value'=>$sid);
        if($isEnterShop){
            $where[] = array('name'=>'tr_es_id','oper'=>'>','value'=>0);
        }
        $where[] = array('name'=>'tr_create_time','oper'=>'>=','value'=> $this->startTime);
        $where[] = array('name'=>'tr_create_time','oper'=>'<','value'=> $this->endTime);
        $refund_model = new App_Model_Trade_MysqlTradeRefundStorage($sid);
        $refundStatistic = $refund_model->refundOrderStatistic($where);

        $refundTotal = $refundStatistic['total'];
        $refundMoney = $refundStatistic['money'];

        return array(
            'goodsTotal'  => $goodsTotal?$goodsTotal:0,  // 商品日销量
            'orderTotal'  => $orderTotal,  // 订单总数
            'totalMoney'  => $totalMoney?$totalMoney:0,  // 订单总金额
            'refundTotal' => $refundTotal, // 退款订单数量
            'refundMoney' => $refundMoney?$refundMoney:0  // 退款订单总金额
        );
    }

    //优惠券统计
    private function _get_coupon_statistic($sid){
        $where_receive = $where_expire = $where_used = [];
        $where_receive[] = $where_expire[] = $where_used[] = ['name' => 'cl_s_id','oper' => '=','value' =>$sid];
        $where_receive[] = $where_expire[] = $where_used[] = ['name' => 'cl_es_id','oper' => '=','value' => 0];
        $where_receive[] = $where_expire[] = $where_used[] = ['name' => 'cl_coupon_type','oper' => '=','value' =>0];

        $where_receive[] = array('name'=>'cr_receive_time','oper'=>'>=','value'=> $this->startTime);
        $where_receive[] = array('name'=>'cr_receive_time','oper'=>'<','value'=> $this->endTime);

        $where_expire[] = array('name'=>'cr_expire_time','oper'=>'>=','value'=> $this->startTime);
        $where_expire[] = array('name'=>'cr_expire_time','oper'=>'<','value'=> $this->endTime);

        $where_used[] = array('name'=>'cr_used_time','oper'=>'>=','value'=> $this->startTime);
        $where_used[] = array('name'=>'cr_used_time','oper'=>'<','value'=> $this->endTime);

        $receive_model = new App_Model_Coupon_MysqlReceiveStorage();
        $usedTotal    = $receive_model->getReceiveStat($where_used);
        $receiveTotal = $receive_model->getReceiveStat($where_receive);
        $expireTotal  = $receive_model->getReceiveStat($where_expire);

        return array(
            'usedTotal'    => $usedTotal['total'],    // 使用优惠券数量
            'receiveTotal' => $receiveTotal['total'], // 领取优惠券数量
            'expireTotal'  => $expireTotal['total']   // 过期优惠券数量
        );
    }

    //积分统计
    private function _get_point_statistic($sid){
        $in_where = $out_where = array();
        $in_where[]  = $out_where[] = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $sid);
        $in_where[]  = $out_where[] = array('name' => 'pi_create_time', 'oper' => '>=', 'value' => $this->startTime);
        $in_where[]  = $out_where[] = array('name' => 'pi_create_time', 'oper' => '<', 'value' => $this->endTime);
        $in_where[]  = array('name' => 'pi_type', 'oper' => '=', 'value' => 1); // 收入
        $out_where[] = array('name' => 'pi_type', 'oper' => '=', 'value' => 2); // 支出
        $point_model = new App_Model_Point_MysqlInoutStorage($sid);
        $inPointTotal  = $point_model->pointStatistic($in_where);
        $outPointTotal = $point_model->pointStatistic($out_where);

        $where = array();
        $where[] = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $pointsTotal = $member_model->memberPointsStatistic($where);

        return array(
            'inPointTotal'  => $inPointTotal?$inPointTotal:0,  // 发放积分总数
            'outPointTotal' => $outPointTotal?$outPointTotal:0, // 使用积分总数
            'pointsTotal'   => $pointsTotal?$pointsTotal:0    // 剩余积分总数
        );
    }

    //入驻商家统计
    private function _get_entershop_statistic($sid, $appletType){
        if($appletType == 6){
            $pay_model = new App_Model_City_MysqlCityPostPayStorage($sid);
            $where[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $sid);
            $where[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 2);
            $where[] = array('name' => 'cpp_create_time', 'oper' => '>=', 'value' => $this->startTime);
            $where[] = array('name' => 'cpp_create_time', 'oper' => '<', 'value' => $this->endTime);
            $shopTotal   = $pay_model->getProfitCountAll($where); // 入驻商家数量
            $profitTotal = $pay_model->getProfitTotal($where); // 入驻商家收益
        }

        if($appletType == 8){
            $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($sid);
            $where[] = array('name' => 'acap_s_id', 'oper' => '=', 'value' => $sid);
            $where[] = array('name' => 'acap_create_time', 'oper' => '>=', 'value' => $this->startTime);
            $where[] = array('name' => 'acap_create_time', 'oper' => '<', 'value' => $this->endTime);
            $shopTotal   = $pay_model->getCount($where); // 入驻商家数量
            $profitTotal = $pay_model->getProfitTotal($where); // 入驻商家收益
        }

        return array(
            'shopTotal'   => $shopTotal,  // 入驻商家数量
            'profitTotal' => $profitTotal?$profitTotal:0 // 入驻商家收益
        );
    }

    //收银统计
    private function _get_cashier_statistic($sid){
        $where_total   = [];
        $where_total[] = ['name'=>'cr_s_id','oper'=>'=','value'=> $sid];
        $where_total[] = ['name'=>'cr_isrefund','oper'=>'=','value'=> 0];
        $where_total[] = ['name'=>'cr_pay_time','oper'=>'>=','value'=> $this->startTime];
        $where_total[] = ['name'=>'cr_pay_time','oper'=>'<','value'=> $this->endTime];

        $cash_recode= new App_Model_Cash_MysqlRecordStorage($sid);
        $cashInfo = $cash_recode->getSumInfo($where_total);
        return array(
            'cashTotal' => $cashInfo['total'] ? $cashInfo['total'] : 0,
            'cashMoney' => $cashInfo['money'] ? $cashInfo['money'] : 0,
        );
    }

    //商品统计
    private function _get_goods_statistic($sid, $isEnterShop=false){
        //获得统计信息
        $where_total   = $where_soldout = $where_nosale = [];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_s_id','oper' => '=','value' => $sid];
        $where_total[] = $where_soldout[] = $where_nosale[] = ['name' => 'g_type','oper' => 'in','value' => array(1,2)];
        if($isEnterShop){
            $where_total[] = $where_soldout[] = $where_nosale[] = array('name' => 'g_es_id','oper' => '>','value' => 0);
        }
        $where_soldout[] = ['name' => 'g_stock','oper' => '=','value' => 0];
        $where_soldout[] = ['name' => 'g_is_sale','oper' => '=','value' => 1];
        $where_nosale[]  = ['name' => 'g_is_sale','oper' => '=','value' => 2];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $totalInfo = $goods_model->getStatInfo($where_total);
        $soldout   = $goods_model->getCount($where_soldout);
        $nosale    = $goods_model->getCount($where_nosale);
        $sale      = intval($totalInfo['total']) - intval($soldout) - intval($nosale);
        return array(
            'soldoutTotal' => intval($soldout),
            'nosaleTotal'  => intval($nosale),
            'saleTotal'    => $sale > 0 ? $sale : 0
        );
    }

    //会员卡|计次卡统计统计
    private function _get_membercard_statistic($sid){
        //获得统计信息
        $where_times    = $where_member = [];
        $where_times[]  = $where_member[] = ['name' => 'oo_s_id', 'oper' => '=', 'value' => $sid];
        $where_times[]  = $where_member[] = ['name' => 'oo_pay_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where_times[]  = $where_member[] = ['name' => 'oo_pay_time', 'oper'=>'<', 'value'=> $this->endTime];
        $where_times[]  = ['name' => 'oo_card_type', 'oper' => '=', 'value' => 1];
        $where_member[] = ['name' => 'oo_card_type', 'oper' => '=', 'value' => 2];
        $order_model = new App_Model_Store_MysqlOrderStorage($sid);
        $timesCardInfo  = $order_model->getTotalAction($where_times);
        $memberCardInfo = $order_model->getTotalAction($where_member);

        $member_model= new App_Model_Store_MysqlMemberStorage($sid);
        $where_total = [];
        $where_total[] = ['name' => 'om_s_id', 'oper' => '=', 'value' => $sid];
        $where_total[] = ['name' => 'om_type', 'oper' => '=', 'value' => 2];
        $where_total[] = ['name' => 'om_expire_time', 'oper' => '>', 'value' => time()];
        $memberCount = $member_model->getCount($where_total);
        return array(
            'timesCardMoney'  => floatval($timesCardInfo['money']),
            'timesCardCount'  => intval($timesCardInfo['total']),
            'memberCardMoney' => floatval($memberCardInfo['money']),
            'memberCardCount' => intval($memberCardInfo['total']),
            'memberCount'     => $memberCount
        );
    }

    //储值统计
    private function _get_recharge_statistic($sid){
        $where          = array();
        $where[]        = array('name' => 'rr_s_id', 'oper' => '=', 'value' => $sid);
        $where[]        = array('name' => 'rr_status', 'oper' => '=', 'value' => 1);
        $where[]        = array('name' => 'rr_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where[]        = array('name' => 'rr_create_time', 'oper'=>'<', 'value'=> $this->endTime);

        $recharge_model = new App_Model_Member_MysqlRechargeStorage($sid);
        $rechargeInfo   = $recharge_model->getAmountSumAction($where);

        return array(
            'rechargeTotal' => floatval($rechargeInfo['total']),
            'rechargeCount' => floatval($rechargeInfo['number'])
        );
    }

    //留言统计
    private function _get_message_statistic($sid){
        $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
        //统计信息
        $where_total    = $where_nodeal = $where_add = [];
        $where_total[]  = $where_nodeal[] = $where_add[] = ['name'=>'acfd_s_id','oper'=>'=','value'=> $sid];
        $where_nodeal[] = ['name'=>'acfd_processed','oper'=>'=','value'=> 0];
        $where_add[]    = ['name' => 'acfd_create_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where_add[]    = ['name' => 'acfd_create_time', 'oper'=>'<', 'value'=> $this->endTime];
        $total  = $data_model->getCount($where_total);
        $nodeal = $data_model->getCount($where_nodeal);
        $newAdd = $data_model->getCount($where_add);

        return array(
            'total'  => $total,
            'nodeal' => $nodeal,
            'newAdd' => $newAdd
        );
    }

    //提现统计
    private function _get_withdraw_statistic($sid){
        //获得统计信息
        $where_total = [];
        $where_total[] = ['name' => 'wd_s_id', 'oper' => '=', 'value' => $sid];
        $where_total[] = ['name' => 'wd_create_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where_total[] = ['name' => 'wd_create_time', 'oper'=>'<', 'value'=> $this->endTime];

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $totalInfo = $withdraw_model->getStatInfo($where_total);

        return array(
            'totalCount' => intval($totalInfo['total']),
            'totalMoney' => floatval($totalInfo['money']),
        );
    }

    //内推招聘统计
    private function _get_job_statistic($sid){
        //简历统计
        $resume_model = new App_Model_Job_MysqlJobResumeStorage($sid);
        $where_total = $where_add = array();
        $where_total[] = $where_add[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $sid);
        $where_add[] = array('name' => 'ajr_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'ajr_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $resumeAdd   = $resume_model->getCount($where_add);
        $resumeTotal = $resume_model->getCount($where_total);

        //职位统计
        $position_model = new App_Model_Job_MysqlJobPositionStorage($sid);
        $where_total = $where_add = array();
        $where_total[] = $where_add[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $sid);
        $where_add[] = array('name' => 'ajp_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'ajp_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $positionAdd   = $position_model->getCount($where_add);
        $positionTotal = $position_model->getCount($where_total);

        //公司统计
        $company_model = new App_Model_Job_MysqlJobCompanyStorage($sid);
        $where_total = $where_add = array();
        $where_total[] = $where_add[] = array('name' => 'ajc_s_id', 'oper' => '=', 'value' => $sid);
        $where_add[] = array('name' => 'ajc_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'ajc_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $where_total[] = array('name' => 'ajc_status', 'oper'=>'=', 'value'=> 2);
        $companyAdd   = $company_model->getCount($where_add);
        $companyTotal = $company_model->getCount($where_total);

        return array(
            'resumeAdd'     => $resumeAdd,
            'resumeTotal'   => $resumeTotal,
            'positionAdd'   => $positionAdd,
            'positionTotal' => $positionTotal,
            'companyAdd'    => $companyAdd,
            'companyTotal'  => $companyTotal,
        );
    }

    //工单统计
    private function _get_workorder_statistic($sid){
        $where_total = $where_add = $where_nodeal = $where_dealing = $where_finish = array();
        $where_total[] = $where_add[] = $where_nodeal[] = $where_dealing[] = $where_finish[] = array('name'=>'awo_s_id','oper'=>'=','value'=> $sid);
        $where_add[] = array('name' => 'awo_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'awo_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $where_nodeal[] = array('name' => 'awo_status', 'oper' => '=', 'value' => 1);
        $where_dealing[] = array('name' => 'awo_status', 'oper' => '=', 'value' => 2);
        $where_finish[] = array('name' => 'awo_status', 'oper' => '=', 'value' => 3);
        $order_storage = new App_Model_Workorder_MysqlWorkOrderStorage($sid);
        $newAdd   = $order_storage->getCount($where_add);
        $nodeal   = $order_storage->getCount($where_nodeal);
        $dealing  = $order_storage->getCount($where_dealing);
        $finish   = $order_storage->getCount($where_finish);
        $total    = $order_storage->getCount($where_total);

        return array(
            'newAdd'  => $newAdd,
            'noDeal'  => $nodeal,
            'dealing' => $dealing,
            'finish'  => $finish,
            'total'   => $total,
        );
    }

    //房产统计
    private function _get_house_statistic($sid){
        $where_add = $where_total = [];
        $where_add[] = $where_total[] = array('name' => 'aha_s_id', 'oper'  => '=', 'value' => $sid);
        $where_add[] = array('name' => 'aha_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'aha_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $apply_model = new App_Model_House_MysqlHouseApplyStorage();
        $applyAdd   = $apply_model->getCount($where_add);
        $applyTotal = $apply_model->getCount($where_total);

        $where_add = $where_total = [];
        $where_add[] = $where_total[] = array('name' => 'ahe_s_id', 'oper'  => '=', 'value' => $sid);
        $where_add[] = array('name' => 'ahe_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'ahe_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $enter_storage = new App_Model_House_MysqlHouseEnterStorage();
        $shopAdd   = $enter_storage->getCount($where_add);
        $shopTotal = $enter_storage->getCount($where_total);

        $where_add = $where_total = [];
        $where_add[] = $where_total[] = array('name' => 'ahr_s_id', 'oper'  => '=', 'value' => $sid);
        $where_add[] = array('name' => 'ahr_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'ahr_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $resources_model = new App_Model_Resources_MysqlResourcesStorage();
        $houseAdd   = $resources_model->getCount($where_add);
        $houseTotal = $resources_model->getCount($where_total);

        return array(
            'applyAdd'   => $applyAdd,
            'applyTotal' => $applyTotal,
            'shopAdd'    => $shopAdd,
            'shopTotal'  => $shopTotal,
            'houseAdd'   => $houseAdd,
            'houseTotal' => $houseTotal,
        );
    }

    //社区团购统计
    private function _get_sequence_statistic($sid){
        //获得统计信息
        $where_total    = $where_add = [];
        $where_total[]  = $where_add[] = ['name'=>'asc_s_id','oper'=>'=','value'=>$sid];
        $where_add[] = array('name' => 'asc_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = array('name' => 'asc_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($sid);
        $communityAdd   = $community_model->getCount($where_add);
        $communityTotal = $community_model->getCount($where_total);

        //获得统计信息
        $where_total = $where_audit = $where_add = [];
        $where_total[] = $where_audit[] = $where_add[] = ['name'=>'asl_s_id','oper'=>'=','value'=> $sid];
        $where_total[] = $where_audit[] = $where_add[] = ['name'=>'asl_status','oper'=>'in','value'=>[1,2,3]];
        $where_audit[] = ['name'=>'asl_status','oper'=>'=','value'=>1];
        $where_add[]   = ['name'=>'asl_status','oper'=>'=','value'=>2];
        $where_add[] = $where_audit[] = array('name' => 'asl_create_time', 'oper'=>'>=', 'value'=> $this->startTime);
        $where_add[] = $where_audit[] = array('name' => 'asl_create_time', 'oper'=>'<', 'value'=> $this->endTime);
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($sid);
        $leaderTotal  = $leader_model->getCount($where_total);
        $leaderAdd    = $leader_model->getCount($where_add);
        $leaderAudit  = $leader_model->getCount($where_audit);

        return array(
            'communityAdd'   => $communityAdd,
            'communityTotal' => $communityTotal,
            'leaderTotal'    => $leaderTotal,
            'leaderAdd'      => $leaderAdd,
            'leaderAudit'    => $leaderAudit,
        );
    }

    //跑腿统计
    private function _get_legwork_statistic($sid){
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($sid);
        $where[]    = array('name'=>'alt_s_id','oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'alt_create_time','oper'=>'>=','value'=> $this->startTime);
        $where[] = array('name'=>'alt_create_time','oper'=>'<','value'=> $this->endTime);
        $where[] = array('name'=>'alt_status','oper'=>'in','value'=>array(6));  //获取已付款,已发货,确认收货,已完成的订单,
        $tradeStatistic = $trade_model->tradePostFeeSum($where);

        $tradeList = $trade_model->getList($where);
        $totalRiderFee = 0;
        foreach ($tradeList as $val){
            $totalRiderFee = $val['alt_basic_price'] + $val['alt_plus_price'] + $val['alt_tip_fee']  + $val['alt_format_price'];
            $postPercent = floatval($val['alt_post_percent']);
            $riderFee = $postPercent > 0 ? round($totalRiderFee - $totalRiderFee*$postPercent/100,2) : $totalRiderFee;
            $totalRiderFee += $riderFee;
        }

        $where_total = [];
        $where_total[] = ['name' => 'alrw_s_id', 'oper' => '=', 'value' => $sid];
        $where_total[] = ['name' => 'alrw_create_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where_total[] = ['name' => 'alrw_create_time', 'oper'=>'<', 'value'=> $this->endTime];

        $withdraw_model = new App_Model_Legwork_MysqlLegworkRiderWithdrawStorage($sid);
        $totalNum = $withdraw_model->getSum($where_total);
        $totalMoney = $withdraw_model->getCount($where_total);

        $where = [];
        $where[] = array('name'=>'alr_s_id','oper'=>'=','value'=>$sid);
        $where[] = ['name' => 'alr_create_time', 'oper'=>'>=', 'value'=> $this->startTime];
        $where[] = ['name' => 'alr_create_time', 'oper'=>'<', 'value'=> $this->endTime];
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($sid);
        $riderAdd = $rider_model->getCount($where);

        return array(
            'totalPrice'    => $tradeStatistic['totalPrice'],
            'totalNum'      => $tradeStatistic['total'],
            'totalRiderFee' => $totalRiderFee,
            'withdrawNum'   => $totalNum?$totalNum:0,
            'withdrawMoney' => $totalMoney,
            'riderAdd'      => $riderAdd
        );
    }

    //会务统计
    private function _get_meeting_statistic($sid){
        $where_ing = $where_end = array();
        $where_ing[] = $where_end[] = array('name'=>'am_s_id','oper'=>'=','value'=> $sid);
        $where_ing[] = array('name'=>'am_end_time','oper'=>'<','value'=> time());
        $where_end[] = array('name'=>'am_end_time','oper'=>'>=','value'=> time());
        $meeting_storage = new App_Model_Meeting_MysqlMeetingStorage($sid);
        $meetingCount = $meeting_storage->getCount($where_ing);
        $meetingEndCount = $meeting_storage->getCount($where_end);

        $where = [];
        $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startTime);
        $where[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endTime);
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$sid);
        $order_model = new App_Model_Trade_MysqlTradeStorage($sid);
        $orderStatistic = $order_model->statOrderStatistic($where);
        $goodsTotal = $orderStatistic['goodsNum'];
        $totalMoney = $orderStatistic['money'];

        $where = [];
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));  //获取已付款,已发货,确认收货,已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$sid);
        $orderStatistic = $order_model->statOrderStatistic($where);
        $allMoney = $orderStatistic['money'];

        $where = [];
        $where[] = array('name'=>'t_status','oper'=>'=','value'=> 6);  //已完成的订单,
        $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=> $this->startTime);
        $where[] = array('name'=>'t_create_time','oper'=>'<','value'=> $this->endTime);
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$sid);
        $signTotal = $order_model->statOrderStatistic($where);

        $where = [];
        $where[] = array('name'=>'t_status','oper'=>'=','value'=> 6);  //已完成的订单,
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$sid);
        $allSignTotal = $order_model->statOrderStatistic($where);

        return array(
            'meetingCount'    => $meetingCount,
            'meetingEndCount' => $meetingEndCount,
            'goodsTotal'      => $goodsTotal?$goodsTotal:0,
            'totalMoney'      => $totalMoney?$totalMoney:0,
            'allMoney'        => $allMoney,
            'signTotal'       => $signTotal['total'],
            'allSignTotal'    => $allSignTotal['total'],
        );
    }

}