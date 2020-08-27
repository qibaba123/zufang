<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Workorder_MysqlWorkorderCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $shop_table;

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_work_order_comment';
        $this->_pk = 'awoc_id';
        $this->_shopId = 'awoc_s_id';

        $this->shop_table = DB::table('shop');
    }

    public function getCommentList($where, $index, $count, $sort){
        $sql = 'SELECT awoc.*, m.m_avatar, m.m_nickname';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' awoc LEFT JOIN pre_member m on awoc.awoc_m_id = m.m_id ';
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

    public function getCommentOrderMemberRow($id){
        $where   = array();
        $where[] = array('name' => 'awoc_id', 'oper' => '=', 'value' => $id);
        $sql = 'SELECT awoc.*, m.m_avatar, m.m_nickname, awo.awo_title,awo.awo_m_id,awo.awo_status ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' awoc LEFT JOIN pre_member m on awoc.awoc_m_id = m.m_id ';
        $sql .= ' LEFT JOIN pre_applet_work_order awo on awoc.awoc_order_id = awo.awo_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}