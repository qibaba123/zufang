<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/6
 * Time: 下午3:37
 */
class App_Helper_Point {

    const POINT_STATUS_RUNNING  = 0;//兑换进行中
    const POINT_STATUS_SUCCESS  = 1;//兑换成功
    const POINT_STATUS_FAILURE  = 2;//兑换失败
    const POINT_STATUS_CREATE   = 4;//兑换创建中

    const POINT_INOUT_INCOME    = 1;//收入
    const POINT_INOUT_OUTPUT    = 2;//支出

    const POINT_SOURCE_TRADE      = 1;//订单来源   //消费
    const POINT_SOURCE_SIGN       = 2;//签到来源
    const POINT_SOURCE_QUEUE      = 3;//公排来源
    const POINT_SOURCE_REFUND     = 4;//退款收回
    const POINT_SOURCE_COIN       = 5;//金币兑换
    const POINT_SOURCE_COMMENT    = 6;//评价 评价帖子，评价订单，评价店铺
    const POINT_SOURCE_COLLECTION = 7;//收藏 ：收藏帖子，店铺，商品，等
    const POINT_SOURCE_SHARE      = 8; //分享 ： 分享文章，店铺等
    const POINT_SOURCE_POST       = 9; //发帖
    const POINT_SOURCE_READ       = 10; //阅读
    const POINT_SOURCE_OPEN_MEMBER = 11; //开通会员
    const POINT_SOURCE_MANAGER    = 12; //管理员操作
    const POINT_SOURCE_PRIZE      = 13; //抽奖
    const POINT_SOURCE_EXCHANGE_PNUM     = 14; //兑换抽奖次数减去积分
    const POINT_SOURCE_EXCHANGE_COUPON   = 15;    //积分兑换优惠券
    const POINT_SOURCE_CASHIER  = 16; //收银台支付
    const POINT_SOURCE_GAMEBOX_TASK  = 17; //游戏盒子完成任务
    const POINT_SOURCE_STUDY  = 18; //知识付费学习课程
    const POINT_SOURCE_EXCHANGE_COIN  = 19; //兑换余额
    const POINT_SOURCE_EXCHANGE_CARD  = 20; //兑换会员卡
    const POINT_SOURCE_POINT_REFUND  = 21; //积分订单退款返还
    const POINT_SOURCE_STEP  = 22; //步数兑换

    const POINT_BACK_RUN        = 0;//积分返还中
    const POINT_BACK_COMPLETE   = 1;//积分返还完成
    const POINT_BACK_BREAK      = 2;//积分返还中断

    private $sid;
    public static $status_note = array(
        self::POINT_STATUS_RUNNING => '兑换进行中',
        self::POINT_STATUS_SUCCESS => '兑换成功',
        self::POINT_STATUS_FAILURE => '兑换失败',
    );

    //积分来源状态描述
    public static $source_status    = array(
        self:: POINT_SOURCE_TRADE      => '购物',
        self:: POINT_SOURCE_SIGN       => '签到',
        self:: POINT_SOURCE_QUEUE      => '公排',
        self:: POINT_SOURCE_REFUND     => '退款收回',
        self:: POINT_SOURCE_COIN       => '金币兑换',
        self:: POINT_SOURCE_COMMENT    => '评价',
        self:: POINT_SOURCE_COLLECTION => '收藏',
        self:: POINT_SOURCE_SHARE      => '分享',
        self:: POINT_SOURCE_POST       => '发帖',
        self:: POINT_SOURCE_READ       => '阅读',
        self:: POINT_SOURCE_OPEN_MEMBER => '开通会员',
        self:: POINT_SOURCE_MANAGER    => '管理员操作',
        //增加积分来源抽奖
        self:: POINT_SOURCE_PRIZE    => '抽奖',
        self:: POINT_SOURCE_EXCHANGE_PNUM    => '兑换抽奖次数',
        self:: POINT_SOURCE_EXCHANGE_COUPON  => '兑换优惠券',
        self:: POINT_SOURCE_EXCHANGE_COIN    => '兑换余额',
        self:: POINT_SOURCE_EXCHANGE_CARD    => '兑换会员卡',
        self:: POINT_SOURCE_POINT_REFUND     => '退款返还'
    );

