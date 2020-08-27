<?php

class App_Model_Group_MysqlGroupGoodsFormatStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;
    public function __construct($sid = null){
        $this->_table 	= 'group_buy_format';
        $this->_pk 		= 'gbf_id';
        $this->_shopId 	= 'gbf_s_id';
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
        $sql .= ' (`gbf_id`, `gbf_s_id`, `gbf_gb_id`, `gbf_g_id`, `gbf_gf_id`, `gbf_price`, `gbf_tz_price`, `gbf_create_time`) ';
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
        $where[] = array('name' => 'gbf_gb_id', 'oper' => '=', 'value' => $actId);
        $where[] = array('name' => 'gbf_g_id', 'oper' => '=', 'value' => $gid);
        return $this->deleteValue($where);
    }

    public function getRowByActIdGfid($actId, $gfId){
        $where = array();
        $where[] = array('name' => 'gbf_gb_id', 'oper' => '=', 'value' => $actId);
        $where[] = array('name' => 'gbf_gf_id', 'oper' => '=', 'value' => $gfId);
        return $this->getRow($where);
    }

}