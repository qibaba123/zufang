<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Auction_MysqlAuctionRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_auction_reocrd';
        $this->_pk = 'aar_id';
        $this->_shopId = 'aar_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * @param $aid
     * @param $mid
     * 获取最高一次出价记录
     */
    public function getMaxPriceRecord($aid, $mid){
        $where = array();
        $where[] = array('name' => 'aar_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aar_aal_id', 'oper' => '=', 'value' => $aid);
        $where[] = array('name' => 'aar_m_id', 'oper' => '=', 'value' => $mid);
        $order = array('aar_price' => 'desc');
        $list = $this->getList($where, 0, 1, $order);
        return $list[0];
    }

    public function getMaxPrice($aid){
        $where = array();
        $where[] = array('name' => 'aar_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aar_aal_id', 'oper' => '=', 'value' => $aid);
        $order = array('aar_price' => 'desc');
        $list = $this->getList($where, 0, 1, $order);
        return $list[0];
    }

    /**
     * 获取列表
     */
    public function getMemberList($where, $index, $count, $sort){
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);

        $sql = "select aar.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` aar ";
        $sql .= " left join pre_member m on m.m_id = aar.aar_m_id ";

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