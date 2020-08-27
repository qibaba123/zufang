<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Train_MysqlTrainCourseIndexStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_train_course_index';
        $this->_pk 		= 'atci_id';
        $this->_shopId 	= 'atci_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 获得当前店铺首页课程分类
     */
    public function fetchCourseIndexShowList($index = 0 , $count = 0 , $tpl_id = 56) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'atci_tpl_id', 'oper' => '=', 'value' => $tpl_id);
        return $this->getList($where, $index, $count, array('atci_weight' => 'ASC'));
    }

    //批量插入微培训首页首页课程分类
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`atci_id`, `atci_s_id`,`atci_tpl_id`,`atci_title`,`atci_link`,`atci_weight`,`atci_create_time`) ';
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