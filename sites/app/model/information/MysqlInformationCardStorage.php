<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Information_MysqlInformationCardStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_information_card';
        $this->_pk 		= 'aic_id';
        $this->_shopId 	= 'aic_s_id';
        $this->_df 	    = 'aic_deleted';

        parent::__construct();
        $this->sid = $sid;
    }

    /*
     * 根据店铺id和主键id获取会员卡信息
     */
    public function fetchRowById($id,$data=null){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function fetchListBySid(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where,0,0,array('aic_create_time'=>'ASC'));
    }



}