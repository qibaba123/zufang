<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityApplyCostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_apply_cost';
        $this->_pk = 'cac_id';
        $this->_shopId = 'cac_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('applet_mobile_shop');
        $this->shop_apply_table = DB::table('applet_city_shop_apply');
    }
    /*
    * 通过店铺id和订单编号获取帖子信息
    */
    public function findRowByActid($actid) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'cac_id', 'oper' => '=', 'value' => $actid);
        return $this->getRow($where);

    }
    /**
     * 根据店铺id查询所有的置顶信息
     */
    public function findListBySid() {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where,0,0,array('cac_data'=>'ASC'));
    }

}