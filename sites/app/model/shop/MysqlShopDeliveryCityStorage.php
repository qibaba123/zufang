<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Shop_MysqlShopDeliveryCityStorage extends Libs_Mvc_Model_BaseModel {

    private $sid = 0;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_delivery_city';
        $this->_pk      = 'sdc_id';
        $this->sid      = $sid;
    }

    public function fetchCityListByGroup($group, $id , $esId = 0){
        $where[] = array('name' => 'sdc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'sdc_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'sdc_group', 'oper' => '=', 'value' => $group);
        $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' => $id);
        $list = $this->getList($where, 0, 0);
        return $list;
    }


    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`sdc_id`, `sdc_s_id`,`sdc_es_id`,`sdc_temp_id`, `sdc_group`,`sdc_area_id`,`sdc_area_name`,`sdc_area_type`, `sdc_first_num`,`sdc_first_fee`,`sdc_add_num`,`sdc_add_fee`, `sdc_create_time`) ';
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

    public function getCityRow($tid, $pid, $cid=0 , $esId = 0){
        $sql = 'select * ';
        $sql .= 'from `'.DB::table($this->_table).'`';
        $sql .= ' where sdc_s_id = '.$this->sid.' and sdc_temp_id = '.$tid;
        $sql .= ' and (sdc_area_id = '.$pid.' or sdc_area_id = '.$cid.')';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}