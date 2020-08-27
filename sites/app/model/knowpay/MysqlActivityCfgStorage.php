<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/12/30
 * Time: 上午10:01
 */
class App_Model_Knowpay_MysqlActivityCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_knowpay_activity';
        $this->_pk      = 'aka_id';
        $this->_shopId  = 'aka_s_id';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 配置
     */
    public function fetchUpdateCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


}