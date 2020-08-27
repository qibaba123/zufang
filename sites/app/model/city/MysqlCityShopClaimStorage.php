<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityShopClaimStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop;//店铺表
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table = 'applet_city_shop_claim';
        $this->_pk = 'acsc_id';
        $this->_shopId = 'acsc_s_id';
        $this->shop    = 'shop';
        $this->sid = $sid;
    }

    /*
     * 通过店铺id和用户ID获取用户入住信息
    */
    public function findClaimByMidShop($mid, $acsId=0, $esId=0) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($acsId){
            $where[]    = array('name' => 'acsc_acs_id', 'oper' => '=', 'value' => $acsId);
        }
        if($esId){
            $where[]    = array('name' => 'acsc_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[]    = array('name' => 'acsc_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }

    /**
     * 根据店铺获取认领记录
     */
    public function getClaimListByShop($acsId=0, $esId = 0, $index, $count, $sort){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($acsId){
            $where[]    = array('name' => 'acsc_acs_id', 'oper' => '=', 'value' => $acsId);
        }
        if($esId){
            $where[]    = array('name' => 'acsc_es_id', 'oper' => '=', 'value' => $esId);
        }
        $sql = 'SELECT acsc.*, m.m_nickname, m.m_avatar';
        $sql .= ' FROM '.DB::table($this->_table).' acsc';
        $sql .= " left join pre_member m on acsc.acsc_m_id = m.m_id ";
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

    /**
     * 根据店铺获取认领记录数量
     */
    public function getClaimCountByShop($acsId=0, $esId = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($acsId){
            $where[]    = array('name' => 'acsc_acs_id', 'oper' => '=', 'value' => $acsId);
        }
        if($esId){
            $where[]    = array('name' => 'acsc_es_id', 'oper' => '=', 'value' => $esId);
        }
        return $this->getCount($where);
    }

}