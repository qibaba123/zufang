<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityShopApplyStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $applet;//配置表
    private $shop;//店铺表
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table = 'applet_city_shop_apply';
        $this->_pk = 'acs_id';
        $this->_shopId = 'acs_s_id';
        $this->applet  = 'applet_cfg';
        $this->shop    = 'shop';
        $this->sid = $sid;
    }
    /**
     * 获取店铺的申请信息
     */
    public function getApplyList($where,$index,$count,$sort){
        $sql  =  '';
        $sql .= 'SELECT sh.s_name,acs.*';
        $sql .= ' FROM '.DB::table($this->_table).' acs';
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = acs.acs_s_id ";
        $sql .= " left join pre_shop sh on sh.s_id= acs.acs_s_id";
        $sql .= " left join pre_agent_open ao on ao.ao_s_id = acs.acs_s_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql,array(),'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getApplyCount($where){
        $sql  =  '';
        $sql .= 'SELECT count(*)';
        $sql .= ' FROM '.DB::table($this->_table).' acs';
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = acs.acs_id ";
        $sql .= " left join pre_shop sh on sh.s_id= acs.acs_id";
        $sql .= " left join pre_agent_open ao on ao.ao_s_id = acs.acs_s_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
      * 通过店铺id和订单编号获取申请信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 通过店铺id和用户ID获取用户入住信息
    */
    public function findShopByUser($userId) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_m_id', 'oper' => '=', 'value' => $userId);
        return $this->getRow($where);
    }


}