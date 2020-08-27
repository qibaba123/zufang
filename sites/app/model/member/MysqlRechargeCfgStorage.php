<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/19
 * Time: 下午1:49
 */
class App_Model_Member_MysqlRechargeCfgStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'recharge_cfg';
        $this->_pk      = 'rc_id';
        $this->_shopId  = 'rc_s_id';
    }

    /**
     * @param $sid
     * @param array $data
     * @return array|bool
     * 单个店铺信息获取或更新
     */
    public function findRowUpdate($sid,$data=array()){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }


}