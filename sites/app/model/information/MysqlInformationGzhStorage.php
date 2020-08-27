<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Information_MysqlInformationGzhStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_bind_gzh';
        $this->_pk 		= 'abg_id';
        $this->_shopId 	= 'abg_s_id';

        parent::__construct();
        $this->sid = $sid;
    }

    /*
     * 根据店铺id和主键id获取会员卡信息
     */
    public function getRowByWxId($wxno, $data=null){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'abg_wxno', 'oper' => '=', 'value' => $wxno);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}