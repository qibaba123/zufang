<?php
/**
 * 商家岛 活动表
 */
class App_Model_Merchant_MysqlMerchantActivityStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $coupon_table;//优惠券 type = 4
    private $reservation_table;//预约 type = 5
    private $group_table; //拼团 type = 1
    private $limit_table; //秒杀 type = 3
    private $bargain_table;//砍价 type = 2
    public function __construct($sid = 0){
        $this->_table 	= 'merchant_activity';
        $this->_pk 		= 'ma_id';
        $this->_shopId 	= 'ma_s_id';
        $this->_df      = 'ma_deleted';
        parent::__construct();
        $this->sid  = $sid;
        $this->coupon_table = DB::table('merchant_coupon_cfg');
        $this->reservation_table = DB::table('merchant_reservation_cfg');
        $this->group_table = DB::table('merchant_group_cfg');
        $this->limit_table = DB::table('merchant_limit_cfg');
        $this->bargain_table = DB::table('merchant_bargain_cfg');
    }

    /*
     * 获得活动列表 关联活动设置表
     */
    public function getActivityList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." ma ";
        $sql .= " LEFT JOIN ".$this->coupon_table." mcc on ma.ma_id=mcc.mcc_a_id AND ma.ma_type = 4";
        $sql .= " LEFT JOIN ".$this->reservation_table." mrc on ma.ma_id=mrc.mrc_a_id AND ma.ma_type = 5";
        $sql .= " LEFT JOIN ".$this->group_table." mgc on ma.ma_id=mgc.mgc_a_id AND ma.ma_type = 1";
        $sql .= " LEFT JOIN ".$this->limit_table." mlc on ma.ma_id=mlc.mlc_a_id AND ma.ma_type = 3";
        $sql .= " LEFT JOIN ".$this->bargain_table." mbc on ma.ma_id=mbc.mbc_a_id AND ma.ma_type = 2";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得活动详情 关联活动设置表
     */
    public function getActivityRow($id,$time = false){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if($time){
            $where[] = array('name' => 'ma_start', 'oper' => '>=', 'value' => time());
            $where[] = array('name' => 'ma_end', 'oper' => '<=', 'value' => time());
        }
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." ma ";
        $sql .= " LEFT JOIN ".$this->coupon_table." mcc on ma.ma_id=mcc.mcc_a_id AND ma.ma_type = 4";
        $sql .= " LEFT JOIN ".$this->reservation_table." mrc on ma.ma_id=mrc.mrc_a_id AND ma.ma_type = 5";
        $sql .= " LEFT JOIN ".$this->group_table." mgc on ma.ma_id=mgc.mgc_a_id AND ma.ma_type = 1";
        $sql .= " LEFT JOIN ".$this->limit_table." mlc on ma.ma_id= mlc.mlc_a_id AND ma.ma_type = 3";
        $sql .= " LEFT JOIN ".$this->bargain_table." mbc on ma.ma_id=mbc.mbc_a_id AND ma.ma_type = 2";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 不同字段 自增或自减
     */
    public function incrementActivityField($field,$aid,$num) {
        $field  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $aid);
        //$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}