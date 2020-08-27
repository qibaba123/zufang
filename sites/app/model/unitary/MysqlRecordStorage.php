<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/14
 * Time: 下午3:40
 */
class App_Model_Unitary_MysqlRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    private $record_table;
    private $plan_table;
    private $goods_table;
    private $order_table;
    private $redpack_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_record';
        $this->_pk      = 'ur_id';
        $this->sid      = $sid;

        $this->record_table = DB::table($this->_table);
        $this->plan_table   = DB::table('unitary_plan');
        $this->goods_table  = DB::table('unitary_goods');
        $this->order_table  = DB::table('unitary_order');
        $this->redpack_table= DB::table('unitary_redpack');
    }

    /*
     * 通过订单id查找参与记录
     */
    public function findRecordByOid($oid) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_o_id', 'oper' => '=', 'value' => $oid);

        return $this->getRow($where);
    }

    /*
     * 获取会员参与人次及分配的号码
     * 未参与返回false
     */
    public function fetchJoinFreqNum($pid, $mid, $type = App_Helper_UnitaryOrder::UNITARY_PLAN) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ur_p_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'ur_m_id', 'oper' => '=', 'value' => $mid);

        $record = $this->getList($where, 0, 0);
        if (!$record) {
            return false;
        }
        $freq   = 0;
        $receive= 0;
        foreach($record as $one) {
            $freq += intval($one['ur_num']);
            $receive    = intval($one['ur_received']);
        }
        $nums = array();
        switch ($type) {
            case App_Helper_UnitaryOrder::UNITARY_PLAN :
                $list_storage   = new App_Model_Unitary_MysqlListStorage($this->sid);
                $list   = $list_storage->fetchListByPidMid($pid, $mid);
                //遍历获取参与号码
                foreach($list as $item) {
                    $nums[] = $item['ul_number'];
                }
                break;
            case App_Helper_UnitaryOrder::UNITARY_REDPACK :

                break;
        }

        return array(
            'freq'      => $freq,//参与总人次数
            'nums'      => $nums,//分配的随机号码
            'receive'   => $receive,//是否已领取过
        );
    }
    /*
     * 获取夺宝计划的参与记录
     * 需要联接订单表，以获取IP、用户昵称
     */
    public function fetchListByPid($pid, $type, $index = 0, $count = 20) {
        $where[]    = array('name' => 'ur.ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur.ur_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ur.ur_p_type', 'oper' => '=', 'value' => $type);

        $where_sql  = $this->formatWhereSql($where);
        $limit_sql  = $this->formatLimitSql($index, $count);
        $sort_sql   = $this->getSqlSort(array('ur.ur_join_time' => 'DESC'));
        $sql    = "SELECT * FROM {$this->record_table} AS ur INNER JOIN {$this->order_table} AS uo ON ur.ur_o_id=uo.uo_id ".$where_sql.$sort_sql.$limit_sql;

        $list   = DB::fetch_all($sql);

        return $list;
    }

    /*
     * 获取会员的参与记录
     * 获取不同状态下的夺宝计划
     * luck ==1 为会员夺宝成功列表
     * gid 代表商品的id
     */
    public function fetchJoinList($mid, $type, $status = null,$luck=null,$gid=null) {
        $where[]    = array('name' => 'ur.ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur.ur_p_type', 'oper' => '=', 'value' => $type);
        if(isset($luck) && $luck == 1){
            $where[]    = array('name' => 'up.up_luck_mid', 'oper' => '=', 'value' => $mid);
         }
         if(!is_null($gid)){
             $where[]    = array('name' => 'up.up_g_id', 'oper' => '=', 'value' => $gid);
         }else{
             $where[]    = array('name' => 'ur.ur_m_id', 'oper' => '=', 'value' => $mid);
         }
        $where_sql  = $this->formatWhereSql($where);
        $sort = array('ur_join_time'=>'DESC');
        $sort_sql  = $this->getSqlSort($sort);
        $group_sql = "GROUP BY up.up_id";
        $group_rd_sql = "GROUP BY up.ur_id";
        $status_sql = "";
        //夺宝计划类型
        if ($type == 1) {
            if (!is_null($status)) {
                $status_sql = " AND up.up_status={$status}";
            }
            $sql    = "SELECT * ,sum(ur.ur_num) as num FROM {$this->record_table} AS ur JOIN {$this->plan_table} AS up ON ur.ur_p_id=up.up_id {$status_sql} JOIN {$this->goods_table} AS ug ON up.up_g_id=ug.ug_id {$where_sql}{$group_sql}{$sort_sql}";
        //定时红包类型
        } else if ($type == 2) {
            if (!is_null($status)) {
                $status_sql = " AND up.ur_status={$status}";
            }
            $sql    = "SELECT * ,sum(ur.ur_num) as num FROM {$this->record_table} AS ur JOIN {$this->redpack_table} AS up ON ur.ur_p_id=up.ur_id {$status_sql} {$where_sql}{$group_rd_sql} {$sort_sql}";
        }

        $list   = DB::fetch_all($sql);

        return $list;
    }
    /**
     * 获取会员参与记录的总数
     *
     */
    /*public function fetchTotalJoinList($mid, $type, $status = null,$luck=null,$gid=null) {
        $where[]    = array('name' => 'ur.ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur.ur_p_type', 'oper' => '=', 'value' => $type);
        if(isset($luck) && $luck == 1){
            $where[]    = array('name' => 'up.up_luck_mid', 'oper' => '=', 'value' => $mid);
        }
        if(!is_null($gid)){
            $where[]    = array('name' => 'up.up_g_id', 'oper' => '=', 'value' => $gid);
        }else{
            $where[]    = array('name' => 'ur.ur_m_id', 'oper' => '=', 'value' => $mid);
        }
        $where_sql  = $this->formatWhereSql($where);
        $status_sql = "";
        //夺宝计划类型
        if ($type == 1) {
            if (!is_null($status)) {
                $status_sql = " AND up.up_status={$status}";
            }
            $sql    = "SELECT count(*) FROM {$this->record_table} AS ur JOIN {$this->plan_table} AS up ON ur.ur_p_id=up.up_id {$status_sql} JOIN {$this->goods_table} AS ug ON up.up_g_id=ug.ug_id {$where_sql}";
            //定时红包类型
        } else if ($type == 2) {
            if (!is_null($status)) {
                $status_sql = " AND up.ur_status={$status}";
            }
            $sql    = "SELECT count(*) as num FROM {$this->record_table} AS ur JOIN {$this->redpack_table} AS up ON ur.ur_p_id=up.ur_id {$status_sql} {$where_sql}";
        }

        $count   = DB::result_first($sql);

        return $count;
    }*/

    /*
     * 获取红包的参与记录
     */
    public function fetchRedpackList($pid) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ur_p_type', 'oper' => '=', 'value' => App_Helper_UnitaryOrder::UNITARY_REDPACK);

        return $this->getList($where, 0, 0);
    }

    /**
     * @param $id
     * @return array|bool
     * 根据记录ID，获取订单数据
     */
    public function getOrderRowById($id,$field){
        $sql = 'SELECT  ';
        $sql .= $this->getFieldString($field);
        $sql .= ' FROM `'.$this->record_table.'` ur ';
        $sql .= ' LEFT JOIN '.$this->order_table.' uo on uo.uo_id = ur.ur_o_id ';
        $sql .= ' WHERE ur_id = '.intval($id);

        $row  = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function updateOrderExpressById($sets,$where){
        $sql  = 'update '.$this->order_table.' uo ';
        $sql .= ' left join '.$this->record_table.'  ur ON uo_id = ur_o_id ';
        $sql .= ' set ';
        $sql .= $this->formatUpdateField($sets);
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 修改参与记录
     */
    public function updateRecordByMidPid($mid, $pid, $set, $type = App_Helper_UnitaryOrder::UNITARY_REDPACK) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_p_id', 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'ur_p_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'ur_m_id', 'oper' => '=', 'value' => $mid);

        return $this->updateValue($set, $where);
    }
}