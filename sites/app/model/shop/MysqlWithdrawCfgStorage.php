<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/23
 * Time: 上午9:55
 */
class App_Model_Shop_MysqlWithdrawCfgStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct($sid=0) {
        parent::__construct();
        $this->_table = 'withdraw_cfg';
        $this->_shopId='wc_s_id';
        $this->_pk = 'wc_id';
        $this->sid=$sid;
    }

    /*
     * 通过店铺id获取提现配置
     */
    public function findCfgBySid($sid) {
        $where[]    = array('name' => 'wc_s_id', 'oper' => '=', 'value' => $sid);

        $cfg    = $this->getRow($where);
        //获取失败时，返回默认值
        if (!$cfg) {
            $cfg = array(
                'wc_s_id'   => $sid,
                'wc_desc'   => '',
                'wc_min'    => 0
            );
        }
        return $cfg;
    }

    /*
    * 通过店铺id
    */
    public function findUpdateBySid($data=null,$fields='') {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where,$fields);
        }
    }
}