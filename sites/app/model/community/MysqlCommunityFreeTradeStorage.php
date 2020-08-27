<?php
/**
 * 免费预约订单
 */
class App_Model_Community_MysqlCommunityFreeTradeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $entershop_table;
    private $member_table;
    private $project_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_free_trade';
        $this->_pk = 'acft_id';
        $this->_shopId = 'acft_s_id';
        $this->_df = 'acft_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->entershop_table = DB::table('enter_shop');
        $this->member_table = DB::table('member');
        $this->project_table = DB::table('applet_community_free_project');
    }

    /*
     * 获得订单列表 关联用户表 门店表
     */
    public function getTradeList($where,$index,$count,$sort){
        $sql = "select acft.*,m.m_id,m.m_nickname,m.m_avatar,es.*,acfp.acfp_name ";
        $sql .= " from `".DB::table($this->_table)."` acft ";
        $sql .= " left join ".$this->entershop_table." es on es.es_id = acft.acft_es_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acft.acft_m_id ";
        $sql .= " left join ".$this->project_table." acfp on acfp.acfp_id = acft.acft_g_id ";

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
     * 获得订单数量
     */
    public function getTradeCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` acft ";
        $sql .= " left join ".$this->entershop_table." es on es.es_id = acft.acft_es_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acft.acft_m_id ";
        $sql .= " left join ".$this->project_table." acfp on acfp.acfp_id = acft.acft_g_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得订单 关联用户表 门店表
     */
    public function getTradeRow($where){
        $sql = "select acft.*,m.m_id,m.m_nickname,m.m_avatar,es.*,acfp.acfp_name ";
        $sql .= " from `".DB::table($this->_table)."` acft ";
        $sql .= " left join ".$this->entershop_table." es on es.es_id = acft.acft_es_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acft.acft_m_id ";
        $sql .= " left join ".$this->project_table." acfp on acfp.acfp_id = acft.acft_g_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}