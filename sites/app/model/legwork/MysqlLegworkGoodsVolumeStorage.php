<?php

class App_Model_Legwork_MysqlLegworkGoodsVolumeStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_goods_volume';
        $this->_pk      = 'algv_id';
//        $this->_df      = 'algv_deleted';
        $this->_shopId  = 'algv_s_id';
        $this->sid      = $sid;
    }

    public function getVolumeList($index = 0,$count = 0,$type = 0){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'algv_type', 'oper' => '=', 'value' => $type];
        $sort = ['algv_sort'=>'asc'];
        return $this->getList($where,$index,$count,$sort);
    }

    public function getVolumeTradeTypeList($index = 0,$count = 0,$type = 0,$tradeType = 0){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'algv_type', 'oper' => '=', 'value' => $type];
        $where[] = ['name' => 'algv_trade_type', 'oper' => '=', 'value' => $tradeType];
        $sort = ['algv_sort'=>'asc'];
        return $this->getList($where,$index,$count,$sort);
    }


    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`algv_id`, `algv_s_id`,`algv_name`,`algv_sort`,`algv_price`,`algv_type`,`algv_trade_type`,`algv_create_time`) ';
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


}