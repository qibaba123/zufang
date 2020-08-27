<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletJumpStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_jump';
        $this->_pk      = 'aj_id';
        $this->_shopId  = 'aj_s_id';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * @return array|bool
     * 获取店铺的所有跳转小程序
     */
    public function fetchJumpList(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('aj_sort'=>'DESC','aj_create_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
    }

}