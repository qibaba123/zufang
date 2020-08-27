<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/14
 * Time: 上午10:40
 */
class App_Helper_UnitaryOrder {

    const UNITARY_ORDER_NONPAY      = 0;//待支付
    const UNITARY_ORDER_BALANCE     = 1;//余额部分支付
    const UNITARY_ORDER_PLATFORM    = 2;//支付平台部分支付
    const UNITARY_ORDER_HADPAY      = 3;//全部支付
    const UNITARY_ORDER_REFUND      = 4;//退款

    const UNITARY_PLAN      = 1;//参与夺宝计划
    const UNITARY_REDPACK   = 2;//参与红包抢购

    const UNITARY_PLAN_BASE = 10000000;//基数

    const UNITARY_PLAN_PUBLISH  = 480;//计算倒计时，8分钟
    const UNITARY_REDPACK_AWARD = 300;//红包开奖倒计时,5分钟

    const UNITARY_STATUS_UNDER  = 0;//进行中
    const UNITARY_STATUS_UNVEIL = 1;//揭晓中
    const UNITARY_STATUS_PUBLISH= 2;//已揭晓
    const UNITARY_STATUS_OVER   = 3;//已结束

    /**
     * 夺宝、红包的状态
     */
    public static $plan_redPack_status    = array(
        'all'   => array(
            'id'    => -1,
            'label' => '全部'
        ),
        'running'   => array(
            'id'    => self::UNITARY_STATUS_UNDER ,
            'label' => '进行中'
        ),
        'success'   => array(
            'id'    => self::UNITARY_STATUS_UNVEIL ,
            'label' => '揭晓中'
        ),
        'complete'   => array(
            'id'    => self::UNITARY_STATUS_PUBLISH ,
            'label' => '已揭晓'
        ),
        'failure'   => array(
            'id'    => self::UNITARY_STATUS_OVER,
            'label' => '已结束'
        ),
    );

    /*
     * 店铺信息，字段名参考pre_shop
     */
    private $shop;
    private $sid;

    public function __construct($sid) {
        if (!$sid) {
            return null;
        }
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        $this->sid      = $sid;
        return $this;
    }

    public static $orderType = array(
        self::UNITARY_PLAN    => '夺宝计划',
        self::UNITARY_REDPACK => '红包抢购',
    );
    public static $orderStatus = array(
        self::UNITARY_ORDER_NONPAY   => '待支付',
        self::UNITARY_ORDER_BALANCE  => '余额部分支付',
        self::UNITARY_ORDER_PLATFORM => '支付平台部分支付',
        self::UNITARY_ORDER_HADPAY   => '全部支付',
        self::UNITARY_ORDER_REFUND   => '退款',
    );

