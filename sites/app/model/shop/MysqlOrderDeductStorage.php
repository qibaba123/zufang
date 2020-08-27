<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/11
 * Time: 下午4:33
 */
class App_Model_Shop_MysqlOrderDeductStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'order_deduct';
        $this->_pk      = 'od_id';
        $this->_shopId  = 'od_s_id';

        $this->sid      = $sid;
    }

    /*
     * 获取或设置佣金分配
     */
    public function findUpdateDeductByTid($tid, $data = null, $gid=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'od_tid', 'oper' => '=', 'value' => $tid);

        if($gid){
            $where[]    = array('name' => 'od_g_id', 'oper' => '=', 'value' => $gid);
        }

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获取订单提成列表
     */
    public function findOrderDeductListByTid($tid, $type = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'od_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);

        return $this->getList($where, 0, 0);
    }

    /*
     * 获取订单提成列表
     */
    public function findOrderDeductListNoTypeByTid($tid, $gid=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'od_tid', 'oper' => '=', 'value' => $tid);
        if($gid){
            $where[]    = array('name' => 'od_g_id', 'oper' => '=', 'value' => $gid);
        }

        return $this->getList($where, 0, 0);
    }



    /**
     * 获取订单的商品及商品信息
     */
    public function getOrderGoodsList($where,$index,$count,$sort, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql = "select od.*,g.g_cover ";
        $sql .= " from `".DB::table($this->_table)."` od  ";
        $sql .=" join pre_goods g on od.o_id = g.g_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getOrderDeductRow($where){
        $sql = "select od.*,g.g_name, m0.m_nickname as m0_nickname, m1.m_nickname as m1_nickname, m2.m_nickname as m2_nickname, m3.m_nickname as m3_nickname ";
        $sql .= " from `".DB::table($this->_table)."` od  ";
        $sql .=" left join pre_goods g on od.od_g_id = g.g_id ";
        $sql .=" left join pre_member m0 on od.od_0f_id = m0.m_id ";
        $sql .=" left join pre_member m1 on od.od_1f_id = m1.m_id ";
        $sql .=" left join pre_member m2 on od.od_2f_id = m2.m_id ";
        $sql .=" left join pre_member m3 on od.od_3f_id = m3.m_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseOrderDeductRow($where){
        $sql = "select od.*,atc_title,g.g_name,g.g_s_id m0.m_nickname as m0_nickname, m1.m_nickname as m1_nickname, m2.m_nickname as m2_nickname, m3.m_nickname as m3_nickname ";
        $sql .= " from `".DB::table($this->_table)."` od  ";
        $sql .=" left join pre_applet_train_course atc on od.od_g_id = atc.atc_id ";
        $sql .=" left join pre_goods g on od.od_g_id = g.g_id ";
        $sql .=" left join pre_member m0 on od.od_0f_id = m0.m_id ";
        $sql .=" left join pre_member m1 on od.od_1f_id = m1.m_id ";
        $sql .=" left join pre_member m2 on od.od_2f_id = m2.m_id ";
        $sql .=" left join pre_member m3 on od.od_3f_id = m3.m_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getOrderDeductList($where,$mid,$index,$count,$sort, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql = "select od.*,g.g_name,acs.acs_name, m.m_nickname, m.m_avatar, cl.cl_name ";
        $sql .= " from `".DB::table($this->_table)."` od  ";
        $sql .=" left join pre_goods g on od.od_g_id = g.g_id ";
        $sql .=" left join pre_member m on od.od_0f_id = m.m_id ";
        $sql .=" left join pre_applet_city_shop_apply acs on od.od_acs_id = acs.acs_id ";
        $sql .=" left join pre_copartner_level cl on od.od_cl_id = cl.cl_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .=" and (od_1f_id = ".$mid." or od_2f_id = ".$mid." or od_3f_id = ".$mid.")";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id获取所有的商品及商品信息
     */
    public function getOrderGoodsMember($where, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT od.*,g_name,g_cover ';
        $sql .='FROM pre_order o
                LEFT JOIN pre_goods g ON g.g_id=o.og_go_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        if(!empty($ret)){
            foreach($ret as $val){
                $data[$val['og_ord_id']][] = $val;
            }
        }
        return $data;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getDeductByMidSid($where, $index, $count, $sort, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT od.*,t.*, td.*, g.* ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';

        $sql .= "LEFT JOIN pre_trade_order td ON t.t_id=td.to_t_id and od.od_g_id=td.to_g_id ";
        $sql .= "LEFT JOIN pre_goods g ON g.g_id=od.od_g_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getDeductCardOrderByMidSid($where, $index, $count, $sort){
        $sql  = 'SELECT od.*,oo.oo_buyer_nick,oo.oo_title,oo.oo_tid,oo.oo_create_time,oo.oo_amount,oo.oo_m_id ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_offline_order oo ON oo.oo_tid=od.od_tid ';

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getDeductCardOrderCountByMidSid($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_offline_order oo ON oo.oo_tid=od.od_tid ';

        $sql .= $this->formatWhereSql($where);
        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getTrainDeductByMidSid($where, $index, $count, $sort, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT od.*,t.*, td.*, atc.* ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';

        $sql .= "LEFT JOIN pre_trade_order td ON t.t_id=td.to_t_id and od.od_g_id=td.to_g_id ";
        $sql .= "LEFT JOIN pre_applet_train_course atc ON atc.atc_id=od.od_g_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getGoodsDeductByMidSid($where, $index, $count, $sort, $type = 0, $mid){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT od.*,t.* ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and ((od_1f_id = '.$mid.' and od_1f_deduct > 0) or (od_0f_id = '.$mid.' and od_0f_deduct > 0))';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据会员id和店铺id获取分销信息
     */
    public function getDeductByMidSidCount($where, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT count(*) as total ';
        $sql .='FROM pre_order_deduct od
                LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function statOrderStatistic($where, $type = 0){
        $where[]    = array('name' => 'od_share_goods', 'oper' => '=', 'value' => $type);
        $sql  = 'SELECT count(*) as total,sum(t_payment) as money ';
        $sql .=' FROM ( SELECT * FROM pre_order_deduct od LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY od.od_tid,t.t_tid ';
        $sql .= ' ) as res ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function statCardOrderStatistic($where){
        $sql  = 'SELECT count(*) as total,sum(oo_amount) as money ';
        $sql .=' FROM ( SELECT * FROM pre_order_deduct od LEFT JOIN pre_offline_order oo ON oo.oo_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY od.od_tid,oo.oo_tid ';
        $sql .= ' ) as res ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 单品分销 收益统计
     */
    public function profitStatisticOld($type, $mid){
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_share_goods', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 't_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET);
        if($type == 'today'){
            $time = strtotime(date('Y-m-d'));
            $where[] = array('name' => 't_finish_time', 'oper' => '>', 'value' => $time);
            $where[] = array('name' => 't_finish_time', 'oper' => '<', 'value' => time());
        }
        $sql  = 'SELECT sum(od_1f_deduct) as 1fTotal, sum(od_0f_deduct) as 0fTotal, od_1f_id, od_0f_id ';
        $sql .=' FROM pre_order_deduct od ';
        $sql .=' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and (od_1f_id = '.$mid.' or od_0f_id = '.$mid.')';

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        if($ret['od_0f_id'] == $mid){
            return $ret['0fTotal']?$ret['0fTotal']:0;
        }
        if($ret['od_1f_id'] == $mid){
            return $ret['1fTotal']?$ret['1fTotal']:0;
        }
        return 0;
    }

    /**
     * 单品分销 收益统计
     */
    public function profitStatistic($type,$mid, $level = 0){
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_share_goods', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 't_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET);
        if($type == 'today'){
            $time = strtotime(date('Y-m-d'));
            $where[] = array('name' => 't_finish_time', 'oper' => '>', 'value' => $time);
            $where[] = array('name' => 't_finish_time', 'oper' => '<', 'value' => time());
        }
        if($level == 0){
            $where[] = array('name' => 'od_0f_id', 'oper' => '=', 'value' => $mid);
            $sql  = 'SELECT sum(od_0f_deduct) as total';
        }else{
            $where[] = array('name' => 'od_1f_id', 'oper' => '=', 'value' => $mid);
            $sql  = 'SELECT sum(od_1f_deduct) as total';
        }

        $sql .=' FROM pre_order_deduct od ';
        $sql .=' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        //$sql .= ' and (od_1f_id = '.$mid.' or od_0f_id = '.$mid.')';

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }

        return $ret ? $ret : 0;
    }

    //获取产生分销的订单数和成交总额
    public function getCountSum($mid, $fid, $level){
        $where[] = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'od_0f_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'od_'.$level.'f_id', 'oper' => '=', 'value' => $fid);

        $sql  = 'SELECT COUNT(*) as num, sum(amount) as total FROM (SELECT sum(od_amount) as amount';
        $sql .=' FROM pre_order_deduct ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY od_tid) as os';

        $ret = DB::fetch_first($sql);

        return $ret;
    }

    //获取待返现的订单总额
    public function delaySum($mid){
        $where[] = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_status','oper'=>'!=','value'=>App_Helper_Trade::TRADE_CLOSED);

        $sql  = 'SELECT *';
        $sql .=' FROM pre_order_deduct od ';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and (od_1f_id = '.$mid.' or od_0f_id = '.$mid.' or od_3f_id = '.$mid.' or od_2f_id = '.$mid.')';

        $ret = DB::fetch_all($sql);
        $delayTotal = 0;
        foreach ($ret as $val){
            if($val['od_0f_id'] == $mid){
                $delayTotal += $val['od_0f_deduct'];
            }
            if($val['od_1f_id'] == $mid){
                $delayTotal += $val['od_1f_deduct'];
            }
            if($val['od_2f_id'] == $mid){
                $delayTotal += $val['od_2f_deduct'];
            }
            if($val['od_3f_id'] == $mid){
                $delayTotal += $val['od_3f_deduct'];
            }
        }

        return $delayTotal;
    }

    //待返现的订单
    public function getDelayBackList($mid, $index, $count){
        $where[] = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'od_0f_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'od_0f_deduct', 'oper' => '>', 'value' => 0);
        $where[] = array('name' => 't_status','oper'=>'>','value'=>App_Helper_Trade::TRADE_NO_PAY);
        $where[] = array('name' => 't_status','oper'=>'!=','value'=>App_Helper_Trade::TRADE_CLOSED);
        $sort = array('od_create_time' => 'desc');

        $sql  = 'SELECT * FROM (SELECT *, SUM(od_0f_deduct) as amount ';
        $sql .= ' FROM pre_order_deduct as od';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY od_tid) as os';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);

        return $ret;
    }

    //分享待返现的订单
    public function getShareDelayBackList($mid, $index, $count){
        $where[] = array('name' => 'od_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'od_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_status','oper'=>'>','value'=>App_Helper_Trade::TRADE_NO_PAY);
        $where[] = array('name' => 't_status','oper'=>'!=','value'=>App_Helper_Trade::TRADE_CLOSED);
        $sort = array('od_create_time' => 'desc');

        $sql  = 'SELECT * FROM (SELECT *, SUM(od_1f_deduct) as amount1, SUM(od_2f_deduct) as amount2, SUM(od_3f_deduct) as amount3 ';
        $sql .= ' FROM pre_order_deduct as od';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and ((od_1f_id = '.$mid.' and od_1f_deduct > 0) or (od_3f_id = '.$mid.' and od_3f_deduct > 0) or (od_2f_id = '.$mid.' and od_2f_deduct > 0))';
        $sql .= ' GROUP BY od_tid) as os';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);

        return $ret;
    }

    /**
     * 获取已返现的订单信息
     */
    public function getBackTradeList($where, $index, $count, $sort){
        $sql  = 'SELECT od_1f_deduct, od_2f_deduct, od_3f_deduct, t_create_time, t_title, od_amount, od_create_time,oo_title,od_type,od_status ';
        $sql .= ' FROM pre_order_deduct as od';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= ' LEFT JOIN pre_offline_order oo ON oo.oo_tid=od.od_tid and od.od_type = 3 ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);

        return $ret;
    }
  
  
  	    /**
     * 获取已返现的订单信息
     */
    public function getBackTradenewList($mid,$where, $index, $count, $sort){
        $sql  = 'SELECT od_1f_deduct, od_2f_deduct, od_3f_deduct, t_create_time, t_title, od_amount, od_create_time,oo_title,od_type,m_nickname,m_1f_id,m_2f_id,m_3f_id,od_status ';
        $sql .= ' FROM pre_order_deduct as od';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=od.od_tid ';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id=od.od_0f_id ';
        $sql .= ' LEFT JOIN pre_offline_order oo ON oo.oo_tid=od.od_tid and od.od_type = 3 ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and (od_1f_id = '.$mid.' or od_3f_id = '.$mid.'  or od_2f_id = '.$mid.' )';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
		  Libs_Log_Logger::outputLog($sql,'sql.log');
        $ret = DB::fetch_all($sql);

        return $ret;
    }

}