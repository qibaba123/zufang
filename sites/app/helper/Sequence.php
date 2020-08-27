<?php

class App_Helper_Sequence
{
    /*
     * 店铺ID
     */
    private $sid;
    /*
     * 店铺数据，字段名参考pre_shop
     */
    private $shop;

    private $leader_model;
    private $member_model;
    public function __construct($sid)
    {
        $this->sid = $sid;
        //获取店铺信息
        $shop_storage       = new App_Model_Shop_MysqlShopCoreStorage($sid);
        $this->shop         = $shop_storage->getRowById($sid);
        $this->leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($sid);
        $this->member_model = new App_Model_Member_MysqlMemberCoreStorage();
    }

    /**
     * 处理核销后的社区团购的订单问题（分佣，通知等等）
     * @param  [type]  $trade       [description]
     * @param  [type]  $mid         [description]
     * @param  boolean $sendTpl     [description]
     * @param  integer $managerId   [description]
     * @param  boolean $dealSettled [description]
     * @return [type]               [description]
     */
    public function dealSequenceVerify($trade, $mid, $sendTpl = true, $managerId = 0, $dealSettled = true)
    {
        //清除自动完成状态定
        $trade_helper = new App_Helper_Trade($this->sid);
        if ($dealSettled) {
            $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
            $trade_redis->delTradeFinish($trade['t_tid']);
            $settled_model = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
            $settled       = $settled_model->findSettledByTid($trade['t_tid']);

            if ($dealSettled && $settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                $trade_redis->delTradeSettledTtl($settled['ts_id']);
                $trade_helper->recordSuccessSettled($settled['ts_id']);
            }
        }

        // 分佣计算与写入
        $this->dealSequenceDeduct($trade, $mid, $managerId);

        if ($sendTpl) {
            $this->_save_verify_record($trade, $mid, $sendTpl);
        }

        // 处理邀新订单的完成状态
        $trade_helper->tradeInviteFinishDeal($trade['t_id'], $trade['t_m_id'], $this->sid);
    }
    /**
     * 精简版的处理订单分佣问题
     * zhangzc
     * 2019-11-23
     * @param  [type]  $trade         [description]
     * @param  [type]  $mid           [description]
     * @param  [type]  $managerId     [description]
     * @param  [type]  $nosettled_row [description]
     * @param  boolean $retry         [description]
     * @param  integer $finishTime    [description]
     * @return [type]                 [description]
     */
    public function dealSequenceDeductConfirm($trade, $mid, $managerId, $nosettled_row, $retry = false, $finishTime = 0)
    {
        $this->dealSequenceVerify($trade, $mid, false, $managerId, false);
    }

    /**
     * 新的分佣逻辑，无论如何都要重新对预估的佣金进行重新的计算
     * zhangzc
     * 2019-11-23
     * @param  [type]  $trade      [description]
     * @param  [type]  $mid        [description]
     * @param  [type]  $managerId  [description]
     * @param  boolean $retry      [description]
     * @param  integer $finishTime [description]
     * @return [type]              [description]
     */
    public function dealSequenceDeduct($trade, $mid, $managerId, $retry = false, $finishTime = 0)
    {
        $leaderId = $trade['t_se_leader'];
        $groupId  = $trade['t_se_group'];
        $money    = 0; //获取到的佣金的数额
        // 团长id不存在返回，不在进行分佣
        if (empty($leaderId)) {
            return;
        }
        // 团长相关信息不存在也不进行分佣操作
        $leader = $this->leader_model->getRowById($leaderId);
        if (empty($leader)) {
            return;
        }
        $is_refund    = false;
        $money_deduct = $this->caculate_sequence_deduct_money($leader, $trade);
        $money        = $money_deduct['money'];
        $goods_deduct = $money_deduct['order_deduct'];
//        $is_refund    = $money_deduct['is_refund'];
        // 没分到钱就不走后续的逻辑了
        if (empty($money)) {
            return;
        }
        // 团长推荐分佣的钱是从团长的佣金里面扣的
        $this->sequenceLeaderRecommanderDeduct($trade, $money, $leader, $finishTime, $retry);
        // 自提点的分佣逻辑
        $this->sequenceGoodsStationDeduct($money, $trade, $managerId, $mid, $finishTime,$leader);
          // 团长分佣计算
        $this->sequenceLeaderDeduct($money, $trade, $leader, $groupId, $finishTime, null, null, $is_refund);
        // 所有的分佣都计算完以后最后将分到trade_order 的to_leader_deduct 字段进行保存
        $this->sequenceSetDeductToOrder($money, $trade, $goods_deduct,null);

    }


