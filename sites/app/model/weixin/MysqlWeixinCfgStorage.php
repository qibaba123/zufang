<?php

class App_Model_Weixin_MysqlWeixinCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid = null)
    {
        parent::__construct();
        $this->_table = 'applet_weixin_cfg';
        $this->_pk = 'ac_id';
        $this->_shopId = 'ac_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 获取时间段内的数量
     */
    public function getSaleList($beginToday, $endToday)
    {
        $sql = 'SELECT count(*) total';
        $sql .= ' FROM ' . DB::table($this->_table);

        $sql .= ' WHERE ac_open_time >=' . $beginToday;
        $sql .= ' AND ac_open_time <' . $endToday;
        $sql .= ' AND ac_expire_time > ac_open_time';
        $sql .= ' AND ac_type > 0 ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取店铺配置
     */
    public function findShopCfg($data = null)
    {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * @param $sid
     * @param null $data
     * @return array|bool
     * 用于后台处理逻辑，不固定某个店铺
     */
    public function fetchUpdateCfgBySid($sid, $data = null)
    {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @return array|bool
     * 连店铺表shop查询
     */
    public function getShopList($where, $index, $count, $sort)
    {
        $sql = 'select  ac.*,s_name,s_id,s_unique_id,tc.tc_id,tc.tc_level ';
        $sql .= ' from `' . DB::table($this->_table) . '` ac';
        $sql .= ' left join ' . $this->shop_table . ' s on s_id=' . $this->_shopId . ' ';
        $sql .= ' left join pre_three_cfg tc on tc_s_id=' . $this->_shopId . ' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getShopCount($where)
    {
        $sql = 'select  count(*) ';
        $sql .= ' from `' . DB::table($this->_table) . '` ac';
        $sql .= ' left join ' . $this->shop_table . ' s on s_id=' . $this->_shopId . ' ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopAppletList($where, $index, $count, $sort)
    {
        $sql = 'select  ac.*,s_name,s_contact,s_phone,s_id,s_unique_id,tc.tc_id,tc.tc_level,m.m_mobile,m.m_password,aa.aa_name,trade.* ';
        $sql .= ' from `' . DB::table($this->_table) . '` ac';
        $sql .= ' left join ' . $this->shop_table . ' s on s_id=' . $this->_shopId . ' ';
        $sql .= ' left join pre_three_cfg tc on tc_s_id=' . $this->_shopId . ' ';
        $sql .= ' left join pre_manager m on m.m_c_id=s.s_c_id ';
        $sql .= ' left join pre_agent_open ao on ao.ao_s_id=s.s_id ';
        $sql .= ' left join pre_agent_admin aa on aa.aa_id=ao.ao_a_id ';
        $sql .= ' left join (select t_s_id,sum(t_total_fee) as tradeTotal,count(t_id) as tradeCount from pre_trade where t_status in (3,4,5,6,8) group by t_s_id) as trade on trade.t_s_id = ac.`ac_s_id` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopAppletListMember($where, $index, $count, $sort)
    {
        $sql = 'select  ac.*,s_name,s_contact,s_phone,s_id,s_unique_id,tc.tc_id,tc.tc_level,m.m_mobile,m.m_password,aa.aa_name,trade.*,member.* ';
        $sql .= ' from `' . DB::table($this->_table) . '` ac';
        $sql .= ' left join ' . $this->shop_table . ' s on s_id=' . $this->_shopId . ' ';
        $sql .= ' left join pre_three_cfg tc on tc_s_id=' . $this->_shopId . ' ';
        $sql .= ' left join pre_manager m on m.m_c_id=s.s_c_id ';
        $sql .= ' left join pre_agent_open ao on ao.ao_s_id=s.s_id ';
        $sql .= ' left join pre_agent_admin aa on aa.aa_id=ao.ao_a_id ';
        $sql .= ' left join (select t_s_id,sum(t_total_fee) as tradeTotal,count(t_id) as tradeCount from pre_trade where t_status in (3,4,5,6,8) group by t_s_id) as trade on trade.t_s_id = ac.`ac_s_id` ';
        $sql .= ' left join (select m_s_id,count(m_id) as memberCount from pre_member where m_source = 3 group by m_s_id) as member on member.m_s_id = ac.`ac_s_id` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopAppletCount($where)
    {
        $sql = 'select  count(*) ';
        $sql .= ' from `' . DB::table($this->_table) . '` ac';
        $sql .= ' left join ' . $this->shop_table . ' s on s_id=' . $this->_shopId . ' ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 通过小程序app_id获取微信配置
     */
    public function fetchUpdateWxcfgByAid($aid, $data = null)
    {
        $where[] = array('name' => 'ac_appid', 'oper' => '=', 'value' => $aid);
        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }

    }

    /**
     * @return array
     * 获取各个类型的开通数量
     */

    public function fetchTypeShopCount()
    {
        $sql = 'SELECT COUNT(*) num,ac_type type FROM `pre_applet_cfg` GROUP BY ac_type';
        $ret = DB::fetch_all($sql);
        $data = array();
        if ($ret) {
            foreach ($ret as $val) {
                $data[$val['type']] = $val['num'];
            }
        }
        return $data;
    }

    public function getShopAppletListNoSort($where,$index,$count,$sort){
        $sql = 'select  ac.*,s_name,s_contact,s_phone,s_id,s_unique_id,tc.tc_id,tc.tc_level,m.m_mobile,m.m_password,aa.aa_name ';
        $sql .= ' from `'.DB::table($this->_table).'` ac';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId.' ';
        $sql .= ' left join pre_three_cfg tc on tc_s_id='.$this->_shopId.' ';
        $sql .= ' left join pre_manager m on m.m_c_id=s.s_c_id ';
        $sql .= ' left join pre_agent_open ao on ao.ao_s_id=s.s_id ';
        $sql .= ' left join pre_agent_admin aa on aa.aa_id=ao.ao_a_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取店铺信息及店铺配置
     */
    public function getAppletShopCfg($sid){
        $sql = 'select  ac.*,s.* ';
        $sql .= ' from `'.DB::table($this->_table).'` ac ';
        $sql .= ' left join '.$this->shop_table.' s on s.s_id=ac.ac_s_id ';
        $sql .= '  WHERE '.$this->_shopId .' = '.intval($sid);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}