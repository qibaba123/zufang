<?php
/**
 * 商家岛 订单表
 */
class App_Model_Merchant_MysqlMerchantTradeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $activity_table;
    private $reservation_table;//预约 type = 5
    private $group_table; //拼团 type = 1
    private $limit_table; //秒杀 type = 3
    private $bargain_table;//砍价 type = 2
    public function __construct($sid = 0){
        $this->_table 	= 'merchant_trade';
        $this->_pk 		= 'mt_id';
        $this->_shopId 	= 'mt_s_id';
        $this->_df      = 'mt_deleted';
        parent::__construct();
        $this->sid  = $sid;
        $this->activity_table = DB::table('merchant_activity');
        $this->reservation_table = DB::table('merchant_reservation_cfg');
        $this->group_table = DB::table('merchant_group_cfg');
        $this->limit_table = DB::table('merchant_limit_cfg');
        $this->bargain_table = DB::table('merchant_bargain_cfg');
    }

    /*
     * 通过订单号获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'mt_tid', 'oper' => '=', 'value' => $tid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 通过订单号或订单id获得订单 关联活动设置表
     */
    public function getTradeRow($id = 0,$tid = ''){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        if($tid){
            $where[] = array('name' => 'mt_tid', 'oper' => '=', 'value' => $tid);
        }
        if($id){
            $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        }
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." mt ";
        $sql .= " LEFT JOIN ".$this->activity_table." ma on ma.ma_id=mt.mt_a_id ";
        $sql .= " LEFT JOIN ".$this->reservation_table." mrc on mt.mt_a_id=mrc.mrc_a_id AND mt.mt_type = 5";
        $sql .= " LEFT JOIN ".$this->group_table." mgc on mt.mt_a_id=mgc.mgc_a_id AND mt.mt_type = 1";
        $sql .= " LEFT JOIN ".$this->limit_table." mlc on mt.mt_a_id= mlc.mlc_a_id AND mt.mt_type = 3";
        $sql .= " LEFT JOIN ".$this->bargain_table." mbc on mt.mt_a_id=mbc.mbc_a_id AND mt.mt_type = 2";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 通过订单号或订单id获得订单 关联活动设置表
     */
    public function getTradeList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除记录
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." mt ";
        $sql .= " LEFT JOIN ".$this->activity_table." ma on ma.ma_id=mt.mt_a_id ";
        $sql .= " LEFT JOIN ".$this->reservation_table." mrc on mt.mt_a_id=mrc.mrc_a_id AND mt.mt_type = 5";
        $sql .= " LEFT JOIN ".$this->group_table." mgc on mt.mt_a_id=mgc.mgc_a_id AND mt.mt_type = 1";
        $sql .= " LEFT JOIN ".$this->limit_table." mlc on mt.mt_a_id= mlc.mlc_a_id AND mt.mt_type = 3";
        $sql .= " LEFT JOIN ".$this->bargain_table." mbc on mt.mt_a_id=mbc.mbc_a_id AND mt.mt_type = 2";
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
}