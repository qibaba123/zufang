<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午5:00
 */
class App_Model_Cake_MysqlCakeShortcutStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_cake_shortcut';
        $this->_pk 		= 'acs_id';
        $this->_shopId 	= 'acs_s_id';
        parent::__construct();

        $this->sid  = $sid;
    }

    /*
 * 获取店铺可展示的快捷菜单列表
 */
    public function fetchShortcutShowList($tpl_id = 14) {
        $where[]    = array('name' => 'acs_tpl', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getList($where, 0, 50, array('acs_index' => 'ASC'));
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acs_id`, `acs_s_id`,`acs_name`, `acs_brief`, `acs_tpl`, `acs_imgsrc`, `acs_link`,`acs_link_title`,`acs_index`, `acs_create_time`) ';
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

    /*
     * 新的导航分类
     */
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acs_id`, `acs_s_id`,`acs_name`, `acs_brief`, `acs_tpl`, `acs_imgsrc`, `acs_link`,`acs_link_title`,`acs_link_type`,`acs_index`, `acs_create_time`) ';
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
    /*
     * 微汽车的导航分类（没有链接类型）
     */
    public function carInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acs_id`, `acs_s_id`,`acs_name`, `acs_brief`, `acs_tpl`, `acs_imgsrc`, `acs_link`,`acs_link_title`,`acs_index`, `acs_create_time`) ';
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