<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Reservation_MysqlReservationJournalStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_reservation_journal';
        $this->_pk 		= 'arj_id';
        $this->_shopId 	= 'arj_s_id';
        $this->_df      = 'arj_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
* 获取店铺可展示的快捷菜单列表
*/
    public function fetchJournalShowList($tpl_id = 33) {
        $where[]    = array('name' => 'arj_tpl_id', 'oper' => '=', 'value' => $tpl_id); //所属模版，暂定通用
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'arj_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 50, array('arj_weight' => 'ASC'));
    }

    //批量插入微培训首页课程信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`arj_id`, `arj_s_id`,`arj_tpl_id`, `arj_title`,`arj_icon`,`arj_link`,`arj_brief`,`arj_course_title`,`arj_weight`,`arj_deleted`, `arj_create_time`) ';
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