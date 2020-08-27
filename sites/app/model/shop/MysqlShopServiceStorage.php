<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午5:00
 */
class App_Model_Shop_MysqlShopServiceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $information_table;
    public function __construct($sid){
        $this->_table 	= 'shop_service';
        $this->_pk 		= 'ss_id';
        $this->_shopId 	= 'ss_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->information_table = 'applet_information';
    }

    /*
     * 获取店铺可展示的快捷菜单列表
     */
    public function fetchServiceShowList($tpl_id = 5, $type = 1, $index = 0, $count = 50) {
        $where[]    = array('name' => 'ss_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ss_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'ss_type', 'oper' => '=', 'value' => $type);//未删除

        return $this->getList($where, $index, $count, array('ss_weight' => 'ASC','ss_create_time'=>'DESC'));
    }

    /*
     * 关联资讯列表
     */
    public function fetchServiceShowListNew($tpl_id = 5, $type = 1, $index = 0, $count = 50) {
        $where[]    = array('name' => 'ss_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ss_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'ss_type', 'oper' => '=', 'value' => $type);//未删除
        $sort = array('ss_weight' => 'ASC','ss_create_time'=>'DESC');

        $sql = "select ss.*,ai.ai_create_time,ai.ai_update_time ";
        $sql .= " from `".DB::table($this->_table)."` ss ";
        $sql .= " left join ".DB::table($this->information_table)." ai on ai.ai_id = ss.ss_link ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

//        return $this->getList($where, $index, $count, $sort);
    }

    public function insertBatchActivity(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_title`,`ss_label`,`ss_brief`,`ss_icon`, `ss_link`,`ss_link_type`,`ss_article_title`,`ss_weight`,`ss_deleted`, `ss_create_time`, `ss_type`) ';
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

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ss_id`, `ss_s_id`,`ss_tpl_id`, `ss_title`,`ss_label`,`ss_brief`,`ss_icon`, `ss_link`,`ss_article_title`,`ss_weight`,`ss_deleted`, `ss_create_time`, `ss_type`) ';
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