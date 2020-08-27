<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/1/4
 * Time: 下午4:09
 */
class App_Model_Redpack_MysqlQrcodeStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_qrcode';
        $this->_pk      = 'rq_id';
        $this->_shopId  = 'rq_s_id';
        $this->_df      = 'rq_deleted';

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
     * 获取所有正在进行中的二维码红包活动
     */
    public function fetchCurrAllRun() {
        $curr       = time();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rq_start_time', 'oper' => '<', 'value' => $curr);
        $where[]    = array('name' => 'rq_end_time', 'oper' => '>', 'value' => $curr);
        $where[]    = array('name' => 'rq_deleted', 'oper' => '=', 'value' => 0);//未被删除

        $sort   = array('rq_create_time' => 'ASC');

        $sql    = "SELECT rq.*,rt.* FROM `{$this->curr_table}` AS rq ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rq.rq_rp_id=rt.rt_id ";
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
    public function incrementReceive($rqid, $had = 1) {
        $field  = array('rq_had');
        $inc    = array($had);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $rqid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}