    /*
     * 参加一元夺宝及定时红包
     */
    public function joinUnitary($tid) {
        $order_storage  = new App_Model_Unitary_MysqlOrderStorage($this->sid);
        $order  = $order_storage->findUpdateOrderByTid($tid);//获取订单

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member         = $member_model->getRowById($order['uo_m_id']);

        //创建夺宝参与记录
        list($usec, $sec)   = explode(" ", microtime());
        $indata     = array(
            'ur_p_id'       => $order['uo_p_id'],
            'ur_p_type'     => $order['uo_type'],//参与类型
            'ur_s_id'       => $order['uo_s_id'],
            'ur_m_id'       => $order['uo_m_id'],
            'ur_join_nick'  => $member['m_nickname'],
            'ur_join_time'  => $sec,
            'ur_join_microtime'     => round($usec, 3),//保留3位小数
            'ur_num'        => $order['uo_num'],//参与数量
            'ur_o_id'       => $order['uo_id'],
        );
        $record_storage = new App_Model_Unitary_MysqlRecordStorage($this->sid);

        switch ($order['uo_type']) {
            //参与夺宝计划
            case self::UNITARY_PLAN :
                //获取夺宝随机号码
                $plan_redis     = new App_Model_Unitary_RedisPlanStorage($this->sid);
                $left   = $plan_redis->fetchPlanLeft($order['uo_p_id']);//剩余量

                if ($left < $order['uo_num']) {
                    //@todo 标记订单退款

                    break;
                }
                //写入夺宝参与记录
                $rid = $record_storage->insertValue($indata);
                $list   = array();
                for ($i=0; $i<$order['uo_num']; $i++) {
                    $left--;
                    array_push($list, $plan_redis->fetchRandomNum($order['uo_p_id']));
                }
                //创建夺宝号码记录
                $list_storage   = new App_Model_Unitary_MysqlListStorage($this->sid);
                $lidata = array(
                    'ul_s_id'       => $this->sid,
                    'ul_p_id'       => $order['uo_p_id'],
                    'ul_r_id'       => $rid,
                    'ul_m_id'       => $order['uo_m_id'],
                    'ul_create_time'=> $sec,
                );
                foreach ($list as $number) {
                    if ($number) {
                        $lidata['ul_number']    = $number;
                        $list_storage->insertValue($lidata);
                    }
                }
                //修改夺宝计划已参与次数
                $plan_storage   = new App_Model_Unitary_MysqlPlanStorage($this->sid);
                $plan_storage->incrementHadJoin($order['uo_p_id'], $order['uo_num']);
                //最后一条号码
                if ($left == 0) {
                    $updata = array(
                        'up_status'     => self::UNITARY_STATUS_UNVEIL,//揭晓中
                        'up_pub_time'   => time()+(2*self::UNITARY_PLAN_PUBLISH),//16分钟后放出
                    );
                    $plan_storage->updateById($updata, $order['uo_p_id']);
                    //将夺宝记录置于定时计划中，八分钟后开始计算
                    $plan_redis->createPlanCountdown($order['uo_p_id'], self::UNITARY_PLAN_PUBLISH);
                }
                break;
            //参与定时红包
            case self::UNITARY_REDPACK :
                $redpack_storage    = new App_Model_Unitary_MysqlRedpackStorage($this->sid);
                $redpack    = $redpack_storage->getRowById($order['uo_p_id']);
                //正在进行中的红包可参与
                if ($redpack['ur_start_time'] < time() && !$redpack['ur_status'] && $redpack['ur_end_time'] > time()) {
                    $redpack_storage->incrementHadJoin($order['uo_amount'], $order['uo_num'], $order['uo_p_id']);

                    $rid = $record_storage->insertValue($indata);
                } else {
                    //@todo 标记退款
                }

                break;
        }
    }

