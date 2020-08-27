<?php

class App_Model_Applet_MysqlAppletSingleIndexImgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_single_index_img';
        $this->_pk 		= 'asii_id';
        $this->_shopId 	= 'asii_s_id';
        parent::__construct();
        $this->sid  = $sid;

    }

    /*
     * 获取店铺可展示的图片列表
     */
    public function fetchImgShowList($tpl_id = 63) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asii_deleted', 'oper' => '=', 'value' => 0);//未删除
        if($tpl_id){
            $where[]    = array('name' => 'asii_tpl_id', 'oper' => '=', 'value' => $tpl_id);
        }
        return $this->getList($where, 0, 30, array('asii_weight' => 'ASC'));
    }

    /**
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asii_id`, `asii_s_id`,`asii_tpl_id`,  `asii_path`, `asii_weight`, `asii_deleted`, `asii_create_time`) ';
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