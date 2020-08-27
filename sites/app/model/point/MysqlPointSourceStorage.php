<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 16/12/30
 * Time: 上午10:01
 */
class App_Model_Point_MysqlPointSourceStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_point_source';
        $this->_pk      = 'aps_id';
        $this->_shopId  = 'aps_s_id';
        $this->sid      = $sid;
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