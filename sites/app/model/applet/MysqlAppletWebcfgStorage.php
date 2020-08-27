<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletWebcfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_web_cfg';
        $this->_pk = 'awc_id';
        $this->_shopId = 'awc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}