<?php

class App_Model_Mobile_MysqlMobileShopErrorStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $shop_table;
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_mobile_shop_error';
        $this->_pk     = 'mse_id';
        $this->_shopId = 'mse_s_id';

        $this->sid     = $sid;
        $this->member_table = DB::table('member');
        $this->shop_table = DB::table('applet_mobile_shop_apply');
    }

    /**
     * 获取报错列表
     */
    public function getReportMemberList($where,$index,$count,$sort){
        $sql = "select mse.*,ams.ams_name,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` mse ";
        $sql .= " left join ".$this->member_table." m on m.m_id = mse.mse_m_id ";
        $sql .= " left join ".$this->shop_table." ams on ams.ams_id = mse.mse_ams_id ";

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