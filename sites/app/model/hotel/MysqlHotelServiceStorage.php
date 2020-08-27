<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Hotel_MysqlHotelServiceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_hotel_service';
        $this->_pk 		= 'ahs_id';
        $this->_shopId 	= 'ahs_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * @return array|bool
     * 获取活动列表
     */
    public function findListBySid($id, $type) {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ahs_f_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'ahs_type', 'oper' => '=', 'value' => $type);
        $where[] = array('name' => 'ahs_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0,array('ahs_weight'=>'ASC', 'ahs_create_time'=>'DESC'));
    }


    //批量插入通知公告信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ahs_id`, `ahs_s_id`,`ahs_f_id`,`ahs_type`,`ahs_name`,`ahs_icon`,`ahs_weight`,`ahs_create_time`) ';
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