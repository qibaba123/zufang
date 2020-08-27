<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/7/1
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletQiniuVideoStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_qiniu_video';
        $this->_pk      = 'aqv_id';
        $this->_shopId  = 'aqv_s_id';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }


}