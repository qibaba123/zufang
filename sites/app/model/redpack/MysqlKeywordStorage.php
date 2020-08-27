<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/1/4
 * Time: 下午2:09
 */
class App_Model_Redpack_MysqlKeywordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_keyword';
        $this->_pk      = 'rk_id';
        $this->_shopId  = 'rk_s_id';
        $this->_df      = 'rk_deleted';

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
     * 获取进行中的活动关键词
     */
    public function fetchRunKeyword() {
        $curr       = time();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rk_start_time', 'oper' => '<', 'value' => $curr);
        $where[]    = array('name' => 'rk_end_time', 'oper' => '>', 'value' => $curr);
        $sort       = array('rk_create_time' => 'ASC');

        return $this->getList($where, 0, 0, $sort, array(), true);
    }
    /*
     * 通过指定的关键词获取红包
     */
    public function findRedpackByKeyword($keyword) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rk_keyword', 'oper' => '=', 'value' => $keyword);

        return $this->getRow($where);
    }
    /*
     * 获取指定的关键词红包
     */
    public function findKeywordRedpack($rkid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $rkid);

        $sql    = "SELECT rk.*,rt.* FROM `{$this->curr_table}` AS rk ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rk.rk_rp_id=rt.rt_id ";
        $sql    .= $this->formatWhereSql($where);

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
    public function incrementReceive($rkid, $had = 1) {
        $field  = array('rk_had');
        $inc    = array($had);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $rkid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}