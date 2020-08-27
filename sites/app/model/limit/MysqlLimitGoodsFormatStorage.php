<?php

class App_Model_Limit_MysqlLimitGoodsFormatStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;
    public function __construct($sid = null){
        $this->_table 	= 'limit_goods_format';
        $this->_pk 		= 'lgf_id';
        $this->_shopId 	= 'lgf_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
    }
    /**
     * @param $value
     * @return bool
     * 批量插入
     */
    public function insertBacth($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`lgf_id`, `lgf_s_id`, `lgf_actid`, `lgf_g_id`, `lgf_gf_id`, `lgf_yh_price`, `lgf_stock`, `lgf_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function deleteListByActidGid($actId, $gid){
        $where = array();
        $where[] = array('name' => 'lgf_actid', 'oper' => '=', 'value' => $actId);
        $where[] = array('name' => 'lgf_g_id', 'oper' => '=', 'value' => $gid);
        return $this->deleteValue($where);
    }

    public function getRowByActIdGfid($actId, $gfId){
        $where = array();
        $where[] = array('name' => 'lgf_actid', 'oper' => '=', 'value' => $actId);
        $where[] = array('name' => 'lgf_gf_id', 'oper' => '=', 'value' => $gfId);
        return $this->getRow($where);
    }

}