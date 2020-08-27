<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/1/5
 * Time: 上午9:30
 */
class App_Model_Redpack_MysqlFollowStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_follow';
        $this->_pk      = 'rf_id';
        $this->_shopId  = 'rf_s_id';
        $this->_df      = 'rf_deleted';

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
     * 获取当前正在进行中关注红包活动,第一个,按照创建时间
     */
    public function fetchCurrRunRedpack() {
        $curr       = time();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rf_start_time', 'oper' => '<', 'value' => $curr);
        $where[]    = array('name' => 'rf_end_time', 'oper' => '>', 'value' => $curr);

        $sort   = array('rf_create_time' => 'ASC');
        
        $sql    = "SELECT rf.*,rt.* FROM `{$this->curr_table}` AS rf ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rf.rf_rp_id=rt.rt_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 增加已领取数量
     */
    public function incrementReceive($rfid, $had = 1) {
        $field  = array('rf_had');
        $inc    = array($had);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $rfid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }    
}