    /*
     * 计算一元夺宝中奖
     */
    public function computePlan($pid) {
        $plan_storage   = new App_Model_Unitary_MysqlPlanStorage($this->sid);
        $plan   = $plan_storage->getRowById($pid);
        //获取全站最新50条参与记录，可小于50
        $record_storage = new App_Model_Unitary_MysqlRecordStorage($this->sid);

        $where  = array();
        $index  = 0;
        $count  = 50;
        $sort   = array('ur_id' => 'DESC');
        $record     = $record_storage->getList($where, $index, $count, $sort);

        if (!$record) {
            return;
        }
        $max = $record[0]['ur_id'];

        $sum = 0;
        foreach ($record as $val) {
            $join_time  = $val['ur_join_time'];
            $tmp    = intval(date('G', $join_time)) * 10000000;
            $tmp    = $tmp+intval(date('i', $join_time)) * 100000;
            $tmp    = $tmp+intval(date('s', $join_time)) * 1000;
            $tmp    = $tmp+round($val['ur_join_microtime'], 3) * 1000;
            $sum    = $sum+$tmp;
        }
        //获取重庆时时彩数据
        $url    = 'http://f.apiplus.cn/cqssc-1.json';
        $json   = Libs_Http_Client::get($url);
        if (!$json) {
            return;
        }
        $json   = json_decode($json, true);
        $expect     = $json['data'][0]['expect'];
        $lattery    = intval(str_replace(',', '', $json['data'][0]['opencode']));
        //计算幸运号码
        $remain = ($sum+$lattery)%intval($plan['up_total']);
        $lucky  = self::UNITARY_PLAN_BASE+$remain;

        //获取中奖信息
        $list_storage   = new App_Model_Unitary_MysqlListStorage($this->sid);
        $reward = $list_storage->fetchRecordByPidNum($pid, $lucky);
        //保存数据
        $updata = array(
            'up_last_joinid'    => $max,
            'up_num_a'          => $sum,
            'up_lottery_expect' => $expect,
            'up_num_b'          => $lattery,
            'up_luck_num'       => $lucky,
            'up_luck_mid'       => $reward['ul_m_id'],
            'up_luck_rid'       => $reward['ul_r_id'],
        );
        $plan_storage->updateById($updata, $pid);
        //自动开启下一期
        $this->autoOpenPlan($pid);
    }
    /*
     * 自动循环开启一元夺宝
     */
    public function autoOpenPlan($upid) {
        $plan_model = new App_Model_Unitary_MysqlPlanStorage($this->sid);
        $plan   = $plan_model->fetchDetailByPlan($upid);
        //自动开启下一期
        if ($plan && $plan['ug_auto']) {
            $issue  = $plan_model->getIssueMax($plan['up_g_id']);
            $indata = array(
                'up_s_id'       => $this->sid,
                'up_g_id'       => $plan['up_g_id'],
                'up_k_id'       => $plan['up_k_id'],
                'up_issue'      => intval($issue)+1,
                'up_create_time'=> time(),
                'up_max_last'   => $plan['up_max_last'],
                'up_last_action'=> $plan['up_last_action'],
                'up_total'      => $plan['up_total'],
                'up_had'        => 0,
                'up_left'       => $plan['up_total'],
                'up_act_rule'   => $plan['up_act_rule'],
                'up_money_limit'=> $plan['up_money_limit'],
                'up_status'     => 0,//进行中
            );
            $ret = $plan_model->insertValue($indata);
            if ($ret) {
                //创建夺宝计划号码序列
                $redis_model = new App_Model_Unitary_RedisPlanStorage($this->sid);
                $redis_model->createPlanSeq($ret, $indata['up_total']);
                //是否创建夺宝自动填充功能
                if ($plan['up_max_last']) {
                    $left   = intval($plan['up_max_last'])*60*60;
                    $redis_model->createPlanAutoFill($ret, $left);
                }
            }
        }
    }

