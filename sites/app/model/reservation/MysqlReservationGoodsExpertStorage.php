<?php

class App_Model_Reservation_MysqlReservationGoodsExpertStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $goods_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_reservation_goods_expert';
        $this->_pk = 'arge_id';
        $this->_shopId = 'arge_s_id';
        $this->goods_table = DB::table('goods');
        $this->sid = $sid;
    }

    /*
     * 前端获取店铺可展示的幻灯列表
     */
    public function fetchExpertList($eid,$count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($eid){
            $where[]    = array('name' => 'arge_g_id', 'oper' => '=', 'value' => $eid);
        }


        return $this->getList($where, 0, $count, array('arge_sort' => 'ASC'));
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`arge_id`, `arge_s_id`,  `arge_g_id`, `arge_e_id`, `arge_sort`,   `arge_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    public function fetchExpertGoodsList($where,$index,$count,$sort) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT arge.*,g.* ";
        $sql .= " FROM ".DB::table($this->_table)." arge ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=arge.arge_g_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchGoodsExpertList($where,$index,$count,$sort) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT arge.*,g.* ";
        $sql .= " FROM ".DB::table($this->_table)." arge ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=arge.arge_e_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}