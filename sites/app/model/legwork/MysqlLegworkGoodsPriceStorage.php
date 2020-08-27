<?php

class App_Model_Legwork_MysqlLegworkGoodsPriceStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_goods_price';
        $this->_pk      = 'algp_id';
//        $this->_df      = 'algp_deleted';
        $this->_shopId  = 'algp_s_id';
        $this->sid      = $sid;
    }

    public function getPriceList($index = 0,$count = 0,$type = 0){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'algp_type', 'oper' => '=', 'value' => $type];
        $sort = ['algp_sort'=>'asc'];
        return $this->getList($where,$index,$count,$sort);
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`algp_id`, `algp_s_id`,`algp_min`,`algp_max`,`algp_sort`,`algp_flag`,`algp_type`,`algp_create_time`) ';
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