    public function __construct($sid) {
        $this->sid  = intval($sid);
    }
    /*
     * 会员积分记录
     * @param int $type 增加或减少会员积分
     * @param int $type 1收入,2支出
     */
    public function memberPointRecord($mid, $point, $title, $type, $source = self::POINT_SOURCE_TRADE, $extra = null,$managerId = 0) {
        $point  = abs($point);
        $fee    = $type == self::POINT_INOUT_INCOME ? $point : -$point;
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);
        //会员积分
        App_Helper_MemberLevel::pointTrans($this->sid, $mid, $fee);
        //记录
        $indata = array(
            'pi_s_id'       => $this->sid,
            'pi_m_id'       => $mid,
            'pi_type'       => $type,
            'pi_title'      => $title,
            'pi_point'      => $point,
            'pi_source'     => $source,
            'pi_extra'      => strval($extra),
            'pi_manager_id' => $managerId,
            'pi_create_time'=> time(),
        );
        $inout_model    = new App_Model_Point_MysqlInoutStorage($this->sid);
        $ret = $inout_model->insertValue($indata);
        //积分变更提醒
        plum_open_backend('templmsg', 'pointsChangeTempl', array('sid' => $this->sid, 'id' => $ret, 'before' => $member['m_points']));
        return $ret;
    }
    /*
     * 检查店铺积分商城功能是否开通
     */
    public static function checkPointOpen($sid) {
        //是否开通区域代理功能
        $flag   = App_Helper_PluginIn::checkShopPointOpen($sid);
        if ($flag['code'] == 0) {
            return true;
        }
        return false;
    }
    /*
     * 购买商品返积分
     */
    public function goodsBackPoint($trade) {
        //判断是否已返回,不可重复返还
        $queue_model    = new App_Model_Point_MysqlPointQueueStorage($this->sid);
        $hadnum         = $queue_model->fetchTradeBackNum($trade['t_m_id'], $trade['t_tid']);
        if ($hadnum > 0) {
            return;
        }

        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order_list     = $order_model->getGoodsListByTid($trade['t_id']);
        foreach ($order_list as $item) {
            if ($item['to_gf_id']) {
                $point  = floatval($item['gf_send_point'])*intval($item['to_num']);
            } else {
                $point  = floatval($item['g_send_point'])*intval($item['to_num']);
            }
            //商品单独处理
            if ($point > 0) {
                //返还总期数
                $back_num   = intval($item['g_back_num']);
                if ($back_num > 1) {
                    $division   = round(($point*100)/$back_num)/100;
                    $title  = "购买商品{$item['g_name']},支付成功,共获得积分{$point},分{$back_num}期返还,本期获取积分{$division}";
                } else {
                    $division   = $point;
                    $title  = "购买商品{$item['g_name']},支付成功,共获得积分{$point}";
                }
                //记录积分
                $indata = array(
                    'pq_s_id'   => $this->sid,
                    'pq_m_id'   => $trade['t_m_id'],
                    'pq_g_name' => $item['g_name'],
                    'pq_g_cover'=> $item['g_cover'],
                    'pq_tid'    => $trade['t_tid'],
                    'pq_total_point'    => $point,
                    'pq_back_point'     => $division,//已返还积分
                    'pq_total_num'      => $back_num,
                    'pq_back_num'       => 1,//统一返还时间,第一期先返
                    'pq_last_time'      => time(),
                    'pq_unit'           => $item['g_back_unit'],
                    'pq_status'         => $back_num > 1 ? 0 : 1,//返还状态
                    'pq_create_time'    => time(),
                );
                $queue_model->insertValue($indata);
                $this->memberPointRecord($trade['t_m_id'], $division, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_TRADE, $trade['t_tid']);
            }
        }
    }
    /*
     * 退款退回所获积分
     */
    public function goodsRefundPoint($trade) {
        $queue_model    = new App_Model_Point_MysqlPointQueueStorage($this->sid);
        $queue  = $queue_model->getUpdateListByTid($trade['t_tid']);
        if ($queue) {
            $had    = 0;
            foreach ($queue as $item) {
                if ($item['pq_status'] < self::POINT_BACK_BREAK) {
                    $had    += floatval($item['pq_back_point']);
                }
            }
            if ($had > 0) {
                $queue_model->getUpdateListByTid($trade['t_tid'], array('pq_status' => self::POINT_BACK_BREAK));
                //收回已返积分
                $title  = "由于会员退款,收回已返回的积分{$had}";
                $this->memberPointRecord($trade['t_m_id'], $had, $title, self::POINT_INOUT_OUTPUT, self::POINT_SOURCE_REFUND, $trade['t_tid']);
            }
        }
    }
    /*
     * 已兑换数量调整
     */
    public function goodsExchangeNum($actid, $gid, $num, $add = true, $gfid = 0) {
        $num    = abs($num);
        $num    = $add ? $num : -$num;
        $goods_model    = new App_Model_Point_MysqlGoodsStorage($this->sid);
        $goods_model->incrementExchangeNum($actid, $gid, $num);

        if ($gfid) {
            $format_model   = new App_Model_Point_MysqlGoodsFormatStorage($this->sid);
            $format_model->incrementExchangeNum($actid, $gid, $gfid, $num);
        }
    }
    /*
     * 是否开启积分签到功能
     */
    public static function isOpenSignPoint($sid) {
        //首先判断积分功能是否开通
        $flag   = self::checkPointOpen($sid);
        if ($flag) {
            $cfg_model  = new App_Model_Point_MysqlPointCfgStorage($sid);
            $ptcfg  = $cfg_model->fetchUpdateCfg();

            if ($ptcfg['pc_sign_open']) {
                return true;
            }
        }
        return false;
    }
    /*
     * 会员签到获取积分
     */
    public function signGainPoint($mid) {
        //判断签到功能是否开启
        $flag   = self::isOpenSignPoint($this->sid);
        if (!$flag) {
            return array('errcode' => 1, 'errmsg' => '商家未开启签到功能');
        }
        $sign_model = new App_Model_Point_MysqlPointSignStorage($this->sid);
        $record     = $sign_model->findSignByMid($mid);

        $ptcfg_model    = new App_Model_Point_MysqlPointCfgStorage($this->sid);
        $ptcfg      = $ptcfg_model->fetchUpdateCfg();

        $point  = $ptcfg['pc_sign_init'];
        if ($record) {
            $time_str   = date("Y-m-d", $record['ps_last_signtime']);
            $last_zero  = strtotime($time_str." 00:00:00");
            $hour_24    = 24*60*60;
            $curr_time  = time();
            if (($last_zero+$hour_24) > $curr_time) {
                return array('errcode' => 1, 'errmsg' => '今日已签到,明日再来');
            }
            //是否为连续签到
            $cont   = ($curr_time - $last_zero) < 2*$hour_24 ? true : false;
            $times  = $cont ? intval($record['ps_last_times'])+1 : 0;//连续签到次数
            $gain   = $point + $times*$ptcfg['pc_sign_step'];

            $updata = array(
                'ps_last_signtime'  => $curr_time,
                'ps_last_times'     => $times,
            );
            $sign_model->updateById($updata, $record['ps_id']);
        } else {
            $gain   = $point;
            $indata = array(
                'ps_s_id'       => $this->sid,
                'ps_m_id'       => $mid,
                'ps_last_signtime'  => time(),
                'ps_last_times' => 0,
            );
            $sign_model->insertValue($indata);
        }
        //增加会员积分
        $title  = "签到奖励积分{$gain}";
        $this->memberPointRecord($mid, $gain, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_SIGN);

        return array('errcode' => 0, 'errmsg' => $title);
    }
    /*
     * 进入单轨制公排
     */
    public function intoLineQueue($mid, array $record) {
        $lncfg_model    = new App_Model_Point_MysqlPointLineCfgStorage($this->sid);
        $lncfg  = $lncfg_model->fetchUpdateCfg();
        //开通单轨制公排系统
        if ($lncfg && $lncfg['lc_open']) {
            $appoint_model  = new App_Model_Point_MysqlLineAppointStorage($this->sid);
            $exist  = $appoint_model->fetchExistAppoint($record['pr_actid'], $record['pr_g_id'], $record['pr_gf_id']);
            //兑换指定商品
            if ($exist) {
                $num    = intval($record['pr_num']);
                //获取换算后的积分
                $dispatch       = round(($record['pr_point']/$num)*$lncfg['lc_in_ratio'])/100;
                $lnmem_model    = new App_Model_Point_MysqlPointMemberStorage($this->sid);
                //批量处理,用户同时兑换多次商品
                for ($i = 1; $i<= $num; $i++) {
                    $first  = $lnmem_model->findQueueFirst();
                    if ($first) {
                        $sum    = floatval($first['lm_had'])+$dispatch;
                        //达到出队级别
                        if ($sum >= $lncfg['lc_out_point']) {
                            $updata = array(
                                'lm_status'     => 1,
                                'lm_out_time'   => time(),
                                'lm_had'        => $lncfg['lc_out_point'],//出队获得积分
                            );
                            $lnmem_model->updateById($updata, $first['lm_id']);
                            //换算成佣金
                            $deduct = round($lncfg['lc_out_point']*$lncfg['lc_deduct_ratio'])/100;
                            $title  = "公排系统出队奖励佣金{$deduct}元";
                            $member_helper  = new App_Helper_MemberLevel($first['lm_m_id']);
                            $member_helper->memberDeductRecord($deduct, $title, App_Helper_MemberLevel::DEDUCT_INOUT_INCOME, App_Helper_OrderLevel::DEDUCT_POINT_EXCHANGE);
                            //溢出部分累加到下一位
                            $diff   = $sum - $lncfg['lc_out_point'];
                            if ($diff > 0) {
                                $next   = $lnmem_model->findQueueFirst();
                                $updata = array(
                                    'lm_had'    => floatval($next['lm_had'])+$diff,
                                );
                                $lnmem_model->updateById($updata, $next['lm_id']);
                            }
                        } else {
                            $updata = array(
                                'lm_had'    => $sum,
                            );
                            $lnmem_model->updateById($updata, $first['lm_id']);
                        }
                    }
                    //当前会员加入公排
                    $lnmem_model->insertQueueMember($mid);
                }
            }
        }
    }

    /**
     * 根据用户操作类型获取积分
     */
    public function gainPointByType($mid,$type,$pream){
        // 获取积分配置
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        $pointCfg    = $point_model->findUpdateBySid();
        if($pointCfg){
            switch ($type){
                case self::POINT_SOURCE_TRADE :
                    $this->_get_order_point($pointCfg,$pream);
                    break;
                case self::POINT_SOURCE_SIGN :
                    $this->_get_point_by_sign($mid,$pointCfg);
                    break;

            }
        }

    }

    /**
     * 根据用户操作类型获取积分(小程序使用)
     */
    public function gainPointBySource($mid,$source,$pream=array()){
        // 获取积分配置
        $pointCfg = self::_fetch_shop_point_cfg();
        if($pointCfg){
            switch ($source){
                case self::POINT_SOURCE_TRADE :
                    $ret = self::_applet_get_order_point($pream);
                    break;
                case self::POINT_SOURCE_SIGN :
                    $ret = self::_get_point_by_sign($mid,$pointCfg);
                    break;
                case self::POINT_SOURCE_OPEN_MEMBER :
                    $ret = self::_applet_get_member_point($mid);
                    break;
                case self::POINT_SOURCE_CASHIER :
                    $ret = self::_applet_get_cashier_point($pream);
                    break;
                default :
                    $ret = self::_get_point_by_source($mid,$source, $pream);
            }
            return $ret;
        }

    }

    /*
     * 购买商品下单获得积分
     */
    private function _get_order_point($pointCfg,$trade){
        //判断是否已返回,不可重复返还
        $queue_model    = new App_Model_Point_MysqlPointQueueStorage($this->sid);
        $hadnum         = $queue_model->fetchTradeBackNum($trade['t_m_id'], $trade['t_tid']);
        if ($hadnum > 0) {
            return;
        }
        $point   = floor($trade/$pointCfg['aps_trade']);  //获取所得积分
        $title  = "购买商品{$trade['t_title']},支付成功,共获得积分{$point}";
        $this->memberPointRecord($trade['t_m_id'], $point, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_TRADE);
    }

    /*
     * 购买商品下单获得积分
     */
    private function _applet_get_cashier_point($trade){
        //判断是否已返回,不可重复返还
        $pointCfg = $this->_fetch_shop_point_cfg();
        if($pointCfg && $pointCfg['aps_cashier_pay']>0){
            $point   = floor($trade['cr_money']/$pointCfg['aps_cashier_pay']);  //获取所得积分
            $title  = "收银台支付{$trade['cr_money']}元,共获得积分{$point}";
            //更改订单所获的积分
            $cash_model    = new App_Model_Cash_MysqlRecordStorage($this->sid);
            $update     = array('cr_points'=>$point);
            $cash_model->findUpdateTradeByTid($trade['cr_tid'],$update);
            return $this->memberPointRecord($trade['cr_m_id'], $point, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_TRADE);
        }
    }

    /*
    * 购买商品下单获得积分（小程序使用方法）
    */
    private function _applet_get_order_point($trade){
        //判断是否已返回,不可重复返还
        $pointCfg = $this->_fetch_shop_point_cfg();
        if($pointCfg && $pointCfg['aps_trade']>0){
            $point = 0;
            $point_price = 0;
            $point_count = 0;
            $point_price   = floor($trade['t_total_fee']/$pointCfg['aps_trade']);  //获取所得积分
            $sectionArr = json_decode($pointCfg['aps_trade_count_section'],1);
            $tradeModel = new App_Model_Trade_MysqlTradeStorage();
            if(is_array($sectionArr)){
                //获得当前用户订单数量
                $where = [];
                $where[] = ['name' => 't_s_id', 'oper' => '=', 'value' => $this->sid];
                $where[] = ['name' => 't_m_id', 'oper' => '=', 'value' => $trade['t_m_id']];
                $where[] = ['name' => 't_independent_mall', 'oper' => '=', 'value' => 0];
                $where[] = ['name' => 't_status', 'oper' => '=', 'value' => 6];
                $tradeCount = $tradeModel->getCount($where);
                $tradeCount = intval($tradeCount);
                foreach ($sectionArr as $item){
                    if($tradeCount >= $item['min'] && $tradeCount < $item['max']){
                        $point_count = intval($item['value']);
                        break;
                    }
                }

            }
            $point = $point_count + $point_price;
            $title  = "购买商品{$trade['t_title']},支付成功,共获得积分{$point}";
            //更改订单所获的积分
            $update     = array('t_points'=>$point);
            $tradeModel->updateById($update,$trade['t_id']);
            return $this->memberPointRecord($trade['t_m_id'], $point, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_TRADE);
        }
    }

    /*
    * 购买会员卡下单获得积分（小程序使用方法）
    */
    private function _applet_get_member_point($mid){
        //判断是否已返回,不可重复返还
        $pointCfg = $this->_fetch_shop_point_cfg();
        if($pointCfg && $pointCfg['aps_open_member']>0){
            $point   = $pointCfg['aps_open_member'];  //获取所得积分
            $title  = "开通会员获得{$point}";
            return $this->memberPointRecord($mid, $point, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_OPEN_MEMBER);
        }
    }

    /*
     * 会员签到赠送积分
     */
    private function _get_point_by_sign($mid,$pointCfg){

        $sign_model = new App_Model_Point_MysqlPointSignStorage($this->sid);
        $record     = $sign_model->findSignByMid($mid);

        $point  = $pointCfg['aps_register'];
        if ($record) {
            $time_str   = date("Y-m-d", $record['ps_last_signtime']);
            $last_zero  = strtotime($time_str." 00:00:00");
            $hour_24    = 24*60*60;
            $curr_time  = time();
            if (($last_zero+$hour_24) > $curr_time) {
                return array('errcode' => 1, 'errmsg' => '今日已签到,明日再来');
            }
            //是否为连续签到
            $cont   = ($curr_time - $last_zero) < 2*$hour_24 ? true : false;
            $times  = $cont ? intval($record['ps_last_times'])+1 : 0;//连续签到次数

            $updata = array(
                'ps_last_signtime'  => $curr_time,
                'ps_last_times'     => $times,
            );
            $sign_model->updateById($updata, $record['ps_id']);
        } else {
            $indata = array(
                'ps_s_id'       => $this->sid,
                'ps_m_id'       => $mid,
                'ps_last_signtime'  => time(),
                'ps_last_times' => 0,
            );
            $sign_model->insertValue($indata);
        }
        //增加会员积分
        $title  = "签到奖励{$point}积分";
        $this->memberPointRecord($mid, $point, $title, self::POINT_INOUT_INCOME, self::POINT_SOURCE_SIGN);
        return array('errcode' => 0,'point'=>$point, 'errmsg' => $title);
    }

    /*
     * 会员评价帖子，评价订单，评价店铺获得积分
     */
    private function _get_point_by_source($mid,$source, $pream=array()){
        $flag = false;
        $point = 0;
        $title  = "";
        $cfg = $this->_fetch_shop_point_cfg();
        if(!$cfg){
            return array('errcode' => 1, 'errmsg' => '暂未开启积分商城功能');
        }
        //获取会员获取的总积分及评价获得总积分
        $totalPoint = $this->_fetch_member_point($mid,0);  // 获得总积分
        $sourcePoint = $this->_fetch_member_point($mid,$source); //获取评论获取的总积分
        if(($cfg['aps_point_total']>0 && $totalPoint>=$cfg['aps_point_total'])){
            return array('errcode' => 1, 'errmsg' => '今日领取积分已达上限，明日再来领取吧');
        }
        switch ($source){
            case self::POINT_SOURCE_COMMENT :
                if($cfg['aps_comment_total']>0 && $sourcePoint>=$cfg['aps_comment_total']){
                    return array('errcode' => 1, 'errmsg' => '今日评价领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_comment']<1){
                    return array('errcode' => 1, 'errmsg' => '');  //评价无积分赠送
                }else{
                    $flag = true;
                    $point = $cfg['aps_comment'];
                    $title  = "评价奖励{$point}积分";

                }
               break;
            case self::POINT_SOURCE_COLLECTION :
                if($cfg['aps_collection_total']>0 && $sourcePoint>=$cfg['aps_collection_total']){
                    return array('errcode' => 1, 'errmsg' => '今日收藏领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_collection']<1){
                    return array('errcode' => 1, 'errmsg' => '');  //收藏无积分赠送
                }else{
                    $flag = true;
                    $point = $cfg['aps_collection'];
                    $title  = "收藏奖励{$point}积分";
                }
                break;
            case self::POINT_SOURCE_SHARE :
                if($cfg['aps_share_total']>0 && $sourcePoint>=$cfg['aps_share_total']){
                    return array('errcode' => 1, 'errmsg' => '今日分享领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_share']<1){
                    return array('errcode' => 1, 'errmsg' => '');  //分享无积分赠送
                }else{
                    $flag = true;
                    $point = $cfg['aps_share'];
                    $title  = "分享奖励{$point}积分";
                }
                break;
            case self::POINT_SOURCE_POST :
                if($cfg['aps_post_total']>0 && $sourcePoint>=$cfg['aps_post_total']){
                    return array('errcode' => 1, 'errmsg' => '今日发帖领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_post']<1){
                    return array('errcode' => 1, 'errmsg' => '');  //发帖无积分赠送
                }else{
                    $flag   = true;
                    $point  = $cfg['aps_post'];
                    $title  = "发帖奖励{$point}积分";
                }
                break;
            case self::POINT_SOURCE_READ :
                if($cfg['aps_read_article_total']>0 && $sourcePoint>=$cfg['aps_read_article_total']){
                    return array('errcode' => 1, 'errmsg' => '今日阅读领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_read_article']<1){
                    return array('errcode' => 1, 'errmsg' => ''); //阅读无积分赠送
                }else{
                    $flag  = true;
                    $point = $cfg['aps_read_article'];
                    $title = "阅读奖励{$point}积分";
                }
                break;
            case self::POINT_SOURCE_STUDY :
                if($cfg['aps_study_total']>0 && $sourcePoint>=$cfg['aps_study_total']){
                    return array('errcode' => 1, 'errmsg' => '今日阅读领取积分已达上限，明日再来领取吧');
                }elseif ($cfg['aps_study']<1){
                    return array('errcode' => 1, 'errmsg' => ''); //阅读无积分赠送
                }else{
                    $flag  = true;
                    $point = $cfg['aps_study'];
                    $title = "学习课程《{$pream['course']}》获得{$point}积分";
                }
                break;
        }

        if($flag && $point>0){
            //增加会员积分
            $ret = $this->memberPointRecord($mid, $point, $title, self::POINT_INOUT_INCOME, $source);
            return array('errcode' => 0,'point'=>$point, 'errmsg' => '获取积分成功');
        }
    }

    // 获取店铺积分相关配置
    private function _fetch_shop_point_cfg(){
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        return $point_model->findUpdateBySid();
    }

    // 获取会员获取的积分总数及各项积分
    private function _fetch_member_point($mid,$source){
        $point_inout = new App_Model_Point_MysqlInoutStorage($this->sid);
        return $point_inout->getMemberSumPoint($mid,$source);
    }

}
