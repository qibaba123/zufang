<?php

class App_Model_Knowpay_MysqlKnowpayRecommendStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_recommend';
        $this->_pk 		= 'akr_id';
        $this->_shopId 	= 'akr_s_id';
        parent::__construct();
        
        $this->sid  = $sid;
    }

    /*
     * 获取店铺可展示的推荐
     */
    public function fetchShowList($tpl_id = 65,$type = 0) {

        $where[]    = array('name' => 'akr_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'akr_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'akr_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('akr_weight' => 'ASC'));
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`akr_id`, `akr_s_id`,`akr_tpl_id`, `akr_type`, `akr_title`, `akr_brief`,`akr_cover`,`akr_link`,`akr_link_detail`, `akr_link_type`,`akr_weight`,`akr_deleted`, `akr_create_time`) ';
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