<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/7/1
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletVideoStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_video';
        $this->_pk      = 'av_id';
        $this->_shopId  = 'av_s_id';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }


    /*
     * 获取开启
     */
    public function fetchShopVideo($data = null,$isopen=true) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($isopen){
            $where[]    = array('name' => 'av_is_open', 'oper' => '=', 'value' => 1);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}