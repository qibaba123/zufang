<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午5:00
 */
class App_Model_Shop_MysqlShopShortcutStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    
    public function __construct($sid){
        $this->_table 	= 'shop_shortcut';
        $this->_pk 		= 'ss_id';
        $this->_shopId 	= 'ss_s_id';
        parent::__construct();
        
        $this->sid  = $sid;
    }

    /*
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchShortcutShowList($tpl_id = 1) {

        $where[]    = array('name' => 'ss_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ss_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('ss_weight' => 'ASC'));
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_name`, `ss_icon`, `ss_link`, `ss_weight`,`ss_article_title`,`ss_deleted`, `ss_create_time`) ';
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

    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_name`, `ss_icon`, `ss_link`,`ss_link_type`, `ss_weight`,`ss_article_title`,`ss_show`,`ss_deleted`, `ss_create_time`) ';
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