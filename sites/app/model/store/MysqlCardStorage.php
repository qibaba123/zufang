<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/11/4
 * Time: 下午8:23
 */
class App_Model_Store_MysqlCardStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_level;
    public function __construct($sid){
        $this->_table 	= 'offline_card';
        $this->_pk 		= 'oc_id';
        $this->_shopId 	= 'oc_s_id';
        $this->_df      = 'oc_deleted';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_level = DB::table('member_level');
    }
    /*
     * 获取店铺所有的会员卡
     */
    public function getShopAllCard($type=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($type){
            $where[]    = array('name' => 'oc_type','oper' => '=','value' =>$type);
        }
        $sort   = array('oc_long_type' => 'ASC');

        return $this->getList($where, 0, 50, $sort,array(),true);
    }

    public function getShopOneCard($cardid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cardid);

        return $this->getRow($where);
    }

    /*
     * 获得会员卡列表
     * 关联等级表
     */
    public function getListLevel($where,$index,$count,$sort){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` oc ";
        $sql .= " left join ".$this->member_level." ml on ml.ml_id = oc.oc_identity ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得会员卡列表
     * 关联等级表
     */
    public function getRowLevel($cardid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cardid);
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` oc ";
        $sql .= " left join ".$this->member_level." ml on ml.ml_id = oc.oc_identity ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}