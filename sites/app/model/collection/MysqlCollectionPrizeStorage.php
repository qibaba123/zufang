<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午10:33
 */
class App_Model_Collection_MysqlCollectionPrizeStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_collection_prize';
        $this->_pk      = 'acp_id';
        $this->_shopId  = 'acp_s_id';

        $this->sid      = $sid;
    }

    /**
     * 获取首页配置
     */
    public function findShopCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


}