<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Workorder_MysqlWorkOrderStorage extends Libs_Mvc_Model_BaseModel
{
    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $type_table;
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table = 'applet_work_order';
        $this->_pk = 'awo_id';
        $this->_shopId = 'awo_s_id';
        $this->_df     = 'awo_deleted';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->type_table = DB::table('applet_work_order_type');
    }

    public function getOrderListMember($where, $index, $count, $sort){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = 'SELECT awo.*, m.m_avatar, m.m_nickname,awot.awot_id,awot.awot_name';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' awo LEFT JOIN pre_member m on awo.awo_m_id = m.m_id ';
        $sql .= ' LEFT JOIN '.$this->type_table.' awot on awot.awot_id = awo.awo_type_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getOrderListMemberCount($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = 'SELECT count(*)';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' awo LEFT JOIN pre_member m on awo.awo_m_id = m.m_id ';
        $sql .= ' LEFT JOIN '.$this->type_table.' awot on awot.awot_id = awo.awo_type_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取单条帖子信息
     */
    public function getOrderRowMember($id){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'awo_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT awo.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= " from `".DB::table($this->_table)."` awo ";
        $sql .= " left join ".$this->member_table." m on m.m_id = awo.awo_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}