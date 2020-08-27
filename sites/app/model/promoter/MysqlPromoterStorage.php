<?php

class App_Model_Promoter_MysqlPromoterStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_promoter';
        $this->_pk     = 'ap_id';
        $this->_shopId = 'ap_s_id';
        $this->_df     = 'ap_deleted';
        $this->sid     = $sid;
    }


    public function findRowByMobile($mobile,$id = 0){

        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'ap_mobile', 'oper' => '=', 'value' => $mobile];
        if($id){
            $where[] = ['name' => $this->_pk, 'oper' => '!=', 'value' => $id];
        }
        return $this->getRow($where);
    }

    public function findRowByCity($city,$type,$id = 0){

        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'ap_city', 'oper' => '=', 'value' => $city];
        $where[] = ['name' => 'ap_level_type', 'oper' => '=', 'value' => $type];
        if($id){
            $where[] = ['name' => $this->_pk, 'oper' => '!=', 'value' => $id];
        }
        return $this->getRow($where);
    }

    /*
    * 不同字段自增或自减
    */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


    public function findRowByMid($mid){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'ap_mid', 'oper' => '=', 'value' => $mid];
        return $this->getRow($where);
    }
}