<?php

class App_Model_Legwork_MysqlLegworkTradeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $address_table;
    private $member_table;
    private $rider_table;
//    private $applet_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_trade';
        $this->_pk     = 'alt_id';
        $this->_shopId = 'alt_s_id';
        $this->sid     = $sid;
        $this->_df     = 'alt_deleted';
        $this->address_table    = DB::table('member_address');
        $this->member_table     = DB::table('member');
        $this->rider_table      = DB::table('applet_legwork_rider');
//        $this->applet_table      = DB::table('applet_cfg');
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'alt_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 通过其他订单id和sid获取订单
     */
    public function findUpdateTradeByOtherTid($tid, $sid,$data = null) {
        $where[]    = array('name' => 'alt_other_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'alt_other_sid', 'oper' => '=', 'value' => $sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获取订单列表
     */
    public function getTradeList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select alt.*,addr.ma_name as addrName,addr.ma_phone as addrPhone,addr.ma_province as addrProvince,addr.ma_city as addrCity,addr.ma_zone as addrZone,addr.ma_detail as addrDetail,addr.ma_lng as addrLng,addr.ma_lat as addrLat,termini.ma_name as terminiName,termini.ma_phone as terminiPhone,termini.ma_province as terminiProvince,termini.ma_city as terminiCity,termini.ma_zone as terminiZone,termini.ma_detail as terminiDetail,termini.ma_lng as terminiLng,termini.ma_lat as terminiLat,(alt_basic_price+alt_plus_price+alt_tip_fee+alt_format_price+alt_time_fee+alt_weight_fee+alt_volume_fee) as money ";
        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->address_table." addr on alt.alt_addr_id = addr.ma_id ";
        $sql .= " left join ".$this->address_table." termini on alt.alt_termini_id = termini.ma_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        if($this->sid == 10043){
            Libs_Log_Logger::outputLog($sql,'test.log');
        }
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取订单列表
     * distance为当前坐标距出发点的距离 逻辑为代取和代送用addr，代买由于两个地址保存相反，若是指定地点取termini作为起点，就近购买直接以用户收货位置addr作为起点
     */
    public function getTradeListDistance($lng,$lat,$where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select alt.*,addr.ma_name as addrName,addr.ma_phone as addrPhone,addr.ma_province as addrProvince,addr.ma_city as addrCity,addr.ma_zone as addrZone,addr.ma_detail as addrDetail,addr.ma_lng as addrLng,addr.ma_lat as addrLat,termini.ma_name as terminiName,termini.ma_phone as terminiPhone,termini.ma_province as terminiProvince,termini.ma_city as terminiCity,termini.ma_zone as terminiZone,termini.ma_detail as terminiDetail,termini.ma_lng as terminiLng,termini.ma_lat as terminiLat,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*({$lng}-(case when alt_type = 2 or alt_type = 3 then alt_addr_lng when alt_type = 1 and alt_termini_type = 2 then alt_addr_lng when alt_type = 1 and alt_termini_type != 2 then alt_termini_lng end))/360),2)+COS(PI()*{$lat}/180)* COS((case when alt_type = 2 or alt_type = 3 then alt_addr_lat when alt_type = 1 and alt_termini_type = 2 then alt_addr_lat when alt_type = 1 and alt_termini_type != 2 then alt_termini_lat end)  * PI()/180)*POW(SIN(PI()*({$lat}-(case when alt_type = 2 or alt_type = 3 then alt_addr_lat when alt_type = 1 and alt_termini_type = 2 then alt_addr_lat when alt_type = 1 and alt_termini_type != 2 then alt_termini_lat end) )/360),2)))) distance,(alt_basic_price+alt_plus_price+alt_tip_fee+alt_format_price+alt_time_fee+alt_weight_fee+alt_volume_fee) as money ";
        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->address_table." addr on alt.alt_addr_id = addr.ma_id ";
        $sql .= " left join ".$this->address_table." termini on alt.alt_termini_id = termini.ma_id ";
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
     * 获取订单列表
     */
    public function getTradeMemberList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select alt.*,addr.ma_name as addrName,addr.ma_phone as addrPhone,addr.ma_province as addrProvince,addr.ma_city as addrCity,addr.ma_zone as addrZone,addr.ma_detail as addrDetail,addr.ma_lng as addrLng,addr.ma_lat as addrLat,termini.ma_name as terminiName,termini.ma_phone as terminiPhone,termini.ma_province as terminiProvince,termini.ma_city as terminiCity,termini.ma_zone as terminiZone,termini.ma_detail as terminiDetail,termini.ma_lng as terminiLng,termini.ma_lat as terminiLat,m.m_nickname,alr.alr_name,alr.alr_mobile  ";

        // 跑腿订单评论表关联
        // zhangzc
        // 2019-10-16
        $sql .=',altc_comment , altc_rider_star, altc_goods_star,alt_comment_pics ';

        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->address_table." addr on alt.alt_addr_id = addr.ma_id ";
        $sql .= " left join ".$this->address_table." termini on alt.alt_termini_id = termini.ma_id ";
        $sql .= " left join ".$this->rider_table." alr on alr.alr_id = alt.alt_rider ";
        $sql .= " left join ".$this->member_table." m on m.m_id = alt.alt_m_id ";

        // 跑腿订单评论表关联
        // zhangzc
        // 2019-10-16
        $sql .=" left join  pre_applet_legwork_trade_comment   on altc_tid = alt.alt_id ";

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
     * 获取订单列表
     */
    public function getTradeMemberCount($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->address_table." addr on alt.alt_addr_id = addr.ma_id ";
        $sql .= " left join ".$this->address_table." termini on alt.alt_termini_id = termini.ma_id ";
        $sql .= " left join ".$this->rider_table." alr on alr.alr_id = alt.alt_rider ";
        $sql .= " left join ".$this->member_table." m on m.m_id = alt.alt_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取单条订单
     */
    public function getTradeRow($tid){
        $where[] = array('name' => 'alt_tid', 'oper' => '=', 'value' => $tid);
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select alt.*,addr.ma_name as addrName,addr.ma_phone as addrPhone,addr.ma_province as addrProvince,addr.ma_city as addrCity,addr.ma_zone as addrZone,addr.ma_detail as addrDetail,addr.ma_lng as addrLng,addr.ma_lat as addrLat,termini.ma_name as terminiName,termini.ma_phone as terminiPhone,termini.ma_province as terminiProvince,termini.ma_city as terminiCity,termini.ma_zone as terminiZone,termini.ma_detail as terminiDetail,termini.ma_lng as terminiLng,termini.ma_lat as terminiLat,alr.* ,alc_id,alc_status,alc_remark ";
        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->address_table." addr on alt.alt_addr_id = addr.ma_id ";
        $sql .= " left join ".$this->address_table." termini on alt.alt_termini_id = termini.ma_id ";
        $sql .= " left join ".$this->rider_table." alr on alr.alr_id = alt.alt_rider ";
        $sql .= " LEFT JOIN `pre_applet_legwork_complaint` ON `alt_id`=`alc_t_id` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得有订单的会员信息
     */
    public function tradePostFeeSum($where){
        $sql  = 'SELECT sum(alt_basic_price) as basicPrice,sum(alt_plus_price) as plusPrice,sum(alt_tip_fee) as fee,sum(alt_format_price) as formatPrice,sum(alt_total_fee) as totalPrice,count(alt_id) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取订单统计信息
     */
    public function statOrderStatistic($where){
        $sql  = 'SELECT count(*) total,sum(alt_payment) money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取单条订单
     */
    public function getTradeRowOther($other_tid){
        $where[] = array('name' => 'alt_other_tid', 'oper' => '=', 'value' => $other_tid);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql = "select alt.*,alr.* ";
        $sql .= " from `".DB::table($this->_table)."` alt ";
        $sql .= " left join ".$this->rider_table." alr on alr.alr_id = alt.alt_rider ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}