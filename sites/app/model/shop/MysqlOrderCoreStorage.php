<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/24
 * Time: 下午11:01
 */

class App_Model_Shop_MysqlOrderCoreStorage extends Libs_Mvc_Model_BaseModel {
    private $order_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'order';
        $this->_pk      = 'o_id';
        $this->_shopId  = 'o_s_id';

        $this->order_table = DB::table($this->_table);
    }

    /*
     * 获取用户不同订单状态下的返佣总额
     */
    public function fetchStatusDeduct($mid) {
        $deduct = array(
            App_Helper_OrderLevel::ORDER_NO_PAY         => 0.00,
            App_Helper_OrderLevel::ORDER_HAD_PAY        => 0.00,
            App_Helper_OrderLevel::ORDER_HAD_COMPLETE   => 0.00,
            App_Helper_OrderLevel::ORDER_HAD_CLOSED     => 0.00,
        );

        $fields     = array('o_status', 'o_1f_id', 'o_1f_deduct', 'o_2f_id', 'o_2f_deduct', 'o_3f_id', 'o_3f_deduct');
        $where[]    = array('name' => 'o_1f_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'o_2f_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'o_3f_id', 'oper' => '=', 'value' => $mid);
        $sort       = array('o_status' => 'ASC');
        $sql = $this->formatSelectSql($fields, $where, $sort, 0, 0, false);

        $list   = DB::fetch_all($sql);

        if ($list) {
            foreach ($list as $val) {
                for ($i=1; $i<=3; $i++) {
                    $tmp = "{$i}f";
                    if ($val["o_{$tmp}_id"] == $mid) {
                        $deduct[$val['o_status']] += (float)$val["o_{$tmp}_deduct"];
                        break;
                    }
                }
            }
        }
        return $deduct;
    }

    /*
     * 获取返现总额
     */
    public function fetchCashbackTotal($mid) {
        $where[]    = array('name' => 'o_m_id', 'oper' => '=', 'value' => $mid);
        //未付款、已付款、已完成订单的返现参与计算
        $where[]    = array('name' => 'o_status', 'oper' => '<', 'value' => App_Helper_OrderLevel::ORDER_HAD_CLOSED);

        $sql = "SELECT SUM(`o_0f_deduct`) FROM `{$this->order_table}` ".$this->formatWhereSql($where);

        $total = DB::result_first($sql);
        return round(floatval($total), 2);
    }

    /*
     * 获取返现订单记录数，用于分页，区别于返现总额
     */
    public function fetchCashbackCount($mid) {
        $where[]    = array('name' => 'o_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'o_status', 'oper' => '<', 'value' => 4);//待支付、已支付、已完成
        $where[]    = array('name' => 'o_0f_deduct', 'oper' => '>', 'value' => 0.00);

        return $this->getCount($where);
    }

    /*
     * 获取返现订单
     */
    public function fetchCashbackOrder($mid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'o_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'o_status', 'oper' => '<', 'value' => 4);//待支付、已支付、已完成
        $where[]    = array('name' => 'o_0f_deduct', 'oper' => '>', 'value' => 0.00);

        $sort       = array('o_created' => 'DESC');
        $list   = $this->getList($where, $index, $count, $sort);

        return $list;
    }
    /*
     * 通过订单编号查找订单
     */
    public function findOrderByTid($tid) {
        $where[]    = array('name' => 'o_tid', 'oper' => '=', 'value' => $tid);

        $order      = $this->getRow($where);
        return $order;
    }

    /*
     * 获取不同状态的订单数量
     */
    public function fetchDeductTotal($mid, $status) {
        $sql = "SELECT count(*) FROM `{$this->order_table}` WHERE (`o_1f_id`={$mid} OR `o_2f_id`={$mid} OR `o_3f_id`={$mid}) AND `o_status`={$status}";

        $total   = DB::result_first($sql);
        return intval($total);
    }

    /*
     * 获取不同状态的订单列表
     */
    public function fetchDeductList($mid, $status, $index = 0, $count = 20) {
        $limit_sql  = $this->formatLimitSql($index, $count);
        $sql = "SELECT * FROM `{$this->order_table}` WHERE (`o_1f_id`={$mid} OR `o_2f_id`={$mid} OR `o_3f_id`={$mid}) AND `o_status`={$status} ORDER BY UNIX_TIMESTAMP(`o_created`) DESC {$limit_sql}";

        $list   = DB::fetch_all($sql);
        return $list;
    }

    /*
     * 获取店铺最早一条未完成订单记录
     */
    public function fetchAgoOrderBySid($sid, $status = App_Helper_OrderLevel::ORDER_HAD_COMPLETE) {
        $sql    = "SELECT * FROM `{$this->order_table}` WHERE `o_s_id`={$sid} AND `o_status` < {$status} ORDER BY UNIX_TIMESTAMP(`o_update_time`) ASC LIMIT 0,1";

        $row    = DB::fetch_first($sql);

        return $row;
    }

    /**
     * @param $s_id
     * @param int $yesterday
     * @return array|bool
     * 获取某店铺不同状态的订单
     */
    public function statOrderStatus($s_id,$yesterday=0){
        $where = array();
        $where[] = array('name'=>'o_s_id','oper'=>'=','value'=>$s_id);
        $sql  = 'SELECT count(*) total,sum(o_payment) money,o_status ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        if($yesterday){
            $ydEnd   = strtotime(date('Y-m-d',time()));
            $ydStart = $ydEnd-86400;
            $sql .= ' and UNIX_TIMESTAMP(`o_created`) > '.$ydStart;
            $sql .= ' and UNIX_TIMESTAMP(`o_created`) < '.$ydEnd;
        }
        $sql .= ' GROUP BY o_status';
        $ret = DB::fetch_all($sql,array(),'o_status');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}