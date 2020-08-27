<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Auction_MysqlAuctionJoinStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_auction_join';
        $this->_pk = 'aaj_id';
        $this->_shopId = 'aaj_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    //获取累计参与人数
    public function getJoinPersonCount(){
        $sql  = ' select count(*) mycount from pre_applet_auction_join GROUP BY aaj_m_id ';
        $ret = DB::fetch_first($sql);
        return $ret['mycount'];
    }


    /**
     * 根据活动id和会员id获取一条参与记录
     */
    public function hadJoin($aid, $mid){
        $where[] = array('name' => 'aaj_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aaj_aal_id', 'oper' => '=', 'value' => $aid);
        $where[] = array('name' => 'aaj_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }

    /**
     * 根据订单号获取一天参与记录
     */
    public function getJoinByTid($tid){
        $where[] = array('name' => 'aaj_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aaj_tid', 'oper' => '=', 'value' => $tid);
        return $this->getRow($where);
    }

    public function updateJoinByTid($tid, $data){
        $where[] = array('name' => 'aaj_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aaj_tid', 'oper' => '=', 'value' => $tid);
        return $this->updateValue($data, $where);
    }

}