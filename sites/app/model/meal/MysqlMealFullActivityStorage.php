<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Meal_MysqlMealFullActivityStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_meal_full';
        $this->_pk 		= 'amf_id';
        $this->_shopId 	= 'amf_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * @return array|bool
     * 获取活动列表  仅总店铺
     */
    public function findListBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amf_es_id','oper'=>'=','value'=>0); //不查门店
        $where[] = array('name' => 'amf_deleted','oper'=>'=','value'=>0);

        return $this->getList($where,0,0,array('amf_type' => 'ASC', 'amf_limit' => 'ASC', 'amf_create_time'=>'DESC'));
    }

    /*
     * 获得活动列表 仅门店
     */
    public function findListByEsId($esId = 0) {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amf_deleted','oper'=>'=','value'=>0);

        $where[] = array('name' => 'amf_es_id','oper'=>'=','value'=>$esId);

        return $this->getList($where,0,0,array('amf_type' => 'ASC', 'amf_limit' => 'ASC', 'amf_create_time'=>'DESC'));
    }

    /*
     * 获得活动列表 包括店铺及门店
     */
    public function findListWithEsId($esId) {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amf_deleted','oper'=>'=','value'=>0);

        $where[] = array('name' => 'amf_es_id','oper'=>'in','value'=>[0,$esId]);

        return $this->getList($where,0,0,array('amf_type' => 'ASC', 'amf_limit' => 'ASC', 'amf_create_time'=>'DESC'));
    }
}