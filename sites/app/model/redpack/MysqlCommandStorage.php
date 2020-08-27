<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/1/4
 * Time: 下午4:09
 */
class App_Model_Redpack_MysqlCommandStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_command';
        $this->_pk      = 'rc_id';
        $this->_shopId  = 'rc_s_id';
        $this->_df      = 'rc_deleted';

        $this->sid      = $sid;
        $this->curr_table = DB::table($this->_table);
        $this->tpl_table    = DB::table('redpack_tpl');
    }

    /*
     * 修改或获取一条数据
     */
    public function getRowUpdate($id,$data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 获取所有正在进行中的口令红包活动
     */
    public function fetchCurrAllRun() {
        $curr       = time();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rc_start_time', 'oper' => '<', 'value' => $curr);
        $where[]    = array('name' => 'rc_end_time', 'oper' => '>', 'value' => $curr);
        $where[]    = array('name' => 'rc_deleted', 'oper' => '=', 'value' => 0);//未被删除

        $sort   = array('rc_create_time' => 'ASC');

        $sql    = "SELECT rc.*,rt.* FROM `{$this->curr_table}` AS rc ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rc.rc_rp_id=rt.rt_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 增加已领取数量
     */
    public function incrementReceive($rcid, $had = 1) {
        $field  = array('rc_had');
        $inc    = array($had);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $rcid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}