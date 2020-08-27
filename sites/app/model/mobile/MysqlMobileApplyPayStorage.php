<?php

class App_Model_Mobile_MysqlMobileApplyPayStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_mobile_shop_pay';
        $this->_pk     = 'msp_id';
        $this->_shopId = 'msp_s_id';

        $this->sid     = $sid;
    }

    /*
      * 通过店铺id和订单编号获取入驻信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'msp_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getMoneyCount($where=[]){
        $sql  = ' select sum(msp_money) from pre_applet_mobile_shop_pay ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        return $ret;
    }


    public function getMemberList($where,$index,$count,$sort){
        $sql = 'SELECT msp.*,m.m_nickname,m.m_avatar ';
        $sql .= ' FROM '.DB::table($this->_table).' msp ';
        $sql .= ' LEFT JOIN pre_applet_mobile_shop_apply ams ON msp.msp_ams_id=ams.ams_id';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id=ams.ams_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


}