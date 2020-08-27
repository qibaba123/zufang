<?php
/*
 * 爆品分销 活动表
 */
class App_Model_Sequence_MysqlSequenceActivityStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $group_table;
    private $trade_table;
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_activity';
        $this->_pk = 'asa_id';
        $this->_shopId = 'asa_s_id';
        $this->_df = 'asa_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->group_table = DB::table('applet_sequence_group');
        $this->trade_table = DB::table('trade');
        $this->member_table = DB::table('member');
    }

    /*
     * 不同字段自增或自减
     */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 批量设置会员金币自增或自减
     */
    public function incrementFieldMulti($field,$ids,$num) {
        $field  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获得活动关联群组的订单
     */
    public function getActivityGroupTradeMemberList($where,$index,$count,$sort){
        $sql  = 'SELECT t.t_id,t.t_se_group,t.t_m_id,m.m_nickname,m.m_avatar,m.m_id ';
        $sql .= ' FROM '.DB::table($this->_table).' asa ';
        $sql .= ' LEFT JOIN '.$this->group_table.' asg on asa.asa_id = asg.asg_a_id';
        $sql .= ' LEFT JOIN '.$this->trade_table.' t on t.t_se_group = asg.asg_id';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = t.t_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY t.t_m_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得活动列表，包含活动状态
     */
    public function getListStatus($where,$index,$count,$sort){
        $where[] = array('name' => 'asa_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT asa.*,';
        //sql判断活动状态
        $sql .= "(case  when asa.asa_start > unix_timestamp() then 2 when asa.asa_end < unix_timestamp() then 1 else 3 end) as status ";
        $sql .= " from `".DB::table($this->_table)."` asa ";
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

    /*
     * 获得活动详情，包含活动状态
     */
    public function getRowStatus($id){
        $where = [];
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asa_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT asa.*,';
        //sql判断活动状态
        $sql .= "(case  when asa.asa_start > unix_timestamp() then 2 when asa.asa_end < unix_timestamp() then 1 else 3 end) as status ";
        $sql .= " from `".DB::table($this->_table)."` asa ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}