    public function dealSequenceDeductTest($trade, $mid, $managerId, $retry = false, $finishTime = 0)
    {
        $log = true;
        $leaderId = $trade['t_se_leader'];
        $groupId  = $trade['t_se_group'];
        $money    = 0; //获取到的佣金的数额
        // 团长id不存在返回，不在进行分佣
        if (empty($leaderId)) {
            return;
        }
        // 团长相关信息不存在也不进行分佣操作
        $leader = $this->leader_model->getRowById($leaderId);
        if (empty($leader)) {
            return;
        }
        $is_refund    = false;
        $money_deduct = $this->caculate_sequence_deduct_money($leader, $trade, $log);
        $money        = $money_deduct['money'];
        $goods_deduct = $money_deduct['order_deduct'];
        $is_refund    = $money_deduct['is_refund'];
        // 没分到钱就不走后续的逻辑了
        if (empty($money)) {
            return;
        }
        // 团长分佣计算
        //$this->sequenceLeaderDeductTest($money, $trade, $leader, $groupId, $finishTime, null, null, $is_refund,$log);
    }

    /**
     * 计算社区团购中的订单的佣金，此处的佣金计算需要去掉已经退款的订单的数据
     * @param  [type] $leader [description]
     * @param  [type] $trade  [description]
     * @return [type]         [description]
     */
    private function caculate_sequence_deduct_money($leader, $trade, $log = false)
    {
       // $is_refund = false;
        // 团长默认的佣金金额
        $percent = intval($leader['asl_percent']);
        // 新版本的分佣方式
        if ($trade['t_se_send_time'] > 0) {
            $goods_deduct = [];
            // 获取子订单中的金额以及商品的佣金的比例
            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $orderList   = $order_model->getSequenceGoodsDeductListByTid($trade['t_id']);
            foreach ($orderList as $order) {
                //子订单中如果有「忽略分佣字段」不进行分佣处理，
                //已退款的商品
                $refund_status = intval($order['to_feedback']) + intval($order['to_fd_status']) + intval($order['to_fd_result']);
                if ($order['to_se_ignore_deduct'] == 1 || $refund_status == 7) {
                   // $is_refund = true;
                    continue;
                } else {
                    // 计算每个子订单的真实付款金额
                    $order_fee = $trade['t_total_fee'] * ($order['to_total'] / $trade['t_goods_fee']);
                    // 有无商品分佣,有的话按照商品分佣，没有的话按照团长默认分佣
                    if (!empty($order['asgd_id'])) {
                        // 固定分佣计算
                        // fix:固定分佣乘以商品数量
                        // zhangzc
                        // 2019-12-28
                        if (is_numeric($order['asgd_ratio_fixed'])) {
                            $goods_deduct[$order['to_id']] = round($order['asgd_ratio_fixed'], 2) * $order['to_num'];
                        } else if (is_numeric($order['asgd_1f_ratio'])) {
                            // 比例分佣计算
                            $goods_percent                 = floatval($order['asgd_1f_ratio']) / 100;
                            $goods_percent                 = $goods_percent > 0 ? $goods_percent : 0;
                            $goods_deduct[$order['to_id']] = round(($order_fee * $goods_percent), 2);
                        } else {
                            $goods_deduct[$order['to_id']] = round(($order_fee * ($percent / 100)), 2);
                        }
                    } else {
                        $goods_deduct[$order['to_id']] = round(($order_fee * ($percent / 100)), 2);
                    }
                }
            }
            $money = array_sum($goods_deduct);
        } else {
            //老版本 根据团长分佣比例计算佣金
            $money = round(($trade['t_total_fee'] * ($percent / 100)), 2);
        }
        Libs_Log_Logger::outputLog($money,'zhangzzc.log');
        // 分佣的总金额与分佣平分到子订单中的金额
        return [
            'money'        => $money,
            'order_deduct' => $goods_deduct,
           // 'is_refund'    => $is_refund,
        ];
    }

