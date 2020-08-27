<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/1
 * Time: 上午10:39
 */
class App_Model_Mall_MysqlMallIndexStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_mall_index';
        $this->_pk = 'ami_id';
        $this->_shopId = 'ami_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($tpl=15,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ami_tpl_id', 'oper' => '=', 'value' => $tpl);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}