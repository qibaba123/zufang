<?php

class App_Model_Legwork_MysqlLegworkGoodsCateStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_goods_cate';
        $this->_pk      = 'algc_id';
//        $this->_df      = 'algc_deleted';
        $this->_shopId  = 'algc_s_id';
        $this->sid      = $sid;
    }

    public function getCateList($index = 0,$count = 0,$type = 0){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'algc_type', 'oper' => '=', 'value' => $type];
        $sort = ['algc_sort'=>'asc'];
        return $this->getList($where,$index,$count,$sort);
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`algc_id`, `algc_s_id`,`algc_name`,`algc_sort`,`algc_type`,`algc_create_time`) ';
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