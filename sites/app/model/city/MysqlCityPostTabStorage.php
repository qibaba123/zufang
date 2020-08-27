<?php

class App_Model_City_MysqlCityPostTabStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    
    public function __construct($sid){
        $this->_table 	= 'applet_city_post_tab';
        $this->_pk 		= 'acpt_id';
        $this->_shopId 	= 'acpt_s_id';
        parent::__construct();
        
        $this->sid  = $sid;
    }

    /*
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchShortcutShowList($tpl_id = 23) {

        $where[]    = array('name' => 'acpt_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acpt_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('acpt_weight' => 'ASC'));
    }



    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acpt_id`, `acpt_s_id`,`acpt_tpl_id`, `acpt_name`, `acpt_icon`, `acpt_link`,`acpt_link_type`, `acpt_weight`,`acpt_show`,`acpt_deleted`, `acpt_create_time`) ';
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