    /**
     * 分佣完成后将团长得到的佣金写入到子订单记录中去
     * zhangzc
     * 2019-11-15
     * @param  [type] $money        [订单的总佣金]
     * @param  [type] $trade        [订单信息]
     * @param  [type] $goods_deduct [商品]
     * @param  [type] $order_model  [description]
     * @return [type]               [description]
     */
    private function sequenceSetDeductToOrder(&$money, $trade, $goods_deduct, $order_model)
    {
        if ($trade['t_se_send_time'] > 0) {
            $temp_money = array_sum($goods_deduct);
            foreach ($goods_deduct as $gkey => $gval) {
                // 计算出来最终的money 在各个商品中占得比例 然后分钱
                // 因最原始的money被减去了团长推荐与自提点所以 需要按照对应的比例重新计算
                $order_deduct_money = round(($money * $gval / $temp_money), 2) * 100;
                $set                = [
                    'to_leader_deduct' => $order_deduct_money,
                ];
                if (empty($order_model)) {
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                }

                $order_model->updateById($set, $gkey);
            }
        }
    }

    /**
     * 团长推荐奖励佣金处理
     * 团长推荐分佣的钱是从团长的佣金里面扣的
     * create by zhangzc
     * update by zhangzc 2019-11-15 (从函数体内进行了分离)
     * @param  [type] $trade      [订单详情]
     * @param  [type] $money      [佣金金额]
     * @param  [type] $leader     [团长信息]
     * @param  [type] $finishTime [结束时间]
     * @param  [type] $retry      [是否执行重试操作]
     * @return [type]             [description]
     */
    private function sequenceLeaderRecommanderDeduct($trade, &$money, $leader, $finishTime, $retry)
    {
        $money_before = $money;
        $seqcfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->sid);
        $seqcfg       = $seqcfg_model->findUpdateBySid();
        // 判断当前团长是否有推荐人
        $leader_parent = $leader['asl_parent_id']; //团长推荐人
        if ($seqcfg && $seqcfg['asc_leader_recmd_reward'] == 1 && $leader_parent) {
            $leader_recmd_reward_per = 0; //推荐佣金的百分比
            $reward_money            = 0; //推荐奖励的佣金

            $leader_recmd_reward_per = $seqcfg['asc_leader_recmd_reward_percent'];
            $reward_money            = $money * ($leader_recmd_reward_per) / 100;
            // $reward_money               =substr($reward_money,0,stripos($reward_money,'.')+3); //转换一下保存两位小数
            $reward_money = round($reward_money, 2); //分佣方式换成四舍五入
            //重新计算团长的分佣-佣金数量（会减少团长的佣金）若金额小于0.01就直接进行抹除
            $money -= ($reward_money < 0.01 ? 0 : $reward_money);

            // 获取推荐团长的用户id
            $parent_row = $this->leader_model->getRowById($leader_parent);
            // 更新累加推荐人的推荐佣金奖励字段
            DB::$db->cur_link->begin_transaction();

            // 团长推荐人佣金累加
            if ($reward_money >= 0.01) {
                $incre_cmd = $this->leader_model->incrementLeaderRecmdReward($leader_parent, floor($reward_money * 100));
            } else {
                $incre_cmd = 'REWARD LESS THAN 0.01';
            }

            // 如果团长有推荐人添加推荐人的佣金记录
            $reward_model = new App_Model_Sequence_MysqlSequenceRecmdRewardStorage($this->sid);
            $insert_cmd   = $reward_model->insertValue([
                'asrr_s_id'      => $this->sid,
                'asrr_m_id'      => $parent_row ? $parent_row['asl_m_id'] : 0,
                'asrr_leader'    => $leader_parent,
                'asrr_money'     => floor($reward_money * 100),
                'asrr_tid'       => $trade['t_tid'],
                'asrr_status'    => 0,
                'asrr_create_at' => $finishTime ? $finishTime : time(),
            ]);
            // 同步更新推荐人的佣金总额
            // 可提现总额
            if ($reward_money >= 0.01) {
                $reward_money = substr($reward_money, 0, stripos($reward_money, '.') + 3);
                $incre_d      = $this->member_model->incrementMemberDeduct($parent_row['asl_m_id'], $reward_money);
                // 更新返佣总额与销售总额
                $incre_a = $this->member_model->incrementMemberAmount($parent_row['asl_m_id'], 0, $reward_money);
            } else {
                $incre_a = $incre_d = 'REWARD LESS THAN 0.01';
            }

            // 更新未结算的佣金的记录
            $deduct_model = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($this->sid);
            $set          = [
                'asdn_status' => 1,
                'asdn_money'  => $reward_money * 100,
            ];
            $where = [
                ['name' => 'asdn_tid', 'oper' => '=', 'value' => $trade['t_tid']],
                ['name' => 'asdn_type', 'oper' => '=', 'value' => 2],
            ];
            $no_settled_exec = $deduct_model->updateValue($set, $where);
            if ($incre_cmd && $insert_cmd && $incre_d && $incre_a && $no_settled_exec) {
                DB::$db->cur_link->commit();
            } else {
                DB::$db->cur_link->rollback();
                //防止先下单后添加推荐团长的情况下，由于下单时没有产生推荐奖励的未结算的记录所以更新失败事务回滚，但引用的$money已经扣除了推荐奖励而造成的佣金减少
                //dn 2020-02-24
                $money = $money_before;
                // if(!$retry)
                //     $this->dealSequenceDeduct($trade,$mid,$managerId,true);
                // else
                Libs_Log_Logger::outputLog(sprintf("团长推荐奖励佣金ERR-RETRY：
                    订单编号-%s,
                    推荐人-%s,
                    被推荐人%s,
                    金额-%s,
                    佣金记录写入-%s,
                    团长推荐人佣金累加-%s,
                    可提现总额-%s,
                    返佣总额与销售总额-%s",
                    $trade['t_tid'],
                    $leader_parent,
                    $leader['asl_id'],
                    $reward_money,
                    $insert_cmd,
                    $incre_cmd,
                    $incre_d,
                    $incre_a), 'leader_reward.log');
            }
        }
        // 如果团长推荐人分佣失败后执行了重试操作的话只重试团长推荐人的逻辑，后面的逻辑不再执行
        if ($retry) {
            exit();
        }

    }

    /**
     * 社区团购自提点佣金处理
     * 同样也是从团长的佣金里面抠出来的血汗钱
     * update by zhangzc(从主函数中分离出来，并且从团长的佣金中减去了被分佣掉的自提点佣金--团长真可怜)
     * @param  [type] &$money     [description]
     * @param  [type] $trade      [description]
     * @param  [type] $managerId  [description]
     * @param  [type] $mid        [description]
     * @param  [type] $finishTime [description]
     * @return [type]             [description]
     */
    private function sequenceGoodsStationDeduct(&$money, $trade, $managerId, $mid, $finishTime,$leader)
    {
        if ($trade['t_expert_id'] > 0 && ($managerId > 0 || $mid <= 0)) {
            $station_model = new App_Model_Sequence_MysqlSequencePickStationStorage($this->sid);
            $station       = $station_model->getRowById($trade['t_expert_id']);

            // 货物自提点
            if ($station && $station['asps_percent'] > 0 && $station['asps_manager_id'] > 0) {
                //todo 计算分佣
                $station_deduct = $money * (intval($station['asps_percent']) / 100);
                $station_deduct = round($station_deduct, 2); //四舍五入保留两位小数
                $money -= $station_deduct; //从团长的佣金里面再减去自提点的佣金

                $station_res = $station_model->incrementStationDeduct($station['asps_id'], $station_deduct);
                if ($station_res) {
                    $station_record = [
                        'aspsd_s_id'        => $this->sid,
                        'aspsd_manager_id'  => $station['asps_manager_id'],
                        'aspsd_manager_mid' => $station['asps_manager_mid'],
                        'aspsd_leader_id'   => $leader['asl_id'],
                        'aspsd_leader_mid'  => $leader['asl_m_id'],
                        'aspsd_station_id'  => $station['asps_id'],
                        'aspsd_money'       => $station_deduct,
                        'aspsd_percent'     => $station['asps_percent'],
                        'aspsd_create_time' => $finishTime ? $finishTime : time(),
                    ];

                    $record_model = new App_Model_Sequence_MysqlSequencePickStationDeductStorage($this->sid);
                    $record_model->insertValue($station_record);
                }
            }
        }
    }

    /**
     * 社区团购团长分佣
     * update by zhangzc(从主函数中分离出来)
     * 2019-11-15
     * @param  [type] &$money     [description]
     * @param  [type] $trade      [description]
     * @param  [type] $leader     [description]
     * @param  [type] $groupId    [description]
     * @param  [type] $finishTime [description]
     * @param  [type] $nosettled_model [description]
     * @param  [type] $nosettled_row [description]
     * @param  [type] $is_refund  [是否是已退款的订单，用于下面的那个更新待结算订单的事务处理]
     * @return [type]             [description]
     */
    private function sequenceLeaderDeduct(&$money, $trade, $leader, $groupId, $finishTime, $nosettled_model = null, $nosettled_row = null, $is_refund = false)
    {
        $data = array(
            'asd_s_id'        => $this->sid,
            'asd_m_id'        => $leader['asl_m_id'],
            'asd_leader'      => $leader['asl_id'],
            'asd_group'       => $groupId,
            'asd_money'       => $money,
            'asd_create_time' => $finishTime ? $finishTime : time(),
            'asd_tid'         => $trade['t_tid'],
        );
        // 团长从订单中获取到的佣金
        DB::$db->cur_link->begin_transaction();
        $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->sid);
        $res          = $deduct_model->insertValue($data);
        $exec_md      = $this->member_model->incrementMemberDeduct($leader['asl_m_id'], $money);
        $exec_ia      = $this->member_model->incrementMemberAmount($leader['asl_m_id'], 0, $money);
        // 更新未结算的佣金的记录
        $deduct_nosettled_model = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($this->sid);
        $set   = [
            'asdn_status' => 1,
            'asdn_money'  => $money * 100,
        ];
        $where = [
            ['name' => 'asdn_tid', 'oper' => '=', 'value' => $trade['t_tid']],
            ['name' => 'asdn_type', 'oper' => '=', 'value' => 1],
        ];
        // 查询是否存在待结算记录，有的话更新并判断，没有的话不再进行操作
        // zhangzc
        // 2020-02-06
        $has_no_settled  = $deduct_nosettled_model->getRow($where);
        if($has_no_settled){
            $no_settled_exec = $deduct_nosettled_model->updateValue($set, $where);

        }else{
            $no_settled_exec = true;
        }
        
        $commit_exec = $res && $exec_md && $exec_ia && $no_settled_exec;
        if ($commit_exec) {
            DB::$db->cur_link->commit();
        } else {
            DB::$db->cur_link->rollback();
            Libs_Log_Logger::outputLog(sprintf('社区团购团长分佣失败,订单号:%s', $trade['t_tid']), 'leader_reward.log');
        }
    }

    private function sequenceLeaderDeductTest(&$money, $trade, $leader, $groupId, $finishTime, $nosettled_model = null, $nosettled_row = null, $is_refund = false,$log = false)
    {
        $data = array(
            'asd_s_id'        => $this->sid,
            'asd_m_id'        => $leader['asl_m_id'],
            'asd_leader'      => $leader['asl_id'],
            'asd_group'       => $groupId,
            'asd_money'       => $money,
            'asd_create_time' => $finishTime ? $finishTime : time(),
            'asd_tid'         => $trade['t_tid'],
        );
        // 团长从订单中获取到的佣金
        DB::$db->cur_link->begin_transaction();
        $deduct_model = new App_Model_Sequence_MysqlSequenceDeductStorage($this->sid);
        $res          = $deduct_model->insertValue($data);
        if($log){
            Libs_Log_Logger::outputLog('res--'.$res,'ding.log');
        }
        $exec_md      = $this->member_model->incrementMemberDeduct($leader['asl_m_id'], $money);
        if($log){
            Libs_Log_Logger::outputLog('exec_md--'.$exec_md,'ding.log');
        }
        $exec_ia      = $this->member_model->incrementMemberAmount($leader['asl_m_id'], 0, $money);
        if($log){
            Libs_Log_Logger::outputLog('exec_ia--'.$exec_ia,'ding.log');
        }
        // 更新未结算的佣金的记录
        $deduct_nosettled_model = new App_Model_Sequence_MysqlSequenceDeductNosettledStorage($this->sid);
        $set   = [
            'asdn_status' => 1,
            'asdn_money'  => $money * 100,
        ];
        $where = [
            ['name' => 'asdn_tid', 'oper' => '=', 'value' => $trade['t_tid']],
            ['name' => 'asdn_type', 'oper' => '=', 'value' => 1],
        ];
        // 已退过款的就不更新未分佣的记录了，因为在退款的时候已经被删掉了
        // zhangzc
        // 2019-12-13
        if ($is_refund) {
            $no_settled_exec = true;
            if($log){
                Libs_Log_Logger::outputLog('is_refund--true','ding.log');
            }
        } else {
            $no_settled_exec = $deduct_nosettled_model->updateValue($set, $where);
            if($log){
                Libs_Log_Logger::outputLog('is_refund--false--'.$no_settled_exec,'ding.log');
            }
        }
        $commit_exec = $res && $exec_md && $exec_ia && $no_settled_exec;

        DB::$db->cur_link->rollback();
        if($log){
            Libs_Log_Logger::outputLog(sprintf('commit_exec--%s', $commit_exec), 'ding.log');
        }

//        if ($commit_exec && !$log) {
//            DB::$db->cur_link->commit();
//        } else {
//            DB::$db->cur_link->rollback();
//            if($log){
//                Libs_Log_Logger::outputLog(sprintf('commit_exec--%s', $commit_exec), 'ding.log');
//            }
//        }
    }

    /*
     * 处理合伙人分佣
     */
    private function _deal_manager_deduct($trade)
    {
        $deduct_model = new App_Model_Entershop_MysqlManagerDeductStorage($this->sid);
        $where        = [];
        $where[]      = ['name' => 'emd_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[]      = ['name' => 'emd_tid', 'oper' => '=', 'value' => $trade['t_tid']];
        $list         = $deduct_model->getList($where, 0, 0);
        $ids          = [];
        if ($list) {
            $manager_model = new App_Model_Entershop_MysqlManagerStorage();
            foreach ($list as $val) {
                if ($val['emd_status'] == 1) {
                    $res = $manager_model->incrementManagerField($val['emd_manager'], $val['emd_money'], 'esm_deduct_ktx');
                    if ($res) {
                        $ids[] = $val['emd_id'];
                    }
                }
            }
        }
        if (!empty($ids)) {
            $where   = [];
            $where[] = ['name' => 'emd_id', 'oper' => 'in', 'value' => $ids];
            $deduct_model->updateValue(['emd_status' => 2], $where);
        }
    }

    /*
     * 保存核销记录
     * type 1.会员卡 2.普通订单 3.会议订单 4.转盘抽奖 5.答题获奖 6.社区团购订单
     */
    public function _save_verify_record($trade, $mid, $sendTpl = true)
    {
        if ($trade) {
            $verify_model = new App_Model_Store_MysqlVerifyStorage($this->sid);
            // $where[] = ['name'=>'ov_se_tid','oper'=>'=','value'=>$trade['t_tid']];
            // $row = $verify_model->getRow($where);
            // if($row){
            //     //如果已有核销记录，更新核销时间
            //     $set = [
            //         'ov_record_time' => time(),
            //         'ov_se_mid' => $mid
            //     ];
            //     $verify_model->updateById($set,$row['ov_id']);
            // }else{

            // }
            $data = array(
                'ov_s_id'        => $this->sid,
                'ov_m_id'        => $trade['t_m_id'],
                'ov_st_id'       => 0,
                'ov_value'       => $trade['t_pickup_code'],
                'ov_type'        => 6,
                'ov_se_tid'      => $trade['t_tid'],
                'ov_se_mid'      => $mid,
                'ov_record_time' => time(),
            );
            $verify_model->insertValue($data);
            //发送模板消息
            if ($sendTpl) {
                plum_open_backend('templmsg', 'sendSequenceTempl', array('sid' => $this->sid, 'tid' => $trade['t_tid'], 'type' => 'se_trade_verify'));
            }

        }
    }

    /**
     * 替换商品推送模板
     */
    public function replaceGoodsGetTpl($infor, $tpl)
    {
        $tpl = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg = plum_parse_config('message', 'tmplmsg');
        foreach ($infor as $key => $val) {
            $infor[$key] = str_replace("\n", "\\n", $val);
        }
        $tplval = array(
            $infor['title'], $infor['price'], $infor['tid'], $infor['createTime'], $infor['sendTime'], $infor['address'],
        );
        $tplreg = $cfg[37];

        return array(
            preg_replace($tplreg, $tplval, $tpl),
        );
    }

    /**
     * 替换团长申请审核推送模板
     */
    public function replaceLeaderHandleTpl($infor, $tpl)
    {
        $tpl = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
        $cfg = plum_parse_config('message', 'tmplmsg');
        foreach ($infor as $key => $val) {
            $infor[$key] = str_replace("\n", "\\n", $val);
        }
        $tplval = array(
            $infor['name'], $infor['mobile'], $infor['community'], $infor['applyTime'], $infor['handleTime'], $infor['status'], $infor['remark'],
        );
        $tplreg = $cfg[42];

        return array(
            preg_replace($tplreg, $tplval, $tpl),
        );
    }

    /*
     * 商品上架处理
     */
    public function _goods_sale_auto($gid, $type)
    {
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $row         = $goods_model->getRowById($gid);
        if ($row) {
            if ($type == 'up') {
                $goods_model->updateById(['g_is_sale' => 1], $gid);
                App_Helper_OperateLog::saveOperateLog("商品{$row['g_name']}自动上架");
            } elseif ($type == 'down') {
                $goods_model->updateById(['g_is_sale' => 2], $gid);
                App_Helper_OperateLog::saveOperateLog("商品{$row['g_name']}自动下架");
            }
        }
    }

    /*
     * 检查是否为新用户
     */
    public static function checkNewMember($uid, $sid)
    {
        $new_member = 0;
        if ($uid) {
            $where       = [];
            $where[]     = ['name' => 't_s_id', 'oper' => '=', 'value' => $sid];
            $where[]     = ['name' => 't_m_id', 'oper' => '=', 'value' => $uid];
            $where[]     = ['name' => 't_status', 'oper' => 'in', 'value' => [1, 3, 4, 5, 6, 8]];
            $trade_model = new App_Model_Trade_MysqlTradeStorage($sid);
            $row         = $trade_model->getRow($where);
            if ($row) {
                $new_member = 0;
            } else {
                $new_member = 1;
            }
        }
        return $new_member;
    }

    /*
     * 获得营业状态
     */
    public static function getOpenStatus($openTimeStr, $closeTimeStr)
    {
        if (!$openTimeStr || !$closeTimeStr) {
            //未设置完整，视为永远以营业
            $isOpen = 1;
        } else {
            $openTime  = strtotime($openTimeStr);
            $closeTime = strtotime($closeTimeStr);
            $timeNow   = time();
            $isOpen    = 0;
            if ($openTime >= $closeTime) {
                //获得当天0点时间戳
                $timeStep_0 = strtotime(date('Y-m-d', $timeNow));
                //获得当天24点时间戳
                $timeStep_24 = strtotime(date('Y-m-d', $timeNow)) + 86399;
                if (($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime) {
                    $isOpen = 1;
                }
            } else {
                if ($openTime <= $timeNow && $timeNow <= $closeTime) {
                    $isOpen = 1;
                }
            }
        }

        return $isOpen;
    }

}
