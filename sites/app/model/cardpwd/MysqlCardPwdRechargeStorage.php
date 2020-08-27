<?php
/**
 * 卡密充值 营销插件
 * zhangzc
 * 2019-07-03
 */
class App_Model_Cardpwd_MysqlCardPwdRechargeStorage extends Libs_Mvc_Model_BaseModel{
    private $member_table;
    private $sid;
	public function __construct($sid){
		parent::__construct();
		$this->_table 	= 'applet_cardpwd_recharge';
        $this->_pk 		= 'acr_id';
        $this->_shopId 	= 'acr_s_id';
        $this->sid 		= $sid;
        $this->member_table = 'member';
	}

    /*
     * 获得列表及会员信息
     */
    public function fetchListMember($where,$index,$count,$sort) {
        $sql = 'SELECT acr.*,m.m_id,m.m_nickname,m.m_show_id ';
        $sql .= "FROM ".DB::table($this->_table).' acr ';
        $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on acr.acr_m_id = m.m_id ";
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

}