    /*
     * 计算定时红包
     */
    public function computeRedpack($redid) {
        $redpack_storage    = new App_Model_Unitary_MysqlRedpackStorage($this->sid);
        $redpack    = $redpack_storage->getRowById($redid);

        if (!$redpack) {
            return;
        }
        //无人参与的红包，将状态置为已过期
        if (!$redpack['ur_num'] || !$redpack['ur_amount']) {
            //修改红包状态
            if($this->sid==1615){
                $set_array = array('ur_status'=>3);
                $set_row   = $redpack_storage->updateById($set_array,$redpack['ur_id']);
                $this->autoOpenRedPack($redpack['ur_id']);
                return;
            }else{
                $updata = array(
                    'ur_status'     => self::UNITARY_STATUS_OVER,//已过期状态
                );
                $redpack_storage->updateById($updata, $redpack['ur_id']);
                return;
            }
        }
        $record_storage = new App_Model_Unitary_MysqlRecordStorage($this->sid);
        $record = $record_storage->fetchRedpackList($redid);

        if (!$record) {
            return;
        }
        $money  = $redpack['ur_amount']*$redpack['ur_ratio'];//乘以分发比例，并转换为分
        $random_helper  = new App_Helper_RedpackRandom($money, $redpack['ur_num']);
        $list   = $random_helper->compute();

        $rplist_storage = new App_Model_Unitary_MysqlRplistStorage($this->sid);
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        foreach ($record as $item) {
            for ($i=0; $i<intval($item['ur_num']); $i++) {
                $award  = array_shift($list)/100;
                $indata = array(
                    'ur_s_id'   => $this->sid,
                    'ur_m_id'   => $item['ur_m_id'],
                    'ur_r_id'   => $item['ur_id'],
                    'ur_amount' => $award,//转换为元
                    'ur_red_id' => $redid,
                    'ur_create_time'    => time(),
                );
                $rplist_storage->insertValue($indata);
                $member_model->incrementMemberGoldcoin($item['ur_m_id'], $award);
            }
        }
        //修改红包状态
        $updata = array(
            'ur_status'     => self::UNITARY_STATUS_UNVEIL,//揭晓中状态
            'ur_pub_time'   => time(),//开奖时间
        );
        $redpack_storage->updateById($updata, $redpack['ur_id']);
    }
    /*
     * 定时红包开奖结束
     */
    public function publishRedpack($redid) {
        $redpack_storage    = new App_Model_Unitary_MysqlRedpackStorage($this->sid);
        $redpack    = $redpack_storage->getRowById($redid);
        //定时红包不存在, 或定时红包非揭晓中状态
        if (!$redpack || $redpack['ur_status'] != self::UNITARY_STATUS_UNVEIL) {
            return;
        }
        //修改红包状态
        $updata = array(
            'ur_status'     => self::UNITARY_STATUS_PUBLISH,//已开奖状态
        );
        $redpack_storage->updateById($updata, $redpack['ur_id']);
        //无人参与的红包,无法进入自动下一期操作(除一元夺夺乐的商品)
        if($this->sid==1615){
            $this->autoOpenRedPack($redpack['ur_id']);
        }else{
            if ($redpack['ur_num'] > 0) {
                $this->autoOpenRedPack($redpack['ur_id']);
            }
        }
    }
    /**
     * 自动下一期红包(测试)
     */
    public function autoOpenRedPack($rpid) {
        $redPack_model = new App_Model_Unitary_MysqlRedpackStorage($this->sid);
        $redPack   = $redPack_model->fetchRedpack($rpid);
        //自动开启下一期
        if ($redPack && $redPack['ur_auto'] == 1) {
            $curr   = time();
            $issue  = $redPack_model->getIssueMax();//获取同一个店铺的最大期号
            //结束时间设置为时间间隔+当前时间
            $end    = ($redPack['ur_end_time'] - $redPack['ur_start_time'])+$curr+60;
            $indata = array(
                'ur_name'       => $redPack['ur_name'],
                'ur_unit_price' => $redPack['ur_unit_price'],
                'ur_ratio'      => $redPack['ur_ratio'],
                'ur_cover_img'  => $redPack['ur_cover_img'],
                'ur_s_id'       => $redPack['ur_s_id'],
                'ur_start_time' => $curr+60,
                'ur_issue'      => intval($issue)+1,
                'ur_end_time'   => $end,
                'ur_create_time'=> $curr,
                'ur_auto'       => $redPack['ur_auto'],
                'ur_act_rule'   => $redPack['ur_act_rule']
            );
            $ret = $redPack_model->insertValue($indata);
            if ($ret) {
                $ttl    = $end - $curr;
                $unitary_redis  = new App_Model_Unitary_RedisPlanStorage($this->sid);
                $unitary_redis->createRedpackCountdown($ret, $ttl);
            }
        }
    }

    /*
     * 发布夺宝计划
     */
    public function publishPlan($pid) {
        $plan_storage   = new App_Model_Unitary_MysqlPlanStorage($this->sid);
        $plan   = $plan_storage->fetchDetailByPlan($pid);
        $updata = array(
            'up_status'     => self::UNITARY_STATUS_PUBLISH,//已揭晓状态
        );
        $plan_storage->updateById($updata, $pid);
        //发送中奖信息, 真实中奖会员
        if ($plan['up_luck_mid'] > 0) {
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $member         = $member_model->getRowById($plan['up_luck_mid']);

            $ucfg_model     = new App_Model_Unitary_MysqlCfgStorage($this->sid);
            $ucfg           = $ucfg_model->fetchUpdateCfgBySid($this->sid);
            $msg_cfg        = plum_parse_config('plugin', 'message');

            $tpl            = $ucfg && $ucfg['uc_zjtz'] ? $ucfg['uc_zjtz'] : $msg_cfg['unitary']['zjtz']['default'];
            $msg            = array($member['m_nickname'], $this->shop['s_name'], $plan['ug_name'], $plan['up_issue'], date("Y-m-d H:i:s", $plan['up_pub_time']), $plan['up_luck_num']);
            $reg            = $msg_cfg['unitary']['zjtz']['usable'];

            $content        = App_Helper_Tool::messageContentReplace($reg, $msg, $tpl);
            $this->sendUnitaryNotice($member, $content);
        }

    }
    /*
     * 发送一元夺宝通知
     */
    public function sendUnitaryNotice($member, $content) {
        //微信客服形式发送
        if (App_Plugin_Weixin_ClientPlugin::openIDVerify($member['m_openid'])) {
            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid);
            $weixin_client->sendTextMessage($member['m_openid'], $content);
        }

        //短信发送
        if (plum_is_mobile($member['m_mobile'])) {
            $sms_helper = new App_Helper_Sms($this->sid);
            $usable     = $sms_helper->checkUsableSms();
            if ($usable > 0) {
                $quxun_helper   = new App_Plugin_Sms_QuXunPlugin();
                $sms_ret        = $quxun_helper->sendSms($member['m_mobile'], $content);

                if ($sms_ret) {
                    $sms_helper->recordSendSms($member['m_mobile'], $member['m_id'], $content);
                }
            }
        }
    }

    /*
     * 填充夺宝计划
     */
    public function fillPlan($pid) {
        $plan_storage   = new App_Model_Unitary_MysqlPlanStorage($this->sid);
        $plan   = $plan_storage->getRowById($pid);
        //非进行中的夺宝计划,无法操作
        if ($plan['up_status'] != self::UNITARY_STATUS_UNDER) {
            return;
        }
        //无一人参与,不再继续进行
        if ($plan['up_had'] == 0) {
            $updata = array(
                'up_status'     => self::UNITARY_STATUS_OVER,
            );
            $plan_storage->updateById($updata, $pid);
            return;
        }
        //完成时,执行退款操作
        if ($plan['up_last_action'] == 1) {
            $this->refundPlanOrder($pid);

            $updata = array(
                'up_status'     => self::UNITARY_STATUS_OVER,
            );
        } else {//完成时,执行自动完成操作
            //获取全站最新50条参与记录，可小于50
            $record_storage = new App_Model_Unitary_MysqlRecordStorage($this->sid);

            $where  = array();
            $index  = 0;
            $count  = 50;
            $sort   = array('ur_id' => 'DESC');
            $record     = $record_storage->getList($where, $index, $count, $sort);

            if (!$record) {
                return;
            }
            $max = $record[0]['ur_id'];

            $sum = 0;
            foreach ($record as $val) {
                $join_time  = $val['ur_join_time'];
                $tmp    = intval(date('G', $join_time)) * 10000000;
                $tmp    = $tmp+intval(date('i', $join_time)) * 100000;
                $tmp    = $tmp+intval(date('s', $join_time)) * 1000;
                $tmp    = $tmp+round($val['ur_join_microtime'], 3) * 1000;
                $sum    = $sum+$tmp;
            }
            //获取重庆时时彩数据
            $url    = 'http://f.apiplus.cn/cqssc-1.json';
            $json   = Libs_Http_Client::get($url);
            if (!$json) {
                return;
            }
            $json   = json_decode($json, true);
            $expect     = $json['data'][0]['expect'];
            $lattery    = intval(str_replace(',', '', $json['data'][0]['opencode']));
            $sum--;
            //计算幸运号码,直到获取不到
            do {
                $sum++;
                //计算幸运号码
                $remain = ($sum+$lattery)%intval($plan['up_total']);
                $lucky  = self::UNITARY_PLAN_BASE+$remain;
                //获取中奖信息
                $list_storage   = new App_Model_Unitary_MysqlListStorage($this->sid);
                $reward = $list_storage->fetchRecordByPidNum($pid, $lucky);
            } while ($reward);

            //保存数据
            $updata = array(
                'up_last_joinid'    => $max,
                'up_num_a'          => $sum,
                'up_lottery_expect' => $expect,
                'up_num_b'          => $lattery,
                'up_luck_num'       => $lucky,
                'up_luck_mid'       => -1,
                'up_luck_rid'       => -1,
                'up_status'         => self::UNITARY_STATUS_PUBLISH,
            );
        }
        $plan_storage->updateById($updata, $pid);
        //自动开启下一期
        $this->autoOpenPlan($pid);
    }
    /*
     * 夺宝计划订单批量退款
     * @param int $pid 夺宝计划ID
     */
    public function refundPlanOrder($pid) {
        $plan_storage   = new App_Model_Unitary_MysqlPlanStorage($this->sid);
        $plan   = $plan_storage->fetchDetailByPlan($pid);
        //获取参与记录列表
        $record_model   = new App_Model_Unitary_MysqlRecordStorage($this->sid);
        $type   = 1;//夺宝计划

        $index  = -20;
        $count  = 20;
        $order_model    = new App_Model_Unitary_MysqlOrderStorage($this->sid);
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        $ucfg_model     = new App_Model_Unitary_MysqlCfgStorage($this->sid);
        $ucfg           = $ucfg_model->fetchUpdateCfgBySid($this->sid);
        $msg_cfg        = plum_parse_config('plugin', 'message');

        $tpl            = $ucfg && $ucfg['uc_tktz'] ? $ucfg['uc_tktz'] : $msg_cfg['unitary']['tktz']['default'];
        $reg            = $msg_cfg['unitary']['tktz']['usable'];
        do {
            $index  += $count;
            $list   = $record_model->fetchListByPid($pid, $type, $index, $count);

            foreach ($list as $item) {
                //退款处理
                $updata = array(
                    'uo_status'     => 4,//退款
                    'uo_refund_time'=> time(),
                );
                $order_model->updateById($updata, $item['uo_id']);
                //增加用户金币值
                $member_model->incrementMemberGoldcoin($item['uo_m_id'], floatval($item['uo_amount']));

                $member     = $member_model->getRowById($item['ur_m_id']);
                $msg            = array($member['m_nickname'], $this->shop['s_name'], $plan['ug_name'], $plan['up_issue']);

                $content        = App_Helper_Tool::messageContentReplace($reg, $msg, $tpl);
                $this->sendUnitaryNotice($member, $content);
            }
        } while (count($list) == $count);

        //清除夺宝号码序列
        $plan_redis = new App_Model_Unitary_RedisPlanStorage($this->sid);
        $plan_redis->removePlanSeq($pid);
        //移除自动完成倒计时
        $plan_redis->removePlanAutoFill($pid);
    }
    /**
     * 测试--终止红包
     */
    public function refundRedOrderAction($pid) {
        $plan_storage   = new App_Model_Unitary_MysqlRedpackStorage($this->sid);
        $plan   = $plan_storage->fetchRedpack($pid);
        //获取参与记录列表
        $record_model   = new App_Model_Unitary_MysqlRecordStorage($this->sid);
        $type   = 2;//夺宝计划

        $index  = -20;
        $count  = 20;
        $order_model    = new App_Model_Unitary_MysqlOrderStorage($this->sid);
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        $ucfg_model     = new App_Model_Unitary_MysqlCfgStorage($this->sid);
        $ucfg           = $ucfg_model->fetchUpdateCfgBySid($this->sid);
        $msg_cfg        = plum_parse_config('plugin', 'message');

        $tpl            = $ucfg && $ucfg['uc_tktz'] ? $ucfg['uc_tktz'] : $msg_cfg['unitary']['tktz']['default'];
        $reg            = $msg_cfg['unitary']['tktz']['usable'];
        do {
            $index  += $count;
            $list   = $record_model->fetchListByPid($pid, $type, $index, $count);

            foreach ($list as $item) {
                //退款处理
                $updata = array(
                    'uo_status'     => 4,//退款
                    'uo_refund_time'=> time(),
                );
                $order_model->updateById($updata, $item['uo_id']);
                //增加用户金币值
                $member_model->incrementMemberGoldcoin($item['uo_m_id'], floatval($item['uo_amount']));

                $member     = $member_model->getRowById($item['ur_m_id']);
                $msg            = array($member['m_nickname'],$this->shop['s_name'], $plan['ur_name'], $plan['ur_issue']);

                $content        = App_Helper_Tool::messageContentReplace($reg, $msg, $tpl);
                $this->sendUnitaryNotice($member, $content);
            }
        } while (count($list) == $count);
        //清除夺宝号码序列
        $plan_redis = new App_Model_Unitary_RedisPlanStorage($this->sid);
        //移除定时红包的计算倒计时
        $plan_redis->removeCreateRedpackCountdown($pid);
        //移除倒计时
        $plan_redis->removeRedpackCountdown($pid);
    }
}